<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendas extends CI_Controller {
    public function __construct() {
        parent::__construct();
        permission();
        $this->load->model('vendas_model');
        $this->load->model('materiais_model');
        $this->load->model('clientes_model');
        $this->load->library('session');
    }

    public function index() {
        $data['title'] = "Vendas";
        $user = $this->session->userdata("logged_user");
        $nivel_acesso = $user['nivel_acesso']; 
        $data['table'] = "vendasTable";

        if ($nivel_acesso == 'admin') {
            // Usuário é administrador, mostrar todas as vendas
            $data["vendas"] = $this->vendas_model->get_all_vendas();
        } else {
            // Usuário comum, mostrar apenas as vendas dele
            $data["vendas"] = $this->vendas_model->get_vendas_by_user($user['email']);
        }
        
        $data['user'] = $user;
    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/vendas/vendas', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function new() {
        $data['title'] = "Adicionar Venda";
        $data['user'] = $this->session->userdata("logged_user");
        $data['materiais'] = $this->materiais_model->index();
        $data['clientes'] = $this->clientes_model->get_all(); // Buscar todos os clientes
    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/vendas/adicionar_venda', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js_vendas');
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function store() {
        $venda = $this->input->post();
        $venda['usuario'] = $this->session->userdata("logged_user")['email'];
        $venda['data'] = date('Y-m-d H:i:s');
    
        $materiais = $this->input->post('materiais');
        $quantidades = $this->input->post('quantidades');
        $precos = $this->input->post('precos');
    
        unset($venda['materiais'], $venda['quantidades'], $venda['precos']);
    
        $estoque_insuficiente = false;
        $materiais_insuficientes = [];
        $materiais_desabilitados = [];
    
        if (is_array($materiais) && is_array($quantidades) && is_array($precos)) {
            for ($i = 0; $i < count($materiais); $i++) {
                $material = $this->materiais_model->get_material($materiais[$i]);
                if ($quantidades[$i] > $material['quantidade']) {
                    $estoque_insuficiente = true;
                    $materiais_insuficientes[] = $materiais[$i];
                }
                if ($material['habilitado'] == 0) {
                    $materiais_desabilitados[] = $materiais[$i];
                }
            }
    
            if ($estoque_insuficiente) {
                $status = 'error';
                $message = 'Estoque insuficiente para um/ou mais materiais adicionados!';
            } elseif (!empty($materiais_desabilitados)) {
                $status = 'error';
                $message = 'Um/ou mais materiais estão desabilitados!';
            } else {
                $this->db->trans_start();
    
                if ($this->vendas_model->store($venda)) {
                    $id_venda = $this->db->insert_id();
                    for ($i = 0; $i < count($materiais); $i++) {
                        $venda_material = [
                            'id_venda' => $id_venda,
                            'id_material' => $materiais[$i],
                            'quantidade' => $quantidades[$i],
                            'preco_unitario' => $precos[$i],
                            'subtotal' => $quantidades[$i] * $precos[$i]
                        ];
                        $this->vendas_model->store_venda_material($venda_material);
                    }
                    $status = 'success';
                    $message = 'Venda adicionada com sucesso!';
                } else {
                    $status = 'error';
                    $message = 'Ocorreu um erro ao adicionar a venda.';
                }
    
                $this->db->trans_complete();
            }
        } else {
            $status = 'error';
            $message = 'Você deve adicionar pelo menos um material à venda.';
        }
    
        redirect("vendas/new?status=$status&message=$message");
    }


    public function show_materials($id_venda) {
        $data['title'] = "Materiais da Venda";
        $data['user'] = $this->session->userdata("logged_user");
        $data['materiais'] = $this->vendas_model->get_materiais_by_venda($id_venda);
        $data['table'] = "materiaisVendaTable";
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/vendas/materiais_venda', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function edit($id_venda) {
        $data['title'] = "Editar Venda";
        $data['user'] = $this->session->userdata("logged_user");
        $data['venda'] = $this->vendas_model->get_venda($id_venda);
        $data['materiais'] = $this->materiais_model->index();
        $data['clientes'] = $this->clientes_model->get_all();
        $data['materiais_venda'] = $this->vendas_model->get_materiais_by_venda($id_venda);
    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav_menu', $data);
        $this->load->view('templates/nav_top', $data);
        $this->load->view('pages/vendas/alterar_venda', $data);
        $this->load->view('templates/modal', $data);
        $this->load->view('templates/js_vendas', $data);
        $this->load->view('templates/js', $data);
        $this->load->view('templates/footer', $data);
    }

    public function update($id_venda) {
        $venda = $this->input->post();
        $venda['usuario'] = $this->session->userdata("logged_user")['email'];
    
        $materiais = $this->input->post('materiais');
        $quantidades = $this->input->post('quantidades');
        $precos = $this->input->post('precos');
    
        unset($venda['materiais'], $venda['quantidades'], $venda['precos']);
    
        $estoque_insuficiente = false;
        $materiais_insuficientes = [];
        $materiais_desabilitados = [];
    
        if (is_array($materiais) && is_array($quantidades) && is_array($precos)) {
            for ($i = 0; $i < count($materiais); $i++) {
                $material = $this->materiais_model->get_material($materiais[$i]);
                if ($quantidades[$i] > $material['quantidade']) {
                    $estoque_insuficiente = true;
                    $materiais_insuficientes[] = $materiais[$i];
                }
                if ($material['habilitado'] == 0) {
                    $materiais_desabilitados[] = $materiais[$i];
                }
            }
    
            if ($estoque_insuficiente) {
                $status = 'error';
                $message = 'Estoque insuficiente para um/ou mais materiais adicionados!';
            } elseif (!empty($materiais_desabilitados)) {
                $status = 'error';
                $message = 'Um/ou mais materiais estão desabilitados!';
            } else {
                $this->db->trans_start();
    
                if ($this->vendas_model->update($id_venda, $venda)) {
                    $this->vendas_model->delete_venda_material($id_venda);
                    for ($i = 0; $i < count($materiais); $i++) {
                        $venda_material = [
                            'id_venda' => $id_venda,
                            'id_material' => $materiais[$i],
                            'quantidade' => $quantidades[$i],
                            'preco_unitario' => $precos[$i],
                            'subtotal' => $quantidades[$i] * $precos[$i]
                        ];
                        $this->vendas_model->store_venda_material($venda_material);
                    }
                    $status = 'success';
                    $message = 'Venda atualizada com sucesso!';
                } else {
                    $status = 'error';
                    $message = 'Ocorreu um erro ao atualizar a venda.';
                }
    
                $this->db->trans_complete();
            }
        } else {
            $status = 'error';
            $message = 'Você deve adicionar pelo menos um material à venda.';
        }
    
        redirect("vendas/edit/$id_venda?status=$status&message=$message");
    }

    public function delete($id_venda) {
        $this->db->trans_start();

        // Deleta os materiais relacionados à venda
        $this->vendas_model->delete_venda_material($id_venda);

        // Deleta a venda
        if ($this->vendas_model->delete_venda($id_venda)) {
            $status = 'success';
            $message = 'Venda excluída com sucesso!';
        } else {
            $status = 'error';
            $message = 'Ocorreu um erro ao excluir a venda.';
        }

        $this->db->trans_complete();

        redirect("vendas?status=$status&message=$message");
    }
}