<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class internacao_model extends BaseModel {

    var $_paciente_id = null;
    var $_nome = null;

    function internacao_model($emergencia_solicitacao_acolhimento_id = null) {
        parent::Model();
        if (isset($emergencia_solicitacao_acolhimento_id)) {
            $this->instanciar($emergencia_solicitacao_acolhimento_id);
        }
    }

    function gravar($paciente_id) {

        try {
            $this->db->set('leito', $_POST['leitoID']);
            $this->db->set('codigo', $_POST['sisreg']);
            $this->db->set('aih', $_POST['aih']);
            $this->db->set('prelaudo', $_POST['central']);
            $this->db->set('medico_id', $_POST['operadorID']);
            $this->db->set('data_internacao', $_POST['data']);
            $this->db->set('forma_de_entrada', $_POST['forma']);
            $this->db->set('estado', $_POST['estado']);
            $this->db->set('carater_internacao', $_POST['carater']);
            $this->db->set('procedimentosolicitado', $_POST['procedimentoID']);
            $this->db->set('cid1solicitado', $_POST['cid1ID']);
            $this->db->set('cid2solicitado', $_POST['cid2ID']);
            $this->db->set('justificativa', $_POST['observacao']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                }
                else
                    $internacao_id = $this->db->insert_id();
                $this->db->set('ativo', 'false');
                $this->db->where('internacao_leito_id', $_POST['leitoID']);
                $this->db->update('tb_internacao_leito');
                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('leito_id', $_POST['leitoID']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_ocupacao');
            }
            else { // update
                $internacao_id = $_POST['internacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_id', $internacao_id);
                $this->db->update('tb_internacao');
            }


            return $internacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarinternacaonutricao($paciente_id) {

        try {
            if ($_POST['leito'] != "") {
                $this->db->set('leito', $_POST['leito']);
            }
            $this->db->set('codigo', $_POST['sisreg']);
            $this->db->set('aih', $_POST['aih']);
            if ($_POST['unidade'] != "") {
                $this->db->set('hospital_id', $_POST['unidade']);
            }
            if ($_POST['data_internacao'] != "") {
                $this->db->set('data_internacao', $_POST['data_internacao']);
            }
            if ($_POST['data_solicitacao'] != "") {
                $this->db->set('data_solicitacao', $_POST['data_solicitacao']);
            }
            $this->db->set('carater_internacao', $_POST['carater']);
            $this->db->set('procedimentosolicitado', $_POST['procedimentoID']);
            $this->db->set('cid1solicitado', $_POST['cid1ID']);
            $this->db->set('justificativa', $_POST['observacao']);
            $this->db->set('solicitante', $_POST['solicitante']);
            $this->db->set('reg', $_POST['reg']);
            $this->db->set('val', $_POST['val']);
            $this->db->set('pla', $_POST['pla']);
            $this->db->set('rx', $_POST['rx']);
            $this->db->set('acesso', $_POST['acesso']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao');
                $internacao_id = $this->db->insert_id();
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return 0;
                } elseif ($_POST['leito'] != "") {
                    $this->db->set('ativo', 'false');
                    $this->db->set('condicao', 'Ocupado');
                    $this->db->where('internacao_leito_id', $_POST['leito']);
                    $this->db->update('tb_internacao_leito');

                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('leito_id', $_POST['leito']);
                    $this->db->set('ocupado', 'false');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_internacao_ocupacao');
                }
            } else { // update
                $internacao_id = $_POST['internacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_id', $internacao_id);
                $this->db->update('tb_internacao');
            }


            return $internacao_id;
        } catch (Exception $exc) {
            return 0;
        }
    }

    function gravarprescricaoenteralnormal($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $this->db->where("data", $dataprescricao);
        $query = $this->db->get();
        $return = $query->result();

        $numero = count($return);

        if ($numero == 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();
        } else {
            $internacao_precricao_id = $return[0]->internacao_precricao_id;
        }

        if ($_POST['produto'] != "Selecione") {

            $this->db->set('etapas', $_POST['etapas']);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id = $this->db->insert_id();

            $i = 0;
            foreach ($_POST['produto'] as $produto) {
                $z = 0;
                $c = 0;
                $i++;
                foreach ($_POST['volume'] as $itemvolume) {
                    $c++;
                    if ($i == $c) {
                        $volume = $itemvolume;
                        break;
                    }
                }
                foreach ($_POST['vazao'] as $itemvazao) {
                    $z++;
                    if ($i == $z) {
                        $vazao = $itemvazao;
                        break;
                    }
                }

                $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('etapas', $_POST['etapas']);
                $this->db->set('tipo', 'ENTERALNORMAL');
                if ($produto != "Selecione") {
                    $this->db->set('produto_id', $produto);
                }
                if ($volume != null) {
                    $this->db->set('volume', $volume);
                }
                if ($vazao != null) {
                    $this->db->set('vasao', $vazao);
                }
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_precricao_produto');
                $internacao_precricao_produto_id = $this->db->insert_id();
            }
        }

        if ($_POST['equipo'] != "Selecione") {

            $this->db->set('etapas', 1);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id_equipo = $this->db->insert_id();

            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id_equipo);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('etapas', 1);
            $this->db->set('tipo', 'ENTERALNORMAL');
            $this->db->set('produto_id', $_POST['equipo']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_produto');
        }
    }

    function gravarprescricaoenteralemergencial($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $this->db->where("data", $dataprescricao);
        $query = $this->db->get();
        $return = $query->result();

        $numero = count($return);

        if ($numero == 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();
        } else {
            $internacao_precricao_id = $return[0]->internacao_precricao_id;
        }

        if ($_POST['produto'] != "Selecione") {

            $this->db->set('etapas', $_POST['etapas']);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id = $this->db->insert_id();

            $i = 0;
            foreach ($_POST['produto'] as $produto) {
                $z = 0;
                $c = 0;
                $i++;
                foreach ($_POST['volume'] as $itemvolume) {
                    $c++;
                    if ($i == $c) {
                        $volume = $itemvolume;
                        break;
                    }
                }
                foreach ($_POST['vazao'] as $itemvazao) {
                    $z++;
                    if ($i == $z) {
                        $vazao = $itemvazao;
                        break;
                    }
                }

                $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('etapas', $_POST['etapas']);
                $this->db->set('tipo', 'ENTERALEMERGENCIAL');
                if ($produto != "Selecione") {
                    $this->db->set('produto_id', $produto);
                }
                if ($volume != null) {
                    $this->db->set('volume', $volume);
                }
                if ($vazao != null) {
                    $this->db->set('vasao', $vazao);
                }
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_precricao_produto');
                $internacao_precricao_produto_id = $this->db->insert_id();
            }
        }

        if ($_POST['equipo'] != "Selecione") {

            $this->db->set('etapas', 1);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id_equipo = $this->db->insert_id();

            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id_equipo);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('etapas', 1);
            $this->db->set('tipo', 'ENTERALEMERGENCIAL');
            $this->db->set('produto_id', $_POST['equipo']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_produto');
        }
    }

    function repetirultimaprescicaoenteralnormal($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $query = $this->db->get();
        $row = $query->last_row();

        $numero = count($row->internacao_precricao_id);
        if ($numero > 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();

            $this->db->select('internacao_precricao_etapa_id, etapas');
            $this->db->from('tb_internacao_precricao_etapa');
            $this->db->where("internacao_precricao_id", $row->internacao_precricao_id);
            $query = $this->db->get();
            $returno = $query->result();
            $numeroetapa = count($returno);

            if ($numeroetapa > 0) {
                foreach ($returno as $item) {
                    $this->db->set('etapas', $item->etapas);
                    $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_internacao_precricao_etapa');
                    $internacao_precricao_etapa_id = $this->db->insert_id();

                    $this->db->select('internacao_precricao_id, internacao_id, etapas, produto_id, volume, vasao');
                    $this->db->from('tb_internacao_precricao_produto');
                    $this->db->where("internacao_precricao_etapa_id", $item->internacao_precricao_etapa_id);
                    $query = $this->db->get();
                    $return = $query->result();
                    $numeroproduto = count($return);


                    if ($numeroproduto > 0) {
                        foreach ($return as $value) {
                            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                            $this->db->set('internacao_id', $value->internacao_id);
                            $this->db->set('etapas', $value->etapas);
                            $this->db->set('tipo', 'ENTERALNORMAL');
                            if ($value->produto_id != "") {
                                $this->db->set('produto_id', $value->produto_id);
                            }
                            if ($value->volume != "") {
                                $this->db->set('volume', $value->volume);
                            }
                            if ($value->vasao != "") {
                                $this->db->set('vasao', $value->vasao);
                            }
                            $this->db->set('empresa_id', $empresa_id);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_internacao_precricao_produto');
                        }
                    }
                }
            }
        }
    }

    function gravarmovimentacao($paciente_id, $leito_id) {

        try {
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $internacao_ocupacao_id = $this->db->insert_id();

                $this->db->set('ativo', 'false');
                $this->db->where('internacao_leito_id', $_POST['leitoID']);
                $this->db->update('tb_internacao_leito');

                $this->db->set('ativo', 'true');
                $this->db->where('internacao_leito_id', $leito_id);
                $this->db->update('tb_internacao_leito');
            }
            return $internacao_ocupacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluiritemprescicao($item_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('ativo', 'false');
            $this->db->where('internacao_precricao_produto_id', $item_id);
            $this->db->update('tb_internacao_precricao_produto');
            return $item_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    private function instanciar($emergencia_solicitacao_acolhimento_id) {
        if ($paciente_id != 0) {

            $this->db->select('tp.tipo_logradouro_id as codigo_logradouro,tp.descricao,p.*,c.nome as cidade_desc,c.municipio_id as cidade_cod,e.estado_id as uf_cod, e.nome as uf_desc');
            $this->db->from('tb_paciente p');
            $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
            $this->db->join('tb_estado e', 'e.estado_id = p.uf_rg', 'left');
            $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
            $this->db->where("paciente_id", $paciente_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_paciente_id = $paciente_id;
            $this->_cpf = $return[0]->cpf;
            $this->_nome = $return[0]->nome;
            $this->_cns = $return[0]->cns;
            if (isset($return[0]->nascimento)) {
                $this->_nascimento = $return[0]->nascimento;
            }
            $this->_idade = $return[0]->idade;
            $this->_documento = $return[0]->rg;
            $this->_estado_id_expedidor = $return[0]->uf_rg;
            $this->_titulo_eleitor = $return[0]->titulo_eleitor;
            $this->_raca_cor = $return[0]->raca_cor;
            $this->_sexo = $return[0]->sexo;
            $this->_estado_civil = $return[0]->estado_civil_id;
            $this->_nomepai = $return[0]->nome_pai;
            $this->_nomemae = $return[0]->nome_mae;
            $this->_telMae = $return[0]->telefone_mae;
            $this->_telefone = $return[0]->telefone;
            $this->_tipoLogradouro = $return[0]->codigo_logradouro;
            $this->_numero = $return[0]->numero;
            $this->_rua = $return[0]->logradouro;
            $this->_bairro = $return[0]->bairro;
            $this->_cidade = $return[0]->municipio_id;
            $this->_cep = $return[0]->cep;
            $this->_observacao = $return[0]->observacao;
            $this->_complemento = $return[0]->complemento;
            $this->_estado_expedidor = $return[0]->uf_desc;
            $this->_estado_id_expedidor = $return[0]->uf_cod;
            $this->_cidade_nome = $return[0]->cidade_desc;
            $this->_data_emissao = $return[0]->data_emissao;
        }
    }

    function listaunidade() {
        $this->db->select(' internacao_unidade_id,
                            nome');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarunidade($unidade_id) {
        $this->db->select(' internacao_unidade_id,
                            nome');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('internacao_unidade_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaprodutosenteral($internacao_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_paciente p', 'p.convenio_id = pc.convenio_id ');
        $this->db->join('tb_internacao i', 'i.paciente_id = p.paciente_id ');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'ENTERAL');
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprodutosequipo($internacao_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_paciente p', 'p.convenio_id = pc.convenio_id ');
        $this->db->join('tb_internacao i', 'i.paciente_id = p.paciente_id ');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesenteral($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ', 'left');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ', 'left');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('ipp.tipo', 'ENTERALNORMAL');
        $this->db->where('ip.data', $data);
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesenteralemergencial($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ', 'left');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ', 'left');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('ipp.tipo', 'ENTERALEMERGENCIAL');
        $this->db->where('ip.data', $data);
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoespaciente($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ip.data,
                            ip.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('pt.grupo !=', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoespacienteequipo($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesdata() {
        $data = date("Y-m-d");
        $this->db->select(' ip.data,
                            ip.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome,
                            p.nome as paciente');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = i.hospital');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito');
        $this->db->where('ip.data >=', $_POST['txtdata_inicio']);
        $this->db->where('ip.data <=', $_POST['txtdata_fim']);
        $this->db->where('ipp.tipo', $_POST['tipo']);
        if ($_POST['unidade'] != 0) {
            $this->db->where('i.hospital_id', $_POST['unidade']);
        }
        $this->db->where('pt.grupo !=', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesequipodata() {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->where('ip.data >=', $_POST['txtdata_inicio']);
        $this->db->where('ip.data <=', $_POST['txtdata_fim']);
        $this->db->where('ipp.tipo', $_POST['tipo']);
        if ($_POST['unidade'] != 0) {
            $this->db->where('i.hospital_id', $_POST['unidade']);
        }
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitointarnacao($unidade_id) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('il.ativo', 't');
        $this->db->where('il.condicao', 'Vago');
        $this->db->where('iu.internacao_unidade_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function buscaPaciente($pacienteId) {

        $this->db->from('tb_paciente')
                ->select('nome');
        $this->db->where('paciente_id', pacienteId);
        return $this->db;
    }

    function listar($args = array()) {
        $this->db->select(' i.internacao_id,
                            i.paciente_id,
                            p.nome,
                            i.data_internacao');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->where('i.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
                $this->db->orwhere('i.paciente_id', $args['nome']);
            }
        }
        return $this->db;
    }

    function listarinternacao($parametro) {
        $this->db->select('p.descricao,
                           cid.no_cid as nomecid,
                           cid.co_cid as codcid,
                           i.data_internacao,
                           o.nome as medico,
                           i.procedimentosolicitado,
                           i.estado');
        $this->db->from('tb_internacao i ');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado');
        $this->db->join('tb_procedimento p', 'p.procedimento = i.procedimentosolicitado');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id');
        $this->db->where('i.ativo', 't');
        if ($parametro != null) {
            $this->db->where('paciente_id', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarleitosinternacao($parametro) {
        $this->db->select('io.leito_id,
                           io.data_cadastro,
                           io.operador_cadastro,
                           io.internacao_ocupacao_id,
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           o.nome as operador');
        $this->db->from('tb_internacao_ocupacao io');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = io.leito_id');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_operador o', 'o.operador_id = io.operador_cadastro');
        $this->db->where('paciente_id', $parametro);
        $this->db->orderby('io.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleito($args = array()) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome,
                            ienome as enfermaria,
                            iu.nome as unidade,
                            il.tipo');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('ie.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('il.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('ie.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('iu.nome ilike', "%" . $args['nome'] . "%");
            }
        }
        return $this->db;
    }

    function listaprocedimentoautocomplete($parametro = null) {
        $this->db->select(' procedimento,
                            descricao');
        $this->db->from('tb_procedimento');
        if ($parametro != null) {
            $this->db->where('descricao ilike', "%" . $parametro . "%");
            $this->db->orwhere('procedimento ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listacidautocomplete($parametro = null) {
        $this->db->select(' co_cid,
                            no_cid');
        $this->db->from('tb_cid');
        if ($parametro != null) {
            $this->db->where('no_cid ilike', "%" . $parametro . "%");
            $this->db->orwhere('co_cid ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function verificainternacao($paciente_id) {
        $this->db->select();
        $this->db->from('tb_internacao');
        $this->db->where("ativo", 'true');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

}

?>
