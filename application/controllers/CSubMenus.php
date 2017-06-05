<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CSubMenus extends CI_Controller {

	public function __construct() {
        parent::__construct();

		// Load database
        $this->load->model('MSubMenus');
        $this->load->model('MMenus');
        $this->load->model('MAcciones');
		
    }
	
	public function index()
	{
		$this->load->view('base');
		$data['listar'] = $this->MSubMenus->obtener();
		$data['menus'] = $this->MMenus->obtener();
		$data['acciones'] = $this->MAcciones->obtener();
		$this->load->view('submenus/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$this->load->view('base');
		$data['menus'] = $this->MMenus->obtener();
		$data['acciones'] = $this->MAcciones->obtenerNoAsignadas();
		$this->load->view('submenus/registrar', $data);
		$this->load->view('footer');
	}
	
	  //Método para guardar un nuevo registro
    public function add() {

        $result = $this->MSubMenus->insert($this->input->post());
        
        echo $result;  // No comentar, esta impresión es necesaria para que se ejecute el método insert()
        
        if ($result != 'existe') {
			
			// Armamos los datos del nuevo submenú
			$data_new_submenu = array(
				'id' => $result,
				'name'=>$this->input->post('name'),
				'route'=>$this->input->post('route'),
				'menu_id'=>$this->input->post('menu_id'),
				'action_id'=>$this->input->post('action_id')
			);
			// Transformamos el nuevo menú en un objeto
			$data_new_submenu = (object)$data_new_submenu;
			
			// Incluimos el nuevo menú en la sesión
			$this->session->userdata['logged_in']['submenus'][0][] = $data_new_submenu;
           
			// Actualizamos la acción y la asignamos 
			$data_action = array();
			$data_action['id'] = $this->input->post('action_id');
			$data_action['assigned'] = 1;

			$update_action = $this->MAcciones->update_simple($data_action);
       
        }
    }
	 //Método para editar
    public function edit() {
		$this->load->view('base');
        $data['id'] = $this->uri->segment(3);
        $data['menus'] = $this->MMenus->obtener();
        
        // Consultamos el id de la acción asociada al submenú
        $id_submenu = $data['id'];
		$find_submenu = $this->MSubMenus->obtenerSubMenu($id_submenu);
		
		$data['acciones'] = $this->MAcciones->obtenerNoAsignadasId($find_submenu[0]->action_id);
        $data['editar'] = $this->MSubMenus->obtenerSubMenu($data['id']);
        $this->load->view('submenus/editar', $data);
    }
	
	//Método para actualizar
    public function update() {
		
		// Primero actualizamos la acción anteriormente asociada y la desasignamos
		$id_submenu = $this->input->post('id');
		$find_submenu = $this->MSubMenus->obtenerSubMenu($id_submenu);
		$data_action = array();
		$data_action['id'] = $find_submenu[0]->action_id;
		$data_action['assigned'] = 0;
		
		$update_action = $this->MAcciones->update_simple($data_action);
		
		// Actualizamos los nuevos datos del submenú
        $result = $this->MSubMenus->update($this->input->post());
        
        if ($result) {			
			// Ahora actualizamos la nueva acción y la asignamos 
			$data_action = array();
			$data_action['id'] = $this->input->post('action_id');
			$data_action['assigned'] = 1;

			$update_action = $this->MAcciones->update_simple($data_action);
        }
    }
    
	//Método para eliminar
	function delete($id) {
		
		// Primero consultamos el identificador de la acción a sociada al submenú
		$id_submenu = $id;
		$find_submenu = $this->MSubMenus->obtenerSubMenu($id_submenu);
		$data_action = array();
		$data_action['id'] = $find_submenu[0]->action_id;
		$data_action['assigned'] = 0;
		
		// Eliminamos el submenú
        $result = $this->MSubMenus->delete($id);
        
        if ($result) {
			// Actualizamos la acción para desasignarla (assigned=0)
			$update_action = $this->MAcciones->update_simple($data_action);
			
			// Quitamos el submenú de la sesión
			$indice = 30;  // Variable para capturar el indice del arreglo que contenga el id del submenú a eliminar
			// Le colocamos un número alto como valor por si no se encuentra el id en ninguno de los arreglos
			foreach($this->session->userdata['logged_in']['submenus'][0] as $key => $submenu){
				if($submenu->id == $id){
					$indice = $key;
				}
			}
			// Quitamos el array correspondiente al submenú con el indice obtenido
			unset($this->session->userdata['logged_in']['submenus'][0][$indice]);
        }
    }
	
	
}
