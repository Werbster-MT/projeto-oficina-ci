<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materiais_model extends CI_Model {
    public function index() {
        $materiais = $this->db->get("Materiais")->result_array();
        return $materiais;
    }

    public function store($material) {
        return $this->db->insert("Materiais", $material);
    }
    
    public function update($id, $material) {
        $this->db->where('id_material', $id);
        return $this->db->update("Materiais", $material);
    }    

    public function get_habilitados() {
        $this->db->where('habilitado', 1);
        $materiais = $this->db->get("Materiais")->result_array();
        return $materiais;
    }

    public function get_quantidade($id_material) {
        $this->db->select('quantidade');
        $this->db->from('Materiais');
        $this->db->where('id_material', $id_material);
        $query = $this->db->get();
        return $query->row_array()['quantidade'];
    }

    public function get_material($id_material) {
        $this->db->select('*');
        $this->db->from('Materiais');
        $this->db->where('id_material', $id_material);
        $query = $this->db->get();
        return $query->row_array();
    }
}