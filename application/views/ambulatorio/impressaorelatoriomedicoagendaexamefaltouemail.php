<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>ENVIAR EMAIL</h4>
    <? if ($_POST['situacao'] != '') { ?>
        <h4>Situação: <?= $_POST['situacao'] ?></h4>  
    <? } else { ?>
        <h4>SITUAÇÃO: TODAS</h4>      
    <? } ?>
    
    <? if ($_POST['idade_maior'] > 0) { ?>
        <h4>IDADE MAIOR QUE: <?= $_POST['idade_maior'] ?> Anos</h4>  
    <? } else { ?>
         
    <? } ?>
    <? if ($_POST['idade_menor'] > 0) { ?>
        <h4>IDADE MENOR QUE: <?= $_POST['idade_menor'] ?> Anos</h4>  
    <? } else { ?>
         
    <? } ?>
    
    <? if ($_POST['raca_cor'] > 0) { ?>
        <h4>RAÇA: <?
                        if ($_POST['raca_cor'] == "1") {
                            echo 'Branca';
                            // $solteiro++;
                        } elseif ($_POST['raca_cor'] == "2") {
                            echo 'Amarela';
                            // $casado++;
                        } elseif ($_POST['raca_cor'] == "3") {
                            echo 'Preta';
                            // $divorciado++;
                        } elseif ($_POST['raca_cor'] == "4") {
                            echo 'Parda';
                            // $viuvo++;
                        } elseif ($_POST['raca_cor'] == "5") {
                            echo 'Ind&iacute;gena';
                            // $outros++;
                        }
                        ?></h4>  
    <? } else { ?>
        <h4> RAÇA: TODAS</h4> 
    <? } ?>
    <? if ($_POST['estado_civil_id'] > 0) { ?>
        <h4>ESTADO CIVIL: <?
                        if ($_POST['estado_civil_id'] == "1") {
                            echo 'Solteiro(a)';
                            // $solteiro++;
                        } elseif ($_POST['estado_civil_id'] == "2") {
                            echo 'Casado(a)';
                            // $casado++;
                        } elseif ($_POST['estado_civil_id'] == "3") {
                            echo 'Divorciado(a)';
                            // $divorciado++;
                        } elseif ($_POST['estado_civil_id'] == "4") {
                            echo 'Viuvo(a)';
                            // $viuvo++;
                        } elseif ($_POST['estado_civil_id'] == "5") {
                            // echo 'Outros';
                            // $outros++;
                        }
                        ?></h4>  
    <? } else { ?>
        <h4>ESTADO CIVIL: TODOS</h4> 
    <? } ?>
    <? if ($_POST['sexo'] != '') { ?>
        <h4>GENERO: <?=($_POST['sexo'] == 'M')? 'Masculino' : 'Feminino';?></h4>  
    <? } else { ?>
        <h4>GENERO: TODOS</h4> 
    <? } ?>
    <? if ($_POST['grupo'] != '') { ?>
        <h4>ESPECIALIDADE: <?= $_POST['grupo'] ?></h4>  
    <? } else { ?>
        <h4>ESPECIALIDADE: TODOS</h4>      
    <? } ?>

    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>


    <hr>
    <!--<table border="1">-->
    <thead>
