<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Produtos</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>estoque/entrada/gerarelatorioprodutos">
                <dl>
                    <dt>
                    <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="0">TODOS</option>
                        </select>
                    </dd>
                    <dt>
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
        $("#txtfornecedorlabel").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=fornecedor",
            minLength: 2,
            focus: function(event, ui) {
                $("#txtfornecedorlabel").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtfornecedorlabel").val(ui.item.value);
                $("#txtfornecedor").val(ui.item.id);
                return false;
            }
        });
    });

    $(function() {
        $("#txtprodutolabel").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=produto",
            minLength: 2,
            focus: function(event, ui) {
                $("#txtprodutolabel").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtprodutolabel").val(ui.item.value);
                $("#txtproduto").val(ui.item.id);
                return false;
            }
        });
    });



    $(function() {
        $("#accordion").accordion();
    });

</script>