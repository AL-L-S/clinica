<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>cadastros/convenio">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Ajuste Valor Convenio</a></h3>
        <div>
            <form name="form_desconto" id="form_desconto" action="<?= base_url() ?>cadastros/convenio/gravardesconto/<?= $convenio[0]->convenio_id; ?>" method="post">

                <dl class="dl_desconto_lista">
                    <input type="hidden" name="txtprocedimentoplanoid" value="<?= @$obj->_procedimento_convenio_id; ?>" />

                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <input class="hidden" name="convenio" id="convenio" class="texto02" value="<?= $convenio[0]->convenio_id; ?>" />
                        <input  value="<?php echo $convenio[0]->nome; ?>" readonly/>
                    </dd>
                    <dt>
                        <label>Grupo</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size1">
                            <option value="TODOS">TODOS</option>
                            <? foreach ($grupos as $value) { ?>
                                <option value="<?= $value->nome; ?>"><?php echo $value->nome; ?></option>
                            <? } ?>                           
                        </select>
                    </dd>
                    <dt>
                        <label>Ajuste CH (%)</label>
                    </dt>
                    <dd>
                        <input type="number" name="ajustech" id="ajustech" class="number" step=0.01 />
                    </dd>
                    <dt>
                        <label>Ajuste Filme (%)</label>
                    </dt>
                    <dd>
                        <input type="number" name="ajustefilme" id="ajustefilme" class="number" step=0.01  />
                    </dd>
                    <dt>
                        <label>Ajuste Porte (%)</label>
                    </dt>
                    <dd>
                        <input type="number" name="ajusteporte" id="ajusteporte" class="number"  step=0.01 />
                    </dd>
                    <dt>
                        <label>Ajuste UCO (%)</label>
                    </dt>
                    <dd>
                        <input type="number" name="ajusteuco" id="ajusteuco" class="number" step=0.01  />
                    </dd>
                    <dt>
                        <label>Desconto TOTAL (%)</label>
                    </dt>
                    <dd>
                        <input type="number" name="ajustetotal" id="ajustetotal" class="number" step=0.01  />
                    </dd>
                    <dt>
                        <label>Arredondar p/ cima</label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="arrendondamento" id="arrendondamento" step=0.01  />
                    </dd>
                    <dt>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

//                            $(document).ready(function () {
//
//                                function multiplica()
//                                {
//                                    total = 0;
//                                    numer2 = document.form_desconto.valorch.value;
//                                    numer4 = document.form_desconto.valorfilme.value;
//                                    numer6 = document.form_desconto.valoruco.value;
//                                    numer8 = document.form_desconto.valorporte.value;
//                                    total += soma2 + soma4 + soma6 + soma8;
////                                    y = total.toFixed(2);
////                                    $('#valortotal').val(y);
//                                    document.form_desconto.valortotal.value = total;
//                                }
//                                multiplica();
//
//
//                            });

</script>