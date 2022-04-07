<?php include 'includes/connection.php';?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sessionstart.php';?>
<?php
if(!empty($_SESSION)) {
    ?>
<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>STI Library</h3>
        </div>
        
        <ul class="list-unstyled components">
            

            <li class="active">
                <a href="home.php">
                    <i class="fas fa-home"></i>  Home
                </a>
            </li>
            <li>
                <a href="monitor.php">
                    <i class="fas fa-tv"></i>  Monitor
                </a>
            </li>
            <li>
                <a href="accounts.php">
                    <i class="fas fa-user-circle"></i> Account
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-align-left"></i>
                    <span>Menu</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

            </div>
        </nav>
        <div class="container">
            <div class="card bg-success text-white">
                <div class="card-header">
                    <div class="display-4 text-center">Welcome</div>
                </div>
            </div>
            <div class="p-5">
                <p>This website will act as a control panel for the equipment that students from the STI College Caloocan's computer engineering department will be using.</p>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });

 <?php
 }else echo '<div class="alert alert-danger alert-dismissible fade show">
 <strong>Login Required!</strong> Y1ou needed to be login first before you can access the page.
 <a href="index.php"> Go back to login</a>
 </div>';
 ?>
</script>
</body>

</html>