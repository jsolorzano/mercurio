<?php

Class Basicauth
{
	function __construct()
	{
		$this->CI = & get_instance();
	}
	
	function login($usuario, $password)
	{
		$data = array();
		$query = $this->CI->db->get_where('users', array('username'=>$usuario, 'password'=>$password));
		
		if($query->num_rows() > 0){
			//~ echo "Pasó 1";
			$query = $this->CI->db->get_where('users', array('username'=>$usuario, 'password'=>$password, 'status'=>1));
			if($query->num_rows() > 0){
				//~ echo "Pasó 2";
				// Consultamos los datos de perfil del usuario
				$query_profile = $this->CI->db->get_where('profile', array('id'=>$query->row()->profile_id));
				// Consultamos los datos de modulos del perfil
				$query_profile_modules = $this->CI->db->get_where('profile_modules', array('profile_id'=>$query_profile->row()->id));
				$modulos = array();
				foreach($query_profile_modules->result() as $profile_module){
					$query_modules = $this->CI->db->get_where('modules', array('id'=>$profile_module->module_id));
					$modulos[] = $query_modules->result();
				}
				// Consultamos los datos de permisos del usuario
				$query_permissions = $this->CI->db->get_where('permissions', array('user_id'=>$query->row()->id));
				$permisos = array();
				foreach($query_permissions->result() as $permissions){
					$query_modules2 = $this->CI->db->get_where('modules', array('id'=>$permissions->module_id));
					$permisos[] = $query_modules2->result();
				}
				// Buscamos los datos de la franquicia con sus servicios, los menús y submenús asociados al usuario
				$franquicias = array();
				$servicios = array();
				$menus = array();
				$submenus = array();
				// Primero verificamos que el usuario no sea administrador
				//if($query->row()->admin == 0){
					//~ echo "Pasó 3";
					// Buscamos si hay franquicias asociadas al usuario
					$query_user_franquicia = $this->CI->db->get_where('users_franchises', array('user_id'=>$query->row()->id));
					if($query_user_franquicia->num_rows() > 0){
						// Listamos las franquicias asociadas
						$ids_serv = array();  // Variable para almacenar los ids de los servicios y filtrar los repetidos
						foreach($query_user_franquicia->result() as $franchises){
							$query_franquicia = $this->CI->db->get_where('franchises', array('id'=>$franchises->franchise_id));
							$franquicias[] = $query_franquicia->result();
							// Buscamos los datos de los servicios asociados a la(s) franquicia(s)
							$query_franquicia_services = $this->CI->db->get_where('franchises_services', array('franchise_id'=>$query_franquicia->row()->id));
							if($query_franquicia_services->num_rows() > 0){
								// Listamos los servicios asociados
								foreach($query_franquicia_services->result() as $services){
									$query_servicio = $this->CI->db->get_where('services', array('id'=>$services->service_id));
									if(!in_array($query_servicio->row()->id, $ids_serv)){
										$servicios[] = $query_servicio->result();
									}
									$ids_serv[] = $query_servicio->row()->id;  // Vamos almacenando los ids de los servicios ya cargados
								}
							}
						}
					}
					// Carga de menús y submenús para usuarios no administradores
					$ids_modulos = array();  // Lista de ids de modulos para buscar en submenús
					// Buscamos los submenús (modulos y permisos) asociados al usuario para armar la lista de modulos
					foreach($modulos as $accion){
						//~ print_r($accion);
						$ids_modulos[] = $accion[0]->id;
					}
					foreach($permisos as $permiso){
						//~ print_r($permiso);
						$ids_modulos[] = $permiso[0]->id;
					}
					//~ print_r($ids_modulos);
					// Buscamos los menús y submenús correspondientes a los ids de modulos
					foreach($ids_modulos as $id_accion){
						//~ echo $id_accion;
						$query_submenus = $this->CI->db->get_where('submenus', array('module_id'=>$id_accion));
						if($query_submenus->num_rows() > 0){
							$submenus[] = $query_submenus->result();
						}
						$query_menus = $this->CI->db->get_where('menus', array('module_id'=>$id_accion));
						if($query_menus->num_rows() > 0){
							$menus[] = $query_menus->result();
						}
					}
					// Buscamos los menús correspondientes a los menu_id de la lista de submenús
					$menu_names = array();  // Variable de apoyo para validar que no se repitan los menús
					foreach($submenus as $submenu){
						//~ echo $submenu[0]->menu_id;
						$query_menus = $this->CI->db->get_where('menus', array('id'=>$submenu[0]->menu_id));
						if($query_menus->num_rows() > 0){
							if(!in_array($query_menus->result()[0]->name, $menu_names)){
								$menu_names[] = $query_menus->result()[0]->name;
								$menus[] = $query_menus->result();
							}
						}
					}
				/*}else{
					// Consultamos los datos de todas las modulos 
					// (en este caso, el formato de captura de datos de modulos en sesión será diferente en el hook de acceso y el helper de menú, para lo cual habrá que hacer una validación en dichos archivos)
					$modulos = array();
					$query_modules = $this->CI->db->get('modules');
					foreach($query_modules->result() as $module){
						$modulos[] = $module;
					}
					// Carga de menús y submenús para usuarios administradores
					// Menús
					$query_menus = $this->CI->db->get('menus');
					$menus[] = $query_menus->result();
					// Submenús
					$query_submenus = $this->CI->db->get('submenus');
					$submenus[] = $query_submenus->result();
				}*/
				//~ exit();
				// Creamos la sesión y le cargamos los datos de usuario
				$session_data = array(
					'id' => $query->row()->id,
					'username' => $usuario,
					'admin' => $query->row()->admin,
					'profile_id' => $query_profile->row()->id,
					'profile_name' => $query_profile->row()->name,
					'modulos' => $modulos,
					'permisos' => $permisos,
					'franquicias' => $franquicias,
					'servicios' => $servicios,
					'submenus' => $submenus,
					'menus' => $menus
				);
				$this->CI->session->set_userdata('logged_in',$session_data);
				
			}else{
				$data['error'] = 'Disculpe, el usuario no tiene acceso, consulte con el administrador del sistema';
			}
		}else{
			$data['error'] = 'Usuario o contraseña incorrectos';
		}
		
		return $data;
	}
	
	function logout()
	{
		$this->CI->session->sess_destroy();
	}
}
