<html>
    
    <?php
    //~ if (isset($this->session->userdata['logged_in'])) {
//~ 
        //~ header("location: http://localhost/lubricar-web/index.php/User_Authentication/user_login_process");
    //~ }
    ?>
    <head>
        <title>Encuesta Socio-laboral</title>
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/select2-bootstrap.css"/>
        <script src="<?=base_url()?>static/js/jquery-1.11.2.min.js"></script>
        <script src="<?=base_url()?>static/js/bootstrap.min.js"></script>

        <script src="<?=base_url()?>static/js/bootstrap-datepicker.js"></script>
        <script src="<?=base_url()?>static/js/bootstrap-datepicker.es.min.js"></script>
        <script src="<?= base_url() ?>static/js/bootbox.js"></script>

		<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/animate.css"/>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/apprise.css"/>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/css/estilo.css"/>
			
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/css/style2.css'); ?>">
		
		<script>
			$(document).ready(function () {
					
				// Activar modal al hacer click en el enlace de recuoperación
				$("#rec_password").click(function (e) {
					e.preventDefault();  // Para evitar que se envíe por defecto
					$("#modal_clave").modal('show');
				});
				
				// Validar formulario
				$("#generar").click(function (e) {
					e.preventDefault();  // Para evitar que se envíe por defecto
					
					if($("#username_rec").val() == ''){
						//~ bootbox.alert("Introduzca el Usuario", function () {
						//~ }).on('hidden.bs.modal', function (event) {
							//~ $("#username_rec").parent('div').addClass('has-error')
							//~ $("#username_rec").val('');
							//~ $("#username_rec").focus();
						//~ });
						alert("Error: Introduzca el Usuario");
						$("#username_rec").parent('div').addClass('has-error')
						$("#username_rec").val('');
						$("#username_rec").focus();
					} else if($("#password_rec").val() == ''){
						//~ bootbox.alert("Introduzca la Clave Maestra", function () {
						//~ }).on('hidden.bs.modal', function (event) {
							//~ $("#password_rec").parent('div').addClass('has-error')
							//~ $("#password_rec").val('');
							//~ $("#password_rec").focus();
						//~ });
						alert("Error: Introduzca la Clave Maestra");
						$("#password_rec").parent('div').addClass('has-error')
						$("#password_rec").val('');
						$("#password_rec").focus();
					} else {
						//~ alert($("#username_rec").val());
						$.post('<?php echo base_url(); ?>index.php/User_Authentication/recuperar/', $("#f_rec_usuario").serialize(), function(response) {
							//~ alert(response[3]);
							if (response[3] != "U"){
								alert("La Clave de Acceso para el Usuario "+$("#username_rec").val()+" ha sido recuperada exitosamente: "+response);
								location.reload();
								//~ bootbox.alert("La Clave de Acceso para el usuario "+$("#username_rec").val()+" ha sido cambiada exitosamente: "+response, function () {
								//~ }).on('hidden.bs.modal', function (event) {
									//~ location.reload();
								//~ });
							}else{
								alert(response);
								//~ bootbox.alert(response, function () {
								//~ }).on('hidden.bs.modal', function (event) {
									//~ 
								//~ });
							}
						});
					}
				});
				
				// Activar modal al hacer click en el botón de registro
				$("#registrar_referido").click(function (e) {
					e.preventDefault();  // Para evitar que se envíe por defecto
					$("#modal_registrar").modal('show');
				});				
				
				// Validar formulario de registro de usuario referido
				$("#registrar").click(function (e) {
					e.preventDefault();  // Para evitar que se envíe por defecto
					
					if($("#username_reg").val() == ''){
						alert("Error: Ingrese su nombre de usuario");
						$("#username_reg").parent('div').addClass('has-error')
						$("#username_reg").val('');
						$("#username_reg").focus();
					} else if($("#password_reg").val() == ''){
						alert("Error: Ingrese su contraseña");
						$("#password_reg").parent('div').addClass('has-error')
						$("#password_reg").val('');
						$("#password_reg").focus();
					} else {
						//~ alert('Código: '+$("#codigo").val());
						// Registramos el nuevo usuario
						$.post('<?php echo base_url(); ?>index.php/User_Authentication/registrar_usuario/', $("#f_reg_usuario").serialize(), function(response) {
							//~ alert(response.trim());
							if (response.trim() == "1"){
								alert("El usuario ya existe");
								location.reload();
							}else{
								
								alert('Usuario registrado exitosamente');
								url = '<?php echo base_url(); ?>index.php/'
								window.location = url
							}
						});
					}
				});
				
			});
		</script>
    </head>
    <body>

<!--
		<div align="center">
			<img src="<?= base_url()?>static/img/tope.jpg" style="width: 100%;"/>
		</div>
