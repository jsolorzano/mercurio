<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CAssignment extends CI_Controller {

	public function __construct() {
        parent::__construct();


        $this->load->view('base');
		// Load database
        $this->load->model('MAssignment');
		$this->load->model('MFranchises');
		$this->load->model('MServices');
		
    }
	
	public function index()
	{
		$data['listar'] = $this->MAssignment->obtener();
		$data['list_franq'] = $this->MFranchises->obtener();
		$data['list_serv'] = $this->MServices->obtener();
		$this->load->view('assignment/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$data['list_franq'] = $this->MFranchises->obtener();
		$data['list_serv'] = $this->MServices->obtener();
		$this->load->view('assignment/registrar',$data);
		$this->load->view('footer');
	}
	
	  //metodo para guardar un nuevo registro
    public function add() {
        
		// Proceso de registro de servicios asociados a la franquicia
		// Asociamos los servicios seleccionadas del combo select
		foreach($this->input->post('services_ids') as $service_id){
			$data = array('franchise_id'=>$this->input->post('franchise_id'), 'service_id'=>$service_id);
			$result = $this->MAssignment->insert($data);
		}
    }
	 //metodo para editar
    public function edit() {		
        $data['id'] = $this->uri->segment(3);
		$data['list_franq'] = $this->MFranchises->obtener();
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
        $this->load->view('assignment/editar', $data);
		$this->load->view('footer');
    }
	
	//Metodo para actualizar
    public function update() {
		
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
    }
    
	//Metodo para eliminar
	function delete($id) {
		
        $result = $this->MAssignment->delete($id);
        if ($result) {
          /*  $this->libreria->generateActivity('Eliminado País', $this->session->userdata['logged_in']['id']);*/
        }
    }
	
	
}
?>
