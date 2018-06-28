<?php

class fornecedor_model extends Model {

    var $_financeiro_credor_devedor_id = null;
    var $_razao_social = null;
    var $_cnpj = null;
    var $_celular = null;
    var $_telefone = null;
    var $_tipo_logradouro_id = null;
    var $_logradouro = null;
    var $_numero = null;
    var $_cadastros_fornecedor_id = null;
    var $_bairro = null;
    var $_complemento = null;
    var $_municipio_id = null;
    var $_cep = null;
    var $_cpf = null;

    function Fornecedor_model($financeiro_credor_devedor_id = null) {
        parent::Model();
        if (isset($financeiro_credor_devedor_id)) {
            $this->instanciar($financeiro_credor_devedor_id);
        }
    }

    function listar($args = array()) {
        $this->db->select(' financeiro_credor_devedor_id,
                            razao_social,
                            ativo,
                            cnpj,
                            cpf,
                            telefone');
        $this->db->from('tb_financeiro_credor_devedor');
        if(@$args['ativo'] == 'f'){
            $this->db->where('ativo', 'false');
        }
        else{
            $this->db->where('ativo', 'true');
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where("(razao_social ilike '%{$args['nome']}%' OR cnpj ilike '%{$args['nome']}%' OR cpf ilike '%{$args['nome']}%')");
        }
        return $this->db;
    }

    function listartipo() {
        $this->db->select('tipo_logradouro_id,
                            descricao');
        $this->db->from('tb_tipo_logradouro');
        $return = $this->db->get();
        return $return->result();
    }

    function reativar($financeiro_credor_devedor_id) {
        $this->db->select('financeiro_credor_devedor_id');
        $this->db->from('tb_financeiro_credor_devedor');
        $this->db->where('ativo', 't');
        $this->db->where("(cpf = (
                                 SELECT cpf FROM ponto.tb_financeiro_credor_devedor 
                                 WHERE financeiro_credor_devedor_id = $financeiro_credor_devedor_id LIMIT 1 ) 
                        OR cnpj = (
                                 SELECT cnpj FROM ponto.tb_financeiro_credor_devedor 
                                 WHERE financeiro_credor_devedor_id = $financeiro_credor_devedor_id LIMIT 1 )
                        )");
        $return = $this->db->get()->result();
        
        if( count($return) == 0 ){
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
            $this->db->update('tb_financeiro_credor_devedor');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        }
        else {
            return -1;
        }
    }

    function verificadependenciasexclusao($financeiro_credor_devedor_id) {
        
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('credor_devedor_id', $financeiro_credor_devedor_id);
        $this->db->where('ativo', 't');
        $operadores = $this->db->get()->result();
        
        $this->db->select('convenio_id');
        $this->db->from('tb_convenio');
        $this->db->where('credor_devedor_id', $financeiro_credor_devedor_id);
        $this->db->where('ativo', 't');
        $convenios = $this->db->get()->result();
        
        $this->db->select('estoque_fornecedor_id');
        $this->db->from('tb_estoque_fornecedor');
        $this->db->where('credor_devedor_id', $financeiro_credor_devedor_id);
        $this->db->where('ativo', 't');
        $fornecedores = $this->db->get()->result();
        
        $result = array(
            "fornecedores" => count($fornecedores),
            "operadores" => count($operadores),
            "convenios" => count($convenios)
        );
        
        return $result;
    }

    function excluir($financeiro_credor_devedor_id) {
        
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
        $this->db->update('tb_financeiro_credor_devedor');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            $cpf = str_replace("-", "", str_replace(".", "", $_POST['txtCPF']));
            $cnpj =  str_replace("-", "", str_replace("/", "", str_replace(".", "", $_POST['txtCNPJ'])));
            
//            var_dump($cnpj, $cpf);
            
            $this->db->select('financeiro_credor_devedor_id');
            $this->db->from('tb_financeiro_credor_devedor fcd');
            if($cpf != ''){
                $this->db->where("fcd.cpf", $cpf);
            }
            if($cnpj != ''){
                $this->db->where("fcd.cnpj", $cnpj);
            }
            $this->db->where("fcd.ativo", 't');
            $return = $this->db->get()->result();
            
        
            /* inicia o mapeamento no banco */
            $financeiro_credor_devedor_id = $_POST['txtcadastrosfornecedorid'];
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('cep', $_POST['txttipo_id']);
            $this->db->set('cpf', $cpf);
            if ($cnpj != '') {
                $this->db->set('cnpj', $cnpj);
            }
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            if ($_POST['txttipo_id'] != '') {
                $this->db->set('tipo_logradouro_id', $_POST['txttipo_id']);
            }
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            
            if ($_POST['txtcadastrosfornecedorid'] == "") {// insert
//                echo "<pre>";
//                var_dump($return); die;
                if(count($return) > 0){
                    return -1;
                }
                
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_financeiro_credor_devedor');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $financeiro_credor_devedor_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('financeiro_credor_devedor_id', $financeiro_credor_devedor_id);
                $this->db->update('tb_financeiro_credor_devedor');
            }
            return $financeiro_credor_devedor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($financeiro_credor_devedor_id) {

        if ($financeiro_credor_devedor_id != 0) {
            $this->db->select('financeiro_credor_devedor_id, 
                               razao_social,
                               cnpj,
                               cpf,
                               celular,
                               telefone,
                               f.tipo_logradouro_id,
                               logradouro,
                               numero,
                               bairro,
                               complemento,
                               f.municipio_id,
                               c.nome,
                               c.estado,
                               cep');
            $this->db->from('tb_financeiro_credor_devedor f');
            $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
            $this->db->where("financeiro_credor_devedor_id", $financeiro_credor_devedor_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_financeiro_credor_devedor_id = $financeiro_credor_devedor_id;
            $this->_cnpj = $return[0]->cnpj;
            $this->_cpf = $return[0]->cpf;
            $this->_razao_social = $return[0]->razao_social;
            $this->_celular = $return[0]->celular;
            $this->_telefone = $return[0]->telefone;
            $this->_tipo_logradouro_id = $return[0]->tipo_logradouro_id;
            $this->_logradouro = $return[0]->logradouro;
            $this->_numero = $return[0]->numero;
            $this->_bairro = $return[0]->bairro;
            $this->_complemento = $return[0]->complemento;
            $this->_municipio_id = $return[0]->municipio_id;
            $this->_nome = $return[0]->nome;
            $this->_estado = $return[0]->estado;
            $this->_cep = $return[0]->cep;
        } else {
            $this->_financeiro_credor_devedor_id = null;
        }
    }

}

?>
