<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Faturar</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/exame/gravarfaturaramentomanualinternacao" method="post">
                <fieldset>
                    <table cellspacing="5">
                        <tr>
                            <td colspan=""><label>Valor total</label></td>
                            <td><label>Diferen&ccedil;a</label></td>
                        </tr>
                        <tr>
                            <td colspan="">
                                <input type="text" name="valorafaturar" id="valorafaturar" class="texto02" value="<?= $valor; ?>" readonly />
                                <input type="hidden" name="internacao_id" id="internacao_id" class="texto01" value="<?= $internacao_id; ?>"/>
                            </td>
                            <td>
                                <input type="text" name="valortotal" id="valortotal"  class="texto02" readonly/>
                                <input type="hidden" name="valorcadastrado" id="valorcadastrado" value="<?= $valor; ?>"/>
                                <input type="hidden" name="novovalortotal" id="novovalortotal">
                                <input type="hidden" name="valorcredito" id="valorcredito" value="0">
                                
                            </td>
                        </tr>
                        <tr>
                            <td><label>Desconto</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="desconto" id="desconto" class="texto02" value="<?= 0; ?>" onblur="multiplica()" />
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
                                    <? foreach ($forma_pagamento as $item) : 
                                        if ($item->forma_pagamento_id == 1000) continue;?>
                                        <option value="<?= $item->forma_pagamento_id; ?>" ><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="valor1" id="valor1" class="texto02" step="0.01" value="<?= 0; ?>" onblur="multiplica()"/>
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
                                    <? foreach ($forma_pagamento as $item) : 
                                        if ($item->forma_pagamento_id == 1000) continue;?>
                                        <option value="<?= $item->forma_pagamento_id; ?>" ><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="valor2" id="valor2" class="texto02" value="<?= 0; ?>" onblur="multiplica()" />
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
                                    <? foreach ($forma_pagamento as $item) : 
                                        if ($item->forma_pagamento_id == 1000) continue;?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="valor3" id="valor3" class="texto02" value="<?= 0; ?>" onblur="multiplica()"/>
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
                                    <? foreach ($forma_pagamento as $item) :
                                        if ($item->forma_pagamento_id == 1000) continue; ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                           
                                <input type="number" name="valor4" id="valor4" class="texto02" value="<?= 0; ?>" onblur="multiplica()" />
                            </td>
                        </tr>
                    </table>

                    <hr/>
                    <button type="submit" name="btnEnviar" id="btnEnviar">
                        Enviar
                    </button>
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

        
    $(document).ready(function () {

        multiplica();

        
        $(function () {
            $('#formapamento1').change(function () {
                $('#valor1').removeAttr("readonly");
            });
        });
        $(function () {
            $('#formapamento2').change(function () {
                $('#valor2').removeAttr("readonly");
            });
        });
        $(function () {
            $('#formapamento3').change(function () {
                $('#valor3').removeAttr("readonly");
            });
        });
        $(function () {
            $('#formapamento4').change(function () {
                $('#valor4').removeAttr("readonly");
            });
        });


    });
</script>