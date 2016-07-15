<?php
require_once APPPATH . 'models/base/BaseModel.php';
    class Operador_model extends BaseModel {

        var $_operador_id = null;
        var $_usuario = null;
        var $_senha = null;
        var $_perfil_id = null;
        var $_ativo = null;


        function Operador_model($operador_id=null) {
            parent::Model();
            if (isset ($operador_id))
            { $this->instanciar($operador_id); }
        }

       function totalRegistros($parametro) {
            $this->db->select('operador_id');
            $this->db->from('tb_operador');
            if ($parametro != null && $parametro != -1)
            {
                echo "ok";
                $this->db->where('usuario ilike', $parametro . "%");
            }
            $return = $this->db->count_all_results();
            return $return;
        }

//        function listar($parametro=null, $maximo=0, $inicio=0) {
//            $this->db->select('o.nome,
//                               o.ativo,
//                               o.operador_id,
//                               o.usuario,
//                               o.perfil_id,
//                               p.nome AS nomeperfil
//                               ');
//            $this->db->from('tb_operador o');
//            $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
//            if ($parametro != null && $parametro!= -1)
//            {
//                $this->db->where('o.usuario ilike', $parametro . "%");
//            }
//            $rs = $this->db->orderby('o.nome');
//            if ($maximo != 0)
//            { $rs = $this->db->limit($maximo, $inicio); }
//            $return = $this->db->get();
//            return $return->result();
//        }

   function listar($args = array()) {
        $this->db->from('tb_operador')
                 ->join('tb_perfil', 'tb_perfil.perfil_id = tb_operador.perfil_id', 'left')
                 ->select('"tb_operador".*, tb_perfil.nome as nomeperfil');

        if ($args) {
            if (isset ($args['nome']) && strlen($args['nome']) > 0) {
               // $this->db->like('tb_operador.nome', $args['nome'], 'left');
                $this->db->where('tb_operador.nome ilike', $args['nome'] . "%");
            }
        }
        return $this->db;
    }

        function listarCada($operador_id) {
            $this->db->select('o.operador_id,
                               o.usuario,
                               o.perfil_id,
                               p.nome
                               ');
            $this->db->from('tb_operador o');
            $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
            $this->db->where('o.operador_id', $operador_id); 

            $return = $this->db->get();
            return $return->result();
        }

          function listarPerfil() {
            $this->db->select('perfil_id,
                               nome,
                               ');
            $this->db->from('tb_perfil');
            $this->db->where('ativo','t');
            $this->db->where('perfil_id','4');
            $this->db->orwhere('perfil_id','5');
            $this->db->orwhere('perfil_id','6');
            $this->db->orwhere('perfil_id','7');

            $return = $this->db->get();
            return $return->result();
        }

       function gravar() {
            try {

                /* inicia o mapeamento no banco */
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->set('usuario', $_POST['txtUsuario']);
                $this->db->set('senha', md5($_POST['txtSenha']));
                $this->db->set('perfil_id', $_POST['txtPerfil']);
                $this->db->set('ativo', 't');
                $this->db->insert('tb_operador');

                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }

            } catch (Exception $exc) {
                return false;
            }

        }


   function gravarNovaSenha() {
            try {

                $novasenha = md5($_POST['txtNovaSenha']);
                $operador_id = $_POST['txtOperadorID'];
                /* inicia o mapeamento no banco */
//                $this->db->set('senha', md5($_POST['txtNovaSenha']));
//                $this->db->update('tb_operador');
//                $this->db->where('operador_id', $_POST['txtOperadorID']);
                $sql=("UPDATE ijf.tb_operador SET senha = '$novasenha' WHERE operador_id= '$operador_id'");

                $this->db->query($sql);
                $erro = $this->db->_error_message();

                if (trim($erro) != "") // erro de banco
                { return false; }
                else
                { return true; }

            } catch (Exception $exc) {
                return false;
            }

        }

       function excluirOperador($operador_id) {

            $sql = "UPDATE ijf.tb_operador
                        SET ativo = 'f'
                WHERE operador_id = $operador_id ";

        $this->db->query($sql);
            return true;
        }


            function instanciar($operador_id){
             if ($operador_id != 0) {
            $this->db->select('operador_id,
                                usuario,
                                senha,
                                perfil_id,
                                ativo');
            $this->db->from('tb_operador');
            $this->db->where("operador_id", $operador_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_operador_id = $return[0]->operador_id;
            $this->_usuario = $return[0]->usuario;
            $this->_senha = $return[0]->senha;
            $this->_perfil_id = $return[0]->perfil_id;
            $this->_ativo = $return[0]->ativo;
            } else  {
            $this->_operador_id = null;
            }


  }

        }