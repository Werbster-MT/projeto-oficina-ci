<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function index()
	{
		$dados["title"] = "Login - CodeIgniter";
		$this->load->view('pages/login', $dados);
	}
}