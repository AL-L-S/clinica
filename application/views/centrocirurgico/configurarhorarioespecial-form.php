<div class="content ficha_ceatox">
    <form name="form_guia" id="form_guia" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarpercentualhorarioespecial" method="post">
        <fieldset>
            <legend>Editar Horario Especial</legend>
            
            <div>
                <label>Percentual horario especial (%)</label>        
                <input type="hidden" id="percentual_id" name="percentual_id" class="texto09" value="<?= @$percentual_id; ?>" readonly=""/>
                <input type="text" id="valor" name="valor" alt="decimal" class="texto02" value="<?= @$percentual['0']->valor; ?>" required=""/>
            </div>
            
            <div style="width: 100%">
                <hr>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
        </fieldset>
    </form>
</div> <!-- Final da DIV content -->