<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->      
    <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/autorizarsolicitacaocirurgica" method="post">
        <fieldset>
            <legend>Outras Opções</legend>   
            <div class="bt_link">
                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/carregarsolicitacaoeditar/<?= @$solicitacao[0]->solicitacao_cirurgia_id; ?>">Cadastrar</a>
            </div>
            <div class="bt_link">
                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/montarequipe/<?= @$solicitacao[0]->solicitacao_cirurgia_id; ?>">Equipe</a>
            </div>
            <div class="bt_link">
                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/solicitacarorcamento/<?= @$solicitacao[0]->solicitacao_cirurgia_id; ?>">Orçamento</a>
            </div>
            <div class="bt_link">
                <a target="_blank" href="<?= base_url() ?>centrocirurgico/centrocirurgico/solicitacarorcamentoconvenio/<?= @$solicitacao[0]->solicitacao_cirurgia_id; ?>">Guia Convênio</a>
            </div>
            <div class="bt_link">
                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/carregarsolicitacaomaterial/<?= @$solicitacao[0]->solicitacao_cirurgia_id; ?>">Cadastrar Material</a>
            </div>
        </fieldset>
        <fieldset >
            <legend>Dados da Solicitacao</legend>

            <div>
                <label>Paciente</label>
                <input type="hidden" id="txtsolcitacao_id" class="texto_id" name="txtsolcitacao_id" readonly="true" value="<?= @$solicitacao_id; ?>" />
                <input type="hidden" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" value="<?= @$solicitacao[0]->paciente_id; ?>" />
                <input type="text" id="txtNome" required name="txtNome" class="texto10" value="<?= @$solicitacao[0]->paciente; ?>" readonly="true"/>
            </div>

            <div>
                <label>Telefone</label>
                <input type="text" id="telefone" class="texto02" name="telefone" value="<?= @$solicitacao[0]->telefone; ?>" readonly="true"/>
            </div>

            <div>
                <label>Solicitante</label>
                <input type="text"  id="solicitante" class="texto02" name="solicitante" value="<?= @$solicitacao[0]->solicitante; ?>" readonly="true"/>
            </div>

            <div>
                <label>Convenio</label>
                <input type="text"  id="convenio" class="texto02" name="convenio" value="<?= @$solicitacao[0]->convenio; ?>" readonly="true"/>
            </div>

            <div>
                <label>Hospital</label>
                <input type="text"  id="hospital" class="texto02" name="hospital" value="<?= @$solicitacao[0]->hospital; ?>" readonly="true"/>
            </div>
            <div>
                <label>Observação</label>
                <textarea readonly="" cols="" rows="5" name="observacao" class="texto_area"><?= @$solicitacao[0]->observacao; ?></textarea>
            </div>

        </fieldset>

        <fieldset>
            <legend>Autorizar Procedimentos</legend>

            <fieldset>
                <div>
                    <label>Data Cirurgia</label>
                    <input type="text" name="txtdata" id="txtdata" alt="date" class="texto02" value="<?
                    if (@$solicitacao[0]->data_prevista != '') {
                        echo date("d/m/Y", strtotime(@$solicitacao[0]->data_prevista));
                    }
                    ?>" required/>
                </div>
                <div>
                    <label>Hora Inicio</label>
                    <input type="text" name="hora" id="hora" alt="99:99" class="texto02" value="<?
                    if (@$solicitacao[0]->hora_prevista != '') {
                        echo date("H:i", strtotime(@$solicitacao[0]->hora_prevista));
                    }
                    ?>" required/>
                </div>
                <div>
                    <label>Hora Fim</label>
                    <input type="text" name="hora_fim" id="hora_fim" alt="99:99" class="texto02" value="<?
                    if (@$solicitacao[0]->hora_prevista_fim != '') {
                        echo date("H:i", strtotime(@$solicitacao[0]->hora_prevista_fim));
                    }
                    ?>" required/>
                </div>
                <div>
                    <label>Desconto (%)</label>
                    <input type="number" id="desconto" name="desconto" value="0" step="0.01" min="0" required=""/>
                </div>


            </fieldset>

            <fieldset>
                <div>
                    <div id="alterardatacirurgia"  style="cursor: pointer;" class="bt_link"><a>Alterar Data</a></div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Procedimentos</legend>
                <table id="table_agente_toxico" border="0">
                    <thead>

                        <tr>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">Convênio</th>
                            <th class="tabela_header">Valor U</th>
                            <th class="tabela_header">Quantidade</th>
                            <th class="tabela_header">Valor T</th>
                            <th class="tabela_header">Horario Especial</th>
                            <th class="tabela_header" colspan="2">Via</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        $i = 0;
                        foreach ($procedimentos as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td  class="<?php echo $estilo_linha; ?>">
                                    <input type="hidden" name="procedimento_convenio_id[<?= $i; ?>]" value="<?= $item->procedimento_convenio_id; ?>" />
                                    <input type="hidden" name="cirurgia_procedimento_id[<?= $i; ?>]" value="<?= $item->solicitacao_cirurgia_procedimento_id; ?>" />
                                    <?= $item->procedimento; ?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <?= $item->convenio; ?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="number" id="valor<?= $i; ?>" class="texto02" name="valor[<?= $i; ?>]" value="<?= @$item->valor_unitario; ?>" step="0.01" required=""/>
                                </td> 
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="number" name="quantidade[<?= $i; ?>]" id="quantidade<?= $i; ?>" alt="integer" class="texto01" value="<?= @$item->quantidade; ?>" required=""/>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="number" id="valor_total<?= $i; ?>" class="texto02"  name="valor_total[<?= $i; ?>]" value="<?= @$item->quantidade * @$item->valor_unitario; ?>" step="0.01" required=""/>
                                </td> 

                <!--                                <td class="<?php echo $estilo_linha; ?>">
                    <input type="number" id="valor_total<?= $i; ?>" name="valor_total[<?= $i; ?>]" value="<?= @$item->quantidade * @$item->valor_unitario; ?>" step="0.01" required=""/>
                    <input type="number" id="valor<?= $i; ?>" name="valor[<?= $i; ?>]" value="<?= @$item->quantidade * @$item->valor_unitario; ?>" step="0.01" required=""/>
                </td> -->
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="text" name="quantidade[<?= $i; ?>]" id="quantidade" alt="integer" class="texto01" value="<?= @$item->quantidade; ?>" required=""/>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="checkbox" name="horEspecial[<?= $i; ?>]">
                                </td>                            
                                <td style="width: 300px" class="<?php echo $estilo_linha; ?>">
                                    <div id="via">
                                        <input type="radio" name="via[<?= $i; ?>]" id="m" <?
                                        if ($item->via == 'M') {
                                            echo 'checked';
                                        }
                                        ?> value="M" required/> <label for="m">Mesma Via</label>
                                        <input type="radio" name="via[<?= $i; ?>]" id="d" <?
                                        if ($item->via == 'D') {
                                            echo 'checked';
                                        }
                                        ?>  value="D" required/> <label for="d">Via Diferente</label>
                                    </div>
                                </td>                            


                            </tr>
                            <?
                            $i++;
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

            <hr/>

            <button type="submit" name="btnEnviar">Enviar</button>
            <button type="reset" name="btnLimpar">Limpar</button>
        </fieldset>

    </form>
</div> <!-- Final da DIV content -->
<style>
    div#via label { color: black;}
    div#via label, div#via input{ display: inline-block; }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    $(function () {
        $("#txtdata").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function () {
        $('#valor').blur(function () {

        });
    });


    $(function () {
        $('#alterardatacirurgia').click(function () {
//            $('#txtdata').val();
//            $('#hora').val();
//            $('#hora_fim').val();
            alert('Data alterada com sucesso');

            $.getJSON('<?= base_url() ?>autocomplete/alterardatacirurgiajson', {solicitacao_id: $('#txtsolcitacao_id').val(), txtdata: $('#txtdata').val(), hora: $('#hora').val(), hora_fim: $('#hora_fim').val(), ajax: true}, function (t) {
//                   if(j == 'true'){
//                        alert('Data Alterada com sucesso');
//                   }else{
//                       alert('Erro ao alterar data'); 
//                   }
                   console.log(t);
//                   window.location.reload(); 
            });

        });
    });


    $(function () {

        $('#desconto').blur(function () {
            desconto = $('#desconto').val();
<? for ($b = 0; $b < $i; $b++) { ?>
                valor_destacado<?= $b ?> = $('#valor_total<?= $b ?>').val();
                valor<?= $b ?> = valor_destacado<?= $b ?> - (valor_destacado<?= $b ?> * (desconto / 100));
                //               alert(valor<?= $b ?>);
                $('#valor_total<?= $b ?>').val(valor<?= $b ?>);
<? } ?>
        });
    });

<? for ($b = 0; $b < $i; $b++) { ?>
        $(function () {
            $('#quantidade<?= $b ?>').change(function () {

                var valor_total = $("#valor<?= $b ?>").val() * $("#quantidade<?= $b ?>").val();
                //            alert(valor_total);
                $("#valor_total<?= $b ?>").val(valor_total);


            });
        });
        $(function () {
            $('#valor<?= $b ?>').change(function () {

                var valor_total = $("#valor<?= $b ?>").val() * $("#quantidade<?= $b ?>").val();
                //            alert(valor_total);
                $("#valor_total<?= $b ?>").val(valor_total);


            });
        });
<? } ?>

</script>
