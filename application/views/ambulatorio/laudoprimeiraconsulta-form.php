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
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr><td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>
                            <td>Solicitante: <?= @$obj->_solicitante ?></td>
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                            <td>Sala:<?= @$obj->_sala ?></td>
                        </tr>
                        <tr><td>Sexo: <?= @$obj->_sexo ?></td>
                            <td>Convenio:<?= @$obj->_convenio; ?></td>
                            <td></td>
                            <td rowspan="3"><img src="<?= base_url() ?>upload/webcam/pacientes/<?= $paciente_id ?>.jpg"  height="120" width="100" /></td>
                        </tr>
                    </table>
                </fieldset>
                <div>

                    <fieldset>
                        <legend>MEDIDAS</legend>
                        <table>
                            <tr>
                                <td><font size = -1>Peso:</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="Peso" id="Peso" class="texto01" value="<?= @$obj->_peso; ?>"/></font></td>
                                <td width="60px;"><font size = -1>Kg</font></td>
                                <td ><font size = -1>Altura:</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="Altura" id="Altura" class="texto01" value="<?= @$obj->_altura; ?>"/></font></td>
                                <td width="60px;"><font size = -1>Cm</font></td>
                            </tr>
                            <tr>
                                <td><font size = -1>Diabetes:</font></td>
                                <td colspan="2"><font size = -1>                            <select name="diabetes" id="diabetes" class="size1">
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
                                <td colspan="2"><font size = -1>                            <select name="hipertensao" id="hipertensao" class="size1">
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

                <fieldset>
                    <legend>Queixa Princioal</legend>


                    <div>
                        <table>
                            <tr><td rowspan="6" >
                                    <textarea id="laudo" name="laudo" rows="10" cols="80" style="width: 80%"><?= @$obj->_texto; ?></textarea></td>

                                <td rowspan="5" ><center>
                                <font color="#FF0000" size="6" face="Arial Black"><span id="clock1"></span><script>setTimeout('getSecs()', 1000);</script></font></center>
                            </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <table>
                            <tr>
                                <td width="40px;"><div class="bt_link_new">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarreceituario/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>');" >
                                            Receituario</a></div>
                                </td>
                                <td width="40px;"><div class="bt_link_new">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarreceituarioespecial/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>');" >
                                            R. especial</a></div>
                                </td>
                                <td width="40px;"><div class="bt_link_new">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarreceituario/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>');" >
                                            Atestado</a></div>
                                </td>
                                <td width="40px;"><div class="bt_link_new">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $ambulatorio_laudo_id ?>');" >
                                            Arquivos</a></div>
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

                        <label>CID</label>
                        <input type="hidden" name="agrupadorfisioterapia" id="agrupadorfisioterapia" value="0" class="size2" />
                        <input type="hidden" name="txtCICPrimario" id="txtCICPrimario" value="<?= @$obj->_cid; ?>" class="size2" />
                        <input type="text" name="txtCICPrimariolabel" id="txtCICPrimariolabel" value="<?= @$obj->_ciddescricao; ?>" class="size8" />
                    </div>
            </div>
            <div>
                <fieldset>
                    <legend>Primeira consulta</legend>
                    <div>
                        <table>
                            <tr>
                                <td><font size = -1>HDA</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="hda" id="hda" class="texto12" value="<?= @$obj->_hda; ?>"/></font></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
            </div>
            <div>
                <fieldset>
                    <legend>Exames Complementares</legend>
                    <div>
                        <table>
                            <tr>
                                <td><font size = -1>MMG</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="mmg" id="mmg" class="texto12" value="<?= @$obj->_mmg; ?>"/></font></td>
                            <tr>
                            </tr>
                            <td ><font size = -1>USG</font></td>
                            <td width="60px;"><font size = -1><input type="text" name="usg" id="usg" class="texto12" value="<?= @$obj->_usg; ?>"/></font></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
            </div>
            <div>
                <fieldset>
                    <legend>Antecedentes</legend>
                    <div>
                        <table>
                            <tr>
                                <td><font size = -1>Menarca</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="menarca" id="menarca" class="texto06" value="<?= @$obj->_menarca; ?>"/></font></td>

                                <td ><font size = -1>Dum</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="dum" id="dum" class="texto06" value="<?= @$obj->_dum; ?>"/></font></td>
                            </tr>
                            <tr>
                                <td><font size = -1>GPA</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="gpa" id="gpa" class="texto06" value="<?= @$obj->_gpa; ?>"/></font></td>

                                <td ><font size = -1>ACO</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="aco" id="aco" class="texto06" value="<?= @$obj->_aco; ?>"/></font></td>
                            </tr>
                            <tr>
                                <td><font size = -1>1 PARTO</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="primeiro_parto" id="primeiro_parto" class="texto06" value="<?= @$obj->_primeiro_parto; ?>"/></font></td>

                                <td ><font size = -1>Menopausa</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="menopausa" id="menopausa" class="texto06" value="<?= @$obj->_menopausa; ?>"/></font></td>
                            </tr>
                            <tr>
                                <td><font size = -1>Aleitamento</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="aleitamento" id="aleitamento" class="texto06" value="<?= @$obj->_aleitamento; ?>"/></font></td>

                                <td ><font size = -1>TH</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="th" id="th" class="texto06" value="<?= @$obj->_th; ?>"/></font></td>
                            </tr>
                            <tr>
                                <td ><font size = -1>Hist. Familiar</font></td>
                                <td width="60px;" colspan="3"><font size = -1><input type="text" name="historico_familiar" id="historico_familiar" class="texto12" value="<?= @$obj->_historico_familiar; ?>"/></font></td>
                            </tr>
                            <tr>
                                <td ><font size = -1>Cirurgias</font></td>
                                <td width="60px;" colspan="3"><font size = -1><input type="text" name="cirurgias" id="cirurgias" class="texto12" value="<?= @$obj->_cirurgias; ?>"/></font></td>
                            </tr>
                            <tr>
                                <td ><font size = -1>Comorbidades</font></td>
                                <td width="60px;" colspan="3"><font size = -1><input type="text" name="comorbidades" id="comorbidades" class="texto12" value="<?= @$obj->_comorbidades; ?>"/></font></td>
                            </tr>
                            <tr>
                                <td ><font size = -1>Alergias</font></td>
                                <td width="60px;" colspan="3"><font size = -1><input type="text" name="alergias" id="alergias" class="texto12" value="<?= @$obj->_alergias; ?>"/></font></td>
                            </tr>
                            <tr>
                                <td ><font size = -1>Tabagismo</font></td>
                                <td width="60px;" colspan="3"><font size = -1><input type="text" name="tabagismo" id="tabagismo" class="texto12" value="<?= @$obj->_tabagismo; ?>"/></font></td>
                            </tr>
                            <tr>
                                <td ><font size = -1>Etilismo</font></td>
                                <td width="60px;" colspan="3"><font size = -1><input type="text" name="etilismo" id="etilismo" class="texto12" value="<?= @$obj->_etilismo; ?>"/></font></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
            </div>
            <div>
                <fieldset>
                    <legend>Exame Fisico</legend>
                    <div>
                        <table>
                            <tr>
                                <td><font size = -1>Exa Fisico</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="exame_fisico" id="exame_fisico" class="texto12" value="<?= @$obj->_exame_fisico; ?>"/></font></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
            </div>
            <div>
                <fieldset>
                    <legend>Hipotese Diagnostica / Conduta</legend>
                    <div>
                        <table>
                            <tr>
                                <td><font size = -1>HD</font></td>
                                <td width="60px;"><font size = -1><input type="text" name="hd" id="hd" class="texto12" value="<?= @$obj->_hd; ?>"/></font></td>
                            <tr>
                            </tr>
                            <td ><font size = -1>CD</font></td>
                            <td width="60px;"><font size = -1><input type="text" name="cd" id="cd" class="texto12" value="<?= @$obj->_cd; ?>"/></font></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
            </div>
            <div>

                <hr>
                <button type="submit" name="btnEnviar">Salvar</button>
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
                                        <td >Queixa principal: <?= $itens->laudo; ?></td>
                                    </tr>
                                    <tr>
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


                                    $(document).ready(function() {
                                        $('#sortable').sortable();
                                    });


                                    $(document).ready(function() {
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


                                    $(function() {
                                        $("#txtCICPrimariolabel").autocomplete({
                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
                                            minLength: 3,
                                            focus: function(event, ui) {
                                                $("#txtCICPrimariolabel").val(ui.item.label);
                                                return false;
                                            },
                                            select: function(event, ui) {
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

                                    $(function() {
                                        $('#exame').change(function() {
                                            if ($(this).val()) {
                                                //$('#laudo').hide();
                                                $('.carregando').show();
                                                $.getJSON('<?= base_url() ?>autocomplete/modeloslaudo', {exame: $(this).val(), ajax: true}, function(j) {
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

                                    $(function() {
                                        $('#linha').change(function() {
                                            if ($(this).val()) {
                                                //$('#laudo').hide();
                                                $('.carregando').show();
                                                $.getJSON('<?= base_url() ?>autocomplete/modeloslinhas', {linha: $(this).val(), ajax: true}, function(j) {
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

                                    $(function() {
                                        $("#linha2").autocomplete({
                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=linhas",
                                            minLength: 1,
                                            focus: function(event, ui) {
                                                $("#linha2").val(ui.item.label);
                                                return false;
                                            },
                                            select: function(event, ui) {
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

                                    $(function(a) {
                                        $('#anteriores').change(function() {
                                            if ($(this).val()) {
                                                //$('#laudo').hide();
                                                $('.carregando').show();
                                                $.getJSON('<?= base_url() ?>autocomplete/laudosanteriores', {anteriores: $(this).val(), ajax: true}, function(i) {
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

