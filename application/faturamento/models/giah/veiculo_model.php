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
    class Veiculo_model extends Model {

        /**
        * Função construtora para setar os valores de conexão com o banco.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return void
        */
        function Veiculo_model() {
            parent::Model();
        }

        /**
        * Função para listar os valores da tabela TB_SUPLEMENTAR.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Array
        * @param integer $servidor_id com a informação do KEY do servidor.
        * @param string $competencia com a informação da competencia atual.
        */
        function listarVeiculoDoServidor($servidor_id) {
            
            $this->db->select('v.servidor_id,
                               v.veiculo_servidor_id,
                               v.modelo,
                               m.marca,
                               v.placa,
                               s.nome');
            $this->db->from('tb_veiculo_servidor v');
            $this->db->join('tb_servidor s', 's.servidor_id = v.servidor_id');
            $this->db->join('tb_veiculo_marca m', 'm.marca_id = v.marca');
            $this->db->where('s.servidor_id', $servidor_id);
            $rs = $this->db->get()->result();
            return $rs;
        }

        function listar($parametro=null) {
            
            $this->db->select('v.servidor_id,
                               v.veiculo_servidor_id,
                               v.modelo,
                               v.marca,
                               v.placa,
                               s.nome');
            $this->db->from('tb_veiculo_servidor v');
            $this->db->join('tb_servidor s', 's.servidor_id = v.servidor_id');
            $this->db->where('v.placa ilike', $parametro . "%");
            return $this->db->get()->result();
        }

        function listarCor() {

            $this->db->select('cor_id,
                               cor');
            $this->db->from('tb_veiculo_cor');
            return $this->db->get()->result();
        }

        function listarMarca() {

            $this->db->select('marca_id,
                               marca');
            $this->db->from('tb_veiculo_marca');
            return $this->db->get()->result();
        }

        function listarEstacionamento($parametro=null) {
            $this->db->select('e.veiculo_estacionamento_id,
                               e.servidor_id,
                               e.veiculo_servidor_id,
                               v.modelo,
                               e.dataentrada,
                               e.horaentrada,
                               v.marca,
                               e.placa,
                               s.nome');
            $this->db->from('tb_veiculo_estacionamento e');
            $this->db->join('tb_servidor s', 's.servidor_id = e.servidor_id');
            $this->db->join('tb_veiculo_servidor v', 'v.veiculo_servidor_id = e.veiculo_servidor_id');
            $this->db->where('e.horasaida', null);
            if ($parametro != null && $parametro!= -1)
            {
                $this->db->where('e.placa ilike', $parametro . "%");
            }
            
            $rs = $this->db->get()->result();
            return $rs;
        }

        /**
        * Função para inserir os valores na tabela TB_SUPLEMENTAR.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Resposta true/false da conexão com o banco
        * @param string $competencia com a informação da competencia atual
        */
        function gravar() {
            try {
                /* inicia o mapeamento no banco */
                $servidor_id    = $_POST['txtServidorID'];
                $placa          =  str_replace("-", "", $_POST['txtPlaca']);
                $this->db->set('cor', $_POST['txtCor']);
                $this->db->set('servidor_id', $servidor_id);
                $this->db->set('modelo', $_POST['txtModelo']);
                $this->db->set('marca', $_POST['txtMarca']);
                $this->db->set('placa', $placa);
                $this->db->insert('tb_veiculo_servidor');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }

            } catch (Exception $exc) {
                return false;
            }

        }

        function gravarestacionamento() {
            try {
                /* inicia o mapeamento no banco */
                $servidor_id    = $_POST['txtServidorID'];
                $placa          =  str_replace("-", "", $_POST['txtPlacaLabel']);
                $this->db->set('veiculo_servidor_id', $_POST['txtVeiculoServidorID']);
                $this->db->set('servidor_id', $servidor_id);
                $this->db->set('dataentrada', date("d/m/Y"));
                $this->db->set('horaentrada', date("H:i:s"));
                $this->db->set('placa', $placa);
                $this->db->insert('tb_veiculo_estacionamento');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }

            } catch (Exception $exc) {
                return false;
            }

        }

        function saidaestacionamento($veiculo_estacionamento_id) {
            try {

                $this->db->set('datasaida', date("d/m/Y"));
                $this->db->set('horasaida', date("H:i:s"));
                $this->db->where('veiculo_estacionamento_id', $veiculo_estacionamento_id);
                $this->db->update('tb_veiculo_estacionamento');
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
        * Função para excluir um item da tabela TB_SUPLEMENTAR.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Resposta true/false da conexão com o banco
        * @param integer $servidor_id com a informação do KEY do servidor.
        * @param string $competencia com a informação da competencia atual.
        */
        function excluir($veiculo_id) {
            $this->db->where('veiculo_servidor_id', $veiculo_id);
            $this->db->delete('tb_veiculo_servidor');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
            { return false; }
            else
            { return true; }
        }

    }
?>
