
<div class="content ficha_ceatox">

    <table>
        <tbody>
            <tr>
                <td colspan="2" ><font size = -1><center><?= utf8_decode($empresa[0]->nome) ?></center></td>
        </tr>
        <tr>
            <td  ><font size = -2><b><?= substr($paciente['0']->nascimento, 8, 2) . "/" . substr($paciente['0']->nascimento, 5, 2) . "/" . substr($paciente['0']->nascimento, 0, 4); ?> - <?= $paciente['0']->nome; ?></b></td>
        </tr>
        <tr>
            <td ><font size = -2><center><?= $paciente['0']->nome_convenio; ?></center></td>
        </tr>
        </tbody>
    </table>

</div>
