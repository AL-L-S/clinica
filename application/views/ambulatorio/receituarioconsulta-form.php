<head>
    <title>Receituário</title>
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
        $procedimento;
    } else {
        $procedimento = $receita[0]->procedimento;
        $texto = $receita[0]->texto;
        $receituario_id = $receita[0]->ambulatorio_receituario_id;
        $medico = $receita[0]->medico_parecer1;
    }
    $operador_id = $this->session->userdata('operador_id');
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarreceituario/<?= $ambulatorio_laudo_id ?>" method="post">
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
                <table>
                    <tr>
                        <td>
                            <div class="bt_link_new" style="width: 200px; margin: 5px">
                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/modeloreceita');" style="width: 250px; margin: 5px">
                                    Modelo Receituario</a></div>
                        </td>
                        <td>
                            <div class="bt_link_new" style="width: 200px; margin: 5px">
                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/modelomedicamento');" style="width: 250px; margin: 5px">
                                    Modelo Medicamento</a></div>
                        </td>
                    </tr>
                </table>
                <div>

                    <fieldset>
                        <legend>Receituario</legend>
                        <div>
                            <label>Modelos</label>
                            <select name="exame" id="exame" class="size2" >
                                <option value='' >selecione</option>
                                <?php foreach ($lista as $item) { ?>
                                    <option value="<?php echo $item->ambulatorio_modelo_receita_id; ?>" ><?php echo $item->nome; ?></option>
                                <?php } ?>
                            </select>

                            <label>Medicamento</label>
                            <input type="text" id="medicamento" class="texto02" name="medicamento"/>

                            <label>Carimbo</label>
                            <input type="checkbox" id="carimbo"  name="carimbo"/>

                            <label>Assinatura</label>
                            <input type="checkbox" id="assinatura" name="assinatura"/>

                        </div>
                        <div>
                            <input type="hidden" id="receituario_id" name="receituario_id" value="<?= $receituario_id ?>"/>
                            <input type="hidden" id="ambulatorio_laudo_id" name="ambulatorio_laudo_id" value="<?= $ambulatorio_laudo_id ?>"/>
                            <input type="hidden" id="medico" name="medico" value="<?= $operador_id ?>"/>
                        </div>
                        <div>

                            <textarea id="laudo" name="laudo" rows="25" cols="80" style="width: 80%">
                                <? //var_dump($modelo);die;
                                if (@$empresapermissao[0]->carregar_modelo_receituario == 't') {
                                    if (count($modelo) > 0) {
                                        if (file_exists("upload/1ASSINATURAS/" . @$laudo['0']->medico_parecer1 . ".jpg")) {
                                            $assinatura = "<img   width='200px' height='100px' src='" . base_url() . "./upload/1ASSINATURAS/" . @$laudo['0']->medico_parecer1 . ".jpg'>";
                                        } else {
                                            $assinatura = "";
                                        }
                                        $corpo = $modelo[0]->texto;
                                        $corpo = str_replace("_paciente_", @$laudo['0']->paciente, $corpo);
                                        $corpo = str_replace("_sexo_", @$laudo['0']->sexo, $corpo);
                                        $corpo = str_replace("_nascimento_", date("d/m/Y", strtotime(@$laudo['0']->nascimento)), $corpo);
                                        $corpo = str_replace("_convenio_", @$laudo['0']->convenio, $corpo);
                                        $corpo = str_replace("_sala_", @$laudo['0']->sala, $corpo);
                                        $corpo = str_replace("_CPF_", @$laudo['0']->cpf, $corpo);
                                        $corpo = str_replace("_solicitante_", @$laudo['0']->solicitante, $corpo);
                                        $corpo = str_replace("_data_", substr(@$laudo['0']->data_cadastro, 8, 2) . '/' . substr(@$laudo['0']->data_cadastro, 5, 2) . '/' . substr(@$laudo['0']->data_cadastro, 0, 4), $corpo);
                                        $corpo = str_replace("_medico_", @$laudo['0']->medico, $corpo);
                                        $corpo = str_replace("_revisor_", @$laudo['0']->medicorevisor, $corpo);
                                        $corpo = str_replace("_procedimento_", @$laudo['0']->procedimento, $corpo);
                                        $corpo = str_replace("_laudo_", @$laudo['0']->texto, $corpo);
                                        $corpo = str_replace("_nomedolaudo_", @$laudo['0']->cabecalho, $corpo);
                                        $corpo = str_replace("_queixa_", @$laudo['0']->cabecalho, $corpo);
                                        $corpo = str_replace("_peso_", @$laudo['0']->peso, $corpo);
                                        $corpo = str_replace("_altura_", @$laudo['0']->altura, $corpo);
                                        $corpo = str_replace("_cid1_", @$laudo['0']->cid1, $corpo);
                                        $corpo = str_replace("_cid2_", @$laudo['0']->cid2, $corpo);
                                        $corpo = str_replace("_assinatura_", $assinatura, $corpo);
                                        echo $corpo;
                                    }
                                }
                                ?>
                            </textarea>
                        </div>
                        <table>
