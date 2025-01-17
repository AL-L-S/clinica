<?
//var_dump(@$obj->_ambulatorio_laudo_id); die;
$pacs = $this->empresa->listarpacs();
if (count($pacs) > 0) {

//    var_dump($agenda_exames_id);
//        die;
// $AN- variavel, com o accession number( numero do exame), obtida do sistema gestor da clinica;
    $AN = $agenda_exames_id;
    $ipPACS_LAN = $pacs[0]->ip_local; //Ip atribuido ao PACS, na LAN do cliente;
    $IPpublico = $pacs[0]->ip_externo; // IP, OU URL( dyndns, no-ip, etc) PARA ACESSO EXTERNO AO PACS;
//login que depende da clinica;
    $login = $pacs[0]->login;
    $password = $pacs[0]->senha;

// url de requisicao(GET),composta pelo IP publico da clinica  ou dns dinamico , considerando, que o seu webserver vai estar fora da clinica, se ele estiver na clinica, aqui deve ser substituido por $ipPACS_LAN ;

    $url = "http://{$IPpublico}/createlink?AccessionNumber={$AN}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
    $resultado = curl_exec($ch);
    curl_close($ch);
// A variavel $resultado, comtem o link, com o IP da rede local do pacs, que deve ser substituido pelo 
// endereco de acesso externo;
//$linkImagem, variável com o link a ser exportado para o site, para o cliente acessar as imagens;

    $linkImagem = str_replace("$ipPACS_LAN", "$IPpublico", "$resultado");

//    echo $url, '<br>';
//    echo $resultado, '<br>';
    if (preg_match('/\ERROR/', $linkImagem)) {
//        echo 'deu';
    }

//    echo $linkImagem, '<br>';
//        if ($verifica == 0) {
//            $ambulatorio_laudooit_id = $this->laudooit->inserirlaudo($ambulatorio_laudo_id);
//            $obj_laudo = new laudooit_model($ambulatorio_laudooit_id);
//        } 
} else {
    $linkImagem = '';
}
//$pacs = $this->empresa->listarpacs();
?>
<head>
    <title>Laudo</title>
</head>
<div >

    <?
    $valuecalculado = '';
    setcookie("TestCookie", $valuecalculado);
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');

    $laudo_sigiloso = $this->session->userdata('laudo_sigiloso');
    $operador_id = $this->session->userdata('operador_id');
    $perfil_id = $this->session->userdata('perfil_id');

    if (@$obj->_status == 'FINALIZADO' && $laudo_sigiloso == 't' && $operador_id != 1) {
        $readonly = 1;
    } else {
        $readonly = 0;
    }
    if (@$obj->_status == 'FINALIZADO' && $laudo_sigiloso == 't') {
        $adendo = true;
    } else {
        $adendo = false;
    }
    if (@$empresapermissao[0]->dados_atendimentomed != '') {
        $opc_dadospaciente = json_decode(@$empresapermissao[0]->dados_atendimentomed);
    } else {
        $opc_dadospaciente = array();
    }


//    var_dump($laudo_sigiloso); die;
//    $estado_civil = @$obj->_estado_civil_id;
    if (@$obj->_estado_civil == ''):$estado_civil = 'Solteiro';
    endif;
    if (@$obj->_estado_civil == 2):$estado_civil = 'Casado';
    endif;
    if (@$obj->_estado_civil == 3):$estado_civil = 'Divorciado';
    endif;
    if (@$obj->_estado_civil == 4):$estado_civil = 'Viuvo';
    endif;
    if (@$obj->_estado_civil == 5):$estado_civil = 'Outros';
    endif;
    ?>

    <div>
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarlaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>/<?= @$obj->_sala_id ?>" method="post">
            <div >
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr >
                            <? if (in_array('paciente', $opc_dadospaciente)) { ?>
                                <td colspan="3" width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <? } ?>
                            <? if (in_array('exame', $opc_dadospaciente)) { ?>
                                <td colspan="3" width="400px;">Exame: <?= @$obj->_procedimento ?></td>
                            <? } ?>
                            <? if (in_array('solicitante', $opc_dadospaciente)) { ?>
                                <td>Solicitante: <?= @$obj->_solicitante ?></td>
                            <? } ?>

                        </tr>
                        <tr>
                            <? if (in_array('idade', $opc_dadospaciente)) { ?>
                                <td colspan="3">Idade: <?= $teste ?></td>
                            <? } ?>
                            <? if (in_array('nascimento', $opc_dadospaciente)) { ?>
                                <td colspan="3">Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                            <? } ?>
                            <? if (in_array('sala', $opc_dadospaciente)) { ?>
                                <td>Sala:<?= @$obj->_sala ?></td>
                            <? } ?>
                        </tr>
                        <tr>
                            <? if (in_array('sexo', $opc_dadospaciente)) { ?>
                                <td colspan="2">Sexo: <?= @$obj->_sexo ?></td>
                            <? } ?>
                            <? if (in_array('estadocivil', $opc_dadospaciente)) { ?>
                                <td colspan="1">Ocupação: <?= @$obj->_profissao_cbo ?> </td>
                            <? } ?>
                            <? if (in_array('ocupacao', $opc_dadospaciente)) { ?>
                                <td colspan="2">Estado Civíl: <?= @$estado_civil ?> </td>
                            <? } ?>
                            <? if (in_array('convenio', $opc_dadospaciente)) { ?>
                                <td colspan="">Convenio:<?= @$obj->_convenio; ?></td>
                            <? } ?>
                            <? if (in_array('telefone', $opc_dadospaciente)) { ?>
                                <td colspan="1" style="width: 200px">Telefone: <?= @$obj->_telefone ?></td>
                            <? } ?>

                        </tr>

                        <tr>
                            <? if (in_array('telefone', $opc_dadospaciente)) { ?>
                                <td colspan="2">Indicaçao: <?= @$obj->_indicacao ?></td>
                            <? } ?>


                            <? if (in_array('endereco', $opc_dadospaciente)) { ?>
                                <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
                            <? } ?>
                        </tr>





                    </table>


                </fieldset>
                <table>
                    <tr>

                        <td>


                            <? if (($endereco != '')) { ?>

                                <div class="bt_link_new">
                                    <a href='#' id='botaochamar' >Chamar</a>
                                </div>


                            <? } else {
                                ?>
                                <div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/chamarpaciente/<?= $ambulatorio_laudo_id ?>');" >
                                        Chamar</a>
                                </div>  
                            <? }
                            ?>
                        </td>
                        <td>
                            <div class="bt_link_new">
                                <a onclick="javascript: return confirm('Deseja realmente deixar o atendimento pendente?');" href="<?= base_url() ?>ambulatorio/laudo/pendenteexamemultifuncao/<?= $exame_id ?>" >
                                    Pendente
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="bt_link_new">
                                <a href="<?= base_url() ?>ambulatorio/laudo/encaminharatendimento/<?= $ambulatorio_laudo_id ?>" >
                                    Encaminhar
                                </a>
                            </div>
                        </td>

                    </tr>

                </table>

                <?
                $i = 0;
                if ($arquivo_pasta != false):
                    foreach ($arquivo_pasta as $value) {
                        $i++;
                    }
                endif
                ?>
                <fieldset>
                    <legend>Imagens : <font size="2"><b> <?= $i ?></b><? if ($i > 0) { ?>  <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/limparnomes/" . $exame_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=400,height=200');">
                                    <font size="-1">Limpar Nomes</font>
                                </a>
                            </div><? } ?></legend>
                    <?
                    if ($arquivo_pasta != false):
                        foreach ($arquivo_pasta as $value) {
                            ?>
                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/alterarnomeimagem/" . $exame_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=800');"><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"></a></li>
                            <?
                        }
                    endif
                    ?>
                    <!--                <ul id="sortable">
                                    </ul>-->
                </fieldset>
                <table>
                    <tr><td width="60px;"><center>
                        <div class="bt_link_new">
                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/galeria/" . $exame_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                <font size="-1"> vizualizar imagem</font>
                            </a>
                        </div>
                        </td>
                        <td width="60px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/exame/anexarimagemmedico/" . $exame_id . "/" . @$obj->_sala_id; ?> ', '_blank', 'width=1200,height=700');">
                                    <font size="-1"> adicionar/excluir</font>
                                </a>
                            </div></center>
                        </td>
                        <td width="60px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/carregarlaudoanterior/" . $paciente_id . "/" . $ambulatorio_laudo_id; ?> ');">
                                    <font size="-1">Laudo anterior</font>
                                </a>
                            </div></center>
                        </td>
                        <td width="250px;"><font size="-2"><center>
                            <div>
                                <h4>Imagens por pagina</h4>
                                <?