<!--            <tr>
            <th class="tabela_header" width="400px;">Nome</th>
            <th class="tabela_header" width="150px;">Data</th>
            <th class="tabela_header" width="250px;">Procedimento</th>
            <th class="tabela_header" width="250px;">Email</th>
            <th class="tabela_header" width="290px;">Telefone</th>
        </tr>-->
    </thead>
    <tbody>
        <?php
        $paciente = "";
        $contador = 0;
        $emails = "";
        if (count($relatorio) > 0) {
            $b = "";
//                var_dump($b) ; die;
            foreach ($relatorio as $item) {
//                    if (substr($item->data, 5, 2) != $b) {
//                        if (substr($item->data, 5, 2) == "01") {
//                            $mes = 'JANEIRO';
//                        }
//                        if (substr($item->data, 5, 2) == "02") {
//                            $mes = 'FEVEREIRO';
//                        }
//                        if (substr($item->data, 5, 2) == "03") {
//                            $mes = 'MARÇO';
//                        }
//                        if (substr($item->data, 5, 2) == "04") {
//                            $mes = 'ABRIL';
//                        }
//                        if (substr($item->data, 5, 2) == "05") {
//                            $mes = 'MAIO';
//                        }
//                        if (substr($item->data, 5, 2) == "06") {
//                            $mes = 'JUNHO';
//                        }
//                        if (substr($item->data, 5, 2) == "07") {
//                            $mes = 'JULHO';
//                        }
//                        if (substr($item->data, 5, 2) == "08") {
//                            $mes = 'AGOSTO';
//                        }
//                        if (substr($item->data, 5, 2) == "09") {
//                            $mes = 'SETEMBRO';
//                        }
//                        if (substr($item->data, 5, 2) == "10") {
//                            $mes = 'OUTUBRO';
//                        }
//
//                        if (substr($item->data, 5, 2) == "11") {
//                            $mes = 'NOVEMBRO';
//                        }
//
//                        if (substr($item->data, 5, 2) == "12") {
//                            $mes = 'DEZEMBRO';
//                        }
//                        echo "<tr>
//                    <td style='text-align: center' colspan='5' ><h4>" .$mes . "</h4></td>
//                    
//                              </tr> ";
//                    }
                ?>
                <!--                <tr>
                                <td  width="400px;"><?= $item->paciente ?></td>
                                <td width="150px;"><?= str_replace("-", "/", date("d-m-Y", strtotime($item->data))); ?></td>
                                <td width="250px;"><?= $item->procedimento ?></td>
                                <td width="250px;"><?= $item->cns ?></td>
                                <td width="290px;"><?= $item->telefone ?>/ <?= $item->celular ?></td>
                            </tr>        -->
                <?
                $b = substr($item->data, 5, 2);
                if ($item->cns != '') {
                    $emails = $emails . " ; " . $item->cns;
                }
            }
        }
        ?>

        <?
        if ($_POST['mala'] == 'SIM') {
            ?>

        <h3 style="display: inline">Mala Direta</h3> <span><button class="btn">Copiar Texto</button></span>
        <div id="mala_direta">
            <?
            echo "<p>" . $emails . "</p>";
            ?>
        </div>
    <? } ?>
    <!--</tbody>-->
    <!--</table>-->
<? if (count($relatorio) > 0 && $_POST['mala'] == 'NAO') { ?>
    <h4>ENVIAR EMAIL</h4>
    <br>
    
        <!--    <div >
                   <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/formularioemail/"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=1000,height=600');"><button class="w3-button w3-hover-blue w3-border w3-border-blue">Enviar Emails</button></a>                             
        
                    </div>-->
        <form action="<?= base_url() . "ambulatorio/guia/enviaremail/"; ?>" method="post">
            <fieldset>
                <label for="assunto">Assunto: </label>
                <input required name="assunto" type="text">
            </fieldset>
            <fieldset>
                <label for="remetente">Remetente: </label>
                <input required name="remetente" type="text" value="<?= $empresa[0]->nome ?>">
                <input  name="email" type="hidden" value="<?= $empresa[0]->email ?>">
                <input  name="txtdata_inicio" type="hidden" value="<?= $_POST['txtdata_inicio'] ?>">
                <input  name="txtdata_fim" type="hidden" value="<?= $_POST['txtdata_fim'] ?>">
                <input  name="situacao" type="hidden" value="<?= $_POST['situacao'] ?>">
                <input  name="empresa" type="hidden" value="<?= $_POST['empresa'] ?>">
            </fieldset>
            <fieldset>
                <label for="mensagem">Mensagem: </label>
                <textarea id="laudo" name="mensagem" rows="30" cols="80" style="width: 90%"></textarea>
            </fieldset>
            <fieldset>
                <button type="submit">Enviar</button>
            </fieldset>
        </form>
    <? } ?>
    <!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">-->
</div> <!-- Final da DIV content -->

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<style>
    #mala_direta{
        width: 600pt;
        border: 1px solid black;
        background-color: #ecf0f1;
        word-wrap: break-word;
        max-height: 200pt;
        overflow-y: auto;
    }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/clipboard/dist/clipboard.js" ></script>
<script>
    var clipboard = new Clipboard('.btn', {
        text: function () {
            return document.getElementById('mala_direta').textContent;
        }
    });

    clipboard.on('success', function (e) {
        alert('Copiado Com Sucesso!');
    });

    clipboard.on('error', function (e) {
        console.log(e);
    });
</script>

<!--<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">



//    $(function () {
//        $("#accordion").accordion();
//    });




    tinyMCE.init({
        // General options
        mode: "textareas",
        theme: "advanced",
        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

        // Theme options
        theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,

        // Example content CSS (should be your site CSS)
        content_css: "css/content.css",

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

</script>
