<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendas_model extends CI_Model {
    public function get_all_vendas() {
        $this->db->select('Vendas.*, Clientes.nome as cliente_nome');
        $this->db->from('Vendas');
        $this->db->join('Clientes', 'Vendas.id_cliente = Clientes.id_cliente', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_vendas_by_user($email) {
        $this->db->select('Vendas.*, Clientes.nome as cliente_nome');
        $this->db->from('Vendas');
        $this->db->join('Clientes', 'Vendas.id_cliente = Clientes.id_cliente', 'left');
        $this->db->where('Vendas.usuario', $email);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_venda($id_venda) {
        $this->db->select('Vendas.*, Clientes.nome as cliente_nome');
        $this->db->from('Vendas');
        $this->db->join('Clientes', 'Vendas.id_cliente = Clientes.id_cliente', 'left');
        $this->db->where('Vendas.id_venda', $id_venda);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function store($venda) {
        return $this->db->insert('Vendas', $venda);
    }

    public function store_venda_material($venda_material) {
        return $this->db->insert('VendaMaterial', $venda_material);
    }

    public function update($id_venda, $venda) {
        $this->db->where('id_venda', $id_venda);
        return $this->db->update('Vendas', $venda);
    }

    public function delete_venda_material($id_venda) {
        $this->db->where('id_venda', $id_venda);
        $this->db->delete('VendaMaterial');
    }

    public function get_materiais_by_venda($id_venda) {
        $this->db->select('VendaMaterial.*, Materiais.nome as material_nome');
        $this->db->from('VendaMaterial');
        $this->db->join('Materiais', 'VendaMaterial.id_material = Materiais.id_material', 'left');
        $this->db->where('VendaMaterial.id_venda', $id_venda);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_venda($id_venda) {
        $this->db->where('id_venda', $id_venda);
        return $this->db->delete('Vendas');
    }
}
