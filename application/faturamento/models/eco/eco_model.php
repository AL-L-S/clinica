<?php

require_once APPPATH . 'models/base/BaseModel.php';

class Eco_model extends BaseModel
{
    /* Método construtor */

    function Eco_model()
    {
        parent::Model();
    }

    function listarLaudos($args = array())
    {

        $this->db->select('laudo_id,
                           nome,
                           data,
                           medico');
        $this->db->from('tb_exame_eco_laudo');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('nome ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function impressaoLaudos($laudo_id)
    {
        $this->db->select();
        $this->db->from('tb_exame_eco_laudo');
        $this->db->where('laudo_id', $laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function impressaolaudoresposta($classe, $laudo_id)
    {
        $this->db->select('descricao');
        $this->db->from('tb_exame_eco_laudo el');
        $this->db->join('tb_exame_resposta er', 'er.laudo_id = el.laudo_id');
        $this->db->join('tb_exame_gruporesposta eg', 'eg.exame_gruporesposta_id = er.gruporesposta_id');
        $this->db->join('tb_exame_classeresposta ec', 'ec.exame_classeresposta_id = eg.exame_classeresposta_id');
        $this->db->where('el.laudo_id', $laudo_id);
        $this->db->where('ec.exame_classeresposta_id', $classe);
        $return = $this->db->get();
        return $return->result();
    }

    function listarGrupoResposta($classeresposta)
    {
        $sql = "SELECT
                    exame_gruporesposta_id,
                    descricao
                    FROM ijf.tb_exame_gruporesposta
                    WHERE exame_classeresposta_id = $classeresposta
                    ORDER BY descricao
            ";

        return $this->db->query($sql)->result();
    }

    function listarClassificacaoResposta()
    {
        $sql = "SELECT
                    exame_classeresposta_id,
                    nome
                    FROM ijf.tb_exame_classeresposta
                    ORDER BY nome
            ";
        return $this->db->query($sql)->result();
    }

    function gravar()
    {
        $nome = $_POST['nome'];
        $data = date('Y-m-d');
        $peso = $_POST['peso'];
        $altura = $_POST['altura'];
        $diam_diastolico_ve = $_POST['diamdiasve'];
        $diam_sisto_final_ve = $_POST['diamsistve'];
        $espes_diastolico_septo = $_POST['espdiassep'];
        $espes_diastolico_pp = $_POST['espdiaspp'];
        $fracao_ejecao = $_POST['fraeje'];
        $perc_encurt_sist_ve = $_POST['percenc'];
        $diametro_aorta = $_POST['diamaorta'];
        $diametro_ae = $_POST['diamae'];
        $diam_basal_vd = $_POST['diamvd'];
        $medico = $_POST['medico'];
        if ($medico == 'Dra Ana Aécia Alexandrino de Oliveira') {
            $crm = 'CRM-5422 - CPF-260.363.583-49';
        } else {
            $crm = 'CRM-5336 - CPF-301.921.293-68';
        }


        $sql = ("INSERT INTO ijf.tb_exame_eco_laudo(nome, data, peso, altura, diam_diastolico_ve, diam_sisto_final_ve, espes_diastolico_septo, espes_diastolico_pp,
                                fracao_ejecao, perc_encurt_sist_ve, diametro_aorta, diametro_ae, diam_basal_vd, medico, crm_cpf) 
                                VALUES ('$nome', '$data','$peso', '$altura', '$diam_diastolico_ve', '$diam_sisto_final_ve', '$espes_diastolico_septo',
                                '$espes_diastolico_pp', '$fracao_ejecao', '$perc_encurt_sist_ve', '$diametro_aorta', '$diametro_ae', '$diam_basal_vd', '$medico', '$crm')");
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    function gravarresposta($laudo_id)
    {

        foreach ($_POST['txtObservacaoGeral'] as $observacao) {
            if ($observacao != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $observacao)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtVentEsquerdoDimensoesHipertrofia'] as $txtVentEsquerdoDimensoesHipertrofia) {
            if ($txtVentEsquerdoDimensoesHipertrofia != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtVentEsquerdoDimensoesHipertrofia)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtValvulaAortica'] as $txtValvulaAortica) {
            if ($txtValvulaAortica != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtValvulaAortica)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtAtrioEsquerdo'] as $txtAtrioEsquerdo) {
            if ($txtAtrioEsquerdo != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtAtrioEsquerdo)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtValvulamitral'] as $txtValvulamitral) {
            if ($txtValvulamitral != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtValvulamitral)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtVentriculoireito'] as $txtVentriculoireito) {
            if ($txtVentriculoireito != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtVentriculoireito)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtAtrioDireito'] as $txtAtrioDireito) {
            if ($txtAtrioDireito != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtAtrioDireito)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtValvulaTricuspide'] as $txtValvulaTricuspide) {
            if ($txtValvulaTricuspide != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtValvulaTricuspide)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtValvulapulmonar'] as $txtValvulapulmonar) {
            if ($txtValvulapulmonar != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtValvulapulmonar)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtPericardio'] as $txtPericardio) {
            if ($txtPericardio != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtPericardio)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtEstudoProteses'] as $txtEstudoProteses) {
            if ($txtEstudoProteses != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtEstudoProteses)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtAnaliseFluxoDoppler'] as $txtAnaliseFluxoDoppler) {
            if ($txtAnaliseFluxoDoppler != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtAnaliseFluxoDoppler)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtAnaliseMapeamentoFluxoCores'] as $txtAnaliseMapeamentoFluxoCores) {
            if ($txtAnaliseMapeamentoFluxoCores != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtAnaliseMapeamentoFluxoCores)";
                $this->db->query($sql);
            }
        }
        foreach ($_POST['txtConclusao'] as $txtConclusao) {
            if ($txtConclusao != -1) {
                $sql = "INSERT INTO ijf.tb_exame_resposta
                           (laudo_id, gruporesposta_id) VALUES
                           ($laudo_id, $txtConclusao)";
                $this->db->query($sql);
            }
        }
    }

    function gravarItens($laudo_id)
    {
        try {
            $i = -1;
            foreach ($_POST['Classificacao'] as $Classificacao) {
                $z = -1;

                if ($Classificacao != '-1') {
                    foreach ($_POST['descricaoClassificacao'] as $itemdescricaoClassificacao) {

                        if ($i == $z) {
                            $resposta = $itemdescricaoClassificacao;
                            break;
                        }
                        $z++;
                    }

                    //$i++;
                    $sql = "INSERT INTO ijf.tb_exame_gruporesposta
                       (exame_classeresposta_id, descricao) VALUES
                       ($Classificacao, '$resposta')";
                    $this->db->query($sql);
                    $gruporespostaid = $this->db->insert_id();
                    $sql = "INSERT INTO ijf.tb_exame_resposta
                       (laudo_id, gruporesposta_id) VALUES
                       ($laudo_id, $gruporespostaid)";
                    $this->db->query($sql);
                }
                $i++;
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

}

?>