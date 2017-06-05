<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MMenus extends CI_Model {


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    // Método público para obterner los menús
    public function obtener() {
        $query = $this->db->get('menus');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Método público, forma de insertar los datos
    public function insert($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->get('menus');
        if ($result->num_rows() > 0) {
            return 'existe';
        } else {
            $result = $this->db->insert("menus", $datos);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    // Método público, para obterner los datos de un menú según el id
    public function obtenerMenu($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('menus');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Método público, para actualizar un registro 
    public function update($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->where('id !=', $datos['id']);
        $result = $this->db->get('menus');

        if ($result->num_rows() > 0) {
            echo '1';
        } else {
            $result = $this->db->where('id', $datos['id']);
            $result = $this->db->update('menus', $datos);
            return $result;
        }
    }

    // Método público, para eliminar un registro 
     public function delete($id) {
        $result = $this->db->where('menu_id =', $id);
        $result = $this->db->get('submenus');

        if ($result->num_rows() > 0) {
            echo 'existe';
        } else {
            $result = $this->db->delete('menus', array('id' => $id));
            return $result;
        }
       
    }
    
    // Método público para obterner los menús
    public function obtenerIconos() {
        $query = $this->db->get('icons');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Método de consulta de registros en la tabla de iconos (icons)
	public function search_icons(){
		$result = $this->db->get('icons');
		
        return $result->num_rows();
	}
	
	// Método de consulta de registros en la tabla de iconos (icons) por el campo clase (class)
	public function search_icons_class($class){
		$result = $this->db->where('class =', $class);
		$result = $this->db->get('icons');
		
        return $result;
	}
	
	// Método de inserción de registros en la tabla de iconos (icons)
	public function insert_icons($datos){
		$result = $this->db->where('class =', $datos['class']);
		$result = $this->db->get('icons');

        if ($result->num_rows() > 0) {
            return 'existe';
        } else {
            $result = $this->db->insert('icons', $datos);
            $id = $this->db->insert_id();
            return $id;
        }
	}
}
?>
