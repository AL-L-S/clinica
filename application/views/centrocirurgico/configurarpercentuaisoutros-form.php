<div class="content ficha_ceatox">
    <form name="form_guia" id="form_guia" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarpercentualoutros" method="post">
        <fieldset>
            <legend>Editar Percentual</legend>
            <?
            $tipo = ($percentual['0']->leito_enfermaria == 't')? "ENFERMARIA" : "APARTAMENTO";
            $via = ($percentual['0']->mesma_via == 't')? "MESMA VIA" : "VIA DIFERENTE";
            ?>
            <div style="width: 100%">
                <input type="hidden" id="percentual_id" name="percentual_id" class="texto09" value="<?= @$percentual_id; ?>" readonly=""/>
                
                
                <label>Tipo</label>                      
                <input type="text" id="nome" name="nome" class="texto09" value="<?= @$tipo; ?>" readonly=""/>
            </div>
            <div style="width: 100%">
                
                <label>Via</label>                      
                <input type="text" id="nome" name="nome" class="texto09" value="<?= @$via; ?>" readonly=""/>
            </div>
            
            <div>
                <label>Procedimento de maior valor (%)</label>                      
                <input type="text" id="maior_valor" name="maior_valor" alt="decimal" class="texto02" value="<?= @$percentual['0']->valor; ?>" required=""/>
            </div>
            <div>
                <label>Outros procedimentos (%)</label>                      
                <input type="text" id="valor_base" name="valor_base" alt="decimal" class="texto02" value="<?= @$percentual['0']->valor_base; ?>" required=""/>
            </div>
            
            <div style="width: 100%">
                <hr>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
        </fieldset>
    </form>
</div> <!-- Final da DIV content -->