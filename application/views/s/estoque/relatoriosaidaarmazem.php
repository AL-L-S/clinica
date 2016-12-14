<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatorio Saida Armazem</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>estoque/entrada/gerarelatoriosaidaarmazem">
                <dl>
                    <dt>
                    <label>Armazem</label>
                    </dt>
                    <dd>
                        <select name="armazem" id="armazem" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($armazem as $value) : ?>
                                <option value="<?= $value->estoque_armazem_id; ?>" ><?php echo $value->descricao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>


                    <dt>
                    <label>Fornecedor</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtfornecedor" id="txtfornecedor" value="<?= @$obj->_fornecedor_id; ?>" />
                        <input type="text" name="txtfornecedorlabel" id="txtfornecedorlabel" class="texto10" value="<?= @$obj->_fornecedor; ?>" />
                    </dd>
                    <dt>
                    <label>Produto</label>
                    </dt>

                    <dd>
                        <input type="hidden" name="txtproduto" id="txtproduto" value="<?= @$obj->_produto_id; ?>" />
                        <input type="text" name="txtprodutolabel" id="txtprodutolabel" class="texto10" value="<?= @$obj->_produto; ?>" />
                    </dd>
                    <dt>
                    <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <dt>
                    <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                    </dd>
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
        $("#txtdata_inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function() {
        $("#txtdata_fim").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

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