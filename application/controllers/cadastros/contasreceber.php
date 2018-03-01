<?php

require_once APPPATH . 'controllers/base/BaseController.php';

/**
 * Esta classe é o controler de Servifinanceiro_contasreceber_id. Responsável por chamar as funções e views, efetuando as chamadas de models
 * @author Equipe de desenvolvimento APH
 * @version 1.0
 * @copyright Prefeitura de Fortaleza
 * @access public
 * @package Model
 * @subpackage GIAH
 */
class Contasreceber extends BaseController {

    function Contasreceber() {
        parent::Controller();
        $this->load->model('cadastro/contasreceber_model', 'contasreceber');
        $this->load->model('cadastro/caixa_model', 'caixa');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->model('cadastro/tipo_model', 'tipo');
        $this->load->model('cadastro/classe_model', 'classe');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->library('mensagem');
        $this->load->library('utilitario');
        $this->load->library('pagination');
        $this->load->library('validation');
    }

    function index() {
        $this->pesquisar();
    }

    function pesquisar($args = array()) {

        $this->loadView('cadastros/contasreceber-lista', $args);

//            $this->carregarView($data);
    }

    function carregar($financeiro_contasreceber_id) {
        $obj_contasreceber = new contasreceber_model($financeiro_contasreceber_id);
        $data['obj'] = $obj_contasreceber;
        $data['conta'] = $this->forma->listarforma();
        $data['tipo'] = $this->tipo->listartipo();
        $data['classe'] = $this->classe->listarclasse();
        $this->loadView('cadastros/contasreceber-form', $data);
    }

    function carregarconfirmacao($financeiro_contasreceber_id) {
        $obj_contasreceber = new contasreceber_model($financeiro_contasreceber_id);
        $data['obj'] = $obj_contasreceber;
        $data['conta'] = $this->forma->listarforma();
        $data['tipo'] = $this->tipo->listartipo();
        $this->loadView('cadastros/contasreceberconfirmar-form', $data);
    }

