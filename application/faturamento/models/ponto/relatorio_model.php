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
class Relatorio_model extends Model {
    /* Propriedades da classe */

    /**
     * Função construtora para setar os valores de conexão com o banco.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    function Relatorio_model() {
        parent::Model();
    }

    /**
     * Função para listar os valores da tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $parametro com a informação do nome ou sigla.
     * @param string $maximo.
     * @param string $inicio.
     */
    function relatoriofuncionariosfixo($inicio, $fim) {
        $this->db->select(' cf.criticafinal_id,
                            cf.data,
                            cf.entrada1,
                            cf.saida1,
                            cf.entrada2,
                            cf.saida2,
                            cf.entrada3,
                            cf.saida3,
                            f.funcionario_id,
                            f.nome,
                            f.matricula,
                            s.nome as setor,
                            tf.nome as funcao,
                            c.nome as cargo,
                            cf.critica1');
        $this->db->from('tb_criticafinal cf');
        $this->db->join('tb_funcionario f', 'f.matricula = cf.matricula');
        $this->db->join('tb_setor s', 's.setor_id = f.setor_id');
        $this->db->join('tb_funcao tf', 'tf.funcao_id = f.funcao_id');
        $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id');
        $this->db->join('tb_cargo c', 'c.cargo_id = f.cargo_id');
        $this->db->where("cf.data between '$inicio' and '$fim'");
        $this->db->where('ht.tipo', 'Fixo');
        $this->db->orderby('cf.matricula');
        $this->db->orderby('cf.data');
        $return = $this->db->get();
        return $return->result();
    }

    /**
     * Função para listar os valores da tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $parametro com a informação do nome ou sigla.
     * @param string $maximo.
     * @param string $inicio.
     */
    function relatoriofuncionariosvariavel($inicio, $fim) {
        $this->db->select(' cf.criticafinal_id,
                            cf.data,
                            cf.entrada1,
                            cf.saida1,
                            cf.entrada2,
                            cf.saida2,
                            cf.entrada3,
                            cf.saida3,
                            f.nome,
                            f.funcionario_id,
                            f.matricula,
                            s.nome as setor,
                            tf.nome as funcao,
                            c.nome as cargo,
                            cf.critica1');
        $this->db->from('tb_criticafinal cf');
        $this->db->join('tb_funcionario f', 'f.matricula = cf.matricula');
        $this->db->join('tb_setor s', 's.setor_id = f.setor_id');
        $this->db->join('tb_funcao tf', 'tf.funcao_id = f.funcao_id');
        $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id');
        $this->db->join('tb_cargo c', 'c.cargo_id = f.cargo_id');
        $this->db->where("cf.data between '$inicio' and '$fim'");
        $this->db->where('ht.tipo', 'Variavel');
        $this->db->orderby('f.nome');
        $this->db->orderby('cf.data');
        $return = $this->db->get();
        return $return->result();
    }
    
    function relatoriofuncionariossemiflexivel($inicio, $fim) {
        $this->db->select(' cf.criticafinal_id,
                            cf.data,
                            cf.entrada1,
                            cf.saida1,
                            cf.entrada2,
                            cf.saida2,
                            cf.entrada3,
                            cf.saida3,
                            f.nome,
                            f.funcionario_id,
                            f.matricula,
                            s.nome as setor,
                            tf.nome as funcao,
                            c.nome as cargo,
                            cf.critica1');
        $this->db->from('tb_criticafinal cf');
        $this->db->join('tb_funcionario f', 'f.matricula = cf.matricula');
        $this->db->join('tb_setor s', 's.setor_id = f.setor_id');
        $this->db->join('tb_funcao tf', 'tf.funcao_id = f.funcao_id');
        $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id');
        $this->db->join('tb_cargo c', 'c.cargo_id = f.cargo_id');
        $this->db->where("cf.data between '$inicio' and '$fim'");
        $this->db->where('ht.tipo', 'Semiflexivel');
        $this->db->orderby('cf.matricula');
        $this->db->orderby('cf.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariofixo() {
        $this->db->select(' hv.data,
            f.funcionario_id,
        hv.horaentrada1,
        hv.horariostipo_id,
        hv.horasaida1,
        hv.horaentrada2,
        hv.horasaida2,
        hv.horaentrada3,
        hv.horasaida3');
        $this->db->from('tb_horariofixorodado hv');
        $this->db->join('tb_funcionario f', 'f.horariostipo_id = hv.horariostipo_id');
        $this->db->orderby('hv.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariovariavel() {
        $this->db->select(' hv.data,
            f.funcionario_id,
        hv.horariostipo_id,
        hv.horaentrada1,
        hv.horasaida1,
        hv.horaentrada2,
        hv.horasaida2,
        hv.horaentrada3,
        hv.horasaida3');
        $this->db->from('tb_horariovariavel hv');
        $this->db->join('tb_funcionario f', 'f.horariostipo_id = hv.horariostipo_id');
        $this->db->orderby('hv.data');
        $return = $this->db->get();
        return $return->result();
    }

}

?>
