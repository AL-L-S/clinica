<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
        <fieldset>
            <legend>Solicitacao produtos</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtestoque_solicitacao_id" value="<?php echo $estoque_solicitacao_id; ?>"/>
                <input type="text" name="txtNome" class="texto10" value="<?php echo $nome[0]->nome; ?>" readonly />
            </div>
        </fieldset>
<fieldset>
    <?
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Produtos Solicitados</th>
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
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                            <a href="<?= base_url() ?>estoque/solicitacao/saidaitens/<?= $item->estoque_solicitacao_itens_id; ?>/<?=$estoque_solicitacao_id?>"> produtos
                            </a></div>

                        </td>
                    </tr>

                </tbody>
                <?
            }
        }
        ?>

    </table> 
</fieldset>
<fieldset>
    <?
    if ($contadorsaida > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Produto Liberados</th>
                    <th class="tabela_header">Qtde</th>
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

                    </tr>

                </tbody>
                <?
            }
        }
        ?>

    </table> 
    <br>
    <div class="bt_link">                                  
    <a onclick="javascript: return confirm('Deseja realmente Finalizar a solicitacao?');" href="<?= base_url() ?>estoque/solicitacao/fecharsolicitacao/<?= $estoque_solicitacao_id ?>">Fechar</a>
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