<HEAD>
    <meta charset="utf-8">
</HEAD>
<center><table>
        <tbody>
        <tr>
                <td colspan="2"  ><font size = -1>SETOR : <? echo $nome[0]->nome ?> - <? echo $estoque_solicitacao_id?> </font></td>
                <td ><font size = -1><center></center></font></td>
        <td width="30px">&nbsp;</td>
        <tr>
            <td colspan="2"  ><font size = -1>DATA SAIDA.: <? echo date('d/m/y', strtotime(substr($nome[0]->data_cadastro, 0, 10))); ?> </font></td>
            <td ><font size = -1><center></center></font></td>
        <td width="30px">&nbsp;</td>
        <tr>
            <td colspan="2"  ><font size = -1>SOL.: <? echo $nome[0]->solicitante ?></font></td>
            <td ><font size = -1><center></center></font></td>
        <td width="30px">&nbsp;</td>
        <tr>
            <td colspan="2"  ><font size = -1>LIB.: <? echo $nome[0]->liberou ?></font></td>
            <td ><font size = -1><center></center></font></td>
        <td width="30px">&nbsp;</td>
        </tbody>
    </table></center>
<center><table border="1">
        <thead>
            <tr>
                <td class="tabela_teste"><font size="-2">PRODUTO</td>
                <td class="tabela_teste"><font size="-2">VALOR UNIT</td>
                <td class="tabela_teste"><font size="-2">VALOR TOTAL DE SAÍDA</td>
                <td class="tabela_teste"><font size="-2">QTDE/SOLIC.</td>
                <td class="tabela_teste"><font size="-2">UNID</td>
                <td class="tabela_teste"><font size="-2">SAÍDA</td>
    <!--            <td class="tabela_teste"><font size="-2">SALDO/ESTOQUE</td>-->
                <td class="tabela_teste"><font size="-2">SALDO APÓS SAIDA</td>
                <td class="tabela_teste"><font size="-2">SALDO ATUAL</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($produtossaida as $item) : ?>
                <tr>
                    <td><font size="-2"><?= $item->descricao; ?></td>
                    <td><font size="-2"><?= number_format($item->valor_unitario, 2, ",", ".") ; ?></td>
                    <td><font size="-2"><?= number_format($item->valor_total, 2, ",", ".") ; ?></td>
                    <td><font size="-2"><?= $item->quantidade_solicitada; ?></td>
                    <td><font size="-2"><?= $item->unidade; ?></td>
                    <td><font size="-2"><?= $item->quantidade; ?></td>
                    <td><font size="-2"><?= $item->saldo; ?></td>
                    <td><font size="-2"><?= $item->saldo_atual; ?></td>
<!--                    <td><font size="-2"></td>-->
<!--                    <td><font size="-2"><?= date('d/m/y', strtotime(substr($item->validade, 0, 10))); ?></td>-->
                </tr>
            <? endforeach; ?>

        </tbody>

    </table></center>