    function excluir($financeiro_contasreceber_id) {
        $valida = $this->contasreceber->excluir($financeiro_contasreceber_id);
        if ($valida == 0) {
            $data['mensagem'] = 'Sucesso ao excluir a Contasreceber';
        } else {
            $data['mensagem'] = 'Erro ao excluir a contasreceber. Opera&ccedil;&atilde;o cancelada.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/contasreceber");
    }

    function formrelatorioemail($email_id, $tiporelatorio) {
        $data['email_id'] = $email_id;
        $data['tiporelatorio'] = $tiporelatorio;
        $this->loadView("ambulatorio/enviaremailcontasreceber-form", $data);
    }

    function enviaremail($email_id) {
        $relatorio = $_POST['tiporelatorio'];

        $msg = $this->caixa->listaremailmensagem($email_id);
        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = 'equipe2016gcjh@gmail.com';
        $config['smtp_pass'] = 'DUCOCOFRUTOPCE';
        $config['validate'] = TRUE;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";

        $this->email->initialize($config);
        $this->email->from('equipe2016gcjh@gmail.com', $_POST['seunome']);
        $this->email->to($_POST['destino1']);
        $this->email->subject($_POST['assunto']);
        $this->email->message($msg);
        if ($this->email->send()) {
            $data['mensagem'] = 'Email enviado com sucesso.';
        } else {
            $data['mensagem'] = 'Envio de Email malsucedido.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/contasreceber/$relatorio/");
    }
    
    function confirmarprevisaorecebimentoconvenio() {
        $this->contasreceber->confirmarprevisaorecebimentoconvenio();
        redirect(base_url() . "seguranca/operador/pesquisarrecepcao");
    }

    function relatoriocontasreceber() {
        $data['conta'] = $this->forma->listarforma();
        $data['credordevedor'] = $this->caixa->listarcredordevedor();
        $data['tipo'] = $this->tipo->listartipo();
//        $data['empresa'] = $this->guia->listarempresas();
        $this->loadView('cadastros/relatoriocontasreceber', $data);
    }

    function gerarelatoriocontasreceber() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $data['credordevedor'] = $this->caixa->buscarcredordevedor($_POST['credordevedor']);
        $data['tipo'] = $this->tipo->buscartipo($_POST['tipo']);
        $data['classe'] = $this->classe->buscarclasserelatorio($_POST['classe']);
        $data['forma'] = $this->forma->buscarforma($_POST['conta']);
//        $data['empresa'] = $this->guia->listarempresa($_POST['empresa']);

        $data['relatorio'] = $this->contasreceber->relatoriocontasreceber();
        
        if(@$_POST['previsao'] == 'SIM'){
            $data['relatorioconvenio'] = $this->contasreceber->relatorioprevisaoconveniocontasreceber();
        }
        else{
            $data['relatorioconvenio'] = array();
        }
        
        if ($_POST['email'] == "NAO") {
            $this->load->View('cadastros/impressaorelatoriocontasreceber', $data);
        } elseif ($_POST['email'] == "SIM") {

            if (count($data['tipo']) > 0) {
                $tipo = "TIPO:" . $data['tipo'][0]->descricao;
            } else {
                $tipo = "TODOS OS TIPOS";
            }
            if (count($data['classe']) > 0) {
                $texto = strtr(strtoupper($data['classe'][0]->descricao), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
                $classe = "CLASSE:" . $texto;
            } else {
                $classe = "TODAS AS CLASSES";
            }
            if (count($data['forma']) > 0) {
                $forma = "CONTA:" . $data['forma'][0]->descricao;
            } else {
                $forma = "TODAS AS CONTAS";
            }
            if (count($data['credordevedor']) > 0) {
                $credordevedor = $data['credordevedor'][0]->razao_social;
            } else {
                $credordevedor = "TODOS OS CREDORES";
            }

            $cabecalho = '<div class="content"> <!-- Inicio da DIV content -->

        <h4> ' . $tipo . ' </h4>
        <h4> ' . $classe . ' </h4>
        <h4>' . $forma . '</h4>
        <h4>' . $credordevedor . '</h4>
        <h4>RELATORIO DE SAIDA</h4>
    <h4>PERIODO: ' . $data['txtdata_inicio'] . ' ate ' . $data['txtdata_fim'] . '</h4>
    <hr>';

            if (count($data['relatorio']) > 0) {

                $corpo = '
        <table border="1">
            <thead>
                <tr>
                    <th width="100px;" class="tabela_header">Conta</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Tipo</th>
                    <th class="tabela_header">Classe</th>
                    <th class="tabela_header">Dt saida</th>
                    <th class="tabela_header">Valor</th>

                    <th class="tabela_header">Observacao</th>
                </tr>
            </thead>
            <tbody>';

                $total = 0;
                $corpo2 = '';
                $corpo3 = '';
                foreach ($data['relatorio'] as $item) :
                    $total = $total + $item->valor;
                    $corpo2 = $corpo2 . '
                    <tr>
                        <td >' . $item->conta . '</td>
                        <td >' . $item->razao_social . '</td>
                        <td >' . $item->tipo . '</td>
                        <td >' . $item->classe . '</td>
                        <td >' . substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4) . '</td>
                        <td >' . number_format($item->valor, 2, ",", ".") . '</td>
                        <td >' . $item->observacao . '</td>
                    </tr>';
                endforeach;
                $corpo3 = '<tr>
                    <td colspan="4"><b>TOTAL</b></td>
                    <td colspan="2"><b>' . number_format($total, 2, ",", ".") . '</b></td>
                </tr>
            </tbody>';

                $html = $cabecalho . $corpo . $corpo2 . $corpo3;
            }
            else {
                $corpo = '
                <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
                ';
                $html = $cabecalho . $corpo;
            }


//                    var_dump($html);
//            die;
            $tiporelatorio = 'relatoriocontasreceber';
            $email_id = $this->caixa->gravaremailmensagem($html);
            $this->formrelatorioemail($email_id, $tiporelatorio);
        }
    }

    function gravar() {
        $repetir = $_POST['repitir'];
        $dia = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['inicio'])));
        $parcela = 1;
        $contador = 0;
        $a = 0;
        $c = 0;
        if ($_POST['devedor'] == "") {
            $devedor_id = $this->contasreceber->gravardevedor();
        }
        else{
            $devedor_id = $_POST['devedor'];
        }
        if ($_POST['financeiro_contasreceber_id'] == '') {
//            if ($_POST['devedor'] == '') {
//                $mensagem = 'É necessário selecionar o item no campo Receber de: ';
//                $this->session->set_flashdata('message', $mensagem);
//                redirect(base_url() . "cadastros/contasreceber/carregar/0");
//            }
            if ($repetir == '' || $repetir == 1) {

                $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
            } elseif ($repetir >= 2) {
                if (date("d", strtotime($dia)) != 29 && date("d", strtotime($dia)) != 30 && date("d", strtotime($dia)) != 31) {
                    $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                } else {

                    if (date("d", strtotime($dia)) == 29) {
                        $contador = 29;
                    }
                    if (date("d", strtotime($dia)) == 30) {
                        $contador = 30;
                    }
                    if (date("d", strtotime($dia)) == 31) {
                        $contador = 30;
                        $dia = date('Y-m-d', strtotime("-1 day", strtotime($dia)));
                    }
                }

                for ($index = 2; $index <= $repetir; $index++) {
                    if ($contador == 29 || $contador == 30 || $contador == 31) {
                        if ($contador == 29) {
                            if (date("m", strtotime($dia)) == 01) {
                                $a ++;
                                if ($c == 0) {
                                    $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                                    $parcela++;
                                }
                                $dia = date('Y-m-d', strtotime("-1 day", strtotime($dia)));

                                $dia = date('Y-m-d', strtotime("+1 month", strtotime($dia)));

                                $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                            } elseif (date("m", strtotime($dia)) == 02) {
                                $dia = date('Y-m-d', strtotime("+1 month", strtotime($dia)));
                                $dia = date('Y-m-d', strtotime("+1 day", strtotime($dia)));

                                $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                            } else {
                                if ($a == 0) {
                                    $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                                    $parcela++;
                                }
                                $a++;
                                $c++;

                                $dia = date('Y-m-d', strtotime("+1 month", strtotime($dia)));
                                $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                            }
                            $parcela++;
                        } elseif ($contador == 30) {
                            if (date("m", strtotime($dia)) == 01) {
                                $a ++;
                                if ($c == 0) {
                                    $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                                    $parcela++;
                                }

                                $dia = date('Y-m-d', strtotime("-2 day", strtotime($dia)));

                                $dia = date('Y-m-d', strtotime("+1 month", strtotime($dia)));

                                $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                            } elseif (date("m", strtotime($dia)) == 02) {
                                $dia = date('Y-m-d', strtotime("+1 month", strtotime($dia)));
                                $dia = date('Y-m-d', strtotime("+2 day", strtotime($dia)));

                                $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                            } else {
                                if ($a == 0) {
//                                    var_dump($dia); die;
                                    $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                                    $parcela++;
                                }
                                $a++;
                                $c++;

                                $dia = date('Y-m-d', strtotime("+1 month", strtotime($dia)));
                                
                                $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                                
                            }
                            $parcela++;
                        }
                    } else {
                        $dia = date('Y-m-d', strtotime("+1 month", strtotime($dia)));
                        $parcela = $index;
                        $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
                    }
                }
            }
        } else {
            $financeiro_contasreceber_id = $this->contasreceber->gravar($dia, $parcela, $devedor_id);
        }
        if ($financeiro_contasreceber_id == "-1") {
            $data['mensagem'] = 'Erro ao gravar a Contas a recebr. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao gravar a Contas a recebr.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/contasreceber");
    }

