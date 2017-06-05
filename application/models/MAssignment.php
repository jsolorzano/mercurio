<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MAssignment extends CI_Model {


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    //Public method to obtain the services of the franchises
    public function obtener() {
        $query = $this->db->get('franchises_services');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to insert the data
    public function insert($datos) {
        
        $result = $this->db->where('franchise_id =', $datos['franchise_id']);
        $result = $this->db->where('service_id =', $datos['service_id']);
        $result = $this->db->get('franchises_services');
        if ($result->num_rows() > 0) {
            echo 'existe';
        } else {
            $result = $this->db->insert("franchises_services", $datos);
            $id = $this->db->insert_id();
            return $id;
        }
    }
    
    // Public method to insert the actions asociated
    public function insert_service($datos) {
		$result = $this->db->insert("franchises_services", $datos);
    }

    // Public method to obtain the services of the franchises by id
    public function obtenerServices($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('franchises_services');
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
    
    //Public method to obtain the actions asociated by franchise_id and service_id
    public function obtenerServiceFranchiseId($id_franchise, $id_service) {
		$this->db->where('franchise_id =', $id_franchise);
		$this->db->where('service_id =', $id_service);
        $query = $this->db->get('franchises_services');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to update a record
    public function update($datos) {
       
        $result = $this->db->where('franchise_id =', $datos['franchise_id']);
        $result = $this->db->where('service_id =', $datos['service_id']);
        $result = $this->db->where('id !=', $datos['id']);
        $result = $this->db->get('franchises_services');

        if ($result->num_rows() > 0) {
            echo '1';
        }else {
            $result = $this->db->where('id', $datos['id']);
            $result = $this->db->update('franchises_services', $datos);
            return $result;
        }
    }


    // Public method to delete a record
    public function delete($id) {
		
		// Primero buscamos los servicios asociados a la franquicia en la tabla 'franchises_services'
		$query_franchise_services = $this->obtenerServicesFranchiseId($id);
		if(count($query_franchise_services) > 0){
			foreach($query_franchise_services as $franchise_service){
				// Comprobamos que el id de la asignación no esté asociado a una orden de servicio
				$this->db->where('service_id =', $franchise_service->id);
				$result = $this->db->get('orders_services');

				if ($result->num_rows() > 0) {
					echo 'existe';
				} else {
					$result = $this->db->delete('franchises_services', array('id' => $franchise_service->id));
				}
			}
		}
       
    }
    
    // Public method to delete the services asociated 
    public function delete_franchise_service($id_franchise, $id_service) {
		$result = $this->db->delete('franchises_services', array('franchise_id' => $id_franchise, 'service_id' => $id_service));
    }
    

}
?>
