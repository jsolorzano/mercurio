<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CModulos extends CI_Controller {

	public function __construct() {
        parent::__construct();


        $this->load->view('base');
		// Load database
        $this->load->model('MModulos');
		
    }
	
	public function index()
	{
		$data['listar'] = $this->MModulos->obtener();
		$this->load->view('modulos/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$data['controladores'] = $this->MModulos->listar_controladores("application/controllers/", '');
		$this->load->view('modulos/registrar', $data);
		$this->load->view('footer');
	}
	
	  //Método para guardar un nuevo registro
    public function add() {
		
		$data = array(
		'name'=>strtoupper($this->input->post('name')),
		'class'=>$this->input->post('class'),
		'route'=>$this->input->post('route'));
		
        $result = $this->MModulos->insert($data);
        if ($result) {

           /*$this->libreria->generateActivity('Nuevo Grupo de Usuario', $this->session->userdata('logged_in')['id']);*/
       
        }
    }
	 //Método para editar
    public function edit() {
        $data['id'] = $this->uri->segment(3);
        $data['controladores'] = $this->MModulos->listar_controladores("application/controllers/", $data['id']);
        $data['editar'] = $this->MModulos->obtenerModulo($data['id']);
        $this->load->view('modulos/editar', $data);
    }
	
	//Método para actualizar
    public function update() {
		
		$data = array(
		'id'=>$this->input->post('id'),
		'name'=>strtoupper($this->input->post('name')),
		'class'=>$this->input->post('class'),
		'route'=>$this->input->post('route'));
		
        $result = $this->MModulos->update($data);
        if ($result) {
        /*    $this->libreria->generateActivity('Actualizado Grupo de Usuario', $this->session->userdata['logged_in']['id']);*/
     
        }
    }
	//Método para eliminar
	function delete($id) {
		
        $result = $this->MModulos->delete($id);
        if ($result) {
          /*  $this->libreria->generateActivity('Eliminado País', $this->session->userdata['logged_in']['id']);*/
        }
    }
	
	
}
