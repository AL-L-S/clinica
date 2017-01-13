<?php

require_once APPPATH . 'controllers/base/BaseController.php';

class Emergencia extends BaseController {

        function Emergencia() {
            parent::Controller();
            $this->load->model('emergencia/emergencia_model', 'emergencia_m');
            $this->load->library('mensagem');
            $this->load->library('utilitario');
            $this->load->library('pagination');
            $this->load->library('validation');
        }

        function index() {
            $this->pesquisar();

        }

        function pesquisar($args = array()) {

            $this->loadView('emergencia/emergencia-lista');
            
//            if (isset ($_POST['filtro']))
//            { $filtro = $_POST['filtro']; }
//            $maximo = 10;
//            $total = $this->emergencia_m->totalRegistros($filtro);
//            $config['base_url'] = base_url() . 'emergencia/emergencia/pesquisar/' . $filtro . '/';
//            $config['total_rows'] = $total;
//            $config['per_page'] = $maximo;
//            $config['uri_segment'] = 5;
//            $config['first_link'] = 'Primeiro';
//            $config['last_link'] = 'Último';
//            $config['next_link'] = 'Próximo';
//            $config['prev_link'] = 'Anterior';
//            $config['cur_tag_open'] = '<b>&nbsp;';
//            $config['cur_tag_close'] = '</b>';
//            $config['num_links'] = 1;
//            $this->pagination->initialize($config);
//            $data['paginacao'] = $this->pagination->create_links();
//            $data['total'] = $total;
//            $data['lista'] = $this->emergencia_m->listarFichas($filtro, $maximo, $inicio);
//            if ($filtro != -1) {
//                $data['filtro'] = $filtro;
//            } else {
//                $data['filtro'] = '';
//            };
//            $this->carregarView($data);
        }

        function novo () {

            $data['data'] = date('d:m:Y');
            $data['hora'] = date('H:i');
            $data['listaCenso']                                       = $this->emergencia_m->listarGrupoResposta(1);
            $data['listaTipo']                                        = $this->emergencia_m->listarGrupoResposta(2);
            $data['listaUrgencia']                                    = $this->emergencia_m->listarGrupoResposta(3);
            $data['listaViasAereas']                                 = $this->emergencia_m->listarGrupoResposta(4);
            $data['listaInfusaoDrogas']                              = $this->emergencia_m->listarGrupoResposta(5);
            $data['listaRenal']                                       = $this->emergencia_m->listarGrupoResposta(6);
            $data['listaSolicitacaoParecer']                      = $this->emergencia_m->listarGrupoResposta(7);
            $data['listaLeito']                                       = $this->emergencia_m->listarLeito();
            //$this->carregarView($data,'emergencia/emergencia-ficha');
            $this->loadView('emergencia/emergencia-ficha', $data);
        }

        function novaevolucao ($ficha) {

            $data['data'] = date('d:m:Y');
            $data['hora'] = date('H:i');
            $data['listaCenso']                                       = $this->emergencia_m->listarGrupoResposta(1);
            $data['listaTipo']                                        = $this->emergencia_m->listarGrupoResposta(2);
            $data['listaUrgencia']                                    = $this->emergencia_m->listarGrupoResposta(3);
            $data['listaViasAereas']                                 = $this->emergencia_m->listarGrupoResposta(4);
            $data['listaInfusaoDrogas']                              = $this->emergencia_m->listarGrupoResposta(5);
            $data['listaRenal']                                       = $this->emergencia_m->listarGrupoResposta(6);
            $data['listaSolicitacaoParecer']                      = $this->emergencia_m->listarGrupoResposta(7);
            $data['listaLeito']                                       = $this->emergencia_m->listarLeito();
            $data['ficha'] = $ficha;
            //$this->carregarView($data,'emergencia/evolucao-ficha');
            $this->loadView('emergencia/evolucao-ficha', $data);
        }

        function novaparecer ($solicitacao, $evolucao_id) {


            $data['data'] = date('d:m:Y');
            $data['hora'] = date('H:i');
            $data['conduta']     = $this->emergencia_m->listarGrupoResposta(10);
            $data['solicitacao'] = $solicitacao;
            $data['evolucao'] = $evolucao_id;
            //$this->carregarView($data,'emergencia/emergencia-parecer');
            $this->loadView('emergencia/emergencia-parecer', $data);

        }

        function relatorioparecer ($evolucao_id, $parecer_id){

            //$this->load-> plugin('to_pdf_pi');
            $data['lista'] = $this->emergencia_m->relatorioParecer($evolucao_id, $parecer_id);

            $this->load->view('emergencia/relatorio-parecer', $data);
        }

        function relatorioevolucao ($evolucao_id){

            $this->load-> plugin('to_pdf_pi');
            $data['lista'] = $this->emergencia_m->relatorioEvolucao($evolucao_id);

            
            $this->load->view('emergencia/relatorio-evolucao', $data);
        }

