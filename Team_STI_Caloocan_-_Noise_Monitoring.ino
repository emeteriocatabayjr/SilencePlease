/*
 * Program ID: Team STI Caloocan - Noise Monitoring
 * 
 *             
 * Date Start: 
 *   Date End: 
 *   
 *    Version: 1.00 
 *    Modules: ESP32 DevKitC
 *             i2S Microphone
 *             Addessable RGB LED module
 *             Power supply/Battery charger module
 *             INA219 module
 *             
 *      About: Monitor the noise in a location and sends the noice level in dB, battery level in %
 *             to a remote database via Wi-Fi.
 *             
 *       Note: Samples audio data from I2S microphone, processes the data 
 *             with digital IIR filters and calculates A or C weighted Equivalent 
 *             Continuous Sound Level (Leq)
 * 
 *             I2S is setup to sample data at Fs=48000KHz (fixed value due to 
 *             design of digital IIR filters). Data is read from I2S queue 
 *             in 'sample blocks' (default 125ms block, equal to 6000 samples) 
 *             by 'i2s_reader_task', filtered trough two IIR filters (equalizer 
 *             and weighting), summed up and pushed into 'samples_queue' as 
 *             sum of squares of filtered samples. The main task then pulls data 
 *             from the queue and calculates decibel value relative to microphone 
 *             reference amplitude, derived from datasheet sensitivity dBFS 
 *             value, number of bits in I2S data, and the reference value for 
 *             which the sensitivity is specified (typically 94dB, pure sine
 *             wave at 1KHz).
*/


#include "math.h"
#include <Wire.h>
#include <Adafruit_INA219.h>
#include <Adafruit_NeoPixel.h>
#include <WiFi.h>
#include <WiFiClient.h>
#include <driver/i2s.h>
#include "sos-iir-filter.h"

// Pins definition.
#define I2S_WS        32 
#define I2S_SCK       33 
#define I2S_SD        34
#define batt          35
#define wifiLED       19
#define noiseLED      15

// Microphone configuration
#define LEQ_PERIOD        1           // second(s)
#define WEIGHTING         C_weighting // Also avaliable: 'C_weighting' or 'None' (Z_weighting)
#define LEQ_UNITS         "LAeq"      // customize based on above weighting used
#define DB_UNITS          "dBA"       // customize based on above weighting used

// Microphone DC-Blocker filter
#define MIC_EQUALIZER     ICS43434    // See below for defined IIR filters or set to 'None' to disable
#define MIC_OFFSET_DB     3.0103      // Default offset (sine-wave RMS vs. dBFS). Modify this value for linear calibration

// Customize these values from microphone datasheet. Do not tamper with.
#define MIC_SENSITIVITY   -26         // dBFS value expected at MIC_REF_DB (Sensitivity value from datasheet)
#define MIC_REF_DB        94.0        // Value at which point sensitivity is specified in datasheet (dB)
#define MIC_OVERLOAD_DB   116.0       // dB - Acoustic overload point
#define MIC_NOISE_DB      29          // dB - Noise floor
#define MIC_BITS          24          // valid number of bits in I2S data
#define MIC_CONVERT(s)    (s >> (SAMPLE_BITS - MIC_BITS))

// Calculate reference amplitude value at compile time
constexpr double MIC_REF_AMPL = pow(10, double(MIC_SENSITIVITY)/20) * ((1<<(MIC_BITS-1))-1);

// I2S peripheral to use (0 or 1)
#define I2S_PORT          I2S_NUM_0


//***********************************************************************************************************//
// IIR Filters                                                                                               //
//***********************************************************************************************************//

// DC-Blocker filter - removes DC component from I2S data
// See: https://www.dsprelated.com/freebooks/filters/DC_Blocker.html
// a1 = -0.9992 should heavily attenuate frequencies below 10Hz
SOS_IIR_Filter DC_BLOCKER = { 
  gain: 1.0,
  sos: {{-1.0, 0.0, +0.9992, 0}}
};

