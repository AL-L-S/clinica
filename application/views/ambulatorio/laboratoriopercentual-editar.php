
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Editar Laboratório</a></h3>
        <div>
            <form name="form_procedimentohonorarioeditar" id="form_procedimentohonorarioeditar" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravareditarlaboratoriopercentual/<?= $procedimento_percentual_laboratorio_convenio_id ?>" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Laboratório</label>
                    </dt>
                    <dd>     
                        <input type="hidden" name="percentual_laboratorio_id" value="<?= $percentual_laboratorio_id ?>"/>
                        <input type="hidden" name="convenio_id" value="<?= $convenio_id ?>"/>
                        <input type="text" name="laboratorio" id="laboratorio" class="texto05" value="<?= $busca[0]->nome ?>" readonly/>
                    </dd>
                    <dt>
                        <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" id="valor" class="texto01" value="<?= $busca[0]->valor ?>"/>
                    </dd>
                    <?if($busca[0]->grupo == 'RM'){?>
                     <dt>
                        <label>Revisor</label>
                    </dt>
                    <dd>
                        <select name="revisor"  id="revisor" class="size1">
                            <?
                            if ($busca[0]->revisor == "t") {
                                ?>
                                <option value="1"> SIM</option>
                                <option value="0"> NÃO</option>                                
                            <? } else { ?>
                                <option value="0"> NÃO</option>
                                <option value="1"> SIM</option>
                            <? } ?>

                        </select>
                    </dd>   
                        
                    <?}?>
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
                    <dt>
                        <label>Dia Faturamento</label>
                    </dt>
                    <dd>
                        <input type="text" id="entrega" class="texto02" name="dia_recebimento" alt="99" value="<?= @$busca[0]->dia_recebimento; ?>" />
                    </dd>
                    <dt>
                        <label>Tempo para Recebimento</label>
                    </dt>
                    <dd>
                        <input type="text" id="pagamento" class="texto02" name="tempo_recebimento" alt="99" value="<?= @$busca[0]->tempo_recebimento; ?>" />
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