        function pesquisarparecer($evolucao_id) {

            $data['lista'] = $this->emergencia_m->listaParecer($evolucao_id);
            //$this->carregarView($data,'emergencia/emergencia-lista-parecer');
            $this->loadView('emergencia/emergencia-lista-parecer', $data);
        }

        function pesquisarsoliciataparecer($filtro=-1) {
            if (isset ($_POST['filtro']))
            { $filtro = $_POST['filtro']; }
            $data['lista'] = $this->emergencia_m->listarSolicitacoesParecer($filtro);

            //$this->carregarView($data,'emergencia/emergencia-lista-solicitacaoparecer');
            $this->loadView('emergencia/emergencia-lista-solicitacaoparecer', $data);
        }



        function pesquisarsoliciatacirurgia($filtro=-1) {
            if (isset ($_POST['filtro']))
            { $filtro = $_POST['filtro']; }
            $data['lista'] = $this->emergencia_m->listarSolicitacoesCirurgia($filtro);
            //$this->carregarView($data,'emergencia/emergencia-lista-solicitacaocirurgia');
            $this->loadView('emergencia/emergencia-lista-solicitacaocirurgia', $data);
        }

        function pesquisarsoliciatatomografia($filtro=-1) {
            if (isset ($_POST['filtro']))
            { $filtro = $_POST['filtro']; }
            $data['lista'] = $this->emergencia_m->listarSolicitacoesTomografia();
            //$this->carregarView($data,'emergencia/emergencia-lista-solicitacaotomografia');
            $this->loadView('emergencia/emergencia-lista-solicitacaotomografia', $data);
        }



//        function  evolucao($ficha_id){
//            $data['ficha'] = new emergencia_model($ficha_id);
//            $data['listaEvolucao']              = $this->emergencia_m->listarGrupoResposta(16);
//            $data['lista']              = $this->emergencia_m->listarevolucao($ficha_id);
//            $this->carregarView($data,'emergencia/emergencia-ficha');
//        }

