<?php
require_once APPPATH . 'models/base/BaseModel.php';
    class solicitante_model extends BaseModel {

        /* Propriedades da classe */
        var $_ceatox_solicitante_id = null;
        var $_nome = null;
        var $_endereco = null;
        var $_municipio_id = null;
        var $_telefone = null;
        var $_ramal = null;
        var $_complemento = null;
        var $_bairro = null;


        /* Método construtor */
         function solicitante_model($ceatox_solicitante_id=null) {
            parent::Model();
            
            if (isset ($ceatox_solicitante_id))
            { $this->instanciar($ceatox_solicitante_id); }
         }

        private function instanciar ($ceatox_solicitante_id) {
            if ($ceatox_solicitante_id != 0) {
                $this->db->select('cs.*,c.nome as municipio,c.estado as estado');
                $this->db->from('tb_ceatox_solicitante cs');
                $this->db->join('tb_municipio c', 'c.municipio_id = cs.municipio_id','left');
                $this->db->where("ceatox_solicitante_id", $ceatox_solicitante_id);
                $query = $this->db->get();
                $return = $query->result();

                $this->_ceatox_solicitante_id = $ceatox_solicitante_id;
                $this->_endereco = $return[0]->endereco;
                $this->_nome = $return[0]->nome;
                $this->_complemento = $return[0]->complemento;
                $this->_bairro = $return[0]->bairro;
                $this->_cidade = $return[0]->municipio_id;
                $this->_telefone = $return[0]->telefone;
                $this->_ramal = $return[0]->ramal;
                $this->_instituicao = $return[0]->instituicao;
                $this->_cidade_nome = $return[0]->municipio.' - '.$return[0]->estado;
 
            }
        }


     function totalRegistros($parametro) {

            $this->db->select('ceatox_solicitante_id');
            $this->db->from('tb_ceatox_solicitante');
            if ($parametro != null && $parametro != -1)
            {
                $this->db->where('nome ilike', $parametro . "%");
            }
            $return = $this->db->count_all_results();
            return $return;
      }

        function listar($args = array()) {
            $this->db->select();
            $this->db->from('tb_ceatox_solicitante');
        

        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->like('nome', $args['nome'], 'left');
            }

        }

        return $this->db;
    }

    function gravar() {
            try {
                /* inicia o mapeamento no banco */
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->set('endereco', $_POST['txtEndereco']);
                $this->db->set('complemento', $_POST['txtComplemento']);
                $this->db->set('bairro', $_POST['txtBairro']);
                $this->db->set('municipio_id', $_POST['municipio_id']);
                $this->db->set('instituicao', $_POST['txtInstituicao']);
                $this->db->set('telefone', str_replace("(","",str_replace(")", "",str_replace("-", "", $_POST['txtTelefone']))));
                $this->db->set('ramal', $_POST['txtRamal']);
                if ( $_POST['ceatox_solicitante_id'] == "" ) {// insert

                $this->db->insert('tb_ceatox_solicitante');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                {
                      return false;
                }
                else
                      $ceatox_solicitante_id = $this->db->insert_id();
                }
                else { // update
                      $ceatox_solicitante_id = $_POST['ceatox_solicitante_id'];
                      $this->db->where('ceatox_solicitante_id', $ceatox_solicitante_id);
                      $this->db->update('tb_ceatox_solicitante');
                }


                return $ceatox_solicitante_id;
            } catch (Exception $exc) {
                return false;
            }
    }

    function listarSolicitante($parametro=null) {
        $this->db->select('tb_ceatox_solicitante.nome as nome,tb_municipio.estado as estado,
            tb_ceatox_solicitante.ceatox_solicitante_id as ceatox_solicitante_id,
            tb_ceatox_solicitante.ramal as ramal, tb_municipio.nome as municipio,
             tb_ceatox_solicitante.telefone as telefone
                ,tb_ceatox_solicitante.instituicao as instituicao,
                tb_ceatox_solicitante.bairro as bairro, tb_ceatox_solicitante.endereco as endereco');
        if ($parametro != null) {
            $this->db->where('tb_ceatox_solicitante.nome ilike',"%" . $parametro . "%");
        }
        $this->db->from('tb_ceatox_solicitante');
        $this->db->join('tb_municipio', 'tb_ceatox_solicitante.municipio_id = tb_municipio.municipio_id','left');

        $return = $this->db->get();

        return $return->result();
    }

    function listarPaciente($parametro=null) {
        $this->db->select('tb_paciente.nome as nome, tb_paciente.paciente_id as paciente_id,tb_municipio.nome as municipio,tb_municipio.estado as estado,
            tb_paciente.telefone as telefone,tb_paciente.logradouro as endereco, tb_paciente.bairro as bairro, tb_paciente.cep as cep,tb_paciente.sexo as sexo,tb_paciente.nome_mae as nome_mae,tb_paciente.idade as idade,tb_paciente.nascimento as nascimento,tb_municipio.municipio_id as municipio_id');
        if ($parametro != null) {
            $this->db->where('tb_paciente.nome ilike',"%" . $parametro . "%");
        }
        $this->db->from('tb_paciente');
        $this->db->join('tb_municipio', 'tb_paciente.municipio_id = tb_municipio.municipio_id','left');

        $return = $this->db->get();

        return $return->result();
    }
    
    }
 
?>