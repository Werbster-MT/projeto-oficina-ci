<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();
		permission();
	}

	public function index()
	{   
		$data['title'] = "Dashboard - CodeIgniter.";
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/admin/dashboard', $data);
		$this->load->view('templates/footer', $data);
		$this->load->view('templates/js', $data);
	}
}