        function gravar() {
            
            $ficha_id = $this->emergencia_m->gravarFicha();
            
            $evolucao_id = $this->emergencia_m->gravarEvolucao($ficha_id);
            
            if( $_POST['txtInfusaoDrogas'] != ""){

                
                    if ($this->emergencia_m->gravarResposta($ficha_id, $evolucao_id))
                    {$data['mensagem'] = 'Ficha de notifica&ccedil;&atilde;o cadastrada com sucesso.';}

                    else{$data['mensagem'] = 'Erro ao cadastrar ficha de notifica&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.';}

            }
           if( $_POST['parecer'] != ""){
               
                    if ($this->emergencia_m->gravarRespostaSolicitacaoParecer($ficha_id, $evolucao_id))
                    {$data['mensagem'] = 'Ficha de notifica&ccedil;&atilde;o cadastrada com sucesso.'; }
                    else
                    {$data['mensagem'] = 'Erro ao cadastrar ficha de notifica&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.'; }
           }
            $data['lista']               = $this->emergencia_m->listarFichas();
//            $this->pesquisar();
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."emergencia/emergencia",$data);
        }

        function gravarparecer() {

            if ($this->emergencia_m->gravarParecer())
                {$data['mensagem'] = 'Parecer cadastrado com sucesso.'; }
            else
                {$data['mensagem'] = 'Erro ao cadastrar parecer . Opera&ccedil;&atilde;o cancelada.'; }
            $data['lista'] = $this->emergencia_m->listarSolicitacoesParecer();
            //$this->carregarView($data,'emergencia/emergencia-lista-solicitacaoparecer');
//            $this->loadView('emergencia/emergencia-lista-solicitacaoparecer', $data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."emergencia/emergencia/pesquisarsoliciataparecer",$data);
        }

        function cirurgiasaidafila($cirurgia_id) {
            $data['condutacirurgia'] = $this->emergencia_m->listarGrupoResposta(11);
            $data['redehospitalar'] = $this->emergencia_m->listarGrupoResposta(12);
            $data['cirurgia'] = $cirurgia_id;
            //$this->carregarView($data,'emergencia/emergencia-listacirurgia-saida');
            $this->loadView('emergencia/emergencia-listacirurgia-saida', $data);
        }

        function cirurgiaatendida() {

            if ($this->emergencia_m->saidaCirurgia())
                {$data['mensagem'] = 'Cirurgia atendida com sucesso.'; }
            else
                {$data['mensagem'] = 'Erro ao atender a cirurgia . Opera&ccedil;&atilde;o cancelada.'; }
            $data['lista'] = $this->emergencia_m->listarSolicitacoesCirurgia();
            //$this->carregarView($data,'emergencia/emergencia-lista-solicitacaocirurgia');
//            $this->loadView('emergencia/emergencia-lista-solicitacaocirurgia', $data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."emergencia/emergencia/pesquisarsoliciatacirurgia",$data);
        }
        
        function adiamentoparecer($solicitacao_id) {
            
            $data['solicitacao'] = $solicitacao_id;
            //$this->carregarView($data,'emergencia/emergencia-listaparecer-adiamento');
            $this->loadView('emergencia/emergencia-listaparecer-adiamento', $data);
        }

        function prioridadeparecer() {

            if ($this->emergencia_m->prioridadeparecer())
                {$data['mensagem'] = 'Prioridade modificada com sucesso.'; }
            else
                {$data['mensagem'] = 'Erro ao modificar prioridade . Opera&ccedil;&atilde;o cancelada.'; }
            $data['lista'] = $this->emergencia_m->listarSolicitacoesParecer();
            //$this->carregarView($data,'emergencia/emergencia-lista-solicitacaoparecer');
//            $this->loadView('emergencia/emergencia-lista-solicitacaoparecer', $data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."emergencia/emergencia/pesquisarsoliciataparecer",$data);
        }

        function adiamentotomografia($tomografia_id) {

            $data['tomografia'] = $tomografia_id;
            //$this->carregarView($data,'emergencia/emergencia-listatomografia-adiamento');
            $this->loadView('emergencia/emergencia-listatomografia-adiamento', $data);
        }

        function prioridadetomografia() {

            if ($this->emergencia_m->prioridadetomografia())
                {$data['mensagem'] = 'Prioridade modificada com sucesso.'; }
            else
                {$data['mensagem'] = 'Erro ao modificar prioridade . Opera&ccedil;&atilde;o cancelada.'; }
            $data['lista'] = $this->emergencia_m->listarSolicitacoesTomografia();
            //$this->carregarView($data,'emergencia/emergencia-lista-solicitacaotomografia');
//            $this->loadView('emergencia/emergencia-lista-solicitacaotomografia', $data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."emergencia/emergencia/pesquisarsoliciatatomografia",$data);
        }

        function tomografiaatendida($tomografia_id) {

            if ($this->emergencia_m->gravarTomografia($tomografia_id))
                {$data['mensagem'] = 'Tomografia atendida com sucesso.'; }
            else
                {$data['mensagem'] = 'Erro ao atender tomografia . Opera&ccedil;&atilde;o cancelada.'; }
            $data['lista'] = $this->emergencia_m->listarSolicitacoesTomografia();
            //$this->carregarView($data,'emergencia/emergencia-lista-solicitacaotomografia');
//            $this->loadView('emergencia/emergencia-lista-solicitacaotomografia', $data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."emergencia/emergencia/pesquisarsoliciatatomografia",$data);
        }

        function gravarevolucao($ficha_id) {

            $evolucao_id = $this->emergencia_m->gravarEvolucao($ficha_id);
            if( $_POST['txtInfusaoDrogas'] != ""){


                    if ($this->emergencia_m->gravarResposta($ficha_id, $evolucao_id))
                    {$data['mensagem'] = 'Evolu&ccedil;&atilde;o cadastrada com sucesso.';}

                    else{$data['mensagem'] = 'Erro ao cadastrar Evolu&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.';}

            }
           if( $_POST['parecer'] != ""){

                    if ($this->emergencia_m->gravarRespostaSolicitacaoParecer($ficha_id, $evolucao_id))
                    {$data['mensagem'] = 'Evolu&ccedil;&atilde;o cadastrada com sucesso.'; }
                    else
                    {$data['mensagem'] = 'Erro ao cadastrar Evolu&ccedil;&atilde;o . Opera&ccedil;&atilde;o cancelada.'; }
           }
            $data['lista'] = $this->emergencia_m->listarEvolucao($ficha_id);
            $data['ficha'] = $ficha_id;
            //$this->carregarView($data, 'emergencia/emergencia-lista-evolucao');
//            $this->loadView('emergencia/emergencia-lista-evolucao', $data);
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url()."emergencia/emergencia/pesquisarevolucao/$ficha_id",$data);
        }

        function pesquisarevolucao($ficha_id) {
                
                //$data['ficha'] = new emergencia_model($ficha_id);
                $data['lista'] = $this->emergencia_m->listarEvolucao($ficha_id);
                $data['ficha'] = $ficha_id;
                //$this->carregarView($data, 'emergencia/emergencia-lista-evolucao');
                $this->loadView('emergencia/emergencia-lista-evolucao', $data);
        }

        /* Métodos privados */
        private function carregarView($data=null, $view=null){
            

            if (!isset ($data)) { $data['mensagem'] = ''; }

            if ($this->utilitario->autorizar(19, $this->session->userdata('modulo')) == true)
            {
                $this->load->view('header', $data);
                if ($view != null) {
                    $this->load->view($view, $data);
                } else {
                    $this->load->view('emergencia/emergencia-lista', $data);
                }
            } else {
                $data['mensagem'] = $this->mensagem->getMensagem('login005');
                $this->load->view('header', $data);
                $this->load->view('home');
            }
            $this->load->view('footer');
        }


}