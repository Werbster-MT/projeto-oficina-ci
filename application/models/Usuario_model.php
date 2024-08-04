<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
    public function store($data) {
        return $this->db->insert('Usuarios', $data);
    }

    public function getUser($email) {
        $query = $this->db->get_where('Usuarios', array('email' => $email));
        return $query->row();
    }

    public function update($usuario) {
        $this->db->where('email', $usuario['email']);
        return $this->db->update('Usuarios', $usuario);
    }
}
?>