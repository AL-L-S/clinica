<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaoprocedimentosalterar" method="post">
        <?
        $perfil_id = $this->session->userdata('perfil_id');
        ?>
         <fieldset>
            <legend>Outras Opções</legend>   
            
            <div class="bt_link">
                <a target="_blank" href="<?= base_url() ?>centrocirurgico/centrocirurgico/carregarsolicitacaomaterial/<?= $dados[0]->solicitacao_cirurgia_id; ?>">Cadastrar Material</a>
            </div>
        </fieldset>
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
            <legend>Adicionar Procedimentos</legend>

            <fieldset>
                <legend>Procedimentos</legend>
                <input type="hidden" name="solicitacao_id" value="<?php echo $solicitacao_id; ?>"/>
                    <table>
                        <tr>
                            <td>Quantidade</td>
                            <td>
                                <input type="text" name="quantidade" id="quantidade" value="1" class="texto00"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Convenio</td>
                            <td><select  name="convenio1" id="convenio1" class="size2"  required=""<?
                                if ($perfil_id != 1) {
                                    echo 'disabled';
                                }
                                ?>>
                                    <option value="-1">Selecione</option>
                                    <? foreach ($convenios as $item) : ?>
                                        <option value="<?= $item->convenio_id; ?>" ><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Procedimento</td>
                            <td>
                                <select name="procedimentoID" id="procedimento1" class="size4 chosen-select" data-placeholder="Selecione" tabindex="1">
                                    <option value="">Selecione</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Valor Unitario</td>
                            <td><input type="text" name="valor1" id="valor1" <?
                                if ($perfil_id != 1) {
                                    echo 'readonly';
                                }
                                ?> class="texto01"/></td>
                        </tr>
<!--                        <tr>
                            <td>Pagamento</td>
                            <td><select  name="formapamento" id="formapamento" class="size2"  <?
                                if ($perfil_id != 1) {
                                    echo 'disabled';
                                }
                                ?>>
                                    <option value="0">Selecione</option>
                                    <? foreach ($forma_pagamento as $item) : ?>
                                        <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
                        </tr>-->
                    </table>
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
     
            </fieldset>

            <hr/>

            <!--<button type="submit" name="btnEnviar">Enviar</button>-->
            <!--<button type="reset" name="btnLimpar">Limpar</button>-->
        </fieldset>

        <fieldset id="cadastro"> 
            <!-- NAO REMOVA ESSE FIELDSET POIS O JAVASCRIPT IRA FUNCIONAR NELE!!! -->
        </fieldset>

        <fieldset > 
            <div class="bt_link">                                  
                <a onclick="javascript: return confirm('Deseja realmente Liberar a solicitacao?');" href="<?= base_url() ?>centrocirurgico/centrocirurgico/liberar/<?= $solicitacao_id ?>/<?= $dados[0]->orcamento ?>">Liberar</a>
            </div>
        </fieldset>

    </form>
    <?
    if (count($procedimentos) > 0) {
        ?>
        <table id="table_agente_toxico" border="0" style="width:600px">
            <thead>

                <tr>
                    <th class="tabela_header">Procedimento</th>
                    <th class="tabela_header">Quantidade</th>
                    <th class="tabela_header">Convenio</th>
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
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                <center>
                    <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluirsolicitacaoprocedimentoeditar/<?= $item->solicitacao_procedimento_id; ?>/<?= $solicitacao_id; ?>" class="delete">
                    </a>
                </center>
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
