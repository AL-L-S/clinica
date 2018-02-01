
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td >
                <div class="bt_link_new">
                    <a  onclick="javascript: return confirm('Deseja realmente atribuir os percentuais padrões da ANS? Os percentuais atuais irão ser perdidos.');" href="<?= base_url() ?>centrocirurgico/centrocirurgico/atribuirpadraopercentualans/">Associar Padrão ANS</a>
                </div>
            </td>
        </tr>
    </table>
    <div id="accordion">

        <h3><a href="#">Percentual Função Médico</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Codigo</th>
                        <th class="tabela_header">Descricao</th>
                        <th class="tabela_header">Percentual </th>
<!--                        <th class="tabela_header">Percentual (maior valor)</th>
                        <th class="tabela_header">Percentual (base)</th>-->
                        <th class="tabela_header"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
//                    echo '<pre>';
//                    var_dump($funcao);
//                    die;
                    $estilo_linha = "tabela_content01";
                    foreach ($funcao as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->codigo; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ",", ""); ?> %</td>
                            <!--<td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor_base, 2, ",", ""); ?> %</td>-->
                            <td class="<?php echo $estilo_linha; ?>">
                                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/editarpercentualfuncao/<?= $item->centrocirurgico_percentual_funcao_id; ?>">Editar</a>
                            </td>
                        </tr>
                    <? } ?>

                    <tr>
                        <td class="tabela_header" colspan="6">* O valor base para o cálculo será o valor que o cirurgião irá ganhar.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3><a href="#">Outros Percentuais</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Leito</th>
                        <th class="tabela_header">Via</th>
                        <th class="tabela_header">Percentual (maior valor)</th>
                        <th class="tabela_header">Percentual (base)</th>
                        <th class="tabela_header"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo_linha = "tabela_content01";
                    foreach ($percentual as $item) {
                        if ($item->horario_especial == 't') {
                            $horario = $item;
                            continue;
                        }

                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>">
                                <?= ($item->leito_enfermaria == 't') ? "ENFERMARIA" : "APARTAMENTO"; ?>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>">
                                <?= ($item->mesma_via == 't') ? "MESMA VIA" : "VIA DIFERENTE"; ?>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor, 2, ",", ""); ?> %</td>
                            <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor_base, 2, ",", ""); ?> %</td>
                            <td class="<?php echo $estilo_linha; ?>">
                                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/editarpercentualoutros/<?= $item->centrocirurgico_percentual_outros_id; ?>">Editar</a>
                            </td>
                        </tr>
                        <?
                    }
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>

                    <tr>
                        <td class="<?php echo $estilo_linha; ?>">HORARIO ESPECIAL</td>
                        <td colspan="3"  class="<?php echo $estilo_linha; ?>"><?= $horario->valor ?> %</td>
                        <td colspan="4" class="<?php echo $estilo_linha; ?>">
                            <a  href="<?= base_url() ?>centrocirurgico/centrocirurgico/editarhorarioespecial/<?= $horario->centrocirurgico_percentual_outros_id; ?>">Editar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });



</script>
