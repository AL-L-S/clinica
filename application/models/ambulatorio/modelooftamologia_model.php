<?php

class modelooftamologia_model extends Model {

    var $_ambulatorio_modelo_laudo_id = null;
    var $_nome = null;
    var $_medico_id = null;
    var $_texto = null;
    var $_procedimento_tuss_id = null;

    function Modelooftamologia_model($ambulatorio_modelo_laudo_id = null) {
        parent::Model();
        if (isset($ambulatorio_modelo_laudo_id)) {
            $this->instanciar($ambulatorio_modelo_laudo_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('ood.od_eixo_id,ood.numero, ood.nome ');
        $this->db->from('tb_oftamologia_od_eixo ood');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ood.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ood.nome ilike', "%" . $args['nome'] . "%");
        }
        $return = $this->db;
        return $return;
    }

    function listaradcl($args = array()) {
        $this->db->select('oad.ad_cilindrico_id,oad.numero, oad.nome ');
        $this->db->from('tb_oftamologia_ad_cilindrico oad');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('oad.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('oad.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('oad.ativo ', 't');
        $this->db->orderby('oad.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluiradcl($ambulatorio_madelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ad_cilindrico_id', $ambulatorio_madelo_laudo_id);
        $this->db->update('tb_oftamologia_ad_cilindrico');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravaradcl() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_ad_cilindrico');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listaracuidadeod($args = array()) {
        $this->db->select('oad.od_acuidade_id,oad.numero, oad.nome ');
        $this->db->from('tb_oftamologia_od_acuidade oad');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('oad.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('oad.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('oad.ativo ', 't');
        $this->db->orderby('oad.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluiracuidadeod($ambulatorio_madelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('od_acuidade_id', $ambulatorio_madelo_laudo_id);
        $this->db->update('tb_oftamologia_od_acuidade');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravaracuidadeod() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_od_acuidade');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listaracuidadeoe($args = array()) {
        $this->db->select('oad.oe_acuidade_id,oad.numero, oad.nome ');
        $this->db->from('tb_oftamologia_oe_acuidade oad');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('oad.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('oad.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('oad.ativo ', 't');
        $this->db->orderby('oad.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluiracuidadeoe($ambulatorio_madelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('oe_acuidade_id', $ambulatorio_madelo_laudo_id);
        $this->db->update('tb_oftamologia_oe_acuidade');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravaracuidadeoe() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_oe_acuidade');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarades($args = array()) {
        $this->db->select('oad.ad_esferico_id,oad.numero, oad.nome ');
        $this->db->from('tb_oftamologia_ad_esferico oad');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('oad.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('oad.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('oad.ativo ', 't');
        $this->db->orderby('oad.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluirades($ambulatorio_madelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ad_esferico_id', $ambulatorio_madelo_laudo_id);
        $this->db->update('tb_oftamologia_ad_esferico');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarades() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_ad_esferico');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarodcl($args = array()) {
        $this->db->select('ood.od_cilindrico_id,ood.numero, ood.nome ');
        $this->db->from('tb_oftamologia_od_cilindrico ood');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ood.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ood.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ood.ativo ', 't');
        $this->db->orderby('ood.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluirodcl($ambulatorio_modelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('od_cilindrico_id', $ambulatorio_modelo_laudo_id);
        $this->db->update('tb_oftamologia_od_cilindrico');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarodcl() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_od_cilindrico');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarodes($args = array()) {
        $this->db->select('ood.od_esferico_id,ood.numero, ood.nome ');
        $this->db->from('tb_oftamologia_od_esferico ood');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ood.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ood.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ood.ativo ', 't');
        $this->db->orderby('ood.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluirodes($ambulatorio_modelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('od_esferico_id', $ambulatorio_modelo_laudo_id);
        $this->db->update('tb_oftamologia_od_esferico');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarodes() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_od_esferico');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarodeixo($args = array()) {
        $this->db->select('ood.od_eixo_id,ood.numero, ood.nome ');
        $this->db->from('tb_oftamologia_od_eixo ood');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ood.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ood.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ood.ativo ', 't');
        $this->db->orderby('ood.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluirodeixo($ambulatorio_modelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('od_eixo_id', $ambulatorio_modelo_laudo_id);
        $this->db->update('tb_oftamologia_od_eixo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarodeixo() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_od_eixo');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarodav($args = array()) {
        $this->db->select('ood.od_av_id,ood.numero, ood.nome ');
        $this->db->from('tb_oftamologia_od_av ood');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ood.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ood.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ood.ativo ', 't');
        $this->db->orderby('ood.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluirodav($ambulatorio_modelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('od_av_id', $ambulatorio_modelo_laudo_id);
        $this->db->update('tb_oftamologia_od_av');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarodav() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_od_av');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listaroecl($args = array()) {
        $this->db->select('ooe.oe_cilindrico_id,ooe.numero, ooe.nome ');
        $this->db->from('tb_oftamologia_oe_cilindrico ooe');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ooe.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ooe.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ooe.ativo ', 't');
        $this->db->orderby('ooe.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluiroecl($ambulatorio_moeelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('oe_cilindrico_id', $ambulatorio_moeelo_laudo_id);
        $this->db->update('tb_oftamologia_oe_cilindrico');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravaroecl() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_oe_cilindrico');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listaroees($args = array()) {
        $this->db->select('ooe.oe_esferico_id,ooe.numero, ooe.nome ');
        $this->db->from('tb_oftamologia_oe_esferico ooe');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ooe.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ooe.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ooe.ativo ', 't');
        $this->db->orderby('ooe.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluiroees($ambulatorio_moeelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('oe_esferico_id', $ambulatorio_moeelo_laudo_id);
        $this->db->update('tb_oftamologia_oe_esferico');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravaroees() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_oe_esferico');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listaroeeixo($args = array()) {
        $this->db->select('ooe.oe_eixo_id,ooe.numero, ooe.nome ');
        $this->db->from('tb_oftamologia_oe_eixo ooe');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ooe.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ooe.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ooe.ativo ', 't');
        $this->db->orderby('ooe.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluiroeeixo($ambulatorio_moeelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('oe_eixo_id', $ambulatorio_moeelo_laudo_id);
        $this->db->update('tb_oftamologia_oe_eixo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravaroeeixo() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_oe_eixo');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listaroeav($args = array()) {
        $this->db->select('ooe.oe_av_id,ooe.numero, ooe.nome ');
        $this->db->from('tb_oftamologia_oe_av ooe');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ooe.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ooe.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ooe.ativo ', 't');
        $this->db->orderby('ooe.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function excluiroeav($ambulatorio_moeelo_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('oe_av_id', $ambulatorio_moeelo_laudo_id);
        $this->db->update('tb_oftamologia_oe_av');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravaroeav() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_oftamologia_oe_av');

            return $this->db->insert_id();
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_modelo_laudo_id) {
        if ($ambulatorio_modelo_laudo_id != 0) {
            $this->db->select('ambulatorio_modelo_laudo_id,
                            aml.nome,
                            medico_id,
                            o.nome as medico,
                            aml.texto,
                            aml.procedimento_tuss_id,
                            pt.nome as procedimento');
            $this->db->from('tb_ambulatorio_modelo_laudo aml');
            $this->db->join('tb_operador o', 'o.operador_id = aml.medico_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = aml.procedimento_tuss_id', 'left');
            $this->db->where("ambulatorio_modelo_laudo_id", $ambulatorio_modelo_laudo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_modelo_laudo_id = $ambulatorio_modelo_laudo_id;
            $this->_nome = $return[0]->nome;
            $this->_medico_id = $return[0]->medico_id;
            $this->_texto = $return[0]->texto;
            $this->_procedimento_tuss_id = $return[0]->procedimento_tuss_id;
        } else {
            $this->_ambulatorio_modelo_laudo_id = null;
        }
    }

}

?>