    function confirmar() {
        $financeiro_contasreceber_id = $this->contasreceber->gravarconfirmacao();
        if ($financeiro_contasreceber_id == "-1") {
            $data['mensagem'] = 'Erro ao confirmar a Contas a recebr. Opera&ccedil;&atilde;o cancelada.';
        } else {
            $data['mensagem'] = 'Sucesso ao confirmar a Contas a recebr.';
        }
        $this->session->set_flashdata('message', $data['mensagem']);
        redirect(base_url() . "cadastros/contasreceber");
    }

    private function carregarView($data = null, $view = null) {
        if (!isset($data)) {
            $data['mensagem'] = '';
        }

        if ($this->utilitario->autorizar(2, $this->session->userdata('modulo')) == true) {
            $this->load->view('header', $data);
            if ($view != null) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('giah/servifinanceiro_contasreceber_id-lista', $data);
            }
        } else {
            $data['mensagem'] = $this->mensagem->getMensagem('login005');
            $this->load->view('header', $data);
            $this->load->view('home');
        }
        $this->load->view('footer');
    }

    function anexarimagemcontasareceber($financeiro_contasreceber_id) {
        if (!is_dir("./upload/contasareceber")) {
            mkdir("./upload/contasareceber");
            chmod("./upload/contasareceber", 0777);
        }

        $this->load->helper('directory');
        $data['arquivo_pasta'] = directory_map("./upload/contasareceber/$financeiro_contasreceber_id/");
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/consulta/$paciente_id/");
        if ($data['arquivo_pasta'] != false) {
            sort($data['arquivo_pasta']);
        }
        $data['financeiro_contasreceber_id'] = $financeiro_contasreceber_id;
        $this->loadView('cadastros/importacao-imagemcontasareceber', $data);
    }

    function importarimagemcontasareceber() {
        $financeiro_contasreceber_id = $_POST['paciente_id'];

        if (!is_dir("./upload/contasareceber")) {
            mkdir("./upload/contasareceber");
            chmod("./upload/contasareceber", 0777);
        }

        if (!is_dir("./upload/contasareceber/$financeiro_contasreceber_id")) {
            mkdir("./upload/contasareceber/$financeiro_contasreceber_id");
            $destino = "./upload/contasareceber/$financeiro_contasreceber_id";
            chmod($destino, 0777);
        }

//        $config['upload_path'] = "/home/vivi/projetos/clinica/upload/consulta/" . $paciente_id . "/";
        $config['upload_path'] = "./upload/contasareceber/" . $financeiro_contasreceber_id . "/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|zip|rar';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $error = null;
            $data = array('upload_data' => $this->upload->data());
        }
        $data['financeiro_contasreceber_id'] = $financeiro_contasreceber_id;
        $this->anexarimagemcontasareceber($financeiro_contasreceber_id);
    }

    function ecluirimagemcontasreceber($financeiro_contasreceber_id, $value) {
        unlink("./upload/contasareceber/$financeiro_contasreceber_id/$value");
        $this->anexarimagemcontasareceber($financeiro_contasreceber_id);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
