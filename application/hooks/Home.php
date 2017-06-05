<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed'); 
class Home
{
	private $ci;
	public function __construct()
	{
		$this->ci =& get_instance();
		!$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
		!$this->ci->load->library('form_validation') ? $this->ci->load->library('form_validation') : false;
		!$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
	}	

	public function check_login()
	{
		echo "Datos sesión: ";
		print_r($this->ci->session->userdata());
		
		$this->ci->form_validation->set_rules('username', 'Username', 'required');
        $this->ci->form_validation->set_rules('password', 'Password', 'required');
        
        $this->ci->form_validation->set_message('Username', 'Ingrese su nombre de usuario');
        $this->ci->form_validation->set_message('Password', 'Ingrese su contraseña');
        
        if ($this->ci->form_validation->run() == FALSE) {
			echo "falso";
			//~ redirect('CLogin');
			//~ $this->ci->load->view('login_form');
		}else{
			echo "verdadero";
		}
		exit();
		//~ if($this->ci->session->userdata('id') == FALSE)
		//~ {
			//~ redirect(base_url('index.php/login'));
		//~ }
	}
}
/*
/end hooks/home.php
*/
