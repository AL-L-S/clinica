<? ?>
<meta charset="utf-8">

<div id="conteudo"> <!-- Inicio da DIV content -->
    <form name="form_gastodesala" id="form_gastodesala" action="<?= base_url() ?>ambulatorio/exame/gravargastodesala" method="post">
        <fieldset>
            <legend>Paciente</legend>
            <div>
                <input type="hidden" name="procedimento_id" id="procedimento_id" value=""/>
                <input type="hidden" name="exame_id" value="<?= $exames_id; ?>"/>
                <input type="hidden" name="txtguia_id" value="<?= $guia_id; ?>"/>
                <input type="hidden" name="sala_id" value="<?= $sala_id; ?>"/>
                <input type="hidden" name="txtpaciente_id" value="<?= $paciente[0]->paciente_id; ?>"/>
                <input type="hidden" name="convenio_id" value="<?= $paciente[0]->convenio_id; ?>"/>
                <input type="hidden" name="armazem_id" id="armazem_id" value="<?= @$armazem_id; ?>"/>
                <table>
                    <tr>
                        <td><label>Nome</label></td>
                        <td><label>Sexo</label></td>
                        <td rowspan="13">
                            <table cellpadding="2">
                                <tr>
                                    <td width="40px;"><div class="bt_link_new">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarreceituario/<?= $laudo[0]->ambulatorio_laudo_id ?>/<?= $paciente[0]->paciente_id ?>/<?= $laudo[0]->procedimento_tuss_id ?>');" >
                                                Receituario</a></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40px;"><div class="bt_link_new">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarreceituarioespecial/<?= $laudo[0]->ambulatorio_laudo_id ?>/<?= $paciente[0]->paciente_id ?>/<?= $laudo[0]->procedimento_tuss_id ?>');" >
                                                R. especial</a></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40px;"><div class="bt_link_new">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarexames/<?= $laudo[0]->ambulatorio_laudo_id ?>/<?= $exames_id ?>');" >
                                                S. exames</a></div>
                                        <!--                                        impressaolaudo -->
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40px;"><div class="bt_link_new">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaratestado/<?= $laudo[0]->ambulatorio_laudo_id ?>/<?= $paciente[0]->paciente_id ?>/<?= $laudo[0]->procedimento_tuss_id ?>');" >
                                                Atestado</a></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="40px;"><div class="bt_link_new">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $laudo[0]->ambulatorio_laudo_id ?>');" >
                                                Arquivos</a></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="text" name="paciente" class="input_grande" value="<?= $paciente[0]->nome; ?>" readonly /></td>
                        <td><input type="text" name="sexo" class="input_pequeno" value="<?
                            if ($paciente[0]->sexo == 'F') {
                                echo 'Feminino';
                            } else {
                                echo 'masculino';
                            }
                            ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td><label>Nascimento</label></td>
                        <td><label>Telefone</label></td>

                    </tr>
                    <tr>
                        <td><input type="text" name="nascimento" class="input_pequeno" value="<?= str_replace('-', '/', date('d-m-Y', strtotime($paciente[0]->nascimento))); ?>" readonly /></td>
                        <td><input type="text" name="celular" class="input_pequeno" value="<?= $paciente[0]->celular; ?>" readonly /></td>
                    </tr>

                    <tr>
                        <td><label>Procedimento</label></td>
                        <td><label>Convênio</label></td>

                    </tr>
                    <tr>
                        <td><input type="text" name="procedimento" class="texto10" value="<?= $laudo[0]->procedimento; ?>" readonly /></td>
                        <td><input type="text" name="convenio" class="texto03" value="<?= $laudo[0]->convenio; ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td width="70px;">
                            <div class="bt_link_new">
                                <a onclick="javascript: return confirm('Deseja realmente executar a ação a seguir?');" href="<?= base_url() ?>ambulatorio/exame/finalizarexame/<?= $exames_id ?>/<?= $sala_id ?> ">
                                    Finalizar
                                </a>
                            </div>
                    </tr>
                </table>

                <div>

                </div>

            </div>
        </fieldset>  
        <fieldset>
            <legend>Gastos de Sala</legend>
            <table>
                <tr>
                    <td> <label>Produtos</label> </td>
                    <td> <label>Quantidade</label> </td>
                    <td> <label>Descricao</label> </td>
                    <!--<td> <label>Faturar</label> </td>-->
                </tr>
                <tr id="gastos">
                    <td> 
                        <select name="produto_id" id="produto_id" class="size4" style="width: 250px" required="true">
                            <option value="">SELECIONE</option>
                            <? foreach ($produtos as $value) : ?>



                                <option value="<?= $value->produto_id; ?>" onclick="procedimento_id(<?= $value->procedimento_id; ?>)"><?php echo $value->descricao . " (" . "$value->unidade" . ")"; ?></option>

                            <? endforeach; ?>
                        </select> 
                    </td>
                    <td> <input style="width: 100px" type="number" name="txtqtde" id="txtqtde" min="0" required="true"/> </td>
                    <td><textarea name="descricao" id="descricao" style="margin-left: 10px; width: 300px"></textarea></td>
                    <td></td>
                </tr>
                <tr>
                    <td> <button type="submit" name="btnEnviar" >Adicionar</button> </td>
                </tr>
            </table>
        </fieldset>

        <fieldset>
            <?
            if (count($produtos_gastos) > 0) {
                ?>
                <table id="table_agente_toxico" border="0">
                    <thead>

                        <tr>
                            <th class="tabela_header">Produto</th>
                            <th class="tabela_header">Qtde</th>
                            <th class="tabela_header">Unidade</th>
                            <th class="tabela_header">Descricao</th>
                            <th class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($produtos_gastos as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tr>
                                <td class="<?php echo $estilo_linha; ?>" width="450px;"><center><? echo $item->descricao; ?></center></td>
                        <td class="<?php echo $estilo_linha; ?>"><center><? echo $item->quantidade; ?></center></td>
                        <td class="<?php echo $estilo_linha; ?>"><center><? echo $item->unidade; ?></center></td>
                        <td class="<?php echo $estilo_linha; ?>"><center><? echo $item->descricao_gasto; ?></center></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                            <a href="<?= base_url() ?>ambulatorio/exame/excluirgastodesala/<?= $item->ambulatorio_gasto_sala_id; ?>/<?= $exames_id; ?>/<?= $convenio_id; ?>/<?= $sala_id; ?>" class="delete">
                            </a>
                        </td>
                        </tr>


                        <?
                    }
                    ?>
                    </tbody>
                    <?
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="5">
                        </th>
                    </tr>
                </tfoot>
            </table> 
        </fieldset>
    </form>

</div> <!-- Final da DIV content -->

<style>
    .input_grande{
        width: 400px;
    }
    .input_pequeno{
        width: 150px;
    }
    input, label{
        margin-left: 10px;
    }
    legend{
        font-size: 15px;
    }
    #conteudo{
        overflow-y: auto;
    }
