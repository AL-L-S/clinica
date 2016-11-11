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
                            nome');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listardados() {
        $this->db->select('convenio_id,
                            nome,
                            dinheiro,
                            conta_id');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
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

    function listarconvenionaodinheiro() {
        $this->db->select('convenio_id,
                            nome');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->where("dinheiro", 'f');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($convenio_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('convenio_id', $convenio_id);
        $this->db->update('tb_convenio');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
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
                      where convenio_id = convenio_id and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        } else {
                            $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = (valortotal * $ajustetotal) + valortotal
                      where convenio_id = convenio_id and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        }
                    } else {
                        $sql = "update ponto.tb_procedimento_convenio
                    set valorch = CEIL((valorch * $ajustech) + valorch), 
                    valorfilme = CEIL((valorfilme * $ajustefilme) + valorfilme),
                    valorporte = CEIL((valorporte * $ajusteporte) + valorporte),                        
                    valoruco = CEIL((valoruco * $ajusteuco) + valoruco),
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where convenio_id = $convenioid and procedimento_tuss_id = $procedimento_tuss_id;";
                        $this->db->query($sql);
                        if ($_POST['ajustetotal'] == '') {
                            $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = CEIL((valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco))
                      where convenio_id = convenio_id and procedimento_tuss_id = $procedimento_tuss_id;";
                            $this->db->query($sqll);
                        } else {
                            $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = CEIL((valortotal * $ajustetotal) + valortotal)
                      where convenio_id = convenio_id and procedimento_tuss_id = $procedimento_tuss_id;";
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
                      where convenio_id = convenio_id;";
                        $this->db->query($sqll);
                    } else {
                        $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = (valortotal * $ajustetotal) + valortotal
                      where convenio_id = convenio_id;";
                        $this->db->query($sqll);
                    }
                } else {
                    $sql = "update ponto.tb_procedimento_convenio
                    set valorch = CEIL((valorch * $ajustech) + valorch), 
                    valorfilme = CEIL((valorfilme * $ajustefilme) + valorfilme),
                    valorporte = CEIL((valorporte * $ajusteporte) + valorporte),                        
                    valoruco = CEIL((valoruco * $ajusteuco) + valoruco),
                    operador_atualizacao = $operador_id,
                    data_atualizacao = '$data'                    
                    where convenio_id = $convenioid;";
                    $this->db->query($sql);

                    if ($_POST['ajustetotal'] == '') {
                        $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = CEIL((valorch * qtdech) + (valorfilme * qtdefilme) + (valorporte * qtdeporte) + (valoruco * qtdeuco))
                      where convenio_id = convenio_id;";
                        $this->db->query($sqll);
                    } else {
                        $sqll = "update ponto.tb_procedimento_convenio
                      set valortotal = CEIL((valortotal * $ajustetotal) + valortotal)
                      where convenio_id = convenio_id;";
                        $this->db->query($sqll);
                    }
                }
            }


            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $convenio_id = $_POST['txtconvenio_id'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('cnpj', $_POST['txtCNPJ']);
            $this->db->set('registroans', $_POST['txtregistroans']);
            $this->db->set('codigoidentificador', $_POST['txtcodigo']);
            if ($_POST['credor_devedor'] != "") {
                $this->db->set('credor_devedor_id', $_POST['credor_devedor']);
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
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_sala_id = $_POST['txtconvenio_id'];
                $this->db->where('convenio_id', $convenio_id);
                $this->db->update('tb_convenio');
            }
            return $exame_sala_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarcopia() {
        try {
            $convenio = $_POST['txtconvenio'];
            $convenioidnovo = $_POST['txtconvenio_id'];
            $sql = "INSERT INTO ponto.tb_procedimento_convenio(
            convenio_id, procedimento_tuss_id, 
            qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
            qtdeuco, valoruco, valortotal, ativo, data_cadastro, operador_cadastro, 
            data_atualizacao, operador_atualizacao)
            SELECT $convenioidnovo, procedimento_tuss_id, 
            qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
            qtdeuco, valoruco, valortotal, ativo, data_cadastro, operador_cadastro, 
            data_atualizacao, operador_atualizacao
            FROM ponto.tb_procedimento_convenio
                where convenio_id = $convenio";
            $this->db->query($sql);

            return $convenioidnovo;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($convenio_id) {

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
                                co.municipio_id,
                                co.logradouro,
                                co.cnpj,
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
                                co.razao_social');
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
        } else {
            $this->_convenio_id = null;
        }
    }

}

?>
