<?php

/**
 * Esta classe é a responsável pela conexão com o banco de dados.
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Corrigirprocessamento_model extends Model {
    /* Propriedades da classe */

    var $_criticafinal_id = null;
    var $_data = null;
    var $_entrada1 = null;
    var $_saida1 = null;
    var $_entrada2 = null;
    var $_saida2 = null;
    var $_entrada3 = null;
    var $_saida3 = null;
    var $_critica1 = null;
    var $_critica2 = null;
    var $_critica3 = null;

    /**
     * Função construtora para setar os valores de conexão com o banco.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    function Corrigirprocessamento_model($criticafinal_id=null) {
        parent::Model();
        if (isset($criticafinal_id)) {
            $this->instanciar($criticafinal_id);
        }
    }

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
    function gravar($criticafinal_id) {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('data', $_POST['txtdata']);
            if($_POST['txtentrada1']){
            $this->db->set('entrada1', $_POST['txtentrada1']);
            }
            if($_POST['txtsaida1']){
            $this->db->set('saida1', $_POST['txtsaida1']);
            }
            if($_POST['txtentrada2']){
            $this->db->set('entrada2', $_POST['txtentrada2']);
            }
            if($_POST['txtsaida2']){
            $this->db->set('saida2', $_POST['txtsaida2']);
            }
            if($_POST['txtentrada3']){
            $this->db->set('entrada3', $_POST['txtentrada3']);
            }
            if($_POST['txtsaida3']){
            $this->db->set('saida3', $_POST['txtsaida3']);
            }
            $this->db->set('critica1', $_POST['txtcritica1']);
           

                $this->db->where('criticafinal_id', $criticafinal_id);
                $this->db->update('tb_criticafinal');


            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    /**
     * Função para instanciar os valores da tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access private
     * @return Resposta true/false da conexão com o banco
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    private function instanciar($criticafinal_id) {
        if ($criticafinal_id != 0) {
        $this->db->select(' cf.data,
                            f.nome,
                            cf.entrada1,
                            cf.saida1,
                            cf.entrada2,
                            cf.saida2,
                            cf.entrada3,
                            cf.saida3,
                            cf.critica1');
        $this->db->from('tb_criticafinal cf');
        $this->db->join('tb_funcionario f', 'f.matricula = cf.matricula');
            $this->db->where("cf.criticafinal_id", $criticafinal_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_criticafinal_id = $criticafinal_id;
            $this->_data = substr($return[0]->data,8,2) . '/' . substr($return[0]->data,5,2) . '/' . substr($return[0]->data,0,4);
            $this->_nome = $return[0]->nome;
            $this->_entrada1 = $return[0]->entrada1;
            $this->_saida1 = $return[0]->saida1;
            $this->_entrada2 = $return[0]->entrada2;
            $this->_saida2 = $return[0]->saida2;
            $this->_entrada3 = $return[0]->entrada3;
            $this->_saida3 = $return[0]->saida3;
            $this->_critica1 = $return[0]->critica1;
        } else {
            $this->_criticafinal_id = null;
        }
    }

}

?>
