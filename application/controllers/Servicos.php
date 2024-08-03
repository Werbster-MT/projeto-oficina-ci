<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        permission();
        $this->load->model('servicos_model');
        $this->load->model('clientes_model');
        $this->load->model('servicosinfo_model');
        $this->load->model('materiais_model');
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = "Ordem de Serviços";
        $user = $this->session->userdata("logged_user");
        $nivel_acesso = $user['nivel_acesso'];
        $data['user'] = $user;
        $data['table'] = "ordemServicosTable";

        if ($nivel_acesso == 'admin') {
            $data["ordem_servicos"] = $this->servicos_model->get_all_ordem_servicos();
        } else {
            $data["ordem_servicos"] = $this->servicos_model->get_ordem_servicos_by_user($user['email']);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/servicos/ordem_servicos', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function view($id_ordem_servico) {
        $data['title'] = "Detalhes da Ordem de Serviço";
        $data['user'] = $this->session->userdata("logged_user");
        $data['ordem_servico'] = $this->servicos_model->get_ordem_servico_by_id($id_ordem_servico);
        $data['servicos'] = $this->servicos_model->get_servicos_by_ordem_servico($id_ordem_servico);
        $data['materiais'] = $this->servicos_model->get_materiais_by_ordem_servico($id_ordem_servico);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/servicos/servicos_ordem_servico', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function new() {
        $data['title'] = "Adicionar Ordem de Serviço";
        $data['user'] = $this->session->userdata("logged_user");
        $data['clientes'] = $this->clientes_model->get_all();
        $data['servicos'] = $this->servicosinfo_model->get_all();
        $data['materiais'] = $this->materiais_model->index();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/servicos/adicionar_ordem_servico', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js_adicionar_ordem_servicos', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function store() {
        $ordem_servico = $this->input->post();
        $ordem_servico['usuario'] = $this->session->userdata("logged_user")['email'];
    
        $servicos_info_ids = $this->input->post('servicos');
        $datas_inicio = $this->input->post('datas_inicio');
        $datas_fim = $this->input->post('datas_fim');
        $materiais = $this->input->post('materiais');
        $quantidades = $this->input->post('quantidades');
        $precos = $this->input->post('precos');
    
        // Remover campos desnecessários da ordem de serviço
        unset($ordem_servico['servicos'], $ordem_servico['datas_inicio'], $ordem_servico['datas_fim'], $ordem_servico['materiais'], $ordem_servico['quantidades'], $ordem_servico['precos']);
    
        $this->db->trans_start();
    
        if ($this->servicos_model->store($ordem_servico)) {
            $id_ordem_servico = $this->db->insert_id();
    
            // Verificar duplicidade de serviços antes de inserir
            $servicos_validos = true;
            for ($i = 0; $i < count($servicos_info_ids); $i++) {
                $servico_info_id = $servicos_info_ids[$i];
                $data_inicio = $datas_inicio[$i];
                $data_fim = $datas_fim[$i];
    
                // Buscar o valor do serviço da tabela ServicosInfo
                $servico_info = $this->servicosinfo_model->get_by_id($servico_info_id);
                $servico_valor = $servico_info['valor'];
    
                // Verificar se o serviço já está associado a esta ordem de serviço
                if ($this->servicos_model->check_servico_duplicate($id_ordem_servico, $servico_info_id)) {
                    $servicos_validos = false;
                    break;
                }
    
                // Inserir na tabela Servicos
                $servico = [
                    'id_servico_info' => $servico_info_id,
                    'data_inicio' => $data_inicio,
                    'data_fim' => $data_fim,
                    'valor' => $servico_valor // Usar o valor do serviço buscado da tabela ServicosInfo
                ];
                $this->servicos_model->store_servico($servico);
                $id_servico = $this->db->insert_id();
    
                // Inserir na tabela OrdemServicoServico
                $ordem_servico_servico = [
                    'id_ordem_servico' => $id_ordem_servico,
                    'id_servico' => $id_servico
                ];
                $this->servicos_model->store_ordem_servico_servico($ordem_servico_servico);
            }
    
            if (!$servicos_validos) {
                $status = 'error';
                $message = 'Serviços duplicados encontrados.';
                $this->db->trans_rollback();
                redirect("servicos/new?status=$status&message=$message");
                return;
            }
    
            if (is_array($materiais) && is_array($quantidades) && is_array($precos) && count($materiais) > 0) {
                $materiais_validos = true;
    
                // Verificar se todos os materiais estão preenchidos corretamente
                for ($i = 0; $i < count($materiais); $i++) {
                    if (empty($materiais[$i]) || empty($quantidades[$i]) || empty($precos[$i])) {
                        $materiais_validos = false;
                        break;
                    }
                }
    
                if ($materiais_validos) {
                    // Verificar duplicidade antes de inserir
                    for ($i = 0; $i < count($materiais); $i++) {
                        $ordem_servico_material = [
                            'id_ordem_servico' => $id_ordem_servico,
                            'id_material' => intval($materiais[$i]),
                            'quantidade' => floatval($quantidades[$i]),
                            'preco_unitario' => floatval($precos[$i]),
                            'subtotal' => floatval($quantidades[$i]) * floatval($precos[$i])
                        ];
    
                        if ($this->servicos_model->check_material_duplicate($ordem_servico_material)) {
                            $status = 'error';
                            $message = 'Materiais duplicados encontrados.';
                            $this->db->trans_rollback();
                            redirect("servicos/new?status=$status&message=$message");
                            return;
                        }
    
                        $this->servicos_model->store_ordem_servico_material($ordem_servico_material);
                    }
                } else {
                    $status = 'error';
                    $message = 'Todos os campos de materiais devem ser preenchidos corretamente.';
                    $this->db->trans_rollback();
                    redirect("servicos/new?status=$status&message=$message");
                    return;
                }
            }
    
            $status = 'success';
            $message = 'Ordem de serviço adicionada com sucesso!';
        } else {
            $status = 'error';
            $message = 'Ocorreu um erro ao adicionar a ordem de serviço.';
            $this->db->trans_rollback();
            redirect("servicos/new?status=$status&message=$message");
            return;
        }
    
        $this->db->trans_complete();
    
        redirect("servicos/new?status=$status&message=$message");
    }
    
    
    public function edit($id) {
        $data['title'] = "Alterar Ordem de Serviço";
        $data['user'] = $this->session->userdata("logged_user");
        $data['ordem_servico'] = $this->servicos_model->get_ordem_servico_by_id($id);
        $data['servicos'] = $this->servicos_model->get_servicos_by_ordem_servico($id);
        $data['materiais'] = $this->servicos_model->get_materiais_by_ordem_servico($id);
        $data['clientes'] = $this->clientes_model->get_all();
        $data['servicos_info'] = $this->servicosinfo_model->get_all();
        $data['materiais_info'] = $this->materiais_model->index();
    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/servicos/alterar_ordem_servico', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js_alterar_ordem_servicos', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function update($id) {
        $ordem_servico = $this->input->post();
        $ordem_servico['usuario'] = $this->session->userdata("logged_user")['email'];
    
        $servicos_info_ids = $this->input->post('servicos');
        $datas_inicio = $this->input->post('datas_inicio');
        $datas_fim = $this->input->post('datas_fim');
        $materiais = $this->input->post('materiais');
        $quantidades = $this->input->post('quantidades');
        $precos = $this->input->post('precos');
    
        // Remover campos desnecessários da ordem de serviço
        unset($ordem_servico['servicos'], $ordem_servico['datas_inicio'], $ordem_servico['datas_fim'], $ordem_servico['materiais'], $ordem_servico['quantidades'], $ordem_servico['precos']);
    
        // Verificar se pelo menos um serviço foi selecionado
        if (!is_array($servicos_info_ids) || count($servicos_info_ids) === 0) {
            $status = 'error';
            $message = 'Pelo menos um serviço deve ser selecionado.';
            redirect("servicos/edit/$id?status=$status&message=$message");
            return;
        }
    
        $this->db->trans_start();
    
        // Atualizar a ordem de serviço
        if ($this->servicos_model->update_ordem_servico($id, $ordem_servico)) {
            // Excluir os serviços e materiais antigos relacionados à ordem de serviço
            $this->servicos_model->delete_servicos_by_ordem_servico($id);
            $this->servicos_model->delete_materiais_by_ordem_servico($id);
    
            // Adicionar os novos serviços
            $servicos_validos = true;
            for ($i = 0; $i < count($servicos_info_ids); $i++) {
                $servico_info_id = $servicos_info_ids[$i];
                $data_inicio = $datas_inicio[$i];
                $data_fim = $datas_fim[$i];
    
                // Buscar o valor do serviço da tabela ServicosInfo
                $servico_info = $this->servicosinfo_model->get_by_id($servico_info_id);
                $servico_valor = $servico_info['valor'];
    
                // Verificar se o serviço já existe para essa ordem de serviço
                if ($this->servicos_model->check_servico_duplicate($id, $servico_info_id)) {
                    $servicos_validos = false;
                    break;
                }
    
                // Inserir na tabela Servicos
                $servico = [
                    'id_servico_info' => $servico_info_id,
                    'data_inicio' => $data_inicio,
                    'data_fim' => $data_fim,
                    'valor' => $servico_valor // Usar o valor do serviço buscado da tabela ServicosInfo
                ];
                $this->servicos_model->store_servico($servico);
                $id_servico = $this->db->insert_id();
    
                // Inserir na tabela OrdemServicoServico
                $ordem_servico_servico = [
                    'id_ordem_servico' => $id,
                    'id_servico' => $id_servico
                ];
                $this->servicos_model->store_ordem_servico_servico($ordem_servico_servico);
            }
    
            if (!$servicos_validos) {
                $status = 'error';
                $message = 'Serviços duplicados encontrados.';
                $this->db->trans_rollback();
                redirect("servicos/edit/$id?status=$status&message=$message");
                return;
            }
    
            // Adicionar os novos materiais
            if (is_array($materiais) && is_array($quantidades) && is_array($precos) && count($materiais) > 0) {
                $materiais_validos = true;
    
                // Verificar se todos os materiais estão preenchidos corretamente
                for ($i = 0; $i < count($materiais); $i++) {
                    if (empty($materiais[$i]) || empty($quantidades[$i]) || empty($precos[$i])) {
                        $materiais_validos = false;
                        break;
                    }
                }
    
                if ($materiais_validos) {
                    // Verificar duplicidade antes de inserir
                    for ($i = 0; $i < count($materiais); $i++) {
                        $ordem_servico_material = [
                            'id_ordem_servico' => $id,
                            'id_material' => intval($materiais[$i]),
                            'quantidade' => floatval($quantidades[$i]),
                            'preco_unitario' => floatval($precos[$i]),
                            'subtotal' => floatval($quantidades[$i]) * floatval($precos[$i])
                        ];
    
                        if ($this->servicos_model->check_material_duplicate($ordem_servico_material)) {
                            $status = 'error';
                            $message = 'Materiais duplicados encontrados.';
                            $this->db->trans_rollback();
                            redirect("servicos/edit/$id?status=$status&message=$message");
                            return;
                        }
    
                        $this->servicos_model->store_ordem_servico_material($ordem_servico_material);
                    }
                } else {
                    $status = 'error';
                    $message = 'Todos os campos de materiais devem ser preenchidos corretamente.';
                    $this->db->trans_rollback();
                    redirect("servicos/edit/$id?status=$status&message=$message");
                    return;
                }
            }
    
            $status = 'success';
            $message = 'Ordem de serviço atualizada com sucesso!';
        } else {
            $status = 'error';
            $message = 'Ocorreu um erro ao atualizar a ordem de serviço.';
            $this->db->trans_rollback();
            redirect("servicos/edit/$id?status=$status&message=$message");
            return;
        }
        $this->db->trans_complete();
    
        redirect("servicos/edit/$id?status=$status&message=$message");
    }      

    public function delete($id) {
        $this->db->trans_start();
    
        $this->servicos_model->delete_servicos_by_ordem_servico($id);
        $this->servicos_model->delete_materiais_by_ordem_servico($id);
        $this->servicos_model->delete_ordem_servico($id);
    
        $this->db->trans_complete();
    
        $status = 'success';
        $message = 'Ordem de serviço excluída com sucesso!';
    
        redirect("servicos?status=$status&message=$message");
    }    
}
?>
