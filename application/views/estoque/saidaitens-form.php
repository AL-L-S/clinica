<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>estoque/solicitacao/gravarsaidaitens" method="post">
        <fieldset>
            <legend>Solicitacao produtos</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtestoque_solicitacao_id" value="<?php echo $estoque_solicitacao_id; ?>"/>
                <input type="hidden" name="txtestoque_solicitacao_itens_id" value="<?php echo $estoque_solicitacao_itens_id; ?>"/>
                <input type="text" name="txtNome" class="texto10" value="<?php echo $nome[0]->nome; ?>" readonly />
            </div>
        </fieldset>
        <fieldset>
            <table id="table_agente_toxico" border="0">
                <thead>

                    <tr>
                        <th class="tabela_header">Produto Solicitado</th>
                        <th class="tabela_header">Qtde</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <?
                $estilo_linha = "tabela_content01";
                foreach ($produto as $item) {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tbody>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                                    <a href="<?= base_url() ?>estoque/solicitacao/saidaitens/<?= $item->estoque_solicitacao_itens_id; ?>/<?= $estoque_solicitacao_id ?>"> produtos
                                    </a></div>

                            </td>

                        </tr>

                    </tbody>
                    <input type="hidden" name="txtexame" value="<?php echo $item->exame_id; ?>"/>
                    <?
                    $estoque_solicitacao_itens_id = $item->estoque_solicitacao_itens_id;
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
        <fieldset>
            <legend>Cadastro de Produtos</legend>
            <div>
                <label>Produtos</label>
                <select name="produto_id" id="produto_id" class="size4">
                    <option value=''>SELECIONE</option>
                    <?
                    foreach ($produtos as $value) :
                        if ($value->total != 0) {
                            ?>
                            <option onclick="verificacao(<?= $value->total ?>)" value="<?= $value->estoque_entrada_id; ?>"><?php echo $value->descricao; ?> - QTDE: <?php echo $value->total; ?> - Armazem: <?php echo $value->armazem; ?> - VALIDADE: <?php echo substr($value->validade, 8, 2) . "/" . substr($value->validade, 5, 2) . "/" . substr($value->validade, 0, 4); ?></option>
                        <? }
                    endforeach;
                    ?>
                </select>
            </div>
            <div>
                <label>Quantidade</label>
                <input type="text" name="txtqtde" id="txtqtde" class="size1" alt="integer"/>
            </div>
            
            <div style="display: none">
                <input type="hidden" name="qtdedisponivel" id="qtdedisponivel" class="size1" alt="integer" value=''>
            </div>
            
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>

<fieldset>
    <?
    if ($contadorsaida > 0) {
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
            foreach ($produtossaida as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <a href="<?= base_url() ?>estoque/solicitacao/excluirsaida/<?= $item->estoque_saida_id; ?>/<?=$estoque_solicitacao_id?>/<?= $estoque_solicitacao_itens_id; ?>" class="delete">
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
        <a onclick="javascript: return confirm('Deseja realmente Finalizar a solicitacao?');" href="<?= base_url() ?>estoque/solicitacao/fecharsolicitacao/<?= $estoque_solicitacao_id ?>">Fechar</a>
    </div>
</fieldset>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

function verificacao(valor){
    document.getElementById("qtdedisponivel").value = valor;
}




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





            $(function() {
                $("#accordion").accordion();
            });


            $(document).ready(function() {
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
                        },
                        produto_id: {
                            required: true
                        },
                        txtqtde: {
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
                        },
                        produto_id: {
                            required: "*"
                        },
                        txtqtde: {
                            required: "*"
                        }
                    }
                });
            });

</script>