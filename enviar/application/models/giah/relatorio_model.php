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
    class Relatorio_model extends Model {

        /* Propriedades da classe */

        /**
        * Função para listar os valores da tabela TB_SERVIDOR.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Array
        * @param string $parametro com a informação do nome ou sigla.
        * @param string $maximo.
        * @param string $inicio.
        */
        function listar($parametro=null) {
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
                            st.salario_base,
                            c.nome as classificacao,
                            s.desconto_inss,
                            st.conta,
                            st.conta_dv,
                            st.agencia,
                            st.agencia_dv,
                            s.situacao_id');
            $this->db->from('tb_servidor s');
            $this->db->join('tb_servidor_teto st', 'st.servidor_id = s.servidor_id');
            $this->db->join('tb_uo uc', 'uc.uo_id = s.uo_id_contrato');
            $this->db->join('tb_uo ul', 'ul.uo_id = s.uo_id_lotacao');
            $this->db->join('tb_funcao f', 'f.funcao_id = s.funcao_id');
            $this->db->join('tb_classificacao c', 'c.classificacao_id = s.classificacao_id');
            $this->db->where('s.situacao_id', 1); //ativo para servidor
            $this->db->where('st.situacao', 't'); //ativo para servidor
            if ($parametro != null && $parametro!= -1)
            { 
                $this->db->where('s.nome ilike', $parametro . "%");
                $this->db->orwhere('s.matricula ilike', $parametro . "%");
                $this->db->orwhere('s.cpf ilike', $parametro . "%");
            }
            $this->db->orderby('s.classificacao_id');
            $this->db->orderby('s.nome');
//            $this->db->orderby('s.nome');
            //$this->db->limit(1500);
            $return = $this->db->get();
            return $return->result();
        }

        /**
        * Função para listar os valores da tabela TB_SERVIDOR_TETO.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Array
        * @param integer $servidor_id com a informação do KEY do servidor.
        */

        function listarPencionista() {
            $this->db->select('p.nome,
                               p.percentual,
                               s.matricula'  );
            $this->db->from('tb_pensionista p');
            $this->db->join('tb_servidor s', 's.servidor_id = p.servidor_id');
            $this->db->where('p.situacao_id', 3);
            $this->db->where('s.situacao_id', 1);
            $this->db->orderby('p.nome');
            $return = $this->db->get();
            return $return->result();
        }

        /**
        * Função para listar os valores da tabela TB_SERVIDOR_TETO.
        * @author Equipe de desenvolvimento APH
        * @access public
        * @return Array
        * @param integer $servidor_id com a informação do KEY do servidor.
        */
        function listarIncentivo($competencia) {
            
            $this->db->select('i.competencia,
                               s.matricula,
                               s.nome,
                               i.valor,
                               i.observacao,
                               f.nome as funcao'  );
            $this->db->from('tb_incentivo i');
            $this->db->join('tb_servidor s', 's.servidor_id = i.servidor_id');
            $this->db->join('tb_funcao f', 'f.funcao_id = s.funcao_id');
            $this->db->where('i.situacao_id', 5);
            $this->db->where('i.competencia', "$competencia");
            $this->db->orderby('s.nome');
            $return = $this->db->get();
            return $return->result();
        }

//        function listarprovento($competencia) {
//
//            $this->db->select('p.competencia,
//                               s.matricula,
//                               s.nome,
//                               p.valor,
//                               i.valor as incentivo,
//                               p.inss,
//                               p.ir,
//                               p.pensao,
//                               c.nome as classificacao,
//                               f.nome as funcao'  );
//            $this->db->from('tb_provento p');
//            $this->db->join('tb_servidor_teto st', 'st.teto_id = p.servidor_id');
//            $this->db->join('tb_servidor s', 's.servidor_id = st.servidor_id');
//            $this->db->join('tb_funcao f', 'f.funcao_id = s.funcao_id');
//            $this->db->join('tb_incentivo i', 'i.teto_id = st.teto_id');
//            $this->db->join('tb_classificacao c', 'c.classificacao_id = s.classificacao_id');
////            $this->db->where('p.competencia', "'$competencia'");
////            $this->db->where('i.competencia', "'$competencia'");
//            //$this->db->groupby('classificacao_id');
//            $this->db->orderby('c.classificacao_id');
//            //$this->db->limit(300);
//
//            $return = $this->db->get();
//            return $return->result();
//        }


        function listarprovento($competencia) {
            $this->db->select('s.matricula,
                               s.nome,
                               c.nome as nomeclassificacao,
                               g.valor,
                               p.inss,
                               p.ir,
                               i.valor as incentivovalor,
                               p.pensao');
            $this->db->from('tb_provento p');
            $this->db->join('tb_servidor s', 's.servidor_id = p.servidor_id', 'left');
            $this->db->join('tb_giah_unificado g', 'p.servidor_id = g.servidor_id', 'left');
            $this->db->join('tb_incentivo i', 'i.servidor_id = s.servidor_id', 'left');
            $this->db->join('tb_classificacao c', 'c.classificacao_id = s.classificacao_id', 'left');
//            $this->db->where("p.competencia", "$competencia");
//            $this->db->where("g.competencia", "$competencia");
//            $this->db->where("i.competencia", "$competencia");
            //this->db->where('i.competencia', "'$competencia'");
            $this->db->orderby('c.nome');
            $this->db->orderby('s.nome');
            $return = $this->db->get();
            return $return->result();
//            $return = $this->db->count_all_results();
//            var_dump($return);
//            die;
        }
         function listarSuplementar($competencia) {

            $this->db->select('su.competencia,
                               s.matricula,
                               s.nome,
                               su.valor,
                               su.observacao,
                               f.nome as funcao'  );
            $this->db->from('tb_suplementar su');
            $this->db->join('tb_servidor s', 's.servidor_id = su.servidor_id');
            $this->db->join('tb_funcao f', 'f.funcao_id = s.funcao_id');
            //$this->db->where('i.competencia', "'$competencia'");
            $this->db->orderby('s.nome');
            $return = $this->db->get();
            return $return->result();
        }

    }
?>
