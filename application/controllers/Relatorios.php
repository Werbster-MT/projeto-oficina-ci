<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {
    public function __construct() {
        parent::__construct();
        permission();
        $this->load->library('session');
        $this->load->model('relatorios_model');
    }

    public function index() {
        $data['title'] = "Relatórios";
        $data['user'] = $this->session->userdata("logged_user");

        // Obtendo os dados necessários para os relatórios
        $data['vendas'] = $this->relatorios_model->getAllVendas();
        $data['servicos'] = $this->relatorios_model->getAllServicos();
        $data['materiais'] = $this->relatorios_model->getAllMateriais();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/admin/relatorios', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function download_pdf() {
        $this->load->library('pdf');

        // Dados para o relatório
        $data['vendas'] = $this->relatorios_model->getAllVendas();
        $data['servicos'] = $this->relatorios_model->getAllServicos();
        $data['materiais'] = $this->relatorios_model->getAllMateriais();

        // Carregar a view e gerar o PDF
        $html = $this->load->view('pages/admin/relatorio_pdf', $data, true);
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream("relatorio.pdf", array("Attachment"=>0));
    }
}
?>