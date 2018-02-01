<table>
    <tbody>
        <tr>
            <td colspan="2"  ><font size = -1>SETOR</font></td>
            <td width="280px"><font size = -1><center></center></font></td>
<td width="30px">&nbsp;</td>
</table>
<table border="1">
    <thead>
        <tr>
            <td class="tabela_teste"><font size="-2">Produto</th>
            <td class="tabela_teste"><font size="-2">QTDE</th>
            <td class="tabela_teste"><font size="-2">Validade</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($produtossaida as $item) : ?>
            <tr>
                <td><font size="-2"><?= utf8_decode($item->descricao); ?></td>
                <td><font size="-2"><?= utf8_decode($item->quantidade); ?></td>
                <td><font size="-2"><?= utf8_decode($item->validade); ?></td>
            </tr>
        <? endforeach; ?>

    </tbody>

</table>

