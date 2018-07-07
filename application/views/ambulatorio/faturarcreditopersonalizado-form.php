<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Faturar</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/exametemp/gravarfaturarcreditopersonalizado/" method="post">
                <fieldset>
                    <table cellspacing="5">
                        <tr>
                            <td colspan=""><label>Valor total</label></td>
                            <td><label>Diferen&ccedil;a</label></td>
                        </tr>
                        <tr>
                            <?
                            if(@$valor_credito[0]->forma_pagamento_ajuste != ''){
                                @$forma = $valor_credito[0]->forma_pagamento_ajuste;
                                $valor1 = (float)@$valor_credito[0]->valor_ajuste;
                                $valor = $valor_credito[0]->valor_ajuste;
                                $min = "min='".$valor1."'"." step='0.01'";
                            }
                            else {
                                @$forma = $valor_credito[0]->forma_pagamento;
                                $valor1 = (float)@$valor_credito[0]->valor1;
                                $valor = $valor_credito[0]->valor;
                                $min = "";
                            }
//                            echo "<pre>";
//                            var_dump($valor_credito); die;
                            
                            ?>
                            <td>
                                <input type="text" name="valorafaturar" id="valorafaturar" size="7" class="texto01" value="<?= $valor; ?>" readonly />
                                <input type="hidden" name="credito_id" id="credito_id" class="texto01" value="<?= $credito_id; ?>"/>
                                <input type="hidden" name="paciente_teste_id" id="paciente_teste_id" class="texto01" value="<?= $paciente_id; ?>"/>
                            </td>
                            <td>
                                <input type="text" name="valortotal" id="valortotal"  onkeyup="multiplica()"  class="texto01" readonly/>
                                <input type="hidden" name="valorcadastrado" id="valorcadastrado" value="<?= $valor; ?>"/>
                                <input type="hidden" name="juros" id="juros" value="0">
                                
                                <input type="hidden" name="juroscartao" id="juroscartao" value="0"class="texto01"/>
                                <input type="hidden" name="dinheiro" id="dinheiro" value="0"class="texto01"/>
                                <input type="hidden" name="valorcredito" id="valorcredito" value="0">
                                <input type="hidden" name="paciente_id" id="paciente_id">
                            </td>
                        </tr>
                        <tr>
                            <td><label>Desconto</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="desconto" id="desconto" class="texto02" onblur="multiplica()" value="0"/>
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
                                        <option value="<?= $item->forma_pagamento_id; ?>"<? if (@$forma == $item->forma_pagamento_id) echo 'selected';?>>
                                            <?= $item->nome; ?>
                                        </option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="valor1" id="valor1" class="texto02" <?=$min?> value="<?= @$valor1; ?>" onblur="multiplica()"/>
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
                                        <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="valor2" id="valor2" class="texto02" onblur="multiplica()" value="0"/>
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
                                        <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="valor3" id="valor3" class="texto02" onblur="multiplica()" value="0"/>
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
                                        <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                           
                                <input type="number" name="valor4" id="valor4" class="texto02" onblur="multiplica()" value="0"/>
                            </td>
                        </tr>
                    </table>

                    <hr/>
                    
                    <? if ($valor > 0) { ?>
                        <button type="submit" name="btnEnviar" >Enviar</button>   
                    <? } else { ?>
                        <button disabled="" type="submit" name="btnEnviar" >Enviar</button>   
                    <? }
                    ?>
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

    function multiplica() {

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
    
    multiplica();
        
    $(document).ready(function () {

        multiplica();

        $(function () {
            $('#formapamento1').change(function () {
                $('#valor1').removeAttr("readonly");
                multiplica();
            });
        });
        
        $(function () {
            $('#formapamento2').change(function () {
                $('#valor2').removeAttr("readonly");
                multiplica();
            });
        });
        
        $(function () {
            $('#formapamento3').change(function () {
                $('#valor3').removeAttr("readonly");
                multiplica();
            });
        });
        
        $(function () {
            $('#formapamento4').change(function () {
                $('#valor4').removeAttr("readonly");
                multiplica();
            });
        });


    });
</script>