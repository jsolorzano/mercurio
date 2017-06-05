<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//~ $datos_sesion = array();
?><!DOCTYPE html>
<html lang="en">
<head>
		 <!-- Metadata -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lubricar Delivery</title>
	<!-- CSS Files -->
    <link href="<?php echo assets_url('css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo assets_url('font-awesome/css/font-awesome.css');?>" rel="stylesheet">
	<link href="<?php echo assets_url('css/plugins/iCheck/custom.css');?>" rel="stylesheet">
    <link href="<?php echo assets_url('css/plugins/steps/jquery.steps.css');?>" rel="stylesheet">
	<link href="<?php echo assets_url('css/plugins/dataTables/datatables.min.css');?>" rel="stylesheet">
	<link href="<?php echo assets_url('css/plugins/select2/select2.min.css');?>" rel="stylesheet">
	<link href="<?php echo assets_url('js/datatables.net-bs/css/dataTables.bootstrap.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo assets_url('css/dataTables.responsive.css'); ?>">
    <link href="<?php echo assets_url('js/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'); ?>"
	<link href="<?php echo assets_url('css/animate.css');?>" rel="stylesheet">
    <link href="<?php echo assets_url('css/style.css');?>" rel="stylesheet">
	<link href="<?php echo assets_url('css/plugins/datapicker/datepicker3.css');?>" rel="stylesheet">
	 <!-- Sweet Alert -->
    <link href="<?php echo assets_url('css/plugins/sweetalert/sweetalert.css');?>" rel="stylesheet">
	
	<!-- Custom and plugin javascript -->
	<script src="<?php echo assets_url('js/jquery-3.1.1.min.js');?>"></script>
	<script src="<?php echo assets_url('js/bootstrap.min.js');?>"></script>
	<script src="<?php echo assets_url('js/plugins/metisMenu/jquery.metisMenu.js');?>"></script>
	<script src="<?php echo assets_url('js/plugins/slimscroll/jquery.slimscroll.min.js');?>"></script>
	<script src="<?php echo assets_url('js/plugins/dataTables/datatables.min.js');?>"></script>
	<script src="<?php echo assets_url('js/plugins/select2/select2.full.min.js');?>"></script>
	<script src="<?php echo assets_url('js/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo assets_url('js/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
	<script src="<?php echo assets_url('js/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
	<script src="<?php echo assets_url('js/inspinia.js');?>"></script>
	<script src="<?php echo assets_url('js/plugins/pace/pace.min.js');?>"></script>
	<script src="<?php echo assets_url('js/plugins/slimscroll/jquery.slimscroll.min.js');?>"></script>
	 <!-- Sweet alert -->
    <script src="<?php echo assets_url('js/plugins/sweetalert/sweetalert.min.js');?>"></script>
	   <!-- Custom and plugin javascript -->
    <script src="<?php echo assets_url('js/inspinia.js');?>"></script>
    <script src="<?php echo assets_url('js/plugins/pace/pace.min.js');?>"></script>
    <!-- Steps -->
    <script src="<?php echo assets_url('js/plugins/steps/jquery.steps.min.js');?>"></script>
	    <!-- Jquery Validate -->
    <script src="<?php echo assets_url('js/plugins/validate/jquery.validate.min.js');?>"></script>
	<script src="<?php echo assets_url('js/jquery.numeric.js');?>"></script>
		<!-- Data picker -->
   <script src="<?php echo assets_url('js/plugins/datapicker/bootstrap-datepicker.js');?>"></script>
   <!-- Date range picker -->
    <script src="<?php echo assets_url('js/plugins/daterangepicker/daterangepicker.js');?>"></script>
		<!-- Typehead -->
    <script src="<?php echo assets_url('js/plugins/typehead/bootstrap3-typeahead.min.js');?>"></script>
    <script>
		$(document).ready(function () {
			// Aplicamos select2() a todos los combos select
			$("select").select2();
		});
	</script>
