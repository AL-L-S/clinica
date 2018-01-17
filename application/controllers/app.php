<?php

class App extends Controller {

    function App() {

        parent::Controller();
        $this->load->model('app_model', 'app');
    }

    function buscandoAgenda() {
        header('Access-Control-Allow-Origin: *');
        $result = $this->app->buscandoAgenda();
        $resumo = array(
            "OK"        => 0,
            "LIVRE"     => 0,
            "BLOQUEADO" => 0,
            "FALTOU"    => 0,
            "TOTAL"    => 0,
        );
//        var_dump($result);die;
        if (count($result) > 0) {
            if (!isset($result["Erro"])) {
                foreach ($result as $item) {
                    
                    $situacao = $item->situacao;
                    
                    if ($item->paciente == "" && $item->bloqueado == 't') {
                        $status = "bloqueado";
                        $situacao = "BLOQUEADO";
                    } else {
                        if ($item->realizada == 't' && $item->situacaoexame == 'EXECUTANDO') {
                            $status = "aguardando";
                            $situacao = "OK";
                        } elseif ($item->realizada == 't' && $item->situacaolaudo == 'FINALIZADO') {
                            $status = "finalizado";
                            $situacao = "OK";
                        } elseif ($item->realizada == 't' && $item->situacaoexame == 'FINALIZADO') {
                            $status = "atendendo";
                            $situacao = "OK";
                        } elseif ($item->confirmado == 'f' && $item->paciente_id == null) {
                            
                            $status = "vago";
                            $situacao = "LIVRE";
                            
                        } elseif ($item->confirmado == 'f' && $item->operador_atualizacao != null) {

                            date_default_timezone_set('America/Fortaleza');
                            $data_atual = date('Y-m-d');
                            $hora_atual = date('H:i:s');

                            if ($item->data < $data_atual && $item->paciente_id != null) {
                                $status = "faltou";
                                $situacao = "FALTOU";
                            } elseif ($item->data < $data_atual && $item->paciente_id == null) {
                                $status = 'vago';
                                $situacao = "LIVRE";
                            } else {
                                $status = "agendado";
                                $situacao = "OK";
                            }
                        } else {
                            $status = "aguardando";
                            $situacao = "OK";
                        }
                    }
                    $paciente = '';
                    if($item->paciente != ''){
                        @$exp = explode(" ", $item->paciente);
                        foreach ($exp as $value) {
                            $paciente .= $value . " ";
                        }
                    }
//                    die;

                    $retorno['agenda_exames_id'] = $item->agenda_exames_id;
                    $retorno['paciente'] = $paciente;
                    $retorno['nomeCompleto'] = $item->paciente;
                    $retorno['data'] = date("d/m/Y", strtotime($item->data));
                    $retorno['inicio'] = date("H:i", strtotime($item->inicio));
                    $retorno['fim'] = date("H:i", strtotime($item->fim));
                    $retorno['situacao'] = $situacao;
                    $retorno['status'] = $status;
                    $retorno['convenio'] = $item->convenio;
                    $retorno['procedimento'] = $item->procedimento;
                    $retorno['celular'] = $item->celular;
                    $retorno['observacoes'] = $item->observacoes;
                    $retorno['externoNome'] = @$_GET['externoNome'];
                    $retorno['externoId'] = @$_GET['externoId'];
                    $var[] = $retorno;
                    
                    @$resumo[$situacao]++;
                    @$resumo['TOTAL']++;
                }
            }
            die(json_encode(array("agenda" => @$var, "resumo" => $resumo )));
        }
        
        die(json_encode(array("status" => "Nenhuma agenda encontrada!")));
    }

    function validaUsuario() {
        header('Access-Control-Allow-Origin: *');

        if (isset($_GET['usuario']) && isset($_GET['pw'])) {
            $retorno = $this->app->validaUsuario();
            if (count($retorno) > 0) {
                $result = array(
                    "status" => "sucesso",
                    "hashSenha" => md5($_GET['pw']),
                    "operador_id" => $retorno[0]->operador_id
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
    
    function confirmarAtendimento(){
        header('Access-Control-Allow-Origin: *');
        
        $retorno = $this->app->confirmarAtendimento();
        
        die ( json_encode( array("status" => "success") ) );
    }
    
    function listarLembretes(){
        header('Access-Control-Allow-Origin: *');
        $retorno = $this->app->listarLembretes();
           
        $var = array();
        foreach($retorno as $value){
            $var[] = array(
                "empresa_lembretes_id" => $value->empresa_lembretes_id,
                "remetente" => $value->remetente,
                "texto" => $value->texto,
                "data" => date("d/m/Y H:i", strtotime($value->data_cadastro) ),
                "visualizado" => $value->visualizado
            ); 
        }
        
        die ( json_encode( $var ) );
    }
  
    function buscarHistoricoPaciente(){
        header('Access-Control-Allow-Origin: *');
        $retorno = $this->app->buscarHistoricoPaciente();
           
        $var = array();
        foreach($retorno as $value){

            $data_atual = date('Y-m-d');
            $data1 = new DateTime($data_atual);
            $data2 = new DateTime($value->data);

            $intervalo = $data1->diff($data2);

            $var[] = array(
                "agenda_exames_id" => $value->agenda_exames_id,
                "inicio" => $value->inicio,
                "nome" => $value->nome,
                "data" => date("d/m/Y", strtotime($value->data) ),
                "intervalo" => $intervalo->days,
                "sala" => $value->sala,
                "medico_agenda" => $value->medico_agenda,
                "medico" => $value->medico,
                "convenio" => $value->convenio,
                "procedimento" => $value->procedimento,
                "observacoes" => $value->observacoes
            ); 
        }
        
        die ( json_encode( $var ) );
    }  
    
    function buscarLembreteNaoLido(){
        header('Access-Control-Allow-Origin: *');
        $retorno = $this->app->buscarLembreteNaoLido();
           
        $var = array();
        foreach($retorno as $value){
            $var[] = array(
                "operador" => $value->operador,
                "texto" => $value->texto
            ); 
        }
        
        die ( json_encode( $var ) );
    }
    
    function buscarQuantidadeAtendimentos(){
        header('Access-Control-Allow-Origin: *');
        
        $operador_id = $_GET['operador_id'];
        $retorno = $this->app->buscarQuantidadeAtendimentos($operador_id);
        
        $marcados = count($retorno);
        $confirmados = 0;
        
        $inicio = '';
        $medico = '';
        
        if( $marcados > 0 ){
            
            $inicio = substr($retorno[0]->inicio, 0, 5);
            $medico = $retorno[0]->medico;
            
            foreach($retorno as $value){
                if( $value->telefonema == 't') $confirmados ++;
            }
        }
        
        $result = array(
            "inicio" => $inicio,
            "medico" => $medico,
            "marcados" => $marcados,
            "confirmados" => $confirmados
        );
        
        die(json_encode($result));
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
