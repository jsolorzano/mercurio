<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CUser extends CI_Controller {

	public function __construct() {
        parent::__construct();

		// Load database
        $this->load->model('MUser');
		$this->load->model('MPerfil');
        $this->load->model('MModulos');
        $this->load->model('MFranchises');
		
    }
	
	public function index()
	{
		$this->load->view('base');
		$data['listar'] = $this->MUser->obtener();
		$data['franquicias'] = $this->MFranchises->obtener();
		$data['users_franquicias'] = $this->MUser->obtenerUsersFranchises();
		$data['modulos'] = $this->MModulos->obtener();
		$data['permisos'] = $this->MUser->obtener_permisos();
		$this->load->view('user/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$this->load->view('base');
		$data['list_perfil'] = $this->MPerfil->obtener();
		$data['franquicias'] = $this->MFranchises->obtener();
		$data['modulos'] = $this->MModulos->obtener_without_home();
		//~ $data['user_franquicias'] = $this->MUser->obtenerUsersFranchises();
		$this->load->view('user/registrar',$data);
		$this->load->view('footer');
	}
	
	// Método para guardar un nuevo registro
    public function add() {
		
		$data = array(
			'username' => $this->input->post('username'),
			'name' => $this->input->post('name'),
			'lastname' => $this->input->post('lastname'),
			'profile_id' => $this->input->post('profile_id'),
			'admin' => $this->input->post('admin'),
			'password' => 'pbkdf2_sha256$12000$' . hash("sha256", $this->input->post('password')),
			'status' => $this->input->post('status'),
			'd_create' => date('Y-m-d H:i:s'),
			'd_update' => date('Y-m-d H:i:s'),

		);
        $result = $this->MUser->insert($data);
        
        echo $result;  // No comentar, esta impresión es necesaria para que se ejecute el método insert()
        
        if ($result != 'existe'){
			// Si hay franquicias asociadas al usuario, registramos la relación en la tabla 'users_franchises'
			if($this->input->post('franquicias_ids') != ""){
				// Inserción de las relaciones usuario-franquicia				
				foreach($this->input->post('franquicias_ids') as $franchise_id){
					$data = array('user_id'=>$result, 'franchise_id'=>$franchise_id);
					$this->MUser->insert_franchise($data);
				}
			}
			// Si hay modulos asociadas al usuario, registramos la relación en la tabla 'permissions'
			if($this->input->post('modules_ids') != ""){
				// Inserción de las relaciones usuario-franquicia				
				foreach($this->input->post('modules_ids') as $module_id){
					$data = array('user_id'=>$result, 'module_id'=>$module_id, 'parameter_permit'=>'777');
					$this->MUser->insert_module($data);
				}
			}
			       
        }
    }
	
	// Método para editar
    public function edit() {
		$this->load->view('base');
        $data['id'] = $this->uri->segment(2);
		$data['list_perfil'] = $this->MPerfil->obtener();
		$data['franquicias'] = $this->MFranchises->obtener();
		//~ $data['user_franquicias'] = $this->MUser->obtenerUsersFranchises();
        $data['editar'] = $this->MUser->obtenerUsers($data['id']);
        // Lista de ids de franquicias asociadas al usuario
        $ids_franchises = "";
        $query_franchises = $this->MUser->obtenerFranchisesUserId($data['id']);
        if(count($query_franchises) > 0){
			foreach($query_franchises as $franchise){
				$ids_franchises .= $franchise->franchise_id.",";
			}
		}
		$ids_franchises = substr($ids_franchises,0,-1);  // Quitamos la última coma de la cadena
		$data['ids_franchises'] = $ids_franchises;
		$data['permissions'] = $this->MUser->obtener_permisos_id($data['id']);
		$data['modulos'] = $this->MModulos->obtener_without_home();
		// Lista de ids de modulos asociadas al usuario
        $ids_modules = "";
        $query_modules = $this->MUser->obtener_permisos_id($data['id']);
        if(count($query_modules) > 0){
			foreach($query_modules as $module){
				$ids_modules .= $module->module_id.",";
			}
		}
		$ids_modules = substr($ids_modules,0,-1);
        $data['ids_modules'] = $ids_modules;
        $this->load->view('user/editar', $data);
		$this->load->view('footer');
    }
	
	// Método para actualizar
    public function update() {
		
		$data = array(
			'id' => $this->input->post('id'),
			'username' => $this->input->post('username'),
			'name' => $this->input->post('name'),
			'lastname' => $this->input->post('lastname'),
			'profile_id' => $this->input->post('profile_id'),
			'admin' => $this->input->post('admin'),
			'status' => $this->input->post('status'),
			'd_update' => date('Y-m-d H:i:s'),

		);
		
        $result = $this->MUser->update($data);
        
        echo $result;
        
        if ($result) {
			// Si hay nuevas franquicias asociadas al usuario, los registramos en la tabla 'users_franchises'
			if($this->input->post('franquicias_ids') != ""){
				// Proceso de registro de frasnquicias asociados al usuario
				$ids_franchises = array(); // Aquí almacenaremos los ids de las franquicias a asociar
				// Asociamos las nuevas franquicias seleccionadas del combo select
				foreach($this->input->post('franquicias_ids') as $franchise_id){
					// Primero verificamos si ya está asociada cada franquicia, si no lo está, la insertamos
					$check_associated = $this->MUser->obtenerUserFranchiseId($this->input->post('id'), $franchise_id);
					//~ echo count($check_associated);
					if(count($check_associated) == 0){
						$data_franchise = array('user_id'=>$this->input->post('id'), 'franchise_id'=>$franchise_id);
						$this->MUser->insert_franchise($data_franchise);
					}
					// Vamos colectando los ids recorridos
					$ids_franchises[] = $franchise_id;
				}
				
				// Validamos qué franquicias han sido quitadas del combo select para proceder a borrar las relaciones
				// Primero buscamos todas las franquicias asociadas al usuario
				$query_associated = $this->MUser->obtenerFranchisesUserId($this->input->post('id'));
				if(count($query_associated) > 0){
					// Verificamos cuales de las franquicias no están en la nueva lista
					foreach($query_associated as $association){
						if(!in_array($association->franchise_id, $ids_franchises)){
							// Eliminamos la asociacion de la tabla users_franchises
							$this->MUser->delete_user_franchise($this->input->post('id'), $association->franchise_id);
						}
					}
				}
			}else{
				// Eliminamos las asociaciones de la tabla users_franchises correspondientes al usuario seleccionado
				// Primero buscamos todas las franquicias asociados al usuario
				$query_associated = $this->MUser->obtenerFranchisesUserId($this->input->post('id'));
				if(count($query_associated) > 0){
					// Eliminamos las asociaciones encontradas
					foreach($query_associated as $association){
						$this->MUser->delete_user_franchise($this->input->post('id'), $association->franchise_id);
					}
				}
			}
			
			// Si hay nuevas modulos asociadas al usuario, los registramos en la tabla 'permissions'
			if($this->input->post('modules_ids') != ""){
				// Proceso de registro de modulos asociadas al perfil
				$ids_modules = array(); // Aquí almacenaremos los ids de las modulos a asociar
				// Asociamos las nuevas modulos seleccionadas del combo select
				foreach($this->input->post('modules_ids') as $module_id){
					// Primero verificamos si ya está asociado cada acción, si no lo está, lo insertamos
					$check_associated = $this->MUser->obtener_permiso_ids($data['id'], $module_id);
					//~ echo count($check_associated);
					if(count($check_associated) == 0){
						$data_module = array('user_id'=>$data['id'], 'module_id'=>$module_id, 'parameter_permit'=>'777');
						$this->MUser->insert_module($data_module);
					}
					// Vamos colectando los ids recorridos
					$ids_modules[] = $module_id;
				}
				
				// Validamos qué modulos han sido quitadas del combo select para proceder a borrar las relaciones
				// Primero buscamos todas las modulos asociadas al perfil
				$query_associated = $this->MUser->obtener_permisos_id($data['id']);
				if(count($query_associated) > 0){
					// Verificamos cuales de las modulos no están en la nueva lista
					foreach($query_associated as $association){
						// Primero verificamos los datos correspondientes a la acción para omitir el proceso si es de la clase Home
						$query_module = $this->MModulos->obtenerModulo($association->module_id);
						if($query_module[0]->class != 'Home'){
							if(!in_array($association->module_id, $ids_modules)){
								// Eliminamos la asociacion de la tabla profile_modules
								$this->MUser->delete_user_module($data['id'], $association->module_id);
							}
						}
					}
				}
				
				// Actualizamos la permisología
				$data_permisos = $this->input->post('data');
				
				foreach ($data_permisos as $campo){
					// Concatenamos los permisos como una cadena
					$parameter = $campo['crear'].$campo['editar'].$campo['eliminar'];
					
					// Nuevos datos de la acción asociada
					$data_ps = array(
						'user_id' => $data['id'],
						'module_id' => $campo['id'],
						'parameter_permit' => $parameter,
					);
					
					// Actualizamos los permisos para la acción asociada
					$result = $this->MUser->update_module($data_ps);
				}
			}else{
				// Eliminamos las asociaciones de la tabla permissions correspondientes al usuario seleccionado
				// Primero buscamos todas las modulos asociados al usuario
				$query_associated = $this->MUser->obtener_permisos_id($this->input->post('id'));
				if(count($query_associated) > 0){
					// Eliminamos las asociaciones encontradas
					foreach($query_associated as $association){
						$this->MUser->delete_user_module($this->input->post('id'), $association->module_id);
					}
				}
			}
        }else{
			return $result;
		}
    }
    
    // Método para actualizar de forma directa el status de un usuario
    public function update_status($id) {
		$accion = $this->input->post('accion');
		$estatus = 1;
		
		if ($accion == 'desactivar'){
			$estatus = 0;
		}
		
		// Armamos la data a actualizar
        $data_usuario = array(
			'id' => $id,
			'status' => $estatus,
			'd_update' => date('Y-m-d H:i:s'),
        );
        
        // Actualizamos el usuario con los datos armados
		$result = $this->MUser->update_status($data_usuario);
	}
    
	// Método para eliminar
	function delete($id) {
        $result = $this->MUser->delete($id);
    }
    
    // Método público para cargar un json con las modulos no asignadas al perfil seleccionado
    public function search_modules()
    {
		$id_profile = $this->input->post('profile_id');  // id del perfil
		
        $result = $this->MUser->search_profile_modules($id_profile);  // Consultamos los ids de los módulos asociados al perfil
        // Armamos una lista de ids de los módulos asociados al perfil
        $list_modules_ids = array();
        foreach($result as $relation){
			$list_modules_ids[] = $relation->module_id;
		}
		
		if(count($list_modules_ids) > 0){
			// Si hay módulos asociados al perfil
			$result2 = $this->MUser->search_modules($list_modules_ids);  // Buscamos las módulos que no están asociadas al perfil
		}else{
			// Si no hay módulos asociados al perfil
			$result2 = $this->MModulos->obtener_without_home();  // Buscamos todos los módulos
		}
		
        echo json_encode($result2);
    }
	
	// Método público para cargar un json con las módulos no asignadas al usuario seleccionado
    public function search_modules2()
    {
		$id_usuario = $this->input->post('user_id');  // id del usuario
		
        $result = $this->MUser->search_permissions($id_usuario);  // Consultamos los ids de los módulos asociados al usuario
        // Armamos una lista de ids de los módulos asociados al usuario
        $list_modules_ids = array();
        foreach($result as $relation){
			$list_modules_ids[] = $relation->module_id;
		}
		
		if(count($list_modules_ids) > 0){
			// Si hay módulos asociados al usuario
			$result2 = $this->MUser->search_modules2($list_modules_ids);  // Buscamos los módulos que están asociados al usuario
		}else{
			// Si no hay módulos asociados al usuario
			$result2 = $list_modules_ids;
		}
		
        echo json_encode($result2);
    }
}
