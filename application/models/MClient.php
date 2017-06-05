<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MClient extends CI_Model {

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    //Metodo publico para obterner los clientes
    public function obtener() {
        $query = $this->db->get('customers');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    //Metodo publico para obterner los clientes
    public function clients() {
        $query = $this->db->select('id');
        $this->db->select("CONCAT(name, ' ', lastname) AS name");
        $query = $this->db->get('customers');
        $result = $this->db->where('status =', '1');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Metodo publico, forma de insertar los datos
    public function insert($datos) {
        $result = $this->db->where('username =', $datos['username']);
        $result = $this->db->get('customers');
        if ($result->num_rows() > 0) {
            $result = 'existe cliente';
            return $result;
        } else {
            $result = $this->db->insert("customers", $datos);
            //return $result;
            $id = $this->db->insert_id();
            return $id;
        }
    }

    // Metodo publico, forma de insertar los datos
    public function insertCars($datos) {
        $result = $this->db->where('license_plate =', $datos['license_plate']);
        $result = $this->db->get('vehicles');
        if ($result->num_rows() > 0) {
            $result = 'existe vehiculo';
            return $result;
        } else {
            $result = $this->db->insert("vehicles", $datos);
            return $result;
        }
    }

    // Metodo publico, forma de insertar los datos
    public function insertAddress($datos) {

        $result = $this->db->insert("addresses", $datos);
        return $result;
    }

    // Metodo publico, forma de actualizar los datos
    public function update($datos) {
        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->update("customers", $datos);
        return $result;
    }

    // Metodo publico, forma de actualizar los datos
    public function updateCars($datos) {
        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->update("vehicles", $datos);
        return $result;
    }

    // Metodo publico, forma de actualizar los datos
    public function updateAddress($datos) {

        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->where('customer_id', $datos['customer_id']);
        $result = $this->db->update('addresses', $datos);
        return $result;
    }

    // Metodo publico, para obterner los clientes por id
    public function obtenerClients($id) {
        $this->db->where('id', $id);
        $query = $this->db->select('id,username, name, lastname, profile_id, admin, status, phone, cell_phone');
        $query = $this->db->get('customers');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Metodo publico, para obterner las direcciones por cliente id
    public function obtenerAddress($id) {
        $this->db->where('customer_id', $id);
        $query = $this->db->get('addresses');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Metodo publico, para obterner los vehiculos por cliente id
    public function obtenerCars($id) {
        $this->db->where('customer_id', $id);
        $query = $this->db->get('vehicles');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to update a record 
    public function update_status($datos) {
        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->update('customers', $datos);
        return $result;
    }

    // Metodo publico, para eliminar un registro 
    public function deleteAddress($id) {
        
        
        $result = $this->db->where('address_service_id =', $id);
        $result = $this->db->get('orders');
        if ($result->num_rows() > 0) {
            echo('existe address');
  
        } else {
            $result = $this->db->delete('addresses', array('id' => $id));
            return $result;
        }

     
    }

    // Metodo publico, para eliminar un registro 
    public function deleteCars($id) {

        $result = $this->db->delete('vehicles', array('id' => $id));
        return $result;
    }

    // Metodo publico, forma de actualizar los datos
    public function pass($datos) {

        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->update('customers', $datos);
        return $result;
    }

}

?>