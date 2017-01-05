<?php

class Autocomplete extends Controller {

    function Autocomplete() {

        parent::Controller();
        $this->load->model('ponto/funcao_model', 'funcao');
        $this->load->model('ponto/funcionario_model', 'funcionario');
        $this->load->model('ponto/ocorrenciatipo_model', 'ocorrenciatipo');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('estoque/fornecedor_model', 'fornecedor_m');
        $this->load->model('estoque/produto_model', 'produto_m');
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('ponto/cargo_model', 'cargo');
        $this->load->model('ponto/setor_model', 'setor');
        $this->load->model('cadastro/paciente_model', 'paciente_m');
        $this->load->model('cadastro/contaspagar_model', 'contaspagar');
        $this->load->model('cadastro/classe_model', 'financeiro_classe');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('emergencia/solicita_acolhimento_model', 'solicita_acolhimento_m');
        $this->load->model('internacao/internacao_model', 'internacao_m');
        $this->load->model('internacao/unidade_model', 'unidade_m');
        $this->load->model('internacao/enfermaria_model', 'enfermaria_m');
        $this->load->model('internacao/leito_model', 'leito_m');
        $this->load->model('ponto/horariostipo_model', 'horariostipo');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('cadastro/classe_model', 'financeiro_classe');
        $this->load->model('estoque/menu_model', 'menu');
        $this->load->model('centrocirurgico/centrocirurgico_model', 'centrocirurgico');
    }

    function index() {
        
    }

