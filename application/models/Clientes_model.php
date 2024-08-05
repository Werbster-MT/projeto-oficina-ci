<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {
    public function get_all() {
        $query = $this->db->get('Clientes');
        return $query->result_array();
    }
}
