
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

            <tr>
                <td ><b><font size = -1>Paciente: <?= $exames['0']->paciente; ?></b></td>
                <td ></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table>
        <tr>
            <td >Procedimento</td>
            <td >Qtde</td>
            <td >V. Unit</td>
            <td >CONVENIO</td>
            <td >V. Total</td>
        </tr>
        <?
        $total = 0;
        foreach ($exames as $item) :
            $total = $total + $item->valor_total;
            ?>
            <tr>

                <td width="25%;"><?= utf8_decode($item->procedimento) ?></td>
                <td ><?= utf8_decode($item->quantidade) ?></td>
                <td width="25%;"><?= number_format($item->valor, 2, ',', '.') ?></td>
                <td width="25%;"><?= $item->convenio ?></td>
                <td width="25%;"><?= number_format($item->valor_total, 2, ',', '.') ?></td>
            </tr>

            <?
        endforeach;
        ?>
            <tr>
                <td>&nbsp;</td>
            </tr>
        <tr>
            <td width="25%;"><b>Total Geral</b></td>
            <td ><b></b></td>
            <td ><b></b></td>
            <td ><b></b></td>
            <td width="25%;"><b><?= number_format($total, 2, ',', '.') ?></b></td>
        </tr>
        </tbody>
    </table>



</div>
