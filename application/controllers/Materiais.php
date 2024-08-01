<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Materiais extends CI_Controller {
    public function __construct() {
        parent::__construct();
        permission();
        $this->load->model('materiais_model'); // Certifique-se de que o caminho está correto
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = "Materiais";
        $data["materiais"] = $this->materiais_model->index();
        $data['user'] = $this->session->userdata("logged_user");

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav-menu', $data);
        $this->load->view('templates/nav-top', $data);
        $this->load->view('pages/materiais/materiais', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function new() {
        $data['title'] = "Adicionar Material";
        $data['user'] = $this->session->userdata("logged_user");

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav-menu', $data);
        $this->load->view('templates/nav-top', $data);
        $this->load->view('pages/materiais/adicionar_material', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function store() {
        $material = $this->input->post();
        $material['habilitado'] = ($material['quantidade'] <= 0) ? 0 : 1;
    
        if ($this->materiais_model->store($material)) {
            $status = 'success';
            $message = 'Material adicionado com sucesso!';
        } else {
            $status = 'error';
            $message = 'Ocorreu um erro ao adicionar o material.';
        }
    
        redirect("materiais/new?status=$status&message=$message");
    }

    public function edit($id) {
        $data['title'] = "Alterar Material";
        $data['user'] = $this->session->userdata("logged_user");
        $data['material'] = $this->materiais_model->get_material_by_id($id);
    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav-menu', $data);
        $this->load->view('templates/nav-top', $data);
        $this->load->view('pages/materiais/alterar_material', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function update($id) {
        $material = $this->input->post();
        if ($material['quantidade'] <= 0) {
            $material['habilitado'] = 0;
            $material['quantidade'] = 0;
        } else {
            $material['habilitado'] = 1;
        }

        if ($this->materiais_model->update($id, $material)) {
            $status = 'success';
            $message = 'Material alterado com sucesso!';
        } else {
            $status = 'error';
            $message = 'Ocorreu um erro ao alterar o material.';
        }
    
        redirect("materiais/edit/$id?status=$status&message=$message");
    }

    public function disable($id) {
        $material = ['habilitado' => 0];
    
        if ($this->materiais_model->update($id, $material)) {
            $status = 'success';
            $message = 'Material desabilitado com sucesso!';
        } else {
            $status = 'error';
            $message = 'Ocorreu um erro ao desabilitar o material.';
        }
    
        redirect("materiais?status=$status&message=$message");
    }

    public function enable($id) {
        $material = ['habilitado' => 1];
    
        if ($this->materiais_model->update($id, $material)) {
            $status = 'success';
            $message = 'Material habilitado com sucesso!';
        } else {
            $status = 'error';
            $message = 'Ocorreu um erro ao habilitar o material.';
        }
    
        redirect("materiais?status=$status&message=$message");
    }
}