<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>seguranca/operador/gravaroperadorconvenioprocedimento" method="post">
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
                <input type="hidden" name="txtconvenio_id" value="<?= @$procedimentos[0]->convenio_id; ?>" />
                <input type="text" name="txtconvenio" class="texto10 bestupper" value="<?= @$procedimentos[0]->convenio; ?>"  readonly />
            </div>
        </fieldset>
        <fieldset>
            <legend>Cadastrar procedimento</legend>
            <div id="marcarTodos">
                <input type="checkbox" name="selecionaTodos" id="selecionaTodos">
                Todos
            </div>
            <div style="float: left; margin-bottom: 20pt;">
                <input type="text" id="procText" onkeypress="filtrarTabela()" placeholder="Pesquisar texto..." title="Pesquise pelo nome do procedimento ou pelo codigo">
                <select id="grupoText">
                    <option value="">TODOS</option>
                    <? foreach ($grupo as $value) { ?>
                        <option value="<?= $value->nome ?>"><?= $value->nome ?></option>
                    <? } ?>
                </select>
                <button type="button" onclick="filtrarTabela()">Buscar</button>
            </div>

            <table id="procedimentosTable">
                <thead>
                    <tr>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Grupo</th>
                        <th class="tabela_header" style="text-align: center;">Adicionar?</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $estilo_linha = "tabela_content01";
                    foreach ($procedimentos as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr id="<?= $item->grupo ?>" class="linhaTabela" >
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                            <td class="<?php echo $estilo_linha; ?>" style="text-align: center;">
                                <input type="checkbox" id="procedimentos" class="<?= $item->grupo; ?>" name="procedimento[<?= $item->procedimento_convenio_id; ?>]"/>
                            </td>
                        </tr>

                        <?
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="2"></th>
                        <th class="tabela_footer" colspan="" style="text-align: center;">
                            <button type="submit" id="excluirButton" onclick="javascript: return confirm('Ao clicar em adicionar, o sistema ira adicionar todos os procedimentos que tenham sido marcados.');">
                                Adicionar
                            </button>
                        </th>
                    </tr>
                </tfoot>
            </table>

        </fieldset>

    </form>
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .divTabela { border: 1pt solid #aaa; border-radius: 10pt; padding: 5pt; }
    .linhaTabela { border-bottom: 1pt solid #aaa; }
    .base { max-height: 400pt; overflow-y: auto; }
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
            var grupo = $('#grupoText').val();
            if ($(this).is(":checked")) {
                if(grupo != ''){
                    $("input[id='procedimentos'][class='"+grupo+"']").attr("checked", "checked");
                } else{
                    $("input[id='procedimentos']").attr("checked", "checked");
                }

            } else {
                if(grupo != ''){
                    $("input[id='procedimentos'][class='"+grupo+"']").attr("checked", false);
                } else{
                    $("input[id='procedimentos']").attr("checked", false);
                }
            }
        });
    });

    $(function () {
        $('#grupo').change(function () {
            $('.carregando').show();
            $.getJSON('<?= base_url() ?>autocomplete/cadastroexcecaoprocedimentoconveniogrupo', {grupo1: $(this).val(), convenio1: <?= $procedimentos[0]->convenio_id; ?>}, function (j) {
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
    
    
    function filtrarTabela() {
        var input, procedimento, select, grupo, table, tr, td, i;
        input = document.getElementById("procText");
        procedimento = input.value.toUpperCase();

        select = document.getElementById("grupoText");
        grupo = select.options[select.selectedIndex].value.toUpperCase();

        var id = 'procedimentosTable';
        table = document.getElementById(id);
        tr = table.getElementsByTagName("tr");
        
        if (grupo == "" && procedimento != "") { // CASO TENHA INFORMADO SOMENTE PROCEDIMENTO
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(procedimento) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        } else if (grupo != "" && procedimento == "") { // CASO TENHA INFORMADO APENAS O GRUPO
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    var id = tr[i].getAttribute("id");
                    if (grupo == id) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        } else if (grupo != "" && procedimento != "") { // CASO TENHA INFORMADO O GRUPO E O PROCEDIMENTO
            for (i = 0; i < tr.length; i++) {

                td = tr[i].getElementsByTagName("td")[0];
//                console.log
                var id = tr[i].getAttribute("id");

                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(procedimento) > -1 && grupo == id) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        } else {
            for (i = 0; i < tr.length; i++) {
                tr[i].style.display = "";
            }
        }
    }

</script>