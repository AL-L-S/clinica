<meta charset="utf8">
<div class="content ficha_ceatox">
    <table>
        <tbody>
            <tr>
                <td width="80%;" ><font size = -1><?= $empresa[0]->razao_social; ?></td>
                <td ><font size = -1>Emissao:<?= str_replace("-", "/", $emissao); ?></td>
            </tr>
            <tr>
                <td ><font size = -1><?= $empresa[0]->logradouro; ?><?= $empresa[0]->numero; ?> - <?= $empresa[0]->bairro; ?></td>
                <td ></td>
            </tr>
            <tr>
                <td ><font size = -1>Fone: <?= $empresa[0]->telefone; ?></td>
                <td ></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table border="1">
        <tr>
            <td >Procedimento</td>
            <td >Convenio</td>
            <td >Qtde</td>
            <td >V. Unit</td>
            <td >V. Total</td>
            <td >Descriçao</td>
        </tr>
        <?
        $total = 0;
        $i = 0;
        $contador = count($convenio);
        for ($i = 0 ; $i < $contador; $i++) :
            $valor_total = str_replace(",", ".", $valor[$i]) * $qtde[$i];
            $total = $total + $valor_total;
            ?>
            <tr>

                <td width="25%;"><?= utf8_decode($procedimento[$i]) ?></td>
                <td width="25%;"><?= $convenio[$i] ?></td>
                <td style="text-align: right"><?= utf8_decode($qtde[$i]) ?></td>
                <td width="25%;" style="text-align: right"><?= $valor[$i] ?></td>
                <td width="25%;" style="text-align: right"><?= number_format($valor_total, 2, ',', '.') ?></td>
                <td width="25%;" style="text-align: right"><?= $descricao[$i] ?></td>
            </tr>

            <?
        endfor;
        ?>
<!--            <tr>
                <td>&nbsp;</td>
            </tr>-->
        <tr>
            <td width="25%;" colspan="7" style="text-align: right"><b>Total Geral: <?= number_format($total, 2, ',', '.') ?></b></td>
            <!--<td width="25%;"><b></b></td>-->
        </tr>
        </tbody>
    </table>



</div>
