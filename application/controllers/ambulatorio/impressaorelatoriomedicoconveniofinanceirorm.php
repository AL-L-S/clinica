<div class="content"> <!-- Inicio da DIV content -->
    <h4>HUMANA IMAGEM</h4>
    <h4>Medico Convenios RM</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
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
                            <td><font size="-2">R$ 75,00</td>
                            <?
                            $y++;
                            $valor = $valor + 75;
                            $valortotalexames = $valortotalexames + 75;
                            ?>
                        <? } else { ?>
                            <td><font size="-2">R$ 50,00</td>

                            <?
                            $valortotalexames = $valortotalexames + 50;
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
        <? } else {
            $y = 0;
            $valor = 0;
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    if (count($revisor)> 0) {
    

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
                <td ><font size="-1">R$ 75,00</td>
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
                    $totalrevisor = $items->quantidade * 50.00;
                    ?>

                    <tr>
                        <td ><font size="-1"><?= $items->revisor ?></td>
                        <td ><font size="-1"><?= $items->quantidade ?></td>
                        <td ><font size="-1">R$ 50,00</td>
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
                    $totalrevisor = $items->quantidade * 25.00;
                    ?>

                    <tr>
                        <td ><font size="-1"><?= $items->revisor ?></td>
                        <td ><font size="-1"><?= $items->quantidade ?></td>
                        <td ><font size="-1">R$ 25,00</td>
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
    <?}?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>