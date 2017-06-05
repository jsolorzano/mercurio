<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Usuarios </h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Inicio</a>
            </li>
            <li>
                <a>Usuarios</a>
            </li>
            <li class="active">
                <strong>Usuarios</strong>
            </li>
        </ol>
    </div>
</div>
<?php
//~ echo "probando...<br>";
//~ // Recorrido de los datos del usuario
//~ $ci = & get_instance();
//~ $accionesperfil = array();  // Ids de las acciones (módulos) permitidos para el perfil logueado
//~ $accionesusuario = array();  // Ids de las acciones (módulos) permitidos para el usuario logueado
//~ foreach($ci->session->userdata('logged_in') as $clave => $userdata){
	//~ if($clave == "acciones"){
		//~ foreach($userdata as $accion){
			//~ $accionesperfil[] = $accion[0]->id;
		//~ }
	//~ }else if($clave == "permisos"){
		//~ foreach($userdata as $permiso){
			//~ $accionesusuario[] = $permiso[0]->id;
		//~ }
	//~ }
//~ }
//~ 
//~ echo "Acciones perfil:<br>";
//~ print_r($accionesperfil);
//~ echo "<br>";
//~ echo "Acciones usuario:<br>";
//~ print_r($accionesusuario);
?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Registrar Usuario <small></small></h5>
				</div>
				<div class="ibox-content">
					<form id="form_users" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Nombre *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  placeholder="" name="name" id="name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Apellido *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  placeholder="" name="lastname" id="lastname">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Usuario *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  placeholder="ejemplo@xmail.com" name="username" id="username">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Contraseña *</label>
							<div class="col-sm-10">
								<input type="password" class="form-control required"  placeholder="" name="password" id="password">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Confirme Contraseña *</label>
							<div class="col-sm-10">
								<input type="password" class="form-control "  placeholder="" name="passw1" id="passw1">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Perfil *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="profile_id" id="profile">
									<option value="0" selected="">Seleccione</option>
									<?php foreach ($list_perfil as $perfil) { ?>
										<option value="<?php echo $perfil->id ?>"><?php echo $perfil->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group" id="franquicias">
							<label class="col-sm-2 control-label" >Franquicia</label>
							<div class="col-sm-10">
								<select class="form-control m-b" id="franchises" multiple="multiple">
									<?php
									// Armamos un arreglo de ids de franquicias asignadas a usuarios
									//~ $franquicias_ids = array();
									//~ foreach ($user_franquicias as $user_franquicia) {
										//~ $franquicias_ids[] = $user_franquicia->franchise_id;
									//~ }
									?>
									<?php foreach ($franquicias as $franquicia) { ?>
										<?php //if(!in_array($franquicia->id, $franquicias_ids)) { ?>
										<option value="<?php echo $franquicia->id ?>"><?php echo $franquicia->name ?></option>
										<?php //} ?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Módulos</label>
							<div class="col-sm-10">
								<select id="modules_ids" class="form-control" multiple="multiple">
									
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Estatus *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="status" id="status">
									<option value="1" selected="">Activo</option>
									<option value="0">Inactivo</option>

								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								<input id="base_url" type="hidden" value="<?php echo base_url(); ?>"/>
								<input type='hidden' id="id" value=""/>
								<input type="hidden" name="admin" id="admin">
								<button class="btn btn-white" id="volver" type="button">Volver</button>
								<button class="btn btn-primary" id="registrar" type="submit">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>
 <script src="<?php echo assets_url('script/users.js'); ?>" type="text/javascript" charset="utf-8" ></script>