// 
// Equalizer IIR filters to flatten microphone frequency response
// See respective .m file for filter design. Fs = 48Khz.
//
// Filters are represented as Second-Order Sections cascade with assumption
// that b0 and a0 are equal to 1.0 and 'gain' is applied at the last step 
// B and A coefficients were transformed with GNU Octave: 
// [sos, gain] = tf2sos(B, A)
// See: https://www.dsprelated.com/freebooks/filters/Series_Second_Order_Sections.html
// NOTE: SOS matrix 'a1' and 'a2' coefficients are negatives of tf2sos output
//

// TDK/InvenSense ICS-43434
// Datasheet: https://www.invensense.com/wp-content/uploads/2016/02/DS-000069-ICS-43434-v1.1.pdf
// B = [0.477326418836803, -0.486486982406126, -0.336455844522277, 0.234624646917202, 0.111023257388606];
// A = [1.0, -1.93073383849136326, 0.86519456089576796, 0.06442838283825100, 0.00111249298800616];
SOS_IIR_Filter ICS43434 = { 
  gain: 0.477326418836803,
  sos: { // Second-Order Sections {b1, b2, -a1, -a2}
   {+0.96986791463971267, 0.23515976355743193, -0.06681948004769928, -0.00111521990688128},
   {-1.98905931743624453, 0.98908924206960169, +1.99755331853906037, -0.99755481510122113}
  }
};


// TDK/InvenSense INMP441
// Datasheet: https://www.invensense.com/wp-content/uploads/2015/02/INMP441.pdf
// B ~= [1.00198, -1.99085, 0.98892]
// A ~= [1.0, -1.99518, 0.99518]
SOS_IIR_Filter INMP441 = {
  gain: 1.00197834654696, 
  sos: { // Second-Order Sections {b1, b2, -a1, -a2}
    {-1.986920458344451, +0.986963226946616, +1.995178510504166, -0.995184322194091}
  }
};


//
// Weighting filters
//

//
// A-weighting IIR Filter, Fs = 48KHz 
// (By Dr. Matt L., Source: https://dsp.stackexchange.com/a/36122)
// B = [0.169994948147430, 0.280415310498794, -1.120574766348363, 0.131562559965936, 0.974153561246036, -0.282740857326553, -0.152810756202003]
// A = [1.0, -2.12979364760736134, 0.42996125885751674, 1.62132698199721426, -0.96669962900852902, 0.00121015844426781, 0.04400300696788968]
SOS_IIR_Filter A_weighting = {
  gain: 0.169994948147430, 
  sos: { // Second-Order Sections {b1, b2, -a1, -a2}
    {-2.00026996133106, +1.00027056142719, -1.060868438509278, -0.163987445885926},
    {+4.35912384203144, +3.09120265783884, +1.208419926363593, -0.273166998428332},
    {-0.70930303489759, -0.29071868393580, +1.982242159753048, -0.982298594928989}
  }
};

//
// C-weighting IIR Filter, Fs = 48KHz 
// Designed by invfreqz curve-fitting, see respective .m file
// B = [-0.49164716933714026, 0.14844753846498662, 0.74117815661529129, -0.03281878334039314, -0.29709276192593875, -0.06442545322197900, -0.00364152725482682]
// A = [1.0, -1.0325358998928318, -0.9524000181023488, 0.8936404694728326   0.2256286147169398  -0.1499917107550188, 0.0156718181681081]
SOS_IIR_Filter C_weighting = {
  gain: -0.491647169337140,
  sos: { 
    {+1.4604385758204708, +0.5275070373815286, +1.9946144559930252, -0.9946217070140883},
    {+0.2376222404939509, +0.0140411206016894, -1.3396585608422749, -0.4421457807694559},
    {-2.0000000000000000, +1.0000000000000000, +0.3775800047420818, -0.0356365756680430}
  }
};


//
// Sampling
//
#define SAMPLE_RATE       48000 // Hz, fixed to design of IIR filters
#define SAMPLE_BITS       32    // bits
#define SAMPLE_T          int32_t 
#define SAMPLES_SHORT     (SAMPLE_RATE / 8) // ~125ms
#define SAMPLES_LEQ       (SAMPLE_RATE * LEQ_PERIOD)
#define DMA_BANK_SIZE     (SAMPLES_SHORT / 16)
#define DMA_BANKS         32

