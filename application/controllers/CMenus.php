<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CMenus extends CI_Controller {

	public function __construct() {
        parent::__construct();


        
		// Load database
        $this->load->model('MMenus');
        $this->load->model('MAcciones');
		
    }
	
	public function index()
	{
		$this->load->view('base');
		// Precarga de iconos
		$search_icons = $this->MMenus->search_icons();
		//~ echo $search_icons;
		if($search_icons == 0){
			$this->load_icons_csv();
		}
		$data['listar'] = $this->MMenus->obtener();
		$data['acciones'] = $this->MAcciones->obtener();
		$this->load->view('menus/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$this->load->view('base');
		$data['iconos'] = $this->MMenus->obtenerIconos();
		$data['acciones'] = $this->MAcciones->obtenerNoAsignadas();
		$this->load->view('menus/registrar', $data);
		$this->load->view('footer');
	}
	
	// Método para guardar un nuevo registro
    public function add() {
		
        $result = $this->MMenus->insert($this->input->post());
        
        echo $result;  // No comentar, esta impresión es necesaria para que se ejecute el método insert()
        
        if ($result != 'existe') {
			
			// Armamos los datos del nuevo menú
			$data_new_menu = array(
				'id' => $result,
				'name'=>$this->input->post('name'),
				'route'=>$this->input->post('route'),
				'action_id'=>$this->input->post('action_id'),
				'logo'=>$this->input->post('logo')
			);
			// Transformamos el nuevo menú en un objeto
			$data_new_menu = (object)$data_new_menu;
			
			// Incluimos el nuevo menú en la sesión
			$this->session->userdata['logged_in']['menus'][0][] = $data_new_menu;
			
			if($this->input->post('action_id') != '0'){
				// Actualizamos la acción y la asignamos 
				$data_action = array();
				$data_action['id'] = $this->input->post('action_id');
				$data_action['assigned'] = 1;

				$update_action = $this->MAcciones->update_simple($data_action);
			}
       
        }
    }
    
	// Método para editar
    public function edit() {
		$this->load->view('base');
        $data['id'] = $this->uri->segment(3);
        
        // Consultamos el id de la acción asociada al menú
        $id_menu = $data['id'];
		$find_menu = $this->MMenus->obtenerMenu($id_menu);
		
		$data['iconos'] = $this->MMenus->obtenerIconos();
		$data['acciones'] = $this->MAcciones->obtenerNoAsignadasId($find_menu[0]->action_id);
        $data['editar'] = $this->MMenus->obtenerMenu($data['id']);
        $this->load->view('menus/editar', $data);
    }
	
	// Método para actualizar
    public function update() {
		
		// Primero actualizamos la acción anteriormente asociada (si tiene) y la desasignamos
		$id_menu = $this->input->post('id');
		$find_menu = $this->MMenus->obtenerMenu($id_menu);
		$data_action = array();
		$data_action['id'] = $find_menu[0]->action_id;
		$data_action['assigned'] = 0;
		
		if($find_menu[0]->action_id != '0'){
			$update_action = $this->MAcciones->update_simple($data_action);
		}
		
		// Actualizamos los nuevos datos del menú
        $result = $this->MMenus->update($this->input->post());
        
        if ($result) {
			// Ahora actualizamos la nueva acción (si tiene) y la asignamos 
			$data_action = array();
			$data_action['id'] = $this->input->post('action_id');
			$data_action['assigned'] = 1;
			if($this->input->post('action_id') != '0'){
				$update_action = $this->MAcciones->update_simple($data_action);
			}     
        }
    }
	// Método para eliminar
	function delete($id) {
		
		// Primero consultamos el identificador de la acción a sociada al submenú
		$id_menu = $id;
		$find_menu = $this->MMenus->obtenerMenu($id_menu);
		$data_action = array();
		$data_action['id'] = $find_menu[0]->action_id;
		$data_action['assigned'] = 0;
		
		// Eliminamos el menú
        $result = $this->MMenus->delete($id);
        //~ echo $result;
        if ($result) {
			// Actualizamos la acción para desasignarla (assigned=0)
			$update_action = $this->MAcciones->update_simple($data_action);
			
			// Quitamos el menú de la sesión
			$indice = 20;  // Variable para capturar el indice del arreglo que contenga el id del menú a eliminar
			// Le colocamos un número alto como valor por si no se encuentra el id en ninguno de los arreglos
			foreach($this->session->userdata['logged_in']['menus'][0] as $key => $menu){
				if($menu->id == $id){
					$indice = $key;
				}
			}
			// Quitamos el array correspondiente al menú con el indice obtenido
			unset($this->session->userdata['logged_in']['menus'][0][$indice]);
        }
    }
	
	// Método para cargar csv de iconos
	public function load_icons_csv(){
		$ruta = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
        $nombre_archivo = "iconos.csv";
        $ubicacion_archivo = $ruta."/application/views/menus/".$nombre_archivo;
        
        // Abrimos el archivo en modo de lectura
        $fp = fopen ($ubicacion_archivo,"r");
        
        while ($data = fgetcsv ($fp, 1000, ";")) {
			$num = count ($data);
			//~ print "";
			//~ echo $data[0].' -> '.$data[1];
			// Armamos un arreglo temporal para preparar la inserción de cada línea como un registro
			$data_icono = array('class'=>$data[0],'name'=>$data[1],'category'=>$data[2]);
			// Insertamos la línea como un nuevo icono
			$this->MMenus->insert_icons($data_icono);
		}
	}
	
}