-->
        

        <?php
        if (isset($logout_message)) {
            echo "</br><div class='alert alert-dismissible alert-success' style='text-align: center'>";
            echo "<button type='button' class='close' data-dismiss='alert'>X</button>";
            echo $logout_message;
            echo "</div>";
        }
        ?>
        <?php
        if (isset($message_display)) {
            echo "<div class='alert alert-dismissible alert-success' style='text-align: center'>";
            echo "<button type='button' class='close' data-dismiss='alert'>X</button>";
            echo $message_display;
            echo "</div>";
        }
        ?>
        <?php
        
        if (isset($error_message)) {
            echo "<div class='alert alert-dismissible alert-danger' style='text-align: center'>";
            echo "<button type='button' class='close' data-dismiss='alert'>X</button>";
            echo $error_message;
            echo "</div>";
        }        
        ?>
    
		<?php
		$errores = validation_errors();
        if ($errores != "") {
			if(strpos($errores, 'The Username field is required') == true && strpos($errores, 'The Password field is required') == true){
				echo "<div class='alert alert-dismissible alert-danger' style='text-align: center'>";
				echo "<button type='button' class='close' data-dismiss='alert'>X</button>";
				echo "<p>Ingrese su usuario y clave de acceso</p>";
				echo "</div>";
			}else if(strpos($errores, 'The Username field is required') == true){
				echo "<div class='alert alert-dismissible alert-danger' style='text-align: center'>";
				echo "<button type='button' class='close' data-dismiss='alert'>X</button>";
				echo "<p>Ingrese su nombre de usuario</p>";
				echo "</div>";
			}else if(strpos($errores, 'The Password field is required') == true){
				echo "<div class='alert alert-dismissible alert-danger' style='text-align: center'>";
				echo "<button type='button' class='close' data-dismiss='alert'>X</button>";
				echo "<p>Ingrese su clave de acceso</p>";
				echo "</div>";
			}
            
        }
        ?>

	<div class="wrapper">
		<div class="container">
			
			<h1 style="color:#fff">Encuesta Socio-laboral</h1>
			
			<?php echo form_open('User_Authentication/user_login_process'); ?>
			<form id="frmlogin" class="form-horizontal"  method="POST" enctype="multipart/form-data" autocomplete="off" role="form">
				<!--<div class="col-lg-12">
					<div class="col-lg-3"></div>
					 <div class="col-lg-6"><img class="img" src="<?= base_url() ?>static/img/default.png" style="width: 100%"/></div> 
					<div class="col-lg-3"></div>
				</div>-->
				<div class="col-lg-12">
				<br>
				<input type="text" id="username" name="username" placeholder="Usuario" >
				<input type="password" id="password" name="password" placeholder="Clave de Acceso">
				<button id="entrar" type="submit" name="enviar">Entrar</button>
				</br></br>
				<button  type="button" id="registrar_referido" name="registrar_referido">Registrar</button>
				</br></br>
				<button type="button" id="rec_password" name="recpassword">Rec: Clave de Acceso</button>
				</div> 
			</form>
			<?php echo form_close(); ?>
		</div>
	
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
		
	</div>
        
        <div class="modal" id="modal_registrar">
		   <div class="modal-dialog">
			  <div class="modal-content">
				 <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">
					   <center><span class="glyphicon glyphicon-search"></span>
					   &nbsp;Introdúzca su usuario y su contraseña para crear la cuenta</center>
					</h4>
				 </div>
				 <div class="modal-body">
					<form id="f_reg_usuario" name="f_reg_usuario" action="" method="post">
					   <div class="form-group">
							<div class="col-sm-12">
								<input type="text" class="form-control" style="width: 100%; " id="username_reg" name="username_reg" placeholder="Usuario" autofocus="true">
							</div>
							</br></br></br>
							<div class="col-sm-12">
								<input style="width: 100%;" type="password" class="form-control" id="password_reg" name="password_reg" placeholder="Contraseña"/>
							</div>
							</br></br></br>
							</br>
							<div class="col-sm-12" align="right">
								<span class="input-btn">
									<button class="btn btn-primary" type="button" id="registrar">
										Registrar&nbsp;<span class="glyphicon glyphicon-share-alt"></span>
									</button>
								</span>
							</div>
							</br></br>
					   </div>
					</form>
				 </div>
				 
			  </div>
		   </div>
		</div>
        
		<div class="modal" id="modal_clave">
		   <div class="modal-dialog">
			  <div class="modal-content">
				 <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">
					   <center><span class="glyphicon glyphicon-search"></span>
					   &nbsp;Introdúzca el Usuario y la Clave Maestra para Generar una Nueva Clave de Acceso</center>
					</h4>
				 </div>
				 <div class="modal-body">
					<form id="f_rec_usuario" name="f_rec_usuario" action="" method="post">
					   <div class="form-group">
							<div class="col-sm-12">
								<input type="text" class="form-control" style="width: 100%; " id="username_rec" name="username_rec" placeholder="Usuario" autofocus="true">
							</div>
							</br></br></br>
							<div class="col-sm-12">
								<input style="width: 100%;" type="password" class="form-control" id="password_rec" name="password_rec" placeholder="Clave Maestra"/>
							</div>
							</br></br>
							<div class="col-sm-12" align="right">
								<span class="input-btn">
									<button class="btn btn-primary" type="button" id="generar">
										Generar&nbsp;<span class="glyphicon glyphicon-share-alt"></span>
									</button>
								</span>
							</div>
							</br></br>
					   </div>
					</form>
				 </div>
				 
			  </div>
		   </div>
		</div>
        
    </body>
    
</html>

