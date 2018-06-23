<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class leito_model extends BaseModel {

    var $_internacao_leito_id = null;
    var $_nome = null;
    var $_enfermaria = null;
    var $_tipo = null;
    var $_condicao = null;
    var $_enfermaria_id = null;

    function leito_model($internacao_leito_id = null) {
        parent::Model();
        if (isset($internacao_leito_id)) {
            $this->instanciar($internacao_leito_id);
        }
    }

    private function instanciar($internacao_leito_id) {
        if ($internacao_leito_id != 0) {
            $this->db->select(' il.internacao_leito_id,
                            il.nome,
                            il.enfermaria_id,
                            ie.nome as enfermaria,
                            iu.nome as unidade,
                            il.tipo,
                            il.condicao');
            $this->db->from('tb_internacao_leito il');
            $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
            $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
            $this->db->where('il.internacao_leito_id', $internacao_leito_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_internacao_leito_id = $internacao_leito_id;
            $this->_nome = $return[0]->nome;
            $this->_tipo = $return[0]->tipo;
            $this->_enfermaria_id = $return[0]->enfermaria_id;
            $this->_enfermaria = $return[0]->enfermaria;
            $this->_condicao = $return[0]->condicao;
        }
    }

    function gravarleito() {

        try {
            $this->db->set('nome', $_POST['nome']);
            $this->db->set('enfermaria_id', $_POST['EnfermariaID']);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('condicao', $_POST['condicao']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_leito_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_leito');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $internacao_leito_id = $this->db->insert_id();
            }
            else { // update
                $internacao_leito_id = $_POST['internacao_leito_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_leito_id', $internacao_leito_id);
                $this->db->update('tb_internacao_leito');
            }


            return $internacao_leito_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listaleitorelatorio() {
        $this->db->select(' il.internacao_leito_id,
                            il.nome,
                            ie.nome as enfermaria,
                            iu.nome as unidade,
                            il.tipo');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
//        $this->db->where('il.ativo', 't');
        $this->db->where('il.excluido', 'f');

        $return = $this->db->get();
        return $return->result();
    }

    function listaleito($args = array()) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome,
                            ie.nome as enfermaria,
                            iu.nome as unidade,
                            il.tipo');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
//        $this->db->where('il.ativo', 't');
        $this->db->where('il.excluido', 'f');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('il.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('ie.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('iu.nome ilike', "%" . $args['nome'] . "%");
            }
        }
        return $this->db;
    }

    function listaleitoautocomplete($parametro = null) {

        $sql = "select il.internacao_leito_id,
                            il.nome,
                            ie.nome as enfermaria,
                            iu.nome as unidade,
                            il.tipo
        from ponto.tb_internacao_leito il
        join ponto.tb_internacao_enfermaria as ie on ie.internacao_enfermaria_id = il.enfermaria_id
        join ponto.tb_internacao_unidade as iu on iu.internacao_unidade_id = ie.unidade_id
        where il.ativo = true and il.condicao = 'Normal'
        and (il.nome ilike '%$parametro%'
        or ie.nome ilike '%$parametro%'
        or iu.nome ilike '%$parametro%')
        order by iu.nome, ie.nome, il.nome";


//        $this->db->select(' il.internacao_leito_id,
//                            il.nome,
//                            ie.nome as enfermaria,
//                            iu.nome as unidade,
//                            il.tipo');
//        $this->db->from('tb_internacao_leito il');
//        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
//        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
//        $this->db->where('il.ativo', 't');
//        if ($parametro != null) {
//            $this->db->where('il.nome ilike', "%" . $parametro . "%");
//            $this->db->orwhere('ie.nome ilike', "%" . $parametro . "%");
//            $this->db->orwhere('iu.nome ilike', "%" . $parametro . "%");
//        }
        $return = $this->db->query($sql);
        return $return->result();
    }

    function excluirleito($leito_id) {
        $this->db->set('excluido', 't');
        $this->db->where('internacao_leito_id', $leito_id);
        $this->db->update('tb_internacao_leito');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
    }

}

?>
