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
class Processaponto_model extends Model {
    /* Propriedades da classe */

    /**
     * Função construtora para setar os valores de conexão com o banco.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    function Processaponto_model($funcionario_id = null) {
        parent::Model();
        if (isset($funcionario_id)) {
            $this->instanciar($funcionario_id);
        }
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
    function listar() {
        $this->db->select(' f.funcionario_id,
                            f.matricula,
                            f.nome,
                            f.cpf,
                            s.nome as setor');
        $this->db->from('tb_funcionario f');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncionarioindividual() {
        $sql = "select distinct f.funcionario_id,
                            f.matricula,
                            f.nome,
                            f.horariostipo_id from ponto.tb_funcionario f
        join ponto.tb_horarioindividual as hi on hi.funcionario_id = f.funcionario_id
        where f.situacao_id = true";
        return $this->db->query($sql)->result();
    }

    function listarpontosiguais() {
        $sql = "SELECT date_trunc('minute', data_batida)as data, matricula, pontosimportados_id FROM ponto.tb_pontosimportados
        where status = false";
        return $this->db->query($sql)->result();
    }

    function listarhorariosindividual($funcionario_id) {
        $this->db->select();
        $this->db->from('tb_horarioindividual');
        $this->db->where('funcionario_id', "$funcionario_id");
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncionariosvariavel() {
        $this->db->select(' f.funcionario_id,
                            f.matricula,
                            f.nome,
                            f.horariostipo_id');
        $this->db->from('tb_funcionario f');
        $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id');
        $this->db->where('f.situacao_id', 't');
        $this->db->where('ht.tipo', 'Variavel');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcritica($matricula, $data) {
        $this->db->select('');
        $this->db->from('tb_criticafinal c');
        $this->db->where('matricula', $matricula);
        $this->db->where('data', $data);
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncionarioslivre() {
        $this->db->select(' f.funcionario_id,
                            f.matricula,
                            f.nome,
                            f.horariostipo_id,
                            pi.data_batida,
                            pi.pontosimportados_id');
        $this->db->from('tb_funcionario f');
        $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id');
        $this->db->join('tb_pontosimportados pi', 'pi.matricula = f.matricula');
        $this->db->where('pi.status', 'f');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariosvariavel($horariotipo) {
        $this->db->select();
        $this->db->from('tb_horariovariavel');
        $this->db->where('horariostipo_id', "$horariotipo");
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncionariosfixo() {
        $this->db->select(' f.funcionario_id,
                            f.matricula,
                            f.nome,
                            f.horariostipo_id');
        $this->db->from('tb_funcionario f');
        $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id');
        $this->db->where('f.situacao_id', 't');
        $this->db->where('ht.tipo', 'Fixo');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncionariossemiflexivel() {
        $this->db->select(' f.funcionario_id,
                            f.matricula,
                            f.nome,
                            f.horariostipo_id');
        $this->db->from('tb_funcionario f');
        $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id');
        $this->db->where('f.situacao_id', 't');
        $this->db->where('ht.tipo', 'Semiflexivel');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariosfixo($horariotipo) {
        $this->db->select();
        $this->db->from('tb_horariofixorodado');
        $this->db->where('horariostipo_id', "$horariotipo");
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorarios($horariotipo) {
        $this->db->select();
        $this->db->from('tb_horariofixorodado');
        $this->db->where('horariostipo_id', "$horariotipo");
        $this->db->orderby('data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncionarioponto($matricula) {
        $this->db->select();
        $this->db->from('tb_pontosimportados');
        $this->db->where('matricula', "$matricula");
        $this->db->where('status', 'f');
        $this->db->orderby('data_batida');
        $return = $this->db->get();
        return $return->result();
    }

    function verificadoponto($pontoid) {
        $this->db->set('status', 't');
        $this->db->where('pontosimportados_id', $pontoid);
        $this->db->update('tb_pontosimportados');
    }

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
    function gravarcritica($matricula, $data, $inserirentrada1, $inserirsaida1, $critica1, $inserirentrada2, $inserirsaida2, $critica2, $inserirentrada3, $inserirsaida3, $critica3) {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('matricula', $matricula);
            $this->db->set('data', $data);
            if ($inserirentrada1 <> "") {
                $this->db->set('entrada1', $inserirentrada1);
            }
            if ($inserirsaida1 <> "") {
                $this->db->set('saida1', $inserirsaida1);
            }
            $this->db->set('critica1', $critica1);
            if ($inserirentrada2 <> "") {
                $this->db->set('entrada2', $inserirentrada2);
            }
            if ($inserirsaida2 <> "") {
                $this->db->set('saida2', $inserirsaida2);
            }
            $this->db->set('critica2', $critica2);
            if ($inserirentrada3 <> "") {
                $this->db->set('entrada3', $inserirentrada3);
            }
            if ($inserirsaida3 <> "") {
                $this->db->set('saida3', $inserirsaida3);
            }
            $this->db->set('critica3', $critica3);
            $this->db->insert('tb_criticafinal');
//$erro = $this->db->_error_message();
        } catch (Exception $exc) {
            return true;
        }
    }

    function alterarcritica($matricula, $data, $inserirentrada1, $inserirsaida1, $critica1, $inserirentrada2, $inserirsaida2, $critica2, $inserirentrada3, $inserirsaida3, $critica3) {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('matricula', $matricula);
            $this->db->set('data', $data);
            if ($inserirentrada1 <> "") {
                $this->db->set('entrada1', $inserirentrada1);
            }
            if ($inserirsaida1 <> "") {
                $this->db->set('saida1', $inserirsaida1);
            }
            $this->db->set('critica1', $critica1);
            if ($inserirentrada2 <> "") {
                $this->db->set('entrada2', $inserirentrada2);
            }
            if ($inserirsaida2 <> "") {
                $this->db->set('saida2', $inserirsaida2);
            }
            $this->db->set('critica2', $critica2);
            if ($inserirentrada3 <> "") {
                $this->db->set('entrada3', $inserirentrada3);
            }
            if ($inserirsaida3 <> "") {
                $this->db->set('saida3', $inserirsaida3);
            }
            $this->db->set('critica3', $critica3);
            $this->db->where('data', $data);
            $this->db->where('matricula', $matricula);
            $this->db->update('tb_criticafinal');
//            var_dump($inserirentrada1);
//            var_dump($inserirsaida1);
//            die;
//$erro = $this->db->_error_message();
        } catch (Exception $exc) {
            return true;
        }
    }

    /**
     * Função para listar os valores da tabela TB_SERVIDOR_TETO.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @param integer $crm com o crm do medico.
     * @return Array
     */
    function getServidorID($crm, $verificador_teto) {
        $this->db->select('se.teto_id');
        $this->db->from('tb_servidor_teto se');
        $this->db->join('tb_servidor s', 's.servidor_id = se.servidor_id');
        $this->db->where('s.classificacao_id', 3);
        $this->db->where('lpad(s.crp,6,\'0\')', $crm);
        $this->db->where('se.situacao', 't');
        $query = $this->db->get()->result();
        if (count($query) == 1) {
            $return = $query[0]->teto_id;
        } else if (count($query) > 1) {
            $teto_id1 = $query[0]->teto_id;
            $teto_id2 = $query[1]->teto_id;
            $i = 0;
            foreach ($verificador_teto as $value) {
                if ($teto_id1 == $value) {
                    $return = $teto_id2;
                    $i = 1;
                }
            }
            if ($i == 0) {
                $return = $teto_id1;
            }
        } else {
            $return = null;
        }
        return $return;
    }

