<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <title>Toast</title>
</head>
<style type="text/css">
    
    .toast-container{
        position:fixed;z-index:1055;margin:5px
    }
    .top-right{
        top:0;right:0
    }
    .top-left{
        top:0;left:0
    }
    .bottom-right{
        right:0;bottom:0
    }
    .bottom-left{
        left:0;bottom:0
    }
    .toast-container>.toast{
        min-width:150px;background:0 0;border:none
    }
    .toast-container>.toast>.toast-header{
        border:none
    }
    .toast-container>.toast>.toast-header strong{
        padding-right:20px}

    .toast-container>.toast>.toast-body{
        background:#fff
    }

</style>
<body>
<div class="jumbotron bg-primary text-white jumbotron-fluid">
    <div class="container">
        <h1 class="text-center display-4">Toast</h1>
        <h3 class="text-center">A jQuery plugin for Bootstrap 4.2+</h3>
    </div>
</div>

<div class="container-fluid text-center">
    <button class="snack btn btn-primary">Snack</button>
    <button class="toast-btn btn btn-primary">Toast</button>
</div>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ac malesuada ipsum. Vestibulum in nunc sed erat
    facilisis lacinia in vitae lacus. Curabitur ornare nulla non urna posuere cursus. Aliquam in molestie augue, ac
    vehicula est. Pellentesque eget massa nibh. Nulla maximus quam laoreet finibus dictum. Aliquam pretium porta
    malesuada. Cras pretium odio massa, non blandit ligula maximus at. Proin sollicitudin felis sollicitudin turpis
    mattis ultricies.</p>

<p>Donec rutrum, magna ut lacinia aliquam, dui justo consequat eros, non feugiat lectus ligula non lacus. Donec
    consequat pharetra posuere. Pellentesque malesuada sodales erat bibendum condimentum. Ut porttitor dignissim semper.
    Quisque sed urna venenatis, sollicitudin tellus vitae, ultricies justo. Suspendisse potenti. Donec in sapien
    molestie, pharetra nisl sit amet, pulvinar erat. Donec ultricies mauris enim, non vehicula sapien malesuada eget.
    Aliquam tristique accumsan magna, eget facilisis nulla convallis sed. Fusce malesuada ipsum sem, eget finibus arcu
    euismod id. Mauris fringilla libero felis, vitae iaculis ante vehicula vitae. Pellentesque ullamcorper semper
    vestibulum. In rutrum at sapien et tincidunt.</p>

<p>Aliquam mauris arcu, euismod vel porta in, consequat in augue. Integer volutpat tincidunt arcu, et iaculis est
    egestas in. Nam nibh neque, consequat quis dolor et, mollis viverra erat. Duis dapibus lacus et pharetra rutrum.
    Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut tempor nibh sit amet eros
    commodo tristique. Maecenas maximus nisi sit amet tempus venenatis.</p>

<p>Mauris hendrerit neque eget sapien efficitur, ac hendrerit lorem ultrices. Praesent nec lorem ac tellus viverra
    sollicitudin posuere in mauris. Cras vulputate arcu at ligula condimentum semper. Fusce erat justo, luctus non
    interdum vitae, rhoncus sed lorem. Pellentesque et nisi vel felis finibus efficitur eu tristique ex. Aenean ac
    lacinia lectus. Vestibulum augue ante, maximus at nisi vel, eleifend convallis nunc. Vivamus tempor arcu neque, non
    auctor enim vehicula et. Integer viverra faucibus consectetur. Maecenas id vestibulum velit, a mollis nulla. Cras
    vitae velit orci. Nunc volutpat urna quam, non aliquet nisl placerat ac.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<p>Nunc porta eu mi eget dignissim. Pellentesque hendrerit odio nec risus facilisis pulvinar. Nam laoreet a libero id
    commodo. Vivamus elementum enim nec tincidunt suscipit. Vestibulum a neque molestie, imperdiet turpis sed,
    ullamcorper ex. Integer et pharetra nulla. Maecenas egestas ut augue non sodales. Nunc aliquet a mauris id
    consectetur. Integer tristique ligula eu pellentesque vulputate. Nunc pellentesque eros a ipsum mattis, finibus
    maximus libero commodo. Cras in posuere lorem, non porttitor diam. Phasellus lacus augue, tempus at turpis ac,
    malesuada eleifend orci. Etiam commodo elementum vehicula. Sed et enim at urna pretium porttitor vel at lectus.
    Nulla consectetur nisl vitae nisl iaculis vulputate. Donec ac nisi cursus, pharetra augue id, eleifend augue.</p>

<div class="container-fluid text-center">
    <button class="snack btn btn-primary">Snack</button>
    <button class="toast-btn btn btn-primary">Toast</button>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