// Data we push to 'samples_queue'
struct sum_queue_t {
  // Sum of squares of mic samples, after Equalizer filter
  float sum_sqr_SPL;
  // Sum of squares of weighted mic samples
  float sum_sqr_weighted;
  // Debug only, FreeRTOS ticks we spent processing the I2S data
  uint32_t proc_ticks;
};
QueueHandle_t samples_queue;

// Static buffer for block of samples
float samples[SAMPLES_SHORT] __attribute__((aligned(4)));

//
// I2S Microphone sampling setup 
//
void mic_i2s_init() {
  // Setup I2S to sample mono channel for SAMPLE_RATE * SAMPLE_BITS
  const i2s_config_t i2s_config = {
    mode: i2s_mode_t(I2S_MODE_MASTER | I2S_MODE_RX),
    sample_rate: SAMPLE_RATE,
    bits_per_sample: i2s_bits_per_sample_t(SAMPLE_BITS),
    channel_format: I2S_CHANNEL_FMT_ONLY_LEFT,
    communication_format: i2s_comm_format_t(I2S_COMM_FORMAT_I2S | I2S_COMM_FORMAT_I2S_MSB),
    intr_alloc_flags: ESP_INTR_FLAG_LEVEL1,
    dma_buf_count: DMA_BANKS,
    dma_buf_len: DMA_BANK_SIZE,
    use_apll: true,
    tx_desc_auto_clear: false,
    fixed_mclk: 0
  };

  // I2S pin mapping
  const i2s_pin_config_t pin_config = {
    bck_io_num:   I2S_SCK,  
    ws_io_num:    I2S_WS,    
    data_out_num: -1, // not used
    data_in_num:  I2S_SD   
  };

  i2s_driver_install(I2S_PORT, &i2s_config, 0, NULL);
  
  i2s_set_pin(I2S_PORT, &pin_config);
}

//
// I2S Reader Task
//
// Rationale for separate task reading I2S is that IIR filter
// processing cam be scheduled to different core on the ESP32
// while main task can do something else, like update the 
// display in the example
//
// As this is intended to run as separate hihg-priority task, 
// we only do the minimum required work with the I2S data
// until it is 'compressed' into sum of squares 
//
// FreeRTOS priority and stack size (in 32-bit words) 
#define I2S_TASK_PRI   4
#define I2S_TASK_STACK 2048


/*
 * Read the microphone.
 */
void mic_i2s_reader_task(void* parameter) {
  mic_i2s_init();

  // Discard first block, microphone may have startup time (i.e. INMP441 up to 83ms)
  size_t bytes_read = 0;
  i2s_read(I2S_PORT, &samples, SAMPLES_SHORT * sizeof(int32_t), &bytes_read, portMAX_DELAY);

  while (true) {

    /* Block and wait for microphone values from I2S
     *
     * Data is moved from DMA buffers to our 'samples' buffer by the driver ISR
     * and when there is requested ammount of data, task is unblocked
     *
     * Note: i2s_read does not care it is writing in float[] buffer, it will write
     *       integer values to the given address, as received from the hardware peripheral. 
     *       
     */

    i2s_read(I2S_PORT, &samples, SAMPLES_SHORT * sizeof(SAMPLE_T), &bytes_read, portMAX_DELAY);

    TickType_t start_tick = xTaskGetTickCount();
    
    /* Convert (including shifting) integer microphone values to floats, 
     * using the same buffer (assumed sample size is same as size of float), 
     * to save a bit of memory
     */
    SAMPLE_T* int_samples = (SAMPLE_T*)&samples;

    for(int i=0; i<SAMPLES_SHORT; i++) samples[i] = MIC_CONVERT(int_samples[i]);

    sum_queue_t q;

    /* 
     * Apply equalization and calculate Z-weighted sum of squares, 
     * writes filtered samples back to the same buffer.
     */ 
    q.sum_sqr_SPL = MIC_EQUALIZER.filter(samples, samples, SAMPLES_SHORT);

    // Apply weighting and calucate weigthed sum of squares
    q.sum_sqr_weighted = WEIGHTING.filter(samples, samples, SAMPLES_SHORT);

    // Debug only. Ticks we spent filtering and summing block of I2S data
    q.proc_ticks = xTaskGetTickCount() - start_tick;

    /* 
     * Send the sums to FreeRTOS queue where main task will pick them up
     * and further calcualte decibel values (division, logarithms, etc...)
     */
    xQueueSend(samples_queue, &q, portMAX_DELAY);
  }
}

