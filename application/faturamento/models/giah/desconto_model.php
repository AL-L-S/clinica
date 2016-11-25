<?php

    class Desconto_model extends Model {

        /* Propriedades da classe */
        var $competencia = null;
        var $tipodesconto_id = null;
        var $tipodesconto = null;
        var $servidor_id = null;
        var $servidor = null;
        var $valor = null;
        var $situacao_id = null;

        /* Método construtor */
        function Desconto_model() {
            parent::Model();
        }

        /* Métodos públicos */

        function listarDescontosDoServidor($servidor_id, $competencia) {
            $this->db->select(' d.servidor_id,
                                d.competencia,
                                d.tipodesconto_id,
                                d.desconto_percentual,
                                t.nome as tipodesconto,
                                d.valor');
            $this->db->from('tb_desconto d');
            $this->db->join('tb_tipodesconto t', 't.tipodesconto_id = d.tipodesconto_id');
            $this->db->where('d.servidor_id', $servidor_id);
            $this->db->where('d.competencia', $competencia);
            $return = $this->db->get();
            return $return->result();
        }

        function gravar($competencia) {
            $servidor_id        = $_POST['txtServidorID'];
            $tipodesconto_id    = $_POST['txtTipodescontoID'];
            $valor              = str_replace(",", ".", $_POST['txtValor']);
            if (isset ($_POST['txtDescontoPercentual'])) $this->db->set('desconto_percentual', $_POST['txtDescontoPercentual']);
            $this->db->set('teto_id', $_POST['txtServidorteto']);
            $this->db->set('competencia', $competencia);
            $this->db->set('tipodesconto_id', $tipodesconto_id);
            $this->db->set('servidor_id', $servidor_id);
            $this->db->set('valor', $valor);

            $this->db->insert('tb_desconto');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
            { return false; }
            else
            { return true; }
        }

        function excluir($servidor_id, $competencia, $tipodesconto_id) {
            $this->db->where('servidor_id', $servidor_id);
            $this->db->where('competencia', $competencia);
            $this->db->where('tipodesconto_id', $tipodesconto_id);
            $this->db->delete('tb_desconto');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
            { return false; }
            else
            { return true; }
        }


    }
?>
