<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        permission();
        $this->load->library('session');
        $this->load->model('dashboard_model');
        $this->load->model('usuario_model');
        $this->load->model('login_model');
        $this->load->model('relatorios_model');
    }

    public function index() {
        $data['title'] = "Dashboard";
        $data['user'] = $this->session->userdata("logged_user");

        // Obtendo os dados do dashboard
        $data['entradas_dia'] = $this->dashboard_model->getEntradasDia();
        $data['saidas_dia'] = $this->dashboard_model->getSaidasDia();
        $data['saldo_mes'] = $this->dashboard_model->getSaldoMes();
        $data['vendas_dia'] = $this->dashboard_model->getVendasDia();
        $data['servicos_dia'] = $this->dashboard_model->getServicosDia();
        $data['materiais_cadastrados'] = $this->dashboard_model->getMateriaisCadastrados();
        $data['total_funcionarios'] = $this->dashboard_model->getTotalFuncionarios();
        $data['total_clientes'] = $this->dashboard_model->getTotalClientes();
        $data['faturamento_mensal_vendas'] = $this->dashboard_model->getFaturamentoMensalVendas();
        $data['faturamento_mensal_servicos'] = $this->dashboard_model->getFaturamentoMensalServicos();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/admin/dashboard', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function new() {
        $data['title'] = "Dashboard ";
        $data['user'] = $this->session->userdata("logged_user");

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/admin/adicionar_usuario', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function store() {
        $usuario = $this->input->post();
        $usuario['senha'] = $this->login_model->gerarHash($usuario['senha']);
        
        try {
            $this->usuario_model->store($usuario);
            $status = 'success';
            $message = 'Usuário adicionado com sucesso!';
        }
        catch (Exception $erro) {
            $status = 'error';
            $message = 'Ocorreu um erro ao adicionar o usuário.';
        }
    
        redirect("dashboard/new?status=$status&message=$message");
    }
}
?>