(function ($) {
    const TOAST_CONTAINER_HTML = `<div id="toast-container" class="toast-container" aria-live="polite" aria-atomic="true"></div>`;

    $.toastDefaults = {
        position: 'top-right',
        dismissible: true,
        stackable: true,
        pauseDelayOnHover: true,
        style: {
            toast: '',
            info: '',
            success: '',
            warning: '',
            error: '',
        }
    };

    $('body').on('hidden.bs.toast', '.toast', function () {
        $(this).remove();
    });

    let toastRunningCount = 1;

    function render(opts) {
        /** No container, create our own **/
        if (!$('#toast-container').length) {
            const position = ['top-right', 'top-left', 'top-center', 'bottom-right', 'bottom-left', 'bottom-center'].includes($.toastDefaults.position) ? $.toastDefaults.position : 'top-right';

            $('body').prepend(TOAST_CONTAINER_HTML);
            $('#toast-container').addClass(position);
        }

        let toastContainer = $('#toast-container');
        let html = '';
        let classes = {
            header: {
                fg: '',
                bg: ''
            },
            subtitle: 'text-white',
            dismiss: 'text-white'
        };
        let id = opts.id || `toast-${toastRunningCount}`;
        let type = opts.type;
        let title = opts.title;
        let subtitle = opts.subtitle;
        let content = opts.content;
        let img = opts.img;
        let delayOrAutohide = opts.delay ? `data-delay="${opts.delay}"` : `data-autohide="false"`;
        let hideAfter = ``;
        let dismissible = $.toastDefaults.dismissible;
        let globalToastStyles = $.toastDefaults.style.toast;
        let paused = false;

        if (typeof opts.dismissible !== 'undefined') {
            dismissible = opts.dismissible;
        }

        switch (type) {
            case 'info':
                classes.header.bg = $.toastDefaults.style.info || 'bg-info';
                classes.header.fg = $.toastDefaults.style.info || 'text-white';
                break;

            case 'success':
                classes.header.bg = $.toastDefaults.style.success || 'bg-success';
                classes.header.fg = $.toastDefaults.style.info || 'text-white';
                break;

            case 'warning':
                classes.header.bg = $.toastDefaults.style.warning || 'bg-warning';
                classes.header.fg = $.toastDefaults.style.warning || 'text-white';
                break;

            case 'error':
                classes.header.bg = $.toastDefaults.style.error || 'bg-danger';
                classes.header.fg = $.toastDefaults.style.error || 'text-white';
                break;
        }

        if ($.toastDefaults.pauseDelayOnHover && opts.delay) {
            delayOrAutohide = `data-autohide="false"`;
            hideAfter = `data-hide-after="${Math.floor(Date.now() / 1000) + (opts.delay / 1000)}"`;
        }

        html = `<div id="${id}" class="toast ${globalToastStyles}" role="alert" aria-live="assertive" aria-atomic="true" ${delayOrAutohide} ${hideAfter}>`;
        html += `<div class="toast-header ${classes.header.bg} ${classes.header.fg}">`;

        if (img) {
            html += `<img src="${img.src}" class="mr-2 ${img.class || ''}" alt="${img.alt || 'Image'}">`;
        }

        html += `<strong class="mr-auto">${title}</strong>`;

        if (subtitle) {
            html += `<small class="${classes.subtitle}">${subtitle}</small>`;
        }

        if (dismissible) {
            html += `<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true" class="${classes.dismiss}">&times;</span>
                    </button>`;
        }

        html += `</div>`;

        if (content) {
            html += `<div class="toast-body">
                        ${content}
                    </div>`;
        }

        html += `</div>`;

        if (!$.toastDefaults.stackable) {
            toastContainer.find('.toast').each(function () {
                $(this).remove();
            });

            toastContainer.append(html);
            toastContainer.find('.toast:last').toast('show');
        } else {
            toastContainer.append(html);
            toastContainer.find('.toast:last').toast('show');
        }

        if ($.toastDefaults.pauseDelayOnHover) {
            setTimeout(function () {
                if (!paused) {
                    $(`#${id}`).toast('hide');
                }
            }, opts.delay);

            $('body').on('mouseover', `#${id}`, function () {
                paused = true;
            });

            $(document).on('mouseleave', '#' + id, function () {
                const current = Math.floor(Date.now() / 1000),
                    future = parseInt($(this).data('hideAfter'));

                paused = false;

                if (current >= future) {
                    $(this).toast('hide');
                }
            });
        }

        toastRunningCount++;
    }

    /**
     * Show a snack
     * @param type
     * @param title
     * @param delay
     */
    $.snack = function (type, title, delay) {
        return render({
            type,
            title,
            delay
        });
    }

    /**
     * Show a toast
     * @param opts
     */
    $.toast = function (opts) {
        return render(opts);
    }
}(jQuery));
</script>
<script>
    const TYPES = ['info', 'warning', 'success', 'error'],
        TITLES = {
            'info': 'Notice!',
            'success': 'Awesome!',
            'warning': 'Watch Out!',
            'error': 'Doh!'
        },
        CONTENT = {
            'info': 'Hello, world! This is a toast message.',
            'success': 'The action has been completed.',
            'warning': 'It\'s all about to go wrong',
            'error': 'It all went wrong.'
        },
        POSITION = ['top-right', 'top-left', 'bottom-right', 'bottom-left'];

    $.toastDefaults.position = 'bottom-right';
    $.toastDefaults.dismissible = true;
    $.toastDefaults.stackable = true;
    $.toastDefaults.pauseDelayOnHover = true;

    $('.snack').click(function () {
        var type = TYPES[Math.floor(Math.random() * TYPES.length)],
            content = CONTENT[type];

        $.snack(type, content);
    });

    $('.toast-btn').click(function () {
        var rng = Math.floor(Math.random() * 2) + 1,
            type = TYPES[Math.floor(Math.random() * TYPES.length)],
            title = TITLES[type],
            content = CONTENT[type];

        if (rng === 1) {
            $.toast({
                type: type,
                title: title,
                subtitle: '11 mins ago',
                content: content,
                delay: 5000
            });
        } else {
            $.toast({
                type: type,
                title: title,
                subtitle: '11 mins ago',
                content: content,
                delay: 5000,
                img: {
                    src: 'https://via.placeholder.com/20',
                    alt: 'Image'
                }
            });
        }
    });
</script>
</body>

</html>
