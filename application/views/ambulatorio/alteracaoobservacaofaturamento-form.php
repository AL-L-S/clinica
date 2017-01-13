<body bgcolor="#C0C0C0">
<div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Alterar Observacao</h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/exame/observacaofaturargravar/<?= $agenda_exame_id; ?>" method="post">
                <fieldset>
                    
                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Observacao</label>
                    </dt>
                        <textarea type="text" name="txtobservacao" cols="55" class="texto12"><?= $observacao[0]->observacao_faturamento; ?></textarea>

                     
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">OK</button>
            </form>
            </fieldset>
        </div>
</div> <!-- Final da DIV content -->
</body>