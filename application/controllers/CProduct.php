<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CProduct extends CI_Controller {

	public function __construct() {
        parent::__construct();


       
		// Load database
        $this->load->model('MProduct');
		
    }
	
	public function index()
	{
		$this->load->view('base');
		$data['listar'] = $this->MProduct->obtener();
		$this->load->view('product/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$this->load->view('base');
		$this->load->view('product/registrar');
		$this->load->view('footer');
	}
	
	  //metodo para guardar un nuevo registro
    public function add() {

        $result = $this->MProduct->insert($this->input->post());
        if ($result) {

           /*$this->libreria->generateActivity('Nuevo Grupo de Usuario', $this->session->userdata('logged_in')['id']);*/
       
        }
    }
	 //metodo para editar
    public function edit() {
		
		$this->load->view('base');
        $data['id'] = $this->uri->segment(3);
        $data['editar'] = $this->MProduct->obtenerProducts($data['id']);
        $this->load->view('product/editar', $data);
		$this->load->view('footer');
    }
	
	//Metodo para actualizar
    public function update() {
		
        $result = $this->MProduct->update($this->input->post());
        if ($result) {
        /*    $this->libreria->generateActivity('Actualizado Grupo de Usuario', $this->session->userdata['logged_in']['id']);*/
     
        }
    }
	//Metodo para eliminar
	function delete($id) {
		
        $result = $this->MProduct->delete($id);
        if ($result) {
          /*  $this->libreria->generateActivity('Eliminado País', $this->session->userdata['logged_in']['id']);*/
        }
    }
	
	
    public function ajax_product()
    {                                          #Campo         #Tabla                #ID
        $result = $this->MProduct->obtener();
        echo json_encode($result);
    }
	
	
}
