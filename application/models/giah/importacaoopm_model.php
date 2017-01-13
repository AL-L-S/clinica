<?php

    class Importacaoopm_model extends Model {

        function Importacaoopm_model() {
        parent::Model();
    }



    function gravarImportacao($co_procedimento, $no_procedimento, $tp_complexidade,
                               $tp_sexo,$qt_maxima_execucao,$qt_dias_permanencia,$qt_pontos,$vl_idade_minima,$vl_idade_maxima,
                               $vl_sh,$vl_sa,$vl_sp,$co_financiamento,$co_rubrica,$dt_competencia) {
         try {
             
            $this->db->set('co_procedimento', $co_procedimento);
            $this->db->set('no_procedimento', $no_procedimento);
            $this->db->set('tp_complexidade', $tp_complexidade);
            $this->db->set('tp_sexo', $tp_sexo);
            $this->db->set('qt_maxima_execucao', $qt_maxima_execucao);
            $this->db->set('qt_dias_permanencia', $qt_dias_permanencia);
            $this->db->set('qt_pontos', $qt_pontos);
            $this->db->set('vl_idade_minima', $vl_idade_minima );
            $this->db->set('vl_idade_maxima', $vl_idade_maxima);
            $this->db->set('vl_sh', $vl_sh);
            $this->db->set('vl_sa', $vl_sa);
            $this->db->set('vl_sp', $vl_sp );
            $this->db->set('co_financiamento', $co_financiamento);
            $this->db->set('co_rubrica', $co_rubrica);
            $this->db->set('dt_competencia', $dt_competencia);

            $this->db->insert('tb_import_opm_procedimento');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
            { return false; }
            else
            { return true; }

            } catch (Exception $exc)
            { return false; }

    }

    function listar(){
            $this->db->select('
                co_procedimento,
                no_procedimento,
                tp_complexidade,
                tp_sexo,
                qt_maxima_execucao,
                qt_dias_permanencia,
                qt_pontos,
                vl_idade_minima,
                vl_idade_maxima,
                vl_sh,
                vl_sa,
                vl_sp,
                co_financiamento,
                co_rubrica,
                dt_competencia
                ');
            $this->db->from('tb_import_opm_procedimento');
            $return = $this->db->get();
            return $return->result();
    }

       function gravarImportacaoCompativel($co_procedimento_principal, $co_registro_principal, $co_procedimento_compativel,
                               $co_registro_compativel,$tp_compatibilidade,$qt_permitida,$dt_competencia) {
         try {

            $this->db->set('co_procedimento_principal', $co_procedimento_principal);
            $this->db->set('co_registro_principal', $co_registro_principal);
            $this->db->set('co_procedimento_compativel', $co_procedimento_compativel);
            $this->db->set('co_registro_compativel', $co_registro_compativel);
            $this->db->set('tp_compatibilidade', $tp_compatibilidade);
            $this->db->set('qt_permitida', $qt_permitida);
            $this->db->set('dt_competencia', $dt_competencia);
          

            $this->db->insert('tb_import_opm_procedimento_compativel');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
            { return false; }
            else
            { return true; }

            } catch (Exception $exc)
            { return false; }

    }

        function listarCompativel(){
            $this->db->select('
                co_procedimento_principal,
                co_registro_principal,
                co_procedimento_compativel,
                co_registro_compativel,
                tp_compatibilidade,
                qt_permitida,
                dt_competencia
  
                ');
            $this->db->from('tb_import_opm_procedimento_compativel');
            $return = $this->db->get();
            return $return->result();
    }

    }
?>