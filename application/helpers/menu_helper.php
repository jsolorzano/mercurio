<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('menu')) {

    //~ function menu($datos_sesion) {
    function menu() {
        $ci = & get_instance();
        $controllerspermitidos = array();  // Controladores permitidos para el usuario logueado
		$accionespermitidas = array();  // Ids de las acciones (módulos) permitidos para el usuario logueado
		$rutaspermitidas = array();  // Rutas permitidas para el usuario logueado
		
		// Si estamos logueados validamos los controladores y métodos permitidos según el perfil y usuario
		if(isset($ci->session->userdata['logged_in'])){
			// Recorrido de los datos del usuario
			foreach($ci->session->userdata('logged_in') as $clave => $userdata){
				if($clave == "acciones"){
					foreach($userdata as $accion){
						// Si el usuario no es administrador capturamos los datos de la acción haciendo referencia con el indice 0,
						// de lo contrario no será necesario indicar ningún indice
						//if($ci->session->userdata('logged_in')['admin'] == 0){
							$controllerspermitidos[] = $accion[0]->class;
							$accionespermitidas[] = $accion[0]->id;
							$rutaspermitidas[] = $accion[0]->route;
						/*}else{
							$controllerspermitidos[] = $accion->class;
							$accionespermitidas[] = $accion->id;
							$rutaspermitidas[] = $accion->route;
						}*/
					}
				}else if($clave == "permisos"){
					foreach($userdata as $permiso){
						$controllerspermitidos[] = $permiso[0]->class;
						$accionespermitidas[] = $permiso[0]->id;
						$rutaspermitidas[] = $permiso[0]->route;
					}
				}else if($clave == "franquicias"){
					//~ foreach($userdata as $franquicias){
						//~ foreach($franquicias as $franquicia){
							//~ echo $franquicia->name;
						//~ }
					//~ }
				}else if($clave == "servicios"){
					//~ foreach($userdata as $servicios){
						//~ foreach($servicios as $servicio){
							//~ echo $servicio->name;
						//~ }
					//~ }
				}else{
					//~ echo $clave." - ";
					//~ print_r($userdata);
				}				
			}
			
		}
		
        ?>

		<!-- Cargamos los menús y submenús correspondientes al perfil -->
		<?php 
		// Imprimiendo los menús
		foreach($ci->session->userdata('logged_in')['menus'] as $menus){
			//~ print_r($menus);
			foreach($menus as $menu){
				//~ print_r($menu);
		?>
			<li>
				<?php 
				if($menu->route != ""){
					echo "<a href='".base_url().$menu->route."'><i class='".$menu->logo."'></i> <span class='nav-label'>".$menu->name."</span></a>";
				}else{
					echo "<a ><i class='".$menu->logo."'></i> <span class='nav-label'>".$menu->name."</span><span class='fa arrow'></span></a>";
				}
				
				// Verificamos si hay submenús para el menú
				$num_submenus = 0;  // Contador de submenús
				foreach($ci->session->userdata('logged_in')['submenus'] as $submenus){
					foreach($submenus as $submenu){
						if($submenu->menu_id == $menu->id){
							$num_submenus += 1;
						}
					}
				}
				if($num_submenus > 0){
					echo "<ul class='nav nav-second-level collapse'>";
					// Imprimiendo los submenús
					foreach($ci->session->userdata('logged_in')['submenus'] as $submenus){
						foreach($submenus as $submenu){
							if($submenu->menu_id == $menu->id){
								echo "<li><a href='".base_url().$submenu->route."'>".$submenu->name."</a></li>";
							}
						}
					}
					echo "</ul>";
				}
				?>
			</li>
		<?php
			}
		} 
		?>
		<!-- Cargamos los menús y submenús correspondientes al perfil -->

        <?php
    }

}