    function horariosambulatorio() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletehorarios($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompletehorarios();
        }
        echo json_encode($result);
    }

    function unidadeleito() {

        if (isset($_GET['unidade'])) {
            $result = $this->internacao_m->listaleitointarnacao($_GET['unidade']);
        } else {
            $result = $this->internacao_m->listaleitointarnacao();
        }
        echo json_encode($result);
    }

    function horariosambulatorioconsulta() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosconsulta($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosconsulta();
        }
        echo json_encode($result);
    }

    function horariosambulatoriogeral() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosgeral($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosgeral();
        }
        echo json_encode($result);
    }

    function procedimentoproduto() {

        if (isset($_GET['procedimento'])) {
            $result = $this->procedimento->listarprocedimentoautocomplete($_GET['procedimento']);
        } else {
            $result = $this->procedimento->listarprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoconveniocirurgia() {

        if (isset($_GET['procedimento'])) {
            $result = $this->procedimento->listarprocedimentocirurgiaautocomplete($_GET['procedimento']);
        } else {
            $result = $this->procedimento->listarprocedimentocirurgiaautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->procedimento_convenio_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function centrocirurgicomedicos() {
//        var_dump(123);die;

        if (isset($_GET['term'])) {
            $result = $this->centrocirurgico->listarmedicocirurgiaautocomplete($_GET['term']);
        } else {
            $result = $this->centrocirurgico->listarmedicocirurgiaautocomplete();
        }
        foreach ($result as $item) {
            $retorno['nome'] = $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoconveniomedico() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedico($_GET['convenio1'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedico();
        }
        echo json_encode($result);
    }

    function conveniopaciente() {
        if (isset($_GET['txtNomeid'])) {
            $result = $this->exametemp->listarautocompleteconveniopaciente($_GET['txtNomeid']);
        } else {
            $result = $this->exametemp->listarautocompleteconveniopaciente();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function classeportiposaidalista() {
        if (isset($_GET['nome'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaida($_GET['nome']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaida();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos11() {

        if (isset($_GET['convenio11'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio11']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos12() {

        if (isset($_GET['convenio12'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio12']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos13() {

        if (isset($_GET['convenio13'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio13']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos14() {

        if (isset($_GET['convenio14'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio14']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos15() {

        if (isset($_GET['convenio15'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio15']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioajustarvalor() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosajustarvalor($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosajustarvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniogrupo() {

        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupo($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupo();
        }
        echo json_encode($result);
    }

    function procedimentoporconvenio() {

        if (isset($_GET['covenio'])) {
            $result = $this->procedimentoplano->listarautocompleteprocedimentos($_GET['covenio']);
        } else {
            $result = $this->procedimentoplano->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function estoqueclasseportipo() {

        if (isset($_GET['tipo_id'])) {
            $result = $this->menu->listarautocompleteclasseportipo($_GET['tipo_id']);
        } else {
            $result = $this->menu->listarautocompleteclasseportipo();
        }
        echo json_encode($result);
    }

    function estoquesubclasseporclasse() {

        if (isset($_GET['classe_id'])) {
            $result = $this->menu->listarautocompletesubclasseporclasse($_GET['classe_id']);
        } else {
            $result = $this->menu->listarautocompletesubclasseporclasse();
        }
        echo json_encode($result);
    }

    function estoqueprodutosporsubclasse() {

        if (isset($_GET['subclasse_id'])) {
            $result = $this->menu->listarautocompleteprodutosporsubclasse($_GET['subclasse_id']);
        } else {
            $result = $this->menu->listarautocompleteprodutosporsubclasse();
        }
        echo json_encode($result);
    }

    function formapagamento($forma) {

        if (isset($forma)) {
            $result = $this->formapagamento->buscarforma($forma);
        } else {
            $result = $this->formapagamento->buscarforma();
        }
        echo json_encode($result);
    }

    function classeportipo() {

        if (isset($_GET['tipo'])) {
            $result = $this->financeiro_classe->listarautocompleteclasse($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclasse();
        }
        echo json_encode($result);
    }

    function classeportiposaida() {

        if (isset($_GET['tipo'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaida($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaida();
        }
        echo json_encode($result);
    }

    function medicoconvenio() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio1() {

        if (isset($_GET['medico_id1'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id1']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio2() {

        if (isset($_GET['medico_id2'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id2']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio3() {

        if (isset($_GET['medico_id3'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id3']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio4() {

        if (isset($_GET['medico_id4'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id4']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio5() {

        if (isset($_GET['medico_id5'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id5']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio6() {

        if (isset($_GET['medico_id6'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id6']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio7() {

        if (isset($_GET['medico_id7'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id7']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio8() {

        if (isset($_GET['medico_id8'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id8']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio9() {

        if (isset($_GET['medico_id9'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id9']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio10() {

        if (isset($_GET['medico_id10'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id10']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio11() {

        if (isset($_GET['medico_id11'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id11']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio12() {

        if (isset($_GET['medico_id12'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id12']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio13() {

        if (isset($_GET['medico_id13'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id13']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio14() {

        if (isset($_GET['medico_id14'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id14']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio15() {

        if (isset($_GET['medico_id15'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id15']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function procedimentoformapagamento() {

        if (isset($_GET['txtpagamento'])) {
            $result = $this->procedimentoplano->listarautocompleteformapagamento($_GET['txtpagamento']);
        } else {
            $result = $this->procedimentoplano->listarautocompleteformapagamento();
        }
//        var_dump($result); die;
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->forma_pagamento_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoconvenioconsulta() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofisioterapia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfisioterapia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfisioterapia();
        }
        echo json_encode($result);
    }

    function procedimentoconveniopsicologia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentospsicologia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentospsicologia();
        }
        echo json_encode($result);
    }

    function procedimentovalor() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia11() {

        if (isset($_GET['procedimento11'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento11']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia12() {

        if (isset($_GET['procedimento12'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento12']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia13() {

        if (isset($_GET['procedimento13'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento13']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia14() {

        if (isset($_GET['procedimento14'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento14']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia15() {

        if (isset($_GET['procedimento15'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento15']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorpsicologia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento1() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function credordevedor() {

        if (isset($_GET['term'])) {
            $result = $this->contaspagar->listarautocompletecredro($_GET['term']);
        } else {
            $result = $this->contaspagar->listarautocompletecredro();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->razao_social;
            $retorno['id'] = $item->financeiro_credor_devedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function modeloslaudo() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosdeclaracao() {

        if (isset($_GET['modelo'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosdeclaracao($_GET['modelo']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosdeclaracao();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosreceita() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosreceita($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosreceita();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosatestado() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosatestado($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosatestado();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelossolicitarexames() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelossolicitarexames($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelossolicitarexames();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function medicamentounidade() {

        if (isset($_GET['unidade'])) {
            $result = $this->exametemp->listarautocompletemedicamentounidade($_GET['unidade']);
        } else {
            $result = $this->exametemp->listarautocompletemedicamentounidade();
        }
        foreach ($result as $item) {
            $retorno['id'] = $item->unidade_id;
            $retorno['value'] = $item->descricao;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function modelosreceitaespecial() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosreceitaespecial($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosreceitaespecial();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modeloslinhas() {

        if (isset($_GET['linha'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletelinha($_GET['linha']);
        } else {
            $result = $this->exametemp->listarautocompletelinha();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function medicoespecialidadetodos() {

        if (isset($_GET['txtcbo'])) {
            $result = $this->operador_m->listarmedicos($_GET['txtcbo']);
        } else {
            $result = $this->operador_m->listarmedicos();
        }


        echo json_encode($result);
    }

    function medicoespecialidade() {

        if (isset($_GET['txtcbo'])) {
            $result = $this->exametemp->listarautocompletemedicoespecialidade($_GET['txtcbo']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoespecialidade();
        }


        echo json_encode($result);
    }

    function cboprofissionaismultifuncao() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listacboprofissionaisautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->cbo_ocupacao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function linhas() {

        if (isset($_GET['term'])) {
            $result = $this->exametemp->listarautocompletelinha($_GET['term']);
        } else {
            $result = $this->exametemp->listarautocompletelinha();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . '-' . $item->texto;
            $retorno['id'] = $item->texto;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicamentolaudo() {

        if (isset($_GET['term'])) {
            $result = $this->exametemp->listarautocompletemedicamentolaudo($_GET['term']);
        } else {
            $result = $this->exametemp->listarautocompletemedicamentolaudo();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' (' . $item->quantidade . ' - ' . $item->descricao . ') -> ' . $item->posologia;
            $retorno['id'] = $item->texto . '<br>' . $item->posologia;
            $retorno['qtde'] = $item->quantidade;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function modeloslaudos() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function laudosanteriores() {

        if (isset($_GET['anteriores'])) {

            $result = $this->laudo->listarautocompletelaudos($_GET['anteriores']);
        } else {
            $result = $this->laudo->listarautocompletelaudos();
        }
        echo json_encode($result);
    }

    function cidade() {

        if (isset($_GET['term'])) {
            $result = $this->paciente_m->listarCidades($_GET['term']);
        } else {
            $result = $this->paciente_m->listarCidades();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->estado;
            $retorno['id'] = $item->municipio_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function produto() {

        if (isset($_GET['term'])) {
            $result = $this->produto_m->autocompleteproduto($_GET['term']);
        } else {
            $result = $this->produto_m->autocompleteproduto();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->estoque_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function fornecedor() {

        if (isset($_GET['term'])) {
            $result = $this->fornecedor_m->autocompletefornecedor($_GET['term']);
        } else {
            $result = $this->fornecedor_m->autocompletefornecedor();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->fantasia;
            $retorno['id'] = $item->estoque_fornecedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentotuss() {

        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarautocompletetuss($_GET['term']);
        } else {
            $result = $this->procedimento->listarautocompletetuss();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->codigo . ' - ' . $item->descricao . ' - ' . $item->ans;
            $retorno['id'] = $item->tuss_id;
            $retorno['codigo'] = $item->codigo;
            $retorno['descricao'] = $item->descricao . ' - ' . $item->ans;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cbo() {

        if (isset($_GET['term'])) {
            $result = $this->operador_m->listarcbo($_GET['term']);
        } else {
            $result = $this->operador_m->listarcbo();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->cbo_grupo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cargo() {
        if (isset($_GET['term'])) {
            $result = $this->cargo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->cargo->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->cargo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function motivo_atendimento() {
        if (isset($_GET['term'])) {
            $result = $this->solicita_acolhimento_m->listamotivoautocomplete($_GET['term']);
        } else {
            $result = $this->solicita_acolhimento_m->listamotivoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->emergencia_motivoatendimento_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicosaida() {
        if (isset($_GET['term'])) {
            $result = $this->solicita_acolhimento_m->listarmedicosaida($_GET['term']);
        } else {
            $result = $this->solicita_acolhimento_m->listarmedicosaida();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicos() {
        if (isset($_GET['term'])) {
            $result = $this->guia->listarmedicos($_GET['term']);
        } else {
            $result = $this->guia->listarmedicos();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientes() {
        if (isset($_GET['term'])) {
            $result = $this->guia->listarpacientes($_GET['term']);
        } else {
            $result = $this->guia->listarpacientes();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->paciente_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function funcao() {
        if (isset($_GET['term'])) {
            $result = $this->funcao->listarautocomplete($_GET['term']);
        } else {
            $result = $this->funcao->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->funcao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function ocorrenciatipo() {
        if (isset($_GET['term'])) {
            $result = $this->ocorrenciatipo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->ocorrenciatipo->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->ocorrenciatipo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function setor() {
        if (isset($_GET['term'])) {
            $result = $this->setor->listarautocomplete($_GET['term']);
        } else {
            $result = $this->setor->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->setor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function horariostipo() {
        if (isset($_GET['term'])) {
            $result = $this->horariostipo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->horariostipo->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->horariostipo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function funcionario() {
        if (isset($_GET['term'])) {
            $result = $this->funcionario->listarautocomplete($_GET['term']);
        } else {
            $result = $this->funcionario->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->funcionario_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function unidade() {
        if (isset($_GET['term'])) {
            $result = $this->unidade_m->listaunidadeautocomplete($_GET['term']);
        } else {
            $result = $this->unidade_m->listaunidadeautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->internacao_unidade_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function operador() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listaoperadorautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listaoperadorautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cboprofissionais() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listacboprofissionaisautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->cbo_ocupacao_id . '-' . $item->descricao;
            $retorno['id'] = $item->cbo_ocupacao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function paciente() {
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepaciente($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepaciente();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientenascimento() {
//        if (isset($_GET['term'])) {
//            $result = $this->exame->listarautocompletepacientenascimento($_GET['term']);
//        } else {
//            $result = $this->exame->listarautocompletepacientenascimento();
//        }
//        foreach ($result as $item) {
//            $retorno['value'] = $item->nome;
//            $retorno['itens'] = $item->telefone;
//            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
//            $retorno['id'] = $item->paciente_id;
//            $var[] = $retorno;
//        }
//        echo json_encode($var);
        echo json_encode('olaolaoa');
    }

    function cid1() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listacidautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->co_cid . '-' . $item->no_cid;
            $retorno['id'] = $item->co_cid;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cid2() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listacidautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->co_cid . '-' . $item->no_cid;
            $retorno['id'] = $item->co_cid;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimento() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listaprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listaprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->procedimento . '-' . $item->descricao;
            $retorno['id'] = $item->procedimento;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function enfermaria() {

        if (isset($_GET['term'])) {
            $result = $this->enfermaria_m->listaenfermariaautocomplete($_GET['term']);
        } else {
            $result = $this->enfermaria_m->listaenfermariaautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->unidade;
            $retorno['id'] = $item->internacao_enfermaria_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function leito() {

        if (isset($_GET['term'])) {
            $result = $this->leito_m->listaleitoautocomplete($_GET['term']);
        } else {
            $result = $this->leito_m->listaleitoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->enfermaria . ' - ' . $item->unidade;
            $retorno['id'] = $item->internacao_leito_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
