<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>cadastros/convenio">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Ajuste Valor Convenio</a></h3>
        <div>
            <form name="form_desconto" id="form_desconto" action="<?= base_url() ?>cadastros/convenio/gravarvaloresassociacao" method="post">

                <dl class="dl_desconto_lista">
                    <input type="hidden" name="convenio_id" value="<?= @$convenio_id; ?>" />
                    <input type="hidden" name="convenio_associacao_id" value="<?= @$convenio_associacao; ?>" />

                    <dt>
                        <label>Associado ao Convenio</label>
                    </dt>
                    <dd>
                        <!--<input class="hidden" name="convenio_associacao_nome" id="convenio_associacao_nome" class="texto02" value="<?= $convenio[0]->convenio_id; ?>" />-->
                        <input  value="<?php echo $convenio[0]->nome; ?>" class="texto07" readonly/>
                    </dd>
                    <dt>
                        <label>Grupo</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" >
                            <option value="TODOS">TODOS</option>
                            <? foreach ($grupos as $value) { ?>
                                <option value="<?= $value->nome; ?>"><?php echo $value->nome; ?></option>
                            <? } ?>                           
                        </select>
                    </dd>
                    <dt>
                        <label title="Esse valor será o valor percentual que os procedimentos desse convenio ira receber em relação ao convenio original.">Valor Percentual (%)</label>
                    </dt>
                    <dd>
                        <input type="number" name="ajusteuco" id="ajusteuco" class="number" step=0.01  />
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