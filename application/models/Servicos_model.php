<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos_model extends CI_Model {
    // Método para obter todas as ordens de serviço
    public function get_all_ordem_servicos() {
        $this->db->select('OrdemServico.*, Clientes.nome as cliente_nome, Clientes.id_cliente as cliente, GROUP_CONCAT(ServicosInfo.nome SEPARATOR ", ") as servicos');
        $this->db->from('OrdemServico');
        $this->db->join('Clientes', 'OrdemServico.cliente = Clientes.id_cliente', 'left');
        $this->db->join('OrdemServicoServico', 'OrdemServico.id_ordem_servico = OrdemServicoServico.id_ordem_servico', 'left');
        $this->db->join('Servicos', 'OrdemServicoServico.id_servico = Servicos.id_servico', 'left');
        $this->db->join('ServicosInfo', 'Servicos.id_servico_info = ServicosInfo.id_servico_info', 'left');
        $this->db->group_by('OrdemServico.id_ordem_servico');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Método para obter ordens de serviço por usuário
    public function get_ordem_servicos_by_user($email) {
        $this->db->select('OrdemServico.*, Clientes.nome as cliente_nome, Clientes.id_cliente as cliente, GROUP_CONCAT(ServicosInfo.nome SEPARATOR ", ") as servicos');
        $this->db->from('OrdemServico');
        $this->db->join('Clientes', 'OrdemServico.cliente = Clientes.id_cliente', 'left');
        $this->db->join('OrdemServicoServico', 'OrdemServico.id_ordem_servico = OrdemServicoServico.id_ordem_servico', 'left');
        $this->db->join('Servicos', 'OrdemServicoServico.id_servico = Servicos.id_servico', 'left');
        $this->db->join('ServicosInfo', 'Servicos.id_servico_info = ServicosInfo.id_servico_info', 'left');
        $this->db->where('OrdemServico.usuario', $email);
        $this->db->group_by('OrdemServico.id_ordem_servico');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ordem_servico_by_id($id_ordem_servico) {
        $this->db->select('OrdemServico.*, Clientes.nome as cliente_nome');
        $this->db->from('OrdemServico');
        $this->db->join('Clientes', 'OrdemServico.cliente = Clientes.id_cliente', 'left');
        $this->db->where('OrdemServico.id_ordem_servico', $id_ordem_servico);
        return $this->db->get()->row_array();
    }
    
    public function get_servicos_by_ordem_servico($id_ordem_servico) {
        $this->db->select('Servicos.*, ServicosInfo.nome as servico_nome');
        $this->db->from('OrdemServicoServico');
        $this->db->join('Servicos', 'OrdemServicoServico.id_servico = Servicos.id_servico', 'left');
        $this->db->join('ServicosInfo', 'Servicos.id_servico_info = ServicosInfo.id_servico_info', 'left');
        $this->db->where('OrdemServicoServico.id_ordem_servico', $id_ordem_servico);
        return $this->db->get()->result_array();
    }
    
    public function get_materiais_by_ordem_servico($id_ordem_servico) {
        $this->db->select('OrdemServicoMaterial.*, Materiais.nome as material_nome');
        $this->db->from('OrdemServicoMaterial');
        $this->db->join('Materiais', 'OrdemServicoMaterial.id_material = Materiais.id_material', 'left');
        $this->db->where('OrdemServicoMaterial.id_ordem_servico', $id_ordem_servico);
        return $this->db->get()->result_array();
    }

    // Método para inserir uma nova ordem de serviço
    public function store($ordem_servico) {
        return $this->db->insert('OrdemServico', $ordem_servico);
    }

    // Método para inserir um novo serviço
    public function store_servico($servico) {
        return $this->db->insert('Servicos', $servico);
    }

    // Método para inserir relação entre ordem de serviço e serviço
    public function store_ordem_servico_servico($ordem_servico_servico) {
        return $this->db->insert('OrdemServicoServico', $ordem_servico_servico);
    }

    // Método para inserir materiais na ordem de serviço
    public function store_ordem_servico_material($ordem_servico_material) {
        if (!$this->check_material_duplicate($ordem_servico_material)) {
            return $this->db->insert('OrdemServicoMaterial', $ordem_servico_material);
        } else {
            return false;
        }
    }    

    public function get_servico_by_info_and_ordem_servico($id_servico_info, $id_ordem_servico) {
        $this->db->select('Servicos.*');
        $this->db->from('Servicos');
        $this->db->join('OrdemServicoServico', 'Servicos.id_servico = OrdemServicoServico.id_servico', 'left');
        $this->db->where('Servicos.id_servico_info', $id_servico_info);
        $this->db->where('OrdemServicoServico.id_ordem_servico', $id_ordem_servico);
        return $this->db->get()->row_array();
    }
    
    public function update_servico($id_servico, $servico) {
        $this->db->where('id_servico', $id_servico);
        return $this->db->update('Servicos', $servico);
    }
    

    public function update_ordem_servico($id, $ordem_servico) {
        $this->db->where('id_ordem_servico', $id);
        return $this->db->update('OrdemServico', $ordem_servico);
    }
    
    public function delete_servicos_by_ordem_servico($id_ordem_servico) {
        // Primeiro, obtenha os IDs dos serviços relacionados à ordem de serviço
        $this->db->select('id_servico');
        $this->db->from('OrdemServicoServico');
        $this->db->where('id_ordem_servico', $id_ordem_servico);
        $servicos = $this->db->get()->result_array();
        
        // Exclua as relações da tabela OrdemServicoServico
        $this->db->where('id_ordem_servico', $id_ordem_servico);
        $this->db->delete('OrdemServicoServico');
        
        // Agora, verifique se os serviços ainda estão relacionados a outras ordens de serviço
        foreach ($servicos as $servico) {
            $this->db->select('id_ordem_servico');
            $this->db->from('OrdemServicoServico');
            $this->db->where('id_servico', $servico['id_servico']);
            $remaining = $this->db->get()->num_rows();
            
            if ($remaining == 0) {
                // Se não houver mais relações, exclua o serviço
                $this->db->where('id_servico', $servico['id_servico']);
                $this->db->delete('Servicos');
            }
        }
    }    

    public function delete_materiais_by_ordem_servico($id_ordem_servico) {
        $this->db->where('id_ordem_servico', $id_ordem_servico);
        return $this->db->delete('OrdemServicoMaterial');
    }
    
    public function delete_ordem_servico($id_ordem_servico) {
        $this->db->where('id_ordem_servico', $id_ordem_servico);
        return $this->db->delete('OrdemServico');
    }

    public function check_material_duplicate($ordem_servico_material) {
        $this->db->where('id_ordem_servico', $ordem_servico_material['id_ordem_servico']);
        $this->db->where('id_material', $ordem_servico_material['id_material']);
        $query = $this->db->get('OrdemServicoMaterial');
        return $query->num_rows() > 0;
    }

    public function check_servico_duplicate($id_ordem_servico, $id_servico_info) {
        $this->db->select('OrdemServicoServico.id_servico');
        $this->db->from('OrdemServicoServico');
        $this->db->join('Servicos', 'OrdemServicoServico.id_servico = Servicos.id_servico', 'left');
        $this->db->where('OrdemServicoServico.id_ordem_servico', $id_ordem_servico);
        $this->db->where('Servicos.id_servico_info', $id_servico_info);
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }
    
}
