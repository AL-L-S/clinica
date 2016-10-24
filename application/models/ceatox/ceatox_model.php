<?php

require_once APPPATH . 'models/base/BaseModel.php';

class Ceatox_model extends BaseModel
{
    /* Propriedades da classe */

    var $_ficha_id = null;
    var $_gruporesposta_id = null;
    var $_numero = null;
    var $_data = null;
    var $_paciente_id = null;
    var $_hora = null;
    var $_diagnostico_definitivo = null;
    var $_atendimento = null;
    var $_ocorrencia = null;
    var $_circunstancia = null;
    var $_zona = null;
    var $_local = null;
    var $_via = null;
    var $_exposicao = null;
    var $_manifestacao = null;
    var $_internacao = null;
    var $_toxicologia = null;
    var $_avaliacao = null;
    var $_evolucao = null;
    var $_enderecoPaciente = null;
    var $_idadePaciente = null;
    var $_idadeTipoPaciente = null;
    var $_sexoPaciente = null;
    var $_municipioIdPaciente = null;
    var $_municipioPaciente = null;
    var $_ufPaciente = null;
    var $_bairroPaciente = null;
    var $_cepPaciente = null;
    var $_nomeMaePaciente = null;
    var $_nomeSolicitante = null;
    var $_temp_solicitante_id = null;
    var $_enderecoSolicitante = null;
    var $_bairroSolicitante = null;
    var $_municipioIdSolicitante = null;
    var $_municipioSolicitanteNome = null;
    var $_ufEstadoSolicitante = null;
    var $_instituicaoSolicitante = null;
    var $_telefoneSolicitante = null;
    var $_ramalSolicitante = null;
    var $_nomePaciente = null;
    var $_telefonePaciente = null;
    var $_tipo = null;
    var $_agente = null;
    var $_tratamento = array();
    var $_peso = null;
    var $_paciente = null;
    var $_cns = null;
    var $_categoria = null;

