<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>seguranca/operador/gravareplicaroperadorconvenio" method="post">
        <fieldset>
            <legend>Dados</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtoperador_id" value="<?= @$operador_id; ?>" />
                <input type="text" name="txtNome" class="texto07 bestupper" value="<?= @$operador[0]->operador; ?>"  readonly />
            </div>
        </fieldset>
        <fieldset>
            <legend>Replicar</legend>
            <div>
                <label>Empresa</label>
                <select name="empresa_id" id="empresa_id" class="size4">
                    <option value="">Todas</option>                    
                    <? foreach ($empresas as $value) :?>
                        <option value="<?= $value->empresa_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Operador</label>
                <select name="operador_destino" id="operador_destino" class="size4" required="">
                    <option value="">Selecione</option>                    
                    <? foreach ($operadores as $value) :?>
                        <option value="<?= $value->operador_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
        </fieldset>
    </form>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>