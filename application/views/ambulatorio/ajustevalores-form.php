<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de valor Procedimento</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimento/gravarajustevalores" method="post">

                <dl class="dl_desconto_lista">
                    <dt>                         
                        <label>Grupo</label>
                    </dt>                    
                    <dd>                       
                        <select name="grupo" id="grupo" class="size4" required>
                            <option value="">SELECIONE</option>                    
                            <? foreach ($grupos as $value) : ?>
                                <option value="<?= $value->nome; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>
                    </dd>
                    <dt>
                        <label>Perc./Valor Medico</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtperc_medico" id="txtperc_medico" class="texto" value="<?= @$obj->_perc_medico; ?>" />
                    </dd>
                    <dt>
                        <label>Percentual</label>
                    </dt>
                    <dd>
                        <select name="percentual" id="percentual" class="size2" required="">
                            <option value="">Selecione</option>
                            <option value="t">SIM</option>
                            <option value="f">N&Atilde;O</option>
                        </select>
                    </dd>

                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar" onclick="javascript: return confirm('Isso irá alterar o valor de todos os procedimentos desse grupo!\nDeseja continuar?');">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
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

$("#grupodiv").hide();
    $('#brasindice').change(function () {
        if ($(this).is(":checked")) {
            $("#valoresdiv").hide();
            $("#procedimentodiv").hide();
            $("#grupodiv").show();
            $("#grupo").prop('required', true);
            
        } else {
            $("#valoresdiv").show();
            $("#procedimentodiv").show();
            $("#grupodiv").hide();
            $("#grupo").prop('required', false);
//            $("#procedimento").toggle();
        }
    });

    $(function () {
        $("#accordion").accordion();
    });

//                            $(document).ready(function () {

//                            function multiplica()
//                            {
//                                total = 0;
//                                numer1 = parseFloat(document.form_procedimentoplano.qtdech.value);
//                                numer2 = parseFloat(document.form_procedimentoplano.valorch.value);
//                                soma = numer1 * numer2;
//                                numer3 = parseFloat(document.form_procedimentoplano.qtdefilme.value);
//                                numer4 = parseFloat(document.form_procedimentoplano.valorfilme.value);
//                                soma2 = numer3 * numer4;
//                                numer5 = parseFloat(document.form_procedimentoplano.qtdeuco.value);
//                                numer6 = parseFloat(document.form_procedimentoplano.valoruco.value);
//                                soma3 = numer5 * numer6;
//                                numer7 = parseFloat(document.form_procedimentoplano.qtdeporte.value);
//                                numer8 = parseFloat(document.form_procedimentoplano.valorporte.value);
//                                soma4 = numer7 * numer8;
//                                total += soma + soma2 + soma3 + soma4;
//                                y = total.toFixed(2);
//                                $('#valortotal').val(y);
//                                //document.form_procedimentoplano.valortotal.value = total;
//                            }
//                            multiplica();


