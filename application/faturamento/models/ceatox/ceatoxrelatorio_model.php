<?php
require_once APPPATH . 'models/base/BaseModel.php';
    class Ceatoxrelatorio_model extends BaseModel {

        /* Método construtor */
         function Ceatoxrelatorio_model() {
            parent::Model();

         }

         function listaTotalAgenteToxicoCircunstancia($i,$j){

            $this->db->from('notificacao');
            $this->db->where('agente_toxico', "$i");
            $this->db->where('circunstancia', "$j");

            $return = $this->db->count_all_results();
            return $return;
         }

         function listaParcialAgenteToxico($i){

            $this->db->from('notificacao');
            $this->db->where('agente_toxico', $i);

            $return = $this->db->count_all_results();
            return $return;
         }

         function listaParcialNotificacao($i){

            $this->db->from('notificacao');
            $this->db->where('agente_toxico', $i);

            $return = $this->db->get();
            return $return->result();
         }

         function listaTotalAgenteToxico(){

            $this->db->from('notificacao');
            $return = $this->db->count_all_results();
            return $return;
         }

        function listarAgenteToxico() {

            $this->db->select('codigo_agente_toxico,
                               descricao_agente_toxico
                              ');
            $this->db->from('notificacao_agente_toxico');

            $return = $this->db->get();
            return $return->result();

        }

        function listarCircunstancia() {

            $this->db->select('codigo_circunstancia,
                               descricao_circunstancia
                              ');
            $this->db->from('notificacao_circunstancia');

            $return = $this->db->get();
            return $return->result();
        }

       function listaTotalAgenteToxicoEvolucao($i,$j){

            $this->db->from('notificacao');
            $this->db->where('agente_toxico', "$i");
            $this->db->where('evolucao', "$j");

            $return = $this->db->count_all_results();
            return $return;
       }

//       function listaTotalAgenteToxicoIdade($i,$j){
//
//            $this->db->from('notificacao');
//            $this->db->where('agente_toxico', "$i");
//            $this->db->where('idade', $j." ANOS");
//
//            $return = $this->db->count_all_results();
//            return $return;
//       }

       function listarEvolucao() {

            $this->db->select('codigo_evolucao,
                               descricao_evolucao
                              ');
            $this->db->from('notificacao_evolucao');

            $return = $this->db->get();
            return $return->result();
       }

       function listaTotalAgenteToxicoSexo($i,$j){

            $this->db->from('notificacao');
            $this->db->where('agente_toxico', "$i");
            $this->db->where('sexo', "$j");

            $return = $this->db->count_all_results();
            return $return;
       }

        function listarSexo() {

            $this->db->select('codigo_sexo,
                               descricao_sexo
                              ');
            $this->db->from('notificacao_sexo');
            $this->db->orderby('codigo_sexo');

            $return = $this->db->get();
            return $return->result();
        }

//        function listarVitima() {
//
//            $this->db->select('codigo_vitima,
//                               descricao_vitima
//                              ');
//            $this->db->from('notificacao_vitima');
//
//            $return = $this->db->get();
//            return $return->result();
//        }

       function listaTotalAgenteToxicoZona($i,$j){

            $this->db->from('notificacao');
            $this->db->where('agente_toxico', "$i");
            $this->db->where('zona', "$j");

            $return = $this->db->count_all_results();
            return $return;
       }

        function listarZona() {

            $this->db->select('codigo_zona,
                               descricao_zona
                              ');
            $this->db->from('notificacao_zona');

            $return = $this->db->get();
            return $return->result();
        }


        function listarAgenteToxicoEvolucao($i,$j) {

            $this->db->select('n.agente_toxico,
                               a."descriçao_agente_toxico AS agente,
                               e."descriçao_evoluçao AS evolucao"
                               '  );
            $this->db->from('notificacao n');
            $this->db->join('notificacao_agente_toxico a', 'n.agente_toxico = a.codigo_agente_toxico');
            $this->db->join('notificacao_evolucao e', 'n."Codigo Evoluçao" = e.evolucao');
            $this->db->where('n.agente_toxico', $i);
            $this->db->where('n.evolucao', $j);

            $return = $this->db->count_all();
            return $return->result();
        }

        function listarAgenteToxicoSexo($i,$j) {

            $this->db->select('agente_toxico
                               '  );
            $this->db->from('notificacao');
            $this->db->where('agente_toxico', $i);
            $this->db->where('sexo', $j);

            $return = $this->db->count_all();
            return $return->result();
        }

        function listarAgenteToxicoZona($i,$j) {

            $this->db->select('agente_toxico
                               '  );
            $this->db->from('notificacao');
            $this->db->where('agente_toxico', $i);
            $this->db->where('zona', $j);

            $return = $this->db->count_all();
            return $return->result();
        }

//        function listarAgenteToxicoCircunstancia($i,$j) {
//
//
//            $this->db->from('notificacao');
//            $this->db->where('agente_toxico', $i);
//            $this->db->where('circunstancia', $j);
//
//            $return = $this->db->count_all_results();
//            //return $return->result();
//            return $return;
//        }

 }
?>