// Class creation.
WiFiClient client;
Adafruit_INA219 batterySensor;
Adafruit_NeoPixel pixels = Adafruit_NeoPixel(1, noiseLED, NEO_GRB + NEO_KHZ800);

// Global variables.
//const char* ssid      = "PLDTHOMEFIBRXYzxW";        //enter the name of your wifi
//const char* password  = "PLDTWIFIp9QFF";    //wifi password
//const char* host      = "192.168.1.49";  // Local host IP Adress.
//const char* ssid      = "HG8145V5_3D80E";        //enter the name of your wifi
//const char* password  = "rSCvg92E";    //wifi password
//const char* ssid      = "thesis_modem";        //enter the name of your wifi
//const char* password  = "1234567890";    //wifi password
const char* ssid      = "PLDTHOMEDSL";        //enter the name of your wifi
const char* password  = "PLDTWIFIB8079";    //wifi password
const char* host      = "192.168.1.4";  // Local host IP Adress.
const uint16_t port = 80;//PORT OF THE LOCAL SERVER
const int noLight = 0;
const int greenLight = 1;
const int yellowLight = 2 ;
const int redLight = 3;

String unitID = "00001"; // This is the unique identifier of this device.

/*
 * Setup in this case is very different since it is where we also loob.  
 * This is FreeRTOS stuff. loop() function is not used.
 */
