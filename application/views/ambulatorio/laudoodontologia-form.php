<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/langs/pt_BR.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/plugins/spellchecker/plugin.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/themes/modern/theme.min.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/tinymce2/tinymce/jquery.tinymce.min.js"></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/tinymce2/tinymce/tinymce.min.js"></script>-->


<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<head>
    <title>Laudo Consulta</title>
</head>
<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
//    var_dump(isset($obj->_peso), isset($obj->_altura)); die;
    if (isset($obj->_peso)) {
        $peso = @$obj->_peso;
    } else {
        $peso = @$laudo_peso[0]->peso;
    }
    if (isset($obj->_altura)) {
        $altura = @$obj->_altura;
    } else {
        $altura = @$laudo_peso[0]->altura;
    }
//    var_dump($altura, $peso); die;
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravaranamineseodontologia/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr>
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>
                            <td>Solicitante: <?= @$obj->_solicitante ?></td>
                            <td rowspan="3"><img src="<?= base_url() ?>upload/webcam/pacientes/<?= $paciente_id ?>.jpg" width="100" height="120" /></td>
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                            <td>Sala:<?= @$obj->_sala ?></td>
                        </tr>
                        <tr><td>Sexo: <?= @$obj->_sexo ?></td>
                            <td>Convenio:<?= @$obj->_convenio; ?></td>
                            <td colspan="1" style="width: 200px">Telefone: <?= @$obj->_telefone ?></td>

                        </tr>

                        <tr>
                            <td colspan="2">Indicaçao: <?= @$obj->_indicacao ?></td>
                            
                            <!--<td>Indicacao: <?= @$obj->_indicado ?></td>-->
                        </tr>
                        <tr>
                            <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
                        </tr>
                    </table>
                </fieldset>
                <table>
                    <tr>
                    <td >
                        <div class="bt_link_new">
                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/chamarpaciente/<?= $ambulatorio_laudo_id ?>');" >
                                Chamar</a>
                        </div>
                    </td>
                    
                    <td>
                        <div class="bt_link_new">
                            <a onclick="javascript:window.open('<?= base_url() ?>cadastros/pacientes/carregarmedico/<?= $paciente_id ?>');" >
                                Editar</a></div>
                    </td>
                    
                        <? if (@$obj->_status != 'FINALIZADO') { ?>
                        <td>
                            <div class="bt_link_new">
                                <a href="<?= base_url() ?>ambulatorio/laudo/pendenteespecialidade/<?= $exame_id ?>" >
                                    Pendente
                                </a>
                            </div>
                        </td>
                        <? } ?>
                        
                        <td>
                            <div class="bt_link_new">
                                <a href="<?= base_url() ?>ambulatorio/laudo/encaminharatendimento/<?= $ambulatorio_laudo_id ?>" >
                                    Encaminhar
                                </a>
                            </div>
                        </td>
                    <td>
                        <div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/laudo/carregarlaudohistorico/<?= $paciente_id ?>">Hist. Consulta</a></div>
                    
                    </td>
                    
                    <td>
                        <div class="bt_link_new">
                            <a href="<?= base_url() ?>ambulatorio/laudo/caregarodontograma/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>">
                                Odontograma
                            </a>
                        </div>
                    </td>
                    
                        
                    </tr>
                </table>
                <div>

                    <fieldset>
                        <legend>MEDIDAS</legend>
                        <table>
                            <tr>
                                <td><font size = -1>Peso:</font></td>
                                <td width="50px;"><font size = -1><input type="text" name="Peso" id="Peso" class="texto01"  alt="decimal" onkeyup="validar(this, 'num');" value="<?= $peso ?>"/></font></td>
                                <td width="50px;"><font size = -1>Kg</font></td>
                                <td ><font size = -1>Altura:</font></td>
                                <td width="50px;"><font size = -1><input type="text" name="Altura" id="Altura" alt="integer" class="texto01" value="<?= $altura; ?>" onblur="calculaImc()"/></font></td> <!--onblur="history.go(0)"-->
                                <td width="50px;"><font size = -1>Cm</font></td>
                                <!--</tr>-->
                                <?
