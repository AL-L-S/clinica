<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>seguranca/operador/gravaroperadorconvenioempresa" method="post">
        <fieldset>
            <legend>Operador</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtoperador_id" value="<?= $operador[0]->operador_id; ?>" />
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= $operador[0]->operador; ?>"  readonly />
            </div>
        </fieldset>
        <fieldset>
            <legend>Cadastrar empresa</legend>
            <div>
                <label>Empresa</label>
                <select name="empresa_id" id="empresa_id" class="size4">
                    <? foreach ($empresas as $value) : ?>
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
            
        <fieldset>
    <?
    $contador = count($empresasCadastradas);
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Empresa</th>
                    <th class="tabela_header" colspan="3">&nbsp;</th>
                </tr>
            </thead>
            <?
            $estilo_linha = "tabela_content01";
            foreach ($empresasCadastradas as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <div class="bt_link">
                                <a target="_blank" href="<?= base_url() ?>seguranca/operador/copiaroperadorconvenioempresa/<?= $item->empresa_id; ?>/<?= $operador[0]->operador_id; ?>">Replicar</a>
                            </div>
                        </td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <div class="bt_link">
                                <a href="<?= base_url() ?>seguranca/operador/operadorconvenio/<?= $operador[0]->operador_id; ?>/<?= $item->empresa_id; ?>">Convênio</a>
                            </div>
                        </td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <div class="bt_link">
                            <a onclick="javascript: return confirm('Deseja realmente excluir todos os procedimentos associados a essa empresa?');" 
                               href="<?= base_url() ?>seguranca/operador/excluiroperadorconvenioempresa/<?= $operador[0]->operador_id; ?>/<?= $item->empresa_id; ?>">Excluir</a>
                            </div>
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
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_exametemp').validate( {
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