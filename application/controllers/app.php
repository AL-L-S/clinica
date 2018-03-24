<?php

class App extends Controller {

    function App() {

        parent::Controller();
        $this->load->model('app_model', 'app');
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('ambulatorio/exame_model', 'exame');
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
    
    function criarArquivosLaudoProImagem(){
        $this->load->helper('directory');
        $arquivo_pasta = directory_map("./upload/laudo/UNIMED UBERLANDIA/");
        $array = array();
        
        foreach($arquivo_pasta as $key => $value){
            $array[] = $key;
        }
        
        $string = implode(',', $array);
        $dados = $this->app->listarLaudosNaoCriados($string);
//        echo "<pre>";
//        var_dump($dados); die;
        foreach ($dados as $value) {
            $this->gerarxmlsalvar($value->ambulatorio_laudo_id, $value->exame_id, $value->sala_id);
//            sleep(0.85);
            
        }
//        $this->gerarxmlsalvar(268115, 271699, 26);
    }
    
    
    function gerarxmlsalvar($ambulatorio_laudo_id, $exame_id, $sala_id) {
        $this->load->plugin('mpdf');
//        var_dump($ambulatorio_laudo_id, $exame_id, $sala_id); die;
        $listarexame = $this->laudo->listarxmlsalvar($ambulatorio_laudo_id, $exame_id, $sala_id);
//        var_dump($listarexame); die;
        if (count($listarexame) > 0) {
            $empresa = $this->exame->listarcnpj();

            $convenio = $listarexame[0]->convenio;

            $origem = "./upload/laudo";

            if (!is_dir($origem)) {
                mkdir($origem);
                chmod($origem, 0777);
            }
            if (!is_dir($origem . '/' . $convenio)) {
                mkdir($origem . '/' . $convenio);
                chmod($origem . '/' . $convenio, 0777);
            }


            $tipo_xml = $this->laudo->listarempresatipoxml(); //verifica qual tipo de xml que a empresa usa.   
            $impressao_tipo = $tipo_xml[0]->impressao_tipo;
            if ($tipo_xml[0]->nome == 'TIPO 1') {

                $corpo = "";
                $paciente_dif = "";

                if ($impressao_tipo == 2) {
                    foreach ($listarexame as $item) {
                        

                        if ($item->paciente_id !== $paciente_dif) {
                            
                            $data_atual = date('Y-m-d');
                            $data1 = new DateTime($data_atual);
                            $data2 = new DateTime($item->nascimento);
                            $intervalo = $data1->diff($data2);
                            $teste = $intervalo->y;
                            
                            $sl_cod_doc = $item->ambulatorio_laudo_id;
                            if (!is_dir($origem . '/' . $convenio)) {
                                mkdir($origem . '/' . $convenio);
                                chmod($origem . '/' . $convenio, 0777);
                            }
//                            if (!is_dir($origem . '/' . $convenio . '/' . $sl_cod_doc)) {
//                                mkdir($origem . '/' . $convenio . '/' . $sl_cod_doc);
//                                chmod($origem . '/' . $convenio . '/' . $sl_cod_doc, 0777);
//                            }
                            $texto = "";

                            //NUMERO DA CARTEIRA
                            if ($item->convenionumero == '') {
                                $numerodacarteira = '0000000';
                            } else {
                                $numerodacarteira = $item->convenionumero;
                            }

                            //NUMERO GUIA CONVENIO  
                            if ($item->guiaconvenio == '') {
                                $numeroguia = '0000000';
                            } else {
                                $numeroguia = $item->guiaconvenio;
                            }

                            $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
                      <S_LINE>
                      <SL_TIPO>RP</SL_TIPO>
                      <SL_TITULO>" . $item->paciente . "-" . $item->nascimento . "</SL_TITULO>
                      <SL_SN>O</SL_SN>
                      <SL_CHAVE></SL_CHAVE>
                      <SL_SENHA></SL_SENHA>                      
                      <SL_COD_DOC>" . $sl_cod_doc . "</SL_COD_DOC>                      
                      <SL_FORMATO>PDF</SL_FORMATO>
                      <SL_DATA_REALIZACAO>" . substr($item->data_realizacao, 0, 10) . "T" . substr($item->data_realizacao, 10, 18) . " </SL_DATA_REALIZACAO>
                        <SL_OPER>
                           <OPER_REGANS>$item->registroans</OPER_REGANS>
                           <OPER_NUMCARTEIRA>" . $numerodacarteira . "</OPER_NUMCARTEIRA>
                           <OPER_NUMGUIA>" . $numeroguia . "
                                ";
                            //   este foreach irá inserir todos os códigos dos exames relacionados ao numeroguia 
                            foreach ($listarexame as $value) {
                                $corpo = $corpo . "<OPER_EXAME>" . $value->codigo . "</OPER_EXAME>";
                                $texto = $texto . $value->texto;
                            }
                            // matriz de entrada
                            $what = array('&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;', '&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;', '&Acirc;');

                            // matriz de saída
                            $by = array('A', '', '');

                            $saida = strip_tags($texto);
                            $saida = str_replace($what, $by, $saida);
//                            $saida = utf8_encode($saida);
//                            echo $saida;
//                            die;
                            $fim_numguia = "</OPER_NUMGUIA>";

                            $rodape = "</SL_OPER>
                       <SL_TEXTO>$saida</SL_TEXTO>
                    </S_LINE>";
                            $nome = "./upload/laudo/" . $convenio . "/" . $sl_cod_doc . ".xml";
                            $xml = $cabecalho . $corpo . $fim_numguia . $rodape;
                            $fp = fopen($nome, "w+");
                            fwrite($fp, $xml . "\n");
                            fclose($fp);
                            $arquivo = '';


                            $cabecalho = "<table>
    <tr>
      <td width='30px'></td><td><img align = 'left'  width='330px' height='100px' src='".$arquivo."img/clinicadez.jpg'></td>
    </tr>
    <td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
    <tr>
    <td width='30px'></td><td>" . substr($item->sala, 0, 10) . "</td>
    </tr>
    <tr>
    <td width='30px'></td><td width='400px'>Reg.:" . $item->paciente_id . "</td><td>Emiss&atilde;o: " . substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4) . "</td>
    </tr>
    <tr>
      <td width='30px'></td><td >Paciente:" . $item->paciente . "</td><td>Idade:" . $teste . "</td>
    </tr>
    <tr>
    <td width='30px'></td><td>Solicitante: Dr(a). " . $item->medicosolicitante . "</td><td>Sexo:" . $item->sexo . "</td>
    </tr>
    </tr>
    </tr><tr><td>&nbsp;</td></tr>
    <tr>
    </table>";
                            $rodape = "";
                            if ($item->situacao == "FINALIZADO" && $item->medico_parecer2 == "") {
                                $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td width='400px'></td><td><img align = 'Right'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $item->medico_parecer1 . ".jpg'></td></tr></tr><tr><td>&nbsp;</td></tr></table>";
                            } elseif ($item->situacao == "FINALIZADO" && $item->medico_parecer2 != "") {
                                $rodape = "<table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;'><tr><td width='30px'></td><td><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $item->medico_parecer1 . ".jpg'></td><td width='30px'></td><td><img align = 'left'  width='200px' height='100px' src='upload/1ASSINATURAS/" . $item->medico_parecer2 . ".jpg'></td></tr></tr><tr><td>&nbsp;</td></tr></table>";
                            }

                            $nomepdf = "./upload/laudo/" . $convenio . "/" . $sl_cod_doc . ".pdf";
                            $cabecalhopdf = $cabecalho;
                            $rodapepdf = $rodape;
//                            $cabecalhopdf = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $item->paciente . " <br>Emiss&atilde;o: </td></tr></table>";
//                            $rodapepdf = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
                            salvapdf($texto, $nomepdf, $cabecalhopdf, $rodapepdf);


//                        $zip = new ZipArchive;
//                        $this->load->helper('directory');
//                        $arquivo_pasta = directory_map("./upload/laudo/$convenio/");
//                        $pasta = $item->paciente_id;
//                        if ($arquivo_pasta != false) {
//                            foreach ($arquivo_pasta as $value) {
//                                $zip->open("./upload/laudo/$convenio/$sl_cod_doc.zip", ZipArchive::CREATE);
//                                $zip->addFile("./upload/laudo/$convenio/$value", "$sl_cod_doc.xml");
//                                $zip->addFile("./upload/laudo/$convenio/$value", "$sl_cod_doc.pdf");
//                                $zip->close();
//                            }
//                            $arquivoxml = "./upload/laudo/$convenio/$sl_cod_doc.xml";
//                            $arquivopdf = "./upload/laudo/$convenio/$sl_cod_doc.pdf";
//                            unlink($arquivoxml);
//                            unlink($arquivopdf);
//                        }

                            $paciente_dif = $item->paciente_id;
                        }
                    }
                } else {
                    foreach ($listarexame as $item) {

//                    if ($_POST['apagar'] == 1) {
//                        delete_files($origem . '/' . $convenio . '/' . $item->paciente_id);
//                    }

                        if ($item->paciente_id !== $paciente_dif) {
                            $sl_cod_doc = $item->ambulatorio_laudo_id;
                            $texto = "";
                            if (!is_dir($origem . '/' . $convenio)) {
                                mkdir($origem . '/' . $convenio);
                                chmod($origem . '/' . $convenio, 0777);
                            }

                            //NUMERO DA CARTEIRA
                            if ($item->convenionumero == '') {
                                $numerodacarteira = '0000000';
                            } else {
                                $numerodacarteira = $item->convenionumero;
                            }

                            //NUMERO GUIA CONVENIO  
                            if ($item->guiaconvenio == '') {
                                $numeroguia = '0000000';
                            } else {
                                $numeroguia = $item->guiaconvenio;
                            }

                            $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
                      <S_LINE>
                      <SL_TIPO>RP</SL_TIPO>
                      <SL_TITULO>" . $item->paciente . "-" . $item->nascimento . "</SL_TITULO>
                      <SL_SN>O</SL_SN>
                      <SL_CHAVE></SL_CHAVE>
                      <SL_SENHA></SL_SENHA>                      
                      <SL_COD_DOC>" . $sl_cod_doc . "</SL_COD_DOC>                      
                      <SL_FORMATO>PDF</SL_FORMATO>
                      <SL_DATA_REALIZACAO>" . substr($item->data_realizacao, 0, 10) . "T" . substr($item->data_realizacao, 10, 18) . " </SL_DATA_REALIZACAO>
                        <SL_OPER>
                           <OPER_REGANS>384577</OPER_REGANS>
                           <OPER_NUMCARTEIRA>" . $numerodacarteira . "</OPER_NUMCARTEIRA>
                           <OPER_NUMGUIA>" . $numeroguia . "
                                ";
                            //este foreach irá inserir todos os códigos dos exames relacionados ao numeroguia 
                            foreach ($listarexame as $value) {
                                $corpo = $corpo . "<OPER_EXAME>" . $value->codigo . "</OPER_EXAME>";
                                $texto = $texto . $value->texto_laudo;
                            }


                            $fim_numguia = "</OPER_NUMGUIA>";

                            $rodape = "</SL_OPER>
                       <SL_TEXTO></SL_TEXTO>
                    </S_LINE>";

                            $nome = "./upload/laudo/" . $convenio . "/" . $sl_cod_doc . ".xml";
                            $xml = $cabecalho . $corpo . $fim_numguia . $rodape;
                            $fp = fopen($nome, "w+");
                            fwrite($fp, $xml . "\n");
                            fclose($fp);

                            $nomepdf = "./upload/laudo/" . $convenio . "/" . $sl_cod_doc . ".pdf";
                            $cabecalhopdf = "<table><tr><td><img align = 'left'  width='1000px' height='300px' src='img/cabecalho.jpg'></td></tr><tr><td>Nome:" . $item->paciente . " <br>Emiss&atilde;o: </td></tr></table>";
                            $rodapepdf = "<img align = 'left'  width='1000px' height='300px' src='img/rodape.jpg'>";
                            salvapdf($texto, $nomepdf, $cabecalhopdf, $rodapepdf);


                            $zip = new ZipArchive;
                            $this->load->helper('directory');
                            $arquivo_pasta = directory_map("./upload/laudo/$convenio/");
                            $pasta = $item->paciente_id;
                            if ($arquivo_pasta != false) {
                                foreach ($arquivo_pasta as $value) {
                                    $zip->open("./upload/laudo/$convenio/$sl_cod_doc.zip", ZipArchive::CREATE);
                                    $zip->addFile("./upload/laudo/$convenio/$value", "$sl_cod_doc.xml");
                                    $zip->addFile("./upload/laudo/$convenio/$value", "$sl_cod_doc.pdf");
                                    $zip->close();
                                }
                                $arquivoxml = "./upload/laudo/$convenio/$sl_cod_doc.xml";
                                $arquivopdf = "./upload/laudo/$convenio/$sl_cod_doc.pdf";
                                unlink($arquivoxml);
                                unlink($arquivopdf);
                            }

                            $paciente_dif = $item->paciente_id;
                        }
                    }
                }
            } else {

                if (!is_dir($origem . '/' . $convenio . '/' . $listarexame[0]->paciente_id)) {
                    mkdir($origem . '/' . $convenio . '/' . $listarexame[0]->paciente_id);
                    chmod($origem . '/' . $convenio . '/' . $listarexame[0]->paciente_id, 0777);
                }

                $cabecalho = "<?xml version='1.0' encoding='iso-8859-1'?>
                            <NAJA>
                                <NJ_CodPaciente>" . $listarexame[0]->paciente_id . "</NJ_CodPaciente>
                                <NJ_NomePaciente>" . $listarexame[0]->paciente . "</NJ_NomePaciente>
                                <NJ_Laudo>" . $listarexame[0]->ambulatorio_laudo_id . "</NJ_Laudo>
                                <NJ_LocalLaudo>./upload/laudo" . $convenio . "/" . $listarexame[0]->paciente_id . "</NJ_LocalLaudo>
                                <NJ_FormatoLaudo>RTF</NJ_FormatoLaudo>
                                <NJ_NomeMedicoLaudante>" . $listarexame[0]->medicosolicitante . "</NJ_NomeMedicoLaudante>
                               <NJ_Detalhes>";

                $corpo = "<NJ_Exame>
                            <NJ_Accessionnumber>" . $listarexame[0]->wkl_accnumber . "</NJ_Accessionnumber>                            
                            <NJ_NomeExame>" . $listarexame[0]->wkl_procstep_descr . "</NJ_NomeExame>
                       </NJ_Exame>";

                $texto = $listarexame[0]->texto_laudo;

                $rodape = "</NJ_Detalhes>
                       </NAJA>";

                $nome = "./upload/laudo/" . $convenio . "/" . $listarexame[0]->paciente_id . "/" . $listarexame[0]->paciente_id . ".xml";
                $xml = $cabecalho . $corpo . $rodape;
                $fp = fopen($nome, "w+");
                fwrite($fp, $xml . "\n");
                fclose($fp);

                $nome = "./upload/laudo/" . $convenio . "/" . $listarexame[0]->paciente_id . "/" . $listarexame[0]->paciente_id . ".rtf";
                $rtf = $texto;
                $fp = fopen($nome, "w+");
                fwrite($fp, $rtf . "\n");
                fclose($fp);
            }
            //        $data['mensagem'] = 'Sucesso ao gerar arquivo.';
//
//        $this->session->set_flashdata('message', $data['mensagem']);
//        redirect(base_url() . "ambulatorio/laudo", $data);
        }
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
