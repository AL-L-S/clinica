
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Editar Promotor</a></h3>
        <div>
            <form name="form_procedimentohonorarioeditar" id="form_procedimentohonorarioeditar" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravareditarpromotorpercentual/<?= $procedimento_percentual_promotor_convenio_id ?>/<?=$dados?>/<?=$convenio_id?>" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Promotor</label>
                    </dt>
                    <dd>     
                        <input type="text" name="promotor" id="promotor" class="texto05" value="<?= $busca[0]->nome ?>" readonly/>
                    </dd>
                    <dt>
                        <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" id="valor" class="texto01" value="<?= $busca[0]->valor ?>"/>
                    </dd>
                    <dt>
                        <label>Percentual</label>
                    </dt>
                    <dd>
                        <select name="percentual"  id="percentual" class="size1">
                            <?
                            if ($busca[0]->percentual == "t") {
                                ?>
                                <option value="1"> SIM</option>
                                <option value="0"> NÃO</option>                                
                            <? } else { ?>
                                <option value="0"> NÃO</option>
                                <option value="1"> SIM</option>
                            <? } ?>

                        </select>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>

        </div>
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/procedimentoplano/procedimentopercentual');
    });

    $(function () {
        $("#accordion").accordion();
    });

</script>