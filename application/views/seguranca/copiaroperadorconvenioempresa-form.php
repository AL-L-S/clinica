<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>seguranca/operador/gravarcopiaroperadorconvenioempresa" method="post">
        <fieldset>
            <legend>Dados</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtoperador_id" value="<?= @$operador_id; ?>" />
                <input type="text" name="txtNome" class="texto07 bestupper" value="<?= @$operador[0]->operador; ?>"  readonly />
            </div>
            <div>
                <label>Empresa</label>
                <input type="hidden" name="empresa_id_origem" value="<?= @$empresa_id; ?>" readonly />
                <input type="text" name="txtEmpresa" class="texto06 bestupper" value="<?= @$empresaOrigem[0]->nome; ?>" readonly />
            </div>
        </fieldset>
        <fieldset>
            <legend>Copiar Para</legend>
            <div>
                <label>Empresa</label>
                <select name="empresa_id_destino" id="empresa_id_origem" class="size4" required="">
                    <option value="">Selecione</option>                    
                    <? foreach ($empresas as $value) : 
                        if($empresa_id == $value->empresa_id) { continue; }?>
                        <option value="<?= $value->empresa_id; ?>"><?php echo $value->nome; ?></option>
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