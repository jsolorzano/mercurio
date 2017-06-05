<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CFranchises extends CI_Controller {

	public function __construct() {
        parent::__construct();

		// Load database
        $this->load->model('MFranchises');
        $this->load->model('MAssignment');
		$this->load->model('MServices');
		
    }
	
	public function index()
	{
		$this->load->view('base');
		$data['listar'] = $this->MFranchises->obtener();
		$data['list_assignment'] = $this->MAssignment->obtener();
		$data['list_serv'] = $this->MServices->obtener();
		$this->load->view('franchises/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$this->load->view('base');
		$data['list_serv'] = $this->MServices->obtener();
		$this->load->view('franchises/registrar', $data);
		$this->load->view('footer');
	}
	
	// Método para guardar un nuevo registro
    public function add() {
		
		$data = array('name'=>$this->input->post('name'),'address'=>$this->input->post('address'),'status'=>$this->input->post('status'));
        
        $result = $this->MFranchises->insert($data);
        
        echo $result;  // No comentar, esta impresión es necesaria para que se ejecute el método insert()
        
        if ($result != 'existe') {
			// Si hay servicios asociados a la franquicia, asociamos los servicios seleccionadas del combo select
			if($this->input->post('services_ids') != ""){
				// Proceso de registro de servicios asociados a la franquicia
				foreach($this->input->post('services_ids') as $service_id){
					$data = array('franchise_id'=>$result, 'service_id'=>$service_id);
					$this->MAssignment->insert_service($data);
				}
			}
        }else{
			return $result;
		}
    }
    
	// Método para editar
    public function edit() {
		$this->load->view('base');
        $data['id'] = $this->uri->segment(3);
        $data['editar'] = $this->MFranchises->obtenerFranchises($data['id']);
        $data['list_serv'] = $this->MServices->obtener();
        // Lista de servicios asociados al perfil
        $ids_services = "";
        $query_services = $this->MAssignment->obtenerServicesFranchiseId($data['id']);
        if(count($query_services) > 0){
			foreach($query_services as $service){
				$ids_services .= $service->service_id.",";
			}
		}
		$ids_services = substr($ids_services,0,-1);
		$data['ids_services'] = $ids_services;
        $this->load->view('franchises/editar', $data);
		$this->load->view('footer');
    }
	
	// Método para actualizar
    public function update() {
		
		$data = array('id'=>$this->input->post('id'),'name'=>$this->input->post('name'),'address'=>$this->input->post('address'),'status'=>$this->input->post('status'));
        
        $result = $this->MFranchises->update($data);
        
        echo $result;  // No comentar, esta impresión es necesaria para que se ejecute el método update()
        
        if ($result) {
			// Si hay servicios asociados a la franquicia, asociamos los servicios seleccionadas del combo select
			if($this->input->post('services_ids') != ""){
				// Proceso de registro de servicios asociados a la franquicia
				$ids_services = array(); // Aquí almacenaremos los ids de los servicios a asociar
				// Asociamos los nuevos servicios seleccionadas del combo select
				foreach($this->input->post('services_ids') as $service_id){
					// Primero verificamos si ya está asociado cada servicio, si no lo está, lo insertamos
					$check_associated = $this->MAssignment->obtenerServiceFranchiseId($this->input->post('id'), $service_id);
					//~ echo count($check_associated);
					if(count($check_associated) == 0){
						$data_service = array('franchise_id'=>$this->input->post('id'), 'service_id'=>$service_id);
						$this->MAssignment->insert_service($data_service);
					}
					// Vamos colectando los ids recorridos
					$ids_services[] = $service_id;
				}
				
				// Validamos qué servicios han sido quitadas del combo select para proceder a borrar las relaciones
				// Primero buscamos todos los servicios asociados a la franquicia
				$query_associated = $this->MAssignment->obtenerServicesFranchiseId($this->input->post('id'));
				if(count($query_associated) > 0){
					// Verificamos cuales de los servicios no están en la nueva lista
					foreach($query_associated as $association){
						if(!in_array($association->service_id, $ids_services)){
							// Eliminamos la asociacion de la tabla franchises_services
							$this->MAssignment->delete_franchise_service($this->input->post('id'), $association->service_id);
						}
					}
				}
			}else{
				// Eliminamos las asociaciones de la tabla franchises_services correspondientes a la franquicia seleccionada
				// Primero buscamos todos los servicios asociados a la franquicia
				$query_associated = $this->MAssignment->obtenerServicesFranchiseId($this->input->post('id'));
				if(count($query_associated) > 0){
					// Eliminamos las asociaciones encontradas
					foreach($query_associated as $association){
						$this->MAssignment->delete_franchise_service($this->input->post('id'), $association->service_id);
					}
				}
			}
        }else{
			return $result;
		}
    }
    
	// Método para eliminar
	function delete($id) {
        $result = $this->MFranchises->delete($id);
        if ($result) {
          /*  $this->libreria->generateActivity('Eliminado País', $this->session->userdata['logged_in']['id']);*/
        }
    }
	
	
}
