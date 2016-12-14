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
                <select name="produto_id" id="produto_id" class="size4">
                    <? foreach ($produto as $value) : ?>
                        <option value="<?= $value->estoque_produto_id; ?>"><?php echo $value->descricao; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Quantidade</label>
                <input type="text" name="txtqtde" class="size1" alt="integer"/>
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
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <a href="<?= base_url() ?>estoque/solicitacao/excluirsolicitacao/<?= $item->estoque_solicitacao_itens_id; ?>/<?= $estoque_solicitacao_id; ?>" class="delete">
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
    <br>
<div class="bt_link">                                  
    <a onclick="javascript: return confirm('Deseja realmente Liberar a solicitacao?');" href="<?= base_url() ?>estoque/solicitacao/liberarsolicitacao/<?= $estoque_solicitacao_id ?>">Liberar</a>
</div>
</fieldset>
</div> <!-- Final da DIV content -->



<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">






                    //$(function(){     
                    //    $('#exame').change(function(){
                    //        exame = $(this).val();
                    //        if ( exame === '')
                    //            return false;
                    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
                    //            var option = new Array();
                    //            $.each(data, function(i, obj){
                    //                console.log(obl);
                    //                option[i] = document.createElement('option');
                    //                $( option[i] ).attr( {value : obj.id} );
                    //                $( option[i] ).append( obj.nome );
                    //                $("select[name='horarios']").append( option[i] );
                    //            });
                    //        });
                    //    });
                    //});



</script>