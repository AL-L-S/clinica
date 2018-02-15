<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaomateriais" method="post">
        <?
        $perfil_id = $this->session->userdata('perfil_id');
        ?>
        <fieldset>
            <legend>Dados da Solicitação</legend>
            <div>
                <label>Paciente</label>
                <input type="text" class="texto06" readonly value="<?= $dados[0]->nome ?>"/> 
                <!--<input type="text" class="texto06" readonly value="//<?= $dados[0]->orcamento ?>"/>--> 
            </div>

            <div>
                <label>Médico Solicitante</label>
                <input type="text" class="texto06" readonly value="<?= $dados[0]->medico ?>"/> 
            </div>
            <div>
                <label>Convênio</label>
                <input type="text" id="convenio" readonly value="<?= $dados[0]->convenio ?>"/> 
            </div>

        </fieldset>
        <fieldset>
            <legend>Adicionar Materiais</legend>

            <fieldset>
                <legend>Fornecedor</legend>
                <input type="hidden" name="solicitacao_id" value="<?php echo $solicitacao_id; ?>"/>
                <table>
                    <tr>
                        <td>Fornecedor</td>
                        <td>
                            <select name="fornecedor_id" id="fornecedor_id" class="size4 chosen-select" required>
                                <option value="">Selecione</option>
                                <? foreach ($fornecedor as $item) { ?>
                                    <option value="<?= $item->fornecedor_material_id ?>" <?if($item->fornecedor_material_id == $dados[0]->fornecedor_id){echo 'selected';}?>><?= $item->nome ?></option>
                                <? } ?>
                            </select>
                        </td>
                    </tr>

                </table>
                <hr/>
                <!--<button type="submit" name="btnEnviar">Enviar</button>-->

            </fieldset>
            <fieldset>
                <legend>Materiais</legend>
                <input type="hidden" name="solicitacao_id" value="<?php echo $solicitacao_id; ?>"/>
                <table>
                    <tr>
                        <td>Quantidade</td>
                        <td>
                            <input type="number" name="qtde1" id="qtde1" min="1" value="1" class="texto01"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Procedimento</td>
                        <td>
                            <select name="material_id" id="material_id" class="size4 chosen-select" required>
                                <option value="">Selecione</option>
                                <? foreach ($procedimento as $item) { ?>
                                    <option value="<?= $item->procedimento_tuss_id ?>"><?= $item->nome ?></option>
                                <? } ?>
                            </select>
                        </td>
                    </tr>

                </table>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>

            </fieldset>

            <hr/>

            <!--<button type="submit" name="btnEnviar">Enviar</button>-->
            <!--<button type="reset" name="btnLimpar">Limpar</button>-->
        </fieldset>



    </form>

    <fieldset>
        <?
        if (count($procedimentos) > 0) {
            ?>
            <table id="table_agente_toxico" border="0" style="width:600px">
                <thead>

                    <tr>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Quantidade</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $estilo_linha = "tabela_content01";
                    foreach ($procedimentos as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>

                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                <a style="text-align: left;" href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluirsolicitacaomaterial/<?= $item->solicitacao_material_id; ?>/<?= $solicitacao_id; ?>" class="delete">
                                </a>
                            </td>
                        </tr>


                        <?
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="tabela_footer" colspan="4">
                    </th>
                </tr>
            </tfoot>
        </table> 
    </fieldset>
</div> <!-- Final da DIV content -->

<style>
    #label{
        display: inline-block;
        font-size: 15px;
    }
</style>

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">


    $(function () {
        $('#convenio1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniocirurgico', {convenio1: $(this).val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                    }
//                    $('#procedimento1').html(options).show();
                    $('#procedimento1 option').remove();
                    $('#procedimento1').append(options);
                    $("#procedimento1").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });


    if ($('#convenio1').val() != '') {
//                            alert('asdsd');
        $('.carregando').show();
        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniocirurgico', {convenio1: $('#convenio1').val(), ajax: true}, function (j) {
            var options = '<option value=""></option>';
            for (var c = 0; c < j.length; c++) {
                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';

            }

//                    $('#procedimento1').html(options).show();
            $('#procedimento1 option').remove();
            $('#procedimento1').append(options);
            $("#procedimento1").trigger("chosen:updated");
            $('.carregando').hide();

            $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $('#procedimento1').val(), ajax: true}, function (j) {
                options = "";
                options += j[0].valortotal;
                document.getElementById("valor1").value = options
                $('.carregando').hide();
            });
        });
    } else {
        $('#procedimento1').html('<option value="">-- Escolha um exame --</option>');
    }



    $(function () {
        $('#procedimento1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor1").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor1').html('value=""');
            }
        });
    });









</script>
