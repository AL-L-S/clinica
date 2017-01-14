<head>
    <title>Histórico de consultas</title>
</head>
<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="" method="post">
            <fieldset>
                <table> 
                    <tr>
                        <td width="900px;" ><strong><font size="3" color="red">PACIENTE:</font></strong> <?= $paciente[0]->nome ?></td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <table> 
                    <tr>

                    </tr>
                    
                </table>
            </fieldset>
            <fieldset>
                <table> 
                    <tr>

                    </tr>
                    
                </table>
            </fieldset>

            <fieldset>
                <legend><b><font size="3" color="red">Historico de consultas</font></b></legend>
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

    </div>



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
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    jQuery("#Altura").mask("999", {placeholder: " "});
//                                                    jQuery("#Peso").mask("999", {placeholder: " "});

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

