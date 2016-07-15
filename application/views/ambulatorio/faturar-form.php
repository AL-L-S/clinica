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
                            <input type="text" name="valorafaturar" id="valorafaturar" class="texto01" value="<?= $exame[0]->valor_total; ?>" readonly />
                            <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" class="texto01" value="<?= $agenda_exames_id; ?>"/>
                        </dd>
                        <dt>
                        <label>Desconto</label>
                        </dt>
                        <dd>
                            <input type="text" name="desconto" id="desconto" class="texto01" value="<?= $exame[0]->desconto; ?>" />
                        </dd>
                        <dt>
                        <label>Forma de pagamento1 / Valor1</label>
                        </dt>
                        <dd>
                            <select  name="formapamento1" id="formapamento1" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"<?
                                if ($exame[0]->forma_pagamento == $item->forma_pagamento_id):echo 'selected';
                                endif;
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                            <input type="text" name="valor1" id="valor1" class="texto01" value="<?= $exame[0]->valor1; ?>" onblur="history.go(0)" />
                        </dd>
                        <dt>
                        <label>Forma de pagamento2 / Valor2</label>
                        </dt>
                        <dd>
                            <select  name="formapamento2" id="formapamento2" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"<?
                                if ($exame[0]->forma_pagamento2 == $item->forma_pagamento_id):echo 'selected';
                                endif;
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                            <input type="text" name="valor2" id="valor2" class="texto01" value="<?= $exame[0]->valor2; ?>" onblur="history.go(0)"/>
                        </dd>
                        <dt>
                        <label>Forma de pagamento3 / Valor3</label>
                        </dt>
                        <dd>
                            <select  name="formapamento3" id="formapamento3" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"<?
                                if ($exame[0]->forma_pagamento3 == $item->forma_pagamento_id):echo 'selected';
                                endif;
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                            <input type="text" name="valor3" id="valor3" class="texto01" value="<?= $exame[0]->valor3; ?>" onblur="history.go(0)"/>
                        </dd>
                        <dt>
                        <label>Forma de pagamento4 / Valor4</label>
                        </dt>
                        <dd>
                            <select  name="formapamento4" id="formapamento4" class="size1" >
                                <option value="">Selecione</option>
                                <? foreach ($forma_pagamento as $item) : ?>
                                    <option value="<?= $item->forma_pagamento_id; ?>"<?
                                if ($exame[0]->forma_pagamento4 == $item->forma_pagamento_id):echo 'selected';
                                endif;
                                    ?>><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                            <input type="text" name="valor4" id="valor4" class="texto01"  value="<?= $exame[0]->valor4; ?>" onblur="history.go(0)"/>
                        </dd>
                        <dt>
                        <label>Diferen&ccedil;a</label>
                        </dt>
                        <dd>
                            <input type="text" name="valortotal" id="valortotal"  class="texto01" readonly/>
                            <input type="hidden" name="valorcadastrado" id="valorcadastrado" value="<?= $exame[0]->valor_total; ?>"/>
                            <input type="hidden" name="novovalortotal" id="novovalortotal">
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
<script type="text/javascript">

    
    $(document).ready(function(){

        function multiplica()
        {
            total=0;
            valor = parseFloat(document.form_faturar.valorcadastrado.value.replace(",","."));
            valordesconto = parseFloat(document.form_faturar.desconto.value.replace(",","."));
            desconto = (100 - valordesconto)/100; 
            numer1 = parseFloat(document.form_faturar.valor1.value.replace(",","."));
            numer2 = parseFloat(document.form_faturar.valor2.value.replace(",","."));
            numer3 = parseFloat(document.form_faturar.valor3.value.replace(",","."));
            numer4 = parseFloat(document.form_faturar.valor4.value.replace(",","."));
            total+= numer1 + numer2 + numer3 + numer4;
            
            valordescontado = valor - valordesconto;
            resultado= valor - (total + valordesconto);
            y=resultado.toFixed(2);
            $('#valortotal').val(y);
            $('#novovalortotal').val(valordescontado);
//            document.getElementById("valortotal").value = 10;
            //        document.form_faturar.valortotal.value = 10;
        }
        multiplica();
           
            
    });
</script>