<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>estoque/menu/gravaritens" method="post">
        <fieldset>
            <legend>Menu produtos</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtestoque_menu_id" value="<?= $menu[0]->estoque_menu_id; ?>" />
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= $menu[0]->descricao; ?>"  readonly />
            </div>
        </fieldset>
        <fieldset>
            <legend>Cadastro de Produtos</legend>
            <!--            <div>-->
            <dl>
                <label>Tipo</label>
            </dl>
            <dd>
                <select name="tipo_id" id="tipo_id" class="size3">
                    <option value="">SELECIONE</option>
                    <? foreach ($tipo as $value) : ?>
                        <option value="<?= $value->estoque_tipo_id; ?>"><?php echo $value->descricao; ?></option>
                    <? endforeach; ?>
                </select>
            </dd>
            <dl>
                <label>Classe</label>
            </dl>
            <dd>
                <select name="classe_id" id="classe_id" class="size3">
                    <option value="">SELECIONE</option>
                </select>
            </dd>
            <dl>
                <label>Sub-classe</label>
            </dl>
            <dd>
                <select name="subclasse_id" id="subclasse_id" class="size3">
                    <option value="">SELECIONE</option>
                </select>
            </dd>
            <!--            </div>-->
            <br/>
            <br/>
            <div>
                <label>Produtos</label>
                <select name="produto_id" id="produto_id" class="size4">
                    <? foreach ($produto as $value) : ?>
                    <option value="<?= $value->estoque_produto_id; ?>" onclick="carregaValor('<?= $value->valor_venda; ?>')"><?php echo $value->descricao; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <dl>
                <label>&nbsp;</label>
            </dl>
            <dd>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </dd>
    </form>
</fieldset>

<fieldset>
    <?
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Produtos</th>
                    <th class="tabela_header">&nbsp;</th>
                </tr>
            </thead>
            <?
            $estilo_linha = "tabela_content01";
            foreach ($produtos as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <a href="<?= base_url() ?>estoque/menu/excluirmenu/<?= $item->estoque_menu_produtos_id; ?>/<?= $menu[0]->estoque_menu_id; ?>" class="delete">
                            </a>

                        </td>
                    </tr>

                </tbody>
                <?
            }
        }
        ?>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 

</fieldset>
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

<?php 
    if ($this->session->flashdata('message') != ''): ?>
        alert("<? echo $this->session->flashdata('message') ?>");
<? endif; ?>

    $(function () {
        $('#classe_id').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/estoquesubclasseporclasse', {classe_id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">SELECIONE -></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_sub_classe_id + '">' + j[c].descricao + '</option>';
                    }
                    $('#subclasse_id').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#subclasse_id').html('<option value="">SELECIONE</option>');
            }
        });
    });

    $(function () {
        $('#tipo_id').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/estoqueclasseportipo', {tipo_id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">SELECIONE -></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_classe_id + '">' + j[c].descricao + '</option>';
                    }
                    $('#classe_id').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#classe_id').html('<option value="">SELECIONE</option>');
            }
        });
    });

    $(function () {
        $('#subclasse_id').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/estoqueprodutosporsubclasse', {subclasse_id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">SELECIONE -></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].estoque_produto_id + '">' + j[c].descricao + '</option>';
                    }
                    $('#produto_id').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#produto_id').html('<option value="">SELECIONE</option>');
            }
        });
    });




    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_exametemp').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                nascimento: {
                    required: true
                },
                idade: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                nascimento: {
                    required: "*"
                },
                idade: {
                    required: "*"
                }
            }
        });
    });

</script>