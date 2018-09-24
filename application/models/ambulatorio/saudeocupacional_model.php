<?php

class saudeocupacional_model extends Model {

    var $_aso_setor_id = null;
    var $_descricao_setor = null;
    var $_aso_funcao_id = null;
    var $_descricao_funcao = null;
    var $_aso_risco_id = null;
    var $_descricao_risco = null;

    function Saudeocupacional_model($saude_ocupacional_id = null) {
        parent::Model();
        if (isset($saude_ocupacional_id)) {
            $this->instanciar($saude_ocupacional_id);
        }
    }

    function listarsetor() {
        $this->db->select('se.aso_setor_id,
                            se.descricao_setor');
        $this->db->from('tb_aso_setor se');
        $this->db->where('se.ativo', 'true');
        return $this->db;
    }
    function listarsetor2() {
        $this->db->select('se.aso_setor_id,
                            se.descricao_setor');
        $this->db->from('tb_aso_setor se');
        $this->db->where('se.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarsetorfuncao() {
        $this->db->select('fu.aso_funcao_id,
                            fu.descricao_funcao');
        $this->db->from('tb_aso_funcao fu');
        $this->db->where('fu.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function carregarsetor($aso_setor_id) {
        $this->db->select('se.aso_setor_id,
                            se.descricao_setor,
                            se.aso_funcao_id');
        $this->db->from('tb_aso_setor se');
        $this->db->where('se.aso_setor_id', $aso_setor_id);
        $return = $this->db->get();
        return $return->result();
    }
    function carregarsetores() {
        $this->db->select('se.aso_setor_id,
                            se.descricao_setor,
                            se.aso_funcao_id,
                            se.convenio_id');
        $this->db->from('tb_aso_setor se');
        $this->db->where('se.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }
    function carregarsetores2() {
        $this->db->select('se.aso_setor_id,
                            se.descricao_setor,
                            se.aso_funcao_id,
                            se.convenio_id');
        $this->db->from('tb_aso_setor se');
        $this->db->where('se.ativo', 'true');
        $this->db->where('se.convenio_id IS NOT NULL', null, false );
        $return = $this->db->get();
        return $return->result();
    }
    function carregarexames() {
        $this->db->select('se.aso_setor_id,
                            se.descricao_setor,
                            se.aso_funcao_id');
        $this->db->from('tb_aso_setor se');        
        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncao() {
        $this->db->select('fu.aso_funcao_id,
                            fu.descricao_funcao
                            ');
        $this->db->from('tb_aso_funcao fu');
        $this->db->where('fu.ativo', 'true');
        
        return $this->db;
    }

    function carregarfuncao($aso_funcao_id) {
        $this->db->select('fu.aso_funcao_id,
                            fu.aso_risco_id,
                           fu.descricao_funcao');
        $this->db->from('tb_aso_funcao fu');

        $this->db->where('fu.aso_funcao_id', $aso_funcao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarrisco() {
        $this->db->select('r.aso_risco_id,
                            r.descricao_risco');
        $this->db->from('tb_aso_risco r');
        $this->db->where('r.ativo', 'true');
        return $this->db;
    }
    
    function listarriscofuncao() {
        $this->db->select('r.aso_risco_id,
                           r.descricao_risco');
        $this->db->from('tb_aso_risco r');
        $this->db->where('r.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarriscofuncao2($item) {
        $this->db->select('r.aso_risco_id,
                           r.descricao_risco');
        $this->db->from('tb_aso_risco r');
        $this->db->where('r.ativo', 'true');
        $this->db->where('r.aso_risco_id', $item);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarrisco($aso_risco_id) {
        $this->db->select('r.aso_risco_id,
                            r.descricao_risco');
        $this->db->from('tb_aso_risco r');

        $this->db->where('r.aso_risco_id', $aso_risco_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    function carregarriscoaso($aso_risco_id) {
        
        $this->db->select('r.aso_risco_id,
                            r.descricao_risco');
        $this->db->from('tb_aso_risco r');

        $this->db->where('r.aso_risco_id', $aso_risco_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluirsetor($aso_setor_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('aso_setor_id', $aso_setor_id);
        $this->db->update('tb_aso_setor');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirfuncao($aso_funcao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('aso_funcao_id', $aso_funcao_id);
        $this->db->update('tb_aso_funcao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function excluirrisco($aso_risco_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('aso_risco_id', $aso_risco_id);
        $this->db->update('tb_aso_risco');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravarsetor() {
        try {
                                   
//            $array_funcao = json_encode($_POST['txtfuncao_id']);
             
            /* inicia o mapeamento no banco */
            $aso_setor_id = $_POST['txtasosetorid'];
            $this->db->set('descricao_setor', $_POST['nome']);
//            $this->db->set('aso_funcao_id', $array_funcao);
//            $this->db->set('convenio_id', $_POST['convenio1']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtasosetorid'] == "") {
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_aso_setor');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $aso_setor_id = $this->db->insert_id();
            }
            else {
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('aso_setor_id', $aso_setor_id);
                $this->db->update('tb_aso_setor');
            }
            return $aso_setor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfuncao() {
        try {
                                
            
//            $array_riscos = json_encode($_POST['txtrisco_id']);
            /* inicia o mapeamento no banco */
            $aso_funcao_id = $_POST['txtasofuncaoid'];
            $this->db->set('descricao_funcao', $_POST['nome']);
            $this->db->set('aso_risco_id', $array_riscos);
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtasofuncaoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_aso_funcao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $aso_funcao_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('aso_funcao_id', $aso_funcao_id);
                $this->db->update('tb_aso_funcao');
            }
            return $aso_funcao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarrisco() {
        try {
            /* inicia o mapeamento no banco */
            $aso_risco_id = $_POST['txtasoriscoid'];
            $this->db->set('descricao_risco', $_POST['nome']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtasoriscoid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_aso_risco');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $aso_risco_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('aso_risco_id', $aso_risco_id);
                $this->db->update('tb_aso_risco');
            }
            return $aso_risco_id;
        } catch (Exception $exc) {
            return -1;
        }
    }
    
    function listarautocompletefuncaosetormt($parametro = null) {
        $this->db->select(' se.aso_funcao_id,
                            se.aso_setor_id
                                            ');
        
        $this->db->from('tb_aso_setor se');    
    
        $this->db->where('se.ativo', 'true');        
        

        if ($parametro != null) {
            $this->db->where('se.aso_setor_id', $parametro);
        }
       
        $this->db->orderby("se.descricao_setor");
        $return = $this->db->get();
        return $return->result();
    }
    function listarautocompletesetorempresamt($parametro = null) {
//        var_dump($_GET['convenio1']);die;
        $this->db->select(' se.aso_setor_id,
                            se.convenio_id,
                            se.descricao_setor
                                            ');
        
        $this->db->from('tb_aso_setor se');    
    
    
        $this->db->where('se.ativo', 'true');       
        
        

        if ($parametro != null) {
            $this->db->where('se.convenio_id', $parametro);
        }
       
        $this->db->orderby("se.descricao_setor");
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarautocompleteriscofuncaomt($parametro = null) {
        $this->db->select(' fu.aso_risco_id,
                            fu.aso_funcao_id
                                            ');
        
        $this->db->from('tb_aso_funcao fu');  
    
        $this->db->where('fu.ativo', 'true');        
        

        if ($parametro != null) {
            $this->db->where('fu.aso_funcao_id', $parametro);
        }
       
        $this->db->orderby("fu.descricao_funcao");
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarautocompletesetorjson($parametro = array()) {
        

        
        $this->db->select(' fu.aso_funcao_id,
                            fu.descricao_funcao
                                            ');
        
        $this->db->from('tb_aso_funcao fu');    
    
        $this->db->where('fu.ativo', 'true');        
        

        if ($parametro != null) {
            $this->db->where_in('aso_funcao_id', $parametro);
        }
       
        $this->db->orderby("fu.descricao_funcao");
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarautocompletefuncaojson($parametro = array()) {
        

        
        $this->db->select(' r.aso_risco_id,
                            r.descricao_risco
                                            ');
        
        $this->db->from('tb_aso_risco r');    
    
        $this->db->where('r.ativo', 'true');        
        

        if ($parametro != null) {
            $this->db->where_in('aso_risco_id', $parametro);
        }
       
        $this->db->orderby("r.descricao_risco");
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarautocompletefuncaojson2($parametro = array()) {
        

        
        $this->db->select(' r.aso_risco_id,
                            r.descricao_risco
                                            ');
        
        $this->db->from('tb_aso_risco r');  
        $this->db->where('r.ativo', 'true');      
                       
        

        if ($parametro != null) {
            $this->db->where_in('r.aso_risco_id', $parametro);
        }
       
        $this->db->orderby("r.descricao_risco");
        $return = $this->db->get();
        return $return->result();
    }

}

?>
