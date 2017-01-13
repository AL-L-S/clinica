<?php

    class Competencia_model extends Model {

        /* Propriedades da classe */
        var $competencia = null;
        var $data_abertura = null;
        var $data_fechamento = null;
        var $situacao_id = null;
 
        /* Método construtor */
        function Competencia_model($competencia=null) {
            parent::Model();
            if (isset ($competencia))
            { $this->instanciar($competencia); }
        }

        /* Métodos públicos */

        function competenciaAtiva() {
            $this->db->select('competencia');
            $this->db->where('situacao', 'aberto');
            $rs = $this->db->get('tb_competencia')->result();
            if (count($rs) > 0) {
                return $rs[0]->competencia;
            } else {
                return '000000';
            }
        }
        function listaAtiva() {
            $this->db->select('data_abertura, data_fechamento');
            $this->db->where('situacao', 'aberto');
            $rs = $this->db->get('tb_competencia')->result();
            return $rs;

        }

        function listar($ano=null) {
            $this->db->select('c.competencia,
                               c.data_abertura,
                               c.data_fechamento,
                               c.situacao');
            $this->db->from('tb_competencia c');
//            if (isset ($ano)) {
//                $this->db->where('competencia like', $ano . '%');
//            }
            $this->db->orderby('c.competencia');
            $rs = $this->db->get()->result();
            return $rs;
        }

        function abrir() {
            try {
                $this->db->trans_start();

                $competencia = str_replace("/", "", $_POST['txtCompetencia']);
                if (isset ($_POST['txtDataAbertura']))
                { $data_abertura = $_POST['txtDataAbertura']; }
                else
                { $data_abertura = date('y/m/d'); }
                if (isset ($_POST['txtDatafechamento']))
                { $data_fechamento = $_POST['txtDatafechamento']; }
                else
                { $data_fechamento = date('y/m/d'); }
                $situacao = 'aberto'; // Competencia aberta

                $this->db->set('competencia', $competencia);
                $this->db->set('data_abertura', $data_abertura);
                $this->db->set('data_fechamento', $data_fechamento);
                $this->db->set('situacao', $situacao);

                $this->db->insert('tb_competencia');

                // Fecha todas as demais competencias
                $this->db->query("UPDATE ponto.tb_competencia
                                  SET situacao = 'fechado'
                                  WHERE competencia <> '$competencia'");

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    return false;
                } else {
                    return true;
                }
            } catch (Exception $exc) {
                return false;
            }

        }

        function fechar($competencia) {
            try {
                $competencia        = $competencia;
                $situacao        = 'fechado'; // Competencia aberta

                $this->db->set('situacao', $situacao);
                $this->db->where('competencia', $competencia);

                $this->db->update('tb_competencia');

                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }
            } catch (Exception $exc) {
                return false;
            }

        }
        
        /* Métodos privadas */
        private function instanciar ($competencia=null) {
            if (isset ($competencia)) {
                $this->db->where("competencia", $competencia);
                $rs = $this->db->get("tb_competencia")->result();

                $this->competencia = $competencia;
                if (isset ($rs[0]->data_abertura)) : $this->data_abertura = $rs[0]->data_abertura; else : $this->data_abertura = null; endif;
                if (isset ($rs[0]->data_fechamento)) : $this->data_fechamento = $rs[0]->data_fechamento; else : $this->data_fechamento = null; endif;
                $this->situacao_id = $rs[0]->situacao;
            } else  {
                $this->competencia = null;
            }
        }

    }
?>
