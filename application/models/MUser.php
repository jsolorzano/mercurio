<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MUser extends CI_Model {


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    // Public method to obtain the users
    public function obtener() {
        $query = $this->db->get('users');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Public method to obtain the permissions asociated
    public function obtener_permisos() {
        $query = $this->db->get('permissions');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Public method to obtain the permissions asociated by user_id
    public function obtener_permisos_id($id_user) {
		$this->db->where('user_id =', $id_user);
        $query = $this->db->get('permissions');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Public method to obtain the permissions asociated by user_id and module_id
    public function obtener_permiso_ids($id_user, $id_module) {
		$this->db->where('user_id =', $id_user);
		$this->db->where('module_id =', $id_module);
        $query = $this->db->get('permissions');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Public method to obtain the franchises assigned to user
    public function obtenerUsersFranchises() {
        $query = $this->db->get('users_franchises');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Public method to obtain the services of the franchises by franchise_id
    public function obtenerFranchisesUserId($id_user) {
        $this->db->where('user_id', $id_user);
        $query = $this->db->get('users_franchises');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }
    
    // Public method to obtain the permissions asociated by user_id and franchise_id
    public function obtenerUserFranchiseId($id_user, $id_franchise) {
		$this->db->where('user_id =', $id_user);
		$this->db->where('franchise_id =', $id_franchise);
        $query = $this->db->get('users_franchises');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to insert the data
    public function insert($datos) {
        $result = $this->db->where('username =', $datos['username']);
        $result = $this->db->get('users');
        if ($result->num_rows() > 0) {
            return 'existe';
        } else {
            $result = $this->db->insert("users", $datos);
            $id = $this->db->insert_id();
            return $id;
        }
    }
    
    // Public method to insert the franchise associated
    public function insert_franchise($datos) {
		$result = $this->db->insert("users_franchises", $datos);
		return $result;
    }
    
    // Public method to insert the module associated
    public function insert_module($datos) {
		$result = $this->db->insert("permissions", $datos);
		return $result;
    }
    
    // Public method to insert the modules asociated
    public function update_module($datos) {
		$this->db->where('user_id', $datos['user_id']);
		$this->db->where('module_id', $datos['module_id']);
		$result = $this->db->update('permissions', $datos);
		return $result;
    }

    // Public method to obtain the users by id
    public function obtenerUsers($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Public method to update a record 
    public function update($datos) {
        $result = $this->db->where('username =', $datos['username']);
        $result = $this->db->where('id !=', $datos['id']);
        $result = $this->db->get('users');

        if ($result->num_rows() > 0) {
            return 'existe';
        } else {
            $result = $this->db->where('id', $datos['id']);
            $result = $this->db->update('users', $datos);
            return $result;
        }
    }
    
    // Public method to update a record 
    public function update_status($datos) {
		$result = $this->db->where('id', $datos['id']);
		$result = $this->db->update('users', $datos);
		return $result;
	}

    // Public method to delete a record
     public function delete($id) {
        $result = $this->db->delete('users', array('id' => $id));
        return $result;
    }
    
    // Public method to delete the franchises asociated 
    public function delete_user_franchise($id_user, $id_franchise) {
		$result = $this->db->delete('users_franchises', array('user_id' => $id_user, 'franchise_id' => $id_franchise));
    }

    // Public method to delete the franchises asociated 
    public function delete_user_module($id_user, $id_module) {
		$result = $this->db->delete('permissions', array('user_id' => $id_user, 'module_id' => $id_module));
    }
    
    // Public method to obtain the modules asociated to profile_id
    public function search_profile_modules($id_profile)
    {
        $result = $this->db->where('profile_id', $id_profile);
        $result = $this->db->get('profile_modules');
        return $result->result();
    }
    
    // Public method to obtain the modules asociated to user_id
    public function search_permissions($id_user)
    {
        $result = $this->db->where('user_id', $id_user);
        $result = $this->db->get('permissions');
        return $result->result();
    }
    
    // Public method to obtain the modules not asociated to profile_id list
    public function search_modules($list_modules_ids)
    {
        $this->db->where_not_in('id',$list_modules_ids);
        $result = $this->db->get('modules');
        return $result->result();
    }
    
    // Public method to obtain the modules not asociated to user_id list
    public function search_modules2($list_modules_ids)
    {
        $this->db->where_in('id',$list_modules_ids);
        $result = $this->db->get('modules');
        return $result->result();
    }

}
?>
