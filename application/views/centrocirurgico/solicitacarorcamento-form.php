<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link" style="width: 250px; ">
        <a style="width: 200px;" onclick="javascript: return confirm('Deseja realmente FINALIZAR O ORÇAMENTO? Após esta ação não será possível editar o orçamento.');" href="<?= base_url() ?>centrocirurgico/centrocirurgico/finalizarorcamento/<?= $solicitacao_id; ?>" style="width: 100px;">Finalizar Orçamento</a>
    </div>      
    <div class="bt_link">
        <a href="#">Faturar</a>
    </div>      
    <fieldset >
        <legend>Fazer Orçamento</legend>
        <div>
            <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaorcamento" method="post">
                <div style="padding-bottom: 50px;">
                    <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="<?= @$solicitacao_id; ?>"/>
                    <input type="hidden" name="convenio_id" id="convenio_id" value="<?= @$convenio_id; ?>"/>
                    <div>
                        <label>Função</label>
                        <select name="funcao" id="funcao" class="texto03" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($funcoes as $value) { ?>
                                <option value="<?= $value->funcao_cirurgia_id ?>"><?= $value->nome ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div>
                        <!--                        <label>Médico</label>
                                                <select name="cirurgiao1" id="cirurgiao1" class="texto04" required>
                                                    <option value="">SELECIONE</option>
                        <? foreach ($medicos as $value) { ?>
                                                                <option value="<?= $value->operador_id ?>"
                            <?
                            if (isset($cirurgiao->operador_responsavel) && $cirurgiao->operador_responsavel == $value->operador_id) :
                                echo 'selected';
                            endif;
                            ?>><?= $value->nome ?></option>
                        <? } ?>
                                                </select>-->
                        <input type="hidden" name="cirurgiao1_id"  value="<?= @$cirurgiao->solicitacao_cirurgia_orcamento_id ?>"/>
                    </div>
                    <div>
                        <label>Procedimento</label>
                        <select name="procedimento1" id="procedimento1" class="texto04" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($procedimentos as $value) { ?>
                                <option value="<?= $value->procedimento_tuss_id ?>"<?
                                if (isset($cirurgiao->procedimento_tuss_id) && $cirurgiao->procedimento_tuss_id == $value->procedimento_tuss_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->codigo ?> - <?= $value->nome ?> - <?= $value->convenio ?></option>
                                    <? } ?>
                        </select>
                    </div>
                    <div>
                        <label>Valor(R$)</label>
                        <input name="valor1" id="valor1" class="texto02" alt="decimal" value="<?= @$cirurgiao->valor ?>"/>
                    </div>
                    <br/>
                    <div style="margin-top: 10px;">
                        <textarea rows="3" cols="60" placeholder="obs..." name="obs"></textarea>
                    </div>
                </div> 
                <hr/>
                <div>
                    <button type="submit" name="btnEnviar">Adicionar</button>
                </div>

            </form>
        </div>
    </fieldset>
    <?php
    $valor_total = 0.00;
    if (count($procedimentos_orcamentados) > 0) {
        ?>
        <fieldset>

            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Grau de Participação</th>
                        <th class="tabela_header">Médico</th>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Valor</th>
                        <th class="tabela_header">Obs</th>
                        <th class="tabela_header" width="30px;" colspan="4"><center></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo_linha = "tabela_content01";
                    foreach ($procedimentos_orcamentados as $item) {
                        $valor_total += $item->valor;
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->grau_participacao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->medico; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->procedimento; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo number_format($item->valor, 2, ",", "."); ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->observacao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="30px;" style="width: 60px;">
                                    <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluiritemorcamento/<?= $item->solicitacao_cirurgia_orcamento_id; ?>/<?= $solicitacao_id; ?>/<?= $convenio_id; ?>" class="delete">
                                    </a>
                            </td>
                        </tr>
                    </tbody>
                <?php }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="8">
                            TOTAL GERAL = R$ <? echo number_format($valor_total, 2, ",", "."); ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    <? }
    ?>



</div> <!-- Final da DIV content -->
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
//                    b = options.toPrecision(2);
                            document.getElementById("valor1").value = options.replace(".", ",");
                            $('.carregando').hide();
                        });
                    } else {
                        $('#valor1').html('value=""');
                    }
                });
            });


</script>
