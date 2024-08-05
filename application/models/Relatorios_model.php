<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios_model extends CI_Model {
    public function getAllVendas() {
        $query = $this->db->get('Vendas');
        return $query->result_array();
    }

    public function getAllServicos() {
        $query = $this->db->get('Servicos');
        return $query->result_array();
    }

    public function getAllMateriais() {
        $query = $this->db->get('Materiais');
        return $query->result_array();
    }
}
?>
