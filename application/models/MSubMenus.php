<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MSubMenus extends CI_Model {


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    //Método público para obterner los menús
    public function obtener() {
        $query = $this->db->get('submenus');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Método público, forma de insertar los datos
    public function insert($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->get('submenus');
        if ($result->num_rows() > 0) {
            return 'existe';
        } else {
            $result = $this->db->insert("submenus", $datos);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    // Método público, para obterner los datos de un menú según el id
    public function obtenerSubMenu($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('submenus');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Método público, para actualizar un registro 
    public function update($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->where('id !=', $datos['id']);
        $result = $this->db->get('submenus');

        if ($result->num_rows() > 0) {
            echo '1';
        } else {
            $result = $this->db->where('id', $datos['id']);
            $result = $this->db->update('submenus', $datos);
            return $result;
        }
    }


    // Método público, para eliminar un registro 
     public function delete($id) {
		$result = $this->db->delete('submenus', array('id' => $id));
		return $result;       
    }

}
?>
