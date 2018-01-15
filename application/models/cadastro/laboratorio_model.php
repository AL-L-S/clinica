<?php

class Laboratorio_model extends Model {

    var $_laboratorio_id = null;
    var $_laboratorio_grupo_id = null;
    var $_nome = null;
    var $_razao_social = null;
    var $_cnpj = null;
    var $_logradouro = null;
    var $_municipio_id = null;
    var $_celular = null;
    var $_telefone = null;
    var $_tipo_logradouro_id = null;
    var $_numero = null;
    var $_bairro = null;
    var $_complemento = null;
    var $_ir = null;
    var $_pis = null;
    var $_cofins = null;
    var $_csll = null;
    var $_iss = null;
    var $_valor_base = null;
    var $_entrega = null;
    var $_pagamento = null;
    var $_cep = null;
    var $_observacao = null;
    var $_dinheiro = null;
    var $_procedimento1 = null;
    var $_procedimento2 = null;
    var $_tabela = null;
    var $_credor_devedor_id = null;
    var $_conta_id = null;
    var $_enteral = null;
    var $_parenteral = null;
    var $_registroans = null;
    var $_codigoidentificador = null;

    function Laboratorio_model($laboratorio_id = null) {
        parent::Model();
        if (isset($laboratorio_id)) {
            $this->instanciar($laboratorio_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('laboratorio_id,
                            nome,
                            associado,
                            associacao_laboratorio_id');
        $this->db->from('tb_laboratorio');
        $this->db->where("ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listardados() {
        $this->db->select('laboratorio_id,
                            nome,
                            dinheiro,
                            conta_id');
        $this->db->from('tb_laboratorio');
        $this->db->where("ativo", 't');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaboratorioscopiar($laboratorio_id) {
        $this->db->select('laboratorio_id,
                            nome,
                            dinheiro,
                            conta_id');
        $this->db->from('tb_laboratorio');
        $this->db->where("ativo", 't');
        $this->db->where("laboratorio_id !=", $laboratorio_id);
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarlaboratorios() {
        $this->db->select('laboratorio_id,
                            nome,
                            dinheiro,
                            conta_id');
        $this->db->from('tb_laboratorio');
        $this->db->where("ativo", 't');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaboratorioselecionado($laboratorio_id) {
        $this->db->select('laboratorio_id,
                            nome,
                            dinheiro,
                            conta_id');
        $this->db->from('tb_laboratorio');
//        $this->db->where("ativo", 't');
        $this->db->where("laboratorio_id", $laboratorio_id);
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listardadoscbhpm() {
        $this->db->select('laboratorio_id,
                            nome,
                            dinheiro,
                            conta_id');
        $this->db->from('tb_laboratorio');
        $this->db->where("ativo", 't');
        $this->db->where("(tabela = 'CBHPM' OR tabela = 'PROPRIA')");
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaboratoriodesconto($laboratorio_id) {
        $this->db->select('laboratorio_id,
                            nome');
        $this->db->from('tb_laboratorio');
        $this->db->where("ativo", 't');
        $this->db->where('laboratorio_id', $laboratorio_id);
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarforma() {
        $this->db->select('forma_entradas_saida_id,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcredordevedor() {
        $this->db->select('financeiro_credor_devedor_id,
                            razao_social,');
        $this->db->from('tb_financeiro_credor_devedor');
        $this->db->orderby('razao_social');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupos() {
        $this->db->select('ambulatorio_grupo_id,
                            nome,');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarassociacoeslaboratorio($laboratorio_id) {
        $this->db->select('laboratorio_secudario_associacao_id,
                           laboratorio_secundario_id,
                           laboratorio_primario_id,
                           valor_percentual,
                           grupo');
        $this->db->from('tb_laboratorio_secudario_associacao');
        $this->db->where("laboratorio_secundario_id", $laboratorio_id);
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listardadoslaboratorios() {
        $this->db->select('laboratorio_id,
                            nome');
        $this->db->from('tb_laboratorio');
        $this->db->where("ativo", 't');
        if ($_POST['laboratorio'] != "0" && $_POST['laboratorio'] != "" && $_POST['laboratorio'] != "-1") {
            $this->db->where("laboratorio_id", $_POST['laboratorio']);
        }
        if ($_POST['laboratorio'] == "") {
            $this->db->where("dinheiro", "f");
        }
        if ($_POST['laboratorio'] == "-1") {
            $this->db->where("dinheiro", "t");
        }
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentolaboratorioodontograma($laboratorio_id) {
        $this->db->select(' pc.procedimento_laboratorio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_laboratorio pc');
        $this->db->join('tb_laboratorio c', 'c.laboratorio_id = pc.laboratorio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("pt.grupo", 'ODONTOLOGIA');
        $this->db->where("ag.tipo", 'ESPECIALIDADE');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.laboratorio_id', $laboratorio_id);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaboratorionaodinheiro() {
        $this->db->select('laboratorio_id,
                            nome');
        $this->db->from('tb_laboratorio');
        $this->db->where("ativo", 't');
        $this->db->where("dinheiro", 'f');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($laboratorio_id) {
        $this->db->select('laboratorio_secudario_associacao_id');
        $this->db->from('tb_laboratorio_secudario_associacao');
        $this->db->where("ativo", 't');
        $this->db->where("laboratorio_primario_id", $laboratorio_id);
        $return = $this->db->get();
        $return = $return->result();

        if (count($return) == 0) {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('laboratorio_id', $laboratorio_id);
            $this->db->update('tb_laboratorio');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('laboratorio_id', $laboratorio_id);
            $this->db->update('tb_procedimento_laboratorio');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return $laboratorio_id;
        } else {
            return -2;
        }
    }

    function gravardesconto() {


        $ajustech = $_POST['ajustech'] / 100;
        $ajustefilme = $_POST['ajustefilme'] / 100;
        $ajusteporte = $_POST['ajusteporte'] / 100;
        $ajusteuco = $_POST['ajusteuco'] / 100;
        $ajustetotal = $_POST['ajustetotal'] / 100;
//        $ajustetotal = $_POST['ajustetotal'] / 100;
        $laboratorioid = $_POST['laboratorio'];
        $operador_id = $this->session->userdata('operador_id');
        $data = date('Y-m-d H:i:s');
//        var_dump($data);
//        die; 
        try {

            if ($_POST['grupo'] != 'TODOS') {
                $this->db->select('procedimento_tuss_id');
                $this->db->from('tb_procedimento_tuss');
                $this->db->where('grupo', $_POST['grupo']);
                $this->db->where('ativo', 't');
                $return = $this->db->get();
                $result = $return->result();

                foreach ($result as $value) {
                    $procedimento_tuss_id = $value->procedimento_tuss_id;
                    if (empty($_POST['arrendondamento'])) { // verifica se é pra arredondar para o interiro mais próximo
                        $sql = "update ponto.tb_procedimento_laboratorio
                    set valorch = (valorch * $ajustech) + valorch, 
                    valorfilme = (valorfilme * $ajustefilme) + valorfilme,
                    valorporte = (valorporte * $ajusteporte) + valorporte,                        
                    valoruco = (valoruco * $ajusteuco) + valoruco,
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where laboratorio_id = $laboratorioid and procedimento_tuss_id = $procedimento_tuss_id;";
                        $this->db->query($sql);
                        if ($_POST['ajustetotal'] == '') {
                            $sqll = "update ponto.tb_procedimento_laboratorio
                      set valortotal = (valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco)
                      where laboratorio_id = $laboratorioid and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        } else {
                            $sqll = "update ponto.tb_procedimento_laboratorio
                      set valortotal = (valortotal * $ajustetotal) + valortotal
                      where laboratorio_id = $laboratorioid and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        }
                    } else {
                        $sql = "update ponto.tb_procedimento_laboratorio
                    set valorch = ROUND((valorch * $ajustech) + valorch), 
                    valorfilme = ROUND((valorfilme * $ajustefilme) + valorfilme),
                    valorporte = ROUND((valorporte * $ajusteporte) + valorporte),                        
                    valoruco = ROUND((valoruco * $ajusteuco) + valoruco),
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where laboratorio_id = $laboratorioid and procedimento_tuss_id = $procedimento_tuss_id;";
                        $this->db->query($sql);
                        if ($_POST['ajustetotal'] == '') {
                            $sqll = "update ponto.tb_procedimento_laboratorio
                      set valortotal = ROUND((valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco))
                      where laboratorio_id = $laboratorioid and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        } else {
                            $sqll = "update ponto.tb_procedimento_laboratorio
                      set valortotal = ROUND((valortotal * $ajustetotal) + valortotal)
                      where laboratorio_id = $laboratorioid and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        }
                    }
                }
            } else {
                if (empty($_POST['arrendondamento'])) { // verifica se é pra arredondar para o interiro mais próximo
                    $sql = "update ponto.tb_procedimento_laboratorio
                    set valorch = (valorch * $ajustech) + valorch, 
                    valorfilme = (valorfilme * $ajustefilme) + valorfilme,
                    valorporte = (valorporte * $ajusteporte) + valorporte,                        
                    valoruco = (valoruco * $ajusteuco) + valoruco,
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where laboratorio_id = $laboratorioid;";
                    $this->db->query($sql);

                    if ($_POST['ajustetotal'] == '') {
                        $sqll = "update ponto.tb_procedimento_laboratorio
                      set valortotal = (valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco)
                      where laboratorio_id = $laboratorioid;";
                        $this->db->query($sqll);
                    } else {
                        $sqll = "update ponto.tb_procedimento_laboratorio
                      set valortotal = (valortotal * $ajustetotal) + valortotal
                      where laboratorio_id = $laboratorioid;";
                        $this->db->query($sqll);
                    }
                } else {
                    $sql = "update ponto.tb_procedimento_laboratorio
                    set valorch = ROUND((valorch * $ajustech) + valorch), 
                    valorfilme = ROUND((valorfilme * $ajustefilme) + valorfilme),
                    valorporte = ROUND((valorporte * $ajusteporte) + valorporte),                        
                    valoruco = ROUND((valoruco * $ajusteuco) + valoruco),
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where laboratorio_id = $laboratorioid;";
                    $this->db->query($sql);

                    if ($_POST['ajustetotal'] == '') {
                        $sqll = "update ponto.tb_procedimento_laboratorio
                      set valortotal = ROUND((valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco))
                      where laboratorio_id = $laboratorioid;";
                        $this->db->query($sqll);
                    } else {
                        $sqll = "update ponto.tb_procedimento_laboratorio
                      set valortotal = ROUND((valortotal * $ajustetotal) + valortotal)
                      where laboratorio_id = $laboratorioid;";
                        $this->db->query($sqll);
                    }
                }
            }


            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarajustelaboratoriosecundario($laboratorio_id) {
        $operador_id = $this->session->userdata('operador_id');
        $data = date('Y-m-d H:i:s');
        try {
            /* TRAZENDO CONVENIOS SECUNDARIOS */
            $this->db->select('laboratorio_secundario_id, grupo, valor_percentual');
            $this->db->from('tb_laboratorio_secudario_associacao csa');
            $this->db->where('csa.ativo', 't');
            $this->db->where('csa.laboratorio_primario_id', $laboratorio_id);
            if ($_POST['grupo'] != 'TODOS') {
                $this->db->where('csa.grupo', $_POST['grupo']);
            }
            $conv_sec = $this->db->get();
            $conv_sec = $conv_sec->result();

            // Verifica se há laboratorios secundarios associados
            if (count($conv_sec) > 0) {

                // Traz todos os procedimentos do laboratorio principal
                $this->db->select('pc.*, pt.grupo');
                $this->db->from('tb_procedimento_laboratorio pc');
                $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                if ($_POST['grupo'] != 'TODOS') {
                    $this->db->where('pt.grupo', $_POST['grupo']);
                }
                $this->db->where('pc.laboratorio_id', $laboratorio_id);
                $this->db->where('pc.ativo', 't');
                $conv_pri = $this->db->get();
                $conv_pri = $conv_pri->result();

                foreach ($conv_sec as $item) {

                    // Traz todos os procedimentos do laboratorio secundario
                    $this->db->select('pc.*');
                    $this->db->from('tb_procedimento_laboratorio pc');
                    $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                    if ($_POST['grupo'] != 'TODOS') {
                        $this->db->where('pt.grupo', $_POST['grupo']);
                    }
                    $this->db->where('pc.laboratorio_id', $item->laboratorio_secundario_id);
                    $this->db->where('pc.ativo', 't');
                    $proc_conv_sec = $this->db->get();
                    $proc_conv_sec = $proc_conv_sec->result();

                    if (count($proc_conv_sec) > 0) {
                        foreach ($proc_conv_sec as $value) {

                            // Salvando valore(s) antigo(s) do(s) laboratorio(s) secundario(s)
                            $this->db->set('procedimento_laboratorio_id', $value->procedimento_laboratorio_id);
                            $this->db->set('laboratorio_id', $value->laboratorio_id);
                            $this->db->set('procedimento_tuss_id', $value->procedimento_tuss_id);
                            $this->db->set('qtdech', $value->qtdech);
                            $this->db->set('valorch', $value->valorch);
                            $this->db->set('qtdefilme', $value->qtdefilme);
                            $this->db->set('valorfilme', $value->valorfilme);
                            $this->db->set('qtdeporte', $value->qtdeporte);
                            $this->db->set('valorporte', $value->valorporte);
                            $this->db->set('qtdeuco', $value->qtdeuco);
                            $this->db->set('valoruco', $value->valoruco);
                            $this->db->set('valortotal', $value->valortotal);
                            if ($item->valor_percentual != '') {
                                $this->db->set('percentual_ch', $item->valor_percentual);
                            }
                            $this->db->set('valortotal', $value->valortotal);
                            $this->db->set('data_cadastro', $data);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_laboratorio_antigo');
                        }
                    }


                    // Atualizando o(s) valor(s) do(s) convneios secundarios
                    foreach ($conv_pri as $cp) {
                        $this->db->set('qtdech', $cp->qtdech);
                        $this->db->set('valorch', $cp->valorch);
                        $this->db->set('qtdefilme', $cp->qtdefilme);
                        $this->db->set('valorfilme', $cp->valorfilme);
                        $this->db->set('qtdeporte', $cp->qtdeporte);
                        $this->db->set('valorporte', $cp->valorporte);
                        $this->db->set('qtdeuco', $cp->qtdeuco);
                        $this->db->set('valoruco', $cp->valoruco);
                        $this->db->set('valortotal', ($cp->valortotal * (float) $item->valor_percentual / 100));
                        $this->db->set('data_atualizacao', $data);
                        $this->db->set('operador_atualizacao', $operador_id);
                        $this->db->where('procedimento_tuss_id', $value->procedimento_tuss_id);
                        $this->db->where('laboratorio_id', $item->laboratorio_secundario_id);
                        $this->db->where('ativo', 't');
                        $this->db->where("(SELECT grupo FROM ponto.tb_procedimento_tuss pt
                                            WHERE procedimento_tuss_id = pt.procedimento_tuss_id
                                            LIMIT 1) = '{$item->grupo}'");
                        $this->db->update('tb_procedimento_laboratorio');
                    }
                }
            }

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarvaloresassociacaoantigo($laboratorio_id) {
        $operador_id = $this->session->userdata('operador_id');
        $data = date('Y-m-d H:i:s');
        try {
            $this->db->select('pc.*, pt.grupo');
            $this->db->from('tb_procedimento_laboratorio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
            $this->db->where('pc.laboratorio_id', $laboratorio_id);
            $this->db->where('pc.ativo', 't');
            foreach ($_POST['grupo'] as $key => $item) {
                if ($_POST['laboratorio'][$key] != '' && $_POST['valor'][$key] != '') {
                    $this->db->where('pt.grupo', $_POST['grupo'][$key]);
                }
            }

            $return2 = $this->db->get();
            $result2 = $return2->result();
            if (count($result2) > 0) {
                foreach ($result2 as $value) {

                    $this->db->set('procedimento_laboratorio_id', $value->procedimento_laboratorio_id);
                    $this->db->set('laboratorio_id', $value->laboratorio_id);
                    $this->db->set('procedimento_tuss_id', $value->procedimento_tuss_id);
                    $this->db->set('qtdech', $value->qtdech);
                    $this->db->set('valorch', $value->valorch);
                    $this->db->set('qtdefilme', $value->qtdefilme);
                    $this->db->set('valorfilme', $value->valorfilme);
                    $this->db->set('qtdeporte', $value->qtdeporte);
                    $this->db->set('valorporte', $value->valorporte);
                    $this->db->set('qtdeuco', $value->qtdeuco);
                    $this->db->set('valoruco', $value->valoruco);
                    $this->db->set('valortotal', $value->valortotal);

                    foreach ($_POST['grupo'] as $key => $item) {
                        if (($_POST['laboratorio'][$key] != '' && $_POST['valor'][$key] != '') && $value->grupo == $_POST['grupo'][$key]) {
                            $this->db->set('percentual_ch', $_POST['valor'][$key]);
                            break;
                        }
                    }

                    $this->db->set('valortotal', $value->valortotal);
                    $this->db->set('data_cadastro', $data);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_laboratorio_antigo');
                }
            }


            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function removerprocedimentosnaopertenceprincipal($laboratorio_id) {


        $operador_id = $this->session->userdata('operador_id');
        $data = date('Y-m-d H:i:s');

        try {

            $sql = "UPDATE ponto.tb_procedimento_laboratorio SET ativo = 'f', data_atualizacao = '{$data}', operador_atualizacao = {$operador_id}
                    WHERE laboratorio_id = {$laboratorio_id} 
                    AND ativo = 't'";

            $this->db->query($sql);

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarvaloresassociacao($laboratorio_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        try {

            foreach ($_POST['grupo'] as $key => $n) {

                if ($_POST['laboratorio'][$key] != '' && $_POST['valor'][$key] != '') {

                    $this->db->set('grupo', $_POST['grupo'][$key]);
                    $this->db->set('laboratorio_primario_id', $_POST['laboratorio'][$key]);
                    $this->db->set('laboratorio_secundario_id', $laboratorio_id);
                    $this->db->set('valor_percentual', $_POST['valor'][$key]);

                    if ($_POST['laboratorio_associacao_id'][$key] == "") {// insert
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_laboratorio_secudario_associacao');
                    } else { // update
                        $this->db->set('data_atualizacao', $horario);
                        $this->db->set('operador_atualizacao', $operador_id);
                        $this->db->where('laboratorio_secudario_associacao_id', $_POST['laboratorio_associacao_id'][$key]);
                        $this->db->update('tb_laboratorio_secudario_associacao');
                    }

                    $this->db->select('pc.*');
                    $this->db->from('tb_procedimento_laboratorio pc');
                    $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                    $this->db->where('pt.grupo', $_POST['grupo'][$key]);
                    $this->db->where('pc.laboratorio_id', $_POST['laboratorio'][$key]);
                    $this->db->where('pc.ativo', 't');
                    $return2 = $this->db->get();
                    $result2 = $return2->result();

                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->where('ativo', 'f');
                    $this->db->where('laboratorio_id', $laboratorio_id);
                    $grupo = $_POST['grupo'][$key];
                    $this->db->where("procedimento_tuss_id IN ( SELECT procedimento_tuss_id 
                                                                FROM ponto.tb_procedimento_tuss 
                                                                WHERE grupo = '{$grupo}')");
                    $this->db->update('tb_procedimento_laboratorio');


                    if (count($result2) > 0) {
                        foreach ($result2 as $value) {
                            $this->db->set('qtdech', $value->qtdech);
                            $this->db->set('valorch', $value->valorch);
                            $this->db->set('qtdefilme', $value->qtdefilme);
                            $this->db->set('valorfilme', $value->valorfilme);
                            $this->db->set('qtdeporte', $value->qtdeporte);
                            $this->db->set('valorporte', $value->valorporte);
                            $this->db->set('qtdeuco', $value->qtdeuco);
                            $this->db->set('valoruco', $value->valoruco);
                            $this->db->set('valortotal', ($value->valortotal * (float) $_POST['valor'][$key] / 100));
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->set('laboratorio_id', $laboratorio_id);
                            $this->db->set('procedimento_tuss_id', $value->procedimento_tuss_id);
                            $this->db->insert('tb_procedimento_laboratorio');
                        }
                    }
                } else {
                    if ($_POST['laboratorio'][$key] == '' && $_POST['laboratorio_associacao_id'][$key] != '') {

                        // Buscando os laboratorios secundarios associados a esse Laboratorio
                        $this->db->select('laboratorio_secundario_id, laboratorio_primario_id, grupo');
                        $this->db->from('tb_laboratorio_secudario_associacao');
                        $this->db->where('laboratorio_secudario_associacao_id', $_POST['laboratorio_associacao_id'][$key]);
                        $return = $this->db->get();
                        $conv_sec = $return->result();

                        foreach ($conv_sec as $value) { // Excluido o proc em todos os planos secundarios
                            $this->db->set('ativo', 'f');
                            $this->db->set('data_atualizacao', $horario);
                            $this->db->set('operador_atualizacao', $operador_id);
                            $this->db->where('laboratorio_id', $value->laboratorio_secundario_id);
                            $this->db->where("procedimento_tuss_id IN (
                                                    SELECT pt.procedimento_tuss_id
                                                    FROM ponto.tb_procedimento_laboratorio pc
                                                    INNER JOIN ponto.tb_procedimento_tuss pt
                                                    ON pt.procedimento_tuss_id = pc.procedimento_tuss_id
                                                    WHERE laboratorio_id = {$value->laboratorio_primario_id}
                                                    AND pt.grupo = '{$value->grupo}'
                                                    AND pc.ativo = 't'
                                                )");
                            $this->db->update('tb_procedimento_laboratorio');
                        }

                        $this->db->set('ativo', 'f');
                        $this->db->set('data_atualizacao', $horario);
                        $this->db->set('operador_atualizacao', $operador_id);
                        $this->db->where('laboratorio_secudario_associacao_id', $_POST['laboratorio_associacao_id'][$key]);
                        $this->db->update('tb_laboratorio_secudario_associacao');
                    }
                }
            }

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravardescontoantigo() {


        $ajustech = $_POST['ajustech'] / 100;
        $ajustefilme = $_POST['ajustefilme'] / 100;
        $ajusteporte = $_POST['ajusteporte'] / 100;
        $ajusteuco = $_POST['ajusteuco'] / 100;
        $ajustetotal = $_POST['ajustetotal'] / 100;
//        $ajustetotal = $_POST['ajustetotal'] / 100;
        $laboratorioid = $_POST['laboratorio'];
        $operador_id = $this->session->userdata('operador_id');
        $data = date('Y-m-d H:i:s');
//        var_dump($ajustech);
//        die; 
        try {

            if ($_POST['grupo'] != 'TODOS') {
                $this->db->select('procedimento_tuss_id');
                $this->db->from('tb_procedimento_tuss');
                $this->db->where('grupo', $_POST['grupo']);
                $this->db->where('ativo', 't');
                $return = $this->db->get();
                $result = $return->result();


                $this->db->select('pc.*');
                $this->db->from('tb_procedimento_laboratorio pc');
                $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                $this->db->where('pt.grupo', $_POST['grupo']);
                $this->db->where('pc.laboratorio_id', $laboratorioid);
                $this->db->where('pc.ativo', 't');
                $return2 = $this->db->get();
                $result2 = $return2->result();
//                echo '<pre>';
//                var_dump($result2); die;

                foreach ($result2 as $value) {

                    $this->db->set('procedimento_laboratorio_id', $value->procedimento_laboratorio_id);
                    $this->db->set('laboratorio_id', $value->laboratorio_id);
                    $this->db->set('procedimento_tuss_id', $value->procedimento_tuss_id);
                    $this->db->set('qtdech', $value->qtdech);
                    $this->db->set('valorch', $value->valorch);
                    $this->db->set('qtdefilme', $value->qtdefilme);
                    $this->db->set('valorfilme', $value->valorfilme);
                    $this->db->set('qtdeporte', $value->qtdeporte);
                    $this->db->set('valorporte', $value->valorporte);
                    $this->db->set('qtdeuco', $value->qtdeuco);
                    $this->db->set('valoruco', $value->valoruco);
                    $this->db->set('valortotal', $value->valortotal);
                    if ($_POST['ajustech'] != '') {
//                    echo  $ajustech; die;
                        $this->db->set('percentual_ch', $_POST['ajustech']);
                    }
                    if ($_POST['ajustefilme'] != '') {

                        $this->db->set('percentual_filme', $_POST['ajustefilme']);
                    }
                    if ($_POST['ajusteporte'] != '') {
                        $this->db->set('percentual_porte', $_POST['ajusteporte']);
                    }
                    if ($_POST['ajusteuco'] != '') {
                        $this->db->set('percentual_uco', $_POST['ajusteuco']);
                    }
                    if ($_POST['ajustetotal'] != '') {
                        $this->db->set('percentual_total', $_POST['ajustetotal']);
                    }
                    $this->db->set('valortotal', $value->valortotal);
                    $this->db->set('data_cadastro', $data);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_laboratorio_antigo');
                }
            } else {
                $this->db->select('pc.*');
                $this->db->from('tb_procedimento_laboratorio pc');
                $this->db->where('pc.laboratorio_id', $laboratorioid);
                $this->db->where('pc.ativo', 't');
                $return2 = $this->db->get();
                $result2 = $return2->result();
//                echo '<pre>';
//                var_dump($result2); die;
                if (count($result2) > 0) {

                    foreach ($result2 as $value) {

                        $this->db->set('procedimento_laboratorio_id', $value->procedimento_laboratorio_id);
                        $this->db->set('laboratorio_id', $value->laboratorio_id);
                        $this->db->set('procedimento_tuss_id', $value->procedimento_tuss_id);
                        $this->db->set('qtdech', $value->qtdech);
                        $this->db->set('valorch', $value->valorch);
                        $this->db->set('qtdefilme', $value->qtdefilme);
                        $this->db->set('valorfilme', $value->valorfilme);
                        $this->db->set('qtdeporte', $value->qtdeporte);
                        $this->db->set('valorporte', $value->valorporte);
                        $this->db->set('qtdeuco', $value->qtdeuco);
                        $this->db->set('valoruco', $value->valoruco);
                        $this->db->set('valortotal', $value->valortotal);
                        if ($_POST['ajustech'] != '') {
//                    echo  $ajustech; die;
                            $this->db->set('percentual_ch', $_POST['ajustech']);
                        }
                        if ($_POST['ajustefilme'] != '') {

                            $this->db->set('percentual_filme', $_POST['ajustefilme']);
                        }
                        if ($_POST['ajusteporte'] != '') {
                            $this->db->set('percentual_porte', $_POST['ajusteporte']);
                        }
                        if ($_POST['ajusteuco'] != '') {
                            $this->db->set('percentual_uco', $_POST['ajusteuco']);
                        }
                        if ($_POST['ajustetotal'] != '') {
                            $this->db->set('percentual_total', $_POST['ajustetotal']);
                        }
                        $this->db->set('valortotal', $value->valortotal);
                        $this->db->set('data_cadastro', $data);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_laboratorio_antigo');
                    }
                }
            }


            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpercentuallaboratoriosecundario() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('associacao_percentual', $_POST['valorpercentual']);
            $this->db->set('data_percentual_atualizacao', $horario);
            $this->db->set('operador_percentual_atualizacao', $operador_id);
            $this->db->where('laboratorio_id', $_POST['laboratorio_id']);
            $this->db->update('tb_laboratorio');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $laboratorio_id = $_POST['txtlaboratorio_id'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('cnpj', $_POST['txtCNPJ']);
//            $this->db->set('registroans', $_POST['txtregistroans']);
//            $this->db->set('codigoidentificador', $_POST['txtcodigo']);
//            var_dump($_POST['laboratorio_associacao']); die;



            $this->db->set('cep', $_POST['cep']);
            if ($_POST['tipo_logradouro'] != "") {
                $this->db->set('tipo_logradouro_id', $_POST['tipo_logradouro']);
            }

            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            if ($_POST['municipio_id'] != "") {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            $this->db->set('telefone', $_POST['telefone']);
            $this->db->set('celular', $_POST['celular']);

            $this->db->set('observacao', $_POST['txtObservacao']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtlaboratorio_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_laboratorio');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $exame_sala_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_sala_id = $_POST['txtlaboratorio_id'];
                $this->db->where('laboratorio_id', $laboratorio_id);
                $this->db->update('tb_laboratorio');
            }
            return $exame_sala_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarcopia() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $laboratorio = $_POST['txtlaboratorio'];
            $grupo = $_POST['grupo'];
//            var_dump($laboratorio); die;
            $laboratorioidnovo = $_POST['txtlaboratorio_id'];
            if ($grupo != '') {
//                var_dump($grupo);
//                die;
                $sql = "INSERT INTO ponto.tb_procedimento_laboratorio(
            laboratorio_id, procedimento_tuss_id, 
            qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
            qtdeuco, valoruco, valortotal, ativo, data_cadastro, operador_cadastro, 
            data_atualizacao, operador_atualizacao)
            SELECT $laboratorioidnovo, pc.procedimento_tuss_id, 
            qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
            qtdeuco, valoruco, valortotal, pc.ativo, '$horario', $operador_id, 
            pc.data_atualizacao, pc.operador_atualizacao
            FROM ponto.tb_procedimento_laboratorio pc
                LEFT JOIN ponto.tb_procedimento_tuss pt ON pc.procedimento_tuss_id = pt.procedimento_tuss_id
                where pt.grupo = '$grupo'
                and laboratorio_id = $laboratorio";
            } else {
                $sql = "INSERT INTO ponto.tb_procedimento_laboratorio(
            laboratorio_id, procedimento_tuss_id, 
            qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
            qtdeuco, valoruco, valortotal, ativo, data_cadastro, operador_cadastro, 
            data_atualizacao, operador_atualizacao)
            SELECT $laboratorioidnovo, procedimento_tuss_id, 
            qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
            qtdeuco, valoruco, valortotal, ativo, '$horario', $operador_id, 
            data_atualizacao, operador_atualizacao
            FROM ponto.tb_procedimento_laboratorio

                where laboratorio_id = $laboratorio";
            }

            $this->db->query($sql);

            return $laboratorioidnovo;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($laboratorio_id) {
//        die;
        if ($laboratorio_id != 0) {
            $this->db->select('laboratorio_id,
                                co.nome,
                                co.laboratorio_grupo_id,
                                co.dinheiro,
                                co.celular,
                                co.observacao,
                                co.cep,
                                co.ir,
                                co.pis,
                                co.cofins,
                                co.csll,
                                co.iss,
                                co.valor_base,
                                co.entrega,
                                co.pagamento,
                                co.complemento,
                                co.bairro,
                                co.numero,
                                co.tipo_logradouro_id,
                                co.telefone,
                                co.home_care,
                                co.municipio_id,
                                co.carteira_obrigatoria,
                                co.logradouro,
                                co.cnpj,
                                co.fidelidade_parceiro_id,
                                co.fidelidade_endereco_ip,
                                co.dinheiro,
                                co.procedimento1,
                                co.procedimento2,
                                co.tabela,
                                co.conta_id,
                                co.enteral,
                                co.registroans,
                                co.codigoidentificador,
                                co.parenteral,
                                co.credor_devedor_id,
                                co.associado,
                                co.associacao_percentual,
                                co.associacao_laboratorio_id,
                                co.razao_social');
            $this->db->from('tb_laboratorio co');
            $this->db->join('tb_municipio c', 'c.municipio_id = co.municipio_id', 'left');
            $this->db->join('tb_tipo_logradouro tp', 'tp.tipo_logradouro_id = co.tipo_logradouro_id', 'left');
            $this->db->where("laboratorio_id", $laboratorio_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_laboratorio_id = $laboratorio_id;
            $this->_nome = $return[0]->nome;
            $this->_laboratorio_grupo_id = $return[0]->laboratorio_grupo_id;
            $this->_razao_social = $return[0]->razao_social;
            $this->_cnpj = $return[0]->cnpj;
            $this->_logradouro = $return[0]->logradouro;
            $this->_municipio_id = $return[0]->municipio_id;
            $this->_celular = $return[0]->celular;
            $this->_telefone = $return[0]->telefone;
            $this->_fidelidade_parceiro_id = $return[0]->fidelidade_parceiro_id;
            $this->_fidelidade_endereco_ip = $return[0]->fidelidade_endereco_ip;
            $this->_carteira_obrigatoria = $return[0]->carteira_obrigatoria;
            $this->_home_care = $return[0]->home_care;
            $this->_tipo_logradouro_id = $return[0]->tipo_logradouro_id;
            $this->_numero = $return[0]->numero;
            $this->_bairro = $return[0]->bairro;
            $this->_complemento = $return[0]->complemento;
            $this->_cep = $return[0]->cep;
            $this->_ir = $return[0]->ir;
            $this->_pis = $return[0]->pis;
            $this->_cofins = $return[0]->cofins;
            $this->_csll = $return[0]->csll;
            $this->_iss = $return[0]->iss;
            $this->_valor_base = $return[0]->valor_base;
            $this->_entrega = $return[0]->entrega;
            $this->_pagamento = $return[0]->pagamento;
            $this->_cep = $return[0]->cep;
            $this->_observacao = $return[0]->observacao;
            $this->_dinheiro = $return[0]->dinheiro;
            $this->_procedimento1 = $return[0]->procedimento1;
            $this->_procedimento2 = $return[0]->procedimento2;
            $this->_tabela = $return[0]->tabela;
            $this->_credor_devedor_id = $return[0]->credor_devedor_id;
            $this->_conta_id = $return[0]->conta_id;
            $this->_enteral = $return[0]->enteral;
            $this->_parenteral = $return[0]->parenteral;
            $this->_registroans = $return[0]->registroans;
            $this->_codigoidentificador = $return[0]->codigoidentificador;
            $this->_associado = $return[0]->associado;
            $this->_associacao_percentual = $return[0]->associacao_percentual;
            $this->_associacao_laboratorio_id = $return[0]->associacao_laboratorio_id;
        } else {
            $this->_laboratorio_id = null;
        }
    }

}

?>
