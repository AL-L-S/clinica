<meta charset="utf8">
<style>
    .negrito{
        font-weight: bold;
    }
</style>
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
    <table cellpadding="5">
        <tr>
            <td class="negrito">Procedimento</td>
            <td class="negrito">Qtde</td>
            <td class="negrito">V. Unit</td>
            <td class="negrito">Grupo</td>
            <td class="negrito">Convenio</td>
            <td class="negrito">Valor</td>
            <td class="negrito">Valor Cartão</td>
        </tr>
        <?
        $total = 0;
        $totalCartao = 0;
        foreach ($exames as $item) :
            $total = $total + $item->valor_total;
            $totalCartao = $totalCartao + $item->valor_total_ajustado;
            ?>
            <tr>

                <td width="25%;"><?= utf8_decode($item->procedimento) ?></td>
                <td ><?= utf8_decode($item->quantidade) ?></td>
                <td width="10%;"><?= number_format($item->valor, 2, ',', '.') ?></td>
                <td width="10%;"><?= $item->grupo ?></td>
                <td width="10%;"><?= $item->convenio ?></td>
                <td width="15%;"><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                <td width="20%;"><?= number_format($item->valor_total_ajustado, 2, ',', '.') ?></td>
            </tr>

            <?
        endforeach;
        ?>
            <tr>
                <td colspan="5"></td>
                <td colspan="">
                    <span class="negrito">Total:</span> <?= number_format($total, 2, ',', '.') ?>
                </td>
                <td colspan="">
                    <span class="negrito">Total Cartão:</span> <?= number_format($totalCartao, 2, ',', '.') ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
<!--        <tr>
            <td width="25%;"><b>Total Geral</b></td>
            <td ><b></b></td>
            <td ><b></b></td>
            <td ><b></b></td>
            <td width="25%;"><b><?= number_format($total, 2, ',', '.') ?></b></td>
        </tr>-->
        </tbody>
    </table>



</div>