//                            $imc = 0;
//                            $peso =  @$obj->_peso;
//                            $altura = substr(@$obj->_altura, 0, 1) . "." .  substr(@$obj->_altura, 1, 2);
//                            $altura = floatval($altura);
//                            if($altura != 0){
//                            $imc = $peso / pow($altura, 2);
//                            }
                                ?>
                                <!--<tr>-->
                                <td><font size = -1>IMC</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="imc" id="imc" class="texto01"  readonly/></font></td>
                                <td width="30px;"></td>
<!--                                <td ><font size = -1></font></td>
                                <td width="60px;"></td>
                                <td width="60px;"></td>-->
                                <!--                            </tr>
                                                            <tr>-->
                                <td><font size = -1>Diabetes:</font></td>
                                <td colspan="2"><font size = -1>                            
                                    <select name="diabetes" id="diabetes" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='nao'<?
                                        if (@$obj->_diabetes == 'nao'):echo 'selected';
                                        endif;
                                        ?> >Não</option>
                                        <option value='sim' <?
                                        if (@$obj->_diabetes == 'sim'):echo 'selected';
                                        endif;
                                        ?> >Sim</option>
                                    </select><font></td>
                                <td width="20px;"></td>
                                <td><font size = -1>Hipertens&atilde;o:</font></td>
                                <td colspan="2"><font size = -1>                            
                                    <select name="hipertensao" id="hipertensao" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='nao'<?
                                        if (@$obj->_diabetes == 'nao'):echo 'selected';
                                        endif;
                                        ?> >Não</option>
                                        <option value='sim' <?
                                        if (@$obj->_diabetes == 'sim'):echo 'selected';
                                        endif;
                                        ?> >Sim</option>
                                    </select><font></td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
                <? if ($empresapermissao[0]->oftamologia == 't'&& @$obj->_grupo == 'OFTALMOLOGIA') { ?>
                    <script>
                        $(function () {
                            $("#tabs").tabs();
                        });

                        $(".tab-ativa").tabs("option", "active", 1);



                    </script>    

                <? }
                ?>


                <div>

                    <fieldset>
                        <div id="tabs">
                            <? if ($empresapermissao[0]->oftamologia == 't' && @$obj->_grupo == 'OFTALMOLOGIA') { ?>
                                <ul>
                                    <li><a class="tab-ativa" href="#tabs-2">Anamnese</a></li>
                                    <li><a href="#tabs-1">Oftamologia</a></li>
                                </ul>
                            <? }
                            ?>

                            <div id="tabs-2">
                                <? if ($empresapermissao[0]->oftamologia == 'f') { ?>
                                    <legend>Anamnese</legend>
                                <? }
                                ?>

                                <div>
                                    <label>Laudo</label>
                                    <select name="exame" id="exame" class="size2" >
                                        <option value='' >selecione</option>
                                        <?php foreach ($lista as $item) { ?>
                                            <option value="<?php echo $item->ambulatorio_modelo_laudo_id; ?>" ><?php echo $item->nome; ?></option>
                                        <?php } ?>
                                    </select>
                                    <?
                                    if (@$obj->_cabecalho == "") {
                                        $cabecalho = @$obj->_procedimento;
                                    } else {
                                        $cabecalho = @$obj->_cabecalho;
                                    }
                                    ?>
                                    <label>Queixa Principal</label>
                                    <input type="text" id="cabecalho" class="texto7" name="cabecalho" value="<?= $cabecalho ?>"/>
                                </div>
                                <!--<br>-->
                                <div>

                                    <!--                        </div>    
                                                            <div>-->
                                    <label>CID Primario</label>
                                    <input type="hidden" name="agrupadorfisioterapia" id="agrupadorfisioterapia" value="<?= @$obj->_agrupador_fisioterapia; ?>" class="size2" />
                                    <input type="hidden" name="txtCICPrimario" id="txtCICPrimario" value="<?= @$obj->_cid; ?>" class="size2" />
                                    <input type="text" name="txtCICPrimariolabel" id="txtCICPrimariolabel" value="<?= @$obj->_ciddescricao; ?>" class="size8" />

                                    <label>CID Secundario</label>
                                    <input type="hidden" name="txtCICSecundario" id="txtCICSecundario" value="<?= @$obj->_cid2; ?>" class="size2" />
                                    <input type="text" name="txtCICSecundariolabel" id="txtCICSecundariolabel" value="<?= @$obj->_cid2descricao; ?>" class="size8" />
                                </div>
                                <!--<br>-->
                                <div>

                                    <!--                        </div>    
                                                            <div>-->
                                    <label>Pesquisar Código TUSS</label>
                                    <input type="hidden" name="txtCodigoTuss" id="txtCodigoTuss" value="<?= @$obj->_cid; ?>" class="size2" />
                                    <input type="text" name="txtCodigoTusslabel" id="txtCodigoTusslabel" value="<?= @$obj->_ciddescricao; ?>" class="size8" />


                                </div>

                                <div>
                                    <table>
                                        <tr><td rowspan="7" >
                                                <textarea id="laudo" name="laudo" rows="30" cols="80" style="width: 80%"><?= @$obj->_texto; ?></textarea></td>
                                            <td width="40px;"><div class="bt_link_new">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarreceituario/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>');" >
                                                        Receituario</a></div>
                                            </td>
                                            <td rowspan="5" ><center>
                                            <font color="#FF0000" size="6" face="Arial Black"><span id="clock1"></span><script>setTimeout('getSecs()', 1000);</script></font></center>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td width="40px;"><div class="bt_link_new">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarreceituarioespecial/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>');" >
                                                        R. especial</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px;"><div class="bt_link_new">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarexames/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');" >
                                                        S. exames</a></div>
                                                <!--                                        impressaolaudo -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px;"><div class="bt_link_new">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaratestado/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>');" >
                                                        Atestado</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px;"><div class="bt_link_new">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/escolherdeclaracao/<?= $paciente_id ?>/<?= @$obj->_guia_id; ?>/<?= $agenda_exames_id ?>');" >
                                                        Declaração</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px;"><div class="bt_link_new">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $ambulatorio_laudo_id ?>');" >
                                                        Arquivos</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px;"><div class="bt_link_new">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/imprimirmodeloaih/<?= $ambulatorio_laudo_id ?>');" >
                                                        AIH</a></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px;"><div class="bt_link_new">
                                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');" >
                                                        Imprimir</a></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div>
                                    <label>M&eacute;dico respons&aacutevel</label>
                                    <select name="medico" id="medico" class="size2">
                                        <? foreach ($operadores as $value) : ?>
                                            <option value="<?= $value->operador_id; ?>"<?
                                            if (@$obj->_medico_parecer1 == $value->operador_id):echo "selected = 'true'";
                                            endif;
                                            ?>><?= $value->nome; ?></option>
                                                <? endforeach; ?>
                                    </select>
                                    <?php
                                    if (@$obj->_assinatura == "t") {
                                        ?>
                                        <input type="checkbox" name="assinatura" checked ="true" /><label>Assinatura</label>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="checkbox" name="assinatura"  /><label>Assinatura</label>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if (@$obj->_rodape == "t") {
                                        ?>
                                        <input type="checkbox" name="rodape" checked ="true" /><label>Rodape</label>
                                        <?php
                                    } else {
                                        ?>
                                        <input type="checkbox" name="rodape"  /><label>Rodape</label>
                                        <?php
                                    }
                                    ?>


                                    <label>situa&ccedil;&atilde;o</label>
                                    <select name="situacao" id="situacao" class="size2" ">
                                        <option value='DIGITANDO'<?
                                        if (@$obj->_status == 'DIGITANDO'):echo "selected = 'true'";
                                        endif;
                                        ?> >DIGITANDO</option>
                                        <option value='FINALIZADO' <?
                                        if (@$obj->_status == 'FINALIZADO'):echo "selected = 'true'";
                                        endif;
                                        ?> >FINALIZADO</option>
                                    </select>
                                    <input type="hidden" name="status" id="status" value="<?= @$obj->_status; ?>" class="size2" />
                                    
                                    <label style="margin-left: 10pt" for="ret">Retorno?</label>
                                    <input type="checkbox" name="ret" id="ret" <?=( (int)@$obj->_dias_retorno != '0') ? 'checked' : ''?>/>
                                    <div style="display: inline-block" class="dias_retorno_div">
                                        <input type="text" name="ret_dias" id="ret_dias" value="<?= @$obj->_dias_retorno; ?>" style="width: 80pt" />
                                    </div>

                                    <label style="margin-left: 10pt" for="rev">Revisão?</label>
                                    <input type="checkbox" name="rev" id="rev" />
                                    <div class="dias" style="display: inline">

                                    </div>
                                </div>
                            </div>
                            <div <?
                            if ($empresapermissao[0]->oftamologia == 't' && @$obj->_grupo == 'OFTALMOLOGIA') {
                                echo "style='display:inline;'";
                            }else{
                                echo "style='display:none;'";
                            }
                            ?> id="tabs-1">

                                <table>
                                    <tr style="text-align: left;">
                                        <th>
                                            Inspeção Geral 
                                        </th>
                                        <th>
                                            Motilidade Ocular 
                                        </th>
                                    </tr>
                                    <tr>

                                        <td>
                                            <!--<label></label>-->
                                            <textarea  id="inspecao_geral" name="inspecao_geral" rows="5" cols="60" style="resize: none"><?= @$obj->_inspecao_geral; ?></textarea>
                                        </td>
                                        <td>
                                            <!--<label></label>-->
                                            <textarea id="motilidade_ocular" name="motilidade_ocular" rows="5" cols="60" style="resize: none"><?= @$obj->_motilidade_ocular; ?></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <table border="0">
                                                <tr>
                                                    <th style="text-align:left" colspan="2">
                                                        <label>Acuidade Visual Sem Correção</label>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        OE <select name="acuidade_oe" id="acuidade_oe" class="size2">
                                                            <option value=""> </option>
                                                            <? foreach ($listaracuidadeoe as $value) : ?>
                                                                <option value="<?= $value->nome; ?>"<?
                                                                        if (@$obj->_acuidade_oe == $value->nome):echo "selected = 'true'";
                                                                        endif;
                                                                        ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                        </select> 
                                                    </td>
                                                    <td>
                                                        OD <select name="acuidade_od" id="acuidade_od" class="size2">
                                                            <option value=""> </option>
                                                            <? foreach ($listaracuidadeod as $value) : ?>
                                                                <option value="<?= $value->nome; ?>"<?
                                                                        if (@$obj->_acuidade_od == $value->nome):echo "selected = 'true'";
                                                                        endif;
                                                                        ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                        </select>   

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table border="0">
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    <input type="radio" name="refracao_retinoscopia" <?
                                                                    if (@$obj->_refracao_retinoscopia == 'refracao') {
                                                                        echo 'checked';
                                                                    }
                                                                    ?> value="refracao">
                                                                    <span>Refração</span>
                                                                </td>
                                                                <td>
                                                                    <input type="radio" name="refracao_retinoscopia" <?
                                                                    if (@$obj->_refracao_retinoscopia == 'retinoscopia') {
                                                                        echo 'checked';
                                                                    }
                                                                    ?> value="retinoscopia">
                                                                    <span>Retinoscopia</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="radio" name="dinamica_estatica" value="dinamica"<?
                                                                    if (@$obj->_dinamica_estatica == 'dinamica') {
                                                                        echo 'checked';
                                                                    }
                                                                    ?>>
                                                                    <span>Dinâmica</span>
                                                                </td>
                                                                <td>
                                                                    <input type="radio" name="dinamica_estatica" value="estatica"<?
                                                                    if (@$obj->_dinamica_estatica == 'estatica') {
                                                                        echo 'checked';
                                                                    }
                                                                    ?>>
                                                                    <span>Estática</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" name="carregar_refrator" <?
                                                                    if (@$obj->_carregar_refrator == 't') {
                                                                        echo 'checked';
                                                                    }
                                                                    ?>>
                                                                    <span>Carregar Refrator</span>
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="carregar_oculos"  <?
                                                                    if (@$obj->_carregar_oculos == 't') {
                                                                        echo 'checked';
                                                                    }
                                                                    ?>>
                                                                    <span>Carregar Óculos</span>
                                                                </td>
                                                            </tr>

                                                        </table>   
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Biomicroscopia</label>
                                            <textarea id="biomicroscopia" name="biomicroscopia" rows="5" cols="60" style="resize: none"><?= @$obj->_biomicroscopia; ?></textarea>
                                        </td>
                                        <td>
                                            <table border="0">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Esférico</th>
                                                        <th>Cilindrico</th>
                                                        <th>Eixo</th>
                                                        <th>A.V</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>OD </td>
                                                        <td>
                                                            <select name="oftamologia_od_esferico" id="oftamologia_od_esferico" class="size2">
                                                                <option value=""> </option>
                                                                <? foreach ($listarodes as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_od_esferico == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select name="oftamologia_od_cilindrico" id="oftamologia_od_cilindrico" class="size2">
                                                                <option value=""> </option>
                                                                <? foreach ($listarodcl as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_od_cilindrico == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select name="oftamologia_od_eixo" id="listarodes" class="size2">
                                                                <option value=""> </option>
                                                                <? foreach ($listarodeixo as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_od_eixo == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select name="oftamologia_od_av" id="listarodes" class="size2">
                                                                <option value="Selecione"></option>
                                                                <? foreach ($listarodav as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_od_av == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>OE </td>
                                                        <td>
                                                            <select name="oftamologia_oe_esferico" id="oftamologia_oe_esferico" class="size2">
                                                                <option value=""> </option>
                                                                <? foreach ($listaroees as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_oe_esferico == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select name="oftamologia_oe_cilindrico" id="oftamologia_oe_cilindrico" class="size2">
                                                                <option value=""> </option>
                                                                <? foreach ($listaroecl as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_oe_cilindrico == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select name="oftamologia_oe_eixo" id="oftamologia_oe_eixo" class="size2">
                                                                <option value=""> </option>
                                                                <? foreach ($listaroeeixo as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_oe_eixo == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select name="oftamologia_oe_av" id="oftamologia_oe_av" class="size2">
                                                                <option value=""> </option>
                                                                <? foreach ($listaroeav as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_oe_av == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>AD </td>
                                                        <td>
                                                            <select name="oftamologia_ad_esferico" id="oftamologia_ad_esferico" class="size2">
                                                                <option value=""> </option>
                                                                <? foreach ($listarades as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_ad_esferico == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>
                                                        <td>
                                                            <select name="oftamologia_ad_cilindrico" id="oftamologia_ad_cilindrico" class="size2">
                                                                <option value=""> </option>
                                                                <? foreach ($listaradcl as $value) : ?>
                                                                    <option value="<?= $value->nome; ?>"<?
                                                                            if (@$obj->_oftamologia_ad_cilindrico == $value->nome):echo "selected = 'true'";
                                                                            endif;
                                                                            ?>><?= $value->nome; ?></option>
<? endforeach; ?>
                                                            </select> 
                                                        </td>
                                                        <!--<td>-->
                                                        <td width="40px;"><div class="bt_link_new">
                                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoreceitaoculos/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>');" >
                                                                    Receita Óculos</a></div>
                                                        </td>
                                                        <!--</td>-->


                                                    </tr>
                                                </tbody>
                                            </table>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table border="0">
                                                <thead>
                                                    <tr>
                                                        <th>Pressão Ocular</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            OD <input step="0.01" type="number" name="pressao_ocular_od" value="<?= @$obj->_pressao_ocular_od ?>">    
                                                        </td>

                                                        <td>
                                                            OE <input step="0.01" type="number" name="pressao_ocular_oe"  value="<?= @$obj->_pressao_ocular_oe ?>">    
                                                        </td>
                                                        <td>
                                                            Hora <input  type="text" id="refracao_retinoscopia_hora" name="pressao_ocular_hora" value="<?= @$obj->_pressao_ocular_hora ?>">    
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>
                                    <tr style="text-align: left;">
                                        <th>
                                            Mapeamento de Retinas  
                                        </th>
                                        <th>
                                            Conduta   
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <!--<label></label>-->
                                            <textarea id="mapeamento_retinas" name="mapeamento_retinas" rows="5" cols="60" style="resize: none"><?= @$obj->_mapeamento_retinas; ?></textarea>    
                                        </td>

                                        <td>
                                            <!--<label></label>-->
                                            <textarea id="conduta" name="conduta" rows="5" cols="60" style="resize: none"><?= @$obj->_conduta; ?></textarea>   
                                        </td>
                                    </tr>
                                </table>




                            </div>

                        </div>

                        <hr>
                        <button type="submit" name="btnEnviar">Salvar</button>
                        <div class="bt_link_new" style="display: inline-block">
                            <a onclick="javascript:window.open('<?= base_url() ?>centrocirurgico/centrocirurgico/novasolicitacaoconsulta/<?= $exame_id ?>');" >
                                Solicitar Cirurgia
                            </a>
                        </div>
                    </fieldset>
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

                                        <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $ambulatorio_laudo_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/consulta/" . $ambulatorio_laudo_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?><br><a href="<?= base_url() ?>ambulatorio/laudo/excluirimagemlaudo/<?= $ambulatorio_laudo_id ?>/<?= $value ?>">Excluir</a></td>
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
<? foreach ($historico as $item) {
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

                    <fieldset>
                        <legend><b><font size="3" color="red">Historico de exames</font></b></legend>
                        <div>
                            <table>
                                <tbody>
<? foreach ($historicoexame as $item) {
    ?>

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
//        $data['arquivo_pasta'] = directory_map("/home/vivi/projetos/clinica/upload/$exame_id/");
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

<? }
?>
                                </tbody>
                            </table>
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
                    </form>

                </div> 
            </div> 
    </div> 
</div> <!-- Final da DIV content -->
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 1300px; }
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
</style>
<!--<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>-->

<script type="text/javascript">
    jQuery('#rev').change(function () {
        if (this.checked) {
            var tag = '<table><tr><td><input type="radio" name="tempoRevisao" value="1a"><span>1 ano</span></td></tr><tr><td><input type="radio" name="tempoRevisao" value="6m" required><span>6 meses</span></td></tr><tr><td><input type="radio" name="tempoRevisao" value="3m"><span>3 meses</span></td></tr><tr><td><input type="radio" name="tempoRevisao" value="1m"><span>1 mes</span></td></tr></table>';
            jQuery(".dias").append(tag);
        } else {
            jQuery(".dias span").remove();
            jQuery(".dias input").remove();
        }
    });
    
    <? if ( (int)@$obj->_dias_retorno != '0') {?>
        jQuery(".dias_retorno_div").show();
    <?} else {?>
        jQuery(".dias_retorno_div").hide();
    <? } ?>
        
    jQuery('#ret').change(function () {
        if ( this.checked ) {
            jQuery(".dias_retorno_div").show();
        } else {
            jQuery(".dias_retorno_div").hide();
        }
    });
    
    jQuery("#Altura").mask("999", {placeholder: " "});
//                                                    jQuery("#Peso").mask("999", {placeholder: " "});

////////// ORDENANDO OS SELECTS DA OFTAMOLOGIA//////////////////

    function oftamologia_od_esferico() {
        var itensOrdenados = $('#oftamologia_od_esferico option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_od_esferico').html(itensOrdenados);
<? if (@$obj->_oftamologia_od_esferico != '') { ?>
            var teste = '<?= @$obj->_oftamologia_od_esferico ?>';
            //        alert(teste);
            $('#oftamologia_od_esferico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_od_esferico').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_od_esferico();

    function oftamologia_oe_esferico() {
        var itensOrdenados = $('#oftamologia_oe_esferico option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_oe_esferico').html(itensOrdenados);
<? if (@$obj->_oftamologia_oe_esferico != '') { ?>
            var teste = '<?= @$obj->_oftamologia_oe_esferico ?>';
            //        alert(teste);
            $('#oftamologia_oe_esferico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_oe_esferico').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_oe_esferico();

    function oftamologia_od_cilindrico() {
        var itensOrdenados = $('#oftamologia_od_cilindrico option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_od_cilindrico').html(itensOrdenados);
<? if (@$obj->_oftamologia_od_cilindrico != '') { ?>
            var teste = '<?= @$obj->_oftamologia_od_cilindrico ?>';
            //        alert(teste);
            $('#oftamologia_od_cilindrico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_od_cilindrico').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_od_cilindrico();

    function oftamologia_oe_cilindrico() {
        var itensOrdenados = $('#oftamologia_oe_cilindrico option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_oe_cilindrico').html(itensOrdenados);
<? if (@$obj->_oftamologia_oe_cilindrico != '') { ?>
            var teste = '<?= @$obj->_oftamologia_oe_cilindrico ?>';
            $('#oftamologia_oe_cilindrico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_oe_cilindrico').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_oe_cilindrico();

    function oftamologia_oe_eixo() {
        var itensOrdenados = $('#oftamologia_oe_eixo option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_oe_eixo').html(itensOrdenados);
<? if (@$obj->_oftamologia_oe_eixo != '') { ?>
            var teste = '<?= @$obj->_oftamologia_oe_eixo ?>';
            //        alert(teste);
            $('#oftamologia_oe_eixo').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_oe_eixo').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_oe_eixo();

    function oftamologia_oe_av() {
        var itensOrdenados = $('#oftamologia_oe_av option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_oe_av').html(itensOrdenados);
<? if (@$obj->_oftamologia_oe_av != '') { ?>
            var teste = '<?= @$obj->_oftamologia_oe_av ?>';
            //        alert(teste);
            $('#oftamologia_oe_av').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_oe_av').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_oe_av();

    function oftamologia_od_eixo() {
        var itensOrdenados = $('#oftamologia_od_eixo option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_od_eixo').html(itensOrdenados);
<? if (@$obj->_oftamologia_od_eixo != '') { ?>
            var teste = '<?= @$obj->_oftamologia_od_eixo ?>';
            //        alert(teste);
            $('#oftamologia_od_eixo').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_od_eixo').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_od_eixo();

    function oftamologia_od_av() {
        var itensOrdenados = $('#oftamologia_od_av option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_od_av').html(itensOrdenados);
<? if (@$obj->_oftamologia_od_av != '') { ?>
            var teste = '<?= @$obj->_oftamologia_od_av ?>';
            //        alert(teste);
            $('#oftamologia_od_av').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_od_av').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_od_av();


    function oftamologia_ad_esferico() {
        var itensOrdenados = $('#oftamologia_ad_esferico option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_ad_esferico').html(itensOrdenados);
<? if (@$obj->_oftamologia_ad_esferico != '') { ?>
            var teste = '<?= @$obj->_oftamologia_ad_esferico ?>';
            //        alert(teste);
            $('#oftamologia_ad_esferico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_ad_esferico').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_ad_esferico();

    function oftamologia_ad_cilindrico() {
        var itensOrdenados = $('#oftamologia_ad_cilindrico option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#oftamologia_ad_cilindrico').html(itensOrdenados);
<? if (@$obj->_oftamologia_ad_cilindrico != '') { ?>
            var teste = '<?= @$obj->_oftamologia_ad_cilindrico ?>';
            //        alert(teste);
            $('#oftamologia_ad_cilindrico').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#oftamologia_ad_cilindrico').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    oftamologia_ad_cilindrico();


    function acuidade_oe() {
        var itensOrdenados = $('#acuidade_oe option').sort(function (a, b) {
            return a.text < b.text ? -1 : 1;
        });

        $('#acuidade_oe').html(itensOrdenados);
<? if (@$obj->_acuidade_oe != '') { ?>
            var teste = '<?= @$obj->_acuidade_oe ?>';
            //        alert(teste);
            $('#acuidade_oe').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#acuidade_oe').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    acuidade_oe();


    function acuidade_od() {
        var acuidade_oditensOrdenados = $('#acuidade_od option').sort(function (a, b) {
//                        alert(b.text);
            return a.text < b.text ? -1 : 1;
        });
//        console.log(acuidade_oditensOrdenados);
        $('#acuidade_od').html(acuidade_oditensOrdenados);
<? if (@$obj->_acuidade_od != '') { ?>
            var teste = '<?= @$obj->_acuidade_od ?>';
            //        alert(teste);
            $('#acuidade_od').find('option:contains("' + teste + '")').prop('selected', true);
<? } else { ?>
            $('#acuidade_od').find('option:contains(" ")').prop('selected', true);
<? } ?>
    }
    acuidade_od();


//////////////////////////////////////////////////



    function validar(dom, tipo) {
        switch (tipo) {
            case'num':
                var regex = /[A-Za-z]/g;
                break;
            case'text':
                var regex = /\d/g;
                break;
        }
        dom.value = dom.value.replace(regex, '');
    }


    pesob1 = document.getElementById('Peso').value;
    peso = parseFloat(pesob1.replace(',', '.'));
//                                        peso = pesob1.substring(0, 2)  + "." + pesob1.substring(3, 1);
    alturae1 = document.getElementById('Altura').value;
    var res = alturae1.substring(0, 1) + "." + alturae1.substring(1, 3);
    var altura = parseFloat(res);
    imc = peso / Math.pow(altura, 2);
    //imc = res;
    resultado = imc.toFixed(2)
    document.getElementById('imc').value = resultado.replace('.', ',');

    function calculaImc() {
        pesob1 = document.getElementById('Peso').value;
        peso = parseFloat(pesob1.replace(',', '.'));
        //                                        peso = pesob1.substring(0, 2)  + "." + pesob1.substring(3, 1);
        alturae1 = document.getElementById('Altura').value;
        var res = alturae1.substring(0, 1) + "." + alturae1.substring(1, 3);
        var altura = parseFloat(res);
        imc = peso / Math.pow(altura, 2);
        //imc = res;
        resultado = imc.toFixed(2)
        document.getElementById('imc').value = resultado.replace('.', ',');
    }



    var sHors = "0" + 0;
    var sMins = "0" + 0;
    var sSecs = -1;
    function getSecs() {
        sSecs++;
        if (sSecs == 60) {
            sSecs = 0;
            sMins++;
            if (sMins <= 9)
                sMins = "0" + sMins;
        }
        if (sMins == 60) {
            sMins = "0" + 0;
            sHors++;
            if (sHors <= 9)
                sHors = "0" + sHors;
        }
        if (sSecs <= 9)
            sSecs = "0" + sSecs;
        clock1.innerHTML = sHors + "<font color=#000000>:</font>" + sMins + "<font color=#000000>:</font>" + sSecs;
        setTimeout('getSecs()', 1000);
    }


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



    function muda(obj) {
        if (obj.value != 'DIGITANDO') {
            document.getElementById('titulosenha').style.display = "block";
            document.getElementById('senha').style.display = "block";
        } else {
            document.getElementById('titulosenha').style.display = "none";
            document.getElementById('senha').style.display = "none";
        }
    }


    $(function () {
        $("#txtCICPrimariolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCICPrimariolabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCICPrimariolabel").val(ui.item.value);
                $("#txtCICPrimario").val(ui.item.id);
                return false;
            }
        });
    });
    $(function () {
        $("#txtCodigoTusslabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentotusspesquisa",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCodigoTusslabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCodigoTusslabel").val(ui.item.value);
                $("#txtCodigoTuss").val(ui.item.id);
//                                                                $("#txtcodigo").val(ui.item.codigo);
//                                                                $("#txtdescricao").val(ui.item.descricao);
                return false;
            }
        });
    });

    $(function () {
        $("#txtCICSecundariolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCICSecundariolabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCICSecundariolabel").val(ui.item.value);
                $("#txtCICSecundario").val(ui.item.id);
                return false;
            }
        });
    });

    tinyMCE.init({
        // General options
        mode: "exact",
        elements: "laudo",
        theme: "advanced",
//                                                        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
        menubar: "tools",
        toolbar: "spellchecker",
        spellchecker_languages: 'pt_BR',
        browser_spellcheck: true,
        theme_url: 'js/tinymce/jscripts/tiny_mce/themes/modern/theme.min.js',
//                                                        external_plugins: 'js/tinymce/jscripts/tiny_mce/plugins/spellchecker/plugin.min.js',

        // Theme options
        theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
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
                document.getElementById("laudo").value = $('#laudo').val() + ui.item.id
                $('#laudo').val() + ui.item.id
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

