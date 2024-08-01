<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct() {
		parent::__construct(); 
		$this->load->helper('url');
		$this->load->model('login_model');
	}

	public function index()
	{
		$dados["title"] = "Login - Oficina Auto";
		$this->load->view('templates/header', $dados);
		$this->load->view('pages/login', $dados);
		$this->load->view('templates/js'); 
	}

	public function enter() {
		$email = $_POST['email'];
		$senha = md5($_POST['senha']);
		$user     = $this->login_model->store($email, $senha);

		if($user){
			$this->session->set_userdata("logged_user", $user);
			
			if($user["nivel_acesso"] === "admin"){
				redirect("admin/dashboard");
			}elseif ($user["nivel_acesso"] === "vendedor"){
				redirect('vendas/vendas');
			}elseif($user["nivel_acesso"] === "mecanico"){
				redirect('servicos/servicos');
			}elseif($user["nivel_acesso"] === "almoxarifado"){
				redirect('materiais/materiais');
			}
		}else {
			$dados['login_error'] = "Email e/ou senha incorretos!"; 
			$dados["title"] = "Login - Oficina Auto";
			$this->load->view('templates/header', $dados);
			$this->load->view('pages/login', $dados);
			$this->load->view('templates/js'); 
		}
	}

	public function logout()
	{
		$this->session->unset_userdata("logged_user");
		redirect('login');
	}
}