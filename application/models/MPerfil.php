<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MPerfil extends CI_Model {


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    //Public method to obtain the profile
    public function obtener() {
        $query = $this->db->get('profile');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    //Public method to obtain the modules asociated
    public function obtener_modulos() {
        $query = $this->db->get('profile_modules');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    //Public method to obtain the modules asociated by id_profile
    public function obtener_modulos_id($id_profile) {
		$this->db->where('profile_id =', $id_profile);
        $query = $this->db->get('profile_modules');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    //Public method to obtain the modules asociated by profile_id and module_id
    public function obtener_modulo_ids($id_profile, $id_module) {
		$this->db->where('profile_id =', $id_profile);
		$this->db->where('module_id =', $id_module);
        $query = $this->db->get('profile_modules');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to insert the data
    public function insert($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->get('profile');
        if ($result->num_rows() > 0) {
            return 'existe';
        } else {
            $result = $this->db->insert("profile", $datos);
            $id = $this->db->insert_id();
            return $id;
        }
    }
    
    // Public method to insert the modules asociated
    public function insert_module($datos) {
		$result = $this->db->insert("profile_modules", $datos);
    }
    
    // Public method to insert the modules asociated
    public function update_module($datos) {
		$this->db->where('profile_id', $datos['profile_id']);
		$this->db->where('module_id', $datos['module_id']);
		$result = $this->db->update('profile_modules', $datos);
		return $result;
    }

    // Public method to obtain the profile by id
    public function obtenerPerfiles($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('profile');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to update a record 
    public function update($datos) {
        $result = $this->db->where('name =', $datos['name']);
        $result = $this->db->where('id !=', $datos['id']);
        $result = $this->db->get('profile');

        if ($result->num_rows() > 0) {
            return 'existe';
        } else {
            $result = $this->db->where('id', $datos['id']);
            $result = $this->db->update('profile', $datos);
            return $result;
        }
    }

    // Public method to delete a record 
    public function delete($id) {
        $result = $this->db->where('profile_id =', $id);
        $result = $this->db->get('users');

        if ($result->num_rows() > 0) {
            echo 'existe';
        } else {
			// Primero buscamos y eliminamos las modulos asociadas en la tabla 'profile_modules'
			$query_modules = $this->obtener_modulos_id($id);
			if(count($query_modules) > 0){
				foreach($query_modules as $module){
					$delete_module = $this->delete_module($module->id);
				}
			}
			// Eliminamos el perfil
            $result = $this->db->delete('profile', array('id' => $id));
            return $result;
        }
       
    }
    
    // Public method to delete the modules asociated 
    public function delete_module($id) {
		$result = $this->db->delete('profile_modules', array('id' => $id));
    }
    
    // Public method to delete the modules asociated 
    public function delete_profile_module($id_profile, $id_module) {
		$result = $this->db->delete('profile_modules', array('profile_id' => $id_profile, 'module_id' => $id_module));
    }
    

}
?>
