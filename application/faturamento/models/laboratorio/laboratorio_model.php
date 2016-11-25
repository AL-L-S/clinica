<?php

require_once APPPATH . 'models/base/BaseModel.php';

class laboratorio_model extends BaseModel {
    /* Propriedades da classe */

    var $_solicitacao_exame_laboratorio_id = null;
    var $_nome = null;
    var $_be = null;
    var $_unidade = null;
    var $_leito = null;
    var $_observacao = null;
    var $_data = null;
    var $_hora = null;


    /* Método construtor */

    function laboratorio_model($solicitacao_exame_laboratorio_id=null) {
        parent::Model();

        if (isset($solicitacao_exame_laboratorio_id)) {
            $this->instanciar($solicitacao_exame_laboratorio_id);
        }
    }

    private function instanciar($solicitacao_exame_laboratorio_id) {
        if ($solicitacao_exame_laboratorio_id != 0) {
            //$this->db->select('cs.*,c.nome as municipio,c.estado as estado');
            $this->db->select();
            $this->db->from('tb_solicitacao_exame_laboratorio');
            $this->db->where("solicitacao_exame_laboratorio_id", $solicitacao_exame_laboratorio_id);
            $query = $this->db->get();
            $return = $query->result();

            //$this->_solicitacao_exame_laboratorio_id = $_solicitante_id;
            $this->_solicitacao_exame_laboratorio_id = $return[0]->solicitacao_exame_laboratorio_id;
            $this->_nome = $return[0]->nome;
            $this->_be = $return[0]->be;
            $this->_unidade = $return[0]->unidade;
            $this->_leito = $return[0]->leito;
            $this->_observacao = $return[0]->observacao;
            $this->_data = $return[0]->data;
            $this->_hora = $return[0]->hora;

// $this->_cidade_nome = $return[0]->municipio.' - '.$return[0]->estado;
        }
    }

    function totalRegistros($parametro) {

        $this->db->select('ceatox_solicitante_id');
        $this->db->from('tb_ceatox_solicitante');
        if ($parametro != null && $parametro != -1) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listar($args = array()) {
        $this->db->select();
        $this->db->from('tb_solicitacao_exame_laboratorio');


        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->like('nome', $args['nome'], 'left');
            }
        }

        return $this->db;
    }

    function listarpaciente($paciente_id=null) {
        $this->db->select('e.nome, s.be, s.unidade, s.leito, s.observacao, s.data, s.hora, s.lotend,
                           e.nome_mae, e.data_nascimento, e.sexo, e.endereco, e.municipio, e.estado,
                           e.complemento, e.bairro');
        $this->db->from('tb_solicitacao_exame_laboratorio s');
        $this->db->join('tb_emergencia_behospub e', 'e.be = s.be');
        $this->db->where('s.solicitacao_exame_laboratorio_id', $paciente_id);

        $return = $this->db->get()->result();

        return $return;
    }


    function listarnumerolote($args = array()) {
        $sql = "SELECT lotend
                  FROM ijf.tb_solicitacao_exame_laboratorio
                  order by solicitacao_exame_laboratorio_id desc
                  limit 1";
        $retorno = $this->db->query($sql);
        $teste = $retorno->row_array();

        return $teste;

    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
           // $sexo = $_POST['txtSexo'];
           // var_dump($sexo);
           //  die;
            $lista = $this->listarnumerolote();

            $lotend = $lista['lotend'];
            $lotend++;
            if ($lotend == 10000){
                $lotend = 1;
            }
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('be', $_POST['txtBe']);
            $this->db->set('lotend', $lotend);
            $this->db->set('unidade', $_POST['txtUnidade']);
            $this->db->set('leito', $_POST['txtLeito']);
            $this->db->set('observacao', $_POST['txtObservacao']);
            $this->db->set('data', date("d/m/Y"));
            $this->db->set('hora', date("H:i:s"));


                $this->db->insert('tb_solicitacao_exame_laboratorio');
                $paciente_id = $this->db->insert_id();
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                }else{
                    return $paciente_id;
                }
        } catch (Exception $exc) {
            return false;
        }
    }

}

?>