<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cancelar Pacote</a></h3>
        <div>
            <form name="form_exameespera" id="form_exameespera" action="<?= base_url() ?>ambulatorio/exame/cancelarpacoterealizando" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Motivo</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtsala_id" value="<?= $sala_id; ?>" />
                        <input type="hidden" name="txtguia_id" value="<?= $guia_id; ?>" />
                        <input type="hidden" name="txtagrupador_id" value="<?= $procedimento_agrupador_id; ?>" />
                        <input type="hidden" name="txtpaciente_id" value="<?= $paciente_id; ?>" />
                        <select name="txtmotivo" id="txtmotivo" class="size4">
                            <? foreach ($motivos as $item) : ?>
                                <option value="<?= $item->ambulatorio_cancelamento_id; ?>"><?= $item->descricao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Observacao</label>
                    </dt>
                    <dd>
                        <textarea id="observacaocancelamento" name="observacaocancelamento" cols="88" rows="3" ></textarea>
                    </dd>
                </dl> 
                <br>
                <br>
                <br>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $("#accordion").accordion();
    });

</script>