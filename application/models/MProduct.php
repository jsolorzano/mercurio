<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MProduct extends CI_Model {


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    //Public method to obtain the products
    public function obtener() {
        $query = $this->db->get('products');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to insert the data
    public function insert($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->get('products');
        if ($result->num_rows() > 0) {
            echo '1';
        } else {
            $result = $this->db->insert("products", $datos);
            return $result;
        }
    }

    // Public method to obtain the products by id
    public function obtenerProducts($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to update a record  
    public function update($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->where('id !=', $datos['id']);
        $result = $this->db->get('products');

        if ($result->num_rows() > 0) {
            echo '1';
        } else {
            $result = $this->db->where('id', $datos['id']);
            $result = $this->db->update('products', $datos);
            return $result;
        }
    }


    // Public method to delete a record
     public function delete($id) {
        $result = $this->db->where('product_id =', $id);
        $result = $this->db->get('orders_services_products');

        if ($result->num_rows() > 0) {
            echo 'existe';
        } else {
            $result = $this->db->delete('products', array('id' => $id));
            return $result;
        }
       
    }
    

}
?>