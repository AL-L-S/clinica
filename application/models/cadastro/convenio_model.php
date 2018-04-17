<?php

class Convenio_model extends Model {

    var $_convenio_id = null;
    var $_convenio_grupo_id = null;
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

    function Convenio_model($convenio_id = null) {
        parent::Model();
        if (isset($convenio_id)) {
            $this->instanciar($convenio_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('convenio_id,
                            nome,
                            associado,
                            associacao_convenio_id');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listardados() {

        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("ce.ativo", 'true');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

    function listarconveniosprimarios() {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("associado", 'f');
        $this->db->where("ce.ativo", 'true');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
//        $this->db->select('convenio_id,
//                            nome,
//                            dinheiro,
//                            conta_id');
//        $this->db->from('tb_convenio');
//        $this->db->where("ativo", 't');
//
//        $this->db->orderby("nome");
//        $return = $this->db->get();
//        return $return->result();
    }

    function buscarconvenioempresa($convenio_id) {
        $this->db->select('e.nome as empresa, convenio_empresa_id');
        $this->db->from('tb_convenio_empresa ce');
        $this->db->join('tb_empresa e', 'ce.empresa_id = e.empresa_id', 'left');
        $this->db->where("ce.ativo", 't');
        $this->db->where("ce.convenio_id", $convenio_id);
        $this->db->orderby("ce.empresa_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listarconvenioscopiar($convenio_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("c.convenio_id !=", $convenio_id);
//        $this->db->where("associado", 'f');
        $this->db->where("ce.ativo", 'true');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        return $return = $query->result();


//        $this->db->select('convenio_id,
//                            nome,
//                            dinheiro,
//                            conta_id');
//        $this->db->from('tb_convenio');
//        $this->db->where("ativo", 't');
//
//        $this->db->orderby("nome");
//        $return = $this->db->get();
//        return $return->result();
    }

    function listarconvenioselecionado($convenio_id) {
        $this->db->select('convenio_id,
                            nome,
                            dinheiro,
                            conta_id');
        $this->db->from('tb_convenio');
//        $this->db->where("ativo", 't');
        $this->db->where("convenio_id", $convenio_id);
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listardadoscbhpm() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
//        $this->db->where("ativo", 't');
        $this->db->where("(tabela = 'CBHPM' OR tabela = 'PROPRIA')");
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarconveniodesconto($convenio_id) {
        $this->db->select('convenio_id,
                            nome');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->where('convenio_id', $convenio_id);
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
        $this->db->where("ativo", 't');
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

    function listarassociacoesconvenio($convenio_id) {
        $this->db->select('convenio_secudario_associacao_id,
                           convenio_secundario_id,
                           convenio_primario_id,
                           valor_percentual,
                           grupo');
        $this->db->from('tb_convenio_secudario_associacao');
        $this->db->where("convenio_secundario_id", $convenio_id);
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listardadosconvenios() {
        $this->db->select('convenio_id,
                            nome');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("dinheiro", "t");
        }
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoconvenioodontograma($convenio_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
//        $this->db->where("pt.grupo", 'ODONTOLOGIA');
        $this->db->where("ag.tipo", 'ESPECIALIDADE');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $convenio_id);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarconvenionaodinheiro() {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("ce.ativo", 'true');
        $this->db->where("dinheiro", 'f');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;

//
//        $this->db->select('convenio_id,
//                            nome');
//        $this->db->from('tb_convenio');
//        $this->db->where("ativo", 't');
//        $this->db->where("dinheiro", 'f');
//        $this->db->orderby("nome");
//        $return = $this->db->get();
//        return $return->result();
    }

    function excluir($convenio_id) {
        $this->db->select('convenio_secudario_associacao_id');
        $this->db->from('tb_convenio_secudario_associacao');
        $this->db->where("ativo", 't');
        $this->db->where("convenio_primario_id", $convenio_id);
        $return = $this->db->get();
        $return = $return->result();

        if (count($return) == 0) {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('convenio_id', $convenio_id);
            $this->db->update('tb_convenio');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('convenio_id', $convenio_id);
            $this->db->update('tb_procedimento_convenio');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return $convenio_id;
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
        $convenioid = $_POST['convenio'];
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
                        $sql = "update ponto.tb_procedimento_convenio
                    set valorch = (valorch * $ajustech) + valorch, 
                    valorfilme = (valorfilme * $ajustefilme) + valorfilme,
                    valorporte = (valorporte * $ajusteporte) + valorporte,                        
                    valoruco = (valoruco * $ajusteuco) + valoruco,
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where convenio_id = $convenioid and procedimento_tuss_id = $procedimento_tuss_id;";
                        $this->db->query($sql);
                        if ($_POST['ajustetotal'] == '') {
                            $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = (valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco)
                      where convenio_id = $convenioid and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        } else {
                            $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = (valortotal * $ajustetotal) + valortotal
                      where convenio_id = $convenioid and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        }
                    } else {
                        $sql = "update ponto.tb_procedimento_convenio
                    set valorch = ROUND((valorch * $ajustech) + valorch), 
                    valorfilme = ROUND((valorfilme * $ajustefilme) + valorfilme),
                    valorporte = ROUND((valorporte * $ajusteporte) + valorporte),                        
                    valoruco = ROUND((valoruco * $ajusteuco) + valoruco),
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where convenio_id = $convenioid and procedimento_tuss_id = $procedimento_tuss_id;";
                        $this->db->query($sql);
                        if ($_POST['ajustetotal'] == '') {
                            $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = ROUND((valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco))
                      where convenio_id = $convenioid and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        } else {
                            $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = ROUND((valortotal * $ajustetotal) + valortotal)
                      where convenio_id = $convenioid and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        }
                    }
                }
            } else {
                if (empty($_POST['arrendondamento'])) { // verifica se é pra arredondar para o interiro mais próximo
                    $sql = "update ponto.tb_procedimento_convenio
                    set valorch = (valorch * $ajustech) + valorch, 
                    valorfilme = (valorfilme * $ajustefilme) + valorfilme,
                    valorporte = (valorporte * $ajusteporte) + valorporte,                        
                    valoruco = (valoruco * $ajusteuco) + valoruco,
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where convenio_id = $convenioid;";
                    $this->db->query($sql);

                    if ($_POST['ajustetotal'] == '') {
                        $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = (valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco)
                      where convenio_id = $convenioid;";
                        $this->db->query($sqll);
                    } else {
                        $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = (valortotal * $ajustetotal) + valortotal
                      where convenio_id = $convenioid;";
                        $this->db->query($sqll);
                    }
                } else {
                    $sql = "update ponto.tb_procedimento_convenio
                    set valorch = ROUND((valorch * $ajustech) + valorch), 
                    valorfilme = ROUND((valorfilme * $ajustefilme) + valorfilme),
                    valorporte = ROUND((valorporte * $ajusteporte) + valorporte),                        
                    valoruco = ROUND((valoruco * $ajusteuco) + valoruco),
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where convenio_id = $convenioid;";
                    $this->db->query($sql);

                    if ($_POST['ajustetotal'] == '') {
                        $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = ROUND((valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco))
                      where convenio_id = $convenioid;";
                        $this->db->query($sqll);
                    } else {
                        $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = ROUND((valortotal * $ajustetotal) + valortotal)
                      where convenio_id = $convenioid;";
                        $this->db->query($sqll);
                    }
                }
            }


            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarajusteconveniosecundario($convenio_id) {
        $operador_id = $this->session->userdata('operador_id');
        $data = date('Y-m-d H:i:s');
        try {
            /* TRAZENDO CONVENIOS SECUNDARIOS */
            $this->db->select('convenio_secundario_id, grupo, valor_percentual');
            $this->db->from('tb_convenio_secudario_associacao csa');
            $this->db->where('csa.ativo', 't');
            $this->db->where('csa.convenio_primario_id', $convenio_id);
            if ($_POST['grupo'] != 'TODOS') {
                $this->db->where('csa.grupo', $_POST['grupo']);
            }
            $conv_sec = $this->db->get();
            $conv_sec = $conv_sec->result();

            // Verifica se há convenios secundarios associados
            if (count($conv_sec) > 0) {

                // Traz todos os procedimentos do convenio principal
                $this->db->select('pc.*, pt.grupo');
                $this->db->from('tb_procedimento_convenio pc');
                $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                if ($_POST['grupo'] != 'TODOS') {
                    $this->db->where('pt.grupo', $_POST['grupo']);
                }
                $this->db->where('pc.convenio_id', $convenio_id);
                $this->db->where('pc.ativo', 't');
                $conv_pri = $this->db->get();
                $conv_pri = $conv_pri->result();

                foreach ($conv_sec as $item) {

                    // Traz todos os procedimentos do convenio secundario
                    $this->db->select('pc.*');
                    $this->db->from('tb_procedimento_convenio pc');
                    $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                    if ($_POST['grupo'] != 'TODOS') {
                        $this->db->where('pt.grupo', $_POST['grupo']);
                    }
                    $this->db->where('pc.convenio_id', $item->convenio_secundario_id);
                    $this->db->where('pc.ativo', 't');
                    $proc_conv_sec = $this->db->get();
                    $proc_conv_sec = $proc_conv_sec->result();

                    if (count($proc_conv_sec) > 0) {
                        foreach ($proc_conv_sec as $value) {

                            // Salvando valore(s) antigo(s) do(s) convenio(s) secundario(s)
                            $this->db->set('procedimento_convenio_id', $value->procedimento_convenio_id);
                            $this->db->set('convenio_id', $value->convenio_id);
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
                            $this->db->insert('tb_procedimento_convenio_antigo');
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
                        $this->db->where('convenio_id', $item->convenio_secundario_id);
                        $this->db->where('ativo', 't');
                        $this->db->where("(SELECT grupo FROM ponto.tb_procedimento_tuss pt
                                            WHERE procedimento_tuss_id = pt.procedimento_tuss_id
                                            LIMIT 1) = '{$item->grupo}'");
                        $this->db->update('tb_procedimento_convenio');
                    }
                }
            }

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarvaloresassociacaoantigo($convenio_id) {
        $operador_id = $this->session->userdata('operador_id');
        $data = date('Y-m-d H:i:s');
        try {
            $this->db->select('pc.*, pt.grupo');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
            $this->db->where('pc.convenio_id', $convenio_id);
            $this->db->where('pc.ativo', 't');
            foreach ($_POST['grupo'] as $key => $item) {
                if ($_POST['convenio'][$key] != '' && $_POST['valor'][$key] != '') {
                    $this->db->where('pt.grupo', $_POST['grupo'][$key]);
                }
            }

            $return2 = $this->db->get();
            $result2 = $return2->result();
            if (count($result2) > 0) {
                foreach ($result2 as $value) {

                    $this->db->set('procedimento_convenio_id', $value->procedimento_convenio_id);
                    $this->db->set('convenio_id', $value->convenio_id);
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
                        if (($_POST['convenio'][$key] != '' && $_POST['valor'][$key] != '') && $value->grupo == $_POST['grupo'][$key]) {
                            $this->db->set('percentual_ch', $_POST['valor'][$key]);
                            break;
                        }
                    }

                    $this->db->set('valortotal', $value->valortotal);
                    $this->db->set('data_cadastro', $data);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_convenio_antigo');
                }
            }


            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function removerpercentuaisnaopertenceprincipal($convenio_id) {


        $operador_id = $this->session->userdata('operador_id');
        $data = date('Y-m-d H:i:s');

        try {
            $this->db->select('pmc.*');
            $this->db->from('tb_procedimento_percentual_medico_convenio pmc');
            $this->db->join('tb_procedimento_percentual_medico pm', 'pm.procedimento_percentual_medico_id = pmc.procedimento_percentual_medico_id');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id');
            $this->db->where('pmc.ativo', 't');
            $this->db->where('pc.convenio_id', $convenio_id);
            $return = $this->db->get()->result();
            
            if(count($return) > 0){
                
                foreach($return as $item){
                    
                    $procedimentos .= $item->procedimento_percentual_medico_id.",";
                    
                    $this->db->set('procedimento_percentual_medico_convenio_id', $item->procedimento_percentual_medico_convenio_id);
                    $this->db->set('procedimento_percentual_medico_id', $item->procedimento_percentual_medico_id);
                    $this->db->set('medico', $item->medico);
                    $this->db->set('valor', $item->valor);
                    $this->db->set('percentual', $item->percentual);
                    $this->db->set('dia_recebimento', $item->dia_recebimento);
                    $this->db->set('tempo_recebimento', $item->tempo_recebimento);
                    $this->db->set('data_cadastro', $data);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_medico_convenio_antigo');
                }
                
                $procedimentosLista = substr($procedimentos, 0, -1);
                
                $sql = "UPDATE ponto.tb_procedimento_percentual_medico 
                        SET ativo = 'f', data_atualizacao = '{$data}', operador_atualizacao = {$operador_id}
                        WHERE procedimento_percentual_medico_id IN ({$procedimentosLista})
                        AND ativo = 't'";
                $this->db->query($sql);
                
                $sql = "UPDATE ponto.tb_procedimento_percentual_medico_convenio 
                        SET ativo = 'f', data_atualizacao = '{$data}', operador_atualizacao = {$operador_id}
                        WHERE procedimento_percentual_medico_id IN ({$procedimentosLista})
                        AND ativo = 't'";
                $this->db->query($sql);

            }
            

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function removerprocedimentosnaopertenceprincipal($convenio_id) {


        $operador_id = $this->session->userdata('operador_id');
        $data = date('Y-m-d H:i:s');

        try {

            $sql = "UPDATE ponto.tb_procedimento_convenio SET ativo = 'f', data_atualizacao = '{$data}', operador_atualizacao = {$operador_id}
                    WHERE convenio_id = {$convenio_id} 
                    AND ativo = 't'";

            $this->db->query($sql);

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarvaloresassociacao($convenio_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        try {

            foreach ($_POST['grupo'] as $key => $n) {

                if ($_POST['convenio'][$key] != '' && $_POST['valor'][$key] != '') {

                    $this->db->set('grupo', $_POST['grupo'][$key]);
                    $this->db->set('convenio_primario_id', $_POST['convenio'][$key]);
                    $this->db->set('convenio_secundario_id', $convenio_id);
                    $this->db->set('valor_percentual', $_POST['valor'][$key]);

                    if ($_POST['convenio_associacao_id'][$key] == "") {// insert
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_convenio_secudario_associacao');
                    } else { // update
                        $this->db->set('data_atualizacao', $horario);
                        $this->db->set('operador_atualizacao', $operador_id);
                        $this->db->where('convenio_secudario_associacao_id', $_POST['convenio_associacao_id'][$key]);
                        $this->db->update('tb_convenio_secudario_associacao');
                    }

                    $this->db->select('pc.*');
                    $this->db->from('tb_procedimento_convenio pc');
                    $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                    $this->db->where('pt.grupo', $_POST['grupo'][$key]);
                    $this->db->where('pc.convenio_id', $_POST['convenio'][$key]);
                    $this->db->where('pc.ativo', 't');
                    $return2 = $this->db->get();
                    $result2 = $return2->result();

                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->set('ativo', 'f');
                    $this->db->where('convenio_id', $convenio_id);
                    $grupo = $_POST['grupo'][$key];
                    $this->db->where("procedimento_tuss_id IN ( SELECT procedimento_tuss_id 
                                                                FROM ponto.tb_procedimento_tuss 
                                                                WHERE grupo = '{$grupo}')");
                    $this->db->update('tb_procedimento_convenio');


                    if (count($result2) > 0) {
                        foreach ($result2 as $value) {
                            $valortotal = $value->valortotal + ($value->valortotal * (float) $_POST['valor'][$key] / 100);
                            $this->db->set('qtdech', $value->qtdech);
                            $this->db->set('valorch', $value->valorch);
                            $this->db->set('qtdefilme', $value->qtdefilme);
                            $this->db->set('valorfilme', $value->valorfilme);
                            $this->db->set('qtdeporte', $value->qtdeporte);
                            $this->db->set('valorporte', $value->valorporte);
                            $this->db->set('qtdeuco', $value->qtdeuco);
                            $this->db->set('valoruco', $value->valoruco);
                            $this->db->set('valortotal', $valortotal);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->set('convenio_id', $convenio_id);
                            $this->db->set('procedimento_tuss_id', $value->procedimento_tuss_id);
                            $this->db->insert('tb_procedimento_convenio');
                        }
                    }
                } else {
                    if ($_POST['convenio'][$key] == '' && $_POST['convenio_associacao_id'][$key] != '') {

                        // Buscando os convenios secundarios associados a esse Convenio
                        $this->db->select('convenio_secundario_id, convenio_primario_id, grupo');
                        $this->db->from('tb_convenio_secudario_associacao');
                        $this->db->where('convenio_secudario_associacao_id', $_POST['convenio_associacao_id'][$key]);
                        $return = $this->db->get();
                        $conv_sec = $return->result();

                        foreach ($conv_sec as $value) { // Excluido o proc em todos os planos secundarios
                            $this->db->set('ativo', 'f');
                            $this->db->set('data_atualizacao', $horario);
                            $this->db->set('operador_atualizacao', $operador_id);
                            $this->db->where('convenio_id', $value->convenio_secundario_id);
                            $this->db->where("procedimento_tuss_id IN (
                                                    SELECT pt.procedimento_tuss_id
                                                    FROM ponto.tb_procedimento_convenio pc
                                                    INNER JOIN ponto.tb_procedimento_tuss pt
                                                    ON pt.procedimento_tuss_id = pc.procedimento_tuss_id
                                                    WHERE convenio_id = {$value->convenio_primario_id}
                                                    AND pt.grupo = '{$value->grupo}'
                                                    AND pc.ativo = 't'
                                                )");
                            $this->db->update('tb_procedimento_convenio');
                        }

                        $this->db->set('ativo', 'f');
                        $this->db->set('data_atualizacao', $horario);
                        $this->db->set('operador_atualizacao', $operador_id);
                        $this->db->where('convenio_secudario_associacao_id', $_POST['convenio_associacao_id'][$key]);
                        $this->db->update('tb_convenio_secudario_associacao');
                    }
                }
            }

            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }
    

    function gravarvaloresassociacaoeditar($convenio_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        try {
//            echo '<pre>';
//            var_dump($_POST); die;
            foreach ($_POST['grupo'] as $key => $n) {

                if ($_POST['convenio'][$key] != '' && $_POST['valor'][$key] != '') {

                    $this->db->set('grupo', $_POST['grupo'][$key]);
                    $this->db->set('convenio_primario_id', $_POST['convenio'][$key]);
                    $this->db->set('convenio_secundario_id', $convenio_id);
                    $this->db->set('valor_percentual', $_POST['valor'][$key]);

                    if ($_POST['convenio_associacao_id'][$key] == "") {// insert
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_convenio_secudario_associacao');
                    } else { // update
                        $this->db->set('data_atualizacao', $horario);
                        $this->db->set('operador_atualizacao', $operador_id);
                        $this->db->where('convenio_secudario_associacao_id', $_POST['convenio_associacao_id'][$key]);
                        $this->db->update('tb_convenio_secudario_associacao');
                    }

                    $this->db->select('pc.*');
                    $this->db->from('tb_procedimento_convenio pc');
                    $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                    $this->db->where('pt.grupo', $_POST['grupo'][$key]);
                    $this->db->where('pc.convenio_id', $_POST['convenio'][$key]);
                    $this->db->where('pc.ativo', 't');
                    $result2 = $this->db->get()->result();

                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->set('ativo', 'f');
                    $this->db->where('convenio_id', $convenio_id);
                    $grupo = $_POST['grupo'][$key];
                    $this->db->where("procedimento_tuss_id IN ( SELECT procedimento_tuss_id 
                                                                FROM ponto.tb_procedimento_tuss 
                                                                WHERE grupo = '{$grupo}')");
                    $this->db->update('tb_procedimento_convenio');


                    if (count($result2) > 0) {
                        foreach ($result2 as $value) {
                            $valortotal = $value->valortotal + ($value->valortotal * (float) $_POST['valor'][$key] / 100);
//                            var_dump($valortotal); die;

                            $this->db->set('qtdech', $value->qtdech);
                            $this->db->set('valorch', $value->valorch);
                            $this->db->set('qtdefilme', $value->qtdefilme);
                            $this->db->set('valorfilme', $value->valorfilme);
                            $this->db->set('qtdeporte', $value->qtdeporte);
                            $this->db->set('valorporte', $value->valorporte);
                            $this->db->set('qtdeuco', $value->qtdeuco);
                            $this->db->set('valoruco', $value->valoruco);
                            $this->db->set('valortotal', $valortotal);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->set('convenio_id', $convenio_id);
                            $this->db->set('procedimento_tuss_id', $value->procedimento_tuss_id);
                            $this->db->insert('tb_procedimento_convenio');
                            $pc_id = $this->db->insert_id();
                            
                            // INSERINDO PERCENTUAIS MÉDICOS (tb_procedimento_percentual_medico)
                            $sql = "INSERT INTO ponto.tb_procedimento_percentual_medico(procedimento_tuss_id, medico, valor, data_cadastro, operador_cadastro)
                                    SELECT {$pc_id}, ppm.medico, ppm.valor, '{$horario}', {$operador_id}
                                    FROM ponto.tb_procedimento_percentual_medico ppm
                                    WHERE ppm.ativo = 't'
                                    AND ppm.procedimento_tuss_id = {$value->procedimento_convenio_id}";
                            $this->db->query($sql);
                            
                            // INSERINDO PERCENTUAIS MÉDICOS (tb_procedimento_percentual_medico_convenio)
                            $sql = "INSERT INTO ponto.tb_procedimento_percentual_medico_convenio(
                                        medico, 
                                        procedimento_percentual_medico_id, 
                                        valor, 
                                        percentual, 
                                        dia_recebimento, 
                                        tempo_recebimento, 
                                        data_cadastro, 
                                        operador_cadastro
                                    )
                                    SELECT ppmc.medico, 
                                           (SELECT procedimento_percentual_medico_id FROM ponto.tb_procedimento_percentual_medico 
                                           WHERE procedimento_tuss_id = {$pc_id} LIMIT 1), 
                                           ppmc.valor, 
                                           percentual, 
                                           dia_recebimento, 
                                           tempo_recebimento, 
                                           '{$horario}', {$operador_id}
                                    FROM ponto.tb_procedimento_percentual_medico_convenio ppmc
                                    INNER JOIN ponto.tb_procedimento_percentual_medico ppm 
                                    ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id
                                    WHERE ppmc.ativo = 't'
                                    AND ppm.ativo = 't'
                                    AND ppm.procedimento_tuss_id = {$value->procedimento_convenio_id}";
                            $this->db->query($sql);
                            
                        }
                    }
                } else {
                    if ($_POST['convenio'][$key] == '' && $_POST['convenio_associacao_id'][$key] != '') {

                        // Buscando os convenios secundarios associados a esse Convenio
                        $this->db->select('convenio_secundario_id, convenio_primario_id, grupo');
                        $this->db->from('tb_convenio_secudario_associacao');
                        $this->db->where('convenio_secudario_associacao_id', $_POST['convenio_associacao_id'][$key]);
                        $return = $this->db->get();
                        $conv_sec = $return->result();

                        foreach ($conv_sec as $value) { // Excluido o proc em todos os planos secundarios
                            $this->db->set('ativo', 'f');
                            $this->db->set('data_atualizacao', $horario);
                            $this->db->set('operador_atualizacao', $operador_id);
                            $this->db->where('convenio_id', $value->convenio_secundario_id);
                            $this->db->where("procedimento_tuss_id IN (
                                                    SELECT pt.procedimento_tuss_id
                                                    FROM ponto.tb_procedimento_convenio pc
                                                    INNER JOIN ponto.tb_procedimento_tuss pt
                                                    ON pt.procedimento_tuss_id = pc.procedimento_tuss_id
                                                    WHERE convenio_id = {$value->convenio_primario_id}
                                                    AND pt.grupo = '{$value->grupo}'
                                                    AND pc.ativo = 't'
                                                )");
                            $this->db->update('tb_procedimento_convenio');
                        }

                        $this->db->set('ativo', 'f');
                        $this->db->set('data_atualizacao', $horario);
                        $this->db->set('operador_atualizacao', $operador_id);
                        $this->db->where('convenio_secudario_associacao_id', $_POST['convenio_associacao_id'][$key]);
                        $this->db->update('tb_convenio_secudario_associacao');
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
        $convenioid = $_POST['convenio'];
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
                $this->db->from('tb_procedimento_convenio pc');
                $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                $this->db->where('pt.grupo', $_POST['grupo']);
                $this->db->where('pc.convenio_id', $convenioid);
                $this->db->where('pc.ativo', 't');
                $return2 = $this->db->get();
                $result2 = $return2->result();
//                echo '<pre>';
//                var_dump($result2); die;

                foreach ($result2 as $value) {

                    $this->db->set('procedimento_convenio_id', $value->procedimento_convenio_id);
                    $this->db->set('convenio_id', $value->convenio_id);
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
                    $this->db->insert('tb_procedimento_convenio_antigo');
                }
            } else {
                $this->db->select('pc.*');
                $this->db->from('tb_procedimento_convenio pc');
                $this->db->where('pc.convenio_id', $convenioid);
                $this->db->where('pc.ativo', 't');
                $return2 = $this->db->get();
                $result2 = $return2->result();
//                echo '<pre>';
//                var_dump($result2); die;
                if (count($result2) > 0) {

                    foreach ($result2 as $value) {

                        $this->db->set('procedimento_convenio_id', $value->procedimento_convenio_id);
                        $this->db->set('convenio_id', $value->convenio_id);
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
                        $this->db->insert('tb_procedimento_convenio_antigo');
                    }
                }
            }


            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpercentualconveniosecundario() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('associacao_percentual', $_POST['valorpercentual']);
            $this->db->set('data_percentual_atualizacao', $horario);
            $this->db->set('operador_percentual_atualizacao', $operador_id);
            $this->db->where('convenio_id', $_POST['convenio_id']);
            $this->db->update('tb_convenio');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function criarProcedimentoCBHPM() {
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");

        $this->db->select('tuss_id, descricao, codigo');
        $this->db->from('tb_tuss t');
        $this->db->where("tabela", 'CBHPM');
        $this->db->where("tuss_id NOT IN (
                    SELECT pt.tuss_id FROM ponto.tb_procedimento_tuss pt
                    INNER JOIN ponto.tb_tuss t ON t.tuss_id = pt.tuss_id
                    WHERE t.tabela = 'CBHPM'
                    AND pt.ativo = 't'
                )");
        $return = $this->db->get()->result();


        if (count($return) > 0) {
            foreach ($return as $item) {

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('nome', $item->descricao);
                $this->db->set('tuss_id', $item->tuss_id);
                $this->db->set('codigo', $item->codigo);
                $this->db->set('descricao', $item->descricao);
                $this->db->set('grupo', 'CIRURGICO');
                $this->db->set('revisao', 'f');
                $this->db->set('associacao_procedimento_tuss_id', null);
                $this->db->set('retorno_dias', null);
                $this->db->set('sala_preparo', 'f');
                $this->db->set('qtde', 1);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_procedimento_tuss');
                $procedimento_tuss_id = $this->db->insert_id();
            }
        }
    }

    function atualizarValoresProcedimentosCBHPM($convenio_id) {
        // Cria procedimentos CBHPM que nao estao cadastrados na MANTER PROCEDIMENTO
        $this->criarProcedimentoCBHPM();

        $valor_por = (float) str_replace(",", ".", str_replace(".", "", $_POST['valor_ajuste_cbhpm']));
        $valor_por = ($valor_por) / 100;

        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $horario = date("Y-m-d H:i:s");

        // Insere procedimentos CBHPM nesse convenio
        $this->db->select('t.valor_porte, pt.procedimento_tuss_id');
        $this->db->from('tb_procedimento_tuss pt');
        $this->db->join('tb_tuss t', 't.tuss_id = pt.tuss_id', 'left');
        $this->db->where("pt.ativo", 't');
        $this->db->where("t.tabela", 'CBHPM');
        $this->db->where("pt.procedimento_tuss_id NOT IN (
            SELECT pc.procedimento_tuss_id FROM ponto.tb_procedimento_convenio pc 
            WHERE pc.ativo = 't' AND pc.convenio_id = " . (int) $convenio_id . "
        )");
        $return = $this->db->get()->result();

        if (count($return) > 0) {
            foreach ($return as $value) {
                $this->db->set('convenio_id', $convenio_id);
                $this->db->set('procedimento_tuss_id', $value->procedimento_tuss_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('qtdech', 0);
                $this->db->set('valorch', 0);
                $this->db->set('qtdefilme', 0);
                $this->db->set('valorfilme', 0);
                $this->db->set('qtdeporte', 0);
                $this->db->set('valorporte', 0);
                $this->db->set('qtdeuco', 0);
                $this->db->set('valoruco', 0);
                $this->db->set('valortotal', 0);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_procedimento_convenio');
            }
        }

        // Inserindo valores antigos na tb_procedimento_convenio_antigo
        $sql = "INSERT INTO ponto.tb_procedimento_convenio_antigo(procedimento_convenio_id, convenio_id,procedimento_tuss_id,
                qtdech,valorch, qtdefilme, valorfilme, qtdeporte, valorporte, qtdeuco,
                valoruco, valortotal, empresa_id, data_cadastro, operador_cadastro)
                SELECT pc.procedimento_convenio_id, pc.convenio_id,pc.procedimento_tuss_id,
                pc.qtdech,pc.valorch, pc.qtdefilme, pc.valorfilme, pc.qtdeporte, pc.valorporte, pc.qtdeuco,
                pc.valoruco, pc.valortotal, pc.empresa_id, '$horario', $operador_id
                FROM ponto.tb_procedimento_convenio pc
                LEFT JOIN ponto.tb_procedimento_tuss pt ON pc.procedimento_tuss_id = pt.procedimento_tuss_id
                LEFT JOIN ponto.tb_tuss t ON t.tuss_id = pt.tuss_id
                WHERE pc.convenio_id = $convenio_id
                AND pc.ativo = 't'
                AND t.tabela = 'CBHPM'";
        $this->db->query($sql);

        // Alterando os valores antigos
        $sql = "UPDATE ponto.tb_procedimento_convenio pc2
                SET valorch = t.valor_porte + ($valor_por * t.valor_porte), 
                    valortotal = t.valor_porte + ($valor_por * t.valor_porte),
                    data_atualizacao = '$horario', operador_atualizacao = $operador_id
                FROM ponto.tb_procedimento_convenio pc
                LEFT JOIN ponto.tb_procedimento_tuss pt ON pc.procedimento_tuss_id = pt.procedimento_tuss_id
                LEFT JOIN ponto.tb_tuss t ON t.tuss_id = pt.tuss_id
                WHERE pc.convenio_id = $convenio_id
                AND pc2.procedimento_convenio_id = pc.procedimento_convenio_id
                AND pc.ativo = 't'
                AND t.tabela = 'CBHPM' ";
        $this->db->query($sql);
    }

    function gravar() {
        try {
            $result = array();
            if ($_POST['txtconvenio_id'] != ''){
                $this->db->select('credor_devedor_id')->from('tb_convenio c');
                $this->db->join("tb_financeiro_credor_devedor cd", "cd.financeiro_credor_devedor_id = c.credor_devedor_id");
                $this->db->where('convenio_id', $_POST['txtconvenio_id'])->where('cd.ativo', 't');
                $result = $this->db->get()->result();
            }
            
            if (count($result) == 0 || @$result[0]->credor_devedor_id == '') {
                $this->db->set('razao_social', $_POST['txtNome']);
                $this->db->set('cep', $_POST['cep']);
                $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
                $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
                if ($_POST['tipo_logradouro'] != "") {
                    $this->db->set('tipo_logradouro_id', $_POST['tipo_logradouro']);
                }
                
                if ($_POST['municipio_id'] != '') {
                    $this->db->set('municipio_id', $_POST['municipio_id']);
                }

                $this->db->set('logradouro', $_POST['endereco']);
                $this->db->set('numero', $_POST['numero']);
                $this->db->set('bairro', $_POST['bairro']);
                $this->db->set('complemento', $_POST['complemento']);
                if ($_POST['municipio_id'] != "") {
                    $this->db->set('municipio_id', $_POST['municipio_id']);
                }
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_financeiro_credor_devedor');
                $financeiro_credor_devedor_id = $this->db->insert_id();
            }
            
            /* inicia o mapeamento no banco */
            $convenio_id = $_POST['txtconvenio_id'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('cnpj', $_POST['txtCNPJ']);
            $this->db->set('registroans', $_POST['txtregistroans']);
            $this->db->set('codigoidentificador', $_POST['txtcodigo']);


            if (isset($_POST['guia_prestador_unico'])) {
                $this->db->set('guia_prestador_unico', 't');
            } else {
                $this->db->set('guia_prestador_unico', 'f');
            }

            if (isset($_POST['associaconvenio'])) {
                $this->db->set('associado', 't');
            } else {
                $this->db->set('associado', 'f');
                $this->db->set('associacao_percentual', 0);
                $this->db->set('associacao_convenio_id', null);
            }

            if ($financeiro_credor_devedor_id != "") {
                $this->db->set('credor_devedor_id', $financeiro_credor_devedor_id);
            }
//            if ($_POST['fidadelidade_endereco_ip'] != "") {
            $this->db->set('fidelidade_endereco_ip', $_POST['fidelidade_endereco_ip']);
//            }
            if ($_POST['fidelidade_parceiro_id'] != "") {
                $this->db->set('fidelidade_parceiro_id', $_POST['fidelidade_parceiro_id']);
            }
            if ($_POST['conta'] != "") {
                $this->db->set('conta_id', $_POST['conta']);
            }
            if ($_POST['grupoconvenio'] != "") {
                $this->db->set('convenio_grupo_id', $_POST['grupoconvenio']);
            }
            $this->db->set('cep', $_POST['cep']);
            if ($_POST['tipo_logradouro'] != "") {
                $this->db->set('tipo_logradouro_id', $_POST['tipo_logradouro']);
            }
            if ($_POST['valor_ajuste_cbhpm'] != "") {
                $this->db->set('valor_ajuste_cbhpm', str_replace(",", ".", str_replace(".", "", $_POST['valor_ajuste_cbhpm'])));
            }
            if ($_POST['ir'] != "") {
                $this->db->set('ir', str_replace(",", ".", $_POST['ir']));
            }
            if ($_POST['pis'] != "") {
                $this->db->set('pis', str_replace(",", ".", $_POST['pis']));
            }
            if ($_POST['cofins'] != "") {
                $this->db->set('cofins', str_replace(",", ".", $_POST['cofins']));
            }
            if ($_POST['csll'] != "") {
                $this->db->set('csll', str_replace(",", ".", $_POST['csll']));
            }
            if ($_POST['iss'] != "") {
                $this->db->set('iss', str_replace(",", ".", $_POST['iss']));
            }
            if ($_POST['valor_base'] != "") {
                $this->db->set('valor_base', str_replace(",", ".", $_POST['valor_base']));
            }
            if ($_POST['entrega'] != "") {
                $this->db->set('entrega', $_POST['entrega']);
            }
            if ($_POST['pagamento'] != "") {
                $this->db->set('pagamento', $_POST['pagamento']);
            }
            if ($_POST['dia_aquisicao'] != "") {
                $this->db->set('dia_aquisicao', $_POST['dia_aquisicao']);
            } else {
                $this->db->set('dia_aquisicao', null);
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
            $this->db->set('tabela', $_POST['tipo']);
            $this->db->set('procedimento1', $_POST['procedimento1']);
            $this->db->set('procedimento2', $_POST['procedimento2']);
            if (isset($_POST['txtdinheiro'])) {
                $this->db->set('dinheiro', $_POST['txtdinheiro']);
            } else {
                $this->db->set('dinheiro', 'f');
            }
            if (isset($_POST['txtcarteira'])) {
                $this->db->set('carteira_obrigatoria', $_POST['txtcarteira']);
            } else {
                $this->db->set('carteira_obrigatoria', 'f');
            }
            $this->db->set('observacao', $_POST['txtObservacao']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtconvenio_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_convenio');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $exame_sala_id = $this->db->insert_id();


                $convenio_id = $exame_sala_id;
                $this->db->select('empresa_id');

                $this->db->from('tb_empresa');
                $this->db->where("ativo", 't');
                $this->db->orderby('empresa_id');
                $empresas = $this->db->get()->result();
                foreach ($empresas as $item) {

                    $this->db->set('empresa_id', $item->empresa_id);
                    $this->db->set('convenio_id', $convenio_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_convenio_empresa');
                }
            } else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_sala_id = $_POST['txtconvenio_id'];
                $this->db->where('convenio_id', $convenio_id);
                $this->db->update('tb_convenio');
            }

            /* Atualiza os valores no procedimento convenio baseado no valor de ajuste informado
              e no valor do porte que está la no cadastro do TUSS. */
            if ($_POST['tipo'] == 'CBHPM') {
                // Só ira recalcular os valores, se o usuario informar que o convenio usa CBHPM
                $this->atualizarValoresProcedimentosCBHPM($exame_sala_id);
            }

            return $exame_sala_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconvenioempresa() {


        $this->db->select('convenio_empresa_id');
        $this->db->from('tb_convenio_empresa ce');
        $this->db->where("ce.ativo", 't');
        $this->db->where('empresa_id', $_POST['empresa']);
        $this->db->where('convenio_id', $_POST['convenio_id']);
        $return = $this->db->get()->result();

        if (count($return) == 0) {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('empresa_id', $_POST['empresa']);
            $this->db->set('convenio_id', $_POST['convenio_id']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_convenio_empresa');

            return true;
        } else {
            return false;
        }
    }

    function excluirconvenioempresa($convenio_empresa_id) {

        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('convenio_empresa_id', $convenio_empresa_id);
        $this->db->update('tb_convenio_empresa');

        return true;
    }

    function gravarcaminhologo($convenio_id, $arquivo) {
        try {

            /* inicia o mapeamento no banco */

            $this->db->set('caminho_logo', $arquivo);
            $this->db->where('convenio_id', $convenio_id);
            $this->db->update('tb_convenio');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarcopia() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $convenio = $_POST['txtconvenio'];
            $grupo = $_POST['grupo'];
//            var_dump($convenio); die;
            $convenioidnovo = $_POST['txtconvenio_id'];
            if ($grupo != '') {
//                var_dump($grupo);
//                die;
                $sql = "INSERT INTO ponto.tb_procedimento_convenio(
                        convenio_id, procedimento_tuss_id, 
                        qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
                        qtdeuco, valoruco, valortotal, ativo, data_cadastro, operador_cadastro, 
                        data_atualizacao, operador_atualizacao)
                        SELECT $convenioidnovo, pc.procedimento_tuss_id, 
                        qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
                        qtdeuco, valoruco, valortotal, pc.ativo, '$horario', $operador_id, 
                        pc.data_atualizacao, pc.operador_atualizacao
                        FROM ponto.tb_procedimento_convenio pc
                        LEFT JOIN ponto.tb_procedimento_tuss pt ON pc.procedimento_tuss_id = pt.procedimento_tuss_id
                        WHERE pt.grupo = '$grupo'
                        AND convenio_id = $convenio
                        AND pc.ativo = 't'
                        AND pc.procedimento_tuss_id NOT IN (
                            SELECT DISTINCT(pc2.procedimento_tuss_id) FROM ponto.tb_procedimento_convenio pc2
                            LEFT JOIN ponto.tb_procedimento_tuss pt2 ON pc2.procedimento_tuss_id = pt2.procedimento_tuss_id
                            WHERE pc2.convenio_id = $convenioidnovo
                            AND pt2.grupo = '$grupo'
                            AND pc2.ativo = 't'
                        )";
            } else {
                $sql = "INSERT INTO ponto.tb_procedimento_convenio(
                        convenio_id, procedimento_tuss_id, 
                        qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
                        qtdeuco, valoruco, valortotal, ativo, data_cadastro, operador_cadastro, 
                        data_atualizacao, operador_atualizacao)
                        SELECT $convenioidnovo, procedimento_tuss_id, 
                        qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
                        qtdeuco, valoruco, valortotal, ativo, '$horario', $operador_id, 
                        data_atualizacao, operador_atualizacao
                        FROM ponto.tb_procedimento_convenio pc
                        WHERE convenio_id = $convenio
                        AND pc.ativo = 't'
                        AND pc.procedimento_tuss_id NOT IN (
                            SELECT DISTINCT(procedimento_tuss_id) FROM ponto.tb_procedimento_convenio
                            WHERE convenio_id = $convenioidnovo
                            AND ativo = 't'
                        )";
            }

            $this->db->query($sql);

            return $convenioidnovo;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($convenio_id) {
//        die;
        if ($convenio_id != 0) {
            $this->db->select('convenio_id,
                                co.nome,
                                co.convenio_grupo_id,
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
                                co.associacao_convenio_id,
                                co.razao_social,
                                co.guia_prestador_unico,
                                co.dia_aquisicao,
                                co.valor_ajuste_cbhpm');
            $this->db->from('tb_convenio co');
            $this->db->join('tb_municipio c', 'c.municipio_id = co.municipio_id', 'left');
            $this->db->join('tb_tipo_logradouro tp', 'tp.tipo_logradouro_id = co.tipo_logradouro_id', 'left');
            $this->db->where("convenio_id", $convenio_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_convenio_id = $convenio_id;
            $this->_nome = $return[0]->nome;
            $this->_convenio_grupo_id = $return[0]->convenio_grupo_id;
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
            $this->_associacao_convenio_id = $return[0]->associacao_convenio_id;
            $this->_guia_prestador_unico = $return[0]->guia_prestador_unico;
            $this->_dia_aquisicao = $return[0]->dia_aquisicao;
            $this->_valor_ajuste_cbhpm = $return[0]->valor_ajuste_cbhpm;
        } else {
            $this->_convenio_id = null;
        }
    }

}

?>
