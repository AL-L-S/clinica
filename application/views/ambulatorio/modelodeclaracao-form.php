<head>
    <meta charset="utf-8">
</head>
<div > <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/modelodeclaracao">
            Voltar
        </a>
    </div>
    <div>
        <h3 class="singular">Cadastro Modelo Declaração</h3>
        <div>
            <form name="form_modelolaudo" id="form_modelolaudo" action="<?= base_url() ?>ambulatorio/modelodeclaracao/gravar" method="post">

                <div>
                    <textarea id="declaracao" name="declaracao" rows="15" cols="80" style="width: 80%"><?= @$obj->_texto; ?></textarea>
                </div>

                <!--                <div>
                                    <textarea id="laudo" name="laudo" class="jqte-test" ><?= @$obj->_texto; ?></textarea>
                                </div>-->

                <fieldset>
                    <div>
                        <label>Nome</label>
                        <input type="hidden" name="ambulatorio_modelo_declaracao_id" class="texto10" value="<?= @$obj->_ambulatorio_modelo_declaracao_id; ?>" />
                        <input type="text" name="txtNome" id="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </div>
                    <div>
                        <label>Medicos</label>
                        <select name="medico" id="medico" class="size4">
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>"<?
                            if (@$obj->_medico_id == $value->operador_id):echo'selected';
                            endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </div>
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                    <button type="reset" name="btnLimpar">Limpar</button>
                    <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
                </fieldset>
                <fieldset>
                    <legend>Opções de Declaração</legend>


                    <table border="1">
                        <thead>
                        <tr class="tabela_header">
                            <th style="text-align: center;">
                                OPÇÕES DE CONFIGURAÇÃO DA DECLARAÇÃO
                            </th>
                        </tr>
                         </thead>
                        <tr class="tabela_content01">
                            <td style="text-align: justify;">
                                Aqui se encontram as opções que você pode estar utilizando na hora de montar seu padrão de laudo.

                                Formate na caixa acima o texto do laudo como quiser e posicione as opções de acordo com sua necessidade.

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
                        <tr class="tabela_content02">
                            <td>
                                Convênio ----------->
                            </td>
                            <td style="text-align: left;">
                                _convenio_
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
                                Sala ----------->
                            </td>
                            <td style="text-align: left;">
                                _sala_
                            </td>
                        </tr>
                        <tr class="tabela_content01">
                            <td>
                                Solicitante ----------->
                            </td>
                            <td style="text-align: left;">
                                _solicitante_
                            </td>
                        </tr>
                        <tr class="tabela_content02">
                            <td>
                                Emissão (Data onde foi realizado o exame----------->
                            </td>
                            <td style="text-align: left;">
                                _data_
                            </td>
                        </tr>
                        <tr class="tabela_content01">
                            <td>
                                Medico (Médico responsável----------->
                            </td>
                            <td style="text-align: left;">
                                _medico_
                            </td>
                        </tr>
                        <tr class="tabela_content02">
                            <td>
                                Medico Revisor----------->
                            </td>
                            <td style="text-align: left;">
                                _revisor_
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
                        <tr class="tabela_content02">
                            <td>
                                Texto descrito pelo médico no laudo----------->
                            </td>
                            <td style="text-align: left;">
                                _laudo_
                            </td>
                        </tr>
                        <tr class="tabela_content01">
                            <td>
                                Nome do Laudo (Apenas Exame----------->
                            </td>
                            <td style="text-align: left;">
                                _nomedolaudo_
                            </td>
                        </tr>
                        <tr class="tabela_content02">
                            <td>
                                Queixa Principal (Apenas Consulta----------->
                            </td>
                            <td style="text-align: left;">
                                _queixa_
                            </td>
                        </tr>
                        <tr class="tabela_content01">
                            <td>
                                Cid Primário (Apenas Consulta----------->
                            </td>
                            <td style="text-align: left;">
                                _cid1_
                            </td>
                        </tr>
                        <tr class="tabela_content02">
                            <td>
                                Cid Secundário (Apenas Consulta----------->
                            </td>
                            <td style="text-align: left;">
                                _cid2_
                            </td>
                        </tr>
                        <tr class="tabela_content01">
                            <td>
                                Peso----------->
                            </td>
                            <td style="text-align: left;">
                                _peso_
                            </td>
                        </tr>
                        <tr class="tabela_content02">
                            <td>
                                Altura----------->
                            </td>
                            <td style="text-align: left;">
                                _altura_
                            </td>
                        </tr>
                        <tr class="tabela_content01">
                            <td>
                                Assinatura do médico (Apenas se quiser no corpo do texto. Também pode ser colocado no rodapé nas configurações de rodapé)
                            </td>
                            <td style="text-align: left;">
                                _assinatura_
                            </td>
                        </tr>
                    </table>

                </fieldset>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Example content CSS (should be your site CSS)
        content_css : "css/content.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        // Style formats
        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}

    });
    
    
    
    
    
    
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_modelolaudo').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>