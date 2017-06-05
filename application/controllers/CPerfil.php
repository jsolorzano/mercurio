<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CPerfil extends CI_Controller {

	public function __construct() {
        parent::__construct();

		// Load database
        $this->load->model('MPerfil');
        $this->load->model('MModulos');
		
    }
	
	public function index()
	{
		$this->load->view('base');
		$data['listar'] = $this->MPerfil->obtener();
		$data['profile_modulos'] = $this->MPerfil->obtener_modulos();
		$data['modulos'] = $this->MModulos->obtener();
		$this->load->view('perfiles/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$this->load->view('base');
		$data['modulos'] = $this->MModulos->obtener_without_home();
		$this->load->view('perfiles/registrar', $data);
		$this->load->view('footer');
	}
	
	// Método para guardar un nuevo registro
    public function add() {
        
        $data = array('name'=>$this->input->post('name'));
        
        $result = $this->MPerfil->insert($data);
        
        echo $result;  // No comentar, esta impresión es necesaria para que se ejecute el método insert()
        
        if ($result != 'existe') {
			// Proceso de registro de modulos asociados al perfil
			// Primero asociamos el módulo por defecto (HOME)
			$module_class = $this->MModulos->obtenerModuloByClass('Home');
			$data_module = array('profile_id'=>$result, 'module_id'=>$module_class[0]->id, 'parameter_permit'=>'777');
			$this->MPerfil->insert_module($data_module);
			// Asociamos los módulos seleccionados del combo select
			foreach($this->input->post('modules_ids') as $module_id){
				$data_module = array('profile_id'=>$result, 'module_id'=>$module_id, 'parameter_permit'=>'777');
				$this->MPerfil->insert_module($data_module);
			}
        }else{
			return $result;
		}
    }
    
	// Método para editar
    public function edit() {
		$this->load->view('base');
        $data['id'] = $this->uri->segment(2);
        $data['editar'] = $this->MPerfil->obtenerPerfiles($data['id']);
        $data['profile_modulos'] = $this->MPerfil->obtener_modulos_id($data['id']);
        $data['modulos'] = $this->MModulos->obtener_without_home();
        // Lista de módulos asociados al perfil
        $ids_modules = "";
        $query_modules = $this->MPerfil->obtener_modulos_id($data['id']);
        if(count($query_modules) > 0){
			foreach($query_modules as $module){
				$ids_modules .= $module->module_id.",";
			}
		}
		$ids_modules = substr($ids_modules,0,-1);
        $data['ids_modules'] = $ids_modules;
        $this->load->view('perfiles/editar', $data);
		$this->load->view('footer');
    }
	
	// Método para actualizar
    public function update() {
		
		$data = array('id'=>$this->input->post('id'),'name'=>$this->input->post('name'));
		
        $result = $this->MPerfil->update($data);
        
        echo $result;  // No comentar, esta impresión es necesaria para que se ejecute el método update()
        
        if ($result) {
			// Proceso de registro de módulos asociados al perfil
			$ids_modules = array(); // Aquí almacenaremos los ids de los módulos a asociar
			// Asociamos los nuevos módulos seleccionadas del combo select
			foreach($this->input->post('modules_ids') as $module_id){
				// Primero verificamos si ya está asociado cada módulo, si no lo está, lo insertamos
				$check_associated = $this->MPerfil->obtener_modulo_ids($data['id'], $module_id);
				//~ echo count($check_associated);
				if(count($check_associated) == 0){
					$data_module = array('profile_id'=>$data['id'], 'module_id'=>$module_id, 'parameter_permit'=>'777');
					$this->MPerfil->insert_module($data_module);
				}
				// Vamos colectando los ids recorridos
				$ids_modules[] = $module_id;
			}
			
			// Validamos qué módulos han sido quitados del combo select para proceder a borrar las relaciones
			// Primero buscamos todos las módulos asociados al perfil
			$query_associated = $this->MPerfil->obtener_modulos_id($data['id']);
			if(count($query_associated) > 0){
				// Verificamos cuales de los módulos no están en la nueva lista
				foreach($query_associated as $association){
					// Primero verificamos los datos correspondientes al módulo para omitir el proceso si es de la clase Home
					$query_module = $this->MModulos->obtenerModulo($association->module_id);
					if($query_module[0]->class != 'Home'){
						if(!in_array($association->module_id, $ids_modules)){
							// Eliminamos la asociacion de la tabla profile_modules
							$this->MPerfil->delete_profile_module($data['id'], $association->module_id);
						}
					}
				}
			}
			
			// Actualizamos la permisología
			$data_permisos = $this->input->post('data');
			
			foreach ($data_permisos as $campo){
				// Concatenamos los permisos como una cadena
				$parameter = $campo['crear'].$campo['editar'].$campo['eliminar'];
				
				// Nuevos datos del módulo asociado
				$data_ps = array(
					'profile_id' => $data['id'],
					'module_id' => $campo['id'],
					'parameter_permit' => $parameter,
				);
				
				// Actualizamos los permisos para el módulo asociado
				$result = $this->MPerfil->update_module($data_ps);
			}
			
        }else{
			return $result;
		}
    }
    
	// Método para eliminar
	function delete($id) {
        $result = $this->MPerfil->delete($id);
        if ($result) {
          /*  $this->libreria->generateActivity('Eliminado País', $this->session->userdata['logged_in']['id']);*/
        }
    }
	
	
}
