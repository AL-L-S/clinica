<div class="content ficha_ceatox">
    <form name="form_guia" id="form_guia" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarpercentualfuncao" method="post">
        <fieldset>
            <legend>Editar Percentual</legend>
            <div style="width: 100%">
                <label>Função</label>                      
                <input type="text" id="nome" name="nome" class="texto09" value="<?= @$percentual['0']->descricao; ?>" readonly=""/>
                <input type="hidden" id="percentual_id" name="percentual_id" class="texto09" value="<?= @$percentual_id; ?>" readonly=""/>
            </div>
<!--            <div>
                <label>Procedimento de maior valor (%)</label>                      
                <input type="text" id="maior_valor" name="maior_valor" alt="decimal" class="texto02" value="<?= @$percentual['0']->valor; ?>" required=""/>
            </div>
            <div>
                <label>Outros procedimentos (%)</label>                      
                <input type="text" id="valor_base" name="valor_base" alt="decimal" class="texto02" value="<?= @$percentual['0']->valor_base; ?>" required=""/>
            </div>-->
            <div>
                <label>Valor Percentual (%)</label>                      
                <input type="text" id="valor_base" name="valor" alt="decimal" class="texto02" value="<?= @$percentual['0']->valor_base; ?>" required=""/>
            </div>
            
            <div style="width: 100%">
                <hr>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
        </fieldset>
    </form>
</div> <!-- Final da DIV content -->