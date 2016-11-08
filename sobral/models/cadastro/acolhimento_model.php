<?php

require_once APPPATH . 'models/base/BaseModel.php';

class acolhimento_model extends BaseModel {

    function gravar($args = array()) {
        //TODO: Lembrar de colocar excecao
        unset($args['paciente']);
        unset($args['nascimento']);
        unset($args['nome_mae']);
        unset($args['Ramsay']);
        unset($args['grupo1']);
        unset($args['grupo2']);
        unset($args['grupo3']);
        unset($args['grupo4']);
        unset($args['grupo5']);
        unset($args['grupo6']);
        unset($args['conduta']);
        //$this->db->set('cpf', str_replace("/", "",str_replace(".", "", $_POST['txtCPF'])));



        $data = date('Y-m-d');
        $hora = date('H:i:s');
        $args['data_acolhimento'] = $data . ' ' . $hora;
        if ($args['ocorrencia_datahora'] == '') {
            $args['ocorrencia_datahora'] = $data . ' ' . $hora;
        }
//        var_dump($args['data_acolhimento']);
//        die;
        if ($args['ocorrencia_local'] == 'Outro') {
            $args['ocorrencia_local'] = $args['ocorrencia_local_desc_especifique'];
        }
        unset($args['ocorrencia_local_desc_especifique']);
        if ($args['ocorrencia_transporte'] == 'Outro') {
            $args['ocorrencia_transporte'] = $args['ocorrencia_transporte_desc_especifique'];
        }
        unset($args['ocorrencia_transporte_desc_especifique']);
        if ($args['sinais_vitais1'] != 0) {
            $args['sinais_vitais'] = $args['sinais_vitais1'];
        } else if ($args['sinais_vitais2'] != 0) {
            $args['sinais_vitais'] = $args['sinais_vitais2'];
        } else if ($args['sinais_vitais3'] != 0) {
            $args['sinais_vitais'] = $args['sinais_vitais3'];
        } else {
            $args['sinais_vitais'] = null;
        }
        unset($args['sinais_vitais1']);
        unset($args['sinais_vitais2']);
        unset($args['sinais_vitais3']);
//        echo "<pre>";
//        var_dump($args);
//        echo "</pre>";
//        die;

        $this->db->insert('tb_acolhimento', $args);
        //return $this->db->insert_id;
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function listar($args = array()) {
        $this->db->from('tb_acolhimento')
                ->join('tb_paciente', 'tb_paciente.paciente_id = tb_acolhimento.paciente_id', 'left')
                ->join('tb_cidade', 'tb_cidade.cidade_id = tb_paciente.municipio_id', 'left')
                ->select('tb_paciente.nome as nomepaciente, tb_cidade.nome as ciade, tb_cidade.estado_id, tb_paciente.nome_mae,
                          tb_acolhimento.data_acolhimento, tb_paciente.nascimento as data_nascimento');

        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->like('tb_paciente.nome', $args['nome'], 'left');
            }
        }
        return $this->db;
    }

    function listarPacientes($parametro=null) {
        $this->db->select('paciente_id,
                           nome,
                           nome_mae,
                           nascimento');
        if ($parametro != null) {
            $this->db->where('nome ilike',"%" . $parametro . "%");
        }
        $this->db->from('tb_paciente');
        $return = $this->db->get();

        return $return->result();
    }

        function listarUnidades() {
        $this->db->select('unidades_id,
                           nome');
        $this->db->from('tb_unidades');
        $return = $this->db->get();

        return $return->result();
    }

}

?>
