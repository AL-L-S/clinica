<?php

class odontograma_model extends Model {

    var $_odontograma_id = null;

    function Odontograma_model($odontograma_id = null) {
        parent::Model();
        if (isset($odontograma_id)) {
            $this->instanciar($odontograma_id);
        }
    }
    
    private function instanciar($odontograma_id) {
        if ($odontograma_id != 0) {
            $this->db->select('odontograma_id, es.nome, h.sala_id, h.tipo');
            $this->db->from('tb_odontograma h ');
            $this->db->join('tb_exame_sala es', 'es.exame_sala_id = h.sala_id', 'left');
            $this->db->where("odontograma_id", $odontograma_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_odontograma_id = $odontograma_id;

            $this->_nome = $return[0]->nome;
            $this->_sala_id = $return[0]->sala_id;
            $this->_tipo = $return[0]->tipo;
        } else {
            $this->_odontograma_id = null;
        }
    }
    
    function crianovoodontograma(){
        $this->db->select('o.odontograma_id');
        $this->db->from('tb_odontograma o');
        $this->db->where("o.ambulatorio_laudo_id", $_GET['ambulatorio_laudo_id']);
        $this->db->where("o.ativo", 't');
        $return = $this->db->get();
        $return = $return->result();
        
        if( count($return) == 0 ){
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set("paciente_id", $_GET['paciente_id']);
            $this->db->set("ambulatorio_laudo_id", $_GET['ambulatorio_laudo_id']);
            $this->db->insert('tb_odontograma');
            $odontograma_id = $this->db->insert_id();
        }
        else{
            $odontograma_id = $return[0]->odontograma_id;
        }
        
        return $odontograma_id;
    }
    
    function novodenteodontograma($odontograma_id){
        $this->db->select('od.odontograma_dente_id');
        $this->db->from('tb_odontograma_dente od');
        $this->db->where("od.odontograma_id", $odontograma_id);
        $this->db->where("od.numero_dente", $_GET['dente']);
        $this->db->where("od.ativo", 't');
        $return = $this->db->get();
        $return = $return->result();
        
        if( count($return) == 0 ){
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->set("observacao", $_GET['observacao']);
            $this->db->set("numero_dente", $_GET['dente']);
            $this->db->set("odontograma_id", $odontograma_id);
            $this->db->insert('tb_odontograma_dente');
            $odontograma_dente_id = $this->db->insert_id();
        }
        else{
            $odontograma_dente_id = $return[0]->odontograma_dente_id;
        }
        
        return $odontograma_dente_id;
    }
    
    function excluirprocedimentoodontograma(){
        
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where("odontograma_dente_procedimento_id", $_GET['dente_procedimento_id']);
        $this->db->update('tb_odontograma_dente_procedimento');
        
        $this->db->select('od.numero_dente, od.odontograma_dente_id');
        $this->db->from('tb_odontograma_dente_procedimento odp');
        $this->db->join("tb_odontograma_dente od", "od.odontograma_dente_id = odp.odontograma_dente_id", 'left');
        $this->db->where("odp.odontograma_dente_procedimento_id", $_GET['dente_procedimento_id']);
        $query = $this->db->get();
        $query = $query->result();
        
        $this->db->select('odontograma_dente_procedimento_id');
        $this->db->from('tb_odontograma_dente_procedimento odp');
        $this->db->where("odp.odontograma_dente_id", $query[0]->odontograma_dente_id);
        $this->db->where("odp.ativo", 't');
        $return = $this->db->get();
        $return = $return->result();
        
//        var_dump($return); die;
        
        if( count($return) == 0 ){
            
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where("odontograma_dente_id", $query[0]->odontograma_dente_id);
            $this->db->update('tb_odontograma_dente');
            
        }
        
        return array(
            "dente" => $query[0]->numero_dente,
            "total" => count($return)
        );
        
    }
    
    function novoprocedimentodenteodontograma($odontograma_dente_id){
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set("observacao", $_GET['observacao']);
        $this->db->set("face", $_GET['face']);
        $this->db->set("procedimento_convenio_id", $_GET['procedimento_id']);
        $this->db->set("odontograma_dente_id", $odontograma_dente_id);
        $this->db->insert('tb_odontograma_dente_procedimento');
    }
    
    function listarprocedimentosodontograma(){
        $this->db->select('odp.face,
                           odp.observacao,
                           od.numero_dente,
                           odp.odontograma_dente_procedimento_id,
                           pt.codigo,
                           pt.nome as procedimento');
        $this->db->from('tb_odontograma_dente_procedimento odp');
        $this->db->join("tb_odontograma_dente od", "od.odontograma_dente_id = odp.odontograma_dente_id", 'left');
        $this->db->join("tb_odontograma o", "od.odontograma_id = o.odontograma_id", 'left');
        $this->db->join("tb_procedimento_convenio pc", "pc.procedimento_convenio_id = odp.procedimento_convenio_id", 'left');
        $this->db->join("tb_procedimento_tuss pt", "pt.procedimento_tuss_id = pc.procedimento_tuss_id", 'left');
        $this->db->where("odp.ativo", 't');
        $this->db->where("o.ambulatorio_laudo_id", $_GET['ambulatorio_laudo_id']);
        $this->db->orderby("od.numero_dente");
        $this->db->orderby("odp.face");
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();        
        
    }
    
    
    function instanciarprimeiroquadrantepacienteodontograma($ambulatorio_laudo_id){
        $this->db->select('od.numero_dente');
        $this->db->from('tb_odontograma o');
        $this->db->join("tb_odontograma_dente od", "od.odontograma_id = o.odontograma_id", 'right');
        $this->db->where("o.ambulatorio_laudo_id", $ambulatorio_laudo_id);
        $this->db->where("CAST(od.numero_dente AS TEXT) like '1%'");
        $this->db->where("o.ativo", 't');
        $this->db->where("od.ativo", 't');
        $return = $this->db->get();
        $return = $return->result();
        
        $retorno = array();
        for($i = 0; $i < count($return); $i++){
            $retorno[] = $return[$i]->numero_dente;
        }
        
        return $retorno;
    }
    
    function instanciarsegundoquadrantepacienteodontograma($ambulatorio_laudo_id){
        $this->db->select('od.numero_dente');
        $this->db->from('tb_odontograma o');
        $this->db->join("tb_odontograma_dente od", "od.odontograma_id = o.odontograma_id", 'right');
        $this->db->where("o.ambulatorio_laudo_id", $ambulatorio_laudo_id);
        $this->db->where("CAST(od.numero_dente AS TEXT) like '2%'");
        $this->db->where("o.ativo", 't');
        $this->db->where("od.ativo", 't');
        $return = $this->db->get();
        $return = $return->result();
        
        $retorno = array();
        for($i = 0; $i < count($return); $i++){
            $retorno[] = $return[$i]->numero_dente;
        }
        
        return $retorno;
    }
    
    function instanciarterceiroquadrantepacienteodontograma($ambulatorio_laudo_id){
        $this->db->select('od.numero_dente');
        $this->db->from('tb_odontograma o');
        $this->db->join("tb_odontograma_dente od", "od.odontograma_id = o.odontograma_id", 'right');
        $this->db->where("o.ambulatorio_laudo_id", $ambulatorio_laudo_id);
        $this->db->where("CAST(od.numero_dente AS TEXT) like '3%'");
        $this->db->where("o.ativo", 't');
        $this->db->where("od.ativo", 't');
        $return = $this->db->get();
        $return = $return->result();
        
        $retorno = array();
        for($i = 0; $i < count($return); $i++){
            $retorno[] = $return[$i]->numero_dente;
        }
        
        return $retorno;
    }
    
    function instanciarquartoquadrantepacienteodontograma($ambulatorio_laudo_id){
        $this->db->select('od.numero_dente');
        $this->db->from('tb_odontograma o');
        $this->db->join("tb_odontograma_dente od", "od.odontograma_id = o.odontograma_id", 'right');
        $this->db->where("o.ambulatorio_laudo_id", $ambulatorio_laudo_id);
        $this->db->where("CAST(od.numero_dente AS TEXT) like '4%'");
        $this->db->where("o.ativo", 't');
        $this->db->where("od.ativo", 't');
        $return = $this->db->get();
        $return = $return->result();
        
        $retorno = array();
        for($i = 0; $i < count($return); $i++){
            $retorno[] = $return[$i]->numero_dente;
        }
        
        return $retorno;
    }
}

?>
