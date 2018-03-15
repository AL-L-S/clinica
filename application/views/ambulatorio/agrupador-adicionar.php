<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Grupo de Pagamento</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravaragrupadoradicionar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="agrupador_id" class="texto10" value="<?= $agrupador[0]->agrupador_id; ?>" />
                        <input type="text" name="txtNome" class="texto05"  value="<?= $agrupador[0]->nome; ?>"/>
                    </dd>
                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <select  name="convenio" id="convenio" class="size2" required="" >
                            <option value="">Selecione</option>
                            <? foreach ($convenio as $item) : ?>
                                <option value="<?= $item->convenio_id; ?>" 
                                    <? if (@$relatorio[count($relatorio)-1]->convenio_id == $item->convenio_id) echo "selected"; ?>>
                                    <?= $item->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Procedimento</label>
                    </dt>
                    <dd>
                        <select name="procedimento" id="procedimento" class="size10 chosen-select" required="" data-placeholder="Selecione um procedimento.">
                            <option value="">Selecione</option>                            
                        </select>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <a href="<?= base_url() ?>ambulatorio/procedimentoplano/agrupador"><button type="button" id="btnVoltar" name="btnVoltar">Voltar</button></a>
            </form>
            <br/><br/>


            <? if (count($relatorio) > 0) { ?>

                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Nome</th>
                            <th class="tabela_header">Convenio</th>
                            <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($relatorio as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse procedimento?');" href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirprocedimentoagrupador/<?= $item->procedimento_agrupado_id ?>/<?= $item->agrupador_id ?>">Excluir</a>
                                </td>
                            </tr>

                        </tbody>
                    <? } ?>

                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="6">
                                Valor Total: <?php echo number_format(count($relatorio)); ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>

            <? } ?>
        </div>
    </div>
</div> <!-- Final da DIV content -->



<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });
    $(function () {
        $('#convenio').change(function () {
            if ($(this).val()) {
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniocirurgicoagrupador', {convenio1: $(this).val()}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="'+j[c].procedimento_convenio_id+'">'+j[c].codigo+' - '+j[c].procedimento+'</option>';
                    }
                    console.log(options);
                    $('#procedimento option').remove();
                    $('#procedimento').append(options);
                    $("#procedimento").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento').html('<option value="">Selecione</option>');
            }
        });
    });
    if ($('#convenio').val() != "") {
        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniocirurgicoagrupador', {convenio1: $('#convenio').val()}, function (j) {
            var options = '<option value=""></option>';
            for (var c = 0; c < j.length; c++) {
                options += '<option value="'+j[c].procedimento_convenio_id+'">'+j[c].codigo+' - '+j[c].procedimento+'</option>';
            }
            console.log(options);
            $('#procedimento option').remove();
            $('#procedimento').append(options);
            $("#procedimento").trigger("chosen:updated");
            $('.carregando').hide();
        });
    }
    
</script>

