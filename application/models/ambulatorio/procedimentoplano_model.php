<?php

class procedimentoplano_model extends Model {

    var $_procedimento_convenio_id = null;
    var $_convenio_id = null;
    var $_convenio = null;
    var $_procedimento_tuss_id = null;
    var $_procedimento = null;
    var $_qtdech = null;
    var $_valorch = null;
    var $_qtdefilme = null;
    var $_valorfilme = null;
    var $_qtdeporte = null;
    var $_valorporte = null;
    var $_qtdeuco = null;
    var $_valoruco = null;
    var $_valortotal = null;

    function Procedimentoplano_model($procedimento_convenio_id = null) {
        parent::Model();
        if (isset($procedimento_convenio_id)) {
            $this->instanciar($procedimento_convenio_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('procedimento_convenio_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            pc.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            pc.valortotal,
                            pt.grupo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('c.nome ilike', $args['nome'] . "%");
        }
        if (isset($args['procedimento']) && strlen($args['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', $args['procedimento'] . "%");
        }
        if (isset($args['codigo']) && strlen($args['codigo']) > 0) {
            $this->db->where('pt.codigo ilike', $args['codigo'] . "%");
        }
        if (isset($args['grupo']) && strlen($args['grupo']) > 0) {
            $this->db->where('pt.grupo ilike', $args['grupo'] . "%");
        }
        return $this->db;
    }

    function listarautocompleteformapagamento($args = array()) {
        $this->db->select('forma_pagamento_id,
                           nome');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');

        if (isset($args['txtpagamento']) && strlen($args['txtpagamento']) > 0) {
            $this->db->where('nome ilike', "%" . $args['txtpagamento'] . "%");
        }

        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentopercentual($args = array()) {
        $this->db->select('pm.procedimento_percentual_medico_id,
                            pm.procedimento_tuss_id,
                            pm.medico,
                            o.nome as medico,
                            pt.nome,
                            pm.valor');
        $this->db->from('tb_procedimento_percentual_medico pm');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = pm.medico', 'left');
        $this->db->where("pm.ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('o.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['procedimento']) && strlen($args['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $args['procedimento'] . "%");
        }
        return $this->db;
    }

    function listarprocedimentogrupo($args = array()) {
//                $this->db->select('pm.procedimento_percentual_medico_id,
//                            pm.procedimento_tuss_id,
//                            pt.grupo as grupo,
//                            pt.nome as procedimento,
//                            c.nome as convenio');
//        $this->db->from('tb_procedimento_percentual_medico pm ');
//        $this->db->join('tb_procedimento_tuss pt', 'pm.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
//        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = pm.procedimento_tuss_id' , 'left');  
//        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id' , 'left');
//        $this->db->where("pm.ativo", 't');          
        $this->db->select('pm.procedimento_percentual_medico_id,
                            
                            pt.nome as procedimento,
                            c.nome as convenio,
                            pt.grupo as grupo,
                            ');
        $this->db->from('tb_procedimento_percentual_medico pm');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pm.ativo", 't');


        if (isset($args['convenio']) && strlen($args['convenio']) > 0) {
            $this->db->where('c.nome ilike', "%" . $args['convenio'] . "%");
        }
        if (isset($args['procedimento']) && strlen($args['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $args['procedimento'] . "%");
        }
        if (isset($args['grupo']) && strlen($args['grupo']) > 0) {
            $this->db->where('pt.grupo ilike', "%" . $args['grupo'] . "%");
        }
        return $this->db;
    }

    function listarmedicopercentual($procedimento_percentual_medico_id) {
        $this->db->select(' ppmc.procedimento_percentual_medico_convenio_id,
                            o.nome as medico,                            
                            ppmc.valor,
                            ppmc.percentual,
                            pt.nome as procedimento,
                            c.nome as convenio');
        $this->db->from('tb_procedimento_percentual_medico_convenio ppmc');
        $this->db->join('tb_procedimento_percentual_medico pm', 'pm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id ', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ppmc.medico', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ppmc.ativo", 't');
        $this->db->where('ppmc.procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
        if (isset($_POST['convenio']) && strlen($_POST['convenio']) > 0) {
            $this->db->where('c.nome ilike', "%" . $_POST['convenio'] . "%");
        }
        if (isset($_POST['procedimento']) && strlen($_POST['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $_POST['procedimento'] . "%");
        }
        if (isset($_POST['medico']) && strlen($_POST['medico']) > 0) {
            $this->db->where('o.nome ilike', "%" . $_POST['medico'] . "%");
        }

//        if (isset($_POST['valor']) && strlen($_POST['valor']) > 0) {
//            $this->db->where('ppmc.valor ilike', "%" . $_POST['valor'] . "%");
//        } 
        if (isset($_POST['valor']) && strlen($_POST['valor']) > 0) {
            $this->db->where('ppmc.valor', $_POST['valor']);
        }
        return $this->db;
    }

    function listarprocedimento() {
        $this->db->select('procedimento_tuss_id,
                            nome,
                            codigo');
        $this->db->from('tb_procedimento_tuss');
        $this->db->orderby('nome');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconvenio() {
        $this->db->select('convenio_id,
                            nome,');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupo() {
        $this->db->distinct();
        $this->db->select('ambulatorio_grupo_id, 
                            nome');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentos($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pc.procedimento_tuss_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->where("pt.grupo !=", 'CONSULTA');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarconveniomedico($medico_id) {
        $this->db->select('c.convenio_id,
                            c.nome,');
        $this->db->from('tb_ambulatorio_convenio_operador co');
        $this->db->join('tb_convenio c', 'c.convenio_id = co.convenio_id', 'left');
        $this->db->where("co.operador_id", $medico_id);
        $this->db->where("co.ativo", 't');
        $this->db->where("c.ativo", 't');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarmedicopercentual($procedimento_percentual_medico_convenio_id) {
        $this->db->select('mc.valor,
                            mc.percentual,
                            o.nome');
        $this->db->from('tb_procedimento_percentual_medico_convenio mc');
        $this->db->join('tb_operador o', 'o.operador_id = mc.medico', 'left');
        $this->db->where("mc.ativo", 't');
        $this->db->where("o.ativo", 't');
        $this->db->where("mc.procedimento_percentual_medico_convenio_id", $procedimento_percentual_medico_convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function novomedico($procedimento_percentual_medico_id) {
        $this->db->select('pm.procedimento_percentual_medico_id,
                            
                            pt.nome as procedimento,
                            c.nome as convenio,
                            pt.grupo as grupo,
                            ');
        $this->db->from('tb_procedimento_percentual_medico pm');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pm.ativo", 't');
        $this->db->where("pm.procedimento_percentual_medico_id ", $procedimento_percentual_medico_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarformapagamentoprocedimento() {

        //verifica se esse medico já está cadastrado nesse procedimento 
        $this->db->select('procedimento_convenio_pagamento_id');
        $this->db->from('tb_procedimento_convenio_pagamento');
        $this->db->where('procedimento_convenio_id', $_POST['procedimento_convenio_id']);
        $this->db->where('forma_pagamento_id', $_POST['txtpagamentoid']);
        $return = $this->db->get();
        $result = $return->result();

        if ($result != NULL) {
            return 2;
        }

        if ($result == NULL) {
            try {
                $this->db->set('procedimento_convenio_id', $_POST['procedimento_convenio_id']);
                $this->db->set('forma_pagamento_id', $_POST['txtpagamentoid']);
                $this->db->insert('tb_procedimento_convenio_pagamento');

                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return 0;
                else
                    return 1;
            } catch (Exception $exc) {
                return 0;
            }
        }
    }

    function gravarnovomedico($procedimento_percentual_medico_id) {

        //verifica se esse medico já está cadastrado nesse procedimento 
        $this->db->select('medico');
        $this->db->from('tb_procedimento_percentual_medico_convenio');
        $this->db->where('medico', $_POST['medico']);
        $this->db->where('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
        $return = $this->db->get();
        $result = $return->result();

        if ($result != NULL) {
            return 2;
        }

        if ($result == NULL) {
            try {

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                $this->db->set('medico', $_POST['medico']);
                $this->db->set('valor', $_POST['valor']);
                $this->db->set('percentual', $_POST['percentual']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('ativo', 't');
                $this->db->insert('tb_procedimento_percentual_medico_convenio');

                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return 0;
                else
                    return 1;
            } catch (Exception $exc) {
                return 0;
            }
        }
    }

    function gravareditarmedicopercentual($procedimento_percentual_medico_convenio_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('valor', $_POST['valor']);
            $this->db->set('percentual', $_POST['percentual']);
            $this->db->where("procedimento_percentual_medico_convenio_id", $procedimento_percentual_medico_convenio_id);
            $this->db->update('tb_procedimento_percentual_medico_convenio ');

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return false;
            else
                return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listarautocompletetuss($parametro = null) {
        $this->db->select('tuss_id,
                            codigo,
                            descricao,
                            ans');
        $this->db->from('tb_tuss');
        if ($parametro != null) {
            $this->db->where('codigo ilike', "%" . $parametro . "%");
            $this->db->orwhere('descricao ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($procedimento_convenio_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
        $this->db->update('tb_procedimento_convenio');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirpercentual($procedimento_percentual_medico_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
        $this->db->update('tb_procedimento_percentual_medico');

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
        $this->db->update('tb_procedimento_percentual_medico_convenio');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirmedicopercentual($procedimento_percentual_medico_convenio_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_percentual_medico_convenio_id', $procedimento_percentual_medico_convenio_id);
        $this->db->update('tb_procedimento_percentual_medico_convenio');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
    function gravar() {
        try {



            /* inicia o mapeamento no banco */
            $procedimento_convenio_id = $_POST['txtprocedimentoplanoid'];
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->set('qtdech', $_POST['qtdech']);
            $this->db->set('valorch', $_POST['valorch']);
            $this->db->set('qtdefilme', $_POST['qtdefilme']);
            $this->db->set('valorfilme', $_POST['valorfilme']);
            $this->db->set('qtdeporte', $_POST['qtdeporte']);
            $this->db->set('valorporte', $_POST['valorporte']);
            $this->db->set('qtdeuco', $_POST['qtdeuco']);
            $this->db->set('valoruco', $_POST['valoruco']);
            $this->db->set('valortotal', $_POST['valortotal']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtprocedimentoplanoid'] == "") {// insert
                $this->db->select('convenio_id');
                $this->db->from('tb_procedimento_convenio');
                $this->db->where('ativo', 't');
                $this->db->where("procedimento_tuss_id", $_POST['procedimento']);
                $this->db->where("convenio_id", $_POST['convenio']);
                $query = $this->db->get();
                $return = $query->result();
                $qtde = count($return);

                if ($qtde == 0) {
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_convenio');
                    $erro = $this->db->_error_message();
                    if (trim($erro) != "") // erro de banco
                        return -1;
                    else
                        $procedimento_convenio_id = $this->db->insert_id();
                }else {
                    return -1;
                }
            } else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
                $this->db->update('tb_procedimento_convenio');
            }

            return $servidor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpercentualmedico() {
        try {

            $grupo = $_POST['grupo'];
            $convenio = $_POST['covenio'];
            $medico = $_POST['medico'];
            $procediemento = $_POST['procedimento'];

            var_dump($convenio, $grupo, $procediemento, $medico);



            if ($grupo == "SELECIONE") {  // inicio grupo=selecione
                if ($medico == "TODOS") { // inicio grupo=selecione  medico=todos
                    $this->db->select('operador_id,
                                       nome');
                    $this->db->from('tb_operador');
                    $this->db->where('ativo', 't');
                    $this->db->where('medico', 't');
                    $return = $this->db->get();
                    $medicos = $return->result();
                    $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('medico', $operador);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_medico');

                    $procedimento_percentual_medico_id = $this->db->insert_id();

                    foreach ($medicos as $item) {
                        $operador = $item->operador_id;

                        /* inicia o mapeamento no banco */

                        $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                        $this->db->set('medico', $operador);
                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $percentual = $_POST['percentual'];
                        $this->db->set('percentual', $percentual);
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico_convenio');
                    }  // fim grupo=selecione  medico=todos
                } else {
                    /* inicia o mapeamento no banco */
                    $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('medico', $_POST['medico']);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_medico');

                    $procedimento_percentual_medico_id = $this->db->insert_id();
                    $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                    $this->db->set('medico', $_POST['medico']);
                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                    $percentual = $_POST['percentual'];
                    $this->db->set('percentual', $percentual);
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_medico_convenio');
                } // fim grupo=selecione
            } elseif ($grupo == "TODOS") {  // inicio grupo=todos 
                if ($procediemento == "") {
                    $this->db->select('distinct(pc.procedimento_tuss_id),                                       
                                        pc.convenio_id');
                    $this->db->from('tb_procedimento_convenio pc');
                    $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                    $this->db->where('pc.convenio_id', $convenio);
                    $this->db->where('pc.ativo', 't');
                    $this->db->where('pt.ativo', 't');
                    $return = $this->db->get();
                    $procedimentos = $return->result();

                    if ($medico == "TODOS") { // inicio grupo=todos medico=todos
                        $this->db->select('operador_id,
                                       nome');
                        $this->db->from('tb_operador');
                        $this->db->where('ativo', 't');
                        $this->db->where('medico', 't');
                        $return = $this->db->get();
                        $medicos = $return->result();


                        foreach ($procedimentos as $value) {
                            $dados = $this->retornaprocedimentoconvenioid($value->procedimento_tuss_id, $value->convenio_id);
                            $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('medico', $operador);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico');

                            $procedimento_percentual_medico_id = $this->db->insert_id();
                            foreach ($medicos as $item) {
                                $operador = $item->operador_id;

                                /* inicia o mapeamento no banco */

                                $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                                $this->db->set('medico', $operador);
                                $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                                $percentual = $_POST['percentual'];
                                $this->db->set('percentual', $percentual);
                                $horario = date("Y-m-d H:i:s");
                                $operador_id = $this->session->userdata('operador_id');
                                $this->db->set('data_cadastro', $horario);
                                $this->db->set('operador_cadastro', $operador_id);
                                $this->db->insert('tb_procedimento_percentual_medico_convenio');
                            }
                        }
                    } //fim grupo=todos medico=todos
                    else {
                        foreach ($procedimentos as $value) {
                            $dados = $this->retornaprocedimentoconvenioid($value->procedimento_tuss_id, $value->convenio_id);
                            /* inicia o mapeamento no banco */
                            $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('medico', $_POST['medico']);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico');

                            $procedimento_percentual_medico_id = $this->db->insert_id();
                            $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                            $this->db->set('medico', $_POST['medico']);
                            $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $percentual = $_POST['percentual'];
                            $this->db->set('percentual', $percentual);
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico_convenio');
                        }
                    }
                } elseif ($procediemento != "") {
                    if ($medico == "TODOS") { // inicio grupo=selecione  medico=todos
                        $this->db->select('operador_id,
                                       nome');
                        $this->db->from('tb_operador');
                        $this->db->where('ativo', 't');
                        $this->db->where('medico', 't');
                        $return = $this->db->get();
                        $medicos = $return->result();
                        $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('medico', $operador);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico');

                        $procedimento_percentual_medico_id = $this->db->insert_id();

                        foreach ($medicos as $item) {
                            $operador = $item->operador_id;

                            /* inicia o mapeamento no banco */

                            $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                            $this->db->set('medico', $operador);
                            $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $percentual = $_POST['percentual'];
                            $this->db->set('percentual', $percentual);
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico_convenio');
                        }  // fim grupo=selecione  medico=todos
                    } else {
                        /* inicia o mapeamento no banco */
                        $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('medico', $_POST['medico']);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico');

                        $procedimento_percentual_medico_id = $this->db->insert_id();
                        $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                        $this->db->set('medico', $_POST['medico']);
                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $percentual = $_POST['percentual'];
                        $this->db->set('percentual', $percentual);
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico_convenio');
                    }
                }
            } // fim grupo todos
            else { //inicio grupo especifico
                $this->db->select('distinct(pt.procedimento_tuss_id),
                                   pc.convenio_id');
                $this->db->from('tb_procedimento_convenio pc');
                $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                $this->db->where('pc.convenio_id', $convenio);
                $this->db->where('pt.grupo', $grupo);
                $this->db->where('pt.ativo', 't');
                $this->db->orderby("pt.procedimento_tuss_id");
                $return = $this->db->get();
                $procedimentos2 = $return->result();

                if ($medico == "TODOS") { // inicio grupo especifico  medico=todos
                    $this->db->select('operador_id,
                                       nome');
                    $this->db->from('tb_operador');
                    $this->db->where('ativo', 't');
                    $this->db->where('medico', 't');
                    $return = $this->db->get();
                    $medicos = $return->result();


                    foreach ($procedimentos2 as $value) {
                        $dados = $this->retornaprocedimentoconvenioid($value->procedimento_tuss_id, $value->convenio_id);

                        $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('medico', $operador);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico');

                        $procedimento_percentual_medico_id = $this->db->insert_id();
                        foreach ($medicos as $item) {
                            $operador = $item->operador_id;
                            /* inicia o mapeamento no banco */

                            $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                            $this->db->set('medico', $operador);
                            $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $percentual = $_POST['percentual'];
                            $this->db->set('percentual', $percentual);
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico_convenio');
                        }
                    }
                } // fim medico=todos
                else {
                    foreach ($procedimentos2 as $value) {
                        $dados = $this->retornaprocedimentoconvenioid($value->procedimento_tuss_id, $value->convenio_id);
                        /* inicia o mapeamento no banco */
                        $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('medico', $_POST['medico']);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico');

                        $procedimento_percentual_medico_id = $this->db->insert_id();
                        $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                        $this->db->set('medico', $_POST['medico']);
                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $percentual = $_POST['percentual'];
                        $this->db->set('percentual', $percentual);
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico_convenio');
                    }
                }
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $procedimento_id = $this->db->insert_id();


            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function retornaprocedimentoconvenioid($procedimento_tuss_id, $convenio_id) {
        $this->db->select('distinct(pc.procedimento_convenio_id)');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where('pc.convenio_id', $convenio_id);
        $this->db->where('pc.procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        $retorno = $return->result();
        return $retorno[0]->procedimento_convenio_id;
    }

    private function instanciar($procedimento_convenio_id) {

        if ($procedimento_convenio_id != 0) {
            $this->db->select('procedimento_convenio_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            pc.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pc.qtdech,
                            pc.valorch,
                            pc.qtdefilme,
                            pc.valorfilme,
                            pc.qtdeporte,
                            pc.valorporte,
                            pc.qtdeuco,
                            pc.valoruco,
                            pc.valortotal');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->where("pc.ativo", 't');
            $this->db->where("procedimento_convenio_id", $procedimento_convenio_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_procedimento_convenio_id = $procedimento_convenio_id;
            $this->_convenio_id = $return[0]->convenio_id;
            $this->_convenio = $return[0]->convenio;
            $this->_procedimento_tuss_id = $return[0]->procedimento_tuss_id;
            $this->_procedimento = $return[0]->procedimento;
            $this->_qtdech = $return[0]->qtdech;
            $this->_valorch = $return[0]->valorch;
            $this->_qtdefilme = $return[0]->qtdefilme;
            $this->_valorfilme = $return[0]->valorfilme;
            $this->_qtdeporte = $return[0]->qtdeporte;
            $this->_valorporte = $return[0]->valorporte;
            $this->_qtdeuco = $return[0]->qtdeuco;
            $this->_valoruco = $return[0]->valoruco;
            $this->_valortotal = $return[0]->valortotal;
        } else {
            $this->_procedimento_convenio_id = null;
            $this->_qtdech = 0;
            $this->_valorch = 0;
            $this->_qtdefilme = 0;
            $this->_valorfilme = 0;
            $this->_qtdeporte = 0;
            $this->_valorporte = 0;
            $this->_qtdeuco = 0;
            $this->_valoruco = 0;
        }
    }

}

?>
