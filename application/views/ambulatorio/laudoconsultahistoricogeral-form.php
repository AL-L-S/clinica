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






</script>

