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
class Incentivo_model extends Model {

    /**
    * Função construtora para setar os valores de conexão com o banco.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return void
    * @param integer $servidor_id com a informação do KEY do servidor.
    * @param integer $competencia com a informação da competencia atual.
    */
    function Incentivo_model($competencia=null, $servidor_id=null) {
        parent::Model();
        $this->load->model('giah/competencia_model', 'competencia');
        if (isset($competencia) && isset($servidor_id)) {
            $this->instanciar($competencia, $servidor_id);
        }
    }

//    /**
//    * Função para iniciar uma nova competencia tabela TB_INCENTIVO.
//    * @author Equipe de desenvolvimento APH
//    * @access public
//    * @param string $competencia com a informação da competencia atual.
//    */
//    function iniciarNovaCompetencia($competencia) {
//
//        $competencia = str_replace("/", "", $competencia);
//        $ano = substr($competencia, 0, 4);
//        $mes = substr($competencia, 4, 2);
//        if ($mes == "01") {
//            $anoant = (int) $ano - 1;
//            $mesant = "12";
//        } else {
//            $anoant = $ano;
//            $mesant = (int) $mes - 1;
//            if (strlen($mesant) == 1) {
//                $mesant = '0' . $mesant;
//            }
//        }
//
//            $sql = "insert into tb_incentivo
//                    (competencia, servidor_id, valor, observacao, situacao_id, operador_id)
//                    select '$competencia', servidor_id, valor, observacao , 5, 1
//                    from tb_incentivo
//                    where competencia = '" . $anoant . $mesant . "'
//                    and autoriza_direx = true and autoriza_super = true";
//            $this->db->query($sql);
//    }

