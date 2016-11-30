<meta charset="utf-8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Faturar</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarfaturadoguia" method="post">
                <fieldset>
                    <table>
                        <tr>
                            <td style="text-align: left">
                               Valor total a faturar 
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: left">
                                <input type="text" name="valorafaturar" id="valorafaturar" size="7" class="texto01" value="<?= $exame[0]->total; ?>" readonly />
                            <input type="hidden" name="guia_id" id="guia_id" class="texto01" value="<?= $guia_id; ?>"/>
                            <input type="hidden" name="financeiro_grupo_id" id="financeiro_grupo_id" class="texto01" value="<?= $financeiro_grupo_id; ?>"/>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: left">
                               Desconto 
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <input type="text" name="desconto" id="desconto" size="7" value="<?= $valor; ?>" class="texto01"/>
                            <input type="hidden" name="dinheiro" id="dinheiro" value="0"class="texto01"/>
                            <input type="hidden" name="juroscartao" id="juroscartao" value="0"class="texto01"/>
                            </td>
                        </tr>
                        </table>
                    <table>
                        
                        
                        <tr>
                            <td style="text-align: left;">
                               Valor1 
                            </td>
                            <td style="text-align: left">
                               Forma de pagamento1 /
                            </td>
                            
                            <td style="text-align: left">
                               Ajuste1(%) /
                            </td>
                            <td style="text-align: left">
                               Valor Ajustado /
                            </td>
                            <td style="text-align: left">
                               Parcelas
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: left">
                            <input type="text" name="valor1" id="valor1" size="2" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left" >
                            <select  name="formapamento1" id="formapamento1" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                            </td>
                            <td style="text-align: left">
                            <input type="text" name="ajuste1" id="ajuste1" size="3" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left" >
                            <input type="text" name="valorajuste1" id="valorajuste1" size="4" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left">
                            <input style="width: 60px;" type="number" name="parcela1" id="parcela1"  size="2" min="1" />
                            </td>
                            
                            <input type="hidden" name="totalpagar" id="totalpagar"  class="texto01" onblur="history.go(0)"/>
                        </tr>

                        <tr>
                            <td style="text-align: left">
                               Valor2
                            </td>
                            <td style="text-align: left">
                               Forma de pagamento2 /
                            </td>
                            
                            <td style="text-align: left">
                               Ajuste2(%) /
                            </td>
                            <td style="text-align: left">
                               Valor Ajustado /
                            </td>
                            <td style="text-align: left">
                               Parcelas
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: left">
                            <input type="text" name="valor2" id="valor2" size="2" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left">
                                <select  name="formapamento2" id="formapamento2" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                            </td>
                            <td style="text-align: left">
                            <input type="text" name="ajuste2" id="ajuste2" size="3" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left">
                            <input type="text" name="valorajuste2" id="valorajuste2" size="4" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left">
                            <input style="width: 60px;" type="number" name="parcela2" id="parcela2" size="2" value="1" min="1" />
                            </td>
                            
                        </tr>
                        
                        <tr>
                            <td style="text-align: left">
                               Valor3 
                            </td>
                            <td style="text-align: left">
                               Forma de pagamento3 /
                            </td>
                            
                            <td style="text-align: left">
                               Ajuste3(%) /
                            </td>
                            <td style="text-align: left">
                               Valor Ajustado /
                            </td>
                            <td style="text-align: left">
                               Parcelas
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: left">
                                <input type="text" name="valor3" id="valor3" size="2"  value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left">
                            <select  name="formapamento3" id="formapamento3" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                            </select>   
                            </td>
                            <td style="text-align: left">
                            <input type="text" name="ajuste3" id="ajuste3" size="3" value="<?= $valor; ?>" onblur="history.go(0)"/>  
                            </td>
                            <td style="text-align: left">
                            <input type="text" name="valorajuste3" id="valorajuste3" size="4" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left">
                            <input style="width: 60px;" type="number" name="parcela3" id="parcela3" size="2" value="1" min="1" />
                            </td>
                            
                        </tr>
                        
                        <tr>
                            <td style="text-align: left">
                               Valor4
                            </td>
                            <td style="text-align: left">
                               Forma de pagamento4 /
                            </td>
                            
                            <td style="text-align: left">
                               Ajuste4(%) /
                            </td>
                            <td style="text-align: left">
                               Valor Ajustado /
                            </td>
                            <td style="text-align: left">
                               Parcelas
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: left">
                            <input type="text" name="valor4" id="valor4" size="2" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left">
                            <select  name="formapamento4" id="formapamento4" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                            </select>  
                            </td>
                            <td style="text-align: left">
                            <input type="text" name="ajuste4" id="ajuste4" size="3" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left">
                            <input type="text" name="valorajuste4" id="valorajuste4" size="4" value="<?= $valor; ?>" onblur="history.go(0)"/>
                            </td>
                            <td style="text-align: left">
                            <input style="width: 60px;" type="number" name="parcela4" id="parcela4" size="2" value="1" min="1" />
                            </td>
                            
                        </tr>
              </table>
                    <table>
                       <tr>
                            <td>
                               Diferença 
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                            <input type="text" name="valortotal" id="valortotal"  onkeyup="multiplica()"  class="texto01" readonly/>
                            <input type="hidden" name="valorcadastrado" id="valorcadastrado" value="<?= $exame[0]->total; ?>"/>
                            <input type="hidden" name="juros" id="juros" value="0">
                            </td>
                        </tr>
                        
                    </table>
                    <dl class="dl_desconto_lista">
 
                        
                        
                        
                        <dd>
                            
                        </dd>
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

                                //    (function($){
                                //        $(function(){
                                //            $('input:text').setMask();
                                //        });
                                //    })(jQuery);


                                $(document).ready(function () {

                                    function multiplica()
                                    {
                                        total = 0;
                                        valor = parseFloat(document.form_faturar.valorcadastrado.value.replace(",", "."));
                                        dinheiro = parseFloat(document.form_faturar.dinheiro.value.replace(",", "."));
                                        juroscartao = document.form_faturar.juroscartao.value;
                                        valordesconto = parseFloat(document.form_faturar.desconto.value.replace(",", "."));
                                        desconto = (100 - valordesconto) / 100;
                                        calculo = valor - dinheiro;
                                        totalpagarcartao = (calculo * 1.05);
                                        totalpagar = totalpagarcartao + dinheiro;
                                        juros = totalpagarcartao - calculo;
                                        numer1 = parseFloat(document.form_faturar.valor1.value.replace(",", "."));
                                        numer2 = parseFloat(document.form_faturar.valor2.value.replace(",", "."));
                                        numer3 = parseFloat(document.form_faturar.valor3.value.replace(",", "."));
                                        numer4 = parseFloat(document.form_faturar.valor4.value.replace(",", "."));
                                        total += numer1 + numer2 + numer3 + numer4;
                                        $('#totalpagar').val(totalpagarcartao);

                                        valordescontado = valor * desconto;
                                        //resultado = total - valordescontado;
                                        resultado = valor - (total + valordesconto);

                                        y = resultado.toFixed(2);
                                        resultado2 = total - totalpagar;
                                        y2 = resultado2.toFixed(2);

                                        if (juroscartao !== "1") {

                                            $('#valortotal').val(y);
                                            $('#novovalortotal').val(valordescontado);
                                        } else {
                                            $('#valortotal').val(y2);
                                            $('#novovalortotal').val(totalpagar);
                                            $('#juros').val(juros);
                                        }

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
                                                    if (j[0].parcelas != null) {
                                                        document.getElementById("parcela3").max = parcelas;
                                                    } else {
                                                        document.getElementById("parcela3").max = '1';
                                                    }
                                                    valorajuste3 = (numer3 * ajuste3) / 100;
                                                    pg3 = numer_3 - valorajuste3;
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