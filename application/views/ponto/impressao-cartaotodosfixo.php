
<?
$matricula = '';
//        echo "<pre>";
//        var_dump($critica);
//        die;

foreach ($critica as $value) :

    foreach ($fixo as $itens) :

        if ($value->data == $itens->data && $value->funcionario_id == $itens->funcionario_id) {

            $horaentrada1 = $itens->horaentrada1;
            $horasaida1 = $itens->horasaida1;
            $horaentrada2 = $itens->horaentrada2;
            $horasaida2 = $itens->horasaida2;
            $horaentrada3 = $itens->horaentrada3;
            $horasaida3 = $itens->horasaida3;
            break;
        }
    endforeach;
    if ($matricula == '') {
        ?>

<!--<a><img src="<?= base_url() ?>img/logohdebo.gif" width="150" height="65" alt="teste"></a>-->
<br>
<table>
    <tr><td width="85%"><font size="-2">Empresa:HOSP DIST MARIA JOSE B. DE OLIVEIRA - FROTINHA DA PARANGABA</font></td><td><font size="-2">Cart&atilde;o de Ponto</font></td><td></td></tr>
    <tr><td width="80%"><font size="-2">CNPJ:07.206.048/0002-80</font></td><td></td><td></td></tr>
</table>
        <table>
            <tr><td width="50%"><font size="-2">Atividade: Hospitalar</font></td><td><font size="-2">Setor: <?= utf8_decode($value->setor); ?></font></td><td></td></tr>
            <tr><td width="50%"><font size="-2">Endere&ccedil;o:Av Jornalista Tomas Coelho, 1578</font></td><td><font size="-2">Fun&ccedil;&atilde;o: <?= utf8_decode($value->funcao); ?></font></td><td></td></tr>
            <tr><td width="50%"><font size="-2">Nome: <?= utf8_decode($value->nome); ?></font></td><td><font size="-2">Matr&iacute;cula: <?= utf8_decode($value->matricula); ?></font></td><td></td></tr>
        </table>
        <br>
        <table border="1">

            <thead>

                <tr bgcolor ="gray">
                    <th rowspan="2"><font size="-2">Data</font></th>
                    <th COLSPAN=2><font size="-2">Hor&aacute;rio Padrao</font></th>
                    <th COLSPAN=2><font size="-2">Hor&aacute;rio Extra</font></th>
                    <th COLSPAN=2><font size="-2">Hor&aacute;rio Extensao</font></th>
                    <th rowspan="2" width="38%"><font size="-2">Ocorrencia</font></th>
                </tr>
                <tr bgcolor ="gray">
                    <th ><font size="-2">entrada</font></th>
                    <th ><font size="-2">saida</font></th>
                    <th ><font size="-2">entrada</font></th>
                    <th ><font size="-2">saida</font></th>
                    <th ><font size="-2">entrada</font></th>
                    <th ><font size="-2">saida</font></th>
                </tr>
            </thead>

            <tbody>
            <?
            }
            if ($value->matricula != $matricula && $matricula != '') {
                ?>
                <tr bgcolor ="gray">
                    <th ><font size="-2">&nbsp;</font></th>
                    <th ><font size="-2"><?= $horaentrada1; ?></font></th>
                    <th ><font size="-2"><?= $horasaida1; ?></font></th>
                    <th ><font size="-2"><?= $horaentrada2; ?></font></th>
                    <th ><font size="-2"><?= $horasaida2; ?></font></th>
                    <th ><font size="-2"><?= $horaentrada3; ?>;</font></th>
                    <th ><font size="-2"><?= $horasaida3; ?></f
                    <th class="tabela_header" width="35%"><font size="-2">&nbsp;</font></th>
                </tr>

        </table>
        <table>
            <tr><td width="70%"><font size="-2">Reconhe&ccedil;o a exati&atilde;o das informa&ccedil;&otilde;es</font></td><td></td><td></td></tr>
            <tr><td width="70%"><font size="-2"></font></td><td><font size="-2"></font></td><td></td></tr>
            <tr><td ><font size="-2">_______________________________________</font></td><td valign="top"><font size="-2">_______________________________________</font></td><td></td></tr>
            <tr><td ><font size="-2">Assinatura do Chefe Imediato</font></td><td valign="top"><font size="-2">Assinatura do Funcion&aacute;rio</font></td><td></td></tr>
        </table>
        <br style="page-break-before: always;" />  


<!--<a><img src="<?= base_url() ?>img/logohdebo.gif" width="150" height="65" alt="teste"></a>-->
<br>
<table>
    <tr><td width="85%"><font size="-2">Empresa:HOSP DIST MARIA JOSE B. DE OLIVEIRA - FROTINHA DA PARANGABA</font></td><td><font size="-2">Cart&atilde;o de Ponto</font></td><td></td></tr>
    <tr><td width="80%"><font size="-2">CNPJ:07.206.048/0002-80</font></td><td></td><td></td></tr>
</table>
        <table>
            <tr><td width="50%"><font size="-2">Atividade: Hospitalar</font></td><td><font size="-2">Setor: <?= utf8_decode($value->setor); ?></font></td><td></td></tr>
            <tr><td width="50%"><font size="-2">Endere&ccedil;o:Av Jornalista Tomas Coelho, 1578</font></td><td><font size="-2">Fun&ccedil;&atilde;o: <?= utf8_decode($value->funcao); ?></font></td><td></td></tr>
            <tr><td width="50%"><font size="-2">Nome: <?= utf8_decode($value->nome); ?></font></td><td><font size="-2">Matr&iacute;cula: <?= utf8_decode($value->matricula); ?></font></td><td></td></tr>
        </table>
        <br>
        <table border="1">

            <thead>

                <tr bgcolor ="gray">
                    <th rowspan="2"><font size="-2">Data</font></th>
                    <th COLSPAN=2><font size="-2">Hor&aacute;rio Padrao</font></th>
                    <th COLSPAN=2><font size="-2">Hor&aacute;rio Extra</font></th>
                    <th COLSPAN=2><font size="-2">Hor&aacute;rio Extensao</font></th>
                    <th rowspan="2" width="38%"><font size="-2">Ocorrencia</font></th>
                </tr>
                <tr bgcolor ="gray">
                    <th ><font size="-2">entrada</font></th>
                    <th ><font size="-2">saida</font></th>
                    <th ><font size="-2">entrada</font></th>
                    <th ><font size="-2">saida</font></th>
                    <th ><font size="-2">entrada</font></th>
                    <th ><font size="-2">saida</font></th>
                </tr>
            </thead>

            <tbody>

                <?
            }
            ?>

            <tr>
                <td ><font size="-2"><? $ano = substr($value->data, 0, 4); ?>
            <? $mes = substr($value->data, 5, 2); ?>
            <? $dia = substr($value->data, 8, 2); ?>
            <? $datafinal = $dia . '/' . $mes . '/' . $ano; ?>
    <?= $datafinal ?></font></a></td>
                <td ><font size="-2"><?= $value->entrada1; ?></font></td>
                <td ><font size="-2"><?= $value->saida1; ?></font></td>
                <td ><font size="-2"><?= $value->entrada2; ?></font></td>
                <td ><font size="-2"><?= $value->saida2; ?></font></td>
                <td ><font size="-2"><?= $value->entrada3; ?></font></td>
                <td ><font size="-2"><?= $value->saida3; ?></font>
                <td width="35%">
                    <font size="-2"><?= utf8_decode($value->critica1); ?></font></td>
            </tr>
    <?
    $matricula = $value->matricula;


