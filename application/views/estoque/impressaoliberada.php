<HEAD>
    <meta charset="utf-8">
</HEAD>
<center><table>
        <tbody>
            <tr>
                <td colspan="2"  ><font size = -1>CLIENTE : <? echo $nome[0]->nome ?>  </font></td>
                <td ><font size = -1><center></center></font></td>
        <td width="30px">&nbsp;</td>
        <tr>
            <td colspan="2"  ><font size = -1>DATA DO PEDIDO: <? echo date('d/m/y', strtotime(substr($nome[0]->data_liberacao, 0, 10))); ?> </font></td>
            <td ><font size = -1><center></center></font></td>
        <td width="30px">&nbsp;</td>
        <tr>
            <td colspan="2"  ><font size = -1>SOL.: <? echo $nome[0]->solicitante ?></font></td>
            <td ><font size = -1><center></center></font></td>
        <td width="30px">&nbsp;</td>
        </tbody>
    </table></center>
<center><table border="1">
        <thead>
            <tr>
                <td class="tabela_teste"><font size="-2">Produto</td>
                <td class="tabela_teste"><font size="-2">UNID</td>
                <td class="tabela_teste"><font size="-2">QTDE/SOLIC.</td>
            </tr>
        </thead>
        <tbody>
            <? foreach ($produtossaida as $item) : ?>
                <tr>
                    <td><font size="-2"><?= utf8_decode($item->descricao); ?></td>
                    <td><font size="-2"><?= utf8_decode($item->unidade); ?></td>
                    <td><font size="-2"><?= utf8_decode($item->quantidade_solicitada); ?></td>
                </tr>
            <? endforeach; ?>

        </tbody>

    </table></center>



