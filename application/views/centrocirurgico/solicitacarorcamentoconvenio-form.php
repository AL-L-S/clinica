<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->      
    <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaorcamentoconvenio" method="post">
        <fieldset>
            <legend>Outras Opções</legend>   
            <div class="bt_link">
                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/carregarsolicitacaoeditarconvenio/<?= @$solicitacao_id; ?>">Cadastrar</a>
            </div>
            <div class="bt_link">
                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/montarequipe/<?= @$solicitacao_id; ?>">Equipe</a>
            </div>
            <!--            <div class="bt_link">
                            <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/solicitacarorcamento/<?= @$solicitacao_id; ?>">Orçamento</a>
                        </div>-->
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

        </fieldset>

        <fieldset>
            <legend>Criar Guia Convênio</legend>

            <!--            <fieldset>
                            <legend>Desconto (%)</legend>
                            <div>
                                <input type="number" id="desconto" name="desconto" value="0" step="0.01" min="0" required=""/>
                            </div>
                        </fieldset>-->

<!--            <fieldset>
                <legend>Via</legend>
                <div id="via">
                    <input type="radio" name="via" id="m" <?
                    if (@$solicitacao[0]->via == 'M') {
                        echo 'checked';
                    }
                    ?> value="M" required/> <label for="m">Mesma Via</label>
                    <input type="radio" name="via" id="d" <?
                    if (@$solicitacao[0]->via == 'D') {
                        echo 'checked';
                    }
                    ?>  value="D" required/> <label for="d">Via Diferente</label>
                </div>
            </fieldset>-->

            <fieldset>
                <legend>Procedimentos</legend>
                <table id="table_agente_toxico" border="0">
                    <thead>

                        <tr>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">Convênio</th>
                            <th class="tabela_header">Valor</th>
                            <th class="tabela_header">Quantidade</th>
                            <th class="tabela_header">Horário Especial</th>
                            <th class="tabela_header">Equipe Particular</th>
                            <th style="text-align: center;" class="tabela_header" colspan="2">Via</th>
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
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="hidden" name="procedimento_convenio_id[<?= $i; ?>]" value="<?= $item->procedimento_convenio_id; ?>" />
                                    <input type="hidden" name="cirurgia_procedimento_id[<?= $i; ?>]" value="<?= $item->solicitacao_cirurgia_procedimento_id; ?>" />
                                    <?= $item->procedimento; ?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <?= $item->convenio; ?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="number" id="valor" name="valor[<?= $i; ?>]" value="<?= @$item->valortotal; ?>" step="0.01" required=""/>
                                </td> 
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="text" name="qtde[<?= $i; ?>]" id="qtde" alt="integer" class="texto01" value="1" required=""/>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="checkbox" name="horEspecial[<?= $i; ?>]">
                                </td>                            
                                <td class="<?php echo $estilo_linha; ?>">
                                    <input type="checkbox" name="equipe_particular[<?= $i; ?>]">
                                </td>  
                                <td style="width: 280px" class="<?php echo $estilo_linha; ?>">
                                    <div id="via">
                                        <input type="radio" name="via[<?= $i; ?>]" id="m<?= $i; ?>" <?
                                        if ($item->via == 'M') {
                                            echo 'checked';
                                        }
                                        ?> value="M" required/> <label for="m<?= $i; ?>">Mesma Via</label>
                                        <input type="radio" name="via[<?= $i; ?>]" id="d<?= $i; ?>" <?
                                        if ($item->via == 'D') {
                                            echo 'checked';
                                        }
                                        ?>  value="D" required/> <label for="d<?= $i; ?>">Via Diferente</label>
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
        $('#procedimento1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalororcamento', {procedimento1: $(this).val(), convenio: $("#convenio_id").val()}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor1").value = options.replace(".", ",");
                    $('.carregando').hide();
                });
            } else {
                $('#valor1').html('value=""');
            }
        });
    });


</script>