endforeach;
?>


        <tr bgcolor ="gray">
            <th ><font size="-2">&nbsp;</font></th>
                    <th ><font size="-2"><?= $horaentrada1; ?></font></th>
                    <th ><font size="-2"><?= $horasaida1; ?></font></th>
                    <th ><font size="-2"><?= $horaentrada2; ?></font></th>
                    <th ><font size="-2"><?= $horasaida2; ?></font></th>
                    <th ><font size="-2"><?= $horaentrada3; ?>;</font></th>
                    <th ><font size="-2"><?= $horasaida3; ?></f
            <th class="tabela_header" width="35%"><font size="-2">&nbsp;</font></th>
        </tr>

</table>
<table>
    <tr><td width="70%"><font size="-2">Reconhe&ccedil;o a exati&atilde;o das informa&ccedil;&otilde;es</font></td><td></td><td></td></tr>
    <tr><td width="70%"><font size="-2"></font></td><td><font size="-2"></font></td><td></td></tr>
    <tr><td ><font size="-2">_______________________________________</font></td><td valign="top"><font size="-2">_______________________________________</font></td><td></td></tr>
    <tr><td ><font size="-2">Assinatura do Chefe Imediato</font></td><td valign="top"><font size="-2">Assinatura do Funcion&aacute;rio</font></td><td></td></tr>
</table>
<br style="page-break-before: always;" />  