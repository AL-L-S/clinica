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
class Servidor_model extends Model
{
    /* Propriedades da classe */

    var $_servidor_id = null;
    var $_matricula = null;
    var $_cpf = null;
    var $_nome = null;
    var $_crp = null;
    var $_crptipo = null;
    var $_categoria = null;
    var $_uo_id_contrato = null;
    var $_contrato = null;
    var $_uo_id_lotacao = null;
    var $_lotacao = null;
    var $_funcao_id = null;
    var $_funcao = null;
    var $_classificacao_id = null;
    var $_classificacao = null;
    var $_banco = null;
    var $_agencia = null;
    var $_agencia_dv = null;
    var $_conta = null;
    var $_conta_dv = null;
    var $_inss = null;
    var $_salario_base = null;
    var $_gratificacao_funcao = null;
    var $_situacao_id = null;

    /**
     * Função construtora para setar os valores de conexão com o banco.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return void
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    function Servidor_model($servidor_id=null)
    {
        parent::Model();
        if (isset($servidor_id)) {
            $this->instanciar($servidor_id);
        }
    }

    /**
     * Função para informar todos os registros da tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param string $parametro com a informação do nome matricula ou cpf.
     */
    function totalRegistros($parametro)
    {
        $this->db->select('s.servidor_id');
        $this->db->from('tb_servidor s');
        $this->db->join('tb_servidor_teto st', 'st.servidor_id = s.servidor_id', 'left');
        $this->db->where('s.situacao_id', 1); //ativo para servidor
        if ($parametro != null && $parametro != -1) {
            $this->db->where('s.nome ilike', $parametro . "%");
            $this->db->orwhere('s.matricula ilike', $parametro . "%");
            $this->db->orwhere('s.cpf ilike', $parametro . "%");
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    /**
     * Função para informar todos os registros ativos da tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     */
    function totalAtivos()
    {
        $this->db->where('situacao_id', 1);
        return $this->db->count_all('tb_servidor');
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
    function listar($args = array())
    {
        $this->db->select('s.servidor_id,
                            s.matricula,
                            s.nome,
                            s.cpf,
                            s.crp,
                            s.crp_tipo,
                            s.uo_id_contrato,
                            uc.nome as uo_contrato,
                            s.uo_id_lotacao,
                            ul.nome as lotacao,
                            s.funcao_id,
                            f.nome as funcao,
                            s.classificacao_id,
                            c.nome as classificacao,
                            s.desconto_inss,
                            s.situacao_id,
                            s.excluido');
        $this->db->from('tb_servidor s');
        $this->db->join('tb_uo uc', 'uc.uo_id = s.uo_id_contrato');
        $this->db->join('tb_uo ul', 'ul.uo_id = s.uo_id_lotacao');
        $this->db->join('tb_funcao f', 'f.funcao_id = s.funcao_id');
        $this->db->join('tb_classificacao c', 'c.classificacao_id = s.classificacao_id');
        $this->db->where('s.excluido', 'f'); //ativo para servidor
//            $this->db->orderby('s.nome');
//            $this->db->groupby('s.servidor_id, s.matricula, s.nome, s.cpf, s.crp, s.crp_tipo, s.uo_id_contrato, uc.nome, s.uo_id_lotacao,
//                            ul.nome, s.funcao_id, f.nome, s.classificacao_id, c.nome, s.desconto_inss, s.situacao_id');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('s.nome ilike', $args['nome'] . "%", 'left');
                $this->db->orwhere('s.matricula ilike', $args['nome'] . "%", 'left');
                $this->db->orwhere('s.cpf ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    /**
     * Função para listar os valores da tabela TB_SERVIDOR_TETO.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Array
     * @param integer $servidor_id com a informação do KEY do servidor.
     */
    function listarTeto($servidor_id)
    {
        $this->db->select('st.servidor_id,
                            st.teto_id,
                            st.matricula_sam,
                            st.banco,
                            s.nome,
                            st.agencia,
                            st.agencia_dv,
                            st.conta,
                            st.conta_dv,
                            st.situacao,
                            st.salario_base');
        $this->db->from('tb_servidor_teto st');
        $this->db->join('tb_servidor s', 's.servidor_id = st.servidor_id');
        $this->db->where('st.servidor_id', $servidor_id);
        $this->db->where('st.situacao', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function instaciarTeto($teto_id)
    {
        $this->db->select('st.servidor_id,
                            st.teto_id,
                            st.matricula_sam,
                            st.banco,
                            s.nome,
                            st.agencia,
                            st.agencia_dv,
                            st.conta,
                            st.conta_dv,
                            st.situacao,
                            st.salario_base');
        $this->db->from('tb_servidor_teto st');
        $this->db->join('tb_servidor s', 's.servidor_id = st.servidor_id');
        $this->db->where('st.teto_id', $teto_id);
        $this->db->where('st.situacao', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarTetoautocomplete($parametro=null)
    {
        $this->db->select('st.servidor_id,
                            st.teto_id,
                            st.matricula_sam,
                            s.matricula,
                            st.banco,
                            s.nome,
                            st.agencia,
                            st.agencia_dv,
                            s.uo_id_lotacao,
                            st.conta,
                            st.conta_dv,
                            st.situacao,
                            st.salario_base');
        $this->db->from('tb_servidor_teto st');
        $this->db->join('tb_servidor s', 's.servidor_id = st.servidor_id');
        $this->db->where('st.situacao', 't');
        if ($parametro != null && $parametro != -1) {
            $this->db->where('s.nome ilike', $parametro . "%");
            $this->db->orwhere('s.matricula ilike', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
    function gravar()
    {
        try {

            if (isset($_POST['btnExcluir'])) {
                $servidor_id = $_POST['txtServidorID'];
                $this->db->set('excluido', 't');
                $this->db->where('servidor_id', $servidor_id);
                $this->db->update('tb_servidor');
                $servidor_id = 0;
            } else {
                /* inicia o mapeamento no banco */
                $servidor_id = $_POST['txtServidorID'];
                $this->db->set('matricula', $_POST['txtMatricula']);
                $this->db->set('cpf', str_replace("-", "", str_replace(".", "", $_POST['txtCPF'])));
                $this->db->set('nome', $_POST['txtNome']);
                if (isset($_POST['txtCRP']))
                    $this->db->set('crp', $_POST['txtCRP']);
                if (($_POST['txtCRPTipo'] != 0))
                    $this->db->set('crp_tipo', $_POST['txtCRPTipo']);
                $this->db->set('uo_id_contrato', $_POST['txtUOContrato']);
                $this->db->set('uo_id_lotacao', $_POST['txtUOLotacao']);
                $this->db->set('funcao_id', $_POST['txtFuncao']);
                $this->db->set('classificacao_id', $_POST['txtClassificacao']);
                if (isset($_POST['txtInss'])) {
                    $this->db->set('desconto_inss', 't');
                } else {
                    $this->db->set('desconto_inss', 'f');
                }
                //
                if (isset($_POST['txtProdutividade'])) {
                    $this->db->set('situacao_id', 1);
                } else {
                    $sql = "UPDATE ijf.tb_servidor_teto
                             SET situacao = FALSE
                             WHERE servidor_id = $servidor_id ";
                    $this->db->query($sql);
                    $this->db->set('situacao_id', 2);
                }


                //


                if (isset($_POST['txtCategoria']))
                    $this->db->set('categoria', $_POST['txtCategoria']);
                //$this->db->set('categoria', $_POST['txtCategoria']);


                if ($_POST['txtServidorID'] == "") {// insert
                    $this->db->insert('tb_servidor');
                    $erro = $this->db->_error_message();
                    if (trim($erro) != "") // erro de banco
                        return -1;
                    else
                        $servidor_id = $this->db->insert_id();
                }
                else { // update
                    $servidor_id = $_POST['txtServidorID'];
                    $this->db->where('servidor_id', $servidor_id);
                    $this->db->update('tb_servidor');
                }
            }
            return $servidor_id;
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
    function getServidorID($crm, $verificador_teto)
    {
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

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
    function gravarTeto($teto_id)
    {

        if (isset($_POST['txtMatricula']))
            $this->db->set('matricula_sam', $_POST['txtMatricula']);
        $this->db->set('banco', $_POST['txtBanco']);
        $this->db->set('agencia', $_POST['txtAgencia']);
        $this->db->set('agencia_dv', $_POST['txtAgenciaDV']);
        $this->db->set('conta', $_POST['txtConta']);
        $this->db->set('conta_dv', $_POST['txtContaDV']);
        $this->db->set('servidor_id', $_POST['txtServidorID']);
        $this->db->set('salario_base', str_replace(",", ".", str_replace(".", "", $_POST['txtSalarioBase'])));
        if ($_POST['txtTetoID'] == "0") {
            $this->db->insert('tb_servidor_teto');
        } else {
            $this->db->where('teto_id', $teto_id);
            $this->db->update('tb_servidor_teto');
        }
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    /**
     * Função para excluir os valores da tabela TB_SERVIDOR_TETO.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     * @param integer $teto_id com a informação do KEY do servidor.
     */
    function excluirTeto($teto_id)
    {

        $sql = "UPDATE ijf.tb_servidor_teto
                        SET situacao = FALSE
                WHERE teto_id = $teto_id ";

        $this->db->query($sql);
        return true;
    }

    function excluirServidor($servidor_id)
    {

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
    private function instanciar($servidor_id)
    {
        if ($servidor_id != 0) {

            $this->db->select('s.servidor_id,
                            s.matricula,
                            s.nome,
                            s.cpf,
                            s.crp,
                            s.crp_tipo,
                            s.uo_id_contrato,
                            uc.nome as uo_contrato,
                            s.uo_id_lotacao,
                            ul.nome as lotacao,
                            s.categoria,
                            s.funcao_id,
                            f.nome as funcao,
                            s.classificacao_id,
                            c.nome as classificacao,
                            s.desconto_inss,
                            s.situacao_id');
            $this->db->from('tb_servidor s');
            $this->db->join('tb_servidor_teto st', 'st.servidor_id = s.servidor_id', 'left');
            $this->db->join('tb_uo uc', 'uc.uo_id = s.uo_id_contrato');
            $this->db->join('tb_uo ul', 'ul.uo_id = s.uo_id_lotacao');
            $this->db->join('tb_funcao f', 'f.funcao_id = s.funcao_id');
            $this->db->join('tb_classificacao c', 'c.classificacao_id = s.classificacao_id');
            $this->db->where("s.servidor_id", $servidor_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_servidor_id = $servidor_id;
            if (isset($return[0]->matricula)) : $this->_matricula = $return[0]->matricula;
            else : $this->matricula = "";
            endif;
            $this->_cpf = $return[0]->cpf;
            $this->_nome = $return[0]->nome;
            if (isset($return[0]->crp)) : $this->_crp = $return[0]->crp;
            else : $this->_crp = "";
            endif;
            if (isset($return[0]->crp_tipo)) : $this->_crptipo = $return[0]->crp_tipo;
            else : $this->_crptipo = "";
            endif;
            if (isset($return[0]->categoria)) : $this->_categoria = $return[0]->categoria;
            else : $this->_categoria = "";
            endif;
            $this->_uo_id_contrato = $return[0]->uo_id_contrato;
            $this->_uo_contrato = $return[0]->uo_id_contrato;
            $this->_contrato = $return[0]->uo_contrato;
            $this->_uo_id_lotacao = $return[0]->uo_id_lotacao;
            $this->_lotacao = $return[0]->lotacao;
            $this->_funcao_id = $return[0]->funcao_id;
            $this->_funcao = $return[0]->funcao;
            $this->_classificacao_id = $return[0]->classificacao_id;
            $this->_classificacao = $return[0]->classificacao;
            $this->_inss = $return[0]->desconto_inss;
            if (isset($return[0]->gratificacao_funcao)) : $this->_gratificacao_funcao = $return[0]->gratificacao_funcao;
            else: $this->_gratificacao_funcao = "";
            endif;
            $this->_situacao_id = $return[0]->situacao_id;
        } else {
            $this->_servidor_id = null;
        }
    }

}

?>
