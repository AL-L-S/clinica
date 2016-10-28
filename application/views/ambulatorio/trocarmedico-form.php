<head>
    <meta charset="UTF-8"/>
</head>
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Trocar Médico</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/exame/gravartrocarmedico" method="post">
                <fieldset>

                    <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" value="<?= $agenda_exames_id ?>"/>
                    <input type="hidden" name="tipo" id="agenda_exames_id" value="<?= $tipo ?>"/>
                    <dt>
                        <label>Médico atual</label>
                    </dt>
                    <dd>
                        <input type="text" value="<?= $medico_atual[0]->medicoagenda ?>" readonly/>
                    <dd>
                    <dt>
                        <label>Trocar por:</label>
                    </dt>
                    <dd>
                        <select  name="medico2" id="medico2" class="size1" style="width: 200px">
                            <option value="">Selecione</option>
                            <? foreach ($medicos as $value) { ?>
                                <option value="<?= $value->operador_id; ?>"><?= $value->nome; ?></option>
                            <? } ?>   
                        </select>
                    </dd>
                    <hr>
                    <dd>                    
                        <button type="submit" id="enviar" >Enviar</button>
                    </dd>

            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