</head>
<body class="md-skin fixed-nav no-skin-config">
	<div id="wrapper">
		<nav class="navbar-default navbar-static-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav metismenu" id="side-menu">
					<li class="nav-header">
						<div class="dropdown profile-element">
							<!--<span>
								<img alt="image" class="img-circle" src="<?php echo assets_url('img/profile_small.jpg'); ?>" />
							</span>-->
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<span class="clear">
									<span class="block m-t-xs">
										<strong class="font-bold"><?php echo $this->session->userdata('logged_in')['username'];?></strong>
									</span>
									<span class="text-muted text-xs block"><?php echo $this->session->userdata('logged_in')['profile_name'];?>
										<b class="caret"></b>
									</span>
								</span>
							</a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
								<li><a href="<?php echo base_url();?>home">Inicio</a></li>
								<!--<li><a href="">Perfil</a></li>-->
								<!--<li><a href="contacts.html">Contactos</a></li>-->
								<li class="divider"></li>
								<li><a href="<?php echo base_url();?>logout">Cerrar Sesión</a></li>
							</ul>
						</div>
						<div class="logo-element">
							IN+
						</div>
					</li>
					
					<!-- Carga de menú lateral -->
					<?php echo menu(); ?>
					<!-- Carga de menú lateral -->

				</ul>

			</div>
		</nav>

		<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom">
				<nav class="navbar navbar-fixed-top" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
						<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
						<!--<form role="search" class="navbar-form-custom" action="search_results.html">
							<div class="form-group">
								<input type="text" placeholder="Buscar..." class="form-control" name="top-search" id="top-search">
							</div>
						</form>-->
					</div>
					<ul class="nav navbar-top-links navbar-right">
						<li>
							<span class="m-r-sm text-muted welcome-message">Bienvenido a Lubricar Delivery.</span>
						</li>
						<!--<li class="dropdown">
							<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
								<i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
							</a>
							<ul class="dropdown-menu dropdown-messages">
								<li>
									<div class="dropdown-messages-box">
										<a href="profile.html" class="pull-left">
											<img alt="image" class="img-circle" src="<?php echo assets_url('img/a7.jpg'); ?>">
										</a>
										<div class="media-body">
											<small class="pull-right">46h ago</small>
											<strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
											<small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
										</div>
									</div>
								</li>
								<li class="divider"></li>
								<li>
									<div class="dropdown-messages-box">
										<a href="profile.html" class="pull-left">
											<img alt="image" class="img-circle" src="<?php echo assets_url('img/a4.jpg'); ?>">
										</a>
										<div class="media-body ">
											<small class="pull-right text-navy">5h ago</small>
											<strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
											<small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
										</div>
									</div>
								</li>
								<li class="divider"></li>
								<li>
									<div class="dropdown-messages-box">
										<a href="profile.html" class="pull-left">
											<img alt="image" class="img-circle" src="<?php echo assets_url('img/profile.jpg');?>">
										</a>
										<div class="media-body ">
											<small class="pull-right">23h ago</small>
											<strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
											<small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
										</div>
									</div>
								</li>
								<li class="divider"></li>
								<li>
									<div class="text-center link-block">
										<a href="mailbox.html">
											<i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
										</a>
									</div>
								</li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
								<i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
							</a>
							<ul class="dropdown-menu dropdown-alerts">
								<li>
									<a href="mailbox.html">
										<div>
											<i class="fa fa-envelope fa-fw"></i> You have 16 messages
											<span class="pull-right text-muted small">4 minutes ago</span>
										</div>
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="profile.html">
										<div>
											<i class="fa fa-twitter fa-fw"></i> 3 New Followers
											<span class="pull-right text-muted small">12 minutes ago</span>
										</div>
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="grid_options.html">
										<div>
											<i class="fa fa-upload fa-fw"></i> Server Rebooted
											<span class="pull-right text-muted small">4 minutes ago</span>
										</div>
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<div class="text-center link-block">
										<a href="notifications.html">
											<strong>See All Alerts</strong>
											<i class="fa fa-angle-right"></i>
										</a>
									</div>
								</li>
							</ul>
						</li>-->
			
			
						<li>
							<a href="<?php echo base_url();?>logout">
								<i class="fa fa-sign-out"></i> Cerrar Sesión
							</a>
						</li>
					</ul>
			
				</nav>
			</div>					
			<!-- Validación de acciones -->
			<?php echo validar_acciones(); ?>
			<!-- Validación de acciones -->
		
