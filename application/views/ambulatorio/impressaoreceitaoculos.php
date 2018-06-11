
<meta charset="UTF-8">
<table border="0"  style="width: 100%; text-align: right;">

    <tbody>
        <tr>
            <td>Dr(a): <?= @$laudo[0]->medico; ?></td>

        </tr>
        <tr>
            <td>CRM: <?= @$laudo[0]->conselho; ?></td>

        </tr>

    </tbody>
</table>
<table border="0"  style="width: 100%">

    <tbody>
        <tr>
            <td>Paciente: <?= @$laudo[0]->paciente; ?></td>

        </tr>

    </tbody>
</table>
<br>
<br>
<br>
<!--<table>
    <tr>
        
    </tr>
    
</table>-->
<style>
    .teste {
        background:#a2a2a2;
        /*width:450px;*/
        width: 90%;
        margin: auto;
        padding:10px;
        text-align:center;

        -moz-border-radius:7px;
        -webkit-border-radius:7px;
        border-radius:7px;
    }

</style>
<div class="teste">
 <table border="0" style="width: 100%">
    <thead>

    </thead>
    <tbody>
        <tr style="text-decoration: underline">
            <td>OD</td>
            <td style="text-decoration: underline"><?= @$laudo[0]->oftamologia_od_av; ?></td>
            <td>Esf</td>
            <td style="text-decoration: underline"><?= @$laudo[0]->oftamologia_od_esferico; ?></td>
            <td>Cil</td>
            <td style="text-decoration: underline"><?= @$laudo[0]->oftamologia_od_cilindrico; ?></td>
        </tr>
        <tr>
            <td>OE</td>
            <td><?= @$laudo[0]->oftamologia_oe_av; ?></td>
            <td>Esf</td>
            <td><?= @$laudo[0]->oftamologia_oe_esferico; ?></td>
            <td>Cil</td>
            <td><?= @$laudo[0]->oftamologia_oe_cilindrico; ?></td>
        </tr>
        <tr>
            <td>Adição</td>
            <td colspan="3">_____</td>

            <td>DP</td>
            <td>_____</td>
        </tr>
    </tbody>
</table>   
</div>

<br>
<br>
<br>
<div class="teste">
<table border="0" style="width: 100%">
    <thead>

    </thead>
    <tbody>
        <tr>
            <td>Anotações:</td>

        </tr>
        <tr>
            <td><p><?= @$laudo[0]->conduta; ?></p></td>

        </tr>

    </tbody>
</table>    
    
</div>

<br>
<br>
<br>
<br>
<table border="0" style="width: 100%">
    <thead>

    </thead>
    <tbody>
        <tr>
            <td style="text-decoration: underline;text-align: center;font-size: 16px;"><?= date('d/m/Y', strtotime(@$laudo[0]->data_cadastro)); ?><br>Data</td>
            <? if ($assinatura != '') { ?>
                <td style="text-align: right;"><?= $assinatura ?><br><br>Oftamologista</td>   
                <? } else { ?>
                <td>___________________________________</td>    
            <? } ?>


        </tr>
        <tr>
            <td></td>
            <td></td>

        </tr>

    </tbody>
</table>
