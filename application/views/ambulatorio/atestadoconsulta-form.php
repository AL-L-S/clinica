<head>
    <title>Atestado</title>
</head>
<div >
    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');

    if (count($receita) == 0) {
        $receituario_id = 0;
        $texto = "";
        $medico = "";
    } else {
        $texto = $receita[0]->texto;
        $receituario_id = $receita[0]->ambulatorio_atestado_id;
        $medico = $receita[0]->medico_parecer1;
    }
    $operador_id = $this->session->userdata('operador_id');
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravaratestado/<?= $ambulatorio_laudo_id ?>" method="post">
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

                    </table>
                </fieldset>
                <div>

                    <fieldset>
                        <legend>Atestado</legend>
                        <div>
                            <label>CID Primario</label>
                            <input type="hidden" id="txtcid1ID" class="texto_id" name="cid1ID"  />
                            <input type="text" id="txtcid1" class="texto10" name="txtcid1"  />
                        </div>
                        <div>
                            <label>CID Secundario</label>
                            <input type="hidden" id="txtcid2ID" class="texto_id" name="cid2ID"  />
                            <input type="text" id="txtcid2" class="texto10" name="txtcid2"  />
                        </div>
                        <div><div class="bt_link_new"><a href="<?php echo base_url() ?>ambulatorio/modeloatestado/carregarmodeloatestado/0" target="_blank">
                                    Novo Modelo Atestado
                                </a></div>
                        </div>
                        <div>
                            <label>Modelos</label>
                            
                            <select name="exame" id="exame" class="size2" >
                                <option value='' ></option>
                                <option value=''  selected="">Selecione</option>
                                <?php foreach ($lista as $item) { ?>
                                    <option value="<?php echo $item->ambulatorio_modelo_atestado_id; ?>" ><?php echo $item->nome; ?></option>
                                <?php } ?>
                            </select>
                            <label>Data</label>
                            <input type="text" id="data" name="data" class="texto02" required/>

                            <label for="carimbo">Carimbo</label>
                            <input type="checkbox" id="carimbo"  name="carimbo" id="carimbo"/>

                            <label for="assinatura">Assinatura</label>
                            <input type="checkbox" id="assinatura" name="assinatura" id="assinatura"/>


                            <label for="imprimircid">Imprimir CID</label>
                            <input type="checkbox"  name="imprimircid" id="imprimircid" />
                        </div>
                        <div>
                            <input type="hidden" id="receituario_id" name="receituario_id" value="<?= $receituario_id ?>"/>
                            <input type="hidden" id="ambulatorio_laudo_id" name="ambulatorio_laudo_id" value="<?= $ambulatorio_laudo_id ?>"/>
                            <input type="hidden" id="medico" name="medico" value="<?= $operador_id ?>"/>
                        </div>
                        <div>
                            <textarea id="laudo" name="laudo" rows="25" cols="80" style="width: 80%"></textarea></td>
                        </div>
                        <table>
<!--                            <tr>

                                <td>
                                    &ensp;
                                </td>
                                <td>
                                    <div class="bt_link_new">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoatestado/<?= $ambulatorio_laudo_id ?>');">
                                            <center>Imprimir</center></a></div>

                            </tr>-->
                        </table>
                        <hr>
                        <div>
                        </div>
                        <button type="submit" name="btnEnviar">Salvar</button>
                    </fieldset>
                    </form>

                </div> 
            </div> 

            <?
            if (count($receita) > 0) {
                ?>
                <table id="table_agente_toxico" border="0">
                    <thead>
                        <tr>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Descri&ccedil;&atilde;o</th>
                            <th colspan="2" class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    foreach ($receita as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data_cadastro)); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->texto; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoatestado/<?= $item->ambulatorio_atestado_id; ?>');">Imprimir
                                        </a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/editarcarregaratestado/<?= $ambulatorio_laudo_id ?>/<?= $item->ambulatorio_atestado_id; ?>');">Editar
                                        </a></div>
                                </td>

                            </tr>

                        </tbody>
                        <?
                    }
                }
                ?>

            </table> 

            </fieldset>

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
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

                                            $(function () {
                                                $("#data").datepicker({
                                                    autosize: true,
                                                    changeYear: true,
                                                    changeMonth: true,
                                                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                                    dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                                    buttonImage: '<?= base_url() ?>img/form/date.png',
                                                    dateFormat: 'dd/mm/yy'
                                                });
                                            });

                                            $(function () {
                                                $("#txtcid1").autocomplete({
                                                    source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
                                                    minLength: 2,
                                                    focus: function (event, ui) {
                                                        $("#txtcid1").val(ui.item.label);
                                                        return false;
                                                    },
                                                    select: function (event, ui) {
                                                        $("#txtcid1").val(ui.item.value);
                                                        $("#txtcid1ID").val(ui.item.id);
                                                        return false;
                                                    }
                                                });
                                            });

                                            $(function () {
                                                $("#txtcid2").autocomplete({
                                                    source: "<?= base_url() ?>index.php?c=autocomplete&m=cid1",
                                                    minLength: 2,
                                                    focus: function (event, ui) {
                                                        $("#txtcid2").val(ui.item.label);
                                                        return false;
                                                    },
                                                    select: function (event, ui) {
                                                        $("#txtcid2").val(ui.item.value);
                                                        $("#txtcid2ID").val(ui.item.id);
                                                        return false;
                                                    }
                                                });
                                            });


                                            $(document).ready(function () {
                                                $('#sortable').sortable();
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
                                                        $.getJSON('<?= base_url() ?>autocomplete/modelosatestado', {exame: $(this).val(), ajax: true}, function (j) {
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









</script>
