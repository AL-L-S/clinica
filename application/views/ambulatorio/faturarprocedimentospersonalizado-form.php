<meta charset="utf-8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Faturar</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarfaturadoprocedimentospersonalizado" method="post">
                <fieldset>
                    <table>
                        <tr>
                            <td style="text-align: left">Valor Total</td>
                            <td>Diferença</td>
                        </tr>

                        <tr>
                            <td style="text-align: left">
                                <input type="text" name="valorafaturar" id="valorafaturar" size="7" class="texto01" value="<?= $exame[0]->total; ?>" readonly />
                                <input type="hidden" name="guia_id" id="guia_id" class="texto01" value="<?= $guia_id; ?>"/>
                            </td>
                            
                            <td>
                                <input type="text" name="valortotal" id="valortotal"  onkeyup="multiplica()"  class="texto01" readonly/>
                                <input type="hidden" name="valorcadastrado" id="valorcadastrado" value="<?= $exame[0]->total; ?>"/>
                                <input type="hidden" name="juros" id="juros" value="0">
                                <input type="hidden" name="valorcredito" id="valorcredito" value="0">
                                <input type="hidden" name="paciente_id" id="paciente_id">
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
<!--                    </table>
                    <table>-->


                        <tr>
                            <td style="text-align: left">
                                Forma de pagamento1
                            </td>
                            <td style="text-align: left;">
                                Valor1 
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: left" >
                                <select  name="formapamento1" id="formapamento1" class="size1" >
                                    <option value="">Selecione</option>
                                    <?
                                    @$fp1 = (int)$pagamento_ajuste[0]["forma"];
                                    @$vl1 = (float)$pagamento_ajuste[0]["valor"];
                                    
                                    foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>" <?if(@$fp1 == $item->forma_pagamento_id) echo 'selected';?>>
                                            <?= $item->nome; ?>
                                        </option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td style="text-align: left">
                                <input type="text" name="valor1" id="valor1" size="2" value="<?= @$vl1; ?>" onblur="multiplica()"/>
                                <input type="hidden" name="valorMinimo1" id="valorMinimo1"/>
                            </td>
                        <input type="hidden" name="totalpagar" id="totalpagar"  class="texto01" onblur="multiplica()"/>
                        </tr>

                        <tr>
                            <td style="text-align: left">
                                Forma de pagamento2
                            </td>
                            <td style="text-align: left">
                                Valor2
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: left">
                                <select  name="formapamento2" id="formapamento2" >
                                    <option value="">Selecione</option>
                                    <?
                                    @$fp2 = (int)$pagamento_ajuste[1]["forma"];
                                    @$vl2 = (float)$pagamento_ajuste[1]["valor"];
                                    
                                    foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>" <?if(@$fp2 == $item->forma_pagamento_id) echo 'selected';?>>
                                            <?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td style="text-align: left">
                                <input type="text" name="valor2" id="valor2" size="2" value="<?= @$vl2; ?>" onblur="multiplica()"/>
                                <input type="hidden" name="valorMinimo2" id="valorMinimo2"/>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: left">
                                Forma de pagamento3 
                            </td>
                            <td style="text-align: left">
                                Valor3 
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: left">
                                <select  name="formapamento3" id="formapamento3" class="size1" >
                                    <option value="">Selecione</option>                                    
                                    <?
                                    @$fp3 = (int)$pagamento_ajuste[2]["forma"];
                                    @$vl3 = (float)$pagamento_ajuste[2]["valor"];
                                    
                                    foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>" <?if(@$fp3 == $item->forma_pagamento_id) echo 'selected';?>>
                                            <?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>   
                            </td>
                            <td style="text-align: left">
                                <input type="text" name="valor3" id="valor3" size="2"  value="<?= @$vl3; ?>" onblur="multiplica()"/>
                                <input type="hidden" name="valorMinimo3" id="valorMinimo3"/>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: left">
                                Forma de pagamento4
                            </td>
                            <td style="text-align: left">
                                Valor4
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: left">
                                <select  name="formapamento4" id="formapamento4" class="size1" >
                                    <option value="">Selecione</option>                             
                                    <?
                                    @$fp4 = (int)$pagamento_ajuste[3]["forma"];
                                    @$vl4 = (float)$pagamento_ajuste[3]["valor"];
                                    
                                    foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>" <?if(@$fp3 == $item->forma_pagamento_id) echo 'selected';?>>
                                            <?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>  
                            </td>
                            <td style="text-align: left">
                                <input type="text" name="valor4" id="valor4" size="2" value="<?= @$vl4; ?>" onblur="multiplica()"/>
                                <input type="hidden" name="valorMinimo4" id="valorMinimo4"/>
                            </td>

                        </tr>
                    </table>
                    <dl class="dl_desconto_lista">




                        <dd>

                        </dd>
                    </dl>    

                    <hr/>
                    <? if ($exame[0]->total > 0) { ?>
                        <button type="submit" name="btnEnviar" >Enviar</button>   
                    <? } else{?>
                        <button disabled="" type="submit" name="btnEnviar" >Enviar</button>   
                    <?}
                    ?>

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
    function mudaValor(id, valor) {
        $("#valorMinimo" + id).val(valor);
    }


    function multiplica(){
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
    }

    $(document).ready(function () {
        multiplica();
        $(function () {
            $('#formapamento1').change(function () {
                if(this.value == 1000){
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 1) {
                            continue;
                        }
                        if($('#formapamento'+i).val() == 1000){
                            selecionado = true;
                        }
                    }

                    var valorDiferenca = $('#valortotal').val();
                    $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {
                        if(!selecionado){
                            if(parseFloat(j.saldo) >=  parseFloat(valorDiferenca)){
                                $('#valor1').val(valorDiferenca);
                            }
                            else{
                                $('#valor1').val(j.saldo);
                            }

                            $('#valorcredito').val($('#valor1').val());
                        }


                        $('#paciente_id').val(j.paciente_id);
                        $('#valor1').attr("readonly", 'true');

                        multiplica();
                    });
                }
                else{
                    $('#valor1').removeAttr("readonly");
                    multiplica();
                }
            });
        });
        $(function () {
            $('#formapamento2').change(function () {
                if(this.value == 1000){
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 1) {
                            continue;
                        }
                        if($('#formapamento'+i).val() == 1000){
                            selecionado = true;
                        }
                    }

                    var valorDiferenca = $('#valortotal').val();
                    $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {
                        if(!selecionado){
                            if(parseFloat(j.saldo) >=  parseFloat(valorDiferenca)){
                                $('#valor2').val(valorDiferenca);
                            }
                            else{
                                $('#valor2').val(j.saldo);
                            }

                            $('#valorcredito').val($('#valor2').val());
                        }


                        $('#paciente_id').val(j.paciente_id);
                        $('#valor2').attr("readonly", 'true');

                        multiplica();
                    });
                }
                else{
                    $('#valor2').removeAttr("readonly");
                    multiplica();
                }
            });
        });
        $(function () {
            $('#formapamento3').change(function () {
                if(this.value == 1000){
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 1) {
                            continue;
                        }
                        if($('#formapamento'+i).val() == 1000){
                            selecionado = true;
                        }
                    }

                    var valorDiferenca = $('#valortotal').val();
                    $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {
                        if(!selecionado){
                            if(parseFloat(j.saldo) >=  parseFloat(valorDiferenca)){
                                $('#valor3').val(valorDiferenca);
                            }
                            else{
                                $('#valor3').val(j.saldo);
                            }

                            $('#valorcredito').val($('#valor3').val());
                        }


                        $('#paciente_id').val(j.paciente_id);
                        $('#valor3').attr("readonly", 'true');

                        multiplica();
                    });
                }
                else{
                    $('#valor3').removeAttr("readonly");
                    multiplica();
                }
            });
        });
        $(function () {
            $('#formapamento4').change(function () {
                if(this.value == 1000){
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 1) {
                            continue;
                        }
                        if($('#formapamento'+i).val() == 1000){
                            selecionado = true;
                        }
                    }

                    var valorDiferenca = $('#valortotal').val();
                    $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {
                        if(!selecionado){
                            if(parseFloat(j.saldo) >=  parseFloat(valorDiferenca)){
                                $('#valor4').val(valorDiferenca);
                            }
                            else{
                                $('#valor4').val(j.saldo);
                            }

                            $('#valorcredito').val($('#valor4').val());
                        }


                        $('#paciente_id').val(j.paciente_id);
                        $('#valor4').attr("readonly", 'true');

                        multiplica();
                    });
                }
                else{
                    $('#valor4').removeAttr("readonly");
                    multiplica();
                }
            });
        });

    });
</script>