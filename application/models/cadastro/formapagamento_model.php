<?php

class formapagamento_model extends Model {

    var $_forma_pagamento_id = null;
    var $_nome = null;
    var $_conta_id = null;
    var $_ajuste = null;
    var $_dia_receber = null;
    var $_tempo_receber = null;
    var $_credor_devedor = null;

    function Formapagamento_model($forma_pagamento_id = null) {
        parent::Model();
        if (isset($forma_pagamento_id)) {
            $this->instanciar($forma_pagamento_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('forma_pagamento_id,
                            nome, 
                            ');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listargrupo($args = array()) {
        $this->db->select('financeiro_grupo_id,
                            nome 
                            ');
        $this->db->from('tb_financeiro_grupo');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarforma() {
        $this->db->select('forma_pagamento_id,
                            nome');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupos() {
        $this->db->select('financeiro_grupo_id,
                            nome');
        $this->db->from('tb_financeiro_grupo');
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarformapagamentonogrupo($financeiro_grupo_id) {
        $this->db->select('fp.nome,
                           fp.forma_pagamento_id,
                           gf.grupo_formapagamento_id,
                           gf.grupo_id');
        $this->db->from('tb_grupo_formapagamento gf');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('gf.grupo_id', $financeiro_grupo_id);
        $this->db->where('gf.ativo', 'true');
        $this->db->where('fp.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcredordevedor() {
        $this->db->select('financeiro_credor_devedor_id,
                            razao_social');
        $this->db->from('tb_financeiro_credor_devedor');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarforma($forma_pagamento_id) {
        $this->db->select('forma_pagamento_id,
                            nome,
                            ajuste');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 'true');
        $this->db->where('forma_pagamento_id', "$forma_pagamento_id");
        $return = $this->db->get();
        return $return->result();
    }

    function buscargrupo($financeiro_grupo_id) {
        $this->db->select('financeiro_grupo_id,
                            nome');
        $this->db->from('tb_financeiro_grupo');
        $this->db->where('ativo', 'true');
        $this->db->where('financeiro_grupo_id', "$financeiro_grupo_id");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($forma_pagamento_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('forma_pagamento_id', $forma_pagamento_id);
        $this->db->update('tb_forma_pagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirformapagamentodogrupo($grupo_formapagamento_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('grupo_formapagamento_id', $grupo_formapagamento_id);
        $this->db->update('tb_grupo_formapagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirgrupo($grupo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('financeiro_grupo_id', $grupo_id);
        $this->db->update('tb_financeiro_grupo');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('grupo_id', $grupo_id);
        $this->db->update('tb_grupo_formapagamento');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravargruponome() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->insert('tb_financeiro_grupo');
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return $this->db->insert_id();
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravargrupoadicionar() {
        try {
            $this->db->select('forma_pagamento_id');
            $this->db->from('tb_grupo_formapagamento');
            $this->db->where('forma_pagamento_id', $_POST['formapagamento']);
            $this->db->where('grupo_id ', $_POST['grupo_id']);
            $return = $this->db->get();

            if (count($return->result()) == 0) {
                /* inicia o mapeamento no banco */
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('forma_pagamento_id', $_POST['formapagamento']);
                $this->db->set('grupo_id ', $_POST['grupo_id']);
                $this->db->insert('tb_grupo_formapagamento');
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('conta_id', $_POST['conta']);
            $this->db->set('ajuste', $_POST['ajuste']);

            $diareceber = $_POST['diareceber'];
            $temporeceber = $_POST['temporeceber'];
            if ($_POST['diareceber'] == '' || $_POST['diareceber'] < 0) {
                $diareceber = null;
            }
            if ($_POST['temporeceber'] == '' || $_POST['temporeceber'] < 0) {
                $temporeceber = null;
            }
            $this->db->set('credor_devedor', $_POST['credor_devedor']);
            $this->db->set('dia_receber', $diareceber);
            $this->db->set('tempo_receber', $temporeceber);
//            $this->db->set('ativo', 't');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtcadastrosformapagamentoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_forma_pagamento');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $forma_pagamento_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
//                $forma_pagamento_id = $_POST['txtcadastrosformapagamentoid'];
                $this->db->where('forma_pagamento_id', $forma_pagamento_id);
                $this->db->update('tb_forma_pagamento');
            }
            return $forma_pagamento_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($forma_pagamento_id) {

        if ($forma_pagamento_id != 0) {
            $this->db->select('forma_pagamento_id, nome, conta_id , ajuste , dia_receber , tempo_receber , credor_devedor');
            $this->db->from('tb_forma_pagamento');
            $this->db->where("forma_pagamento_id", $forma_pagamento_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_forma_pagamento_id = $forma_pagamento_id;
            $this->_nome = $return[0]->nome;
            $this->_conta_id = $return[0]->conta_id;
            $this->_ajuste = $return[0]->ajuste;
            $this->_dia_receber = $return[0]->dia_receber;
            $this->_tempo_receber = $return[0]->tempo_receber;
            $this->_credor_devedor = $return[0]->credor_devedor;
        } else {
            $this->_forma_pagamento_id = null;
        }
    }

}

?>
