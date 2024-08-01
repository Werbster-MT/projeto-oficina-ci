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

    public function get_material_by_id($id) {
        return $this->db->get_where("Materiais", ['id_material' => $id])->row_array();
    }
    
    public function update($id, $material) {
        $this->db->where('id_material', $id);
        return $this->db->update("Materiais", $material);
    }    
}