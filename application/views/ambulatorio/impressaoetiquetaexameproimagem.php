
<div class="content ficha_ceatox">

    <table>
        <tbody>
            <tr>
                <td  ><font size = -2><?= substr($exame['0']->sala, 0,10); ?></td><td ><font size = -2>Data:&nbsp<?= substr($exame['0']->data, 8, 2) . "/" . substr($exame['0']->data, 5, 2) . "/" . substr($exame['0']->data, 0, 4);; ?></td>
            </tr>
            <tr>
                <td colspan="2" ><font size = -2>Nome:&nbsp;<?= utf8_decode($paciente['0']->nome); ?></td>
            </tr>
            <tr>
                <td  ><font size = -2>C&oacute;digo:&nbsp<b><?= $paciente['0']->paciente_id; ?></b></td><td  ><font size = -2>Conv&ecirc;nio:&nbsp<?= utf8_decode($exame['0']->convenio); ?></td>
            </tr>
            <tr>
                <td colspan="2" ><font size = -2>Dr(a):&nbsp<?= utf8_decode($exame['0']->medicosolicitante); ?></td>
            </tr>
            <tr>
                
            </tr>
            <tr>
                
            </tr>
        </tbody>
    </table>
</div>