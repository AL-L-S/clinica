<div class="content"> <!-- Inicio da DIV content -->
    <h4>HUMANA IMAGEM</h4>
    <h4>Medico Convenios RM</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
    <h4>Medico: <?= $medico[0]->operador; ?></h4>
    <hr>
    <? if ($contador > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                    <th class="tabela_header"><font size="-1">Data</th>
                    <th class="tabela_header"><font size="-1">Quantidade</th>
                    <th class="tabela_header" width="220px;"><font size="-1">Procedimento</th>
                    <th class="tabela_header" width="100px;"><font size="-1">Laudo</th>
                    <th class="tabela_header" ><font size="-1">Revisor</th>
                    <th class="tabela_header" width="80px;"><font size="-1">Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $valor = 0;
                $valortotal = 0;
                $valortotalexames = 0;
                $totalrevisor = 0;
                $convenio = "";
                $y = 0;
                $qtde = 0;
                $qtdetotal = 0;
                foreach ($relatorio as $item) :
                    $i++;
                    ?>
                    <tr>
                        <td><font size="-2"><?= $item->convenio; ?></td>
                        <td><font size="-2"><?= $item->paciente; ?></td>
                        <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                        <td><font size="-2"><?= $item->quantidade; ?></td>
                        <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                        <td><font size="-2"><?= $item->situacaolaudo; ?></td>
                        <td><font size="-2"><?= substr($item->revisor, 0, 20); ?></td>
                        <? if ($item->revisor == "") { ?>
                            <? if ($item->convenio_id != 9 && $item->convenio_id != 12 && $item->convenio_id != 5 && $item->convenio_id != 17 && $item->convenio_id != 8 && $item->convenio_id != 6 && $item->convenio_id != 19 && $item->convenio_id != 36 && $item->convenio_id != 4 && $item->convenio_id != 50 && $item->convenio_id != 52) { ?>
                                <td><font size="-2">R$ 50,00 </td>
                            <? } else { ?>
                                <td><font size="-2">R$ 75,00 </td>
                            <? }
                            ?>

                            <?
                            $y++;
                            if ($item->convenio_id != 9 && $item->convenio_id != 12 && $item->convenio_id != 5 && $item->convenio_id != 17 && $item->convenio_id != 8 && $item->convenio_id != 6 && $item->convenio_id != 19 && $item->convenio_id != 36 && $item->convenio_id != 4 && $item->convenio_id != 50 && $item->convenio_id != 52) {
                                $valor = $valor + 50;
                                $valortotalexames = $valortotalexames + 50;
                            } else {
                                $valor = $valor + 75;
                                $valortotalexames = $valortotalexames + 75;
                            }
                            ?>
                        <? } else { ?>
                            <? if ($item->convenio_id != 9 && $item->convenio_id != 12 && $item->convenio_id != 5 && $item->convenio_id != 17 && $item->convenio_id != 8 && $item->convenio_id != 6 && $item->convenio_id != 19 && $item->convenio_id != 36 && $item->convenio_id != 4 && $item->convenio_id != 50 && $item->convenio_id != 52) { ?>
                                <td><font size="-2">R$ 35,00</td>
                            <? } else { ?>
                                <td><font size="-2">R$ 50,00</td>
                            <? }
                            ?>


                            <?
                            if ($item->convenio_id != 9 && $item->convenio_id != 12 && $item->convenio_id != 5 && $item->convenio_id != 17 && $item->convenio_id != 8 && $item->convenio_id != 6 && $item->convenio_id != 19 && $item->convenio_id != 36 && $item->convenio_id != 4 && $item->convenio_id != 50 && $item->convenio_id != 52) {
                                $valortotalexames = $valortotalexames + 35;
                            } else {
                                $valortotalexames = $valortotalexames + 50;
                            }
                        }
                        ?>
                    </tr>


                    <?php
                    $qtdetotal = $qtdetotal + $item->quantidade;
                endforeach;
                ?>
                <tr>
                    <td ><font size="-1">TOTAL GERAL</td>
                    <td colspan="3"><font size="-1"><center><?= $qtdetotal; ?></center></td>
            <td colspan="4"><font size="-1"><center>R$ <?= number_format($valortotalexames, 2, ',', '.'); ?></center></td>
            </tr>
            </tbody>
        </table>
        <?
    } else {
        $y = 0;
        $valor = 0;
        ?>
        <h4>Medico: <?= $medico[0]->operador; ?>, n&atilde;o fez laudo</h4>
        <?
    }
    if (count($revisada) > 0) {
        ?>
        <hr>
        <table border="1">
            <tr>
                <th class="tabela_header"><font size="-1">Medico</th>
                <th class="tabela_header"><font size="-1">QTDE</th>
                <th class="tabela_header"><font size="-1">Valor Unit.</th>
                <th class="tabela_header"><font size="-1">Total Bruto</th>
            </tr>
            <tr>
                <td ><font size="-1"><b>SEM REVISOR</b></td>
                <td ><font size="-1"><?= $y ?></td>
                <td ><font size="-1">Novo(R$ 50,00) Antigo (R$ 75,00)</td>



                <td ><font size="-1">R$<?= number_format($valor, 2, ',', '.'); ?></td>
            </tr>
            <tr>
                <td colspan="4"><font size="-1"><center><b>COM REVISOR</b></center></td>
            </tr>
            <?
            $valortotal = $valor;
            $qtdetotal = $y;
            foreach ($revisor as $items) :
                if ($items->revisor != "") {
                    if ($item->convenio_id != 9 && $item->convenio_id != 12 && $item->convenio_id != 5 && $item->convenio_id != 17 && $item->convenio_id != 8 && $item->convenio_id != 6 && $item->convenio_id != 19 && $item->convenio_id != 36 && $item->convenio_id != 4 && $item->convenio_id != 50 && $item->convenio_id != 52) {
                        $totalrevisor = $items->quantidade * 35.00;
                    } else {
                        $totalrevisor = $items->quantidade * 50.00;
                    }
                    ?>

                    <tr>
                        <td ><font size="-1"><?= $items->revisor ?></td>
                        <td ><font size="-1"><?= $items->quantidade ?></td>
                        <? if ($item->convenio_id != 9 && $item->convenio_id != 12 && $item->convenio_id != 5 && $item->convenio_id != 17 && $item->convenio_id != 8 && $item->convenio_id != 6 && $item->convenio_id != 19 && $item->convenio_id != 36 && $item->convenio_id != 4 && $item->convenio_id != 50 && $item->convenio_id != 52) { ?>
                            <td ><font size="-1">R$ 35,00</td>
                        <? } else { ?>
                            <td ><font size="-1">R$ 50,00</td>
                        <? }
                        ?>
                        <td ><font size="-1">R$<?= number_format($totalrevisor, 2, ',', '.'); ?></td>
                    </tr>

                    <?
                }
                $valortotal = $valortotal + $totalrevisor;
                $qtdetotal = $qtdetotal + $items->quantidade;
                $totalrevisor = 0;
            endforeach;
            ?>
            <tr>
                <td colspan="4"><font size="-1"><center><b>COMO REVISOR</b></center></td>
            </tr>
            <?
            foreach ($revisada as $items) :
                if ($items->revisor != "") {
                    if ($item->convenio_id != 9 && $item->convenio_id != 12 && $item->convenio_id != 5 && $item->convenio_id != 17 && $item->convenio_id != 8 && $item->convenio_id != 6 && $item->convenio_id != 19 && $item->convenio_id != 36 && $item->convenio_id != 4 && $item->convenio_id != 50 && $item->convenio_id != 52) {
                        $totalrevisor = $items->quantidade * 15.00;
                    } else {
                        $totalrevisor = $items->quantidade * 25.00;
                    }
                    ?>

                    <tr>
                        <td ><font size="-1"><?= $items->revisor ?></td>
                        <td ><font size="-1"><?= $items->quantidade ?></td>
                        <td ><font size="-1">Novo(R$ 15,00) Antigo (R$ 25,00)</td>


                        <td ><font size="-1">R$<?= number_format($totalrevisor, 2, ',', '.'); ?></td>
                    </tr>

                    <?
                }
                $valortotal = $valortotal + $totalrevisor;
                $qtdetotal = $qtdetotal + $items->quantidade;
                $totalrevisor = 0;
            endforeach;
            ?>
            <tr>
                <td ><font size="-1">TOTAL A RECEBER</td>
                <td ><font size="-1"><?= $qtdetotal ?></td>
                <td colspan="2"><font size="-1"><center><?= number_format($valortotal, 2, ',', '.'); ?></center></td>
            </tr>
        </table>
    <? } else {
        ?>
        <h4>Medico: <?= $medico[0]->operador; ?>, n&atilde;o foi revisor</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>