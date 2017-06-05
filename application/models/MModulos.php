<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MModulos extends CI_Model {

	private $controladores = array();  // Variable que contendrá la lista de controladores
	
    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    // Método público para obterner las acciones
    public function obtener() {
        $query = $this->db->get('modules');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Método público para obterner las acciones que no sean HOME
    public function obtener_without_home() {
		$result = $this->db->where('class !=', 'Home');
        $query = $this->db->get('modules');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
	
	// Método público para obterner una lista de controladores
    function listar_controladores($ruta, $id)
    {
        // abrir un directorio y listarlo recursivo
        if (is_dir($ruta)) {
            if ($dh = opendir($ruta)) {
                while (($file = readdir($dh)) !== false) {
					//esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
					//mostraría tanto archivos como directorios
                    if ($file!="." && $file!=".."){
                        $controlador = str_replace('.php', '', $file);
                        $controllersbase = array('Home','Welcome','CLogin');  // Controladores a ignorar
                        if(!in_array($controlador, $controllersbase) && $controlador != 'index.html'){
							// Verificamos si el controlador ya está asignado a alguna acción
							$query_asigned = $this->db->get_where('modules', array('class'=>$controlador));
							if($query_asigned->num_rows() == 0){
								$this->controladores[] = $controlador;
							}
						}
                    }
                }
                closedir($dh);
                
                // Si el id viene cargado quiere decir que se está editando una acción, por lo que debemos incluir el controlador del mismo
                if($id != ''){
					// Consultamos el controlador con el id de la acción editada
					$query_action = $this->db->get_where('modules', array('id'=>$id));
					if($query_action->num_rows() > 0){
						$this->controladores[] = $query_action->result()[0]->class;
					}
				}
            }
        }else{
            echo "<br>No es ruta valida";
        }
        return $this->controladores;
    }
    
    // Método público para obterner las acciones no asignadas
    public function obtenerNoAsignadas() {
		$controllers = array('Home');  // Lista de controladores a los que se descartará de la vavlidación
		$result = $this->db->where('assigned', 0);
		$result = $this->db->where_not_in('class', $controllers);
        $query = $this->db->get('modules');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Método público para obterner las acciones no asignadas y la que pertenezca a un submenu específico
    public function obtenerNoAsignadasId($id) {
		$controllers = array('Home');  // Lista de controladores a los que se descartará de la vavlidación
		$result = $this->db->where('assigned', 0);
		$result = $this->db->where_not_in('class', $controllers);
		$result = $this->db->or_where('id', $id);
        $query = $this->db->get('modules');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Método público, forma de insertar los datos
    public function insert($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->get('modules');
        if ($result->num_rows() > 0) {
            echo '1';
        } else {
            $result = $this->db->insert("modules", $datos);
            return $result;
        }
    }

    // Método público, para obterner los datos de una acción según el id
    public function obtenerModulo($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('modules');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Método público, para obterner los datos de una acción según la clase
    public function obtenerModuloByClass($class) {
        $this->db->where('class', $class);
        $query = $this->db->get('modules');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Método público, para actualizar un registro 
    public function update($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->where('id !=', $datos['id']);
        $result = $this->db->get('modules');

        if ($result->num_rows() > 0) {
            echo '1';
        } else {
            $result = $this->db->where('id', $datos['id']);
            $result = $this->db->update('modules', $datos);
            return $result;
        }
    }
    
    // Método público, para actualizar un registro sin validaciones extra
    public function update_simple($datos) {
		$result = $this->db->where('id', $datos['id']);
		$result = $this->db->update('modules', $datos);
    }

    // Método público, para eliminar un registro 
    public function delete($id) {
        $result = $this->db->where('module_id =', $id);
        $result = $this->db->get('submenus');
        
        $result2 = $this->db->where('module_id =', $id);
        $result2 = $this->db->get('menus');
        
        $result3 = $this->db->where('module_id =', $id);
        $result3 = $this->db->get('profile_modules');

        if ($result->num_rows() > 0 || $result2->num_rows() > 0 || $result3->num_rows() > 0) {
            echo 'existe';
        } else {
            $result = $this->db->delete('modules', array('id' => $id));
            return $result;
        }
       
    }

}
?>
