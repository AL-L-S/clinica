
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <!--<h3>Configurações Cabeçalho e Rodapé das impressões</h3>-->
    <!--<div style="width: 100%">-->
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/empresa/gravarimpressaoorcamento" method="post">

        <fieldset>
            <legend>Orçamento</legend>
            <label for="cabecalho">Cabeçalho</label>
            <input type="checkbox" id="cabecalho" <?
            if (@$impressao[0]->cabecalho == 't') {
                echo 'checked';
            }
            ?> name="cabecalho" id="cabecalho"/>

            <label for="rodape">Rodapé</label>
            <input type="checkbox" id="assinatura" <?
            if (@$impressao[0]->rodape == 't') {
                echo 'checked';
            }
            ?>  name="rodape" id="rodape"/>
            <textarea style="width: 100%; height:400px;" name="texto" id=""><?= @$impressao[0]->texto ?></textarea>
            <div>
                <label>Nome</label>
                <input type="text" name="nome" id="nome" class="texto10" value="<?= @$impressao[0]->nome_orcamento; ?>" />
                <input type="hidden" id="impressao_id" name="impressao_id" value="<?= @$empresa_impressao_orcamento_id ?>"/>
            </div>
            <div style="width: 100%">
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </div>

        </fieldset>
        <fieldset>
            <legend>Opções do Orçamento</legend>


            <table border="1">
                <thead>
                <tr class="tabela_header">
                    <th style="text-align: center;">
                        OPÇÕES DE CONFIGURAÇÃO DO LAUDO
                    </th>
                </tr>
                 </thead>
                <tr class="tabela_content01">
                    <td style="text-align: justify;">
                        Aqui se encontram as opções que você pode estar utilizando na hora de montar seu padrão de orcamento.

                        Formate na caixa acima o texto do orcamento como quiser e posicione as opções de acordo com sua necessidade.

                        Por exemplo, você pode estar colocando _paciente_ para informar o nome do paciente e ao lado separado por um espaço, colocar _sexo_ para mostrar o sexo

                    </td>
                </tr>
                <tr class="tabela_content01">
                    <td style="text-align: justify;">
                        Segue abaixo a lista com as opções disponíveis de dados.

                        (Copie os traços e a palavra como estão descritos abaixo. Ou seja, o nome do paciente não é paciente e sim _paciente_ )

                    </td>
                </tr>
            </table>
            <br>
            <br>
            <table>
                <tr class="tabela_header">
                    <th >
                        Descrição
                    </th>
                    <th >
                        Como fazer
                    </th>
                </tr>
                <tr class="tabela_content01">
                    <td>
                        Nome Do Paciente  ----------->
                    </td>
                    <td style="text-align: left;">
                        _paciente_ 
                    </td>
                </tr>
                <tr class="tabela_content02">
                    <td>
                        Sexo ----------->
                    </td>
                    <td style="text-align: left;">
                        _sexo_
                    </td>
                </tr>
                <tr class="tabela_content01">
                    <td>
                        Nascimento ----------->
                    </td>
                    <td style="text-align: left;">
                        _nascimento_
                    </td>
                </tr>
                
                <tr class="tabela_content01">
                    <td>
                        CPF ----------->
                    </td>
                    <td style="text-align: left;"> 
                        _CPF_
                    </td>
                </tr>

                
                <tr class="tabela_content02">
                    <td>
                        Emissão (Data onde foi emitido o orçamento----------->
                    </td>
                    <td style="text-align: left;">
                        _data_
                    </td>
                </tr>
               
               
                <tr class="tabela_content01">
                    <td>
                        Procedimento----------->
                    </td>
                    <td style="text-align: left;">
                        _procedimento_ 
                    </td>
                </tr>
                <tr class="tabela_content01">
                    <td>
                        Valor Total----------->
                    </td>
                    <td style="text-align: left;">
                        _total_ 
                    </td>
                </tr>
                
                
                
                
               
            </table>

        </fieldset>
    </form>
    <!--</div>  Final da DIV content -->
</div> <!-- Final da DIV content -->
<style>
    textarea{
        width: 90%;
        /*font-size: 18pt;*/
        /*height: 50pt;*/
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    tinyMCE.init({
        // General options
        mode: "textareas",
        theme: "advanced",
        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
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
</script>
