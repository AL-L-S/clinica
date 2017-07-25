
<div class="content ficha_ceatox">

    <table>
        <tbody>
            <tr>
                <td colspan="2" ><font size = -1><center><?= utf8_decode($empresa[0]->nome) ?></center></td>
        </tr>
        <tr>
            <td  ><font size = -2><b><?= str_replace("-", "/", $emissao); ?>-<?= $paciente['0']->nome; ?></b></td>
            <td ><font size = -2></td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <?
            $i = 0;
                    ?>
                <td ><font size = -2><?= utf8_decode($exame[0]->procedimento) ?></td>
                <?
                ?>
            </tbody>
    </table>
</div>