void setup() {

  // CPU Frequency. 
  setCpuFrequencyMhz(80); // It should run as low as 80MHz

  pinMode(wifiLED, OUTPUT);

  Serial.begin(9600);
  
  batterySensor.begin();
  pixels.begin();
  
  Serial.begin(112500);
  delay(1000); // Safety

  // Setup ADC.
  adc1_config_width(ADC_WIDTH_12Bit);
  adc1_config_channel_atten(ADC1_CHANNEL_7, ADC_ATTEN_0db); //set reference voltage to internal

  // Connect to Wi-Fi 
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.status()!=WL_CONNECTED){Serial.print(".");
    delay(500);
  }
  Serial.println("CONNECTED TO WIFI");
  Serial.print("IP:"); Serial.println(WiFi.localIP());  

  // Create FreeRTOS queue
  samples_queue = xQueueCreate(8, sizeof(sum_queue_t));
  
  // Create the I2S reader FreeRTOS task
  xTaskCreate(mic_i2s_reader_task, "Mic I2S Reader", I2S_TASK_STACK, NULL, I2S_TASK_PRI, NULL);

  sum_queue_t q;

  String url = "";
  uint32_t Leq_samples = 0;
  double Leq_sum_sqr = 0;
  double Leq_dB = 0;
  double oldTimer = 0;
  double nowTimer = 0;
  double oldReconnectTimer = 0;
  double nowReconnectTimer = 0;
  int secsCtr = 0;
  int LEDlight = 0;
  bool redLightState = HIGH;
  bool blinkRed = false;
  bool APconnected = true;
  float batteryVolt = 0.0;
  int batteryPercentage = 0;
  

  // Read sum of samaples, calculated by 'i2s_reader_task'
  while (xQueueReceive(samples_queue, &q, portMAX_DELAY)) {

    // Calculate dB values relative to MIC_REF_AMPL and adjust for microphone reference
    double short_RMS = sqrt(double(q.sum_sqr_SPL) / SAMPLES_SHORT);
    double short_SPL_dB = MIC_OFFSET_DB + MIC_REF_DB + 20 * log10(short_RMS / MIC_REF_AMPL);

    // In case of acoustic overload or below noise floor measurement, report infinty Leq value
    if (short_SPL_dB > MIC_OVERLOAD_DB) {
      Leq_sum_sqr = INFINITY;
    } else if (isnan(short_SPL_dB) || (short_SPL_dB < MIC_NOISE_DB)) {
      Leq_sum_sqr = -INFINITY;
    }

    // Accumulate Leq sum
    Leq_sum_sqr += q.sum_sqr_weighted;
    Leq_samples += SAMPLES_SHORT;

    // When we gather enough samples, calculate new Leq value
    if (Leq_samples >= SAMPLE_RATE * LEQ_PERIOD) {
      double Leq_RMS = sqrt(Leq_sum_sqr / Leq_samples);
      Leq_dB = MIC_OFFSET_DB + MIC_REF_DB + 20 * log10(Leq_RMS / MIC_REF_AMPL);
      Leq_sum_sqr = 0;
      Leq_samples = 0;
 
      // Process battery level.
      batteryVolt = roundf(batterySensor.getBusVoltage_V() * 100);
      batteryVolt = batteryVolt / 100;
      batteryPercentage = mapfloat(batteryVolt, 3.7, 4.2, 0, 100);

      // Serial output, customize (or remove) as needed
      // Serial.printf("%.1f\n", Leq_dB);

      LEDlight = int(Leq_dB); 

      switch (LEDlight){
        case 1 ... 59:
          setColorTo(greenLight);
          secsCtr = 0;
          break;

        case 60 ... 74:
          setColorTo(yellowLight);
          secsCtr = 0;
          break;

        case 75 ... 200:

          nowTimer = millis();
          if (nowTimer - oldTimer >= 250){
            oldTimer = nowTimer;
            secsCtr++;
            if (secsCtr > 5){
              if (redLightState){
                setColorTo(redLight);
              }
              else{
                setColorTo(noLight);
              }            
              redLightState = !redLightState;
            }
          }

          if (secsCtr < 5){
            setColorTo(redLight);
          } 
          break;

        default:
          setColorTo(noLight);
          secsCtr = 0;
          break;
      }

    }

    if (WiFi.status()!= WL_CONNECTED){
      APconnected = false;
      digitalWrite(wifiLED, LOW);
    }
    else{
      APconnected = true;
      digitalWrite(wifiLED, HIGH);
    }   

    // Try to reconnect to the AP if we get disconnected.
    if (!APconnected){
      nowReconnectTimer = millis();
      if (nowReconnectTimer - oldReconnectTimer >= 3000){
        Serial.println("Trying to connect...");
        oldReconnectTimer = nowReconnectTimer;
        WiFi.disconnect();
        WiFi.begin(ssid, password);
      }
    }
    else{   // We're conencted, so try connecting to the host and update the database.
      if(client.connect(host, port, 50)){
    
        // Create a URL for the request. Modify YOUR_HOST_DIRECTORY so that you're pointing to the PHP file. "http://" +
        url = "/updatedata.php?unitID=";
        url += unitID;
        url += "&soundLVL=";
        url += String(LEDlight);
        url += "&battLVL=";
        url += String(batteryPercentage);

        client.print(String("GET ")+ url + " HTTP/1.1\r\n"+"Host:"+host+"\r\n"+"Connection:close\r\n\r\n");

      }   
    }
  }
}


/*
 * This is not used.
 */
void loop() {
  // Nothing here to write home about.
}


/*
 * Float data type mapper. 
 */
float mapfloat(float x, float in_min, float in_max, float out_min, float out_max){
  return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}


/*
 * LED color painter.
 * 
 * GREEN - 1
 * YELLOW - 2
 * RED - 3
 * NONE - 0
 */
void setColorTo(int color){

  switch (color){
    case 0:   // LED is off.
      pixels.setPixelColor(0, pixels.Color(0, 0, 0));
      break;

    case 1:   // LED is Green.
      pixels.setPixelColor(0, pixels.Color(0, 255, 0));
      break;
    
    case 2:   // LED is Yellow.
      pixels.setPixelColor(0, pixels.Color(255, 175, 0));
      break;
    
    case 3:   // LED is Red.
      pixels.setPixelColor(0, pixels.Color(255, 0, 0));
      break;      
  }
  pixels.show(); // Update the LED.  
}
