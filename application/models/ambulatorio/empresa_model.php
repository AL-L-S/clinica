<?php

class empresa_model extends Model {

    var $_empresa_id = null;
    var $_nome = null;
    var $_razao_social = null;
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
    var $_chat = null;
    var $_servicoemail = null;
    var $_servicosms = null;
    var $_cnes = null;
    var $_botao_faturar_guia = null;
    var $_botao_faturar_proc = null;

    function Empresa_model($exame_empresa_id = null) {
        parent::Model();
        if (isset($exame_empresa_id)) {
            $this->instanciar($exame_empresa_id);
        }
    }

    function listar($args = array()) {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('empresa_id,
                            nome,
                            razao_social,
                            cnpj');
        $this->db->from('tb_empresa');
        if ($operador_id != 1) {
            $this->db->where('empresa_id', $empresa_id);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarlembretes($args = array()) {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select("el.empresa_lembretes_id,
                            el.texto,
                            el.perfil_destino,
                            el.operador_destino,
                            el.ativo,
                            o.nome as operador,
                            (
                                SELECT COUNT(*) 
                                FROM ponto.tb_empresa_lembretes_visualizacao 
                                WHERE ponto.tb_empresa_lembretes_visualizacao.empresa_lembretes_id = el.empresa_lembretes_id 
                            ) as visualizado");
        $this->db->from('tb_empresa_lembretes el');
        $this->db->join('tb_operador o', "o.operador_id = el.operador_destino");
        $this->db->where('el.empresa_id', $empresa_id);
//        $this->db->where('el.ativo', 't');

        if (isset($args['texto']) && strlen(@$args['texto']) > 0) {
            $this->db->where('el.texto ilike', "%" . $args['texto'] . "%");
        }

        if (@$args['operador_id'] != '') {
            $this->db->where('el.operador_destino', $args['operador_id']);
        }

        if (@$args['perfil_id'] != '') {
            $this->db->where('el.perfil_destino', $args['perfil_id']);
        }

        return $this->db;
    }

    function listarnumeroindentificacaosms() {

        $this->db->select('nome_empresa, numero_indentificacao');
        $this->db->from('tb_empresas_indentificacao_sms');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressao() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('*');
        $this->db->from('tb_empresa_impressao');
        $this->db->where('empresa_id', $empresa_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function pacotesms() {

        $this->db->select('descricao_pacote, pacote_sms_id');
        $this->db->from('tb_pacote_sms');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacs() {

        $this->db->select('*');
        $this->db->from('tb_pacs');
//        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresas() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_empresa_id,
                            nome, tipo');
        $this->db->from('tb_exame_empresa');
        $this->db->orderby('nome');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresasprocedimento() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->orderby('nome');
//        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarinformacaoemail($empresa_id) {
//        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' email_mensagem_confirmacao,
                            email_mensagem_agradecimento,
                            email_mensagem_falta');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarinformacaosms($empresa_id) {
//        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' pacote_id,
                            empresa_sms_id,
                            numero_indentificacao_sms,
                            enviar_excedentes,
                            mensagem_revisao, 
                            mensagem_confirmacao, 
                            mensagem_agradecimento,
                            mensagem_aniversariante');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $this->db->limit(1);
        $return = $this->db->get();
        return $return->result();
    }

    function listaripservidor() {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('');
        $this->db->from('tb_empresas_acesso_servidores');
//        $this->db->where('empresa_id', $empresa_id);
//        $this->db->where('ativo', 't');
//        $this->db->limit(1);
        $return = $this->db->get();
        return $return->result();
    }

    function buscandolembreteoperador() {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('empresa_lembretes_id,
                            texto,
                            (
                                SELECT COUNT(*) 
                                FROM ponto.tb_empresa_lembretes_visualizacao 
                                WHERE ponto.tb_empresa_lembretes_visualizacao.empresa_lembretes_id = el.empresa_lembretes_id 
                                AND ponto.tb_empresa_lembretes_visualizacao.operador_visualizacao = ' . $operador_id . '
                            ) as visualizado');
        $this->db->from('tb_empresa_lembretes el');
        $this->db->where('ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        $retorno = $return->result();

        return $retorno;
    }

    function visualizalembrete() {

        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");

        $this->db->set('empresa_lembretes_id', $_GET['lembretes_id']);
        $this->db->set('data_visualizacao', $horario);
        $this->db->set('operador_visualizacao', $operador_id);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->insert('tb_empresa_lembretes_visualizacao');
    }

    function listarempresa($empresa_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_empresa_id,
                            nome, tipo');
        $this->db->from('tb_exame_empresa');
        $this->db->where('exame_empresa_id', $empresa_id);
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluirlembrete($empresa_lembretes_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('empresa_lembretes_id', $empresa_lembretes_id);
        $this->db->update('tb_empresa_lembretes');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluir($exame_empresa_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('exame_empresa_id', $exame_empresa_id);
        $this->db->update('tb_exame_empresa');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarlembrete($empresa_lembretes_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->set('texto', $_POST['descricao']);
        $this->db->set('operador_destino', $_POST['operador_id']);
        $this->db->set('empresa_id', $empresa_id);

        if ($empresa_lembretes_id == "" || $empresa_lembretes_id == "0") {// insert
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_empresa_lembretes');
        } else { // update
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('empresa_lembretes_id', $empresa_lembretes_id);
            $this->db->update('tb_empresa_lembretes');
        }

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravaripservidor($servidor_id) {

        $this->db->set('ip_externo', $_POST['ipservidor']);
        $this->db->set('nome_clinica', $_POST['nome_clinica']);
        $this->db->insert('tb_empresas_acesso_servidores');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluiripservidor($servidor_id) {

        $this->db->where('empresas_acesso_externo_id', $servidor_id);
        $this->db->delete('tb_empresas_acesso_servidores');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarconfiguracaoemail() {
        try {
//            var_dump($_POST['empresa_id']); die;

            $this->db->set('email_mensagem_confirmacao', $_POST['lembr']);
            $this->db->set('email_mensagem_agradecimento', $_POST['agrade']);
            $this->db->set('email_mensagem_falta', $_POST['falta']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->where('empresa_id', $_POST['empresa_id']);
            $this->db->update('tb_empresa');
            $empresa_id = $_POST['empresa_id'];

            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconfiguracaosms() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('empresa_id', $_POST['empresa_id']);
            $this->db->set('pacote_id', $_POST['txtpacote']);
            $this->db->set('numero_indentificacao_sms', $_POST['numero_identificacao_sms']);

            if (isset($_POST['msgensExcedentes'])) {
                $this->db->set('enviar_excedentes', 't');
            } else {
                $this->db->set('enviar_excedentes', 'f');
            }

            $this->db->set('mensagem_confirmacao', $_POST['txtMensagemConfirmacao']);
            $this->db->set('mensagem_agradecimento', $_POST['txtMensagemAgradecimento']);
            $this->db->set('mensagem_aniversariante', $_POST['txtMensagemAniversariantes']);
            $this->db->set('mensagem_revisao', $_POST['txtMensagemRevisao']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['sms_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa_sms');
            } else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);

                $sms_id = $_POST['sms_id'];

                $this->db->where('empresa_sms_id', $sms_id);
                $this->db->update('tb_empresa_sms');
            }
            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconfiguracaopacs() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('empresa_id', $_POST['empresa_id']);
//            $this->db->set('pacote_id', $_POST['txtpacote']);
//            if(isset($_POST['msgensExcedentes'])){
//                $this->db->set('enviar_excedentes', 't');
//            }
//            else{
//                $this->db->set('enviar_excedentes', 'f');
//            }
            $this->db->set('ip_local', $_POST['ip_local']);
            $this->db->set('ip_externo', $_POST['ip_externo']);
            $this->db->set('login', $_POST['login']);
            $this->db->set('senha', $_POST['senha']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['pacs_id'] == "") {// insert
//                $this->db->set('data_cadastro', $horario);
//                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_pacs');
            } else { // update
//                $this->db->set('data_atualizacao', $horario);
//                $this->db->set('operador_atualizacao', $operador_id);
                $pacs_id = $_POST['pacs_id'];

                $this->db->where('pacs_id', $pacs_id);
                $this->db->update('tb_pacs');
            }
//            echo 'something';
//            die;
            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('razao_socialxml', $_POST['txtrazaosocialxml']);
            $this->db->set('cep', $_POST['CEP']);
            $this->db->set('cnes', $_POST['txtCNES']);
            $this->db->set('email', $_POST['email']);

            if ($_POST['impressao_tipo'] != "") {
                $this->db->set('impressao_tipo', $_POST['impressao_tipo']);
            }
            if ($_POST['impressao_laudo'] != "") {
                $this->db->set('impressao_laudo', $_POST['impressao_laudo']);
            }
            if ($_POST['impressao_recibo'] != "") {
                $this->db->set('impressao_recibo', $_POST['impressao_recibo']);
            }
            if ($_POST['impressao_declaracao'] != "") {
                $this->db->set('impressao_declaracao', $_POST['impressao_declaracao']);
            }

            if ($_POST['txtCNPJ'] != '') {
                $this->db->set('cnpj', str_replace("-", "", str_replace("/", "", str_replace(".", "", $_POST['txtCNPJ']))));
            }
            if ($_POST['txtCNPJxml'] != '') {
                $this->db->set('cnpjxml', str_replace("-", "", str_replace("/", "", str_replace(".", "", $_POST['txtCNPJxml']))));
            }
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);

            if (isset($_POST['sms'])) {
                $this->db->set('servicosms', 't');
            } else {
                $this->db->set('servicosms', 'f');
            }
            if (isset($_POST['servicoemail'])) {
                $this->db->set('servicoemail', 't');
            } else {
                $this->db->set('servicoemail', 'f');
            }
            if (isset($_POST['chat'])) {
                $this->db->set('chat', 't');
            } else {
                $this->db->set('chat', 'f');
            }
            if (isset($_POST['imagem'])) {
                $this->db->set('imagem', 't');
            } else {
                $this->db->set('imagem', 'f');
            }
            if (isset($_POST['data_contaspagar'])) {
                $this->db->set('data_contaspagar', 't');
            } else {
                $this->db->set('data_contaspagar', 'f');
            }
            if (isset($_POST['medico_laudodigitador'])) {
                $this->db->set('medico_laudodigitador', 't');
            } else {
                $this->db->set('medico_laudodigitador', 'f');
            }
            if (isset($_POST['chamar_consulta'])) {
                $this->db->set('chamar_consulta', 't');
            } else {
                $this->db->set('chamar_consulta', 'f');
            }
            if (isset($_POST['procedimentos_multiempresa'])) {
                $this->db->set('procedimento_multiempresa', 't');
            } else {
                $this->db->set('procedimento_multiempresa', 'f');
            }
            if (isset($_POST['consulta'])) {
                $this->db->set('consulta', 't');
            } else {
                $this->db->set('consulta', 'f');
            }
            if (isset($_POST['especialidade'])) {
                $this->db->set('especialidade', 't');
            } else {
                $this->db->set('especialidade', 'f');
            }
            if (isset($_POST['odontologia'])) {
                $this->db->set('odontologia', 't');
            } else {
                $this->db->set('odontologia', 'f');
            }
            if (isset($_POST['laboratorio'])) {
                $this->db->set('laboratorio', 't');
            } else {
                $this->db->set('laboratorio', 'f');
            }
            if (isset($_POST['geral'])) {
                $this->db->set('geral', 't');
            } else {
                $this->db->set('geral', 'f');
            }
            if (isset($_POST['faturamento'])) {
                $this->db->set('faturamento', 't');
            } else {
                $this->db->set('faturamento', 'f');
            }
            if (isset($_POST['estoque'])) {
                $this->db->set('estoque', 't');
            } else {
                $this->db->set('estoque', 'f');
            }
            if (isset($_POST['financeiro'])) {
                $this->db->set('financeiro', 't');
            } else {
                $this->db->set('financeiro', 'f');
            }
            if (isset($_POST['marketing'])) {
                $this->db->set('marketing', 't');
            } else {
                $this->db->set('marketing', 'f');
            }
            if (isset($_POST['internacao'])) {
                $this->db->set('internacao', 't');
            } else {
                $this->db->set('internacao', 'f');
            }
            if (isset($_POST['centro_cirurgico'])) {
                $this->db->set('centrocirurgico', 't');
            } else {
                $this->db->set('centrocirurgico', 'f');
            }
            if (isset($_POST['ponto'])) {
                $this->db->set('ponto', 't');
            } else {
                $this->db->set('ponto', 'f');
            }
            if (isset($_POST['calendario'])) {
                $this->db->set('calendario', 't');
            } else {
                $this->db->set('calendario', 'f');
            }
            if (isset($_POST['botao_faturar_guia'])) {
                $this->db->set('botao_faturar_guia', 't');
            } else {
                $this->db->set('botao_faturar_guia', 'f');
            }
            if (isset($_POST['botao_faturar_proc'])) {
                $this->db->set('botao_faturar_procedimento', 't');
            } else {
                $this->db->set('botao_faturar_procedimento', 'f');
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtempresaid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_empresa');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $empresa_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $empresa_id = $_POST['txtempresaid'];
                $this->db->where('empresa_id', $empresa_id);
                $this->db->update('tb_empresa');
            }
            return $empresa_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($empresa_id) {

        if ($empresa_id != 0) {
            $this->db->select('empresa_id, 
                               f.nome,
                               razao_social,
                               cnpj,
                               celular,
                               telefone,
                               email,
                               cep,
                               logradouro,
                               numero,
                               bairro,
                               cnes,
                               f.municipio_id,
                               c.nome as municipio,
                               c.estado,
                               cep,
                               consulta,
                               internacao,
                               centrocirurgico,
                               especialidade,
                               geral,
                               faturamento,
                               estoque,
                               chamar_consulta,
                               procedimento_multiempresa,
                               financeiro,
                               data_contaspagar,
                               medico_laudodigitador,
                               laboratorio,
                               ponto,
                               marketing,
                               imagem,
                               odontologia,
                               impressao_tipo,
                               impressao_laudo,
                               impressao_recibo,
                               impressao_declaracao,
                               calendario,
                               servicosms,
                               servicoemail,
                               chat,
                               botao_faturar_guia,
                               botao_faturar_procedimento');
            $this->db->from('tb_empresa f');
            $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
            $this->db->where("empresa_id", $empresa_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_empresa_id = $empresa_id;
            $this->_nome = $return[0]->nome;
            $this->_cnpj = $return[0]->cnpj;
            $this->_razao_social = $return[0]->razao_social;
            $this->_celular = $return[0]->celular;
            $this->_telefone = $return[0]->telefone;
            $this->_email = $return[0]->email;
            $this->_cep = $return[0]->cep;
            $this->_logradouro = $return[0]->logradouro;
            $this->_numero = $return[0]->numero;
            $this->_bairro = $return[0]->bairro;
            $this->_municipio_id = $return[0]->municipio_id;
            $this->_municipio = $return[0]->municipio;
            $this->_nome = $return[0]->nome;
            $this->_estado = $return[0]->estado;
            $this->_cep = $return[0]->cep;
            $this->_chat = $return[0]->chat;
            $this->_servicoemail = $return[0]->servicoemail;
            $this->_servicosms = $return[0]->servicosms;
            $this->_cnes = $return[0]->cnes;
            $this->_internacao = $return[0]->internacao;
            $this->_centro_cirurgico = $return[0]->centrocirurgico;
            $this->_consulta = $return[0]->consulta;
            $this->_especialidade = $return[0]->especialidade;
            $this->_odontologia = $return[0]->odontologia;
            $this->_geral = $return[0]->geral;
            $this->_faturamento = $return[0]->faturamento;
            $this->_estoque = $return[0]->estoque;
            $this->_financeiro = $return[0]->financeiro;
            $this->_marketing = $return[0]->marketing;
            $this->_imagem = $return[0]->imagem;
            $this->_laboratorio = $return[0]->laboratorio;
            $this->_ponto = $return[0]->ponto;
            $this->_impressao_tipo = $return[0]->impressao_tipo;
            $this->_impressao_laudo = $return[0]->impressao_laudo;
            $this->_impressao_declaracao = $return[0]->impressao_declaracao;
            $this->_impressao_recibo = $return[0]->impressao_recibo;
            $this->_calendario = $return[0]->calendario;
            $this->_botao_faturar_guia = $return[0]->botao_faturar_guia;
            $this->_data_contaspagar = $return[0]->data_contaspagar;
            $this->_medico_laudodigitador = $return[0]->medico_laudodigitador;
            $this->_botao_faturar_proc = $return[0]->botao_faturar_procedimento;
            $this->_chamar_consulta = $return[0]->chamar_consulta;
            $this->_procedimento_multiempresa = $return[0]->procedimento_multiempresa;
        } else {
            $this->_empresa_id = null;
        }
    }

}

?>
