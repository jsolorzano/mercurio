<!DOCTYPE html>
<html>
	<?php
    //~ if (isset($this->session->userdata['logged_in'])) {
        //~ redirect('home');
        //~ header("location: ".base_url()."home");
    //~ }
    ?>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lubricar Delivery</title>

    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url()?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <!--<div>

                <h1 class="logo-name">IN+</h1>

            </div>-->
            <!--<h3>Welcome to IN+</h3>
            <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                Continually expanded and constantly improved Inspinia Admin Them (IN+)
            </p>-->
            <h2>Iniciar sesión</h2>
            <form class="m-t" role="form" action="login" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Usuario" required="" name="username" id="username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Contraseña" required="" name="password" id="password">
                </div>
                <button id="entrar" type="submit" class="btn btn-primary block full-width m-b">Iniciar sesión</button>

                <!--<a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>-->
            </form>
            <?php echo validation_errors('<div class="error">','</div>');?>
            <?php if(isset($error)) echo "<div class='error'>$error</div>";?>
            <!--<p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>-->
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url()?>assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>

</body>

</html>
