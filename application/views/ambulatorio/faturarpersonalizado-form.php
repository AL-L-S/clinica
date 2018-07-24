<?
$usouCredito = false;
$id = null;

if (@$exame[0]->forma_pagamento == 1000) {
    $usouCredito = true;
    $id = '1';
}
if (@$exame[0]->forma_pagamento2 == 1000) {
    $usouCredito = true;
    $id = '2';
}
if (@$exame[0]->forma_pagamento3 == 1000) {
    $usouCredito = true;
    $id = '3';
}
if (@$exame[0]->forma_pagamento4 == 1000) {
    $usouCredito = true;
    $id = '4';
}
?>
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Faturar</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarfaturadopersonalizado" method="post">
                <fieldset>
                    <table cellspacing="5">
                        <tr>
                            <td colspan=""><label>Valor total</label></td>
                            <td><label>Diferen&ccedil;a</label></td>
                        </tr>
                        <tr>
                            <?
                            if(@$exame[0]->forma_pagamento_ajuste != '' && @$exame[0]->faturado == 'f'){
                                @$forma = $exame[0]->forma_pagamento_ajuste;
                                $valor1 = $exame[0]->valor_ajuste;
                                $valor = $exame[0]->valor_ajuste;
                                $min = "min='".$valor1."'"." step='0.01'";
                            }
                            else {
                                @$forma = $exame[0]->forma_pagamento;
                                $valor1 = $exame[0]->valor1;
                                $valor = $exame[0]->valor;
                                $min = "";
                            }
                            ?>                         
                            
                            <td colspan="">
                                <input type="text" name="valorafaturar" id="valorafaturar" class="texto02" value="<?= $valor; ?>" readonly />
                                <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" class="texto01" value="<?= $agenda_exames_id; ?>"/>
                            </td>
                            <td>
                                <input type="text" name="valortotal" id="valortotal"  class="texto02" readonly/>
                                <input type="hidden" name="valorcadastrado" id="valorcadastrado" value="<?= $valor; ?>"/>
                                <input type="hidden" name="novovalortotal" id="novovalortotal">
                                <input type="hidden" name="valorcredito" id="valorcredito" value="0">
                                <input type="hidden" name="paciente_id" id="paciente_id" value="<?= $exame[0]->paciente_id; ?>">
                                
                            </td>
                        </tr>
                        <tr>
                            <td><label>Desconto</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="desconto" id="desconto" class="texto02" value="<?= $exame[0]->desconto; ?>" onblur="multiplica()" />
                            </td>
                        </tr>
                        <tr>
                            <td><label>Forma de pagamento1</label></td>
                            <td><label>Valor1</label></td>
                        </tr>
                        <tr>
                            <td>
                                <select  name="formapamento1" id="formapamento1" class="size1" >
                                    <option value="">Selecione</option>
                                    <? foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"<?
                                        if (@$forma == $item->forma_pagamento_id):echo 'selected';
                                        endif;
                                        ?>><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="valor1" id="valor1" class="texto02" <?=$min?> value="<?= @$valor1; ?>" onblur="multiplica()" <?if (@$exame[0]->forma_pagamento == 1000) echo "readonly";?>/>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><label>Forma de pagamento2</label></td>
                            <td><label>Valor2</label></td>
                        </tr>
                        <tr>
                            <td>
                                <select  name="formapamento2" id="formapamento2" class="size1" >
                                    <option value="">Selecione</option>
                                    <? foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"<?
                                        if ($exame[0]->forma_pagamento2 == $item->forma_pagamento_id):echo 'selected';
                                        endif;
                                        ?>><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="valor2" id="valor2" class="texto02" value="<?= $exame[0]->valor2; ?>" onblur="multiplica()" <?
                                if (@$exame[0]->forma_pagamento2 == 1000) {
                                    echo "readonly";
                                }
                                ?>/>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Forma de pagamento3</label></td>
                            <td><label>Valor3</label></td>
                        </tr>
                        <tr>
                            <td>
                                <select  name="formapamento3" id="formapamento3" class="size1" >
                                    <option value="">Selecione</option>
                                    <? foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"<?
                                        if ($exame[0]->forma_pagamento3 == $item->forma_pagamento_id):echo 'selected';
                                        endif;
                                        ?>><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="valor3" id="valor3" class="texto02" value="<?= $exame[0]->valor3; ?>" onblur="multiplica()" <?
                                if (@$exame[0]->forma_pagamento3 == 1000) {
                                    echo "readonly";
                                }
                                ?>/>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><label>Forma de pagamento4</label></td>
                            <td><label>Valor4</label></td>
                        </tr>
                        <tr>
                            <td>                           

                                <select  name="formapamento4" id="formapamento4" class="size1" >
                                    <option value="">Selecione</option>
                                    <? foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"<?
                                        if ($exame[0]->forma_pagamento4 == $item->forma_pagamento_id):echo 'selected';
                                        endif;
                                        ?>><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                           
                                <input type="number" name="valor4" id="valor4" class="texto02" value="<?= $exame[0]->valor4; ?>" onblur="multiplica()" <?
                                if (@$exame[0]->forma_pagamento4 == 1000) {
                                    echo "readonly";
                                }
                                ?>/>
                            </td>
                        </tr>
                    </table>

                    <hr/>
                    <? if ($exame[0]->financeiro == 'f') { ?>
                        <button type="submit" name="btnEnviar" id="btnEnviar" <?= $usouCredito ? "disabled='true'" : '' ?>>
                            Enviar
                        </button>
                    <? } else { ?>
                        Caixa Fechado
                    <? } ?>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<style>
    .texto02 { width: 80pt; }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    function validaNumero(numero){
        if (numero == "" || Number.isNaN(numero)) return 0;
        else return numero;
    }

    function multiplica(){
        total = 0;
        valor = parseFloat(document.form_faturar.valorcadastrado.value.replace(",", "."));
        valordesconto = parseFloat(document.form_faturar.desconto.value.replace(",", "."));
        desconto = (100 - valordesconto) / 100;
        numer1 = parseFloat(document.form_faturar.valor1.value.replace(",", "."));
        numer2 = parseFloat(document.form_faturar.valor2.value.replace(",", "."));
        numer3 = parseFloat(document.form_faturar.valor3.value.replace(",", "."));
        numer4 = parseFloat(document.form_faturar.valor4.value.replace(",", "."));
        total += validaNumero(numer1) + validaNumero(numer2) + validaNumero(numer3) + validaNumero(numer4);

        valordescontado = valor - valordesconto;
        resultado = valor - (total + valordesconto);
        y = resultado.toFixed(2);
        $('#valortotal').val(y);
        $('#novovalortotal').val(valordescontado);
    }

    function atualizaValorTotal(formaPagamentoId, numero){
        var procedimento = <?= $exame[0]->procedimento_tuss_id ?>;
        var valorSemAjuste = <?= $exame[0]->valor ?>;
        $.getJSON('<?= base_url() ?>autocomplete/buscaValorAjustePagamentoFaturar', {procedimento: procedimento, forma: formaPagamentoId, ajax: true}, function (p) {
            if (p.length != 0) {
                $("#valorcadastrado").val(p[0].ajuste);
                $("#valorafaturar").val(p[0].ajuste);
                $('#valor'+numero).attr("min", p[0].ajuste);
            }
            else{
                $("#valorcadastrado").val(valorSemAjuste);
                $("#valorafaturar").val(valorSemAjuste);
                $('#valor'+numero).removeAttr("min");
            }
            multiplica();
        });
    }

        
    $(document).ready(function () {

        <? if ($usouCredito) { ?>
            $(function () {
                $('#formapamento<?= $id ?>').change(function () {
                    $('#btnEnviar').removeAttr('disabled');
                });
            });
        <? } ?>

        multiplica();

        $(function () {
            $('#formapamento1').change(function () {
                if (this.value == 1000) {
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 1) {
                            continue;
                        }
                        if ($('#formapamento' + i).val() == 1000) {
                            selecionado = true;
                        }
                    }

                    if (!selecionado) {
                        $('#valor1').val('0');
                        multiplica();
                        var valorDiferenca = $('#valortotal').val();

                        $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {
                            if (parseFloat(j.saldo) >= parseFloat(valorDiferenca)) {
                                $('#valor1').val(valorDiferenca);
                            } else {
                                $('#valor1').val(j.saldo);
                            }
                            $('#valorcredito').val($('#valor1').val());


                            $('#paciente_id').val(j.paciente_id);
                            $('#valor1').attr("readonly", 'true');

                            multiplica();
                        });
                    } else {
                        $('#formapamento1').val('');
                    }
                } else {
                    $('#valor1').removeAttr("readonly");
                    multiplica();
                }
                
                atualizaValorTotal($(this).val(), 1);
            });
        });
        $(function () {
            $('#formapamento2').change(function () {

                if (this.value == 1000) {
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 2) {
                            continue;
                        }
                        if ($('#formapamento' + i).val() == 1000) {
                            selecionado = true;
                        }
                    }
                    if (!selecionado) {
                        $('#valor2').val('0');
                        multiplica();
                        var valorDiferenca = $('#valortotal').val();
                        $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {
                            if (parseFloat(j.saldo) >= parseFloat(valorDiferenca)) {
                                $('#valor2').val(valorDiferenca);
                            } else {
                                $('#valor2').val(j.saldo);
                            }

                            $('#valorcredito').val($('#valor2').val());


                            $('#paciente_id').val(j.paciente_id);
                            $('#valor2').attr("readonly", 'true');

                            multiplica();
                        });
                    } else {
                        $('#formapamento2').val('');
                    }
                } else {
                    $('#valor2').removeAttr("readonly");
                    multiplica();
                }
                
                atualizaValorTotal($(this).val(), 2);
            });
        });
        $(function () {
            $('#formapamento3').change(function () {

                if (this.value == 1000) {
//                                                    $('#valor3').val("");
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 3) {
                            continue;
                        }
                        if ($('#formapamento' + i).val() == 1000) {
                            selecionado = true;
                        }
                    }
                    if (!selecionado) {
                        $('#valor3').val('0');
                        multiplica();
                        var valorDiferenca = $('#valortotal').val();
                        $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {

                            if (parseFloat(j.saldo) >= parseFloat(valorDiferenca)) {
                                $('#valor3').val(valorDiferenca);
                            } else {
                                $('#valor3').val(j.saldo);
                            }

                            $('#valorcredito').val($('#valor3').val());


                            $('#paciente_id').val(j.paciente_id);
                            $('#valor3').attr("readonly", 'true');

                            multiplica();
                        });
                    } else {
                        $('#formapamento3').val('');
                    }
                } else {
                    $('#valor3').removeAttr("readonly");
                    multiplica();
                }

                
                atualizaValorTotal($(this).val(), 3);
            });
        });
        $(function () {
            $('#formapamento4').change(function () {
                if (this.value == 1000) {
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 4) {
                            continue;
                        }
                        if ($('#formapamento' + i).val() == 1000) {
                            selecionado = true;
                        }
                    }
                    if (!selecionado) {
                        $('#valor4').val('0');
                        multiplica();
                        var valorDiferenca = $('#valortotal').val();
                        $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {

                            if (parseFloat(j.saldo) >= parseFloat(valorDiferenca)) {
                                $('#valor4').val(valorDiferenca);
                            } else {
                                $('#valor4').val(j.saldo);
                            }

                            $('#valorcredito').val($('#valor4').val());


                            $('#paciente_id').val(j.paciente_id);
                            $('#valor4').attr("readonly", 'true');

                            multiplica();
                        });
                    } else {
                        $('#formapamento4').val('');
                    }
                } else {
                    $('#valor4').removeAttr("readonly");
                    multiplica();
                }

                
                atualizaValorTotal($(this).val(), 4);
            });
        });


    });
</script>