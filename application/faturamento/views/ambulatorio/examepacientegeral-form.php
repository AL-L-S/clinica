<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacienteexametempgeral/<?= $agenda_exames_id ?>" method="post">
        <fieldset>
            <legend>Marcar Exames</legend>

            <div>
                <label>Nome</label>
                <input type="text" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                <input type="text" id="txtNome" name="txtNome" class="texto10"/>
            </div>
            <div>
                <label>Dt de nascimento</label>

                <input type="text" name="nascimento" id="nascimento" class="texto02" onkeypress="datanascimento(this)" type="text"/>
            </div>
            <div>
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>
                <input type="hidden" name="medico" id="medico" class="texto01" value="<?= $medico ?>"/>

            </div>
            <div>
                <label>Telefone</label>


                <input type="text" id="telefone" class="texto02" name="telefone" onkeypress="mascara(this)" type="text" />
            </div>
            <div>
                <label>Celular</label>


                <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone"/>
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio1" id="convenio1" class="size4">
                    <option  value="-1">Selecione</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select  name="procedimento1" id="procedimento1" class="size1" >
                    <option value="">Selecione</option>
                </select>
            </div>
            <div>
                <label>Observacoes</label>


                <input type="text" id="observacoes" class="texto10" name="observacoes" />
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Enviar</button>
            </div>
    </form>
</fieldset>

<fieldset>
    <?
    ?>
    <table id="table_agente_toxico" border="0">
        <thead>

            <tr>
                <th class="tabela_header">Data</th>
                <th class="tabela_header">Hora</th>
                <th class="tabela_header">Sala</th>
                <th class="tabela_header">Observa&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <?
        $estilo_linha = "tabela_content01";
        foreach ($exames as $item) {
            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
            ?>
            <tbody>
                <tr>
                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->sala . $item->medico_agenda; ?></td>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                </tr>

            
            <?
        }
        
        ?>
        </tbody>
            <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 

</fieldset>
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


    $(function() {
        $('#convenio1').change(function() {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedico', {convenio1: $(this).val(), teste: $("#medico").val()}, function(j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
                    $('#procedimento1').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1').html('<option value="">Selecione</option>');
            }
        });
    });


    $(function() {
        $("#txtNome").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function(event, ui) {
                $("#txtNome").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#telefone").val(ui.item.itens);
                $("#nascimento").val(ui.item.valor);
                return false;
            }
        });
    });

    $(function() {
        $("#nascimento").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=pacientenascimento",
            minLength: 3,
            focus: function(event, ui) {
                $("#nascimento").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#telefone").val(ui.item.itens);
                $("#nascimento").val(ui.item.valor);
                return false;
            }
        });
    });





    //$(function(){     
    //    $('#exame').change(function(){
    //        exame = $(this).val();
    //        if ( exame === '')
    //            return false;
    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
    //            var option = new Array();
    //            $.each(data, function(i, obj){
    //                console.log(obl);
    //                option[i] = document.createElement('option');
    //                $( option[i] ).attr( {value : obj.id} );
    //                $( option[i] ).append( obj.nome );
    //                $("select[name='horarios']").append( option[i] );
    //            });
    //        });
    //    });
    //});




//
//    $(function() {
//        $("#accordion").accordion();
//    });
//
//
//    $(document).ready(function() {
//        jQuery('#form_exametemp').validate({
//            rules: {
//                txtNome: {
//                    required: true,
//                    minlength: 3
//                }
//            },
//            messages: {
//                txtNome: {
//                    required: "*",
//                    minlength: "!"
//                }
//            }
//        });
//    });

</script>