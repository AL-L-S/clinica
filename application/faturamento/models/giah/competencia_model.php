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
            $this->db->where('situacao_id', 21);
            $rs = $this->db->get('tb_competencia')->result();
            if (count($rs) > 0) {
                return $rs[0]->competencia;
            } else {
                return '000000';
            }
        }

        function listar($ano=null) {
            $this->db->select('c.competencia,
                               c.data_abertura,
                               c.data_fechamento,
                               c.situacao_id,
                               s.nome as situacao');
            $this->db->from('tb_competencia c');
            $this->db->join('tb_situacao s', 's.situacao_id = c.situacao_id');
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
                $situacao_id = 21; // Competencia aberta

                $this->db->set('competencia', $competencia);
                $this->db->set('data_abertura', $data_abertura);
                $this->db->set('situacao_id', $situacao_id);

                $this->db->insert('tb_competencia');

                // Fecha todas as demais competencias
                $this->db->query('UPDATE ijf.tb_competencia
                                  SET situacao_id = 22,
                                  data_fechamento = \'' . date('Y/m/d') .'\'
                                  WHERE competencia <> \''.$competencia.'\'');

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
                $data_fechamento    = date('Y/m/d');
                $situacao_id        = 22; // Competencia aberta

                $this->db->set('data_fechamento', $data_fechamento);
                $this->db->set('situacao_id', $situacao_id);
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
                $this->situacao_id = $rs[0]->situacao_id;
            } else  {
                $this->competencia = null;
            }
        }

    }
?>
