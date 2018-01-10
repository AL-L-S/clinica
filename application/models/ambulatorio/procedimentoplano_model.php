<?php

class procedimentoplano_model extends Model {

    var $_procedimento_convenio_id = null;
    var $_convenio_id = null;
    var $_convenio = null;
    var $_procedimento_tuss_id = null;
    var $_procedimento = null;
    var $_qtdech = null;
    var $_valorch = null;
    var $_qtdefilme = null;
    var $_valorfilme = null;
    var $_qtdeporte = null;
    var $_valorporte = null;
    var $_qtdeuco = null;
    var $_valoruco = null;
    var $_valortotal = null;

    function Procedimentoplano_model($procedimento_convenio_id = null) {
        parent::Model();
        if (isset($procedimento_convenio_id)) {
            $this->instanciar($procedimento_convenio_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('procedimento_convenio_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            pc.procedimento_tuss_id,
                            pc.procedimento_tuss_id,
                            pc.agrupador,
                            pc.valor_pacote_diferenciado,
                            pt.nome as procedimento,
                            pt.codigo,
                            pc.valortotal,
                            pt.grupo,
                            e.nome as empresa');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = pc.empresa_id', 'left');
        $this->db->where("pc.ativo", 't');
//        $empresa_id = $this->session->userdata('empresa_id');
//        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
//        if ($procedimento_multiempresa == 't') {
//            $this->db->where('pc.empresa_id', $empresa_id);
//        }
        if (@$args['nome'] != '') {
//            var_dump($args['nome']); die;
            $this->db->where('c.nome', $args['nome']);
        }
        if (isset($args['convenio']) && @$args['convenio'] != '') {
            $this->db->where('c.convenio_id', $args['convenio']);
        }
        if (isset($args['procedimento']) && strlen($args['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', $args['procedimento'] . "%");
        }
        if (isset($args['codigo']) && strlen($args['codigo']) > 0) {
            $this->db->where('pt.codigo ilike', $args['codigo'] . "%");
        }
        if (isset($args['grupo']) && strlen($args['grupo']) > 0) {
            $this->db->where('pt.grupo ilike', $args['grupo'] . "%");
        }
        return $this->db;
    }

    function listarautocompleteformapagamento($args = array()) {
        $this->db->select('forma_pagamento_id,
                           nome');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');

        if (isset($args['txtpagamento']) && strlen($args['txtpagamento']) > 0) {
            $this->db->where('nome ilike', "%" . $args['txtpagamento'] . "%");
        }

        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentopercentualmedico($args = array()) {
        $this->db->select('pm.procedimento_percentual_medico_id,
                            pm.procedimento_tuss_id,
                            pm.medico,
                            o.nome as medico,
                            pt.nome,
                            pm.valor');
        $this->db->from('tb_procedimento_percentual_medico pm');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = pm.medico', 'left');
        $this->db->where("pm.ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('o.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['procedimento']) && strlen($args['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $args['procedimento'] . "%");
        }
        return $this->db;
    }

    function listarprocedimentopercentual($args = array()) {
        $this->db->select('pm.procedimento_percentual_medico_id,
                            pm.procedimento_tuss_id,
                            pm.medico,
                            o.nome as medico,
                            pt.nome,
                            pm.valor');
        $this->db->from('tb_procedimento_percentual_medico pm');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = pm.medico', 'left');
        $this->db->where("pm.ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('o.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['procedimento']) && strlen($args['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $args['procedimento'] . "%");
        }
        return $this->db;
    }

    function listarpercentualconvenio($args = array()) {
        $this->db->select(' c.nome as convenio,
                            c.convenio_id');
        $this->db->from('tb_convenio c');
        $this->db->where("c.convenio_id IN (
                            SELECT pc.convenio_id
                            FROM ponto.tb_procedimento_percentual_medico pm
                            INNER JOIN ponto.tb_procedimento_convenio pc
                            ON pc.procedimento_convenio_id = pm.procedimento_tuss_id
                            WHERE pm.ativo = 't'
                            GROUP BY pc.convenio_id)");


        if (isset($args['convenio']) && @$args['convenio'] != '') {
            $this->db->where('c.convenio_id', $args['convenio']);
        }

        return $this->db;
    }
    
    function listarpercentualconveniolaboratorio($args = array()) {
        $this->db->select(' c.nome as convenio,
                            c.convenio_id');
        $this->db->from('tb_convenio c');
        $this->db->where("c.convenio_id IN (
                            SELECT pc.convenio_id
                            FROM ponto.tb_procedimento_percentual_laboratorio pm
                            INNER JOIN ponto.tb_procedimento_convenio pc
                            ON pc.procedimento_convenio_id = pm.procedimento_tuss_id
                            WHERE pm.ativo = 't'
                            GROUP BY pc.convenio_id)");


        if (isset($args['convenio']) && @$args['convenio'] != '') {
            $this->db->where('c.convenio_id', $args['convenio']);
        }

        return $this->db;
    }

    function listarprocedimentoconveniopercentual($convenio_id) {

        $this->db->select('pm.procedimento_percentual_medico_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            pt.grupo as grupo');
        $this->db->from('tb_procedimento_percentual_medico pm');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pm.ativo", 't');
        $this->db->where("c.convenio_id", $convenio_id);

        if (isset($_GET['procedimento']) && strlen($_GET['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $_GET['procedimento'] . "%");
        }
        if (isset($_GET['grupo']) && strlen($_GET['grupo']) > 0) {
            $this->db->where('pt.grupo ilike', "%" . $_GET['grupo'] . "%");
        }

//        $limit = 10;
//        isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
//        $this->db->limit($limit, $pagina);

        return $this->db;
    }

    function listarprocedimentogrupo($args = array()) {
//                $this->db->select('pm.procedimento_percentual_medico_id,
//                            pm.procedimento_tuss_id,
//                            pt.grupo as grupo,
//                            pt.nome as procedimento,
//                            c.nome as convenio');
//        $this->db->from('tb_procedimento_percentual_medico pm ');
//        $this->db->join('tb_procedimento_tuss pt', 'pm.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
//        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = pm.procedimento_tuss_id' , 'left');  
//        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id' , 'left');
//        $this->db->where("pm.ativo", 't');          
        $this->db->select('pm.procedimento_percentual_medico_id,
                            
                            pt.nome as procedimento,
                            c.nome as convenio,
                            pt.grupo as grupo,
                            ');
        $this->db->from('tb_procedimento_percentual_medico pm');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pm.ativo", 't');


        if (isset($args['convenio']) && strlen($args['convenio']) > 0) {
            $this->db->where('c.nome ilike', "%" . $args['convenio'] . "%");
        }
        if (isset($args['procedimento']) && strlen($args['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $args['procedimento'] . "%");
        }
        if (isset($args['grupo']) && strlen($args['grupo']) > 0) {
            $this->db->where('pt.grupo ilike', "%" . $args['grupo'] . "%");
        }
        return $this->db;
    }

    function listarprocedimentogrupopromotor($args = array()) {
//                $this->db->select('pm.procedimento_percentual_medico_id,
//                            pm.procedimento_tuss_id,
//                            pt.grupo as grupo,
//                            pt.nome as procedimento,
//                            c.nome as convenio');
//        $this->db->from('tb_procedimento_percentual_medico pm ');
//        $this->db->join('tb_procedimento_tuss pt', 'pm.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
//        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = pm.procedimento_tuss_id' , 'left');  
//        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id' , 'left');
//        $this->db->where("pm.ativo", 't');          
        $this->db->select('pm.procedimento_percentual_promotor_id,
                            
                            pt.nome as procedimento,
                            c.nome as convenio,
                            pt.grupo as grupo,
                            ');
        $this->db->from('tb_procedimento_percentual_promotor pm');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pm.ativo", 't');


        if (isset($args['convenio']) && @$args['convenio'] != '') {
            $this->db->where('c.convenio_id', $args['convenio']);
        }
        if (isset($args['procedimento']) && strlen($args['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $args['procedimento'] . "%");
        }
        if (isset($args['grupo']) && strlen($args['grupo']) > 0) {
            $this->db->where('pt.grupo ilike', "%" . $args['grupo'] . "%");
        }
        return $this->db;
    }

    function listarpromotorpercentual($procedimento_percentual_promotor_id) {
        $this->db->select(' ppmc.procedimento_percentual_promotor_convenio_id,
                            pi.nome as promotor,                            
                            ppmc.valor,
                            ppmc.percentual,
                            pt.nome as procedimento,
                            c.nome as convenio');
        $this->db->from('tb_procedimento_percentual_promotor_convenio ppmc');
        $this->db->join('tb_procedimento_percentual_promotor pm', 'pm.procedimento_percentual_promotor_id = ppmc.procedimento_percentual_promotor_id ', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ppmc.promotor', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'ppmc.promotor = pi.paciente_indicacao_id');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ppmc.ativo", 't');
        $this->db->where('ppmc.procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
        if (isset($_POST['convenio']) && strlen($_POST['convenio']) > 0) {
            $this->db->where('c.nome ilike', "%" . $_POST['convenio'] . "%");
        }
        if (isset($_POST['procedimento']) && strlen($_POST['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $_POST['procedimento'] . "%");
        }
        if (isset($_POST['promotor']) && strlen($_POST['promotor']) > 0) {
            $this->db->where('pi.nome ilike', "%" . $_POST['promotor'] . "%");
        }

//        if (isset($_POST['valor']) && strlen($_POST['valor']) > 0) {
//            $this->db->where('ppmc.valor ilike', "%" . $_POST['valor'] . "%");
//        } 
        if (isset($_POST['valor']) && strlen($_POST['valor']) > 0) {
            $this->db->where('ppmc.valor', $_POST['valor']);
        }
        return $this->db;
    }

    function listarmedicopercentual($procedimento_percentual_medico_id) {
        $this->db->select(' ppmc.procedimento_percentual_medico_convenio_id,
                            o.nome as medico,                            
                            ppmc.valor,
                            ppmc.percentual,
                            pt.nome as procedimento,
                            pt.grupo,
                            ppmc.revisor,
                            c.nome as convenio');
        $this->db->from('tb_procedimento_percentual_medico_convenio ppmc');
        $this->db->join('tb_procedimento_percentual_medico pm', 'pm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id ', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ppmc.medico', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ppmc.ativo", 't');
        $this->db->where('ppmc.procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
        if (isset($_POST['convenio']) && strlen($_POST['convenio']) > 0) {
            $this->db->where('c.nome ilike', "%" . $_POST['convenio'] . "%");
        }
        if (isset($_POST['procedimento']) && strlen($_POST['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $_POST['procedimento'] . "%");
        }
        if (isset($_POST['medico']) && strlen($_POST['medico']) > 0) {
            $this->db->where('o.nome ilike', "%" . $_POST['medico'] . "%");
        }

//        if (isset($_POST['valor']) && strlen($_POST['valor']) > 0) {
//            $this->db->where('ppmc.valor ilike', "%" . $_POST['valor'] . "%");
//        } 
        if (isset($_POST['valor']) && strlen($_POST['valor']) > 0) {
            $this->db->where('ppmc.valor', $_POST['valor']);
        }
        return $this->db;
    }

    function listarmedicopercentualgruporm($procedimento_percentual_medico_id) {
        $this->db->select(' ppmc.procedimento_percentual_medico_convenio_id,
                            o.nome as medico,                            
                            ppmc.valor,
                            ppmc.percentual,
                            pt.nome as procedimento,
                            pt.grupo,
                            c.nome as convenio');
        $this->db->from('tb_procedimento_percentual_medico_convenio ppmc');
        $this->db->join('tb_procedimento_percentual_medico pm', 'pm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id ', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ppmc.medico', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ppmc.ativo", 't');
        $this->db->where("pt.grupo", 'RM');
        $this->db->where('ppmc.procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
        if (isset($_POST['convenio']) && strlen($_POST['convenio']) > 0) {
            $this->db->where('c.nome ilike', "%" . $_POST['convenio'] . "%");
        }
        if (isset($_POST['procedimento']) && strlen($_POST['procedimento']) > 0) {
            $this->db->where('pt.nome ilike', "%" . $_POST['procedimento'] . "%");
        }
        if (isset($_POST['medico']) && strlen($_POST['medico']) > 0) {
            $this->db->where('o.nome ilike', "%" . $_POST['medico'] . "%");
        }

//        if (isset($_POST['valor']) && strlen($_POST['valor']) > 0) {
//            $this->db->where('ppmc.valor ilike', "%" . $_POST['valor'] . "%");
//        } 
        if (isset($_POST['valor']) && strlen($_POST['valor']) > 0) {
            $this->db->where('ppmc.valor', $_POST['valor']);
        }
        return $this->db;
    }

    function listaragrupador() {
        $this->db->select('agrupador_id,
                           nome                            
                            ');
        $this->db->from('tb_agrupador_procedimento_nome');
        $this->db->where("ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('c.nome ilike', "%" . $args['nome'] . "%");
        }

        return $this->db;
    }

    function buscarprocedimentoconvenioprincipal($convenio_id) {
        $this->db->select('nome, 
                           procedimento_tuss_id, 
                           codigo');
        $this->db->from('tb_procedimento_tuss');
        $this->db->where("ativo", 't');
        $this->db->where("procedimento_tuss_id IN (
            SELECT procedimento_tuss_id FROM ponto.tb_procedimento_convenio
            WHERE convenio_id = {$convenio_id} AND ativo = 't'
                 )");

        $query = $this->db->get();
        return $query->result();
    }

    function buscarprocedimentoconveniosecundario($convenio_id) {
        $this->db->select('convenio_primario_id, grupo');
        $this->db->from('tb_convenio_secudario_associacao');
        $this->db->where('convenio_secundario_id', $convenio_id);
        $this->db->where("ativo", 't');
        $query = $this->db->get();
        $query = $query->result();

        $sql = "SELECT procedimento_tuss_id,
                        nome,
                        grupo,
                        codigo
                FROM ponto.tb_procedimento_tuss
                WHERE ativo = 't' AND
                WHERE grupo != 'AGRUPADOR' AND ";
        $i = 0;
        foreach ($query as $item) {
            $sql .= " (procedimento_tuss_id IN (SELECT procedimento_tuss_id FROM ponto.tb_procedimento_convenio WHERE ativo = 't' AND convenio_id = {$item->convenio_primario_id} ) AND grupo = '{$item->grupo}')";

            if (count($query) - 1 != $i)
                $sql .= " OR ";

            $i++;
        }

        $return = $this->db->query($sql);
        return $return->result();
    }

    function buscarconveniosecundario($convenio_id) {
        $this->db->select('associado');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->where('convenio_id', $convenio_id);

        $query = $this->db->get();
        return $query->result();
    }

    function instanciaragrupador($agrupador_id = null) {
        $this->db->select('agrupador_id,
                           nome,
                           convenio_id');
        $this->db->from('tb_agrupador_procedimento_nome');
        $this->db->where("ativo", 't');
        $this->db->where('agrupador_id', $agrupador_id);

        $query = $this->db->get();
        return $query->result();
    }

    function buscaragrupador($agrupador_id) {
        $this->db->select('agrupador_id,
                           nome,
                           convenio_id');
        $this->db->from('tb_agrupador_procedimento_nome');
        $this->db->where("ativo", 't');
        $this->db->where('agrupador_id', $agrupador_id);
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('c.nome ilike', "%" . $args['nome'] . "%");
        }

        $query = $this->db->get();
        return $query->result();
    }

    function listarprocedimentosagrupador($agrupador_id) {
//        die;
        $this->db->select('pa.agrupador_id,
                           pa.procedimento_agrupado_id,
                           pt.nome,
                           c.nome as convenio,
                           pt.codigo,
                           pc.procedimento_convenio_id');
        $this->db->from('tb_procedimentos_agrupados pa');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pa.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pa.ativo", 't');
        $this->db->where('pa.agrupador_id', $agrupador_id);

        $query = $this->db->get();
        return $query->result();
    }

    function gravaragrupador() {
        
        $this->db->select('DISTINCT(convenio_secundario_id)');
        $this->db->from('tb_convenio_secudario_associacao');
        $this->db->where('convenio_primario_id', $_POST['convenio']);
        $this->db->where('ativo', 't');
        $conv_sec = $this->db->get()->result();
        
        if( count($conv_sec) > 0 ){
            
            $convPrimario = true;
        
            $this->db->select('DISTINCT(pt.grupo)');
            $this->db->from('tb_procedimentos_agrupados_ambulatorial paa');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = paa.procedimento_tuss_id', 'left');
            $this->db->where('paa.procedimento_agrupador_id', $_POST['procedimento']);
            $this->db->where('paa.ativo', 't');
            $grupos = $this->db->get()->result();
            
            $gp = array();
            foreach ($grupos as $value) { $gp[] = (string)$value->grupo; }
            $gp = implode(',', $gp);
            
            foreach ($conv_sec as $item) {
                $this->db->select('convenio_secundario_id, valor_percentual');
                $this->db->from('tb_convenio_secudario_associacao');
                $this->db->where('convenio_secundario_id', $item->convenio_secundario_id);
                $this->db->where("grupo IN ('{$gp}')");
                $this->db->where('ativo', 't');
                $verificador = $this->db->get()->result(); 
                
                if ( count($verificador) != count($grupos) ){
                    return -3;
                    break;
                }
            }
        }
        
        $procedimento_agrupador_id = $_POST['procedimento'];
        $convenio_id = $_POST['convenio'];
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where('pc.ativo', 't');
        $this->db->where("pc.procedimento_tuss_id", $_POST['procedimento']);
        $this->db->where("pc.convenio_id", $_POST['convenio']);
        $this->db->where("pc.empresa_id", $_POST['empresa']);
        
        if ($_POST['txtprocedimentoplanoid'] != "") {
            $this->db->where("pc.procedimento_convenio_id !=", $_POST['txtprocedimentoplanoid']);
        }
        
        $query = $this->db->get();
        $return = $query->result();
        $qtde = count($return);
        $qtde = 0;
        if ($qtde == 0) {

            $this->db->select('grupo_pagamento_id');
            $this->db->from('tb_convenio_grupopagamento cg');
            $this->db->where('cg.ativo', 't');
            $this->db->where("cg.convenio_id", $convenio_id);
            $query = $this->db->get();
            $grupoPagamento = $query->result();

            $this->db->set('procedimento_tuss_id', $procedimento_agrupador_id);
            $this->db->set('convenio_id', $convenio_id);
            $this->db->set('empresa_id', $_POST['empresa']);
            $this->db->set('qtdech', 0);
            $this->db->set('valorch', 0);
            $this->db->set('qtdefilme', 0);
            $this->db->set('valorfilme', 0);
            $this->db->set('qtdeporte', 0);
            $this->db->set('valorporte', 0);
            $this->db->set('qtdeuco', 0);
            $this->db->set('valoruco', 0);
            $this->db->set('valortotal', ((float)$_POST['valortotal']));
            $this->db->set('agrupador', 't');

            if (isset($_POST['valor_diferenciado'])) {
                $this->db->set('valor_pacote_diferenciado', 't');
            } else {
                $this->db->set('valor_pacote_diferenciado', 'f');
            }
            
            if ($_POST['txtprocedimentoplanoid'] == "") {
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_procedimento_convenio');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $procedimento_convenio_id = $this->db->insert_id();


                foreach ($grupoPagamento as $gp) {
                    $this->db->set('procedimento_convenio_id', $procedimento_convenio_id);
                    $this->db->set('grupo_pagamento_id', $gp->grupo_pagamento_id);
                    $this->db->insert('tb_procedimento_convenio_pagamento');
                }
            }
            else{
                $procedimento_convenio_id = $_POST['txtprocedimentoplanoid'];
                
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
                $this->db->update('tb_procedimento_convenio');
                
            }
            
            if($convPrimario){ // Caso seja um convenio primario, adiciona nos secundarios
                foreach ($conv_sec as $item) {
                    $valorPacote = 0;
                    
                    // Traz os dados desse convenio secundario
                    $this->db->select('convenio_secundario_id, valor_percentual, grupo');
                    $this->db->from('tb_convenio_secudario_associacao');
                    $this->db->where('convenio_secundario_id', $item->convenio_secundario_id);
                    $this->db->where("grupo IN ('{$gp}')");
                    $this->db->where('ativo', 't');
                    $cv = $this->db->get()->result();
                    
                    foreach ( $cv as $value ){
                        // Somando o valor de todos os procedimentos desse grupo                        
                        $this->db->select('SUM(pc.valortotal) as valor');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->where('pc.ativo', 't');
                        $this->db->where('pc.convenio_id', $convenio_id);
                        $this->db->where("pc.procedimento_tuss_id IN (
                            SELECT paa.procedimento_tuss_id FROM ponto.tb_procedimentos_agrupados_ambulatorial paa
                            INNER JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = paa.procedimento_tuss_id
                            WHERE paa.procedimento_agrupador_id = {$procedimento_agrupador_id} AND paa.ativo = 't'
                            AND pt.grupo = '{$value->grupo}'
                        )");
                        $valor = $this->db->get()->result();
                        
                        // Aplica o percentual cadastrado a todos os procedimentos desse grupo
                        $v = ($valor[0]->valor * $value->valor_percentual / 100);
                        
                        // Soma o valor total desse grupo, ao valor total do pacote
                        $valorPacote += $v;
                    }
                    
                    $this->db->set('procedimento_tuss_id', $procedimento_agrupador_id);
                    $this->db->set('convenio_id', $item->convenio_secundario_id);
                    $this->db->set('empresa_id', $_POST['empresa']);
                    $this->db->set('qtdech', 0);
                    $this->db->set('valorch', 0);
                    $this->db->set('qtdefilme', 0);
                    $this->db->set('valorfilme', 0);
                    $this->db->set('qtdeporte', 0);
                    $this->db->set('valorporte', 0);
                    $this->db->set('qtdeuco', 0);
                    $this->db->set('valoruco', 0);
                    $this->db->set('valortotal', $valorPacote);
                    $this->db->set('agrupador', 't');
                    if (isset($_POST['valor_diferenciado'])) {
                        $this->db->set('valor_pacote_diferenciado', 't');
                    } else {
                        $this->db->set('valor_pacote_diferenciado', 'f');
                    }

                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_convenio');
                }
            }

            return $procedimento_convenio_id;
        } 
        else {
            return -2;
        }
    }

    function verificaagrupadorconvenio($convenio_id, $procedimento_agrupador_id) {

        $this->db->select('pa.procedimento_tuss_id');
        $this->db->from('tb_procedimentos_agrupados_ambulatorial pa');
        $this->db->where("pa.procedimento_agrupador_id", $procedimento_agrupador_id);
        $this->db->where("pa.ativo", 't');
        $query = $this->db->get();
        $agrupados = $query->result();
//        
        $this->db->select('procedimento_convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where("procedimento_tuss_id IN (SELECT procedimento_tuss_id 
                                                   FROM ponto.tb_procedimentos_agrupados_ambulatorial
                                                   WHERE ativo = 't' AND procedimento_agrupador_id = $procedimento_agrupador_id)");
        $this->db->where("convenio_id", $convenio_id);
        $this->db->where("ativo", 't');
        $query = $this->db->get();
        $procedimentos = $query->result();

        if (count($agrupados) <= count($procedimentos)) {
            return count($procedimentos);
        } else {
            return -1;
        }
    }

    function gravaragrupadornome() {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('convenio_id', $_POST['convenio']);
            if ($_POST['agrupador_id'] == '' || !isset($_POST['agrupador_id'])) {
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agrupador_procedimento_nome');
                $agrupador_id = $this->db->insert_id();
            } else {
                $agrupador_id = $_POST['agrupador_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agrupador_id', $agrupador_id);
                $this->db->update('tb_agrupador_procedimento_nome');
            }
            $erro = $this->db->_error_message();
            
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agrupador_id', $agrupador_id);
            $this->db->update('tb_procedimentos_agrupados');

            if (trim($erro) != "") // erro de banco
                return 0;
            else
                return $agrupador_id;
        } catch (Exception $exc) {
            return 0;
        }
    }

    function gravaragrupadoradicionar() {
        try {
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            $this->db->select();
            $this->db->from('tb_procedimentos_agrupados');
            $this->db->where('agrupador_id', $_POST['agrupador_id']);
            $this->db->where('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->where("ativo", 't');
            $query = $this->db->get()->result();
            
            if( count($query) == 0 ){
                $this->db->set('agrupador_id', $_POST['agrupador_id']);
                $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_procedimentos_agrupados');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return false;
                else
                    return true;
            }
            else{
                return false;
            }

        } catch (Exception $exc) {
            return false;
        }
    }

    function excluiragrupadornome($agrupador_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agrupador_id', $agrupador_id);
            $this->db->update('tb_agrupador_procedimento_nome');


            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return 0;
            else
                return 1;
        } catch (Exception $exc) {
            return 0;
        }
    }

    function excluirprocedimentoagrupador($procedimento_agrupado_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('procedimento_agrupado_id', $procedimento_agrupado_id);
            $this->db->update('tb_procedimentos_agrupados');


            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return 0;
            else
                return 1;
        } catch (Exception $exc) {
            return 0;
        }
    }

    function listarprocedimentoconvenioagrupadorcirurgico($convenio_id) {
        $this->db->select('pc.procedimento_convenio_id,
                            pt.nome as procedimento,
                            pt.codigo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pc.convenio_id", $convenio_id);
        $this->db->where("pt.grupo", "CIRURGICO");
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimento() {
        $this->db->select('pc.procedimento_convenio_id,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            pt.codigo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->orderby('pt.nome');
        $this->db->where("pc.ativo", 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaragrupadoresprocedimento() {
        $this->db->select('procedimento_tuss_id,
                            nome,
                            codigo');
        $this->db->from('tb_procedimento_tuss');
        $this->db->orderby('nome');
        $this->db->where("ativo", 't');
        $this->db->where("grupo", 'AGRUPADOR');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimento2() {
        $this->db->select('procedimento_tuss_id,
                            nome,
                            codigo');
        $this->db->from('tb_procedimento_tuss');
        $this->db->orderby('nome');
        $this->db->where("ativo", 't');
        $this->db->where("grupo !=", 'AGRUPADOR');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimento3() {
        $this->db->select('procedimento_tuss_id,
                            nome,
                            grupo,
                            codigo');
        $this->db->from('tb_procedimento_tuss');
        $this->db->orderby('grupo');
        $this->db->orderby('nome');
        $this->db->where("ativo", 't');
        $this->db->where("grupo !=", 'AGRUPADOR');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconvenio() {
        $this->db->select('convenio_id,
                            nome,');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconveniointegracaofidelidade($parceiro_id) {
        $this->db->select('convenio_id,
                            nome,');
        $this->db->from('tb_convenio');
        $this->db->where("convenio_id", $parceiro_id);
        $this->db->where("ativo", 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconveniocirurgiaorcamento() {
        $this->db->select('convenio_id,
                            nome,');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupo() {
        $this->db->distinct();
        $this->db->select('ambulatorio_grupo_id, 
                            nome');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentos($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pc.procedimento_tuss_id,
                            pt.codigo,
                            pt.nome as procedimento,
                            pc.empresa_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->where("pt.grupo !=", 'CONSULTA');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $empresa_id = $this->session->userdata('empresa_id');
        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
        if ($procedimento_multiempresa == 't') {
            $this->db->where('pc.empresa_id', $empresa_id);
        }
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarconveniomedico($medico_id) {
        $this->db->select('c.convenio_id,
                            c.nome,');
        $this->db->from('tb_convenio c');

//        $procedimento_excecao = $this->session->userdata('procedimento_excecao');
//        if ($procedimento_excecao == "t") {
//            $this->db->where("c.convenio_id NOT IN (
//                                SELECT pc2.convenio_id FROM ponto.tb_convenio_operador_procedimento cop
//                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
//                                WHERE cop.operador = {$medico_id}
//                                AND cop.ativo = 't'
//                            )");
//        }
//        else {
//            $this->db->where("c.convenio_id IN (
//                                SELECT pc2.convenio_id FROM ponto.tb_convenio_operador_procedimento cop
//                                INNER JOIN ponto.tb_procedimento_convenio pc2 ON pc2.procedimento_convenio_id = cop.procedimento_convenio_id
//                                WHERE cop.operador = {$medico_id}
//                                AND cop.ativo = 't'
//                            )");
//        }

        $this->db->where("c.ativo", 't');
        $this->db->orderby('c.nome');
        $return = $this->db->get();

        return $return->result();
    }

    function buscarmedicopercentual($procedimento_percentual_medico_convenio_id) {
        $this->db->select('o.nome,
                            mc.valor,
                            mc.percentual,
                            mc.dia_recebimento,
                            mc.revisor,
                            pt.grupo,
                            mc.tempo_recebimento');
        $this->db->from('tb_procedimento_percentual_medico_convenio mc');
        $this->db->join('tb_procedimento_percentual_medico pm', 'pm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id ', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = mc.medico', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("mc.ativo", 't');
        $this->db->where("o.ativo", 't');
        $this->db->where("mc.procedimento_percentual_medico_convenio_id", $procedimento_percentual_medico_convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function buscarpromotorpercentual($procedimento_percentual_promotor_convenio_id) {
        $this->db->select('mc.valor,
                            mc.percentual,
                            pi.nome');
        $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
//        $this->db->join('tb_operador o', 'o.operador_id = mc.promotor', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'mc.promotor = pi.paciente_indicacao_id');
        $this->db->where("mc.ativo", 't');
//        $this->db->where("o.ativo", 't');
        $this->db->where("mc.procedimento_percentual_promotor_convenio_id", $procedimento_percentual_promotor_convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function novomedico($procedimento_percentual_medico_id) {
        $this->db->select('pm.procedimento_percentual_medico_id,
                            
                            pt.nome as procedimento,
                            c.nome as convenio,
                            pt.grupo as grupo,
                            ');
        $this->db->from('tb_procedimento_percentual_medico pm');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pm.ativo", 't');
        $this->db->where("pm.procedimento_percentual_medico_id ", $procedimento_percentual_medico_id);
        $return = $this->db->get();
        return $return->result();
    }

    function novopromotor($procedimento_percentual_promotor_id) {
        $this->db->select('pm.procedimento_percentual_promotor_id,
                            
                            pt.nome as procedimento,
                            c.nome as convenio,
                            pt.grupo as grupo,
                            ');
        $this->db->from('tb_procedimento_percentual_promotor pm');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pm.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("pm.ativo", 't');
        $this->db->where("pm.procedimento_percentual_promotor_id ", $procedimento_percentual_promotor_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluirformapagamentoplanoconvenio($convenio_formapagamento_id, $grupopagamento_id, $convenio_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $sql = "DELETE FROM ponto.tb_procedimento_convenio_pagamento
                WHERE grupo_pagamento_id = $grupopagamento_id
                AND procedimento_convenio_id IN (
                    SELECT procedimento_convenio_id 
                    FROM ponto.tb_procedimento_convenio pc
                    WHERE pc.ativo = 't'
                    AND pc.convenio_id = $convenio_id 
                 )";
        $this->db->query($sql);

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('ativo', 'f');
        $this->db->where('convenio_grupopagamento_id', $convenio_formapagamento_id);
        $this->db->update('tb_convenio_grupopagamento');
    }

    function excluirprocedimentoplanoconveniosessao($procedimento_convenio_sessao_id, $procedimento_convenio_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('ativo', 'f');
        $this->db->where('procedimento_convenio_sessao_id', $procedimento_convenio_sessao_id);
        $this->db->update('tb_procedimento_convenio_sessao');
    }

    function gravarformapagamentoplanoconvenio() {
        $this->db->select('grupo_pagamento_id');
        $this->db->from('tb_convenio_grupopagamento');
        $this->db->where('ativo', 't');
        $this->db->where('convenio_id', $_POST['convenio']);
        $this->db->where('grupo_pagamento_id', $_POST['grupopagamento_id']);
        $return = $this->db->get();
        $return = $return->result();

        if (count($return) == 0) {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);

            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->set('grupo_pagamento_id', $_POST['grupopagamento_id']);
            $this->db->insert('tb_convenio_grupopagamento');

            $convenio_id = $_POST['convenio'];

            $sql = "DELETE FROM ponto.tb_procedimento_convenio_pagamento
                    WHERE procedimento_convenio_id IN (
                        SELECT procedimento_convenio_id 
                        FROM ponto.tb_procedimento_convenio pc
                        WHERE pc.ativo = 't'
                        AND pc.convenio_id = $convenio_id 
                     )";

            $this->db->query($sql);

            $this->db->select('grupo_pagamento_id');
            $this->db->from('tb_convenio_grupopagamento');
            $this->db->where('ativo', 't');
            $this->db->where('convenio_id', $convenio_id);
            $return = $this->db->get();
            $retorno = $return->result();

            $this->db->select('procedimento_convenio_id');
            $this->db->from('tb_procedimento_convenio');
            $this->db->where('convenio_id', $convenio_id);
            $this->db->where('ativo', 't');
            $return = $this->db->get();
            $result = $return->result();


            foreach ($result as $value) {
                foreach ($retorno as $item) {
                    $this->db->set('procedimento_convenio_id', $value->procedimento_convenio_id);
                    $this->db->set('grupo_pagamento_id', $item->grupo_pagamento_id);
                    $this->db->insert('tb_procedimento_convenio_pagamento');
                }
            }
        }
    }

    function gravarprocedimentoconveniosessao() {
        $this->db->select('procedimento_convenio_sessao_id');
        $this->db->from('tb_procedimento_convenio_sessao');
        $this->db->where('ativo', 't');
        $this->db->where('procedimento_convenio_id', $_POST['procedimento_convenio_id']);
        $this->db->where('sessao', $_POST['numero_sessao']);
        $return = $this->db->get();
        $return = $return->result();
//        var_dump($return); die;

        if (count($return) == 0) {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('sessao', $_POST['numero_sessao']);
            $this->db->set('valor_sessao', str_replace(",", ".", str_replace(".", "", $_POST['valor_sessao'])));
            $this->db->set('procedimento_convenio_id', $_POST['procedimento_convenio_id']);
            $this->db->insert('tb_procedimento_convenio_sessao');

            return 1;
        } else {
            return 0;
        }
    }

    function listarformaspagamentoconvenio($convenio_id) {

        //verifica se esse medico já está cadastrado nesse procedimento 
        $this->db->select('convenio_grupopagamento_id, 
                            cg.grupo_pagamento_id,
                            fg.nome as grupopagamento');
        $this->db->from('tb_convenio_grupopagamento cg');
        $this->db->join('tb_financeiro_grupo fg', 'fg.financeiro_grupo_id = cg.grupo_pagamento_id', 'left');
        $this->db->where('cg.ativo', 't');
        $this->db->where('convenio_id', $convenio_id);
        $return = $this->db->get();
        $result = $return->result();
        return $result;
    }

    function listarprocedimentoconveniosessao($convenio_id) {

        //verifica se esse medico já está cadastrado nesse procedimento 
        $this->db->select('pc.procedimento_convenio_id, 
                            pcs.procedimento_convenio_sessao_id,
                            pcs.sessao,
                            pcs.valor_sessao');
        $this->db->from('tb_procedimento_convenio_sessao pcs');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pcs.procedimento_convenio_id', 'left');
        $this->db->where('pcs.ativo', 't');
        $this->db->where('pcs.procedimento_convenio_id', $convenio_id);
        $return = $this->db->get();
        $result = $return->result();
        return $result;
    }

    function gravarformapagamentoprocedimento() {

        //verifica se esse medico já está cadastrado nesse procedimento 
        $this->db->select('procedimento_convenio_pagamento_id');
        $this->db->from('tb_procedimento_convenio_pagamento');
        $this->db->where('procedimento_convenio_id', $_POST['procedimento_convenio_id']);
        $this->db->where('grupo_pagamento_id ', $_POST['grupopagamento']);
        $return = $this->db->get();
        $result = $return->result();

        if ($result != NULL) {
            return 2;
        }

        if ($result == NULL) {
            try {
                $this->db->set('procedimento_convenio_id', $_POST['procedimento_convenio_id']);
                $this->db->set('grupo_pagamento_id', $_POST['grupopagamento']);
                $this->db->insert('tb_procedimento_convenio_pagamento');

                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return 0;
                else
                    return 1;
            } catch (Exception $exc) {
                return 0;
            }
        }
    }

    function gravarnovomedico($procedimento_percentual_medico_id) {

        //verifica se esse medico já está cadastrado nesse procedimento 
        $this->db->select('medico');
        $this->db->from('tb_procedimento_percentual_medico_convenio');
        $this->db->where('medico', $_POST['medico']);
        $this->db->where('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
        if ($_POST['revisor'] == '1') {
            $this->db->where('revisor', 't');
        } else {
            $this->db->where('revisor', 'f');
        }
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        $result = $return->result();

        if ($result != NULL) {
            return 2;
        }

        if ($result == NULL) {
            try {

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                if ($_POST['dia_recebimento'] != '') {
                    $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
                }
                if ($_POST['tempo_recebimento'] != '') {
                    $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
                }
                $this->db->set('revisor', $_POST['revisor']);
                $this->db->set('medico', $_POST['medico']);
                $this->db->set('valor', $_POST['valor']);
                $this->db->set('percentual', $_POST['percentual']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('ativo', 't');
                $this->db->insert('tb_procedimento_percentual_medico_convenio');

                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return 0;
                else
                    return 1;
            } catch (Exception $exc) {
                return 0;
            }
        }
    }

    function gravarnovopromotor($procedimento_percentual_promotor_id) {

        //verifica se esse promotor já está cadastrado nesse procedimento 
        $this->db->select('promotor');
        $this->db->from('tb_procedimento_percentual_promotor_convenio');
        $this->db->where('promotor', $_POST['promotor']);
        $this->db->where('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        $result = $return->result();

        if ($result != NULL) {
            return 2;
        }

        if ($result == NULL) {
            try {

                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
                $this->db->set('promotor', $_POST['promotor']);
                $this->db->set('valor', $_POST['valor']);
                $this->db->set('percentual', $_POST['percentual']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('ativo', 't');
                $this->db->insert('tb_procedimento_percentual_promotor_convenio');

                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return 0;
                else
                    return 1;
            } catch (Exception $exc) {
                return 0;
            }
        }
    }

    function gravareditarmedicopercentual($procedimento_percentual_medico_convenio_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $sql = "INSERT INTO ponto.tb_procedimento_percentual_medico_convenio_antigo(procedimento_percentual_medico_convenio_id, 
            procedimento_percentual_medico_id, medico, valor, percentual, 
            ativo, data_cadastro, operador_cadastro, data_atualizacao, operador_atualizacao, 
            dia_recebimento, tempo_recebimento)
            SELECT procedimento_percentual_medico_convenio_id, procedimento_percentual_medico_id, 
            medico, valor, percentual, ativo, '$horario', $operador_id, 
            '$horario', $operador_id, dia_recebimento, tempo_recebimento
            FROM ponto.tb_procedimento_percentual_medico_convenio
            WHERE procedimento_percentual_medico_convenio_id = $procedimento_percentual_medico_convenio_id";
            $this->db->query($sql);

            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('valor', $_POST['valor']);
            $this->db->set('percentual', $_POST['percentual']);
            if($_POST['revisor'] != ''){
            $this->db->set('revisor', $_POST['revisor']);
            }
            if ($_POST['dia_recebimento'] != '') {
                $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
            }
            if ($_POST['tempo_recebimento'] != '') {
                $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
            }
            $this->db->where("procedimento_percentual_medico_convenio_id", $procedimento_percentual_medico_convenio_id);
            $this->db->update('tb_procedimento_percentual_medico_convenio');

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return false;
            else
                return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravareditarpromotorpercentual($procedimento_percentual_promotor_convenio_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('valor', $_POST['valor']);
            $this->db->set('percentual', $_POST['percentual']);
            $this->db->where("procedimento_percentual_promotor_convenio_id", $procedimento_percentual_promotor_convenio_id);
            $this->db->update('tb_procedimento_percentual_promotor_convenio ');

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return false;
            else
                return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listarautocompletetuss($parametro = null) {
        $this->db->select('tuss_id,
                            codigo,
                            descricao,
                            ans');
        $this->db->from('tb_tuss');
        if ($parametro != null) {
            $this->db->where('codigo ilike', "%" . $parametro . "%");
            $this->db->orwhere('descricao ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($procedimento_convenio_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        /* EXCLUINDO ESSE PROCEDIMENTO NOS CONVENIOS SECUNDARIOS */

        // Trazendo convenio e procedimento desse plano
        $this->db->select(' pc.convenio_id,
                            pc.procedimento_tuss_id, 
                            pt.grupo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', "pt.procedimento_tuss_id = pc.procedimento_tuss_id");
        $this->db->where('pc.procedimento_convenio_id', $procedimento_convenio_id);
        $return = $this->db->get();
        $plano = $return->result();

        // Buscando os convenios secundarios associados a esse Convenio
        $this->db->select('convenio_secundario_id');
        $this->db->from('tb_convenio_secudario_associacao');
        $this->db->where('convenio_primario_id', $plano[0]->convenio_id);
        $this->db->where('grupo', $plano[0]->grupo);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        $conv_sec = $return->result();

        if (count($conv_sec) > 0) { // Caso tenha convenios secundarios associados
            foreach ($conv_sec as $value) { // Excluido o proc em todos os planos secundarios
                $this->db->set('ativo', 'f');
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('convenio_id', $value->convenio_secundario_id);
                $this->db->where('procedimento_tuss_id', $plano[0]->procedimento_tuss_id);
                $this->db->update('tb_procedimento_convenio');
            }
        }

        /* FIM DA EXCLUSAO NOS SECUNDARIOS */

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
        $this->db->update('tb_procedimento_convenio');
        $erro = $this->db->_error_message();


        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirporgrupo() {

        $grupo = $_POST['grupo'];
        $convenio_id = $_POST['convenio'];
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        /* EXCLUINDO ESSES PROCEDIMENTOS NOS CONVENIOS SECUNDARIOS */

        // Lista de todos os procedimentos que serão excluidos
        $this->db->select('pc.procedimento_tuss_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', "pt.procedimento_tuss_id = pc.procedimento_tuss_id");
        $this->db->where('pc.convenio_id', $_POST['convenio']);
        $this->db->where('pt.grupo', $_POST['grupo']);
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        $procedimentos = $return->result();

        // Buscando os convenios secundarios associados a esse Convenio
        $this->db->select('convenio_secundario_id');
        $this->db->from('tb_convenio_secudario_associacao');
        $this->db->where('convenio_primario_id', $_POST['convenio']);
        $this->db->where('grupo', $_POST['grupo']);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        $conv_sec = $return->result();

        if (count($conv_sec) > 0 && count($procedimentos) > 0) { // Caso tenha convenios secundarios associados
            foreach ($conv_sec as $value) { // Excluido os procs em todos os planos secundarios
                foreach ($procedimentos as $item) {
                    $this->db->set('ativo', 'f');
                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->where('ativo', 't');
                    $this->db->where('convenio_id', $value->convenio_secundario_id);
                    $this->db->where('procedimento_tuss_id', $item->procedimento_tuss_id);
                    $this->db->update('tb_procedimento_convenio');
                }
            }
        }

        /* FIM DA EXCLUSAO NOS SECUNDARIOS */


        $sql = "UPDATE ponto.tb_procedimento_convenio pc
                SET ativo = false, operador_atualizacao = $operador_id, data_atualizacao = '$horario'

                FROM  ponto.tb_procedimento_tuss pt
                WHERE pc.procedimento_tuss_id = pt.procedimento_tuss_id
                AND pc.convenio_id = $convenio_id
                AND pt.grupo = '$grupo';";
        $this->db->query($sql);

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirpercentualconvenio($convenio_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where("procedimento_tuss_id IN (
                            SELECT procedimento_convenio_id 
                            FROM ponto.tb_procedimento_convenio
                            WHERE convenio_id = $convenio_id )");
        $this->db->update('tb_procedimento_percentual_medico');

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where("procedimento_percentual_medico_id IN (
                            SELECT procedimento_percentual_medico_id 
                            FROM ponto.tb_procedimento_percentual_medico ppm
                            INNER JOIN ponto.tb_procedimento_convenio pc
                            ON ppm.procedimento_tuss_id = pc.procedimento_convenio_id
                            WHERE ppm.ativo = 'f'
                            AND pc.convenio_id = $convenio_id )");

        $this->db->update('tb_procedimento_percentual_medico_convenio');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirpercentual($procedimento_percentual_medico_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
        $this->db->update('tb_procedimento_percentual_medico');

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
        $this->db->update('tb_procedimento_percentual_medico_convenio');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirpercentualpromotorgeral($procedimento_percentual_promotor_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
        $this->db->update('tb_procedimento_percentual_promotor');

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
        $this->db->update('tb_procedimento_percentual_promotor_convenio');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirmedicopercentual($procedimento_percentual_medico_convenio_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_percentual_medico_convenio_id', $procedimento_percentual_medico_convenio_id);
        $this->db->update('tb_procedimento_percentual_medico_convenio');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirpromotorpercentual($procedimento_percentual_promotor_convenio_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_percentual_promotor_convenio_id', $procedimento_percentual_promotor_convenio_id);
        $this->db->update('tb_procedimento_percentual_promotor_convenio');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    /**
     * Função para gravar valores na tabela TB_SERVIDOR.
     * @author Equipe de desenvolvimento APH
     * @access public
     * @return Resposta true/false da conexão com o banco
     */
    function gravarmultiplos() {
        try {
//            echo "<pre>";
//            var_dump($_POST); die;

            /* inicia o mapeamento no banco */
            $empresa_id = $_POST['empresa'];
            $convenio_id = $_POST['convenio'];
//            echo "<pre>"; var_dump($_POST); die;
            $this->db->select('grupo_pagamento_id');
            $this->db->from('tb_convenio_grupopagamento cg');
            $this->db->where('cg.ativo', 't');
            $this->db->where("cg.convenio_id", $convenio_id);
            $query = $this->db->get();
            $grupoPagamento = $query->result();

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['teste_conv_secundario'] == 't') { // Caso seja um convneio secundario
                foreach ($_POST['add_conv_sec'] as $key => $value) {

                    if ($_POST['add_conv_sec'][$key] != "") {// insert
                        $this->db->select('convenio_primario_id, valor_percentual');
                        $this->db->from('tb_convenio_secudario_associacao csa');
                        $this->db->where('csa.ativo', 't');
                        $this->db->where('csa.grupo', $_POST['grupoTxt'][$key]);
                        $this->db->where('csa.convenio_secundario_id', $convenio_id);
                        $query = $this->db->get();
                        $conv_sec = $query->result();

                        $this->db->select('pc.*');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->where('pc.ativo', 't');
                        $this->db->where("pc.procedimento_tuss_id", $_POST['procedimento_id'][$key]);
                        $this->db->where("pc.convenio_id", $conv_sec[0]->convenio_primario_id);
                        $query = $this->db->get();
                        $return = $query->result();
                        $qt = count($return);

                        if ($qt > 0) {
                            $this->db->select('procedimento_convenio_id');
                            $this->db->from('tb_procedimento_convenio pc');
                            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
                            $this->db->where('pc.ativo', 't');
                            $this->db->where('pc.empresa_id', $empresa_id);
                            $this->db->where("pc.convenio_id", $convenio_id);
                            $this->db->where("pt.procedimento_tuss_id", $_POST['procedimento_id'][$key]);
                            $query = $this->db->get();
                            $r = $query->result();
                            $q = count($r);

                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');

                            $this->db->set('procedimento_tuss_id', $_POST['procedimento_id'][$key]);
                            $this->db->set('convenio_id', $convenio_id);
                            $this->db->set('empresa_id', $empresa_id);
                            $this->db->set('qtdech', $return[0]->qtdech);
                            $this->db->set('valorch', $return[0]->valorch);
                            $this->db->set('qtdefilme', $return[0]->qtdefilme);
                            $this->db->set('valorfilme', $return[0]->valorfilme);
                            $this->db->set('qtdeporte', $return[0]->qtdeporte);
                            $this->db->set('valorporte', $return[0]->valorporte);
                            $this->db->set('qtdeuco', $return[0]->qtdeuco);
                            $this->db->set('valoruco', $return[0]->valoruco);
                            $this->db->set('valortotal', ($return[0]->valortotal * (float) $conv_sec[0]->valor_percentual / 100));

                            if ($q == 0) { // Verifica se esse procedimento ja esta cadastrado
                                //Insere o procedimento para o convenio secundario
                                $this->db->set('data_cadastro', $horario);
                                $this->db->set('operador_cadastro', $operador_id);
                                $this->db->insert('tb_procedimento_convenio');
                                $procedimento_tuss_id = $this->db->insert_id();

                                foreach ($grupoPagamento as $gp) {
                                    $this->db->set('procedimento_convenio_id', $procedimento_tuss_id);
                                    $this->db->set('grupo_pagamento_id', $gp->grupo_pagamento_id);
                                    $this->db->insert('tb_procedimento_convenio_pagamento');
                                }
                            } else {

                                //Atualiza o valor do procedimento no convenio secundario
                                $this->db->set('data_atualizacao', $horario);
                                $this->db->set('operador_atualizacao', $operador_id);
                                $this->db->where('procedimento_convenio_id', $r[0]->procedimento_convenio_id);
                                $this->db->update('tb_procedimento_convenio');
                            }
                        }
                    } else {
                        continue;
                    }
                }
            } else {
                foreach ($_POST['valortotal'] as $key => $value) {

                    if ($_POST['valortotal'][$key] != "") {// insert
                        $this->db->select('procedimento_convenio_id');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
                        $this->db->where('pc.ativo', 't');
                        $this->db->where('pc.empresa_id', $empresa_id);
                        $this->db->where("pc.convenio_id", $convenio_id);
                        $this->db->where("pt.procedimento_tuss_id", $_POST['procedimento_id'][$key]);
                        $query = $this->db->get();
                        $return = $query->result();
                        $qtde = count($return);

                        $this->db->set('procedimento_tuss_id', $_POST['procedimento_id'][$key]);
                        $this->db->set('convenio_id', $convenio_id);
                        $this->db->set('empresa_id', $empresa_id);

                        $this->db->set('qtdech', (($_POST['qtdech'][$key] == "") ? 0 : $_POST['qtdech'][$key]));
                        $this->db->set('valorch', (($_POST['valorch'][$key] == "") ? 0 : $_POST['valorch'][$key]));
                        $this->db->set('qtdefilme', (($_POST['qtdefilme'][$key] == "") ? 0 : $_POST['qtdefilme'][$key]));
                        $this->db->set('valorfilme', (($_POST['valorfilme'][$key] == "") ? 0 : $_POST['valorfilme'][$key]));
                        $this->db->set('qtdeporte', (($_POST['qtdeporte'][$key] == "") ? 0 : $_POST['qtdeporte'][$key]));
                        $this->db->set('valorporte', (($_POST['valorporte'][$key] == "") ? 0 : $_POST['valorporte'][$key]));
                        $this->db->set('qtdeuco', (($_POST['qtdeuco'][$key] == "") ? 0 : $_POST['qtdeuco'][$key]));
                        $this->db->set('valoruco', (($_POST['valoruco'][$key] == "") ? 0 : $_POST['valoruco'][$key]));
                        $this->db->set('valortotal', (($_POST['valortotal'][$key] == "") ? 0 : $_POST['valortotal'][$key]));

                        if ($qtde == 0) {
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);

                            $this->db->insert('tb_procedimento_convenio');
                            $erro = $this->db->_error_message();
                            if (trim($erro) != "") // erro de banco
                                return -1;
                            else
                                $procedimento_convenio_id = $this->db->insert_id();


                            foreach ($grupoPagamento as $gp) {
                                $this->db->set('procedimento_convenio_id', $procedimento_convenio_id);
                                $this->db->set('grupo_pagamento_id', $gp->grupo_pagamento_id);
                                $this->db->insert('tb_procedimento_convenio_pagamento');
                            }

                            // Inserindo o valor nos convenios secundarios
                            $this->db->select('csa.convenio_secundario_id, valor_percentual');
                            $this->db->from('tb_convenio_secudario_associacao csa');
                            $this->db->where('csa.ativo', 't');
                            $this->db->where('csa.convenio_primario_id', $convenio_id);
                            $this->db->where("csa.grupo = (SELECT grupo FROM ponto.tb_procedimento_tuss WHERE procedimento_tuss_id = " . $_POST['procedimento_id'][$key] . " LIMIT 1)");
                            $query = $this->db->get();
                            $secundarios = $query->result();

                            foreach ($secundarios as $sec) {
                                $this->db->set('qtdech', (($_POST['qtdech'][$key] == "") ? 0 : $_POST['qtdech'][$key]));
                                $this->db->set('valorch', (($_POST['valorch'][$key] == "") ? 0 : $_POST['valorch'][$key]));
                                $this->db->set('qtdefilme', (($_POST['qtdefilme'][$key] == "") ? 0 : $_POST['qtdefilme'][$key]));
                                $this->db->set('valorfilme', (($_POST['valorfilme'][$key] == "") ? 0 : $_POST['valorfilme'][$key]));
                                $this->db->set('qtdeporte', (($_POST['qtdeporte'][$key] == "") ? 0 : $_POST['qtdeporte'][$key]));
                                $this->db->set('valorporte', (($_POST['valorporte'][$key] == "") ? 0 : $_POST['valorporte'][$key]));
                                $this->db->set('qtdeuco', (($_POST['qtdeuco'][$key] == "") ? 0 : $_POST['qtdeuco'][$key]));
                                $this->db->set('valoruco', (($_POST['valoruco'][$key] == "") ? 0 : $_POST['valoruco'][$key]));
                                $this->db->set('valortotal', ($_POST['valortotal'][$key] * (float) $sec->valor_percentual / 100));
                                $this->db->set('empresa_id', $_POST['empresa']);
                                $this->db->set('data_atualizacao', $horario);
                                $this->db->set('operador_atualizacao', $operador_id);
                                $this->db->set('procedimento_tuss_id', $_POST['procedimento_id'][$key]);
                                $this->db->set('convenio_id', $sec->convenio_secundario_id);
                                $this->db->insert('tb_procedimento_convenio');
                                $secundario_id = $this->db->insert_id();

                                // Adicionando o grupo de pagamento 
                                $this->db->select('grupo_pagamento_id');
                                $this->db->from('tb_convenio_grupopagamento cg');
                                $this->db->where('cg.ativo', 't');
                                $this->db->where("cg.convenio_id", $sec->convenio_secundario_id);
                                $query = $this->db->get();
                                $gpPagamentoSec = $query->result();

                                foreach ($gpPagamentoSec as $gp) {
                                    $this->db->set('procedimento_convenio_id', $secundario_id);
                                    $this->db->set('grupo_pagamento_id', $gp->grupo_pagamento_id);
                                    $this->db->insert('tb_procedimento_convenio_pagamento');
                                }
                            }
                        } else {
                            $this->db->set('data_atualizacao', $horario);
                            $this->db->set('operador_atualizacao', $operador_id);
                            $this->db->where('procedimento_convenio_id', $return[0]->procedimento_convenio_id);
                            $this->db->update('tb_procedimento_convenio');

                            // Atualizando o valor nos convenios secundarios
                            $this->db->select('csa.convenio_secundario_id, valor_percentual');
                            $this->db->from('tb_convenio_secudario_associacao csa');
                            $this->db->where('csa.ativo', 't');
                            $this->db->where('csa.convenio_primario_id', $convenio_id);
                            $this->db->where("csa.grupo = (SELECT grupo FROM ponto.tb_procedimento_tuss WHERE procedimento_tuss_id = " . $_POST['procedimento_id'][$key] . " LIMIT 1)");
                            $query = $this->db->get();
                            $secundarios = $query->result();

                            foreach ($secundarios as $sec) {
                                $this->db->set('qtdech', (($_POST['qtdech'][$key] == "") ? 0 : $_POST['qtdech'][$key]));
                                $this->db->set('valorch', (($_POST['valorch'][$key] == "") ? 0 : $_POST['valorch'][$key]));
                                $this->db->set('qtdefilme', (($_POST['qtdefilme'][$key] == "") ? 0 : $_POST['qtdefilme'][$key]));
                                $this->db->set('valorfilme', (($_POST['valorfilme'][$key] == "") ? 0 : $_POST['valorfilme'][$key]));
                                $this->db->set('qtdeporte', (($_POST['qtdeporte'][$key] == "") ? 0 : $_POST['qtdeporte'][$key]));
                                $this->db->set('valorporte', (($_POST['valorporte'][$key] == "") ? 0 : $_POST['valorporte'][$key]));
                                $this->db->set('qtdeuco', (($_POST['qtdeuco'][$key] == "") ? 0 : $_POST['qtdeuco'][$key]));
                                $this->db->set('valoruco', (($_POST['valoruco'][$key] == "") ? 0 : $_POST['valoruco'][$key]));
                                $this->db->set('valortotal', ($_POST['valortotal'][$key] * (float) $sec->valor_percentual / 100));
                                $this->db->set('empresa_id', $_POST['empresa']);
                                $this->db->set('data_atualizacao', $horario);
                                $this->db->set('operador_atualizacao', $operador_id);
                                $this->db->where('procedimento_tuss_id', $_POST['procedimento_id'][$key]);
                                $this->db->where('convenio_id', $sec->convenio_secundario_id);
                                $this->db->update('tb_procedimento_convenio');
                            }
                        }
                    } else {
                        continue;
                    }
                }
            }

            return $servidor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar() {
        try {

            $this->db->select('grupo_pagamento_id');
            $this->db->from('tb_convenio_grupopagamento cg');
            $this->db->where('cg.ativo', 't');
            $this->db->where("cg.convenio_id", $_POST['convenio']);
            $query = $this->db->get();
            $grupoPagamento = $query->result();

            if ($_POST['teste_conv_secundario'] == 't') { // Caso seja um convneio secundario
                // Vê qual o convenio primario associado a esse grupo
                $this->db->select('convenio_primario_id, valor_percentual');
                $this->db->from('tb_convenio_secudario_associacao csa');
                $this->db->where('convenio_secundario_id', $_POST['convenio']);
                $this->db->where("csa.grupo = (SELECT grupo FROM ponto.tb_procedimento_tuss WHERE procedimento_tuss_id = " . $_POST['procedimento'] . " LIMIT 1)");
                $this->db->where('ativo', 't');
                $query = $this->db->get();
                $conv_sec = $query->result();


                if (count($conv_sec) > 0) {
                    $this->db->select('pc.*');
                    $this->db->from('tb_procedimento_convenio pc');
                    $this->db->where('pc.ativo', 't');
                    $this->db->where("pc.procedimento_tuss_id", $_POST['procedimento']);
                    $this->db->where("pc.convenio_id", $conv_sec[0]->convenio_primario_id);
                    $query = $this->db->get();
                    $return = $query->result();
                    $qtde = count($return);

                    if ($qtde > 0) { // Verifica de esse procedimento esta contido no convenio primario
                        $this->db->select('pc.*');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->where('pc.ativo', 't');
                        $this->db->where("pc.procedimento_tuss_id", $_POST['procedimento']);
                        $this->db->where("pc.convenio_id", $_POST['convenio']);
                        $query = $this->db->get();
                        $r = $query->result();
                        $q = count($r);

                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set("procedimento_tuss_id", $_POST['procedimento']);
                        $this->db->set("convenio_id", $_POST['convenio']);
                        $this->db->set('empresa_id', $_POST['empresa']);
                        $this->db->set('qtdech', $return[0]->qtdech);
                        $this->db->set('valorch', $return[0]->valorch);
                        $this->db->set('qtdefilme', $return[0]->qtdefilme);
                        $this->db->set('valorfilme', $return[0]->valorfilme);
                        $this->db->set('qtdeporte', $return[0]->qtdeporte);
                        $this->db->set('valorporte', $return[0]->valorporte);
                        $this->db->set('qtdeuco', $return[0]->qtdeuco);
                        $this->db->set('valoruco', $return[0]->valoruco);
                        $this->db->set('valortotal', ($return[0]->valortotal * (float) $conv_sec[0]->valor_percentual / 100));

                        if ($q == 0) { // Verifica se esse procedimento ja esta cadastrado
                            //Insere o procedimento para o convenio secundario
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_convenio');
                            $procedimento_tuss_id = $this->db->insert_id();

                            foreach ($grupoPagamento as $gp) {
                                $this->db->set('procedimento_convenio_id', $procedimento_tuss_id);
                                $this->db->set('grupo_pagamento_id', $gp->grupo_pagamento_id);
                                $this->db->insert('tb_procedimento_convenio_pagamento');
                            }
                        } else {

                            //Atualiza o valor do procedimento no convenio secundario
                            $this->db->set('data_atualizacao', $horario);
                            $this->db->set('operador_atualizacao', $operador_id);
                            $this->db->where('procedimento_convenio_id', $r[0]->procedimento_convenio_id);
                            $this->db->update('tb_procedimento_convenio');
                        }
                    } else {
                        return -2;
                    }
                } else {
                    return -2;
                }
            } else {
                if (isset($_POST['brasindice'])) {
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $grupo = $_POST['grupo'];
                    $this->db->select('t.tuss_id,
                                valor_bri,
                                t.descricao,
                                t.codigo,
                                pt.procedimento_tuss_id,
                                pc.procedimento_convenio_id,
                                pc.convenio_id,
                                grupo_matmed
                                ');
                    $this->db->from('tb_tuss t');
                    $this->db->join('tb_procedimento_tuss pt', 'pt.tuss_id = t.tuss_id', 'left');
                    $this->db->join('tb_procedimento_convenio pc', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
                    $this->db->where("valor_bri > 0.00");
                    //                $this->db->where("pt.tuss_id is null");
                    //                $this->db->where("pc.convenio_id", $_POST['convenio']);
                    $this->db->where("grupo_matmed = '$grupo'");
                    $brasindice_tuss = $this->db->get()->result();

                    foreach ($brasindice_tuss as $value) {
                        // TB PROCEDIMENTO
                        if ($value->procedimento_tuss_id == '') {

                            $this->db->set('nome', $value->descricao);
                            $this->db->set('tuss_id', $value->tuss_id);
                            $this->db->set('codigo', $value->codigo);
                            $this->db->set('descricao', $value->descricao);
                            $this->db->set('qtde', 1);
                            $this->db->set('revisao', 'f');
                            $this->db->set('sala_preparo', 'f');
                            $this->db->set('grupo', $value->grupo_matmed);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_tuss');
                            $procedimento_tuss_id = $this->db->insert_id();
                        } else {
                            $procedimento_tuss_id = $value->procedimento_tuss_id;
                            $this->db->set('grupo', $grupo);
                            $this->db->set('data_atualizacao', $horario);
                            $this->db->set('operador_atualizacao', $operador_id);
                            $this->db->where('procedimento_tuss_id', $procedimento_tuss_id);
                            $this->db->update('tb_procedimento_tuss');
                        }
                        // TB PROCEDIMENTO CONVENIO
                        $this->db->select('convenio_id');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
                        $this->db->where('pc.ativo', 't');
                        $this->db->where("pt.procedimento_tuss_id", $procedimento_tuss_id);
                        $this->db->where("pc.convenio_id", $_POST['convenio']);
                        $query = $this->db->get();
                        $return = $query->result();
                        $qtde = count($return);

                        if ($qtde == 0) {

                            $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                            $this->db->set('convenio_id', $_POST['convenio']);
                            $this->db->set('valortotal', $value->valor_bri);
                            $this->db->set('empresa_id', $_POST['empresa']);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_convenio');
                            $procedimento_convenio_id = $this->db->insert_id();

                            foreach ($grupoPagamento as $gp) {
                                $this->db->set('procedimento_convenio_id', $procedimento_convenio_id);
                                $this->db->set('grupo_pagamento_id', $gp->grupo_pagamento_id);
                                $this->db->insert('tb_procedimento_convenio_pagamento');
                            }
                        }
                    }
                } else {
                    /* inicia o mapeamento no banco */
                    $procedimento_convenio_id = $_POST['txtprocedimentoplanoid'];
                    $convenio_id = $_POST['convenio'];

                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');

                    if ($_POST['txtprocedimentoplanoid'] == "") {// insert
                        $this->db->select('convenio_id');
                        $this->db->from('tb_procedimento_convenio pc');
                        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
                        $this->db->where('pc.ativo', 't');
                        $this->db->where("pt.procedimento_tuss_id", $_POST['procedimento']);
                        $this->db->where("pc.convenio_id", $_POST['convenio']);
                        $this->db->where("pc.empresa_id", $_POST['empresa']);
                        $query = $this->db->get();
                        $return = $query->result();
                        $qtde = count($return);

                        if ($qtde == 0) {
                            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
                            $this->db->set('convenio_id', $_POST['convenio']);
                            $this->db->set('qtdech', $_POST['qtdech']);
                            $this->db->set('valorch', $_POST['valorch']);
                            $this->db->set('qtdefilme', $_POST['qtdefilme']);
                            $this->db->set('valorfilme', $_POST['valorfilme']);
                            $this->db->set('qtdeporte', $_POST['qtdeporte']);
                            $this->db->set('valorporte', $_POST['valorporte']);
                            $this->db->set('qtdeuco', $_POST['qtdeuco']);
                            $this->db->set('valoruco', $_POST['valoruco']);
                            $this->db->set('valortotal', $_POST['valortotal']);
                            $this->db->set('empresa_id', $_POST['empresa']);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_convenio');
                            $erro = $this->db->_error_message();
                            if (trim($erro) != "") // erro de banco
                                return -1;
                            else
                                $procedimento_convenio_id = $this->db->insert_id();


                            foreach ($grupoPagamento as $gp) {
                                $this->db->set('procedimento_convenio_id', $procedimento_convenio_id);
                                $this->db->set('grupo_pagamento_id', $gp->grupo_pagamento_id);
                                $this->db->insert('tb_procedimento_convenio_pagamento');
                            }


                            // Inserindo o procedimento nos convenios secundarios
                            $this->db->select('csa.convenio_secundario_id, valor_percentual');
                            $this->db->from('tb_convenio_secudario_associacao csa');
                            $this->db->where('csa.ativo', 't');
                            $this->db->where('csa.convenio_primario_id', $_POST['convenio']);
                            $this->db->where("csa.grupo = (SELECT grupo FROM ponto.tb_procedimento_tuss WHERE procedimento_tuss_id = " . $_POST['procedimento'] . " LIMIT 1)");
                            $query = $this->db->get();
                            $secundarios = $query->result();

                            foreach ($secundarios as $sec) {
                                $this->db->set('qtdech', $_POST['qtdech']);
                                $this->db->set('valorch', $_POST['valorch']);
                                $this->db->set('qtdefilme', $_POST['qtdefilme']);
                                $this->db->set('valorfilme', $_POST['valorfilme']);
                                $this->db->set('qtdeporte', $_POST['qtdeporte']);
                                $this->db->set('valorporte', $_POST['valorporte']);
                                $this->db->set('qtdeuco', $_POST['qtdeuco']);
                                $this->db->set('valoruco', $_POST['valoruco']);
                                $this->db->set('valortotal', ($_POST['valortotal'] * (float) $sec->valor_percentual / 100));
                                $this->db->set('empresa_id', $_POST['empresa']);
                                $this->db->set('data_atualizacao', $horario);
                                $this->db->set('operador_atualizacao', $operador_id);
                                $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
                                $this->db->set('convenio_id', $sec->convenio_secundario_id);
                                $this->db->insert('tb_procedimento_convenio');
                                $secundario_id = $this->db->insert_id();

                                // Adicionando o grupo de pagamento 
                                $this->db->select('grupo_pagamento_id');
                                $this->db->from('tb_convenio_grupopagamento cg');
                                $this->db->where('cg.ativo', 't');
                                $this->db->where("cg.convenio_id", $sec->convenio_secundario_id);
                                $query = $this->db->get();
                                $gpPagamentoSec = $query->result();

                                foreach ($gpPagamentoSec as $gp) {
                                    $this->db->set('procedimento_convenio_id', $secundario_id);
                                    $this->db->set('grupo_pagamento_id', $gp->grupo_pagamento_id);
                                    $this->db->insert('tb_procedimento_convenio_pagamento');
                                }
                            }
                        } else {
                            return -1;
                        }
                    } else { // update
                        $sql = "INSERT INTO ponto.tb_procedimento_convenio_antigo(procedimento_convenio_id, convenio_id, 
                            procedimento_tuss_id, qtdech, valorch, qtdefilme, valorfilme, 
                            qtdeporte, valorporte, qtdeuco, valoruco, valortotal,
                            ativo, data_cadastro, operador_cadastro, data_atualizacao, operador_atualizacao, empresa_id)
                            SELECT procedimento_convenio_id, convenio_id, procedimento_tuss_id, 
                            qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
                            qtdeuco, valoruco, valortotal, ativo, '$horario', $operador_id, 
                            data_atualizacao, operador_atualizacao, empresa_id
                            FROM ponto.tb_procedimento_convenio
                            WHERE procedimento_convenio_id = $procedimento_convenio_id";
                        $this->db->query($sql);



                        $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
                        $this->db->set('convenio_id', $_POST['convenio']);
                        $this->db->set('qtdech', $_POST['qtdech']);
                        $this->db->set('valorch', $_POST['valorch']);
                        $this->db->set('qtdefilme', $_POST['qtdefilme']);
                        $this->db->set('valorfilme', $_POST['valorfilme']);
                        $this->db->set('qtdeporte', $_POST['qtdeporte']);
                        $this->db->set('valorporte', $_POST['valorporte']);
                        $this->db->set('qtdeuco', $_POST['qtdeuco']);
                        $this->db->set('valoruco', $_POST['valoruco']);
                        $this->db->set('valortotal', $_POST['valortotal']);
                        $this->db->set('empresa_id', $_POST['empresa']);
                        $this->db->set('data_atualizacao', $horario);
                        $this->db->set('operador_atualizacao', $operador_id);
                        $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
                        $this->db->update('tb_procedimento_convenio');

                        // Atualizando o valor nos convenios secundarios
                        $this->db->select('csa.convenio_secundario_id, valor_percentual');
                        $this->db->from('tb_convenio_secudario_associacao csa');
                        $this->db->where('csa.ativo', 't');
                        $this->db->where('csa.convenio_primario_id', $_POST['convenio']);
                        $this->db->where("csa.grupo = (SELECT grupo FROM ponto.tb_procedimento_tuss WHERE procedimento_tuss_id = " . $_POST['procedimento'] . " LIMIT 1)");
                        $query = $this->db->get();
                        $secundarios = $query->result();

                        foreach ($secundarios as $sec) {
                            $this->db->set('qtdech', $_POST['qtdech']);
                            $this->db->set('valorch', $_POST['valorch']);
                            $this->db->set('qtdefilme', $_POST['qtdefilme']);
                            $this->db->set('valorfilme', $_POST['valorfilme']);
                            $this->db->set('qtdeporte', $_POST['qtdeporte']);
                            $this->db->set('valorporte', $_POST['valorporte']);
                            $this->db->set('qtdeuco', $_POST['qtdeuco']);
                            $this->db->set('valoruco', $_POST['valoruco']);
                            $this->db->set('valortotal', ($_POST['valortotal'] * (float) $sec->valor_percentual / 100));
                            $this->db->set('empresa_id', $_POST['empresa']);
                            $this->db->set('data_atualizacao', $horario);
                            $this->db->set('operador_atualizacao', $operador_id);
                            $this->db->where('procedimento_tuss_id', $_POST['procedimento']);
                            $this->db->where('convenio_id', $sec->convenio_secundario_id);
                            $this->db->update('tb_procedimento_convenio');
                        }
                    }
                }
            }
            return $servidor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function salvareplicacaopercentualmedico() {
        try {

            $grupo = $_POST['grupo'];
            $convenio = $_POST['covenio'];
            $medicoOrigem = $_POST['medico'];
            $medicoDestino = $_POST['medico2'];

            $this->db->select('pc.convenio_id, 
                               pc.procedimento_tuss_id, 
                               ppmc.valor, ppmc.percentual, 
                               ppm.procedimento_percentual_medico_id,
                               ppmc.dia_recebimento,
                               ppmc.tempo_recebimento');
            $this->db->from('tb_procedimento_percentual_medico_convenio ppmc');
            $this->db->join('tb_procedimento_percentual_medico ppm', "ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id");
            $this->db->join('tb_procedimento_convenio pc', "pc.procedimento_convenio_id = ppm.procedimento_tuss_id");
            $this->db->join('tb_procedimento_tuss pt', "pt.procedimento_tuss_id = pc.procedimento_tuss_id");
            $this->db->where('ppmc.medico', $medicoOrigem);
            $this->db->where('ppmc.ativo', 'true');

            if ($convenio != "") {
                $this->db->where('pc.convenio_id', $convenio);
            }
            if ($grupo != "") {
                $this->db->where('pt.grupo', $grupo);
            }

            $return = $this->db->get();
            $result = $return->result();

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            foreach ($result as $item) {

                //CASO ESTE PROCEDIMENTO PLANO JA TENHA SIDO CADASTRADO PRA ESSE MEDICO ELE APAGA O ANTIGO E INSERE UM NOVO
                $parametro = "ppmc.medico = {$medicoDestino} ";

                if ($grupo != "") {
                    $parametro .= " AND pt.grupo = '{$grupo}' ";
                }

                $parametro .= " AND pc.convenio_id = {$item->convenio_id} ";
                $parametro .= " AND pc.procedimento_tuss_id = {$item->procedimento_tuss_id} ";

                $sql = "UPDATE ponto.tb_procedimento_percentual_medico_convenio 
                        SET ativo = 'f', data_atualizacao = '" . $horario . "', operador_atualizacao = {$operador_id} 
                        WHERE procedimento_percentual_medico_convenio_id IN (
                            SELECT ppmc.procedimento_percentual_medico_convenio_id
                            FROM ponto.tb_procedimento_percentual_medico_convenio ppmc 
                            INNER JOIN ponto.tb_procedimento_percentual_medico ppm ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id  
                            INNER JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ppm.procedimento_tuss_id 
                            INNER JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
                            WHERE " . $parametro . " ) ";
                $this->db->query($sql);


                //INSERE NOVO VALOR 
                $this->db->set('procedimento_percentual_medico_id', $item->procedimento_percentual_medico_id);
                $this->db->set('medico', $medicoDestino);
                $this->db->set('valor', $item->valor);
                $this->db->set('percentual', $item->percentual);
                if ($item->dia_recebimento != "") {
                    $this->db->set('dia_recebimento', $item->dia_recebimento);
                }
                if ($item->tempo_recebimento != "") {
                    $this->db->set('tempo_recebimento', $item->tempo_recebimento);
                }
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_procedimento_percentual_medico_convenio');
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $procedimento_id = $this->db->insert_id();


            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpercentualmedico() {
        try {
//            echo "<pre>";
//            var_dump($_POST);
//            die;
            $grupo = $_POST['grupo'];
            $convenio = $_POST['covenio'];
            $medico = $_POST['medico'];
            $procediemento = $_POST['procedimento'];

            if ($grupo == "") {  // inicio grupo=selecione
                if ($medico == "TODOS") { // inicio grupo=selecione  medico=todos
                    $this->db->select('operador_id,
                                       nome');
                    $this->db->from('tb_operador');
                    $this->db->where('consulta', 'true');
                    $this->db->where('ativo', 'true');
                    $this->db->where('solicitante', 'f');
                    $return = $this->db->get();
                    $medicos = $return->result();
                    $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('medico', $operador);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_medico');

                    $procedimento_percentual_medico_id = $this->db->insert_id();

                    foreach ($medicos as $item) {
                        $operador = $item->operador_id;

                        /* inicia o mapeamento no banco */

                        $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                        $this->db->set('medico', $operador);
                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        if ($_POST['revisor'] == '1') {
                            $this->db->set('revisor', 't');
                        }
                        if ($_POST['dia_recebimento'] != '') {
                            $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
                        }
                        if ($_POST['tempo_recebimento'] != '') {
                            $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
                        }
                        $percentual = $_POST['percentual'];
                        $this->db->set('percentual', $percentual);
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico_convenio');
                    }  // fim grupo=selecione  medico=todos
                } else {
                    /* inicia o mapeamento no banco */
                    $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('medico', $_POST['medico']);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_medico');

                    $procedimento_percentual_medico_id = $this->db->insert_id();
                    $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                    $this->db->set('medico', $_POST['medico']);
                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                    if ($_POST['dia_recebimento'] != '') {
                        $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
                    }
                    if ($_POST['tempo_recebimento'] != '') {
                        $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
                    }
                    if ($_POST['revisor'] == '1') {
                        $this->db->set('revisor', 't');
                    }
                    $percentual = $_POST['percentual'];
                    $this->db->set('percentual', $percentual);
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_medico_convenio');
                } // fim grupo=selecione
            } elseif ($grupo == "TODOS") {  // inicio grupo=todos 
                if ($procediemento == "") {
                    $this->db->select('procedimento_convenio_id,
                                    procedimento_tuss_id ');
                    $this->db->from('tb_procedimento_convenio');
                    $this->db->where('convenio_id', $convenio);
                    $this->db->where('ativo', 't');
                    $return = $this->db->get();
                    $procedimentos = $return->result();

                    if ($medico == "TODOS") { // inicio grupo=todos medico=todos
                        $this->db->select('operador_id,
                                       nome');
                        $this->db->from('tb_operador');
                        $this->db->where('consulta', 'true');
                        $this->db->where('ativo', 'true');
                        $this->db->where('solicitante', 'f');
                        $return = $this->db->get();
                        $medicos = $return->result();




                        foreach ($procedimentos as $value) {
                            $dados = $value->procedimento_convenio_id;
                            $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('medico', $operador);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico');

                            $procedimento_percentual_medico_id = $this->db->insert_id();
                            foreach ($medicos as $item) {
                                $operador = $item->operador_id;

                                /* inicia o mapeamento no banco */

                                $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                                $this->db->set('medico', $operador);
                                $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                                $percentual = $_POST['percentual'];
                                if ($_POST['dia_recebimento'] != '') {
                                    $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
                                }
                                if ($_POST['tempo_recebimento'] != '') {
                                    $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
                                }
                                $this->db->set('percentual', $percentual);
                                $horario = date("Y-m-d H:i:s");
                                if ($_POST['revisor'] == '1') {
                                    $this->db->set('revisor', 't');
                                }
                                $operador_id = $this->session->userdata('operador_id');
                                $this->db->set('data_cadastro', $horario);
                                $this->db->set('operador_cadastro', $operador_id);
                                $this->db->insert('tb_procedimento_percentual_medico_convenio');
                            }
                        }
                    } //fim grupo=todos medico=todos
                    else {
                        foreach ($procedimentos as $value) {
                            $dados = $value->procedimento_convenio_id;
                            /* inicia o mapeamento no banco */
                            $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('medico', $_POST['medico']);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico');

                            $procedimento_percentual_medico_id = $this->db->insert_id();
                            $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                            $this->db->set('medico', $_POST['medico']);
                            if ($_POST['dia_recebimento'] != '') {
                                $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
                            }
                            if ($_POST['tempo_recebimento'] != '') {
                                $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
                            }
                            if ($_POST['revisor'] == '1') {
                                $this->db->set('revisor', 't');
                            }
                            $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $percentual = $_POST['percentual'];
                            $this->db->set('percentual', $percentual);
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico_convenio');
                        }
                    }
                } elseif ($procediemento !== "") {
                    if ($medico == "TODOS") { // inicio grupo=selecione  medico=todos
                        $this->db->select('operador_id,
                                       nome');
                        $this->db->from('tb_operador');
                        $this->db->where('consulta', 'true');
                        $this->db->where('ativo', 'true');
                        $this->db->where('solicitante', 'f');
                        $return = $this->db->get();
                        $medicos = $return->result();
                        $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('medico', $operador);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico');

                        $procedimento_percentual_medico_id = $this->db->insert_id();

                        foreach ($medicos as $item) {
                            $operador = $item->operador_id;

                            /* inicia o mapeamento no banco */

                            $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                            $this->db->set('medico', $operador);
                            $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $percentual = $_POST['percentual'];
                            $this->db->set('percentual', $percentual);
                            if ($_POST['dia_recebimento'] != '') {
                                $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
                            }
                            if ($_POST['tempo_recebimento'] != '') {
                                $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
                            }
                            if ($_POST['revisor'] == '1') {
                                $this->db->set('revisor', 't');
                            }
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico_convenio');
                        }  // fim grupo=selecione  medico=todos
                    } else {
                        /* inicia o mapeamento no banco */
                        $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('medico', $_POST['medico']);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico');

                        $procedimento_percentual_medico_id = $this->db->insert_id();
                        $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                        $this->db->set('medico', $_POST['medico']);
                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $percentual = $_POST['percentual'];
                        $this->db->set('percentual', $percentual);
                        $horario = date("Y-m-d H:i:s");
                        if ($_POST['dia_recebimento'] != '') {
                            $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
                        }
                        if ($_POST['tempo_recebimento'] != '') {
                            $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
                        }
                        if ($_POST['revisor'] == '1') {
                            $this->db->set('revisor', 't');
                        }
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico_convenio');
                    }
                }
            } // fim grupo todos
            else { //inicio grupo especifico
                $this->db->select('pt.procedimento_tuss_id,
                                   pc.procedimento_convenio_id');
                $this->db->from('tb_procedimento_tuss pt');
                $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                $this->db->where('pc.convenio_id', $convenio);
                $this->db->where('pt.grupo', $grupo);

                if ($procediemento != "") {
                    $this->db->where('pc.procedimento_convenio_id', $procediemento);
                }

                $this->db->where('pc.ativo', 't');
                $this->db->where('pt.ativo', 't');
                $this->db->orderby("pt.nome");
                $return = $this->db->get();
                $procedimentos2 = $return->result();
//                echo '<pre>';
//                var_dump($grupo);
//                var_dump($procedimentos2); die;

                if ($medico == "TODOS") { // inicio grupo especifico  medico=todos
                    $this->db->select('operador_id,
                                       nome');
                    $this->db->from('tb_operador');
                    $this->db->where('consulta', 'true');
                    $this->db->where('ativo', 'true');
                    $this->db->where('solicitante', 'f');
                    $return = $this->db->get();
                    $medicos = $return->result();


                    foreach ($procedimentos2 as $value) {
                        $dados = $value->procedimento_convenio_id;

                        $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('medico', $operador);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico');

                        $procedimento_percentual_medico_id = $this->db->insert_id();
                        foreach ($medicos as $item) {
                            $operador = $item->operador_id;
                            /* inicia o mapeamento no banco */

                            $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                            $this->db->set('medico', $operador);
                            $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $percentual = $_POST['percentual'];
                            $this->db->set('percentual', $percentual);
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            if ($_POST['dia_recebimento'] != '') {
                                $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
                            }
                            if ($_POST['tempo_recebimento'] != '') {
                                $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
                            }
                            if ($_POST['revisor'] == '1') {
                                $this->db->set('revisor', 't');
                            }
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_medico_convenio');
                        }
                    }
                } // fim medico=todos
                else {
                    foreach ($procedimentos2 as $value) {
                        $dados = $value->procedimento_convenio_id;
                        /* inicia o mapeamento no banco */
                        $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('medico', $_POST['medico']);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico');

                        $procedimento_percentual_medico_id = $this->db->insert_id();
                        $this->db->set('procedimento_percentual_medico_id', $procedimento_percentual_medico_id);
                        $this->db->set('medico', $_POST['medico']);
                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $percentual = $_POST['percentual'];
                        $this->db->set('percentual', $percentual);
                        $horario = date("Y-m-d H:i:s");
                        if ($_POST['dia_recebimento'] != '') {
                            $this->db->set('dia_recebimento', $_POST['dia_recebimento']);
                        }
                        if ($_POST['tempo_recebimento'] != '') {
                            $this->db->set('tempo_recebimento', $_POST['tempo_recebimento']);
                        }
                        if ($_POST['revisor'] == '1') {
                            $this->db->set('revisor', 't');
                        }
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_medico_convenio');
                    }
                }
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $procedimento_id = $this->db->insert_id();


            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpercentualpromotor() {
        try {

            $grupo = $_POST['grupo'];
            $convenio = $_POST['covenio'];
            $promotor = $_POST['promotor'];
            $procediemento = $_POST['procedimento'];



            if ($grupo == "") {  // inicio grupo=selecione
                if ($promotor == "TODOS") { // inicio grupo=selecione  promotor=todos
                    $this->db->select('paciente_indicacao_id, nome');
                    $this->db->from('tb_paciente_indicacao');
                    $this->db->where('ativo', 't');
                    $return = $this->db->get();
                    $promotors = $return->result();
                    $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('promotor', $operador);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_promotor');

                    $procedimento_percentual_promotor_id = $this->db->insert_id();

                    foreach ($promotors as $item) {
                        $operador = $item->paciente_indicacao_id;

                        /* inicia o mapeamento no banco */

                        $this->db->set('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
                        $this->db->set('promotor', $operador);
                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $percentual = $_POST['percentual'];
                        $this->db->set('percentual', $percentual);
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_promotor_convenio');
                    }  // fim grupo=selecione  promotor=todos
                } else {
                    /* inicia o mapeamento no banco */
                    $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('promotor', $_POST['promotor']);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_promotor');

                    $procedimento_percentual_promotor_id = $this->db->insert_id();
                    $this->db->set('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
                    $this->db->set('promotor', $_POST['promotor']);
                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                    $percentual = $_POST['percentual'];
                    $this->db->set('percentual', $percentual);
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_procedimento_percentual_promotor_convenio');
                } // fim grupo=selecione
            } elseif ($grupo == "TODOS") {  // inicio grupo=todos 
                if ($procediemento == "") {
                    $this->db->select('procedimento_convenio_id,
                                    procedimento_tuss_id ');
                    $this->db->from('tb_procedimento_convenio');
                    $this->db->where('convenio_id', $convenio);
                    $this->db->where('ativo', 't');
                    $return = $this->db->get();
                    $procedimentos = $return->result();

                    if ($promotor == "TODOS") { // inicio grupo=todos promotor=todos
                        $this->db->select('paciente_indicacao_id, nome');
                        $this->db->from('tb_paciente_indicacao');
                        $this->db->where('ativo', 't');
                        $return = $this->db->get();
                        $promotors = $return->result();




                        foreach ($procedimentos as $value) {
                            $dados = $value->procedimento_convenio_id;
                            $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('promotor', $operador);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_promotor');

                            $procedimento_percentual_promotor_id = $this->db->insert_id();
                            foreach ($promotors as $item) {
                                $operador = $item->paciente_indicacao_id;

                                /* inicia o mapeamento no banco */

                                $this->db->set('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
                                $this->db->set('promotor', $operador);
                                $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                                $percentual = $_POST['percentual'];
                                $this->db->set('percentual', $percentual);
                                $horario = date("Y-m-d H:i:s");
                                $operador_id = $this->session->userdata('operador_id');
                                $this->db->set('data_cadastro', $horario);
                                $this->db->set('operador_cadastro', $operador_id);
                                $this->db->insert('tb_procedimento_percentual_promotor_convenio');
                            }
                        }
                    } //fim grupo=todos promotor=todos
                    else {
                        foreach ($procedimentos as $value) {
                            $dados = $value->procedimento_convenio_id;
                            /* inicia o mapeamento no banco */
                            $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('promotor', $_POST['promotor']);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_promotor');

                            $procedimento_percentual_promotor_id = $this->db->insert_id();
                            $this->db->set('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
                            $this->db->set('promotor', $_POST['promotor']);
                            $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $percentual = $_POST['percentual'];
                            $this->db->set('percentual', $percentual);
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_promotor_convenio');
                        }
                    }
                } elseif ($procediemento !== "") {
                    if ($promotor == "TODOS") { // inicio grupo=selecione  promotor=todos
                        $this->db->select('paciente_indicacao_id, nome');
                        $this->db->from('tb_paciente_indicacao');
                        $this->db->where('ativo', 't');
                        $return = $this->db->get();
                        $promotors = $return->result();
                        $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('promotor', $operador);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_promotor');

                        $procedimento_percentual_promotor_id = $this->db->insert_id();

                        foreach ($promotors as $item) {
                            $operador = $item->paciente_indicacao_id;

                            /* inicia o mapeamento no banco */

                            $this->db->set('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
                            $this->db->set('promotor', $operador);
                            $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $percentual = $_POST['percentual'];
                            $this->db->set('percentual', $percentual);
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_promotor_convenio');
                        }  // fim grupo=selecione  promotor=todos
                    } else {
                        /* inicia o mapeamento no banco */
                        $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                    $this->db->set('promotor', $_POST['promotor']);
//                    $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_promotor');

                        $procedimento_percentual_promotor_id = $this->db->insert_id();
                        $this->db->set('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
                        $this->db->set('promotor', $_POST['promotor']);
                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $percentual = $_POST['percentual'];
                        $this->db->set('percentual', $percentual);
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_promotor_convenio');
                    }
                }
            } // fim grupo todos
            else { //inicio grupo especifico
                $this->db->select('pt.procedimento_tuss_id,
                                   pc.procedimento_convenio_id');
                $this->db->from('tb_procedimento_tuss pt');
                $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                $this->db->where('pc.convenio_id', $convenio);
                $this->db->where('pt.grupo', $grupo);

                if ($procediemento != "") {
                    $this->db->where('pc.procedimento_convenio_id', $procediemento);
                }

                $this->db->where('pc.ativo', 't');
                $this->db->where('pt.ativo', 't');
                $this->db->orderby("pt.nome");
                $return = $this->db->get();
                $procedimentos2 = $return->result();

                if ($promotor == "TODOS") { // inicio grupo especifico  promotor=todos
                    $this->db->select('paciente_indicacao_id, nome');
                    $this->db->from('tb_paciente_indicacao');
                    $this->db->where('ativo', 't');
                    $return = $this->db->get();
                    $promotors = $return->result();


                    foreach ($procedimentos2 as $value) {
                        $dados = $value->procedimento_convenio_id;

                        $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('promotor', $operador);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_promotor');

                        $procedimento_percentual_promotor_id = $this->db->insert_id();
                        foreach ($promotors as $item) {
                            $operador = $item->paciente_indicacao_id;
                            /* inicia o mapeamento no banco */

                            $this->db->set('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
                            $this->db->set('promotor', $operador);
                            $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                            $percentual = $_POST['percentual'];
                            $this->db->set('percentual', $percentual);
                            $horario = date("Y-m-d H:i:s");
                            $operador_id = $this->session->userdata('operador_id');
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_procedimento_percentual_promotor_convenio');
                        }
                    }
                } // fim promotor=todos
                else {
                    foreach ($procedimentos2 as $value) {
                        $dados = $value->procedimento_convenio_id;
                        /* inicia o mapeamento no banco */
                        $this->db->set('procedimento_tuss_id', $dados);
//                        $this->db->set('promotor', $_POST['promotor']);
//                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_promotor');

                        $procedimento_percentual_promotor_id = $this->db->insert_id();
                        $this->db->set('procedimento_percentual_promotor_id', $procedimento_percentual_promotor_id);
                        $this->db->set('promotor', $_POST['promotor']);
                        $this->db->set('valor', str_replace(",", ".", $_POST['valor']));
                        $percentual = $_POST['percentual'];
                        $this->db->set('percentual', $percentual);
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_procedimento_percentual_promotor_convenio');
                    }
                }
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $procedimento_id = $this->db->insert_id();


            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($procedimento_convenio_id) {

        if ($procedimento_convenio_id != 0) {
            $this->db->select('procedimento_convenio_id,
                            pc.convenio_id,
                            pc.empresa_id,
                            c.associado,
                            c.nome as convenio,
                            pc.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pc.qtdech,
                            pc.valorch,
                            pc.qtdefilme,
                            pc.valorfilme,
                            pc.qtdeporte,
                            pc.valorporte,
                            pc.qtdeuco,
                            pc.valoruco,
                            pc.valortotal');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->where("pc.ativo", 't');
            $this->db->where("procedimento_convenio_id", $procedimento_convenio_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_procedimento_convenio_id = $procedimento_convenio_id;
            $this->_convenio_id = $return[0]->convenio_id;
            $this->_convenio = $return[0]->convenio;
            $this->_procedimento_tuss_id = $return[0]->procedimento_tuss_id;
            $this->_procedimento = $return[0]->procedimento;
            $this->_qtdech = $return[0]->qtdech;
            $this->_valorch = $return[0]->valorch;
            $this->_qtdefilme = $return[0]->qtdefilme;
            $this->_valorfilme = $return[0]->valorfilme;
            $this->_qtdeporte = $return[0]->qtdeporte;
            $this->_valorporte = $return[0]->valorporte;
            $this->_qtdeuco = $return[0]->qtdeuco;
            $this->_valoruco = $return[0]->valoruco;
            $this->_valortotal = $return[0]->valortotal;
            $this->_empresa_id = $return[0]->empresa_id;
            $this->_associado = $return[0]->associado;
        } else {
            $this->_procedimento_convenio_id = null;
            $this->_qtdech = 0;
            $this->_valorch = 0;
            $this->_qtdefilme = 0;
            $this->_valorfilme = 0;
            $this->_qtdeporte = 0;
            $this->_valorporte = 0;
            $this->_qtdeuco = 0;
            $this->_valoruco = 0;
        }
    }

}

?>
