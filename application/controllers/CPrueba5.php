<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CPrueba5 extends CI_Controller {

	public function __construct() {
        parent::__construct();


        $this->load->view('base');
		
    }
	
	public function index()
	{
		$this->load->view('pruebas/lista');
		$this->load->view('footer');
	}
	
}