</style>

<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
                                function procedimento_id(id) {
                                    if (id != undefined) {
                                        $('#procedimento_id').val(id);

                                        var verifica = $("#faturar").length;
                                        if (verifica == 0) {
                                            var faturar = '<td> <input type="checkbox" name="faturar" id="faturar"/> <label>Faturar</label></td>';
                                            $('#gastos').append(faturar);
                                        }
                                    } else {
                                        var verifica = $("#faturar").length;
                                        if (verifica == 1) {
                                            $("#faturar").parent().remove();
//                                                console.log(i);
                                        }
                                    }
                                }


                                $(function () {
                                    $('#produto_id').change(function () {
                                        if ($(this).val()) {

                                            $.getJSON('<?= base_url() ?>autocomplete/armazemtransferenciaentradaquantidadegastos', {produto: $(this).val(), armazem: $('#armazem_id').val()}, function (j) {
                                                var options = '<option value=""></option>';
                                                var b = 0;
                                                for (var i = 0; i < j.length; i++) {
                                                    options += '<option value="' + j[i].estoque_entrada_id + '">QTDE: ' + j[i].total + '  Produto:  ' + j[i].descricao + ' Armazem:' + j[i].armazem + '  </option>';
                                                    if (j[i].total > 0 && b == 0) {

                                                        $("#txtqtde").prop('max', j[i].total);
                                                        b++;
                                                    }
                                                }
                                                if (b == 0) {
                                                    alert('Sem saldo deste produto');
                                                    $("#txtqtde").prop('max', '0');
                                                }

                                            });
                                        } else {

                                        }
                                    });
                                });
</script>