<!--                            <tr>

                                <td>
                                    &ensp;
                                </td>
                                <td>
                                    <div class="bt_link_new">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoreceita/<?= $ambulatorio_laudo_id ?>');">
                                            <center>Imprimir</center></a></div>

                            </tr>-->
                        </table>
                        
                        <hr>
                        <div>
                            <label id="titulosenha">Senha</label>
                            <input type="password" name="senha" id="senha" class="size1" />
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
                            <!--<th class="tabela_header">Procedimento</th>-->
                            <th class="tabela_header">Médico</th>
                            <th class="tabela_header">Descri&ccedil;&atilde;o</th>
                            <th colspan="3" class="tabela_header">&nbsp;</th>
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
                               <!-- <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td> -->
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->texto; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoreceita/<?= $item->ambulatorio_receituario_id; ?>');">Imprimir
                                        </a></div>
                                </td>
                            
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="repetir(<?=$item->ambulatorio_receituario_id;?>)">Repetir
                                        </a></div>
                                </td>
                                 <? 
                                if (@$obj->_status != 'FINALIZADO'){ 
                                    if(@$obj->_medico_parecer1 == $item->operador_id){ ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/editarcarregarreceituario/<?= $ambulatorio_laudo_id ?>/<?= $item->ambulatorio_receituario_id; ?>');">Editar
                                        </a></div>
                                    </td>
                                 <? } else{ ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"></td>
                                <? }
                                }?>

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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

                                    document.getElementById('titulosenha').style.display = "none";
                                    document.getElementById('senha').style.display = "none";


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
                                                $.getJSON('<?= base_url() ?>autocomplete/modelosreceita', {exame: $(this).val(), ajax: true}, function (j) {
                                                    options = "";

                                                    options += j[0].texto;
                                                    //                                                document.getElementById("laudo").value = options

                                                    $('#laudo').val(options);
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
                                        $("#medicamento").autocomplete({
                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=medicamentolaudo",
                                            minLength: 1,
                                            focus: function (event, ui) {
                                                $("#medicamento").val(ui.item.label);
                                                return false;
                                            },
                                            select: function (event, ui) {
                                                $("#medicamento").val(ui.item.value);
                                                tinyMCE.triggerSave(true, true);
                                                document.getElementById("laudo").value = $('#laudo').val() + ui.item.id
                                                $('#laudo').val() + ui.item.id
                                                var ed = tinyMCE.get('laudo');
                                                ed.setContent($('#laudo').val());
                                                //$( "#laudo" ).val() + ui.item.id;
                                                document.getElementById("medicamento").value = ''
                                                return false;
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

                                    function repetir(receita_id) {

                                        $.getJSON('<?= base_url() ?>autocomplete/repetirreceituario', {receita: receita_id, ajax: true}, function (j) {
                                            options = "";

                                            options += j[0].texto;

                                            $('#laudo').val(options);
                                            var ed = tinyMCE.get('laudo');
                                            ed.setContent($('#laudo').val());

                                                
                                        }
                                       ) 
                                    }
                                    
                                             function editar(receita_id) {

                                        $.getJSON('<?= base_url() ?>autocomplete/editarreceituario', {receita: receita_id, ajax: true}, function (j) {
                                            options = "";

                                            options += j[0].texto;

                                            $('#laudo').val(options);
                                            var ed = tinyMCE.get('laudo');
                                            ed.setContent($('#laudo').val());

                                                
                                        }
                                       ) 
                                    }
                                    
                                    

                                    //$('.jqte-test').jqte();








</script>
