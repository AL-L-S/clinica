<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravaranaminese/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>" method="post">
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
                            <td width="40px;"><div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/chamarpaciente/<?= $ambulatorio_laudo_id ?>');" >
                                        chamar</a></div>
                                <!--                                        impressaolaudo -->
                            </td>
                        </tr>
                        
                        <tr><td>Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero ?></td>
                    </table>
                </fieldset>
                <div>

                    <fieldset>
                        <legend>MEDIDAS</legend>
                        <table>
                            <tr>
                                <td><font size = -1>Peso:</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="Peso" id="Peso" class="texto01"  alt="decimal" value="<?= number_format(@$obj->_peso, 2, ",", "."); ?>"/></font></td>
                                <td width="60px;"><font size = -1>Kg</font></td>
                                <td ><font size = -1>Altura:</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="Altura" id="Altura" alt="integer" class="texto01" value="<?= @$obj->_altura; ?>" onblur="history.go(0)"/></font></td>
                                <td width="60px;"><font size = -1>Cm</font></td>
                            </tr>
                            <?
//                            $imc = 0;
//                            $peso =  @$obj->_peso;
//                            $altura = substr(@$obj->_altura, 0, 1) . "." .  substr(@$obj->_altura, 1, 2);
//                            $altura = floatval($altura);
//                            if($altura != 0){
//                            $imc = $peso / pow($altura, 2);
//                            }
                            ?>
                            <tr>
                                <td><font size = -1>IMC</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="imc" id="imc" class="texto01"  readonly/></font></td>
                                <td width="60px;"></td>
                                <td ><font size = -1></font></td>
                                <td width="60px;"></td>
                                <td width="60px;"></td>
                            </tr>
                            <tr>
                                <td><font size = -1>Diabetes:</font></td>
                                <td colspan="2"><font size = -1>                            
                                    <select name="diabetes" id="diabetes" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='nao'<?
                                        if (@$obj->_diabetes == 'nao'):echo 'selected';
                                        endif;
                                        ?> >nao</option>
                                        <option value='sim' <?
                                        if (@$obj->_diabetes == 'sim'):echo 'selected';
                                        endif;
                                        ?> >sim</option>
                                    </select><font></td>
                                <td><font size = -1>Hipertens&atilde;o:</font></td>
                                <td colspan="2"><font size = -1>                            
                                    <select name="hipertensao" id="hipertensao" class="size1">
                                        <option value=''>SELECIONE</option>
                                        <option value='nao'<?
                                        if (@$obj->_diabetes == 'nao'):echo 'selected';
                                        endif;
                                        ?> >nao</option>
                                        <option value='sim' <?
                                        if (@$obj->_diabetes == 'sim'):echo 'selected';
                                        endif;
                                        ?> >sim</option>
                                    </select><font></td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
                <div>

                    <fieldset>
                        <legend>Anamnese</legend>
                        <label>Laudo</label>
                        <select name="exame" id="exame" class="size2" >
                            <option value='' >selecione</option>
                            <?php foreach ($lista as $item) { ?>
                                <option value="<?php echo $item->ambulatorio_modelo_laudo_id; ?>" ><?php echo $item->nome; ?></option>
                            <?php } ?>
                        </select>


                        <div>
                            <?
                            if (@$obj->_cabecalho == "") {
                                $cabecalho = @$obj->_procedimento;
                            } else {
                                $cabecalho = @$obj->_cabecalho;
                            }
                            ?>
                            <label>Queixa Principal</label>
                            <input type="text" id="cabecalho" class="texto7" name="cabecalho" value="<?= $cabecalho ?>"/>

                            <label>CID</label>
                            <input type="hidden" name="agrupadorfisioterapia" id="agrupadorfisioterapia" value="<?= @$obj->_agrupador_fisioterapia; ?>" class="size2" />
                            <input type="hidden" name="txtCICPrimario" id="txtCICPrimario" value="<?= @$obj->_cid; ?>" class="size2" />
                            <input type="text" name="txtCICPrimariolabel" id="txtCICPrimariolabel" value="<?= @$obj->_ciddescricao; ?>" class="size8" />
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
                                    if (@$obj->_medico_parecer1 == $value->operador_id):echo 'selected';
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
                                if (@$obj->_status == 'DIGITANDO'):echo 'selected';
                                endif;
                                ?> >DIGITANDO</option>
                                <option value='FINALIZADO' <?
                                if (@$obj->_status == 'FINALIZADO'):echo 'selected';
                                endif;
                                ?> >FINALIZADO</option>
                            </select>
                        </div>
                        <hr>
                        <button type="submit" name="btnEnviar">Salvar</button>
                        <div class="bt_link_new" style="display: inline-block">
                            <a onclick="javascript:window.open('<?= base_url() ?>centrocirurgico/centrocirurgico/novasolicitacaoconsulta/<?= $exame_id ?>');" >
                                Solicitar Cirurgia
                            </a>
                        </div>
                    </fieldset>
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
                                                $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/consulta/$item->ambulatorio_laudo_id/");

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
                                            $arquivo_pastaimagem = directory_map("/home/sisprod/projetos/clinica/upload/$item->exames_id/");
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
                                                $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/consulta/$item->ambulatorio_laudo_id/");

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

                                            tinyMCE.init({
                                                // General options
                                                mode: "textareas",
                                                theme: "advanced",
                                                plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
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

