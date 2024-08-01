<?php

class Login_model extends CI_Model
{
	public function store($email, $senha)
	{
		$this->db->where("email", $email);
		$this->db->where("senha", $senha);
		$user = $this->db->get("Usuarios")->row_array();
		return $user;
	}
}