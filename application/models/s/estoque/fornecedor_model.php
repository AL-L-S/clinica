<?php

class fornecedor_model extends Model {

    var $_estoque_fornecedor_id = null;
    var $_razao_social = null;
    var $_fantasia = null;
    var $_cnpj = null;
    var $_celular = null;
    var $_telefone = null;
    var $_tipo_logradouro_id = null;
    var $_logradouro = null;
    var $_numero = null;
    var $_bairro = null;
    var $_complemento = null;
    var $_municipio_id = null;
    var $_cep = null;

    function Fornecedor_model($estoque_fornecedor_id = null) {
        parent::Model();
        if (isset($estoque_fornecedor_id)) {
            $this->instanciar($estoque_fornecedor_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('estoque_fornecedor_id,
                            fantasia,
                            razao_social,
                            cnpj,
                            telefone');
        $this->db->from('tb_estoque_fornecedor');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->orwhere('razao_socialo ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('cnpj ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function autocompletefornecedor($parametro = null) {
        $this->db->select('estoque_fornecedor_id,
                            fantasia,
                            razao_social,
                            cnpj');
        $this->db->from('tb_estoque_fornecedor');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('fantasia ilike', "%" . $parametro . "%");
//            $this->db->where('cnpj', $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listartipo() {
        $this->db->select('tipo_logradouro_id,
                            descricao');
        $this->db->from('tb_tipo_logradouro');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($estoque_fornecedor_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('estoque_fornecedor_id', $estoque_fornecedor_id);
        $this->db->update('tb_estoque_fornecedor');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return -1;
        else
            return 0;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $estoque_fornecedor_id = $_POST['txtestoquefornecedorid'];
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('fantasia', $_POST['txtfantasia']);
            $this->db->set('cep', $_POST['txttipo_id']);
            if ($_POST['txtCNPJ'] != '') {
                $this->db->set('cnpj', str_replace("/", "", str_replace(".", "", $_POST['txtCNPJ'])));
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

            if ($_POST['txtestoquefornecedorid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_estoque_fornecedor');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $estoque_fornecedor_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('estoque_fornecedor_id', $estoque_fornecedor_id);
                $this->db->update('tb_estoque_fornecedor');
            }
            return $estoque_fornecedor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($estoque_fornecedor_id) {

        if ($estoque_fornecedor_id != 0) {
            $this->db->select('estoque_fornecedor_id, 
                               razao_social,
                               fantasia,
                               cnpj,
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
            $this->db->from('tb_estoque_fornecedor f');
            $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
            $this->db->where("estoque_fornecedor_id", $estoque_fornecedor_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_estoque_fornecedor_id = $estoque_fornecedor_id;
            $this->_cnpj = $return[0]->cnpj;
            $this->_razao_social = $return[0]->razao_social;
            $this->_fantasia = $return[0]->fantasia;
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
            $this->_estoque_fornecedor_id = null;
        }
    }

}

?>
