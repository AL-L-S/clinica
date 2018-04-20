<?php

class indicacao_model extends Model {

    var $_paciente_indicacao_id = null;
    var $_nome = null;

    function Indicacao_model($paciente_indicacao_id = null) {
        parent::Model();
        if (isset($paciente_indicacao_id)) {
            $this->instanciar($paciente_indicacao_id);
        }
    }

    function listargrupo($args = array()) {
        $this->db->select(' paciente_indicacao_grupo_id as grupo_id,
                            nome');
        $this->db->from('tb_paciente_indicacao_grupo pig');
        $this->db->where('ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('pig.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listar($args = array()) {
        $this->db->select('paciente_indicacao_id,
                           aml.nome,
                           aml.registro,
                           grupo_id,
                           pig.nome as grupo');
        $this->db->from('tb_paciente_indicacao aml');
        $this->db->join('tb_paciente_indicacao_grupo pig', 'pig.paciente_indicacao_grupo_id = aml.grupo_id', 'left');
        $this->db->where('aml.ativo', 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where("(aml.nome ilike '%". $args['nome']. "%' OR aml.registro ilike '%". $args['nome']. "%')");
        }
        if ( @$args['grupo_id'] != '') {
            $this->db->where('grupo_id',$args['grupo_id']);
        }
        return $this->db;
    }

    function listargrupoindicacao($args = array()) {
        $this->db->select(' paciente_indicacao_grupo_id as grupo_id,
                            nome');
        $this->db->from('tb_paciente_indicacao_grupo pig');
        $this->db->where('ativo', 't');
        $query = $this->db->get();
        return $query->result();
    }

    function carregargrupoindicacao($grupo_id) {
        $this->db->select(' paciente_indicacao_grupo_id as grupo_id,
                            nome');
        $this->db->from('tb_paciente_indicacao_grupo pig');
        $this->db->where('ativo', 't');
        $this->db->where('paciente_indicacao_grupo_id', $grupo_id);
        $query = $this->db->get();
        return $query->result();
    }

    function excluirgrupo($grupo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_indicacao_grupo_id', $grupo_id);
        $this->db->update('tb_paciente_indicacao_grupo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluir($paciente_indicacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('paciente_indicacao_id', $paciente_indicacao_id);
        $this->db->update('tb_paciente_indicacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravargrupo() {
        try {
            /* inicia o mapeamento no banco */
            $grupo_id = $_POST['grupo_id'];
            $this->db->set('nome', $_POST['txtNome']);
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            if ($grupo_id == "0" || $grupo_id == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_indicacao_grupo');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $paciente_indicacao_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_indicacao_grupo_id', $grupo_id);
                $this->db->update('tb_paciente_indicacao_grupo');
            }
            return $paciente_indicacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar() {
        try {
            
            if ($this->session->userdata('recomendacao_configuravel') == "t") {
                
                $result = array();
                if ($_POST['txtlaboratorio_id'] != ''){
                    $this->db->select('credor_devedor_id')->from('tb_paciente_indicacao')->where('paciente_indicacao_id', $_POST['paciente_indicacao_id']);
                    $result = $this->db->get()->result();
                }
                if (count($result) == 0 || @$result[0]->credor_devedor_id == '') {
                    $this->db->set('razao_social', $_POST['txtNome']);
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_financeiro_credor_devedor');
                    $credor_devedor_id = $this->db->insert_id();
                }
            
                if (count($result) == 0 || @$result[0]->credor_devedor_id == '') {
                    $this->db->set('credor_devedor_id', $credor_devedor_id);
                }
                if ($_POST['conta'] != "") {
                    $this->db->set('conta_id', $_POST['conta']);
                }
                $this->db->set('classe', $_POST['classe']);
                $this->db->set('tipo_id', $_POST['tipo']);
            }
            
            /* inicia o mapeamento no banco */
            $paciente_indicacao_id = $_POST['paciente_indicacao_id'];
            $this->db->set('registro', $_POST['registro']);
            $this->db->set('nome', $_POST['txtNome']);
            
            if($_POST['grupo_id'] != ''){
                $this->db->set('grupo_id', $_POST['grupo_id']);
            }
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            if ($_POST['paciente_indicacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_indicacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $paciente_indicacao_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_indicacao_id', $paciente_indicacao_id);
                $this->db->update('tb_paciente_indicacao');
            }
            return $paciente_indicacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }
    function gravarfinanceiro() {
        try {
            
            if ($this->session->userdata('recomendacao_configuravel') == "t") {
                
                if (@$_POST['criarcredor'] == "on") {
                    $this->db->set('razao_social', $_POST['txtNome']);
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_financeiro_credor_devedor');
                    $credor_devedor_id = $this->db->insert_id();
                }
            
                if ($_POST['conta'] != "") {
                    $this->db->set('conta_id', $_POST['conta']);
                }
                if (@$_POST['criarcredor'] == "on") {
                    $this->db->set('credor_devedor_id', $credor_devedor_id);
                } elseif ($_POST['credor_devedor'] != "") {
                    $this->db->set('credor_devedor_id', $_POST['credor_devedor']);
                }
                $this->db->set('classe', $_POST['classe']);
                $this->db->set('tipo_id', $_POST['tipo']);
            }
            
            /* inicia o mapeamento no banco */
            $paciente_indicacao_id = $_POST['paciente_indicacao_id'];
            $this->db->set('registro', $_POST['registro']);
            $this->db->set('nome', $_POST['txtNome']);
            
            if(@$_POST['grupo_id'] != ''){
                $this->db->set('grupo_id', $_POST['grupo_id']);
            }
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            if ($_POST['paciente_indicacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_paciente_indicacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $paciente_indicacao_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('paciente_indicacao_id', $paciente_indicacao_id);
                $this->db->update('tb_paciente_indicacao');
            }
            return $paciente_indicacao_id;
        } catch (Exception $exc) {
            return 2;
        }
    }

    private function instanciar($paciente_indicacao_id) {
        if ($paciente_indicacao_id != 0) {
            $this->db->select('paciente_indicacao_id,
                                aml.nome,
                                aml.registro,
                                grupo_id,
                                aml.credor_devedor_id,
                                aml.conta_id,
                                aml.classe,
                                aml.tipo_id');
            $this->db->from('tb_paciente_indicacao aml');
            $this->db->where("paciente_indicacao_id", $paciente_indicacao_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_paciente_indicacao_id = $paciente_indicacao_id;
            $this->_nome = $return[0]->nome;
            $this->_grupo_id = $return[0]->grupo_id;
            $this->_registro = $return[0]->registro;
            $this->_credor_devedor_id = $return[0]->credor_devedor_id;
            $this->_conta_id = $return[0]->conta_id;
            $this->_classe = $return[0]->classe;
            $this->_tipo_id = $return[0]->tipo_id;
        } else {
            $this->_paciente_indicacao_id = null;
        }
    }

}

?>
