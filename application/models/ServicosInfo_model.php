<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicosinfo_model extends CI_Model {
    public function get_all() {
        return $this->db->get('ServicosInfo')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('ServicosInfo', ['id_servico_info' => $id])->row_array();
    }
}