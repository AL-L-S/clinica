<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimentoplano">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Agrupador</a></h3>
        <!--<div class="ajusteAccordion">--> 
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravaragrupador" method="post">

                <table class="dl_desconto_lista">
                    <input type="hidden" name="txtprocedimentoplanoid" value="<?= @$obj->_procedimento_convenio_id; ?>" />
                    <tr>
                        <td>
                            <label>Convenio *</label>
                        </td>
                        <td>
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
                    <tr>
                        <td>    
                            <label>Grupo</label>
                        </td>
                        <td>                  
                            <select name="grupo" id="grupo" class="size4">
                                <option value="">SELECIONE</option>                        
                                <? foreach ($grupos as $value) : ?>
                                    <option value="<?= $value->nome; ?>"><?php echo $value->nome; ?></option>
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
                                    ?>><?php echo $value->nome; ?></option>
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
                        <td colspan="2">
                            
                            <fieldset style="position: relative">
                                <label for="valor_diferenciado">Valor diferenciado para o pacote?</label>
                                <input type="checkbox" name="valor_diferenciado" id="valor_diferenciado"/>
                                
                                <div style="display:inline-block; margin-left: 10pt;" id="valor_div">
                                    <label>Valor</label>
                                    <input type="text" name="valortotal"  id="valortotal" class="texto01" value="<?= @$obj->_valortotal; ?>" required=""/>
                                </div>
                            </fieldset>
                        </td>

                    </tr>
                    <tr id="aviso">
                        <td colspan="2">
                            <span>* Não será possivel cadastrar esse agrupador. Alguns procedimentos contidos no agrupador não estão cadastrados no convenio selecionado.</span>
                        </td>

                    </tr>

                </table>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
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
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
        $("tr#aviso").hide();
        $("#valor_div").hide();
    });
    
    $(function () {
        $('#grupo').change(function () {
            $.getJSON('<?= base_url() ?>autocomplete/procedimentoagrupadorgrupo', {grupo1: $(this).val()}, function (j) {
                var options = '<option value="">Selecione</option>';
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].procedimento_tuss_id + '">' + j[c].nome + '</option>';
                }

                $('#procedimento option').remove();
                $('#procedimento').append(options);
                $("#procedimento").trigger("chosen:updated");
                $('.carregando').hide();
            });
        });
    });
    
    
    $(function () {
        $('#procedimento').change(function () {
            buscarValor();
        });
        
        $('#convenio').change(function () {
            buscarValor();
        });
        
        $('#valor_diferenciado').change(function () {
            if ( $(this).is(":checked") ) {
               $("#valor_div").show();
            }
            else{
                $("#valor_div").hide();
            }
        });
    });
    
    function buscarValor(){
        $.getJSON('<?= base_url() ?>autocomplete/buscarvalorprocedimentoagrupados', {convenio: $("#convenio").val(), procedimento_id: $('#procedimento').val(), ajax: true}, function (j) {
            if(j != '-1') { 
                $("tr#aviso").hide();
                $('#valortotal').val(j);
            }
            else {
                $('#valortotal').val('');
                $("tr#aviso").show();
                
            }
        });
    }

</script>