//                            });


    $(function () {
        $('#qtdech').change(function () {
            valorch = parseFloat($('#qtdech').val()) * parseFloat($('#valorch').val());
            valorfilme = parseFloat($('#qtdefilme').val()) * parseFloat($('#valorfilme').val());
            valoruco = parseFloat($('#qtdeuco').val()) * parseFloat($('#valoruco').val());
            valorporte = parseFloat($('#qtdeporte').val()) * parseFloat($('#valorporte').val());
            valortotal = valoruco + valorfilme + valorporte + valorch;
//                                    alert(valortotal);
            $('#valortotal').val(valortotal);
        });
        $('#qtdefilme').change(function () {
            valorch = parseFloat($('#qtdech').val()) * parseFloat($('#valorch').val());
            valorfilme = parseFloat($('#qtdefilme').val()) * parseFloat($('#valorfilme').val());
            valoruco = parseFloat($('#qtdeuco').val()) * parseFloat($('#valoruco').val());
            valorporte = parseFloat($('#qtdeporte').val()) * parseFloat($('#valorporte').val());
            valortotal = valoruco + valorfilme + valorporte + valorch;
//                                    alert(valortotal);
            $('#valortotal').val(valortotal);
        });
        $('#qtdeuco').change(function () {
            valorch = parseFloat($('#qtdech').val()) * parseFloat($('#valorch').val());
            valorfilme = parseFloat($('#qtdefilme').val()) * parseFloat($('#valorfilme').val());
            valoruco = parseFloat($('#qtdeuco').val()) * parseFloat($('#valoruco').val());
            valorporte = parseFloat($('#qtdeporte').val()) * parseFloat($('#valorporte').val());
            valortotal = valoruco + valorfilme + valorporte + valorch;
//                                    alert(valortotal);
            $('#valortotal').val(valortotal);
        });
        $('#qtdeporte').change(function () {
            valorch = parseFloat($('#qtdech').val()) * parseFloat($('#valorch').val());
            valorfilme = parseFloat($('#qtdefilme').val()) * parseFloat($('#valorfilme').val());
            valoruco = parseFloat($('#qtdeuco').val()) * parseFloat($('#valoruco').val());
            valorporte = parseFloat($('#qtdeporte').val()) * parseFloat($('#valorporte').val());
            valortotal = valoruco + valorfilme + valorporte + valorch;
//                                    alert(valortotal);
            $('#valortotal').val(valortotal);
        });
        $('#valorch').change(function () {
            valorch = parseFloat($('#qtdech').val()) * parseFloat($('#valorch').val());
            valorfilme = parseFloat($('#qtdefilme').val()) * parseFloat($('#valorfilme').val());
            valoruco = parseFloat($('#qtdeuco').val()) * parseFloat($('#valoruco').val());
            valorporte = parseFloat($('#qtdeporte').val()) * parseFloat($('#valorporte').val());
            valortotal = valoruco + valorfilme + valorporte + valorch;
//                                    alert(valortotal);
            $('#valortotal').val(valortotal);
        });
        $('#valorfilme').change(function () {
            valorch = parseFloat($('#qtdech').val()) * parseFloat($('#valorch').val());
            valorfilme = parseFloat($('#qtdefilme').val()) * parseFloat($('#valorfilme').val());
            valoruco = parseFloat($('#qtdeuco').val()) * parseFloat($('#valoruco').val());
            valorporte = parseFloat($('#qtdeporte').val()) * parseFloat($('#valorporte').val());
            valortotal = valoruco + valorfilme + valorporte + valorch;
//                                    alert(valortotal);
            $('#valortotal').val(valortotal);
        });
        $('#valoruco').change(function () {
            valorch = parseFloat($('#qtdech').val()) * parseFloat($('#valorch').val());
            valorfilme = parseFloat($('#qtdefilme').val()) * parseFloat($('#valorfilme').val());
            valoruco = parseFloat($('#qtdeuco').val()) * parseFloat($('#valoruco').val());
            valorporte = parseFloat($('#qtdeporte').val()) * parseFloat($('#valorporte').val());
            valortotal = valoruco + valorfilme + valorporte + valorch;
//                                    alert(valortotal);
            $('#valortotal').val(valortotal);
        });
        $('#valorporte').change(function () {
            valorch = parseFloat($('#qtdech').val()) * parseFloat($('#valorch').val());
            valorfilme = parseFloat($('#qtdefilme').val()) * parseFloat($('#valorfilme').val());
            valoruco = parseFloat($('#qtdeuco').val()) * parseFloat($('#valoruco').val());
            valorporte = parseFloat($('#qtdeporte').val()) * parseFloat($('#valorporte').val());
            valortotal = valoruco + valorfilme + valorporte + valorch;
//                                    alert(valortotal);
            $('#valortotal').val(valortotal);
        });
        $('#qtdech').change(function () {
            valorch = parseFloat($('#qtdech').val()) * parseFloat($('#valorch').val());
            valorfilme = parseFloat($('#qtdefilme').val()) * parseFloat($('#valorfilme').val());
            valoruco = parseFloat($('#qtdeuco').val()) * parseFloat($('#valoruco').val());
            valorporte = parseFloat($('#qtdeporte').val()) * parseFloat($('#valorporte').val());
            valortotal = valoruco + valorfilme + valorporte + valorch;
//                                    alert(valortotal);
            $('#valortotal').val(valortotal);
        });

    });

</script>