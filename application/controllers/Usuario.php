<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {
    public function __construct() {
        parent::__construct();
        permission();
        $this->load->library('session');
        $this->load->model('usuario_model');
        $this->load->model('login_model');
    }

    public function index() {
        $data['title'] = "Dados do Usuário";
        $data['user'] = $this->session->userdata("logged_user");

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/dados_usuario', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function update() {
        $usuario = $this->input->post();
        $usuario['senha'] = $this->login_model->gerarHash($usuario['senha']);

        try {
            $this->usuario_model->update($usuario);
            $status = 'success';
            $message = 'Usuário atualizado com sucesso!';
        }
        catch (Exception $erro) {
            $status = 'error';
            $message = 'Ocorreu um erro ao atualizar o usuário.';
        }
        
        redirect("usuario?status=$status&message=$message");
    }
}
?>