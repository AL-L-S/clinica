<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimentoplano">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de valor Procedimento</a></h3>
        <!--<div class="ajusteAccordion">--> 
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravar" method="post">

                <table class="dl_desconto_lista">
                    <input type="hidden" name="txtprocedimentoplanoid" value="<?= @$obj->_procedimento_convenio_id; ?>" />
                    <tr>
                        <td>
                            <label>Convenio *</label>
                        </td>
                        <td>
                            <input type="hidden" name="teste_conv_secundario" id="conv_secundario"  value="f" />
                            <!--<input type="hidden" name="conv_principal_id" id="conv_principal_id"/>-->
                            <!--<input type="hidden" name="conv_secundario_perc" id="conv_secundario_perc"/>-->
                            <select name="convenio" id="convenio" class="size4" required="">
                                <option value="">Selecione</option>
                                <? foreach ($convenio as $value) : ?>
                                    <option value="<?= $value->convenio_id; ?>"<?
                                    if (@$obj->_convenio_id == $value->convenio_id):echo'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr id="procedimentodiv">
                        <td>
                            <label>Procedimento *</label>
                        </td>
                        <td>
                            <select name="procedimento" id="procedimento" class="size4 chosen-select" tabindex="1" required="">
                                <option value="">Selecione</option>
                                <? foreach ($procedimento as $value) : ?>
                                    <option value="<?= $value->procedimento_tuss_id; ?>"<?
                                    if (@$obj->_procedimento_tuss_id == $value->procedimento_tuss_id):echo'selected';
                                    endif;
                                    ?>><?php echo $value->codigo . " - " . $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Empresa *</label>
                        </td>
                        <td>
                            <select name="empresa" id="empresa" class="size4">
                                <? foreach ($empresa as $value) : ?>
                                    <option value="<?= $value->empresa_id; ?>"<?
                                    if (@$obj->_empresa_id == $value->empresa_id):echo'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr id="valoresdiv">
                        <td>
                            <label>Valor TOTAL</label>
                        </td>
                        <td>
                            <input type="text" name="valortotal"  id="valortotal" class="texto01" value="<?= @$obj->_valortotal; ?>" />
                        </td>

                    </tr>

                </table>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        <!--</div>-->
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
        $("#form_procedimentoplano").css("height", '370pt');
    });
    
    $(function () {
        $('#procedimento').change(function () {
            if ($(this).val()) {
                $.getJSON('<?= base_url() ?>autocomplete/buscarvalorprocedimentoagrupados', {convenio: $(this).val(), procedimento_id: $(this).val(), ajax: true}, function (j) {
                    
                });
            }
        });
    });

</script>