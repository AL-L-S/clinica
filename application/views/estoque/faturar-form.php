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
                            <input type="text" name="valorafaturar" id="valorafaturar" class="texto01" value="<?= $valortotal; ?>" readonly />
                            <input type="hidden" name="estoque_solicitacao_id" id="estoque_solicitacao_id" class="texto01" value="<?= $estoque_solicitacao_id; ?>"/>
                        </dd>
                        <dt>
                            <label>Desconto</label>
                        </dt>
                        <dd>
                            <input type="text" name="desconto" id="desconto" class="texto01" value="" />
                        </dd>
                        <dt>
                            <label>Valor / Forma de pagamento / Parcelas</label>
                        </dt>
                        <dd>
                            <input type="text" name="valo1" id="valor1" class="texto01" value="" onblur="history.go(0)" />
                            <select  name="formapamento1" id="formapamento1" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                
                                <? endforeach; ?>
                            </select>
                            <input style="width: 60px;" type="number" name="parcela1" id="parcela1"  value="1" min="1" /> 

                        </dd>
                        <br/>
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
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