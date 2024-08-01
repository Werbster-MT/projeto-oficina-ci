<?php

class Login_model extends CI_Model
{	
	// Função para criptografar a senha
    private function cripto($senha) {
        $c = '';
        // Loop através de cada caractere da senha
        for ($pos = 0; $pos < strlen($senha); $pos++) {
            $letra = ord($senha[$pos]) + 1; // Adiciona 1 ao código ASCII
            $c .= chr($letra); // Adiciona o caractere criptografado à string resultante
        }
        return $c; // Retorna a senha criptografada
    }

	// Função para verificar a senha contra o hash armazenado
    private function testarHash($senha, $hash) {
        // Verifica se a senha criptografada corresponde ao hash armazenado
        $ok = password_verify($this->cripto($senha), $hash);
        return $ok; // Retorna true se corresponder, false caso contrário
    }

	public function store($email, $senha)
	{
		$this->db->where("email", $email);
		$user = $this->db->get("Usuarios")->row_array();

		if ($this->testarHash($senha, $user['senha'])){
			return $user;
		}
		return null;
	}
}