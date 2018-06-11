<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->

    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>seguranca/operador/operadorconvenio/<?= @$operador[0]->operador_id; ?>/<?= @$empresa_id; ?>">
            Voltar
        </a>
    </div>
    <div class="clear"></div>
    <fieldset>
        <legend>Operador</legend>
        <div>
            <label>Nome</label>
            <input type="hidden" name="txtoperador_id" value="<?= @$operador[0]->operador_id; ?>" />
            <input type="hidden" name="txtempresa_id" value="<?= @$empresa_id; ?>" />
            <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$operador[0]->operador; ?>"  readonly />
        </div>
        <div>
            <label>Convênio</label>
            <input type="hidden" name="txtconvenio_id" value="<?= @$convenio_id; ?>" />
            <input type="text" name="txtconvenio" class="texto10 bestupper" value="<?= @$convenio[0]->nome; ?>"  readonly />
        </div>
    </fieldset>

    <fieldset>
        <div class="bt_link">
            <a target="_blank" href="<?= base_url() ?>seguranca/operador/operadorconvenioprocedimentoadicionar/<?= @$convenio_id; ?>/<?= $operador[0]->operador_id; ?>/<?= @$empresa_id; ?>">
                Adicionar
            </a>
        </div>
        <?
        $contador = count($procedimentos_cadastrados);
        if ($contador > 0) {
            ?>
            <form id="form_menuitens" action="<?= base_url() ?>seguranca/operador/excluiroperadorconvenioprocedimento/<?= @$convenio_id; ?>/<?= $operador[0]->operador_id; ?>/<?= @$empresa_id; ?>" method="post">

                <div id="marcarTodos">
                    <input type="checkbox" name="selecionaTodos" id="selecionaTodos">
                    Todos
                </div>

                <table id="table_agente_toxico" border="0">
                    <thead>

                        <tr>
                            <th class="tabela_header">Empresa</th>
                            <th class="tabela_header">Convenio</th>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header" style="text-align: center;">Excluir?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($procedimentos_cadastrados as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;" style="text-align: center;">
                                    <input type="checkbox" id="procedimentos" name="procedimento[<?= $item->convenio_operador_procedimento_id; ?>]"/>
                                </td>
                            </tr>

                            <?
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="3"></th>
                            <th class="tabela_footer" colspan="">
                                <button type="submit" id="excluirButton" style="text-align: center;">Excluir</button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </form>
            <?
        }
        ?>

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
    #marcarTodos {
        font-size: 13pt;
        float: right;
    }
    #excluirButton{
        float: left;
        margin: 5pt;
        font-size: 12pt;
        font-weight: bold;
        width: 80pt;
        border-radius: 5pt;
    }
</style>

<script type="text/javascript">
    $(function () {
        $('#selecionaTodos').change(function () {
            if ($(this).is(":checked")) {
                $("input[id='procedimentos']").attr("checked", "checked");

            } else {
                $("input[id='procedimentos']").attr("checked", false);
            }
        });
    });

    $(function () {
        $('#grupo').change(function () {
            $('.carregando').show();
            $.getJSON('<?= base_url() ?>autocomplete/cadastroexcecaoprocedimentoconveniogrupo', {grupo1: $(this).val(), convenio1: <?= (count($procedimentos) > 0)?$procedimentos[0]->convenio_id : ''; ?>}, function (j) {
                options = '<option value="">TODOS</option>';
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

    $(function () {
        $("#accordion").accordion();
    });

</script>