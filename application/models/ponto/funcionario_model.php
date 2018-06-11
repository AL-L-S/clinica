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
class Funcionario_model extends Model {
    /* Propriedades da classe */

    var $_funcionario_id = null;
    var $_matricula = null;
    var $_cpf = null;
    var $_nome = null;
    var $_cargo_id = null;
    var $_cargo = null;
    var $_contrato = null;
    var $_funcao_id = null;
    var $_funcao = null;
    var $_setor_id = null;
    var $_setor = null;
    var $_horariostipo_id = null;
    var $_horariostipo = null;
    var $_telefone = null;
    var $_celular = null;
    var $_situacao_id = null;
    var $_email = null;
    var $_aniversario = null;

    /**
     * Função construtora para setar os valores de conexão com o banco.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    function Funcionario_model($funcionario_id = null) {
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
    function listar($args = array()) {
        $this->db->select(' f.funcionario_id,
                            f.matricula,
                            f.nome,
                            f.cpf,
                            s.nome as setor');
        $this->db->from('tb_funcionario f');
        $this->db->join('tb_setor s', 's.setor_id = f.setor_id ', 'left');
        $this->db->where('f.situacao_id', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('f.nome ilike', $args['nome'] . "%", 'left');
                $this->db->orwhere('f.matricula ilike', $args['nome'] . "%", 'left');
                $this->db->orwhere('f.cpf ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarcritica($funcionario_id, $inicio, $fim) {
        $this->db->select(' cf.criticafinal_id,
                            cf.data,
                            cf.entrada1,
                            cf.saida1,
                            cf.entrada2,
                            cf.saida2,
                            cf.entrada3,
                            cf.saida3,
                            cf.critica1');
        $this->db->from('tb_criticafinal cf');
        $this->db->join('tb_funcionario f', 'f.matricula = cf.matricula');
        $this->db->where('f.funcionario_id', $funcionario_id);
        $this->db->where("cf.data between '$inicio' and '$fim'");
        $this->db->orderby('cf.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariovariavel($funcionario_id) {
        $this->db->select(' hv.data,
                            hv.horaentrada1,
                            hv.horasaida1,
                            hv.horaentrada2,
                            hv.horasaida2,
                            hv.horaentrada3,
                            hv.horasaida3');
        $this->db->from('tb_horariofixorodado hv');
        $this->db->join('tb_funcionario f', 'f.horariostipo_id = hv.horariostipo_id');
        $this->db->where('f.funcionario_id', $funcionario_id);
        $this->db->orderby('hv.data');
        $return = $this->db->get();
        return $return->result();
    }

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
    function gravar() {
        try {

            /* inicia o mapeamento no banco */
            $funcionario_id = $_POST['txtFuncionarioID'];
            $this->db->set('matricula', $_POST['txtMatricula']);
            $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['txtCPF'])));
            $this->db->set('telefone', str_replace("(", "", str_replace(") ", "", str_replace("-", "", $_POST['txtTelefone']))));
            $this->db->set('celular', str_replace("(", "", str_replace(") ", "", str_replace("-", "", $_POST['txtcelular']))));
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('cargo_id', $_POST['txtCargo']);
            $this->db->set('horariostipo_id', $_POST['txtHorariostipo']);
            $this->db->set('email', $_POST['txtemail']);
            $this->db->set('aniversario', $_POST['txtaniversario']);
            $this->db->set('setor_id', $_POST['txtSetor']);
            $this->db->set('funcao_id', $_POST['txtFuncao']);
            if ($_POST['txtFuncionarioID'] == "") {// insert
                $this->db->insert('tb_funcionario');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $servidor_id = $this->db->insert_id();
            }
            else { // update
                $funcionario_id = $_POST['txtFuncionarioID'];
                $this->db->where('funcionario_id', $funcionario_id);
                $this->db->update('tb_funcionario');
            }

            return $funcionario_id;
        } catch (Exception $exc) {
            return -1;
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

    function excluirfuncionario($funcionario_id) {

        $sql = "UPDATE ponto.tb_funcionario
                        SET situacao_id = false
                WHERE funcionario_id = $funcionario_id ";

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
                            f.email,
                            f.aniversario,
                            f.celular');
            $this->db->from('tb_funcionario f');
            $this->db->join('tb_setor s', 's.setor_id = f.setor_id', 'left');
            $this->db->join('tb_funcao tf', 'tf.funcao_id = f.funcao_id', 'left');
            $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id', 'left');
            $this->db->join('tb_cargo c', 'c.cargo_id = f.cargo_id', 'left');
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
            $this->_email = $return[0]->email;
            $this->_aniversario = $return[0]->aniversario;
        } else {
            $this->_funcioanrio_id = null;
        }
    }

    public function relatorio() {

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
        $this->db->join('tb_setor s', 's.setor_id = f.setor_id', 'left');
        $this->db->join('tb_funcao tf', 'tf.funcao_id = f.funcao_id', 'left');
        $this->db->join('tb_horariostipo ht', 'ht.horariostipo_id = f.horariostipo_id', 'left');
        $this->db->join('tb_cargo c', 'c.cargo_id = f.cargo_id', 'left');
        $this->db->orderby('f.nome');
        $query = $this->db->get();
        $return = $query->result();
        return $return;
    }

    function listarautocomplete($parametro = null) {
        $this->db->select('funcionario_id,
                            nome');
        $this->db->from('tb_funcionario');
        $this->db->where('situacao_id', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

}

?>
