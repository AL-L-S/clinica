<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>seguranca/operador/gravaroperadorconvenio" method="post">
        <fieldset>
            <legend>Operador</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtoperador_id" value="<?= $operador[0]->operador_id; ?>" />
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= $operador[0]->operador; ?>"  readonly />
            </div>
        </fieldset>
        <fieldset>
            <legend>Cadastrar convenio</legend>
            <div>
                <label>Convenio</label>
                <select name="convenio_id" id="convenio_id" class="size4">
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
                </fieldset>
            
        <fieldset>
    <?
    $contador = count($convenios);
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Convenio</th>
                    <th class="tabela_header" colspan="3">&nbsp;</th>
                </tr>
            </thead>
            <?
            $estilo_linha = "tabela_content01";
            foreach ($convenios as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                            <a href="<?= base_url() ?>seguranca/operador/operadorconvenioprocedimento/<?= $item->convenio_id; ?>/<?= $item->operador_id; ?>">Procedimentos
                            </a></div>
                        </td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                            <a href="<?= base_url() ?>seguranca/operador/excluiroperadorconvenio/<?= $item->ambulatorio_convenio_operador_id; ?>/<?= $item->operador_id; ?>">Excluir
                            </a></div>

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