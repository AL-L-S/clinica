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
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarfaturado" method="post">
                <fieldset>

                    <dl class="dl_desconto_lista">
                        <dt>
                            <label>Valor total a faturar</label>
                        </dt>
                        <dd>
                            <input type="text" name="valorafaturar" id="valorafaturar" class="texto01" value="<?= $exame[0]->valor; ?>" readonly />
                            <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" class="texto01" value="<?= $agenda_exames_id; ?>"/>
                        </dd>
                        <dt>
                            <label>Desconto</label>
                        </dt>
                        <dd>
                            <input type="text" name="desconto" id="desconto" class="texto01" value="<?= $exame[0]->desconto; ?>" />
                        </dd>
                        <br/>
                        <dt>
                            <label><label >Valor1 / Forma de pagamento1 /  Ajuste1(%) /  Valor Ajustado1 / Parcelas1</label>
                        </dt>
                        <dd>
                            <input type="text" name="valor1" id="valor1" class="texto01" value="<?= $exame[0]->valor1; ?>" onblur="history.go(0)" <?
                            if (@$exame[0]->forma_pagamento == 1000) {
                                echo "readonly";
                            }
                            ?>/>
                            <select  name="formapamento1" id="formapamento1" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"<?
                                    if (@$exame[0]->forma_pagamento == $item->forma_pagamento_id):echo 'selected';
                                    endif;
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                            <input type="text" name="ajuste1" id="ajuste1" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/>                                                                           
                            <input type="text" name="valorajuste1" id="valorajuste1" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/> 
                            <input style="width: 60px;" type="number" name="parcela1" id="parcela1"  value="1" min="1" /> 

                        </dd>
                        <br/>
                        <dt>
                            <label>Valor2/ Forma de pagamento2 / Ajuste2(%) / Valor Ajustado2 / Parcelas2</label>
                        </dt>
                        <dd>
                            <input type="text" name="valor2" id="valor2" class="texto01" value="<?= $exame[0]->valor2; ?>" onblur="history.go(0)" <?
                            if (@$exame[0]->forma_pagamento2 == 1000) {
                                echo "readonly";
                            }
                            ?>/>
                            <select  name="formapamento2" id="formapamento2" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"<?
                                    if ($exame[0]->forma_pagamento2 == $item->forma_pagamento_id):echo 'selected';
                                    endif;
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                <input type="text" name="ajuste2" id="ajuste2" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/>
                                <input type="text" name="valorajuste2" id="valorajuste2" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/>
                                <input style="width: 60px;" type="number" name="parcela2" id="parcela2"  value="1" min="1" /> 
                            </select>

                        </dd>
                        <br/>
                        <dt>
                            <label>Valor3/ Forma de pagamento3 / Ajuste3(%) / Valor Ajustado3 / Parcelas3</label>
                        </dt>
                        <dd>
                            <input type="text" name="valor3" id="valor3" class="texto01" value="<?= $exame[0]->valor3; ?>" onblur="history.go(0)" <?
                            if (@$exame[0]->forma_pagamento3 == 1000) {
                                echo "readonly";
                            }
                            ?>/>
                            <select  name="formapamento3" id="formapamento3" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"<?
                                    if ($exame[0]->forma_pagamento3 == $item->forma_pagamento_id):echo 'selected';
                                    endif;
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                <input type="text" name="ajuste3" id="ajuste3" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/>  
                                <input type="text" name="valorajuste3" id="valorajuste3" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/>
                                <input style="width: 60px;" type="number" name="parcela3" id="parcela3"  value="1" min="1" />                             
                            </select>
                        </dd>
                        <br/>
                        <dt>
                            <label>Valor4/ Forma de pagamento4 / Ajuste4(%) / Valor Ajustado4 / Parcelas4</label>
                        </dt>
                        <dd>                           
                            <input type="text" name="valor4" id="valor4" class="texto01"  value="<?= $exame[0]->valor4; ?>" onblur="history.go(0)" <?
                            if (@$exame[0]->forma_pagamento4 == 1000) {
                                echo "readonly";
                            }
                            ?>/>

                            <select  name="formapamento4" id="formapamento4" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"<?
                                    if ($exame[0]->forma_pagamento4 == $item->forma_pagamento_id):echo 'selected';
                                    endif;
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                <input type="text" name="ajuste4" id="ajuste4" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/>
                                <input type="text" name="valorajuste4" id="valorajuste4" size="1" value="<?= $valor; ?>" onblur="history.go(0)"/>
                                <input style="width: 60px;" type="number" name="parcela4" id="parcela4"  value="1" min="1" />                             
                            </select>

                        </dd>
                        <br/>
                        <dt>
                            <label>Diferen&ccedil;a</label>
                        </dt>
                        <dd>
                            <input type="text" name="valortotal" id="valortotal"  class="texto01" readonly/>
                            <input type="hidden" name="valorcadastrado" id="valorcadastrado" value="<?= $exame[0]->valor; ?>"/>
                            <input type="hidden" name="novovalortotal" id="novovalortotal">
                            <input type="hidden" name="valorcredito" id="valorcredito" value="0">
                            <input type="hidden" name="paciente_id" id="paciente_id" value="<?= $exame[0]->paciente_id; ?>">
                        </dd>
                    </dl> 
                    <dt>
                        <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                            <textarea type="text" id="observacao" name="observacao" class="texto"  value="" cols="50" rows="4"></textarea>  
                    </dd>

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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">


                                    $(document).ready(function () {

<? if ($usouCredito) { ?>
                                            $(function () {
                                                $('#formapamento<?= $id ?>').change(function () {
                                                    $('#btnEnviar').removeAttr('disabled');
                                                });
                                            });

<? } ?>

                                        function multiplica()
                                        {
                                            total = 0;
                                            valor = parseFloat(document.form_faturar.valorcadastrado.value.replace(",", "."));
                                            valordesconto = parseFloat(document.form_faturar.desconto.value.replace(",", "."));
                                            desconto = (100 - valordesconto) / 100;
                                            numer1 = parseFloat(document.form_faturar.valor1.value.replace(",", "."));
                                            numer2 = parseFloat(document.form_faturar.valor2.value.replace(",", "."));
                                            numer3 = parseFloat(document.form_faturar.valor3.value.replace(",", "."));
                                            numer4 = parseFloat(document.form_faturar.valor4.value.replace(",", "."));
                                            total += numer1 + numer2 + numer3 + numer4;

                                            valordescontado = valor - valordesconto;
                                            resultado = valor - (total + valordesconto);
                                            y = resultado.toFixed(2);
                                            $('#valortotal').val(y);
                                            $('#novovalortotal').val(valordescontado);
//            document.getElementById("valortotal").value = 10;
                                            //        document.form_faturar.valortotal.value = 10;
                                        }
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

                                                if ($(this).val()) {
                                                    forma_pagamento_id = document.getElementById("formapamento1").value;
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamento/' + forma_pagamento_id + '/', {formapamento1: $(this).val(), ajax: true}, function (j) {
                                                        options = "";
                                                        parcelas = "";
                                                        options = j[0].ajuste;
                                                        parcelas = j[0].parcelas;
                                                        numer_1 = parseFloat(document.form_faturar.valor1.value.replace(",", "."));
                                                        if (j[0].parcelas != null) {
                                                            document.getElementById("parcela1").max = parcelas;
                                                        } else {
                                                            document.getElementById("parcela1").max = '1';
                                                        }
                                                        if (j[0].ajuste != null) {
                                                            document.getElementById("ajuste1").value = options;
                                                            valorajuste1 = (numer1 * options) / 100;
                                                            pg1 = numer_1 + valorajuste1;
                                                            document.getElementById("valorajuste1").value = pg1;
//                                                        document.getElementById("desconto1").type = 'text';
//                                                        document.getElementById("valordesconto1").type = 'text';
                                                        } else {
                                                            document.getElementById("ajuste1").value = '0';
                                                            document.getElementById("valorajuste1").value = '0';

                                                        }
                                                        $('.carregando').hide();
                                                    });
                                                } else {
                                                    $('#ajuste1').html('value=""');
                                                }
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

                                                if ($(this).val()) {
                                                    forma_pagamento_id = document.getElementById("formapamento2").value;
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamento/' + forma_pagamento_id + '/', {formapamento2: $(this).val(), ajax: true}, function (j) {
                                                        options = "";
                                                        parcelas = "";
                                                        options = j[0].ajuste;
                                                        parcelas = j[0].parcelas;
                                                        numer_2 = parseFloat(document.form_faturar.valor2.value.replace(",", "."));
                                                        if (j[0].parcelas != null) {
                                                            document.getElementById("parcela2").max = parcelas;
                                                        } else {
                                                            document.getElementById("parcela2").max = '1';
                                                        }
                                                        if (j[0].ajuste != null) {
                                                            document.getElementById("ajuste2").value = options;
                                                            valorajuste2 = (numer2 * options) / 100;
                                                            pg2 = numer_2 + valorajuste2;
                                                            document.getElementById("valorajuste2").value = pg2;
//                                                        document.getElementById("desconto2").type = 'text';
//                                                        document.getElementById("valordesconto2").type = 'text';
                                                        } else {
//                                                        document.getElementById("desconto2").type = 'hidden';
                                                            document.getElementById("ajuste2").value = "0";
//                                                        document.getElementById("valordesconto2").type = 'hidden';
                                                            document.getElementById("valorajuste2").value = "0";
                                                        }

                                                        $('.carregando').hide();
                                                    });
                                                } else {
                                                    $('#ajuste2').html('value=""');
                                                }
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

                                                if ($(this).val()) {
                                                    forma_pagamento_id = document.getElementById("formapamento3").value;
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamento/' + forma_pagamento_id + '/', {formapamento3: $(this).val(), ajax: true}, function (j) {
                                                        options = "";
                                                        parcelas = "";
                                                        options = j[0].ajuste;
                                                        parcelas = j[0].parcelas;
                                                        numer_3 = parseFloat(document.form_faturar.valor3.value.replace(",", "."));
                                                        valorajuste3 = (numer3 * ajuste3) / 100;
                                                        pg3 = numer_3 - valorajuste3;
                                                        if (j[0].parcelas != null) {
                                                            document.getElementById("parcela3").max = parcelas;
                                                        } else {
                                                            document.getElementById("parcela3").max = '1';
                                                        }
                                                        if (j[0].ajuste != null) {
                                                            document.getElementById("ajuste3").value = options;
                                                            valorajuste3 = (numer3 * options) / 100;
                                                            pg3 = numer_3 + valorajuste3;
                                                            document.getElementById("valorajuste3").value = pg3;
                                                        } else {
                                                            document.getElementById("ajuste3").value = "0";
                                                            document.getElementById("valorajuste3").value = "0";
                                                        }
                                                        ;
                                                        $('.carregando').hide();
                                                    });
                                                } else {
                                                    $('#ajuste3').html('value=""');
                                                }
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

                                                if ($(this).val()) {
                                                    forma_pagamento_id = document.getElementById("formapamento4").value;
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamento/' + forma_pagamento_id + '/', {formapamento4: $(this).val(), ajax: true}, function (j) {
                                                        options = "";
                                                        parcelas = "";
                                                        options = j[0].ajuste;
                                                        parcelas = j[0].parcelas;
                                                        numer_4 = parseFloat(document.form_faturar.valor4.value.replace(",", "."));
                                                        if (j[0].parcelas != null) {
                                                            document.getElementById("parcela4").max = parcelas;
                                                        } else {
                                                            document.getElementById("parcela4").max = '1';
                                                        }
                                                        if (j[0].ajuste != null) {
                                                            document.getElementById("ajuste4").value = options;
                                                            valorajuste4 = (numer4 * options) / 100;
                                                            pg4 = numer_4 + valorajuste4;
                                                            document.getElementById("valorajuste4").value = pg4;
                                                        } else {
                                                            document.getElementById("ajuste4").value = "0";
                                                            document.getElementById("valorajuste4").value = "0";
                                                        }

                                                        $('.carregando').hide();
                                                    });
                                                } else {
                                                    $('#ajuste4').html('value=""');
                                                }
                                            });
                                        });


                                    });
</script>