//                    var_dump(@$obj->_quantidade);
//                    die;

                                if (@$obj->_imagens == "1") {
                                    ?>
                                    <label><input type="radio" value="1" name="imagem" class="radios3" checked ="true"/> 1</label>
                                <? } else { ?>
                                    <label><input type="radio" value="1" name="imagem" class="radios3" />1</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "2") { ?>
                                    <label><input type="radio" value="2" name="imagem" class="radios3" checked ="true"/> 2</label>
                                <? } else { ?>
                                    <label><input type="radio" value="2" name="imagem" class="radios3" /> 2</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "3") { ?>
                                    <label><input type="radio" value="3" name="imagem" class="radios3" checked ="true"/> 3</label>
                                <? } else { ?>
                                    <label><input type="radio" value="3" name="imagem" class="radios3" /> 3</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "4") { ?>
                                    <label><input type="radio" value="4" name="imagem" class="radios3" checked ="true"/> 4</label>
                                <? } else { ?>
                                    <label><input type="radio" value="4" name="imagem" class="radios3" /> 4</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "5") { ?>
                                    <label><input type="radio" value="5" name="imagem" class="radios3" checked ="true"/> 5</label>
                                <? } else { ?>
                                    <label><input type="radio" value="5" name="imagem" class="radios3" /> 5</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "6") { ?>
                                    <label><input type="radio" value="6" name="imagem" class="radios3" checked ="true"/> 6</label>
                                <? } else { ?>
                                    <label><input type="radio" value="6" name="imagem" class="radios3" /> 6</label>
                                <? } ?>
                            </div>
                            </font></center></td>
                        <td width="60px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/modelolaudo"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650 ');">
                                    <font size="-1">laudo Modelo</font>
                                </a>
                            </div>
                            </td>
                            <td width="60px;"><center>
                                <div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/modelolinha"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                        <font size="-1">  Linha Modelo </font>
                                    </a>
                                </div></center>
                            </td>
                            <td width="60px;"><center>
                                <div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/calculadora"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=400,height=450');">
                                        <font size="-1">  Calculadora </font>
                                    </a>
                                </div></center>
                            </td>
                            </table>

                            </div>
                            <div>

                                <fieldset>
                                    <legend>Laudo</legend>
                                    <div>
                                        <?
                                        if (@$obj->_cabecalho == "") {
                                            $cabecalho = @$obj->_procedimento;
                                        } else {
                                            $cabecalho = @$obj->_cabecalho;
                                        }
                                        ?>
                                        <label>Nome do Laudo</label>
                                        <input type="text" id="cabecalho" class="texto10" name="cabecalho" value="<?= $cabecalho ?>"/>
                                    </div>
                                    <div>
                                        <table style="font-size: 10pt;" >

                                            <tr>
                                                <td style="width: 100px;">
                                                    <label>Laudo</label>
                                                    <select name="exame" id="exame" class="size2" >
                                                        <option value='' >selecione</option>
                                                        <?php foreach ($lista as $item) { ?>
                                                            <option value="<?php echo $item->ambulatorio_modelo_laudo_id; ?>" ><?php echo $item->nome; ?></option>
                                                        <?php } ?>
                                                    </select>   
                                                </td>
                                                <td>
                                                    <label>Linha</label>
                                                    <br>
                                                    <input type="text" id="linha2" class="texto02" name="linha2"/>

                                                </td>
                                                <td>
                                                    <div class="bt_link" style="width: 140px;">
                                                        <a onclick="visualizarModeloLaudo();">
                                                            <font size="-1"> Visual. Modelo</font></a>
                                                    </div>  
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>


                                                    <div style="width: 180px;" class="bt_link">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                                            <font size="-1"> Imprimir</font></a>
                                                    </div>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                    <div>
                                        <textarea id="laudo" class="laudo" name="laudo" rows="30" cols="80" style="width: 80%"><?= @$obj->_texto; ?></textarea>
                                    </div>
                                    <? if ($adendo) { ?>
                                        <div>
                                            <label><h3>Adendo</h3></label>
                                            <textarea id="adendo" name="adendo" class="adendo" rows="30" cols="80" style="width: 80%"></textarea>
                                        </div>    
                                    <? }
                                    ?>

                                    <div>
                                        <label title='Apenas Administradores Totais podem alterar o médico.'>
                                            M&eacute;dico respons&aacutevel
                                        </label>
                                        <select name="medico" id="medico" class="size2" title='Apenas Administradores Totais podem alterar o médico.' >
                                            <? if ($perfil_id == 1) { ?>
                                                <option value=0 >selecione</option>
                                                <?
                                            }
                                            foreach ($operadores as $value) :
                                                if ($perfil_id != 1 && $obj->_medico_parecer1 != $value->operador_id) {
                                                    continue;
                                                }
                                                ?>

                                                <option value="<?= $value->operador_id; ?>" <?= (@$obj->_medico_parecer1 == $value->operador_id) ? 'selected' : ''; ?>>
                                                    <?= $value->nome; ?>
                                                </option>
                                            <? endforeach; ?>
                                        </select>
                                        <?php
                                        if (@$obj->_revisor == "t") {
                                            ?>
                                            <input type="checkbox" name="revisor" checked ="true" /><label>Revisor</label>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="checkbox" name="revisor"  /><label>Revisor</label>
                                            <?php
                                        }
                                        ?>
                                        <select name="medicorevisor" id="medicorevisor" class="size2">
                                            <option value="">Selecione</option>
                                            <? foreach ($operadores as $valor) : ?>
                                                <option value="<?= $valor->operador_id; ?>"<?
                                                if (@$obj->_medico_parecer2 == $valor->operador_id):echo 'selected';
                                                endif;
                                                ?>><?= $valor->nome; ?></option>
                                                    <? endforeach; ?>
                                        </select>
                                        <? if (@$empresapermissao[0]->desativar_personalizacao_impressao != 't') { ?>
                                            <?php
                                            if (@$obj->_assinatura == "t") {
                                                ?>
                                                <input type="checkbox" name="assinatura" id="assinatura" checked ="true" /><label>Assinatura</label>
                                                <?php
                                            } else {
                                                ?>
                                                <input type="checkbox" name="assinatura" id="assinatura"  /><label>Assinatura</label>
                                                <?php
                                            }
                                            ?>
                                            <input type="checkbox" name="carimbo" id="carimbo" <? //=(@$obj->_carimbo == 't')? 'checked': ''; ?> /><label>Carimbo</label>
                                            <?php
                                            if (@$obj->_indicado == "t") {
                                                ?>
                                                <input type="checkbox" name="indicado" checked ="true" /><label>Indicado</label>
                                                <?php
                                            } else {
                                                ?>
                                                <input type="checkbox" name="indicado"  /><label>Indicado</label>
                                                <?php
                                            }
                                            ?>
                                        <? } ?>

                                        <label>situa&ccedil;&atilde;o</label>
                                        <select name="situacao" id="situacao" class="size2" <? if ($empresapermissao[0]->senha_finalizar_laudo == 't') { ?>onChange="muda(this)" <? } ?> >
                                            <option value='DIGITANDO'<?
                                            if (@$obj->_status == 'DIGITANDO'):echo 'selected';
                                            endif;
                                            ?> >DIGITANDO</option>
                                            <option value='REVISAR' <?
                                            if (@$obj->_status == 'REVISAR'):echo 'selected';
                                            endif;
                                            ?> >REVISAR</option>
                                            <option value='FINALIZADO' <?
                                            if (@$obj->_status == 'FINALIZADO'):echo 'selected';
                                            endif;
                                            ?> >FINALIZADO</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label id="titulosenha">Senha</label>
                                        <input type="password" name="senha" id="senha" class="size1" />
                                    </div>
                                    <label style="margin-left: 10pt" for="rev">Revisão?</label>
                                    <input type="checkbox" name="rev" id="rev" />
                                    <div class="dias" style="display: inline">

                                    </div>
                                </fieldset>
                                <fieldset>
                                    <? ?>
                                    <legend>Impress&atilde;o</legend>
                                    <div>
                                        <table>
                                            <tr>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a id="Imprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                                            <font size="-1"> Imprimir</font></a></div></td>
                                                <td ><div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoimagem/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                                            <font size="-1"> fotos</font></a></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/pesquisarlaudoantigo');">
                                                            <font size="-1">L. Antigo</font></a></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $ambulatorio_laudo_id ?>');" >
                                                            <font size="-1">Arquivos</font></a></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/oit/<?= $ambulatorio_laudo_id ?>');" >
                                                            <font size="-1">OIT</font></a></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <? if (!preg_match('/\ERROR/', $linkImagem) && $linkImagem != '') { ?>
                                                            <a href="<?= $linkImagem ?>" target="_blank" >
                                                                <font size="-1">Imagens PACS</font></a>    
                                                        <? } else { ?>
                                                            <font size="-1">Imagens PACS</font>
                                                        <? }
                                                        ?>
                                                    </div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/pesquisarsolicitacaosadt/<?= $paciente_id ?>');" >
                                                            <font size="-1">Solicitação SADT</font></a></div></td>    

                                            </tr>
                                            <tr>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaooit/<?= $ambulatorio_laudo_id ?>');" >
                                                            <font size="-1">Imp. OIT</font></a></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/gravordevoz/" ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                                            <font size="-1">Gravador</font></a></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaratestado/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>');" >
                                                            <font size="-1">Atestado</a></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a href="<?= base_url() ?>ambulatorio/laudo/vozemtexto/<?= $ambulatorio_laudo_id ?>/<?= $operador_id ?>">
                                                            <font size="-1">Voz em Texto</a></div></td>
                                                <td >
                                                    <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/carregaruploadcliente/" ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');" >
                                                            <font size="-1">Upload de Imagens</a></div></td>
                                                <td>
                                                    <div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimentoplano/procedimentoplanoconsultalaudo/" ?> ', '_blank');" >
                                                            <font size="-1">Consultar Proc...</a></div></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <? if (!preg_match('/\ERROR/', $linkImagem) && count($pacs) > 0) { ?>
                                        <div>

                                            <iframe allowfullscreen="" height="250" width="600" src="<?= $linkImagem ?>"></iframe>

                                        </div>
                                    <? }
                                    ?>


                                    <div>




                                        <hr/>

                                        <button type="submit" name="btnEnviar">Salvar</button>
                                    </div>
                                </fieldset>
                                <table border="1">
                                    <tr>
                                        <th>Tecla</th>
                                        <th>Bot&atilde;o Fun&ccedil;&atilde;o</th>
                                    </tr>
                                    <tr>
                                        <td>F8</td>
                                        <td>Bot&atilde;o Visualizar Impress&atilde;o</td>
                                    </tr>
                                    <tr>
                                        <td>F9</td>
                                        <td>Bot&atilde;o Finalizar</td>
                                    </tr>

                                </table>
                                </form>
                                <br>
                                <br>
                                <fieldset>
                                    <legend><b><font size="3" color="red">Arquivos Anexados Paciente</font></b></legend>
                                    <table>
                                        <tr>
                                            <?
                                            $l = 0;
                                            if ($arquivos_paciente != false):
                                                foreach ($arquivos_paciente as $value) :
                                                    $l++;
                                                    ?>

                                                    <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/paciente/" . $paciente_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/paciente/" . $paciente_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?><br><a target="_blank"  href="<?= base_url() ?>cadastros/pacientes/excluirimagemlaudo/<?= $paciente_id ?>/<?= $value ?>">Excluir</a></td>
                                                    <?
                                                    if ($l == 8) {
                                                        ?>
                                                    </tr><tr>
                                                        <?
                                                    }
                                                endforeach;
                                            endif
                                            ?>
                                    </table>
                                </fieldset>
                                <br>
                                <br>
                                <fieldset>
                                    <legend><b><font size="3" color="red">Arquivos Anexados Laudo</font></b></legend>
                                    <table>
                                        <tr>
                                            <?
                                            $o = 0;
                                            if ($arquivos_anexados != false):
                                                foreach ($arquivos_anexados as $value) :
                                                    $o++;
                                                    ?>

                                                    <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $ambulatorio_laudo_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/consulta/" . $ambulatorio_laudo_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?><br><a target="_blank" href="<?= base_url() ?>ambulatorio/laudo/excluirimagemlaudo/<?= $ambulatorio_laudo_id ?>/<?= $value ?>">Excluir</a></td>
                                                    <?
                                                    if ($o == 8) {
                                                        ?>
                                                    </tr><tr>
                                                        <?
                                                    }
                                                endforeach;
                                            endif
                                            ?>
                                    </table>
                                </fieldset>
                                <br>
                                <br>
                                <fieldset>
                                    <legend><b><font size="3" color="red">Historico de consultas</font></b></legend>
                                    <div>
                                        <?
                                        // Esse código serve para mostrar os históricos que foram importados
                                        // De outro sistema STG.
                                        // Na hora que o médico finaliza o atendimento, o sistema manda os dados para o endereço do sistema
                                        // Digitado no cadastro do médico, caso exista ele salva numa tabela especifica.
                                        // Para não criar um outro local onde iriam aparecer os atendimentos dessa tabela 
                                        // Há essa lógica aqui embaixo para inserir no meio dos outros atendimentos da ambulatorio_laudo os outros
                                        // da integração
                                        $contador_teste = 0;
                                        // Contador para utilizar no array