    function excluirServidor($servidor_id) {

        $sql = "UPDATE ijf.tb_servidor
                        SET excluido = true, situacao_id = 2
                WHERE servidor_id = $servidor_id ";

        $this->db->query($sql);
        $sql = "UPDATE ijf.tb_servidor_teto
                        SET situacao = FALSE
                WHERE servidor_id = $servidor_id ";

        $this->db->query($sql);
        return true;
    }

    /**
     * Função para instanciar os valores da tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access private
     * @return Resposta true/false da conexão com o banco
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    private function instanciar($funcionario_id) {
        if ($funcionario_id != 0) {
            $this->db->select(' f.matricula,
                            f.nome,
                            f.cpf,
                            s.nome as setor,
                            s.setor_id,
                            tf.funcao_id,
                            tf.nome as funcao,
                            c.cargo_id,
                            c.nome as cargo,
                            ht.horariostipo_id,
                            ht.nome as horariostipo,
                            f.telefone,
                            f.celular');
            $this->db->from('tb_funcionario f');
            $this->db->join('tb_setor s', 's.setor_id = f.setor_id');
            $this->db->join('tb_funcao tf', 'tf.funcao_id = f.funcao_id');
            $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id');
            $this->db->join('tb_cargo c', 'c.cargo_id = f.cargo_id');
            $this->db->where("f.funcionario_id", $funcionario_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_funcionario_id = $funcionario_id;
            if (isset($return[0]->matricula)) : $this->_matricula = $return[0]->matricula;
            else : $this->matricula = "";
            endif;
            $this->_cpf = $return[0]->cpf;
            $this->_nome = $return[0]->nome;
            $this->_funcao_id = $return[0]->funcao_id;
            $this->_funcao = $return[0]->funcao;
            $this->_setor_id = $return[0]->setor_id;
            $this->_setor = $return[0]->setor;
            $this->_horariostipo_id = $return[0]->horariostipo_id;
            $this->_horariostipo = $return[0]->horariostipo;
            $this->_cargo_id = $return[0]->cargo_id;
            $this->_cargo = $return[0]->cargo;
            $this->_telefone = $return[0]->telefone;
            $this->_celular = $return[0]->celular;
        } else {
            $this->_funcioanrio_id = null;
        }
    }

}

?>
