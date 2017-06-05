<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MFranchises extends CI_Model {


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    //Public method to obtain the franchises
    public function obtener() {
        $query = $this->db->get('franchises');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to insert the data
    public function insert($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->get('franchises');
        if ($result->num_rows() > 0) {
            return 'existe';
        } else {
            $result = $this->db->insert("franchises", $datos);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    // Public method to obtain the franchises by id
    public function obtenerFranchises($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('franchises');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Public method to obtain the services of the franchises by franchise_id
    public function obtenerServicesFranchiseId($id_franchise) {
        $this->db->where('franchise_id', $id_franchise);
        $query = $this->db->get('franchises_services');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to update a record 
    public function update($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->where('id !=', $datos['id']);
        $result = $this->db->get('franchises');

        if ($result->num_rows() > 0) {
            return 'existe';
        } else {
            $result = $this->db->where('id', $datos['id']);
            $result = $this->db->update('franchises', $datos);
            return $result;
        }
    }


    // Public method to delete a record
    public function delete($id) {
		 
        $result = $this->db->where('user_id =', $id);
        $result = $this->db->get('users_franchises');

        if ($result->num_rows() > 0) {
            echo 'existe';
        } else {
			// Primero buscamos y eliminamos los servicios asociados en la tabla 'franchises_services'
			$query_services = $this->obtenerServicesFranchiseId($id);
			if(count($query_services) > 0){
				$delete_services = $this->delete_services($id);
			}
			// Eliminamos la franquicia
            $result = $this->db->delete('franchises', array('id' => $id));
            return $result;
        }
       
    }
    
    // Public method to delete the services asociated 
    public function delete_services($id) {
		$result = $this->db->delete('franchises_services', array('franchise_id' => $id));
    } 

}
?>
