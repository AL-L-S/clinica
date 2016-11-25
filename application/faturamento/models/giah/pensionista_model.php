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
    class Pensionista_model extends Model {

         /* Propriedades da classe */
        var $pensionista_id = null;
        var $cpf = null;
        var $pensionistanome = null;
        var $servidor_id = null;
        var $nome = null;
        var $banco = null;
        var $agencia = null;
        var $agencia_dv = null;
        var $conta = null;
        var $conta_dv = null;
        var $percentual = null;
        var $situacao_id = null;


        /**
        * Função construtora para setar os valores de conexão com o banco.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return void
        * @param integer $pensionista_id com a informação do KEY do pensionista.
        */
        function Pensionista_model($pensionista_id=null) {
            parent::Model();
            if (isset ($pensionista_id))
            { $this->instanciar($pensionista_id); }
        }

        /**
        * Função para informar todos os registros da tabela TB_PENSIONISTA.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Array
        * @param string $servidor_id com a informação do KEY do servidor.
        */
        function listarPensionistasDoServidor($servidor_id) {
            $this->db->select('p.pensionista_id,
                            p.servidor_id,
                            s.nome as servidor,
                            s.cpf,
                            p.nome,
                            p.cpf,
                            p.banco,
                            p.agencia,
                            p.agencia_dv,
                            p.conta,
                            p.conta_dv,
                            p.percentual,
                            p.situacao_id'  );
            $this->db->from('tb_pensionista p');
            $this->db->join('tb_servidor s', 's.servidor_id = p.servidor_id');
            $this->db->where('p.situacao_id', 3); //ativo para pensionista
            $this->db->where('p.servidor_id', $servidor_id);
            $this->db->orderby('p.nome');
            $return = $this->db->get();
            return $return->result();
        }

        /**
        * Função para excluir os valores da tabela TB_PENSIONISTA.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Resposta true/false da conexão com o banco
        * @param integer $pensionista_id com a informação do KEY do pensionista.
        */
        function excluir($pensionista_id) {
            $this->db->set('situacao_id', 4);
            $this->db->set('data_exclusao', date("Y/m/d"));
            $this->db->where('pensionista_id', $pensionista_id);
            $this->db->update('tb_pensionista');
            return true;
        }

        /**
        * Função para gravar valores na tabela TB_PENSIONISTA.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Resposta true/false da conexão com o banco
        */
        function gravar() {
            try {
                /* inicia o mapeamento no banco */
                $this->db->set('servidor_id', $_POST['txtServidorID']);
                $this->db->set('cpf', str_replace("-", "",str_replace(".", "", $_POST['txtCPF'])));
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->set('banco', $_POST['txtBanco']);
                $this->db->set('agencia',$_POST['txtAgencia']);
                $this->db->set('agencia_dv', $_POST['txtAgenciaDV']);
                $this->db->set('conta', $_POST['txtConta']);
                $this->db->set('conta_dv', $_POST['txtContaDV']);
                $this->db->set('percentual', $_POST['txtPercentual'] / 100);
                $this->db->set('situacao_id', 3); // Ativo para pensionista
                $this->db->set('data_inclusao', date("Y/m/d"));

                $this->db->insert('tb_pensionista');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }

            } catch (Exception $exc) {
                return false;
            }

        }

        /**
        * Função para instanciar os valores da tabela TB_PENSIONISTA.
        * @author Equipe de desenvolvimento APH
        * @access private
        * @return Resposta true/false da conexão com o banco
        * @param integer $pensionista_id com a informação do KEY do pensionista.
        */
        private function instanciar ($pensionista_id) {
            if ($pensionista_id != 0) {

            $this->db->select('p.pensionista_id,
                            p.servidor_id,
                            s.nome as servidor,
                            s.cpf,
                            p.nome,
                            p.cpf,
                            p.banco,
                            p.agencia,
                            p.agencia_dv,
                            p.conta,
                            p.conta_dv,
                            p.percentual,
                            p.situacao_id'  );
            $this->db->from('tb_pensionista p');
            $this->db->join('tb_servidor s', 's.servidor_id = p.servidor_id');
            $this->db->where('pensionista_id', $pensionista_id); //ativo para servidor
                $query = $this->db->get();
                $return = $query->result();
                $this->pensionista_id = $pensionista_id;
                $this->servidor_id = $return[0]->servidor_id;
                $this->nome = $return[0]->servidor;
                $this->cpf = $return[0]->cpf;
                $this->pensionistanome = $return[0]->nome;
                $this->banco = $return[0]->banco;
                $this->agencia = $return[0]->agencia;
                $this->agencia_dv = $return[0]->agencia_dv;
                $this->conta = $return[0]->conta;
                $this->conta_dv = $return[0]->conta_dv;
                $this->percentual = $return[0]->percentual;
                $this->situacao_id = $return[0]->situacao_id;
            } else  {
                $this->pensionista_id = null;
            }
        }
        
      }
?>