    /**
    * Função para listar incentivos da competencia da tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param integer $servidor_id com a informação do KEY do servidor.
    * @param string $competencia com a informação da competencia atual.
    */
    function listarIncentivosDaCompetencia($competencia, $servidor=null) {
        $this->db->select(' i.competencia,
                                i.servidor_id,
                                i.valor,
                                i.observacao,
                                i.autoriza_direx,
                                i.autoriza_super,
                                i.operador_id,
                                u.uo_id,
                                u.nome as lotacao,
                                u.uo_hierarquia as direcao,
                                s.nome AS servidor,
                                o.usuario AS operador');
        $this->db->from('tb_incentivo i');
        $this->db->join('tb_servidor s', 's.servidor_id = i.servidor_id');
        $this->db->join('tb_operador o', 'o.operador_id = i.operador_id');
        $this->db->join('tb_uo u', 'u.uo_id = s.uo_id_lotacao');
        $this->db->where('i.competencia', $competencia);
        if (isset($servidor)) {
            $this->db->where("s.nome ilike '" . $servidor . "%'");
        }
        $this->db->orderby('u.uo_hierarquia');
        $this->db->orderby('u.uo_id');
        //$this->db->orderby('i.autoriza_direx');


        return $this->db->get()->result();
    }

    /**
    * Função para listar incentivos da competencia da tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param integer $servidor_id com a informação do KEY do servidor.
    * @param string $competencia com a informação da competencia atual.
    */
    function listarIncentivosDoAno($ano) {
        //$this->db->where('competencia like', $ano . "%");
        $rs = $this->db->get('vw_listaincentivo')->result();
        return $rs;
    }

    /**
    * Função para excluir um item da tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param integer $servidor_id com a informação do KEY do servidor.
    * @param string $competencia com a informação da competencia atual.
    */
    function delete($competencia, $servidor_id) {

        $this->db->where("competencia", $competencia);
        $this->db->where("servidor_id", $servidor_id);
        $this->db->delete('tb_incentivo');
        return true;
    }


    function verificarincentivoservidopor($competencia, $servidor_id) {
        $this->db->select();
        $this->db->from('tb_incentivo');
        $this->db->where("competencia", $competencia);
        $this->db->where("servidor_id", $servidor_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    /**
    * Função para inserir os valores na tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Resposta true/false da conexão com o banco
    * @param string $competencia com a informação da competencia atual
    */
    function gravar($competencia) {
        try {
            $servidor_id = $_POST['txtServidorID'];
            $valor = str_replace(",", ".", str_replace(".", "", $_POST['txtValor']));
            $observacao = $_POST['txtObservacao'];
            $tetoid = $_POST['txtTeto_id'];
            
            $this->db->set('valor', $valor);
            $this->db->set('observacao', $observacao);
            $this->db->set('teto_id', $tetoid);
            $this->db->set('situacao_id', 5); //TODO: hm verificar a situacao id para insercao
            $this->db->set('operador_id', 1);
            $this->db->set('competencia', $competencia);
            $this->db->set('servidor_id', $servidor_id);

            $this->db->insert('tb_incentivo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
    * Função para aprovar insentivos na tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Resposta true/false da conexão com o banco
    * @param string $competencia com a informação da competencia atual
    * @param integer $servidor_id com a informação do KEY do servidor.
    * @param integer $responsavel com o id do responsavel pela aprovação.
    * @param boolean $valor com a informação true/false.
    */
    function aprovar($responsavel, $competencia, $servidor_id, $valor) {
        if ($responsavel == 1) {
            $this->db->set('autoriza_direx', $valor);
        } else {
            $this->db->set('autoriza_super', $valor);
        }
        $this->db->where('competencia', $competencia);
        $this->db->where('servidor_id', $servidor_id);
        $this->db->update('tb_incentivo');
    }

    /**
    * Função para aprovar todos os incentivos da tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Resposta true/false da conexão com o banco
    * @param string $competencia com a informação da competencia atual
    * @param integer $responsavel com o id do responsavel pela aprovação.
    * @param boolean $valor com a informação true/false.
    */
    function aprovartodos($responsavel, $competencia, $valor) {
        
        if ($responsavel == 1) {
            $this->db->set('autoriza_direx', $valor);
            $this->db->where('autoriza_direx', null);
        } else {
            $this->db->set('autoriza_super', $valor);
            $this->db->where('autoriza_super', null);
        }
        $this->db->where('competencia', $competencia);
        $this->db->update('tb_incentivo');
    }

    /**
    * Função para aprovar todos os incentivos da tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Resposta true/false da conexão com o banco
    * @param string $competencia com a informação da competencia atual
    * @param integer $responsavel com o id do responsavel pela aprovação.
    * @param boolean $valor com a informação true/false.
    * @param integer $lotacao com o id da lotação.
    */
    function aprovartodossetor($responsavel, $competencia, $lotacao, $valor, $autoriza = null) {

        
        if ($responsavel == 1) {
                $autoriza = 'autoriza_direx';

        } else {
                $autoriza = 'autoriza_super';
        }
            
        $sql = "UPDATE ijf.tb_incentivo SET $autoriza = $valor WHERE competencia = '$competencia'
                AND $autoriza is null AND servidor_id IN (WITH RECURSIVE tb_arvore_uo (servidor_id) AS
                (
                    SELECT servidor_id
                    FROM ijf.tb_servidor s
                    WHERE uo_id_lotacao = $lotacao
                    UNION ALL
                    SELECT tb_uo.uo_id
                    FROM ijf.tb_uo
                    INNER JOIN ijf.tb_arvore_uo ON ijf.tb_uo.uo_id = ijf.tb_arvore_uo.servidor_id
                )
		select servidor_id from tb_arvore_uo)";
            $this->db->query($sql);

//        if ($responsavel == 1) {
//            $this->db->set('i.autoriza_direx', $valor);
//        } else {
//            $this->db->set('i.autoriza_super', $valor);
//        }
//        $this->db->where('i.competencia', $competencia);
//        $this->db->where('s.uo_id_lotacao', $lotacao);
//        $this->db->join('tb_servidor s', 'tb_servidor s.servidor_id = i.servidor_id');
//        $this->db->update('tb_incentivo i');
    }

    function virificarTeto ($competencia){
        $this->db->select();
        $this->db->from('tb_tetoincentivo');
        $this->db->where('competencia', $competencia);
        $this->db->where('uo_id', $_POST['txtDirecaoID']);
        $return = $this->db->count_all_results();
        return $return;
    }

    /**
    * Função para inserir os valores na tabela TB_TETOINCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Resposta true/false da conexão com o banco
    * @param string $competencia com a informação da competencia atual
    */
    function gravarTeto($competencia) {


        $this->db->set('competencia', $competencia);
        $this->db->set('uo_id', $_POST['txtDirecaoID']);
        $this->db->set('valor', str_replace(",", ".",str_replace(".", "", $_POST['txtValor'])));
        $rr = $this->db->insert('tb_tetoincentivo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    /**
    * Função para excluir um item da tabela TB_TETOINCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param integer $teto_id com a informação do KEY do teto.
    * @param string $competencia com a informação da competencia atual.
    */
    function excluirTeto($competencia, $teto_id) {

        $this->db->where('uo_id', $teto_id);
        $this->db->where('competencia', $competencia);
        $this->db->delete('tb_tetoincentivo');
        return true;
    }

    /**
    * Função para listar os tetos da competencia da tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param string $competencia com a informação da competencia atual.
    */
    function listarTetoDaCompetencia($competencia) {
        $this->db->select(' te.competencia,
                                te.valor,
                                te.uo_id,
                                u.nome as lotacao,
                                u.uo_hierarquia as direcao');
        $this->db->from('tb_tetoincentivo te');
        $this->db->join('tb_uo u', 'u.uo_id = te.uo_id');
        $this->db->where('te.competencia', $competencia);
        $this->db->orderby('u.uo_hierarquia');


        return $this->db->get()->result();
    }

    /**
    * Função para listar os tetos do ano da tabela TB_TETOINCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param string $ano com a informação do ano atual.
    */
    function listarTetoDoAno($ano) {

        $this->db->select('competencia,
                                SUM(valor) AS valor');
        $this->db->from('tb_tetoincentivo');
        //$this->db->where('competencia like', $ano . "%");
        $this->db->groupby('competencia');
        $this->db->orderby('competencia');

        return $this->db->get()->result();
    }

    /**
    * Função para somar incentivos dos setores da tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param string $competencia com a informação da competencia atual.
    */
    function somarIncentivo($competencia ) {
        $uo_id = $_POST['txtUo_id'];
        $sql = "WITH RECURSIVE tb_arvore_uo (uo_id, nome) AS
                (
                    SELECT uo_id, nome
                    FROM ijf.tb_uo
                    WHERE uo_hierarquia = case
                          when (SELECT uo_hierarquia FROM ijf.tb_uo u where uo_id = $uo_id) = 1 then $uo_id
                          else (SELECT uo_hierarquia FROM ijf.tb_uo u where uo_id = $uo_id)
                          end
                    UNION ALL
                    SELECT ijf.tb_uo.uo_id, tb_uo.nome
                    FROM ijf.tb_uo
                    INNER JOIN tb_arvore_uo ON ijf.tb_uo.uo_hierarquia = tb_arvore_uo.uo_id
                )
                SELECT SUM(valor) AS valor FROM ijf.tb_incentivo i
                JOIN ijf.tb_servidor s ON s.servidor_id = i.servidor_id
                JOIN tb_arvore_uo a ON a.uo_id = s.uo_id_lotacao
                where competencia = '$competencia'";
        return $this->db->query($sql)->result();

    }

    /**
    * Função para somar os incentivos das direções da tabela TB_INCENTIVO.
    * @author Equipe de desenvolvimento APH
    * @access public
    * @return Array
    * @param string $competencia com a informação da competencia atual.
    */
    function tetoIncentivodirecao($competencia ) {
        $uo_id = $_POST['txtUo_id'];
        $sql = "SELECT SUM(valor) AS valor FROM ijf.tb_tetoincentivo
                WHERE uo_id = case
                          when (SELECT uo_hierarquia FROM ijf.tb_uo u where uo_id = $uo_id) = 1 then $uo_id
                          else (SELECT uo_hierarquia FROM ijf.tb_uo u where uo_id = $uo_id)
                          end
                AND competencia = '$competencia'";

        return $this->db->query($sql)->result();
        
    }

}

?>
