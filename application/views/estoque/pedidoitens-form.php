<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>estoque/pedido">
            Voltar
        </a>
    </div>
    <form name="form_pedidoitens" id="form_pedidoitens" action="<?= base_url() ?>estoque/pedido/gravaritens" method="post">
        <fieldset>
            <legend>Descrição Pedido</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtestoque_pedido_id" value="<?= $estoque_pedido_id; ?>"/>
                <input type="text" name="txtNome" class="texto10" value="<?= @$nome[0]->descricao; ?>" readonly />

            </div>
        </fieldset>
        <fieldset>
            <legend>Cadastro de Produtos</legend>
            <div>
                <label>Produtos</label>
                <select name="produto_id" id="produto_id" class="size4 chosen-select" tabindex="1" required="">
                    <? foreach ($produto as $value) : ?>
                        <option value="<?= $value->estoque_produto_id; ?>">
                            <?= $value->descricao." SALDO: ".(int)$value->saldo_atual." EST. MINIMO: ".$value->estoque_minimo; ?>
                        </option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Quantidade</label>
                <input type="text" name="txtqtde" class="size1" alt="integer"/>
            </div>
            <div>
                <label>Observação</label>
                <textarea name="observacao" style="resize: none" cols="50"></textarea>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
        </fieldset>
    </form>

    <fieldset>
        <?
        if (count($produtosPedido) > 0) {
            ?>
            <table id="table_agente_toxico" border="0">
                <thead>

                    <tr>
                        <th class="tabela_header">Produto</th>
                        <th class="tabela_header">Qtde</th>
                        <th class="tabela_header">Observação</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <?
                $estilo_linha = "tabela_content01";
                foreach ($produtosPedido as $item) {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tbody>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->observacao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                <a href="<?= base_url() ?>estoque/pedido/excluirpedido/<?= $item->estoque_pedido_itens_id; ?>/<?= $estoque_pedido_id; ?>" class="delete"></a>

                            </td>
                        </tr>

                    </tbody>
                    <?
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                        </th>
                    </tr>
                </tfoot>
            </table> 
            <br>
            <div class="bt_link">
                <a href="<?= base_url() ?>estoque/pedido/imprimirpedido/<?= $estoque_pedido_id ?>">Imprimir</a>
            </div>
            <?
        }
        ?>
    </fieldset>
</div> <!-- Final da DIV content -->


<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<!--<style>
    .chosen-container{ margin-top: 5pt;}
    #produto_id_chosen a { width: 130px; }
</style>-->
<script type="text/javascript">
    $(".chosen-select").chosen()
// $(".chosen-select").chosen({width: "95%"}); 

</script>