if (!function_exists('validar_acciones')) {
	// Método para validar la visualización de iconos y botones de registro, edición y borrado
    function validar_acciones(){
		$ci = & get_instance();
		
		// Si estamos logueados validamos los controladores y métodos permitidos según el perfil y usuario
		if(isset($ci->session->userdata['logged_in'])){
			$id_user = $ci->session->userdata('logged_in')['id'];
			$id_profile = $ci->session->userdata('logged_in')['profile_id'];
			// Recorrido de los datos del usuario
			foreach($ci->session->userdata('logged_in') as $clave => $userdata){
				if($clave == "acciones"){
					foreach($userdata as $accion){
						// Si el usuario no es administrador capturamos los datos de la acción haciendo referencia con el indice 0,
						// de lo contrario no será necesario indicar ningún indice
						//if($ci->session->userdata('logged_in')['admin'] == 0){
							if($ci->router->class == $accion[0]->class){
								// Si estamos en el método index hacemos los respectivos bloqueos
								if($ci->router->method == 'index'){
									// Consultamos los parámetros en base de datos
									$query_permissions = $ci->db->get_where('profile_actions', array('profile_id'=>$id_profile, 'module_id'=>$accion[0]->id));
									$permisos = $query_permissions->row()->parameter_permit;
									$crear = $permisos[0];
									$editar = $permisos[1];
									$borrar = $permisos[2];
									
									// Bloqueamos los elementos que correspondan
									if($crear == '0'){
										echo "<script>
										 $(document).ready(function () {
											$('.btn-primary').hide();
										 });
										</script>";
									}
									if($editar == '0'){
										echo "<script>
										 $(document).ready(function () {
											$('.fa-edit').hide();
										 });
										</script>";
									}
									if($borrar == '0'){
										echo "<script>
										 $(document).ready(function () {
											$('.fa-trash-o').hide();
										 });
										</script>";
									}
								}
							}
						/*}else{
							if($ci->router->class == $accion->class){
								// Si estamos en el método index hacemos los respectivos bloqueos
								if($ci->router->method == 'index'){
									// Consultamos los parámetros en base de datos
									$query_permissions = $ci->db->get_where('profile_actions', array('profile_id'=>$id_profile, 'module_id'=>$accion->id));
									$permisos = $query_permissions->row()->parameter_permit;
									$crear = $permisos[0];
									$editar = $permisos[1];
									$borrar = $permisos[2];
									
									// Bloqueamos los elementos que correspondan
									if($crear == '0'){
										echo "<script>
										 $(document).ready(function () {
											$('.btn-primary').hide();
										 });
										</script>";
									}
									if($editar == '0'){
										echo "<script>
										 $(document).ready(function () {
											$('.fa-edit').hide();
										 });
										</script>";
									}
									if($borrar == '0'){
										echo "<script>
										 $(document).ready(function () {
											$('.fa-trash-o').hide();
										 });
										</script>";
									}
								}
							}
						}*/
					}
				}else if($clave == "permisos"){
					foreach($userdata as $permiso){
						if($ci->router->class == $permiso[0]->class){
							// Si estamos en el método index hacemos los respectivos bloqueos
							if($ci->router->method == 'index'){
								// Consultamos los parámetros en base de datos
								$query_permissions = $ci->db->get_where('permissions', array('user_id'=>$id_user, 'module_id'=>$permiso[0]->id));
								$permisos = $query_permissions->row()->parameter_permit;
								$crear = $permisos[0];
								$editar = $permisos[1];
								$borrar = $permisos[2];
								
								// Bloqueamos los elementos que correspondan
								if($crear == '0'){
									echo "<script>
									 $(document).ready(function () {
										$('.btn-primary').hide();
									 });
									</script>";
								}
								if($editar == '0'){
									echo "<script>
									 $(document).ready(function () {
										$('.fa-edit').hide();
									 });
									</script>";
								}
								if($borrar == '0'){
									echo "<script>
									 $(document).ready(function () {
										$('.fa-trash-o').hide();
									 });
									</script>";
								}
							}
						}
					}
				}
			}
		}
	}
}
