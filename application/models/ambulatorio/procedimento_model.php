<?php

class procedimento_model extends Model {

    var $_procedimento_tuss_id = null;
    var $_nome = null;
    var $_codigo = null;
    var $_grupo = null;
    var $_descricao = null;
    var $_tuss_id = null;
    var $_perc_medico = null;
    var $_qtde = null;
    var $_dencidade_calorica = null;
    var $_descricao_procedimento = null;
    var $_proteinas = null;
    var $_carboidratos = null;
    var $_entrega = null;
    var $_percentual = null;
    var $_medico = null;
    var $_sala_preparo = null;
    var $_revisao = null;
    var $_revisao_dias = null;

    function Procedimento_model($procedimento_tuss_id = null) {
        parent::Model();
        if (isset($procedimento_tuss_id)) {
            $this->instanciar($procedimento_tuss_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('procedimento_tuss_id,
                            nome,
                            codigo,
                            descricao,
                            grupo');
        $this->db->from('tb_procedimento_tuss');
        $this->db->where("ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('grupo ilike', "%" . $args['nome'] . "%");
            $this->db->where("ativo", 't');
            $this->db->orwhere('codigo ilike', "%" . $args['nome'] . "%");
            $this->db->where("ativo", 't');
        }

        return $this->db;
    }
    
    
    function listaresponsavelorcamento($orcamento_id) {
//        var_dump($paciente_id);die;
        $horario = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('o.nome');
        $this->db->from('tb_ambulatorio_orcamento ao');
        $this->db->join('tb_operador o', 'o.operador_id = ao.operador_cadastro', 'left');
        $this->db->where("ao.ambulatorio_orcamento_id", $orcamento_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    
    function listarorcamentosrecepcao($orcamento_id) {
//        var_dump($paciente_id);die;
        $horario = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('oi.ambulatorio_orcamento_item_id,
                            oi.data,
                            oi.orcamento_id,
                            oi.valor_total,
                            ao.paciente_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            pt.codigo,
                            pt.descricao_procedimento,
                            pt.grupo,
                            pt.nome as procedimento');
        $this->db->from('tb_ambulatorio_orcamento_item oi');
        $this->db->join('tb_ambulatorio_orcamento ao', 'ao.ambulatorio_orcamento_id = oi.orcamento_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = oi.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
//        $this->db->where('oi.empresa_id', $empresa_id);
        $this->db->where("oi.orcamento_id", $orcamento_id);
        $this->db->where("oi.ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listartuss($args = array()) {
        $this->db->select('tuss_id,
                            codigo,
                            ans,
                            descricao,
                            valor');
        $this->db->from('tb_tuss');
        $this->db->where("ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('descricao ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('codigo ilike', "%" . $args['nome'] . "%");
            $this->db->where("ativo", 't');
            $this->db->orwhere('ans ilike', "%" . $args['nome'] . "%");
            $this->db->where("ativo", 't');
        }
        return $this->db;
    }

    function listarprocedimentos() {
        $this->db->select('procedimento_tuss_id,
                            nome,
                            codigo,
                            descricao');
        $this->db->from('tb_procedimento_tuss');
        $this->db->where("ativo", 't');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoprodutovalor($procedimento_tuss_id) {
        $this->db->select('procedimento_tuss_id,
                            nome,
                            codigo,
                            descricao');
        $this->db->from('tb_procedimento_tuss');
        $this->db->where("procedimento_tuss_id", $procedimento_tuss_id);
        $this->db->where("ativo", 't');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoconveniovalor($procedimento_tuss_id) {
        $this->db->select('pc.procedimento_convenio_id,
                            pc.valortotal as valor,
                            pc.procedimento_tuss_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            ');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pc.procedimento_tuss_id", $procedimento_tuss_id);
        $this->db->orderby("pc.procedimento_convenio_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listargruposexame() {
        $this->db->select('ambulatorio_grupo_id,
                            nome,
                            ');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->where("tipo", 'EXAME');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listargruposatendimento() {
        $this->db->select('ambulatorio_grupo_id,
                            nome,
                            ');
        $this->db->from('tb_ambulatorio_grupo');
//        $this->db->where("tipo", 'CONSULTA');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listargruposconsulta() {
        $this->db->select('ambulatorio_grupo_id,
                            nome,
                            ');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->where("tipo", 'CONSULTA');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listargruposespecialidade() {
        $this->db->select('ambulatorio_grupo_id,
                            nome,
                            ');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->where("tipo", 'ESPECIALIDADE');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupos() {
        $this->db->select('ambulatorio_grupo_id,
                            nome,
                            ');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listargruposmatmed() {
        $this->db->select('ambulatorio_grupo_id,
                            nome,
                            tipo
                            ');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->where("(tipo = 'MEDICAMENTO' OR tipo ='MATERIAL')");
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioprocedimentos() {
        $this->db->select('procedimento_tuss_id,
                            nome,
                            codigo,
                            descricao,
                            grupo,
                            perc_medico,
                            qtde,
                            dencidade_calorica,
                            proteinas,
                            carboidratos,
                            lipidios,
                            kcal');
        $this->db->from('tb_procedimento_tuss');
        $this->db->where("ativo", 't');
        if ($_POST['grupo'] == "1") {
            $this->db->where('grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('grupo', $_POST['grupo']);
        }
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioprocedimentoconvenio() {
        $this->db->select('pt.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            pc.data_atualizacao,
                            pc.data_cadastro,
                            c.nome as convenio,
                            pc.valortotal');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pc.ativo", 't');
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        $this->db->orderby("pc.convenio_id");
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioprocedimentotuss() {

        $this->db->select('codigo,
                           descricao,
                           valor,
                           classificacao');
        $this->db->from('tb_tuss');
        $this->db->orderby('descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentostuss($procedimento_tuss_id) {
        $this->db->select('tuss_id,
                            descricao,
                            codigo,
                            valor_bri,
                            texto,
                            grupo_matmed,
                            classificacao,
                            valor');
        $this->db->from('tb_tuss');
        $this->db->where("tuss_id", $procedimento_tuss_id);
        $return = $this->db->get();
        return $return->result();
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
//        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoautocomplete($parametro = null) {
        $this->db->select('pt.procedimento_tuss_id,
                           pt.nome');
        $this->db->from('tb_procedimento_tuss pt');
        $this->db->where('pt.ativo', 'true');
        if ($parametro != null) {
            $this->db->where("(pt.nome ilike '%$parametro%' OR pt.codigo ilike '%$parametro%')");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentocirurgia2autocomplete($parametro = null, $parametro2 = null) {
        $this->db->select('pc.procedimento_convenio_id,
                           pc.valortotal,
                           pt.codigo,
                           pt.nome,
                           pt.procedimento_tuss_id,
                           pt.descricao');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pc.convenio_id', $parametro2);
        if ($parametro != null) {
            $this->db->where("(pt.nome ilike '%$parametro%' OR pt.codigo ilike '%$parametro%')");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function carregavalorprocedimentocirurgico($procedimento_id) {
        $this->db->select('valortotal');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentocirurgiaautocomplete($parametro = null) {
        $this->db->select('pc.procedimento_convenio_id,
                           pt.descricao');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pc.ativo', 'true');
        if ($parametro != null) {
            $this->db->where('pt.descricao ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarclassificacaotuss() {
        $this->db->select('tuss_classificacao_id,
                            nome');
        $this->db->from('tb_tuss_classificacao');
        $return = $this->db->get();
        return $return->result();
    }

    function excluirorcamentorecepcao($ambulatorio_orcamento_item_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_orcamento_item_id', $ambulatorio_orcamento_item_id);
        $this->db->update('tb_ambulatorio_orcamento_item');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluir($procedimento_tuss_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->update('tb_procedimento_tuss');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirprocedimentotuss($tuss_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('tuss_id', $tuss_id);
        $this->db->update('tb_tuss');
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
    function verificaexistenciaprocedimento($nome) {
        $this->db->select('procedimento_tuss_id');
        $this->db->from('tb_procedimento_tuss');
        $this->db->where('ativo', 't');
        $this->db->where('nome ', $nome);
        $return = $this->db->get();
        $result = $return->result();

        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    function gravar() {
        try {

            /* inicia o mapeamento no banco */
            $procedimento_tuss_id = $_POST['txtprocedimentotussid'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('tuss_id', $_POST['txtprocedimento']);
            $this->db->set('codigo', $_POST['txtcodigo']);
            $this->db->set('descricao', $_POST['txtdescricao']);
            if ($_POST['txtqtde'] != '') {
                $this->db->set('qtde', $_POST['txtqtde']);
            }
            if ($_POST['percentual'] != '') {
                $this->db->set('percentual', $_POST['percentual']);
            }
            if ($_POST['homecare'] != '') {
                $this->db->set('home_care', $_POST['homecare']);
            }
            if ($_POST['medico'] != '') {
                $this->db->set('medico', $_POST['medico']);
            }
            if ($_POST['descricao'] != '') {
                $this->db->set('descricao_procedimento', $_POST['descricao']);
            }
//            if ($_POST['observacao'] != '') {
//                $this->db->set('observacao_procedimento', $_POST['observacao']);
//            }
            if ($_POST['entrega'] != '') {
                $this->db->set('entrega', $_POST['entrega']);
            }

            if (isset($_POST['rev'])) {
                $this->db->set('revisao', 't');
                $this->db->set('revisao_dias', $_POST['dias']);
            } else {
                $this->db->set('revisao', 'f');
            }

            if (isset($_POST['salaPreparo'])) {
                $this->db->set('sala_preparo', 't');
            } else {
                $this->db->set('sala_preparo', 'f');
            }

            $this->db->set('grupo', $_POST['grupo']);
            if ($_POST['txtperc_medico'] != '') {
                $this->db->set('perc_medico', str_replace(",", ".", $_POST['txtperc_medico']));
            }
            
            if ($_POST['txtperc_revisor'] != '') {
                $this->db->set('valor_revisor', str_replace(",", ".", $_POST['txtperc_revisor']));
            }
            if ($_POST['percentual_revisor'] != '') {
            $this->db->set('percentual_revisor', $_POST['percentual_revisor']);
            }
//
//            if ($_POST['txtperc_promotor'] != '') {
//                $this->db->set('valor_promotor', str_replace(",", ".", $_POST['txtperc_promotor']));
//            }
//
//            $this->db->set('percentual_promotor', $_POST['percentual_promotor']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtprocedimentotussid'] == "") {// insert
                $nome = str_replace("     ", " ", $_POST['txtNome']);
                $nome = str_replace("    ", " ", $nome);
                $nome = str_replace("   ", " ", $nome);
                $nome = str_replace("  ", " ", $nome);
                if ($this->verificaexistenciaprocedimento($nome) == false) {
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_tuss');
                    $erro = $this->db->_error_message();
                    if (trim($erro) != "") // erro de banco
                        return -1;
                    else
                        $procedimento_tuss_id = $this->db->insert_id();
                }else {
                    return 0;
                }
            } else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $procedimento_tuss_id = $_POST['txtprocedimentotussid'];
                $this->db->where('procedimento_tuss_id', $procedimento_tuss_id);
                $this->db->update('tb_procedimento_tuss');
            }

            return $procedimento_tuss_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarempresas() {

        $this->db->select('empresa_id,
            razao_social,
            nome');
        $this->db->from('tb_empresa');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }
    
    function gravartuss() {
        try {

            /* inicia o mapeamento no banco */
            if ($_POST['txtvalorbri'] != "") {
                if ($_POST['tuss_id'] != "") {
                    $tuss_id = $_POST['tuss_id'];
                    $valor_bri =  str_replace(",", ".", str_replace(".", "", $_POST['txtvalorbri']));
                    
                    $sql = "UPDATE ponto.tb_procedimento_convenio pc
                            SET 
                            valorch= $valor_bri, valortotal= $valor_bri
                            FROM ponto.tb_procedimento_tuss pt, ponto.tb_tuss t
                            WHERE pc.procedimento_tuss_id = pt.procedimento_tuss_id
                            AND t.tuss_id = pt.tuss_id
                            AND t.tuss_id = $tuss_id";
                    $this->db->query($sql);
                }
                $this->db->set('valor_bri', str_replace(",", ".", str_replace(".", "", $_POST['txtvalorbri'])));
            }
            $this->db->set('descricao', $_POST['txtNome']);
            $this->db->set('codigo', $_POST['procedimento']);
            if ($_POST['classificaco'] != '') {
                $this->db->set('classificacao', $_POST['classificaco']);
            }
            if ($_POST['txtvalor'] != "") {
                $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['txtvalor'])));
            }

            if ($_POST['grupo'] != "") {
                $this->db->set('grupo_matmed', $_POST['grupo']);
            }
            $this->db->set('texto', $_POST['laudo']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['tuss_id'] == "") {
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_tuss');
                $erro = $this->db->_error_message();
            } else {
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $tuss_id = $_POST['tuss_id'];
                $this->db->where('tuss_id', $tuss_id);
                $this->db->update('tb_tuss');
            }


            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarajustevalores() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
                      
            $sql = "UPDATE ponto.tb_procedimento_tuss
                    SET perc_medico = {$_POST['txtperc_medico']}, percentual = '{$_POST['percentual']}'
                    WHERE grupo = '{$_POST['grupo']}' ";
            
            $this->db->query($sql);
            
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarprocedimentoconveniovalor($procedimento_tuss_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            var_dump((float)str_replace(".", "", str_replace(",", "", $_POST['valor']))); die;

            /* inicia o mapeamento no banco */
            $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->set('qtdech', 1);
            $this->db->set('qtdefilme', 0);
            $this->db->set('valorfilme', 0);
            $this->db->set('qtdeporte', 0);
            $this->db->set('valorporte', 0);
            $this->db->set('qtdeuco', 0);
            $this->db->set('valoruco', 0);
            $this->db->set('qtdech', 1);
            $this->db->set('valorch', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $this->db->set('valortotal', str_replace(",", ".", str_replace(".", "", $_POST['valor'])));
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_procedimento_convenio');

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirprocedimentoconveniovalor($procedimento_convenio_produto_valor_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('procedimento_convenio_id', $procedimento_convenio_produto_valor_id);
            $this->db->update('tb_procedimento_convenio');

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($procedimento_tuss_id) {

        if ($procedimento_tuss_id != 0) {
            $this->db->select('pt.nome, pt.codigo, pt.grupo, pt.tuss_id, 
                               pt.home_care, pt.descricao_procedimento, pt.entrega, 
                               pt.medico, pt.percentual,  t.descricao, pt.perc_medico,  pt.valor_promotor,  pt.percentual_promotor, 
                               pt.valor_revisor,  pt.percentual_revisor, 
                               pt.qtde, pt.dencidade_calorica, pt.proteinas, 
                               pt.carboidratos, pt.lipidios, pt.kcal,
                               pt.revisao, pt.sala_preparo, pt.revisao_dias');
            $this->db->from('tb_procedimento_tuss pt');
            $this->db->join('tb_tuss t', 't.tuss_id = pt.tuss_id', 'left');
            $this->db->where("procedimento_tuss_id", $procedimento_tuss_id);
            $query = $this->db->get();
            $return = $query->result();
//            echo '<pre>';
//            var_dump($return); die;
            $this->_procedimento_tuss_id = $procedimento_tuss_id;

            $this->_tuss_id = $return[0]->tuss_id;
            $this->_nome = $return[0]->nome;
            $this->_grupo = $return[0]->grupo;
            $this->_codigo = $return[0]->codigo;
            $this->_home_care = $return[0]->home_care;
            $this->_descricao = $return[0]->descricao;
            $this->_descricao_procedimento = $return[0]->descricao_procedimento;
            $this->_perc_medico = $return[0]->perc_medico;
            $this->_qtde = $return[0]->qtde;
            $this->_dencidade_calorica = $return[0]->dencidade_calorica;
            $this->_proteinas = $return[0]->proteinas;
            $this->_carboidratos = $return[0]->carboidratos;
            $this->_percentual = $return[0]->percentual;
            $this->_medico = $return[0]->medico;
            $this->_entrega = $return[0]->entrega;
            $this->_revisao_dias = $return[0]->revisao_dias;
            $this->_revisao = $return[0]->revisao;
            $this->_sala_preparo = $return[0]->sala_preparo;
            $this->_valor_promotor = $return[0]->valor_promotor;
            $this->_percentual_promotor = $return[0]->percentual_promotor;
            $this->_valor_revisor = $return[0]->valor_revisor;
            $this->_percentual_revisor = $return[0]->percentual_revisor;
        } else {
            $this->_procedimento_tuss_id = null;
        }
    }

}

?>