    /**
     * Método criado para atender uma necessidade temporária
     * @author Vicente Armando
     * @return <type>
     */
    function gravarSolicitante()
    {
        try {
            $this->db->set('nome', $_POST['nome_solicitante']);


            $this->db->set('endereco', $_POST['end_solicitante']);

            $this->db->set('bairro', $_POST['bairro_solicitante']);
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['tel_solicitante']))));
            $this->db->set('municipio_id', $_POST['municipio_id_solicitante']);

            $this->db->set('bairro', $_POST['bairro_solicitante']);
            if ($_POST['municipio_id_solicitante'] != null)
                $this->db->set('municipio_id', $_POST['municipio_id_solicitante']);
            else
                $this->db->set('municipio_id', null);
            $this->db->set('ramal', $_POST['ramal_tel_solicitante']);
            $this->db->set('instituicao', $_POST['instituicao_solicitante']);

            if ($_POST['temp_solicitante_id'] == "") {// insert
                $this->db->insert('tb_temp_solicitante');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                }
                else
                    $temp_solicitante_id = $this->db->insert_id();
            }else { // update
                $temp_solicitante_id = $_POST['temp_solicitante_id'];
                $this->db->where('temp_solicitante_id', $temp_solicitante_id);
                $this->db->update('tb_temp_solicitante');
            }

            return $temp_solicitante_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    /* Método construtor */

    function Ceatox_model($ficha_id=null)
    {
        parent::Model();

        if (isset($ficha_id)) {
            $this->instanciar($ficha_id);
        }
    }

    function totalRegistros($parametro)
    {
        $this->db->select('ficha_id');
        $this->db->from('tb_ceatox_ficha');
        if ($parametro != null && $parametro != -1) {
            $this->db->where('numero ilike', $parametro . "%");
            $this->db->orwhere('numero_registro ilike', $parametro . "%");
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarGrupoResposta($classeresposta)
    {
        $sql = "SELECT
                    gruporesposta_id,
                    descricao
                    FROM ijf.tb_ceatox_gruporesposta
                    WHERE classeresposta_id = $classeresposta
                    ORDER BY descricao
            ";

        return $this->db->query($sql)->result();
    }

    function deletarficha($ficha_id)
    {
        $sql = "DELETE FROM ijf.tb_ceatox_resposta_exposicao
                 WHERE ficha_id = $ficha_id;
                DELETE FROM ijf.tb_ceatox_resposta_agentetoxico
                WHERE ficha_id =$ficha_id;
                DELETE FROM ijf.tb_ceatox_resposta
                WHERE ficha_id = $ficha_id;
                DELETE FROM ijf.tb_ceatox_observacao
                WHERE ficha_id = $ficha_id;
                DELETE FROM ijf.tb_ceatox_evolucao
                WHERE ficha_id =  $ficha_id;
                DELETE FROM ijf.tb_ceatox_ficha
                WHERE ficha_id =  $ficha_id;
            ";
        $this->db->query($sql);
        return true;
    }

    function listarobservacao($ficha_id)
    {
        $this->db->select('co.ficha_id as ficha,
                                       co.observacao,
                                       co.observacao_id,
                                       tp.nome');
        $this->db->from('tb_ceatox_observacao co');
        $this->db->join('tb_ceatox_ficha cf', 'cf.ficha_id = co.ficha_id');
        $this->db->join('tb_temp_paciente tp', 'tp.temp_paciente_id = cf.paciente_id');
        $this->db->where('co.ficha_id', $ficha_id);
        $this->db->orderby('co.ficha_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarevolucao($ficha_id)
    {

        $this->db->select('r.evolucao_id,
                                       r.ficha_id,
                                       r.gruporesposta_id,
                                       gr.descricao AS nome,
                                       r.descricao');
        $this->db->from('tb_ceatox_evolucao r');
        $this->db->join('tb_ceatox_gruporesposta gr', 'gr.gruporesposta_id = r.gruporesposta_id');
        $this->db->where('r.ficha_id', $ficha_id);
        //$this->db->where('r.gruporesposta_id in (163,164,165,166,167,168,169)');
        $this->db->orderby('r.ficha_id');
        $return = $this->db->get();

        return $return->result();
    }

    function gravarobservacao()
    {
        try {
            $this->db->set('ficha_id', $_POST['txtFichaID']);
            $this->db->set('observacao', $_POST['txtObservacao']);
            $this->db->insert('tb_ceatox_observacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarevolucao()
    {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('ficha_id', $_POST['txtFichaID']);
            $this->db->set('descricao', $_POST['evolucao_desc']);
            $this->db->set('gruporesposta_id', $_POST['evolucao']);
            $this->db->insert('tb_ceatox_evolucao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function listarTratamento()
    {
        $sql = "SELECT
                    gruporesposta_id,
                    descricao
                    FROM ijf.tb_ceatox_gruporesposta
                    WHERE classeresposta_id = 11 OR classeresposta_id = 12 OR classeresposta_id=13
                    ORDER BY descricao
            ";

        return $this->db->query($sql)->result();
    }

    function fichaRelatorio($ficha_id)
    {
        $sql = "SELECT
                    numero,
                    data,
                    numero_registro,
                    paciente_id,
                    peso,
                    hora,
                    diagnostico_definitivo
                    FROM ijf.tb_ceatox_ficha
                    WHERE ficha_id = $ficha_id
                    ORDER BY numero
            ";

        return $this->db->query($sql)->result();
    }

    function listarAgentesFicha($ficha_id)
    {
        $sql = "SELECT
                    *
                    FROM ijf.tb_ceatox_resposta_agentetoxico tb
                    left join ijf.tb_ceatox_gruporesposta tg on tb.gruporesposta_id = tg.gruporesposta_id
                    WHERE ficha_id = $ficha_id and classeresposta_id = 9
                    ORDER BY respostaagentetoxico_id
            ";

        return $this->db->query($sql)->result();
    }

    function listarCentro()
    {
        $sql = "SELECT
                    centro_id,
                    nome
                    FROM ijf.tb_ceatox_centro
                    ORDER BY nome
            ";

        return $this->db->query($sql)->result();
    }

    function criaFicha()
    {
        try {
            $sql = "INSERT INTO ijf.tb_ceatox_ficha (numero,data,numero_registro,paciente_id,peso,vitima,gestante,solicitante_id,categoria,cid,hora,diagnostico_definitivo) VALUES
                (0,'01/01/1010',1,2,3,4,5,6,7,9,'00:01',8)";

            $this->db->query($sql);
            return $this->db->insert_id();
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravar($ficha_id, $paciente_id, $solicitante_id)
    {
        try {
            $num_ficha = $_POST['n_ficha'];

            $data = $_POST['data_ficha'];
            $hora = $_POST['hora_ficha'];
            $num_atendimento = $_POST['num_atendimento'];

            //$peso = $_POST['peso_paciente'];
            $vitima = $_POST['tipo_vitima'];
            $gestante = $_POST['gestante'];

            $categoria = $_POST['categoria'];
            $diag_defin = $_POST['diag_defin'];
            $cid = $_POST['cid'];

            if ($_POST['atendimento'] != -1) {
                $gruporesposta_atendimento = $_POST['atendimento'];
                $descricao_atendimento = $_POST['atendimento_desc'];

                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id,$gruporesposta_atendimento,'$descricao_atendimento')");
                else
                    $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $gruporesposta_atendimento . ",descricao='" . $descricao_atendimento . "' where ficha_id=" . $_POST['fichaId'];

                $this->db->query($sql);
            }
            else
                $gruporesposta_atendimento = null;

            if ($_POST['tipo_ocorrencia'] != -1) {
                $descricao_ocorrencia = $_POST['tipo_ocorrencia_desc'];
                $gruporesposta_ocorrencia = $_POST['tipo_ocorrencia'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id,$gruporesposta_ocorrencia,'$descricao_ocorrencia')");
                else
                    $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $gruporesposta_ocorrencia . ",descricao='" . $descricao_ocorrencia . "' where ficha_id=" . $_POST['fichaId'];

                $this->db->query($sql);
            }
            else
                $gruporesposta_ocorrencia = null;



            if ($_POST['circunstancia'] != -1) {
                $gruporesposta_circunstancia = $_POST['circunstancia'];
                $descricao_circunstancia = $_POST['circunstancia_ocorrencia_desc'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id,$gruporesposta_circunstancia,'$descricao_circunstancia')");
                else
                    $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $gruporesposta_circunstancia . ",descricao='" . $descricao_circunstancia . "' where ficha_id=" . $_POST['fichaId'];

                $this->db->query($sql);
            }
            else
                $gruporesposta_circunstancia = null;


            if ($_POST['zona'] != -1) {
                $gruporesposta_zona = $_POST['zona'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id,$gruporesposta_zona,'')");
                else
                    $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $gruporesposta_zona . " where ficha_id=" . $_POST['fichaId'];

                $this->db->query($sql);
            }
            else
                $gruporesposta_zona = null;
            if ($_POST['local'] != -1) {
                $gruporesposta_local = $_POST['local'];
                $descricao_local = $_POST['local_desc'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id,$gruporesposta_local,'$descricao_local')");
                else
                    $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $gruporesposta_local . ",descricao='" . $descricao_local . "' where ficha_id=" . $_POST['fichaId'];

                $this->db->query($sql);
            }
            else
                $gruporesposta_local = null;

            if ($_POST['via'] != -1) {
                $descricao_via = $_POST['via_desc'];
                $gruporesposta_via = $_POST['via'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id,$gruporesposta_via,'$descricao_via')");
                else
                    $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $gruporesposta_via . ",descricao='" . $descricao_via . "' where ficha_id=" . $_POST['fichaId'];

                $this->db->query($sql);
            }
            else
                $gruporesposta_via = null;

            if ($_POST['tipo_exposicao'] != -1) {

                if ($_POST['tempo_decor_exp'] == "") {
                    $tempo_exposicao = 0;
                } else {
                    $tempo_exposicao = str_replace(",", ".", $_POST['tempo_decor_exp']);
                }
                $tempo_exposicao_metrica = $_POST['tempo_decor_exp_metrica'];
                if ($_POST['duracao_exp'] == "") {
                    $duracao_exposicao = 0;
                } else {
                    $duracao_exposicao = str_replace(",", ".", $_POST['duracao_exp']);
                }
                $duracao_exposicao_metrica = $_POST['duracao_exp_metrica'];
                $gruporesposta_exposicao = $_POST['tipo_exposicao'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta_exposicao (gruporesposta_id,ficha_id,tempo_exposicao_valor,tempo_exposicao_metrica,duracao_exposicao_valor,duracao_exposicao_metrica) VALUES ($gruporesposta_exposicao,$ficha_id,$tempo_exposicao,'$tempo_exposicao_metrica',$duracao_exposicao,'$duracao_exposicao_metrica')");
                else
                    $sql="update ijf.tb_ceatox_resposta_exposicao set gruporesposta_id = " . $gruporesposta_exposicao . ",tempo_exposicao_valor=" . $tempo_exposicao . ",tempo_exposicao_metrica='" . $tempo_exposicao_metrica . "',duracao_exposicao_valor=" . $duracao_exposicao . ",duracao_exposicao_metrica='" . $duracao_exposicao_metrica . "' where ficha_id=" . $_POST['fichaId'];
                echo($sql);
                $this->db->query($sql);
            }else {
                $gruporesposta_exposicao = null;
            }

            if ($_POST['manif_clinica'] != -1) {
                $manifestacao = $_POST['manif_clinica'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id,$manifestacao,'')");
                else
                    $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $manifestacao . ",descricao='' where ficha_id=" . $_POST['fichaId'];

                $this->db->query($sql);
            }
            else
                $manifestacao = null;
            if ($_POST['internacao'] != -1) {
                $internacao = $_POST['internacao'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id,$internacao,'')");
                else
                    $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $internacao . ",descricao='' where ficha_id=" . $_POST['fichaId'];

                $this->db->query($sql);
            }
            else
                $internacao = null;
            if ($_POST['toxicologica'] != -1) {
                $toxicologica = $_POST['toxicologica'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id, $toxicologica , '$toxicologica_desc')");
                else
                    $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $toxicologica . ",descricao='" . $toxicologica_desc . "' where ficha_id=" . $_POST['fichaId'];

                $this->db->query($sql);
            }
            else
                $toxicologica = null;
            $toxicologica_desc = $_POST['toxicologica_desc'];

            $avaliacao = $_POST['aval'];
            if ($_POST['acao'] == 0)
                $sql = ("INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id,$avaliacao,'')");
            else
                $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $avaliacao . ",descricao='' where ficha_id=" . $_POST['fichaId'];

            $this->db->query($sql);


            if ($_POST['evolucao'] != -1) {
                $evolucao = $_POST['evolucao'];
                if ($_POST['acao'] == 0)
                    $sql = ("INSERT INTO ijf.tb_ceatox_evolucao (ficha_id,gruporesposta_id,descricao) VALUES ($ficha_id, $evolucao , '$evolucao_desc')");
                else
                    $sql="update ijf.tb_ceatox_evolucao set gruporesposta_id = " . $evolucao . ",descricao='" . $evolucao_desc . "' where ficha_id=" . $_POST['fichaId'];
                $this->db->query($sql);
            }
            else
                $evolucao = null;
            $evolucao_desc = $_POST['evolucao_desc'];
            $sql = "UPDATE ijf.tb_ceatox_ficha SET numero='$num_ficha',data='$data',numero_registro='$num_atendimento',paciente_id=$paciente_id,peso=0,vitima=$vitima,gestante=$gestante,solicitante_id=$solicitante_id,categoria=$categoria,hora='$hora',diagnostico_definitivo='$diag_defin'";
            if ($_POST['cid'] != '')
                $sql = $sql . ",cid = '$cid'";
            else
                $sql = $sql . ",cid=null";
            $sql = $sql . " WHERE ficha_id=" . $ficha_id;
            $this->db->query($sql);

            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarAgente($ficha_id)
    {
        try {
            $i = -1;

            foreach ($_POST['agenteToxico'] as $agentetoxico) {

                $z = -1;
                $x = -1;
                $y = -1;
                $w = -1;
                $i++;
                foreach ($_POST['nomeComercial'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $nomeComercial = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['dose'] as $itemdose) {
                    $x++;
                    if ($i == $x) {
                        $dose = $itemdose;
                        break;
                    }
                }
                foreach ($_POST['classificacao'] as $itemclassificacao) {
                    $y++;
                    if ($i == $y) {
                        $classificacao = $itemclassificacao;
                        break;
                    }
                }
                foreach ($_POST['clandestino'] as $itemclandestino) {
                    $w++;
                    if ($i == $w) {
                        $clandestino = $itemclandestino;
                        break;
                    }
                }

                if ($agentetoxico != -1) {
                    if ($_POST['acao'] == 0)
                        $sql = "INSERT INTO ijf.tb_ceatox_resposta_agentetoxico
                           (gruporesposta_id,ficha_id,nomecomercial_especie,dose_quantidade,classificacao,clandestino) VALUES
                           ('$agentetoxico','$ficha_id','$nomeComercial','$dose','$classificacao','$clandestino')";
                    else
                        $sql = "update ijf.tb_ceatox_resposta_agentetoxico
                           set gruporesposta_id = " . $agentetoxico . ",nomecomercial_especie='" . $nomeComercial . "',dose_quantidade='" . $dose .
                                ",classificacao='" . $classificacao . ",clandestino='" . $clandestino . "' where ficha_id = " . $_POST['fichaId'];
                    $this->db->query($sql);
                }
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirobservacao($observacao_id)
    {

        $this->db->where('observacao_id', $observacao_id);
        $this->db->delete('tb_ceatox_observacao');

        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    function excluirevolucao($evolucao_id)
    {
        $this->db->where('evolucao_id', $evolucao_id);
        $this->db->delete('tb_ceatox_evolucao');

        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    function listarFichas($args = array())
    {

        $this->db->select('cf.ficha_id,
                           cf.numero,
                           tp.nome,
                           cf.data,
                           cf.hora,
                           cf.diagnostico_definitivo');
        $this->db->from('tb_ceatox_ficha cf');
        $this->db->join('tb_temp_paciente tp', 'tp.temp_paciente_id = cf.paciente_id');
        if ($args) {
            if (isset($args['pacienet_nome']) && strlen($args['pacienet_nome']) > 0) {
//                $this->db->like('tb_ceatox_ficha.numero', $args['nome'], 'left');
                $this->db->where('tp.nome ilike', $args['pacienet_nome'] . "%", 'left');
                //$this->db->orwhere('tb_ceatox_ficha. ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function retornaUltimaFicha()
    {
        $sql = 'select max(numero) as valor from ijf.tb_ceatox_ficha';
        $return = $this->db->query($sql)->result();
        return $return[0]->valor;
    }

    function gravarTratamento($ficha_id)
    {
        try {

            $i = $_POST['variavel'];
            for ($b = 2; $b <= $i; $b++) {


                if (isset($_POST['tratamentoa' . $b])) {

                    if ($_POST['acao'] == 0)
                        $sql = "INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id) VALUES ($ficha_id," . $_POST['tratamentoa' . $b] . ")";
                    else
                        $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $_POST['tratamentoa' . $b] . " where ficha_id=" . $_POST['fichaId'];

                    $this->db->query($sql);
                }
                if (isset($_POST['tratamentob' . $b])) {
                    if ($_POST['acao'] == 0)
                        $sql = "INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id) VALUES ($ficha_id," . $_POST['tratamentob' . $b] . ")";
                    else
                        $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $_POST['tratamentob' . $b] . " where ficha_id=" . $_POST['fichaId'];

                    $this->db->query($sql);
                }
                if (isset($_POST['tratamentoc' . $b])) {
                    if ($_POST['acao'] == 0)
                        $sql = "INSERT INTO ijf.tb_ceatox_resposta (ficha_id,gruporesposta_id) VALUES ($ficha_id," . $_POST['tratamentoc' . $b] . ")";
                    else
                        $sql="update ijf.tb_ceatox_resposta set gruporesposta_id = " . $_POST['tratamentoc' . $b] . " where ficha_id=" . $_POST['fichaId'];

                    $this->db->query($sql);
                }
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function instanciar($ficha_id)
    {
        if ($ficha_id != 0) {
            $this->db->select('ficha.ficha_id,
                                ficha.numero as num,
                                data,
                                paciente_id,
                                numero_registro,
                                diagnostico_definitivo,
                                ficha.cid,
                                hora,
                                categoria,
                                diagnostico_definitivo,
                                
                                paciente.nome as nomepaciente,
                                paciente.logradouro as enderecopaciente,
                                paciente.idade as idadepaciente,
                                paciente.idade_tipo as idadetipopaciente,
                                paciente.sexo as sexopaciente,
                                paciente.peso as peso,
                                paciente.cns as cns,
                                paciente.profissao as profissao,
                                paciente.municipio_id as municipioidpaciente,
                                municipio.nome as municipiopaciente,
                                municipio.estado as ufpaciente,
                                municipio1.nome as municipioSolicitanteNome,
                                municipio1.estado as ufEstadoSolicitante,
                                paciente.bairro as bairropaciente,
                                paciente.cep as ceppaciente,
                                paciente.nome_mae as nomemaepaciente,
                                paciente.telefone as telefonepaciente,
                                solicitante.nome as nomeSolicitante,
                                solicitante.temp_solicitante_id,
                                solicitante.endereco as enderecoSolicitante,
                                solicitante.bairro as bairroSolicitante,
                                solicitante.instituicao as instituicao,
                                solicitante.municipio_id as municipioIdSolicitante,
                                exposicao.gruporesposta_id as exposicao_id,
                                tempo_exposicao_valor,
                                tempo_exposicao_metrica,
                                duracao_exposicao_valor,
                                duracao_exposicao_metrica,
                                ocorrencia.gruporesposta_id as ocorrencia_id,
                                solicitante.instituicao as instituicaoSolicitante,
                                solicitante.telefone as telefoneSolicitante,
                                solicitante.ramal as ramalSolicitante');
            $this->db->from('tb_ceatox_ficha ficha');
            $this->db->join('tb_temp_paciente paciente', 'paciente.temp_paciente_id = ficha.paciente_id', 'left');
            $this->db->join('tb_municipio municipio', 'paciente.municipio_id = municipio.municipio_id', 'left');
            $this->db->join('tb_temp_solicitante solicitante', 'solicitante.temp_solicitante_id = ficha.solicitante_id', 'left');
            $this->db->join('tb_municipio municipio1', 'solicitante.municipio_id = municipio1.municipio_id', 'left');
            $this->db->join('tb_ceatox_resposta ocorrencia', 'ocorrencia.ficha_id = ficha.ficha_id', 'left');
            $this->db->join('tb_ceatox_resposta_exposicao exposicao', 'exposicao.ficha_id = ficha.ficha_id', 'left');
            $this->db->where("ficha.ficha_id", $ficha_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_cns = $return[0]->cns;
            $this->_categoria = $return[0]->categoria;
            $this->_numero_registro = $return[0]->numero_registro;
            $this->_ficha_id = $return[0]->ficha_id;
            $this->valor = $return[0]->num;
            $this->_data = $return[0]->data;
            $this->_paciente_id = $return[0]->paciente_id;
            $this->_hora = $return[0]->hora;
            $this->_diagnostico_definitivo = $return[0]->diagnostico_definitivo;

            $this->_cid = $return[0]->cid;
            $this->_diagnostico_definitivo = $return[0]->diagnostico_definitivo;


            $this->_tempo_valor = $return[0]->tempo_exposicao_valor;

            $this->_tempo_metrica = $return[0]->tempo_exposicao_metrica;
            $this->_duracao_valor = $return[0]->duracao_exposicao_valor;
            $this->_duracao_metrica = $return[0]->duracao_exposicao_metrica;



            $this->_ocorrencia = $return[0]->ocorrencia_id;
            $this->_enderecoPaciente = $return[0]->enderecopaciente;
            $this->_idadePaciente = $return[0]->idadepaciente;
            $this->_peso = $return[0]->peso;
            $this->_profissao = $return[0]->profissao;
            $this->_idadeTipoPaciente = $return[0]->idadetipopaciente;
            $this->_sexoPaciente = $return[0]->sexopaciente;
            $this->_municipioIdPaciente = $return[0]->municipioidpaciente;
            $this->_municipioPaciente = $return[0]->municipiopaciente . ' - ' . $return[0]->ufpaciente;
            ;
            $this->_bairroPaciente = $return[0]->bairropaciente;
            $this->_telefonePaciente = $return[0]->telefonepaciente;
            $this->_cepPaciente = $return[0]->ceppaciente;
            $this->_nomeMaePaciente = $return[0]->nomemaepaciente;
            $this->_nomeSolicitante = $return[0]->nomesolicitante;
            $this->_temp_solicitante_id = $return[0]->temp_solicitante_id;
            $this->_enderecoSolicitante = $return[0]->enderecosolicitante;
            $this->_bairroSolicitante = $return[0]->bairrosolicitante;
            $this->_bairroSolicitante = $return[0]->bairrosolicitante;
            $this->_municipioSolicitante = $return[0]->municipiosolicitantenome . ' - ' . $return[0]->ufestadosolicitante;
            $this->_municipioIdSolicitante = $return[0]->municipioidsolicitante;
            $this->_instituicaoSolicitante = $return[0]->instituicaosolicitante;
            $this->_telefoneSolicitante = $return[0]->telefonesolicitante;
            $this->_ramalSolicitante = $return[0]->ramalsolicitante;
            $this->_nomePaciente = $return[0]->nomepaciente;
            $this->_instituicao = $return[0]->instituicao;




            $this->db->select();
            $this->db->from('tb_ceatox_resposta re');
            $this->db->join('tb_ceatox_gruporesposta ce', 're.gruporesposta_id = ce.gruporesposta_id', 'left');
            $this->db->where("ficha_id", $ficha_id);
            $query = $this->db->get();
            $return = $query->result();

            foreach ($return as $value) {
                switch ($value->classeresposta_id) {

                    case 1:

                        $this->_atendimento = $value->gruporesposta_id;
                        break;
                    case 2:

                        $this->_atendimento = $value->gruporesposta_id;
                        break;
                    case 3:

                        $this->_ocorrencia = $value->gruporesposta_id;
                        break;
                    case 4:
                        $this->_circunstancia = $value->gruporesposta_id;
                        break;
                    case 5:

                        $this->_zona = $value->gruporesposta_id;
                        break;
                    case 6:

                        $this->_local = $value->gruporesposta_id;
                        break;
                    case 7:

                        $this->_via = $value->gruporesposta_id;
                        break;
                    case 8:

                        $this->_tipo = $value->gruporesposta_id;
                        break;
                    case 9:

                        $this->_agente = $value->gruporesposta_id;
                        break;
                    case 13:

                        $this->_manifestacao = $value->gruporesposta_id;
                        break;
                    case 14:

                        $this->_internacao = $value->gruporesposta_id;
                        break;
                    case 15:

                        $this->_toxicologia = $value->gruporesposta_id;
                        break;
                    case 17:

                        $this->_avaliacao = $value->gruporesposta_id;
                        break;

                    case 16:

                        $this->_evolucao = $value->gruporesposta_id;
                        break;
                }
                switch ($value->gruporesposta_id) {
                    case 102:

                        $this->_tratamento["tratamentoinicial2"] = $value->gruporesposta_id;

                        break;
                    case 126:

                        $this->_tratamento["tratamentoproposto2"] = $value->gruporesposta_id;
                        break;
                    case 150:

                        $this->_tratamento["tratamentorealizado2"] = $value->gruporesposta_id;
                        break;
                    case 94:

                        $this->_tratamento["tratamentoinicial3"] = $value->gruporesposta_id;
                        break;
                    case 118:

                        $this->_tratamento["tratamentoproposto3"] = $value->gruporesposta_id;
                        break;
                    case 142:

                        $this->_tratamento["tratamentorealizado3"] = $value->gruporesposta_id;

                        break;
                    case 95:
                        $this->_tratamento["tratamentoinicial4"] = $value->gruporesposta_id;
                        break;
                    case 119:

                        $this->_tratamento["tratamentoproposto4"] = $value->gruporesposta_id;
                        break;
                    case 143:

                        $this->_tratamento["tratamentorealizado4"] = $value->gruporesposta_id;
                        break;
                    case 89:

                        $this->_tratamento["tratamentoinicial5"] = $value->gruporesposta_id;
                        break;
                    case 113:

                        $this->_tratamento["tratamentoproposto5"] = $value->gruporesposta_id;
                        break;
                    case 137:

                        $this->_tratamento["tratamentorealizado5"] = $value->gruporesposta_id;
                        break;
                    case 86:

                        $this->_tratamento["tratamentoinicial6"] = $value->gruporesposta_id;
                        break;
                    case 110:

                        $this->_tratamento["tratamentoproposto6"] = $value->gruporesposta_id;
                        break;
                    case 134:

                        $this->_tratamento["tratamentorealizado6"] = $value->gruporesposta_id;
                        break;
                    case 87:

                        $this->_tratamento["tratamentoinicial7"] = $value->gruporesposta_id;
                        break;
                    case 111:

                        $this->_tratamento["tratamentoproposto7"] = $value->gruporesposta_id;
                        break;
                    case 135:

                        $this->_tratamento["tratamentorealizado7"] = $value->gruporesposta_id;
                        break;
                    case 88:

                        $this->_tratamento["tratamentoinicial8"] = $value->gruporesposta_id;
                        break;
                    case 112:

                        $this->_tratamento["tratamentoproposto8"] = $value->gruporesposta_id;
                        break;
                    case 136:

                        $this->_tratamento["tratamentorealizado8"] = $value->gruporesposta_id;
                        break;
                    case 96:

                        $this->_tratamento["tratamentoinicial9"] = $value->gruporesposta_id;
                        break;
                    case 120:

                        $this->_tratamento["tratamentoproposto9"] = $value->gruporesposta_id;
                        break;
                    case 144:

                        $this->_tratamento["tratamentorealizado9"] = $value->gruporesposta_id;
                        break;
                    case 91:

                        $this->_tratamento["tratamentoinicial10"] = $value->gruporesposta_id;
                        break;
                    case 115:

                        $this->_tratamento["tratamentoproposto10"] = $value->gruporesposta_id;
                        break;
                    case 139:

                        $this->_tratamento["tratamentorealizado10"] = $value->gruporesposta_id;
                        break;
                    case 99:

                        $this->_tratamento["tratamentoinicial11"] = $value->gruporesposta_id;
                        break;
                    case 123:

                        $this->_tratamento["tratamentoproposto11"] = $value->gruporesposta_id;
                        break;
                    case 147:

                        $this->_tratamento["tratamentorealizado11"] = $value->gruporesposta_id;
                        break;
                    case 97:

                        $this->_tratamento["tratamentoinicial12"] = $value->gruporesposta_id;
                        break;
                    case 121:

                        $this->_tratamento["tratamentoproposto12"] = $value->gruporesposta_id;
                        break;
                    case 145:

                        $this->_tratamento["tratamentorealizado12"] = $value->gruporesposta_id;
                        break;
                    case 98:

                        $this->_tratamento["tratamentoinicial13"] = $value->gruporesposta_id;
                        break;
                    case 122:

                        $this->_tratamento["tratamentoproposto13"] = $value->gruporesposta_id;
                        break;
                    case 146:

                        $this->_tratamento["tratamentorealizado13"] = $value->gruporesposta_id;
                        break;
                    case 105:

                        $this->_tratamento["tratamentoinicial14"] = $value->gruporesposta_id;
                        break;
                    case 129:

                        $this->_tratamento["tratamentoproposto14"] = $value->gruporesposta_id;
                        break;
                    case 153:

                        $this->_tratamento["tratamentorealizado14"] = $value->gruporesposta_id;
                        break;
                    case 101:

                        $this->_tratamento["tratamentoinicial15"] = $value->gruporesposta_id;
                        break;
                    case 125:

                        $this->_tratamento["tratamentoproposto15"] = $value->gruporesposta_id;
                        break;
                    case 149:

                        $this->_tratamento["tratamentorealizado15"] = $value->gruporesposta_id;
                        break;
                    case 92:

                        $this->_tratamento["tratamentoinicial16"] = $value->gruporesposta_id;
                        break;
                    case 116:

                        $this->_tratamento["tratamentoproposto16"] = $value->gruporesposta_id;
                        break;
                    case 140:

                        $this->_tratamento["tratamentorealizado16"] = $value->gruporesposta_id;
                        break;
                    case 93:

                        $this->_tratamento["tratamentoinicial17"] = $value->gruporesposta_id;
                        break;
                    case 117:

                        $this->_tratamento["tratamentoproposto17"] = $value->gruporesposta_id;
                        break;
                    case 141:

                        $this->_tratamento["tratamentorealizado17"] = $value->gruporesposta_id;
                        break;
                    case 82:

                        $this->_tratamento["tratamentoinicial18"] = $value->gruporesposta_id;
                        break;
                    case 106:

                        $this->_tratamento["tratamentoproposto18"] = $value->gruporesposta_id;
                        break;
                    case 130:

                        $this->_tratamento["tratamentorealizado18"] = $value->gruporesposta_id;
                        break;
                    case 90:

                        $this->_tratamento["tratamentoinicial19"] = $value->gruporesposta_id;
                        break;
                    case 114:

                        $this->_tratamento["tratamentoproposto19"] = $value->gruporesposta_id;
                        break;
                    case 138:

                        $this->_tratamento["tratamentorealizado19"] = $value->gruporesposta_id;
                        break;
                    case 83:

                        $this->_tratamento["tratamentoinicial20"] = $value->gruporesposta_id;
                        break;
                    case 107:

                        $this->_tratamento["tratamentoproposto20"] = $value->gruporesposta_id;
                        break;
                    case 131:

                        $this->_tratamento["tratamentorealizado20"] = $value->gruporesposta_id;
                        break;
                    case 104:

                        $this->_tratamento["tratamentoinicial21"] = $value->gruporesposta_id;
                        break;
                    case 128:

                        $this->_tratamento["tratamentoproposto21"] = $value->gruporesposta_id;
                        break;
                    case 152:

                        $this->_tratamento["tratamentorealizado21"] = $value->gruporesposta_id;
                        break;
                    case 100:

                        $this->_tratamento["tratamentoinicial22"] = $value->gruporesposta_id;
                        break;
                    case 124:

                        $this->_tratamento["tratamentoproposto22"] = $value->gruporesposta_id;
                        break;
                    case 148:

                        $this->_tratamento["tratamentorealizado22"] = $value->gruporesposta_id;
                        break;
                    case 103:

                        $this->_tratamento["tratamentoinicial23"] = $value->gruporesposta_id;
                        break;
                    case 127:

                        $this->_tratamento["tratamentoproposto23"] = $value->gruporesposta_id;
                        break;
                    case 151:

                        $this->_tratamento["tratamentorealizado23"] = $value->gruporesposta_id;
                        break;
                    case 85:

                        $this->_tratamento["tratamentoinicial24"] = $value->gruporesposta_id;
                        break;
                    case 109:

                        $this->_tratamento["tratamentoproposto24"] = $value->gruporesposta_id;
                        break;
                    case 133:

                        $this->_tratamento["tratamentorealizado24"] = $value->gruporesposta_id;
                        break;
                    case 84:

                        $this->_tratamento["tratamentoinicial25"] = $value->gruporesposta_id;
                        break;
                    case 108:

                        $this->_tratamento["tratamentoproposto25"] = $value->gruporesposta_id;
                        break;
                    case 132:

                        $this->_tratamento["tratamentorealizado25"] = $value->gruporesposta_id;
                        break;
                }
            }
        } else {
            $this->_ficha_id_id = null;
        }
    }

    function listarHumanaAgenteToxico()
    {
        $data_inicio = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data_fim = str_replace("/", "-", $_POST['txtdata_fim']);
        $sql = "SELECT ra.gruporesposta_id, count(*) as total, cg.descricao 
                FROM ijf.tb_ceatox_resposta_agentetoxico ra
                join ijf.tb_ceatox_gruporesposta cg on  cg.gruporesposta_id = ra.gruporesposta_id
                join ijf.tb_ceatox_ficha cf on  cf.ficha_id = ra.ficha_id
                where cf.data between '$data_inicio' and '$data_fim'
                group by ra.gruporesposta_id, cg.descricao
                order by cg.descricao
            ";
        return $this->db->query($sql)->result();
    }

    function listarSexoAgenteToxico()
    {
        $data_inicio = str_replace("/", "-", $_POST['txtdata_inicio']);
        $data_fim = str_replace("/", "-", $_POST['txtdata_fim']);
        $sql = "SELECT ra.gruporesposta_id, count(*) as total, tp.sexo, cg.descricao
                FROM ijf.tb_ceatox_resposta_agentetoxico ra
                join ijf.tb_ceatox_gruporesposta cg on  cg.gruporesposta_id = ra.gruporesposta_id
                join ijf.tb_ceatox_ficha cf on  cf.ficha_id = ra.ficha_id
		join ijf.tb_temp_paciente tp on  tp.temp_paciente_id = cf.paciente_id
                where cf.data between '$data_inicio' and '$data_fim'
                group by ra.gruporesposta_id, cg.descricao, tp.sexo
                order by cg.descricao
            ";
//        var_dump($sql);
//        die;
        return $this->db->query($sql)->result();
    }


}

?>