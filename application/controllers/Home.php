<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Home extends CI_Controller {

    public function __construct() {
        @parent::__construct();
    }

	// Show login page
    public function home() {
		$this->load->view('base');
    }

}
