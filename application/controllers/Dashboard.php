<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();
		permission();
		$this->load->library('session');
	}

	public function index()
	{   
		$data['title'] = "Dashboard - CodeIgniter.";
		$data['user'] = $this->session->userdata("logged_user");
		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav-menu', $data);
		$this->load->view('templates/nav-top', $data);
		$this->load->view('pages/admin/dashboard', $data);
		$this->load->view('templates/js', $data);
		$this->load->view('templates/footer', $data);
	}
}