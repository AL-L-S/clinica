<?php
require_once APPPATH . 'models/base/BaseModel.php';

    class Ambulancia_model extends BaseModel {

        /* Propriedades da classe */
        var $_ambulancia_id = null;



        /* Método construtor */
         function Ambulancia_model($ambulancia_id=null) {
            parent::Model();

         }


     function totalRegistros($parametro) {
            $this->db->select('ambulancia_id');
            $this->db->from('tb_ambulancia');
            if ($parametro != null && $parametro != -1)
            {
                $this->db->where('paciente ilike', $parametro . "%");
                $this->db->orwhere('motorista ilike', $parametro . "%");
            }

            $return = $this->db->count_all_results();
            return $return;
        }

//    function listarCadastros() {
//            $sql = "SELECT
//                    placa,
//                    data,
//                    hora,
//                    cidade_id,
//                    estado_id,
//                    paciente,
//                    motorista,
//                    vigilante_id
//                    FROM tb_ambulancia
//                    ORDER BY data
//            ";
//
//     return $this->db->query($sql)->result();
//     }

//    function listarCadastros() {
//    $this->db->select('     a.ambulancia_id,
//                            a.placa,
//                            a.data,
//                            a.hora,
//                            a.cidade_id,
//                            a.estado_id,
//                            a.paciente,
//                            a.motorista,
//                            a.vigilante_id,
//                            e.sigla as estado,
//                            c.nome as cidade,
//                            v.nome
//                            ');
//            $this->db->from('tb_ambulancia a');
//            $this->db->join('tb_estado e', 'e.estado_id = a.estado_id');
//            $this->db->join('tb_cidade c', 'c.cidade_id = a.cidade_id');
//            $this->db->join('tb_vigilante v', 'v.vigilante_id = a.vigilante_id');
//            $this->db->orderby('a.data','DESC');
//            $return = $this->db->get();
//
//            return $return->result();
//
//     }


   function listarCadastros($args = array()) {
        $this->db->from('tb_ambulancia')
                 ->join('tb_cidade', 'tb_cidade.cidade_id = tb_ambulancia.cidade_id', 'left')
                 ->join('tb_estado', 'tb_estado.estado_id = tb_ambulancia.estado_id', 'left')
                 ->join('tb_vigilante', 'tb_vigilante.vigilante_id = tb_ambulancia.vigilante_id', 'left')
                 ->select('"tb_ambulancia".*, tb_cidade.nome as cidade, tb_estado.sigla as estado, tb_vigilante.nome');

        if ($args) {
            if (isset ($args['nome']) && strlen($args['nome']) > 0) {
//                $this->db->like('tb_ambulancia.paciente', $args['nome'], 'left');
                  $this->db->where('tb_ambulancia.paciente ilike', $args['nome'] . "%", 'left');
                  $this->db->orwhere('tb_cidade.nome ilike', $args['nome'] . "%", 'left');
                  $this->db->orwhere('tb_ambulancia.placa ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarEstados($parametro=null) {
        $this->db->select('estado_id,
                           nome
                         ');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $this->db->from('tb_estado');
        $return = $this->db->get();

        return $return->result();

    }

    function listarCidades($parametro=null) {
        $this->db->select('municipio_id,
                           nome,estado
                         ');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro . "%");
        }
        $this->db->from('tb_municipio');
        $return = $this->db->get();

        return $return->result();

    }

//    function gravar() {
//            try {
//                /* inicia o mapeamento no banco */
//                $this->db->set('placa', $_POST['txtPlaca']);
//                $this->db->set('data', $_POST['txtData']);
//                $this->db->set('hora', $_POST['txtHora']);
//                $this->db->set('cidade_id', $_POST['txtCidadeID']);
//                $this->db->set('estado_id', $_POST['txtEstadoID']);
//                $this->db->set('paciente', $_POST['txtPaciente']);
//                $this->db->set('motorista', $_POST['txtMotorista']);
//                $this->db->set('vigilante_id', $_POST['txtVigilanteID']);
//                $this->db->insert('tb_ambulancia');
//                $erro = $this->db->_error_message();
//                if (trim($erro) != "") // erro de banco
//                { return false; }
//                else
//                { return true; }
//
//            } catch (Exception $exc) {
//                return false;
//            }
//
//        }

function gravar(){
      try {
          $i=-1;
                $txtPlaca = $_POST['txtPlaca'];
                $txtData = $_POST['txtData'];
                $txtHora = $_POST['txtHora'];
                $txtCidadeID = $_POST['txtCidadeID'];
                $txtEstadoID = $_POST['txtEstadoID'];
                $txtMotorista = $_POST['txtMotorista'];
                $txtVigilanteID = $_POST['txtVigilanteID'];
          foreach ($_POST['txtPaciente'] as $txtPaciente){

            $i++;

                $sql = "INSERT INTO ijf.tb_ambulancia
                       (placa,data,hora,cidade_id,estado_id,paciente,motorista,vigilante_id) VALUES
                       ('$txtPlaca','$txtData','$txtHora','$txtCidadeID','$txtEstadoID','$txtPaciente','$txtMotorista','$txtVigilanteID')";
                $this->db->query($sql);

          }
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }


            } catch (Exception $exc)
            { return false; }
     }

        function excluir($ambulancia_id) {
            $this->db->where('ambulancia_id',$ambulancia_id);
            $this->db->delete('tb_ambulancia');

            if($this->db->affected_rows()>0) return true;
            else return false;
        }

    function instanciar($ficha_id){
             if ($ficha_id != 0) {
            $this->db->select('ficha_id,
                               numero,
                               data,
                               paciente_id,
                               hora,
                               diagnostico_definitivo');
            $this->db->from('tb_ceatox_ficha');
            $this->db->where("ficha_id", $ficha_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_ficha_id = $return[0]->ficha_id;
            $this->_numero = $return[0]->numero;
            $this->_data = $return[0]->data;
            $this->_paciente_id = $return[0]->paciente_id;
            $this->_hora = $return[0]->hora;
            $this->_diagnostico_definitivo = $return[0]->diagnostico_definitivo;
            } else  {
            $this->_ficha_id_id = null;
            }
  }

 }
?>