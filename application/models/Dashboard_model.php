<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function getEntradasDia() {
        // Total de vendas do dia
        $this->db->select_sum('total', 'total_vendas');
        $this->db->where('DATE(data)', date('Y-m-d'));
        $vendas = $this->db->get('Vendas')->row()->total_vendas;

        // Total de ordens de serviço do dia
        $this->db->select_sum('total', 'total_ordem_servico');
        $this->db->where('DATE(data)', date('Y-m-d'));
        $ordem_servico = $this->db->get('OrdemServico')->row()->total_ordem_servico;

        // Soma total de vendas e ordens de serviço
        return $vendas + $ordem_servico;
    }

    public function getSaidasDia() {
        $this->db->select('SUM(preco_compra * quantidade) AS total_saidas');
        $this->db->where('DATE(data)', date('Y-m-d'));
        $query = $this->db->get('Materiais');
        return $query->row()->total_saidas;
    }

    public function getSaldoMes() {
        // Total de vendas do mês
        $this->db->select_sum('total', 'total_vendas');
        $this->db->where('MONTH(data)', date('m'));
        $this->db->where('YEAR(data)', date('Y'));
        $vendas = $this->db->get('Vendas')->row()->total_vendas;

        // Total de serviços do mês
        $this->db->select_sum('valor', 'total_servicos');
        $this->db->where('MONTH(data_inicio)', date('m'));
        $this->db->where('YEAR(data_inicio)', date('Y'));
        $servicos = $this->db->get('Servicos')->row()->total_servicos;

        // Total de compras de materiais do mês
        $this->db->select('SUM(preco_compra * quantidade) AS total_compras');
        $this->db->where('MONTH(data)', date('m'));
        $this->db->where('YEAR(data)', date('Y'));
        $compras = $this->db->get('Materiais')->row()->total_compras;

        return ($vendas + $servicos) - $compras;
    }

    public function getVendasDia() {
        $this->db->where('DATE(data)', date('Y-m-d'));
        $this->db->from('Vendas');
        return $this->db->count_all_results();
    }

    public function getServicosDia() {
        $this->db->where('DATE(data_fim)', date('Y-m-d'));
        $this->db->from('Servicos');
        return ($this->db->count_all_results());
    }

    public function getMateriaisCadastrados() {
        return $this->db->count_all('Materiais');
    }

    public function getTotalFuncionarios() {
        return $this->db->count_all('Usuarios');
    }

    public function getTotalClientes() {
        return $this->db->count_all('Clientes');
    }

    public function getFaturamentoMensalVendas() {
        $this->db->select('DATE_FORMAT(data, "%Y-%m-%d") as data, SUM(total) as faturamento_mensal');
        $this->db->where('MONTH(data)', date('m'));
        $this->db->where('YEAR(data)', date('Y'));
        $this->db->group_by('DATE(data)');
        $this->db->order_by('data', 'ASC');
        $query = $this->db->get('Vendas');
        return $query->result_array();
    }

    public function getFaturamentoMensalServicos() {
        $this->db->select('DATE_FORMAT(data_inicio, "%Y-%m-%d") as data, SUM(valor) as faturamento_mensal');
        $this->db->where('MONTH(data_inicio)', date('m'));
        $this->db->where('YEAR(data_inicio)', date('Y'));
        $this->db->group_by('DATE(data_inicio)');
        $this->db->order_by('data_inicio', 'ASC');
        $query = $this->db->get('Servicos');
        return $query->result_array();
    }
}
?>