//                            $historico = array();
                                        foreach ($historico as $item) {
                                            // Verifica se há informação
                                            if (isset($historicowebcon[$contador_teste])) {
                                                // Define as datas
                                                $data_foreach = date("Y-m-d", strtotime($item->data_cadastro));
                                                $data_while = date("Y-m-d", strtotime($historicowebcon[$contador_teste]->data));
                                                // Caso a data do Index atual da integracao seja maior que a data rodando no foreach, ele irá mostrar

                                                while ($data_while > $data_foreach) {
                                                    ?>

                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td ><span style="color: #007fff">Integração</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Empresa: <?= $historicowebcon[$contador_teste]->empresa; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Data: <?= substr($historicowebcon[$contador_teste]->data, 8, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 5, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 0, 4); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Medico: <?= $historicowebcon[$contador_teste]->medico_integracao; ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td >Tipo: <?= $historicowebcon[$contador_teste]->procedimento; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Queixa principal: <?= $historicowebcon[$contador_teste]->texto; ?></td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                    <?
                                                    $contador_teste ++;
                                                    // Verifica se o próximo index existe e se sim, ele redefine a data_while pra poder rodar novamente o while
                                                    if (isset($historicowebcon[$contador_teste])) {
                                                        $data_while = date("Y-m-d", strtotime($historicowebcon[$contador_teste]->data_cadastro));
                                                    } else {
                                                        // Caso não exista ele simplesmente dá um break e deixa o foreach rodar
                                                        break;
                                                    }
                                                }
                                            }
                                            ?>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td >Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Medico: <?= $item->medico; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Tipo: <?= $item->procedimento; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Queixa principal: <?= $item->texto; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Arquivos anexos:
                                                            <?
                                                            $this->load->helper('directory');
                                                            $arquivo_pasta = directory_map("./upload/consulta/$item->ambulatorio_laudo_id/");

                                                            $w = 0;
                                                            if ($arquivo_pasta != false):
                                                                foreach ($arquivo_pasta as $value) :
                                                                    $w++;
                                                                    ?>

                                                                    <a onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="50px" height="50px" src="<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?>"></a>
                                                                    <?
                                                                    if ($w == 8) {
                                                                        
                                                                    }
                                                                endforeach;
                                                                $arquivo_pasta = "";
                                                            endif
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                        <? }
                                        ?>
                                    </div>
                                    <?
                                    if (count($historico) == 0 || $contador_teste < count($historicowebcon)) {
                                        while ($contador_teste < count($historicowebcon)) {
                                            ?>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td><span style="color: #007fff">Integração</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Empresa: <?= $historicowebcon[$contador_teste]->empresa; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Data: <?= substr($historicowebcon[$contador_teste]->data, 8, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 5, 2) . "/" . substr($historicowebcon[$contador_teste]->data, 0, 4); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Medico: <?= $historicowebcon[$contador_teste]->medico_integracao; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td >Tipo: <?= $historicowebcon[$contador_teste]->procedimento; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Queixa principal: <?= $historicowebcon[$contador_teste]->texto; ?></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <hr>

                                            <?
                                            $contador_teste++;
                                        }
                                    }
                                    ?>

                                    <div>
                                        <? foreach ($historicoantigo as $itens) {
                                            ?>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td >Data: <?= substr($itens->data_cadastro, 8, 2) . "/" . substr($itens->data_cadastro, 5, 2) . "/" . substr($itens->data_cadastro, 0, 4); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Queixa principal: <?= $itens->laudo; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                        <? }
                                        ?>
                                    </div>

                                </fieldset>
                                <br><br>
                                <fieldset>
                                    <legend><b><font size="3" color="red">Historico de exames</font></b></legend>
                                    <div>

                                        <?
                                        $contador_exame = 0;
                                        foreach ($historicoexame as $item) {
                                            // Verifica se há informação
                                            if (isset($historicowebexa[$contador_exame])) {
                                                // Define as datas
                                                $data_foreach = date("Y-m-d", strtotime($item->data_cadastro));
                                                $data_while = date("Y-m-d", strtotime($historicowebexa[$contador_exame]->data));
                                                // Caso a data do Index atual da integracao seja maior que a data rodando no foreach, ele irá mostrar

                                                while ($data_while > $data_foreach) {
                                                    ?>

                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td ><span style="color: #007fff">Integração</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Empresa: <?= $historicowebexa[$contador_exame]->empresa; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Data: <?= substr($historicowebexa[$contador_exame]->data, 8, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 5, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 0, 4); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Medico: <?= $historicowebexa[$contador_exame]->medico_integracao; ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td >Tipo: <?= $historicowebexa[$contador_exame]->procedimento; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td >Queixa principal: <?= $historicowebexa[$contador_exame]->texto; ?></td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                    <?
                                                    $contador_exame ++;
                                                    // Verifica se o próximo index existe e se sim, ele redefine a data_while pra poder rodar novamente o while
                                                    if (isset($historicowebexa[$contador_exame])) {
                                                        $data_while = date("Y-m-d", strtotime($historicowebexa[$contador_exame]->data_cadastro));
                                                    } else {
                                                        // Caso não exista ele simplesmente dá um break e deixa o foreach rodar
                                                        break;
                                                    }
                                                }
                                            }
                                            ?>
                                            <table>
                                                <tbody>


                                                    <tr>
                                                        <td >Data: <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Medico: <?= $item->medico; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td >Tipo: <?= $item->procedimento; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <?
                                                        $this->load->helper('directory');
                                                        $arquivo_pastaimagem = directory_map("./upload/$item->exames_id/");

                                                        if ($arquivo_pastaimagem != false) {
                                                            sort($arquivo_pastaimagem);
                                                        }
                                                        $i = 0;
                                                        if ($arquivo_pastaimagem != false) {
                                                            foreach ($arquivo_pastaimagem as $value) {
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                        <td >Imagens : <font size="2"><b> <?= $i ?></b>
                                                            <?
                                                            if ($arquivo_pastaimagem != false):
                                                                foreach ($arquivo_pastaimagem as $value) {
                                                                    ?>
                                                                    <a onclick="javascript:window.open('<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $item->exames_id . "/" . $value ?>"></a>
                                                                    <?
                                                                }
                                                                $arquivo_pastaimagem = "";
                                                            endif
                                                            ?>
                                                            <!--                <ul id="sortable">
            
                                                                            </ul>-->
                                                        </td >
                                                    </tr>
                                                    <tr>
                                                        <td >Laudo: <?= $item->texto; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Arquivos anexos:
                                                            <?
                                                            $this->load->helper('directory');
                                                            $arquivo_pasta = directory_map("./upload/consulta/$item->ambulatorio_laudo_id/");

                                                            $w = 0;
                                                            if ($arquivo_pasta != false):

                                                                foreach ($arquivo_pasta as $value) :
                                                                    $w++;
                                                                    ?>

                                                                    <a onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="50px" height="50px" src="<?= base_url() . "upload/consulta/" . $item->ambulatorio_laudo_id . "/" . $value ?>"></a>
                                                                    <?
                                                                    if ($w == 8) {
                                                                        
                                                                    }
                                                                endforeach;
                                                                $arquivo_pasta = "";
                                                            endif
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style='width:10pt;border:solid windowtext 1.0pt;
                                                            border-bottom:none;mso-border-top-alt:none;border-left:
                                                            none;border-right:none;' colspan="10">&nbsp;</th>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        <? }
                                        ?>
                                        <?
                                        if (count($historico) == 0 || $contador_exame < count($historicowebexa)) {
                                            while ($contador_exame < count($historicowebexa)) {
                                                ?>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td><span style="color: #007fff">Integração</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td >Empresa: <?= $historicowebexa[$contador_exame]->empresa; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td >Data: <?= substr($historicowebexa[$contador_exame]->data, 8, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 5, 2) . "/" . substr($historicowebexa[$contador_exame]->data, 0, 4); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td >Medico: <?= $historicowebexa[$contador_exame]->medico_integracao; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td >Tipo: <?= $historicowebexa[$contador_exame]->procedimento; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td >Queixa principal: <?= $historicowebexa[$contador_exame]->texto; ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <hr>

                                                <?
                                                $contador_exame++;
                                            }
                                        }
                                        ?>
                                    </div>

                                </fieldset>
                                <fieldset>
                                    <legend><b><font size="3" color="red">Digitaliza&ccedil;&otilde;es</font></b></legend>
                                    <div>
                                        <table>
                                            <tbody>

                                                <tr>
                                                    <td>
                                                        <?
                                                        $this->load->helper('directory');
                                                        $arquivo_pasta = directory_map("./upload/paciente/$paciente_id/");

                                                        $w = 0;
                                                        if ($arquivo_pasta != false):

                                                            foreach ($arquivo_pasta as $value) :
                                                                $w++;
                                                                ?>

                                                            <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/paciente/" . $paciente_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/paciente/" . $paciente_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?></td>
                                                            <?
                                                            if ($w == 8) {
                                                                
                                                            }
                                                        endforeach;
                                                        $arquivo_pasta = "";
                                                    endif
                                                    ?>
                                                    </td>
                                                </tr>



                                            </tbody>
                                        </table>
                                    </div>

                                </fieldset>
                            </div> 
                            </div> 
                            </div> 
                            </div> <!-- Final da DIV content -->
                            <style>
                                .bt_link {width: 200pt;}

                                #sortable { list-style-type: none; margin: 0; padding: 0; width: 1300px; }
                                #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
                            </style>
                            <meta http-equiv="content-type" content="text/html;charset=utf-8" />
                            <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
                            <script type="text/javascript">
                                                                jQuery('#rev').change(function () {
                                                                    if (this.checked) {
                                                                        var tag = '<table><tr><td><input type="radio" name="tempoRevisao" value="1a"><span>1 ano</span></td></tr><tr><td><input type="radio" name="tempoRevisao" value="6m" required><span>6 meses</span></td></tr><tr><td><input type="radio" name="tempoRevisao" value="3m"><span>3 meses</span></td></tr><tr><td><input type="radio" name="tempoRevisao" value="1m"><span>1 mes</span></td></tr></table>';
//                                                            var tag += '';
////                                                           <input type="radio" name="OPCAO1" VALUE="op1"> opção1
////                                                            var tag += '';
//                                                            jQuery("#Altura").mask("999", {placeholder: " "});
                                                                        jQuery(".dias").append(tag);
                                                                    } else {
                                                                        jQuery(".dias span").remove();
                                                                        jQuery(".dias input").remove();
                                                                    }
                                                                });
                                                                document.getElementById('titulosenha').style.display = "none";
                                                                document.getElementById('senha').style.display = "none";

                                                                $(document).ready(function () {
                                                                    $("body").keypress(function (event) {

                                                                        if (event.keyCode == 119)   // se a tecla apertada for 13 (enter)
                                                                        {
                                                                            document.getElementById('Imprimir').click();
                                                                        }
                                                                        if (event.keyCode == 120)   // se a tecla apertada for 13 (enter)
                                                                        {
                                                                            var combosituacao = document.getElementById("situacao");
                                                                            combosituacao.selectedIndex = 2;
                                                                            document.getElementById('titulosenha').style.display = "block";
                                                                            document.getElementById('senha').style.display = "block";
                                                                            document.form_laudo.senha.focus()
                                                                        }
                                                                    });
                                                                });
                                                                $(document).ready(function () {
                                                                    $('#sortable').sortable();
                                                                });


                                                                $(document).ready(function () {
                                                                    jQuery('#ficha_laudo').validate({
                                                                        rules: {
                                                                            imagem: {
                                                                                required: true
                                                                            }
                                                                        },
                                                                        messages: {
                                                                            imagem: {
                                                                                required: "*"
                                                                            }
                                                                        }
                                                                    });
                                                                });

                                                                function visualizarModeloLaudo() {
                                                                    if ($('#exame').val() != '') {
                                                                        varWindow = window.open('<?= base_url() ?>ambulatorio/laudo/carregarmodelolaudoselecionado/' + $('#exame').val(), 'popup', "width=800, height=600 ");
                                                                    } else {
                                                                        alert('Escolha um modelo de laudo antes de tentar visualizá-lo');
                                                                    }

                                                                }
<? if (($endereco != '')) { ?>
    <?
    if ($obj->_cpf != '') {
        $cpf = $obj->_cpf;
    } else {
        $cpf = 'null';
    }
    $url_enviar_ficha = "$endereco/webService/telaAtendimento/enviarFicha/$obj->_toten_fila_id/$obj->_nome/$cpf/$obj->_medico_parecer1/$obj->_medico_nome/$obj->_toten_sala_id/false";
    ?>
                                                                    $("#botaochamar").click(function () {
    //                                                                alert('<? //= $url_enviar_ficha  ?>');
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            data: {teste: 'teste'},
                                                                            //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
                                                                            url: "<?= $url_enviar_ficha ?>",
                                                                            success: function (data) {
                                                                                //                console.log(data);
                                                                                //                    alert(data.id);
                                                                                $("#idChamada").val(data.id);

                                                                            },
                                                                            error: function (data) {
                                                                                console.log(data);

                                                                            }
                                                                        });


                                                                        $.ajax({
                                                                            type: "POST",
                                                                            data: {teste: 'teste'},
                                                                            //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
                                                                            url: "<?= $endereco ?>/webService/telaChamado/proximo/<?= @$obj->_medico_parecer1 ?>/<?= @$obj->_toten_fila_id ?>/<?= @$obj->_toten_sala_id ?>",
                                                                                        success: function (data) {

                                                                                            alert('Operação efetuada com sucesso');


                                                                                        },
                                                                                        error: function (data) {
                                                                                            console.log(data);
                                                                                            alert('Erro ao chamar paciente');
                                                                                        }
                                                                                    });
                                                                                    $.ajax({
                                                                                        type: "POST",
                                                                                        data: {teste: 'teste'},
                                                                                        //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
                                                                                        url: "<?= $endereco ?>/webService/telaChamado/cancelar/<?= @$obj->_toten_fila_id ?>",
                                                                                                    success: function (data) {

                                                                                                        //                            alert('Operação efetuada com sucesso');


                                                                                                    },
                                                                                                    error: function (data) {
                                                                                                        console.log(data);
                                                                                                        //                            alert('Erro ao chamar paciente');
                                                                                                    }
                                                                                                });
                                                                                            });
<? } ?>



                                                                                        function muda(obj) {
                                                                                            if (obj.value == 'FINALIZADO') {
                                                                                                document.getElementById('titulosenha').style.display = "block";
                                                                                                document.getElementById('senha').style.display = "block";
                                                                                            } else {
                                                                                                document.getElementById('titulosenha').style.display = "none";
                                                                                                document.getElementById('senha').style.display = "none";
                                                                                            }
                                                                                        }


<?
//                                                            var_dump($laudo_sigiloso); die;
?>
                                                                                        var readonly = <?= $readonly ?>;

                                                                                        tinyMCE.init({
                                                                                            // General options
                                                                                            mode: "specific_textareas",
                                                                                            editor_selector: "laudo",
                                                                                            theme: "advanced",
                                                                                            readonly: readonly,
                                                                                            plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                                                                                            // Theme options
                                                                                            theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                                                                                            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,fullscreen",
                                                                                            theme_advanced_toolbar_location: "top",
                                                                                            theme_advanced_toolbar_align: "left",
                                                                                            theme_advanced_statusbar_location: "bottom",
                                                                                            theme_advanced_resizing: true,
                                                                                            browser_spellcheck: true,
                                                                                            // Example content CSS (should be your site CSS)
                                                                                            //                                    content_css : "css/content.css",
                                                                                            content_css: "js/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/img/content.css",
                                                                                            // Drop lists for link/image/media/template dialogs
                                                                                            template_external_list_url: "lists/template_list.js",
                                                                                            external_link_list_url: "lists/link_list.js",
                                                                                            external_image_list_url: "lists/image_list.js",
                                                                                            media_external_list_url: "lists/media_list.js",
                                                                                            // Style formats
                                                                                            style_formats: [
                                                                                                {title: 'Bold text', inline: 'b'},
                                                                                                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                                                                                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                                                                                {title: 'Example 1', inline: 'span', classes: 'example1'},
                                                                                                {title: 'Example 2', inline: 'span', classes: 'example2'},
                                                                                                {title: 'Table styles'},
                                                                                                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                                                                                            ],
                                                                                            // Replace values for the template plugin
                                                                                            template_replace_values: {
                                                                                                username: "Some User",
                                                                                                staffid: "991234"
                                                                                            }

                                                                                        });

                                                                                        tinyMCE.init({
                                                                                            // General options
                                                                                            mode: "specific_textareas",
                                                                                            editor_selector: "adendo",
                                                                                            theme: "advanced",

                                                                                            plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                                                                                            // Theme options
                                                                                            theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                                                                                            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,fullscreen",
                                                                                            theme_advanced_toolbar_location: "top",
                                                                                            theme_advanced_toolbar_align: "left",
                                                                                            theme_advanced_statusbar_location: "bottom",
                                                                                            theme_advanced_resizing: true,
                                                                                            browser_spellcheck: true,
                                                                                            // Example content CSS (should be your site CSS)
                                                                                            //                                    content_css : "css/content.css",
                                                                                            content_css: "js/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/img/content.css",
                                                                                            // Drop lists for link/image/media/template dialogs
                                                                                            template_external_list_url: "lists/template_list.js",
                                                                                            external_link_list_url: "lists/link_list.js",
                                                                                            external_image_list_url: "lists/image_list.js",
                                                                                            media_external_list_url: "lists/media_list.js",
                                                                                            // Style formats
                                                                                            style_formats: [
                                                                                                {title: 'Bold text', inline: 'b'},
                                                                                                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                                                                                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                                                                                {title: 'Example 1', inline: 'span', classes: 'example1'},
                                                                                                {title: 'Example 2', inline: 'span', classes: 'example2'},
                                                                                                {title: 'Table styles'},
                                                                                                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                                                                                            ],
                                                                                            // Replace values for the template plugin
                                                                                            template_replace_values: {
                                                                                                username: "Some User",
                                                                                                staffid: "991234"
                                                                                            }

                                                                                        });

                                                                                        $(function () {
                                                                                            $('#exame').change(function () {
                                                                                                if ($(this).val()) {
                                                                                                    //$('#laudo').hide();
                                                                                                    $('.carregando').show();
                                                                                                    $.getJSON('<?= base_url() ?>autocomplete/modeloslaudo', {exame: $(this).val(), ajax: true}, function (j) {
                                                                                                        options = "";

                                                                                                        options += j[0].texto;
                                                                                                        //                                                document.getElementById("laudo").value = options

                                                                                                        $('#laudo').val(options)
                                                                                                        var ed = tinyMCE.get('laudo');
                                                                                                        ed.setContent($('#laudo').val());

                                                                                                        //$('#laudo').val(options);
                                                                                                        //$('#laudo').html(options).show();
                                                                                                        //                                                $('.carregando').hide();
                                                                                                        //history.go(0) 
                                                                                                    });
                                                                                                } else {
                                                                                                    $('#laudo').html('value=""');
                                                                                                }
                                                                                            });
                                                                                        });

                                                                                        $(function () {
                                                                                            $('#linha').change(function () {
                                                                                                if ($(this).val()) {
                                                                                                    //$('#laudo').hide();
                                                                                                    $('.carregando').show();
                                                                                                    $.getJSON('<?= base_url() ?>autocomplete/modeloslinhas', {linha: $(this).val(), ajax: true}, function (j) {
                                                                                                        options = "";

                                                                                                        options += j[0].texto;
                                                                                                        //                                                document.getElementById("laudo").value = $('#laudo').val() + options
                                                                                                        $('#laudo').val() + options
                                                                                                        var ed = tinyMCE.get('laudo');
                                                                                                        ed.setContent($('#laudo').val());
                                                                                                        //$('#laudo').html(options).show();
                                                                                                    });
                                                                                                } else {
                                                                                                    $('#laudo').html('value=""');
                                                                                                }
                                                                                            });
                                                                                        });

                                                                                        $(function () {
                                                                                            $('#carimbo').change(function () {
//                                                                            alert('adasd');
                                                                                                if ($(this).prop('checked') == true) {
                                                                                                    //$('#laudo').hide();
                                                                                                    $('.carregando').show();
                                                                                                    $.getJSON('<?= base_url() ?>autocomplete/carimbomedico', {medico_id: $('#medico').val(), ajax: true}, function (j) {
                                                                                                        options = "";

                                                                                                        options += j[0].carimbo;
                                                                                                        tinyMCE.triggerSave(true, true);
                                                                                                        document.getElementById("laudo").value = $('#laudo').val() + j[0].carimbo;
                                                                                                        $('#laudo').val() + j[0].carimbo;
                                                                                                        var ed = tinyMCE.get('laudo');
                                                                                                        ed.setContent($('#laudo').val());
                                                                                                    });
                                                                                                } else {
                                                                                                    //$('#laudo').html('value=""');
                                                                                                }
                                                                                            });
                                                                                        });

                                                                                        $(function () {
                                                                                            $('#assinatura').change(function () {
//                                                                            alert('adasd');
                                                                                                if ($(this).prop('checked') == true) {
                                                                                                    //$('#laudo').hide();
                                                                                                    $('.carregando').show();
                                                                                                    $.getJSON('<?= base_url() ?>autocomplete/assinaturamedico', {medico_id: $('#medico').val(), ajax: true}, function (j) {
                                                                                                        options = "";
                                                                                                        console.log(j);
                                                                                                        options += j;
                                                                                                        tinyMCE.triggerSave(true, true);
                                                                                                        document.getElementById("laudo").value = $('#laudo').val() + j;
                                                                                                        $('#laudo').val() + j;
                                                                                                        var ed = tinyMCE.get('laudo');
                                                                                                        ed.setContent($('#laudo').val());
                                                                                                    });
                                                                                                } else {
                                                                                                    //$('#laudo').html('value=""');
                                                                                                }
                                                                                            });
                                                                                        });

                                                                                        $(function () {
                                                                                            $("#linha2").autocomplete({
                                                                                                source: "<?= base_url() ?>index.php?c=autocomplete&m=linhas",
                                                                                                minLength: 1,
                                                                                                focus: function (event, ui) {
                                                                                                    $("#linha2").val(ui.item.label);
                                                                                                    return false;
                                                                                                },
                                                                                                select: function (event, ui) {
                                                                                                    $("#linha2").val(ui.item.value);
                                                                                                    tinyMCE.triggerSave(true, true);
                                                                                                    document.getElementById("laudo").value = $('#laudo').val() + ui.item.id;
                                                                                                    $('#laudo').val() + ui.item.id;
                                                                                                    var ed = tinyMCE.get('laudo');
                                                                                                    ed.setContent($('#laudo').val());
                                                                                                    //$( "#laudo" ).val() + ui.item.id;
                                                                                                    document.getElementById("linha2").value = ''
                                                                                                    return false;
                                                                                                }
                                                                                            });
                                                                                        });

                                                                                        $(function (a) {
                                                                                            $('#anteriores').change(function () {
                                                                                                if ($(this).val()) {
                                                                                                    //$('#laudo').hide();
                                                                                                    $('.carregando').show();
                                                                                                    $.getJSON('<?= base_url() ?>autocomplete/laudosanteriores', {anteriores: $(this).val(), ajax: true}, function (i) {
                                                                                                        option = "";

                                                                                                        option = i[0].texto;
                                                                                                        tinyMCE.triggerSave();
                                                                                                        document.getElementById("laudo").value = option
                                                                                                        //$('#laudo').val(options);
                                                                                                        //$('#laudo').html(options).show();
                                                                                                        $('.carregando').hide();
                                                                                                        history.go(0)
                                                                                                    });
                                                                                                } else {
                                                                                                    $('#laudo').html('value="texto"');
                                                                                                }
                                                                                            });
                                                                                        });
                                                                                        //bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
                                                                                        $('.jqte-test').jqte();








                            </script>


                            <? if ($mensagem == 2) { ?>
                                <script type="text/javascript">
                                    alert("Sucesso ao finalizar Laudo");
                                </script>
                                <?
                            }
                            if ($mensagem == 1) {
                                ?>
                                <script type="text/javascript">
                                    alert("Erro ao finalizar Laudo");
                                </script>
                                <?
                            }
