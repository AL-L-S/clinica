<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>seguranca/operador/gravaroperadorconvenioprocedimento" method="post">
        <fieldset>
            <legend>Operador</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtoperador_id" value="<?= $operador[0]->operador_id; ?>" />
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= $operador[0]->operador; ?>"  readonly />
            </div>
            <div>
                <label>Convênio</label>
                <input type="hidden" name="txtconvenio_id" value="<?= $convenio[0]->convenio_id; ?>" />
                <input type="text" name="txtconvenio" class="texto10 bestupper" value="<?= $convenio[0]->convenio; ?>"  readonly />
            </div>
        </fieldset>
        <fieldset>
            <legend>Cadastrar procedimento</legend>
            <div>
                <label>Grupo</label>
                <select name="grupo" id="grupo" class="size3" >
                    <option value=''>TODOS</option>
                    <? foreach ($grupo as $value) : ?>
                        <option value="<?php echo $value->nome; ?>" ><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select name="procedimento" id="procedimento" class="size4 chosen-select" data-placeholder="Selecione" tabindex="1">
                    <option value=''>TODOS</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->procedimento_convenio_id; ?>" ><?php echo $value->procedimento; ?></option>
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
    $contador = count($procedimentos);
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Convenio</th>
                    <th class="tabela_header">Procedimento</th>
                    <th class="tabela_header">&nbsp;</th>
                </tr>
            </thead>
            <?
            $estilo_linha = "tabela_content01";
            foreach ($procedimentos as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                            <a href="<?= base_url() ?>seguranca/operador/excluiroperadorconvenioprocedimento/<?= $item->convenio_operador_procedimento_id; ?>/<?= $convenio[0]->convenio_id; ?>/<?= $operador[0]->operador_id; ?>">Excluir
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
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 130px; }
</style>

<script type="text/javascript">
    
    $(function () {
        $('#grupo').change(function () {
            $('.carregando').show();
            $.getJSON('<?= base_url() ?>autocomplete/cadastroexcecaoprocedimentoconveniogrupo', { grupo1: $(this).val(), convenio1: <?= @$convenio[0]->convenio_id; ?> }, function (j) {
                options = '<option value="0">TODOS</option>';
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                }
                $('#procedimento option').remove();
                $('#procedimento').append(options);
                $("#procedimento").trigger("chosen:updated");
                $('.carregando').hide();
            });
            
        });
    });
    
    $(function() {
        $( "#accordion" ).accordion();
    });

</script>