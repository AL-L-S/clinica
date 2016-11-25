<?php
require_once APPPATH . 'models/base/BaseModel.php';

    class Vigilante_model extends BaseModel {

         /* Propriedades da classe */
        var $vigilante_id = null;
        var $nome = null;



   
        function Vigilante_model() {
            parent::Model();

            
        }


//       function listarVigilantes($parametro=null) {
//        $this->db->select('vigilante_id,
//                           nome
//                         ');
//        if ($parametro != null) {
//            $this->db->where('nome ilike', $parametro . "%");
//        }
//        $this->db->where('situacao_id' , 3);
//        $this->db->from('tb_vigilante');
//        $return = $this->db->get();
//
//        return $return->result();
//
//    }

        function listarVigilantes($args = array()) {
        $this->db->from('tb_vigilante')
                 ->select('"tb_vigilante".*')
                 ->where('tb_vigilante.situacao_id', 3);

        if ($args) {
            if (isset ($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->like('tb_vigilante.nome', $args['nome'], 'left');
            }
        }
        return $this->db;
    }
   
        function excluir($vigilante_id) {
            $this->db->set('situacao_id', 4);
            $this->db->where('vigilante_id', $vigilante_id);
            $this->db->update('tb_vigilante');
            if($this->db->affected_rows()>0) return true;
            else return false;
        }

 
        function gravar() {
            try {
                /* inicia o mapeamento no banco */
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->set('situacao_id', 3);
                

                $this->db->insert('tb_vigilante');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }

            } catch (Exception $exc) {
                return false;
            }

        }


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
