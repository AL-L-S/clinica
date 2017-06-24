<?php

class App extends Controller {

    function App() {

        parent::Controller();
        $this->load->model('app_model', 'app');
    }

    function buscandoAgenda() {
        header('Access-Control-Allow-Origin: *');
        $result = $this->app->buscandoAgenda();

        if (count($result) > 0) {
            if (!isset($result["Erro"])) {
                foreach ($result as $item) {

                    if ($item->paciente == "" && $item->bloqueado == 't') {
                        $situacao = "bloqueado";
                    } else {
                        if ($item->realizada == 't' && $item->situacaoexame == 'EXECUTANDO') {
                            $situacao = "aguardando";
                        } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                            $situacao = "finalizado";
                        } elseif ($item->realizada == 't' && $item->situacaoexame == 'FINALIZADO') {
                            $situacao = "atendendo";
                        } elseif ($item->confirmado == 'f' && $item->paciente_id == null) {
                            $situacao = "vago";
                        } elseif ($item->confirmado == 'f' && $item->operador_atualizacao != null) {

                            date_default_timezone_set('America/Fortaleza');
                            $data_atual = date('Y-m-d');
                            $hora_atual = date('H:i:s');

                            if ($item->data < $data_atual && $item->paciente_id != null) {
                                $situacao = "faltou";
                            } elseif ($item->data < $data_atual && $item->paciente_id == null) {
                                $situacao = 'vago';
                            } else {
                                $situacao = "agendado";
                            }
                        } else {
                            $situacao = "aguardando";
                        }
                    }
                    
                    $paciente = '';
                    if($item->paciente != ''){
                        @$exp = explode(" ", $item->paciente);
                        $paciente = $exp[0] . " " . $exp[1];
                    }

                    $retorno['agenda_exames_id'] = $item->agenda_exames_id;
                    $retorno['paciente'] = $paciente;
                    $retorno['nomeCompleto'] = $item->paciente;
                    $retorno['data'] = date("d/m/Y", strtotime($item->data));
                    $retorno['inicio'] = date("H:i", strtotime($item->inicio));
                    $retorno['fim'] = date("H:i", strtotime($item->fim));
                    $retorno['situacao'] = $situacao;
                    $retorno['convenio'] = $item->convenio;
                    $retorno['procedimento'] = $item->procedimento;
                    $retorno['celular'] = $item->celular;
                    $retorno['observacoes'] = $item->observacoes;
                    $retorno['externoNome'] = '';
                    $retorno['externoId'] = '';
                    $var[] = $retorno;
                }
//        echo "<pre>"; var_dump($var);
            }
            
            die(json_encode(@$var));
        }
    }

    function validaUsuario() {
        header('Access-Control-Allow-Origin: *');

        if (isset($_GET['usuario']) && isset($_GET['pw'])) {
            $retorno = $this->app->validaUsuario();
            if (count($retorno) > 0) {
                $result = array(
                    "status" => "sucesso",
                    "hashSenha" => md5($_GET['pw'])
                );
            } else {
                $result = array(
                    "status" => "erro",
                    "motivo" => "Neste link não foi encontrado nenhum usuario com os dados informados!"
                );
            }
        } else {
            $result = array(
                "status" => "erro",
                "motivo" => "Nome de usuario ou senha em branco."
            );
        }

        die(json_encode($result));
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
