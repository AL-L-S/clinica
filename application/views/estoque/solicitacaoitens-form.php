<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>estoque/solicitacao/gravaritens" method="post">
        <fieldset>
            <legend>Solicitacao produtos</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtestoque_solicitacao_id" value="<?php echo $estoque_solicitacao_id; ?>"/>
                <input type="text" name="txtNome" class="texto10" value="<?php echo $nome[0]->nome; ?>" readonly />

            </div>
        </fieldset>
        <fieldset>
            <legend>Cadastro de Produtos</legend>
            <div>
                <label>Produtos</label>
                <select name="produto_id" id="produto_id" class="size4" required>
                    <option value=""  onclick="carregaValor('0,00')">SELECIONE</option>
                    <? foreach ($produto as $value) : ?>
                        <option value="<?= $value->estoque_produto_id; ?>"  onclick="carregaValor('<?= $value->valor_venda; ?>')">
                            <?php echo $value->descricao; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Quantidade</label>
                <input type="text" name="txtqtde" class="size1" alt="integer" required/>
            </div>
            <div>
                <label>Valor</label>
                <input type="text" name="valor" id="valor" alt="decimal" class="texto02" required readonly/>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>

<fieldset>
    <?
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Produto</th>
                    <th class="tabela_header">Qtde</th>
                    <th class="tabela_header">Valor (R$)</th>
                    <th class="tabela_header">&nbsp;</th>
                </tr>
            </thead>
            <?
            $valortotal = 0;
            $estilo_linha = "tabela_content01";?>
            <tbody>
            <?
            foreach ($produtos as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><? $v = (float) $item->valor_venda;
                                                                    $a = (int) str_replace('.', '', $item->quantidade); 
                                                                    $preco = (float) $a * $v; 
                                                                    $valortotal += $preco;
                                                                    echo "R$ <span id='valorunitario'>". number_format($preco, 2, '.', ',') . '</span>'; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <a href="<?= base_url() ?>estoque/solicitacao/excluirsolicitacao/<?= $item->estoque_solicitacao_itens_id; ?>/<?= $estoque_solicitacao_id; ?>" class="delete">
                            </a>

                        </td>
                    </tr>

                
                <?
            }?>
                    <tr id="tot">
                        <td class="<?php echo $estilo_linha; ?>">&nbsp;</td>
                        <td class="<?php echo $estilo_linha; ?>" id="textovalortotal"><span id="spantotal"> Total:</span> </td>
                        <td class="<?php echo $estilo_linha; ?>"><span id="spantotal">R$ <?=$valortotal;?></span></td>
                        <td class="<?php echo $estilo_linha; ?>">&nbsp;</td>
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
    <a onclick="javascript: return confirm('Deseja realmente Liberar a solicitacao?');" href="<?= base_url() ?>estoque/solicitacao/liberarsolicitacao/<?= $estoque_solicitacao_id ?>">Liberar</a>
</div>
</fieldset>
</div> <!-- Final da DIV content -->
 
<style>
    #spantotal{
        
        color: black;
        font-weight: bolder;
        font-size: 18px;
    }
    #textovalortotal{
        text-align: right;
    }
    #tot td{
        background-color: #bdc3c7;
    }
</style>


<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    function carregaValor(valor){
//        alert(valor);
        $("#valor").val(valor);
    }
    
//     onclick="carregaValor('+j[c].valor_venda+')"

</script>