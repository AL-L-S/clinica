<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Alterar Sala</h3>
        <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/agenda/gravarsalahorarioagenda" method="post">
            <div>
                <label>Sala</label>                  
                <input type="hidden" name="horario_id" id="horario_id" class="texto01"  value="<?= $horario_id; ?>"/>
                <input type="hidden" name="agenda_id" id="agenda_id" class="texto01"  value="<?= $agenda_id; ?>"/>

                <select name="sala_id" id="sala_id" required="">
                    <option value="">Selecione</option>
                    <? foreach ($salas as $item) : ?>
                        <option value="<?= $item->exame_sala_id; ?>" <?= ($item->exame_sala_id == $sala_id) ? 'selected': ''; ?>>
                            <?= $item->nome; ?>
                        </option>
                    <? endforeach; ?>                            
                </select>                
            </div>
            <hr>
            <div>
                <button type="submit">Enviar</button>
            </div>

        </form>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript">
</script>