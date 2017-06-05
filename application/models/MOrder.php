<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MOrder extends CI_Model {


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    //Public method to obtain the orders services
    public function obtener() {
        $query = $this->db->get('orders');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    //Public method to obtain the orders services
    public function obtenerStatus() {
        $query = $this->db->get('status');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
      //Public method to obtain the row of the orders services
    public function obtenerRows() {
        
        $this->db->select("id");
        $query = $this->db->get('orders');
        if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)
			{
				$id = $row->id;
			}
			return $id;
		}else{
			$id = 1;
		}
    }
    
     // Metodo publico, para obtener las order_service por id
    public function obtenerServ($id) {
        $this->db->where('order_id', $id);
        $query = $this->db->get('orders_services');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
     // Metodo publico, para obtener las order_product por id
    public function obtenerProd($id) {
        $this->db->where('order_id', $id);
        $query = $this->db->get('orders_products');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    
    
    // Public method, to insert the data of orders
    public function insert($datos) {

            $result = $this->db->insert("orders", $datos);
            //return $result;
            $id = $this->db->insert_id();
            return $id;
        
    }
    
    //Public method to obtain the orders services
    public function getServices() {
        $query = $this->db->get('orders_services');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    //Public method to obtain the orders products
    public function getProducts() {
        $query = $this->db->get('orders_products');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Método público, forma de insertar los datos
    public function insertServ($datos) {
        $result = $this->db->where('service_id =', $datos['service_id']);
        $result = $this->db->where('order_id =', $datos['order_id']);
        $result = $this->db->get('orders_services');
        if ($result->num_rows() > 0) {
            echo 'existe';
        } else {
            $result = $this->db->insert("orders_services", $datos);
            return $result;
        }
    }
    
      // Método público, forma de insertar los datos
    public function insertProd($datos) {
        $result = $this->db->where('product_id =', $datos['product_id']);
        $result = $this->db->where('order_id =', $datos['order_id']);
        $result = $this->db->get('orders_products');
        if ($result->num_rows() > 0) {
            echo 'existe';
        } else {
            $result = $this->db->insert("orders_products", $datos);
            return $result;
        }
    }
    
        // Metodo publico, forma de actualizar los datos
    public function update($datos) {
        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->update("orders", $datos);
        return $result;        
    }
    
      // Metodo publico, forma de actualizar los datos
    public function updateServ($datos) {
        
        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->where('order_id', $datos['order_id']);
        $result = $this->db->update('orders_services', $datos);
        return $result;
        
    }
    
      // Metodo publico, forma de actualizar los datos
    public function updateProd($datos) {
        
        $result = $this->db->where('id', $datos['id']);
        $result = $this->db->where('order_id', $datos['order_id']);
        $result = $this->db->update('orders_products', $datos);
        return $result;
        
    }

	// Metodo publico, para obtener los order por id
    public function obtenerOrder($id) {
        
        $query = $this->db->from('orders or');
        //$query = $this->db->join('orders_services os', 'de.delito_id=dl.id', 'left');
        //$query = $this->db->join('orders_products op', 'de.estado_id=e.cod_estado', 'left');
        $query = $this->db->where('or.id=', $id);
        $query = $this->db->get();
        return $query->result();
    }
    

    
    // Metodo publico, para eliminar un registro 
     public function deleteServ($id) {
        
        $result = $this->db->delete('orders_services', array('id' => $id));
        return $result;
    }
    
     // Metodo publico, para eliminar un registro 
     public function deleteProd($id) {
        
        $result = $this->db->delete('orders_products', array('id' => $id));
        return $result;
    }
    
    
    // Metodo publico, para eliminar un registro 
     public function delete($id) {
        
        $result = $this->db->delete('orders_services', array('order_id' => $id));
        $result = $this->db->delete('orders_products', array('order_id' => $id));
        $result = $this->db->delete('orders', array('id' => $id));
       
        return $result;
    }


}
?>
