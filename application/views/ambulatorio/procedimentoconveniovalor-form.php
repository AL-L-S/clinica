<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>ambulatorio/procedimento/gravarprocedimentoconveniovalor/<?= $procedimento[0]->procedimento_tuss_id; ?>" method="post">
        <fieldset>
            <legend>Procedimento</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtoperador_id" value="<?= $procedimento[0]->procedimento_tuss_id; ?>" />
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= $procedimento[0]->nome; ?>"  readonly />
            </div>
            <div>
                <label>Código</label>
                <input type="text" name="txtconvenio" class="texto10 bestupper" value="<?= $procedimento[0]->codigo; ?>"  readonly />
            </div>
        </fieldset>
        <fieldset>
            <legend>Cadastrar Valor Por Convênio</legend>
            <div>
                <label>Convênio</label>
                <select name="convenio" id="procedimento" class="size4" required>
                    <option value="">SELECIONE</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Valor(R$)</label>
                <input type="text" name="valor" class="texto02" alt="decimal" value="" required/>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>

<fieldset>
    <?
    $contador = count($valor);
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Convenio</th>
                    <th class="tabela_header">Valor</th>
                    <th class="tabela_header">&nbsp;</th>
                </tr>
            </thead>
            <?
            $estilo_linha = "tabela_content01";
            foreach ($valor as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ',', '.'); ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                                <a href="<?= base_url() ?>ambulatorio/procedimento/excluirprocedimentoconveniovalor/<?= $item->procedimento_convenio_id; ?>/<?= $item->procedimento_tuss_id; ?>">Excluir
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