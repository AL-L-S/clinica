
<a><img src="<?= base_url() ?>img/logoijf.gif" width="200" height="20" alt="teste"></a>
<br>
<br>
<a>RELA&Ccedil;&Atilde;O DOS PACIENTES DA EMERG&Ecirc;NCIA</a><br>
<a>DATA:&ensp;<?=substr($data, 4, 2) . "/" . substr($data, 6, 2) . "/" . substr($data, 0, 4)?>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;CHEFE DE EQUIPE: ____________________________________</a>
<br>
<br>
<?$unidade = $paciente["0"]["C14NOMEC"] ?>
<table border="1">

    <thead>
        <tr bgcolor ="gray"><th colspan="11" align="center"><?= $unidade ?></th></tr>
        <tr bgcolor ="gray">
            <th class="tabela_header"><font size="-1">N&deg;</font></th>
            <th class="tabela_header"><font size="-1">Leito</font></th>
            <th class="tabela_header"><font size="-1">Protuario</font></th>
            <th class="tabela_header"><font size="-1">Paciente</font></th>
            <th class="tabela_header"><font size="-1">Tempo</font></th>
            <th class="tabela_header"><font size="-1">Data entrada</font></th>
            <th class="tabela_header"><font size="-1">ID</font></th>
            <th class="tabela_header"><font size="-1">Origem</font></th>
            <th class="tabela_header"><font size="-1">Procedimento</font></th>
            <th class="tabela_header"><font size="-1">Procedimento decricao</font></th>
            <th class="tabela_header" width="400px;"><font size="-1">Status</font></th>
        </tr>
    </thead>

    <tbody>
        <?
        $total_leitos = 0;
        $linhas = 1;
        $capital = 0;
        $capital2 = 0;
        $leitos_ocupados = 0;
        $somatempo = 0;
        foreach ($leitos as $value) :
            $total_leitos++;
            foreach ($paciente as $item) :
                if ($value['C10CODLEITO'] == $item['C02CODLEITO']) {
                    $leitos_ocupados++;
                    $leito = $item['C02CODLEITO'];
                    $prontuario = $item['IB6REGIST'];
                    $nome = $item['IB6NOME'];
                    $nascimento = $item['IB6DTNASC'];
                    $data_internacao = $item['D02INTER'];
                    $municipio = $item['ID4DESCRICAO'];
                    $procedimento = $item['C02PROCSOL'];
                    $capital2++;
                    if ('FORTALEZA' == trim($municipio)) {
                        $capital++;
                    }
                    break;
                } else {
                    $leito = null;
                }

            endforeach;

            if ($leito != null) {
                //calcular idade
                $ano_atual = substr($data, 0, 4);
                $mes_atual = substr($data, 6, 2);
                $dia_atual = substr($data, 4, 2);
                $nascimento_ano = substr($nascimento, 0, 4);
                $nascimento_mes = substr($nascimento, 4, 2);
                $nascimento_dia = substr($nascimento, 6, 2);
                $internacao_ano = substr($data_internacao, 1, 4);
                $internacao_mes = substr($data_internacao, 5, 2);
                $internacao_dia = substr($data_internacao, 7, 2);

                $idade = $ano_atual - $nascimento_ano;
                if ($mes_atual < $nascimento_mes) {
                    $idade = $idade - 1;
                } elseif ($mes_atual == $nascimento_mes && $nascimento_dia > $dia_atual) {
                    $idade = $idade - 1;
                }
                if ($idade == -1) {
                    $idade = 0;
                }
                $tempo = ($ano_atual - $internacao_ano) ;
                $tempo = $tempo + ($mes_atual - $internacao_mes);
                $tempo = $tempo * 30;
                $tempo = $tempo + ($dia_atual - $internacao_dia);


                foreach ($procedimentos as $itens) :

                    if ($procedimento == $itens->procedimento) {

                        $procedimentodescricao = $itens->descricao_resumida;
                        break;
                    }
                endforeach;
                $status = null;
                foreach ($procedimentopaciente as $itens) :

                    if ($prontuario == $itens->prontuario && $procedimento == $itens->procedimento) {

                        $procedimentodescricao = $itens->descricao_resumida;
                        $status = $itens->status;
                        break;
                    }
                endforeach;
        ?>

        <?
        if($tempo<5){
        $cor = 'green';
        }else if ($tempo <20){
            $cor = 'orange';
        }else {
                $cor = 'red';}?>
                <tr>
                    <td ><font size="-1" color="<?=$cor?>"><?= $linhas; ?></font></td>
                    <td ><font size="-1" color="<?=$cor?>"><?= $leito; ?></font></td>
                    <td ><font size="-1" color="<?=$cor?>"><?= $prontuario; ?></font></td>
                    <td ><font size="-1" color="<?=$cor?>"><?= $nome; ?></font></td>
                    <td ><font size="-1" color="<?=$cor?>"><?= $tempo; ?></font></td>
                    <td ><font size="-1" color="<?=$cor?>"><? $ano = substr($data_internacao, 1, 4); ?>
                    <? $mes = substr($data_internacao, 5, 2); ?>
                    <? $dia = substr($data_internacao, 7, 2); ?>
                    <? $datafinal = $dia . '/' . $mes . '/' . $ano; ?>
                    <?= $datafinal ?>
                </font></td>
            <td ><font size="-1" color="<?=$cor?>"><?= $idade; ?></font></td>
            <td ><font size="-1" color="<?=$cor?>"><?= $municipio; ?></font></td>
            <td ><font size="-1" color="<?=$cor?>"><?= $procedimento; ?></font></td>
            <td ><font size="-1" color="<?=$cor?>"><?= $procedimentodescricao; ?></font></td>
            <td ><font size="-1" color="<?=$cor?>"><?= $status; ?><a href="<?= base_url() ?>cadastros/pacientes/carregarpacientecensostatus/<?= $prontuario ?>/<?= $nome ?>/<?= $procedimento ?>/<?= $procedimentodescricao ?>/<?= $unidade ?>">
                        <img border="0" title="Alterar registro" alt="Detalhes"
                             src="<?= base_url() ?>img/form/page_white_edit.png" />
                    </a></font></td>
        </tr>
       <? $linhas++;
          $somatempo = $somatempo + $tempo;?>


        <? } 

            endforeach;
        ?>

    </table>
    <br>
<?
            $percentual_ocupado = (($leitos_ocupados / $total_leitos) * 100);
            $percentual_livre = ((($total_leitos - $leitos_ocupados) / $total_leitos) * 100);
            $percentual_capital = (($capital / $capital2) * 100);
            $percentual_interior = ((($capital2 - $capital) / $capital2) * 100);
?>
            <table border="1">
                <tr><th colspan="3">Resumo da clinica</th></tr>
                <tr><td ><font size="-1">Total de leitos da clinica </font></td><td><font size="-1"><?= $total_leitos; ?></font></td><td><font size="-1">100%</font></td></tr>
                <tr><td ><font size="-1">Leitos ocupados </font></td><td><font size="-1"><?= $leitos_ocupados; ?></font></td><td><font size="-1"><?= substr($percentual_ocupado, 0, 3); ?>%</font></td></tr>
                <tr><td ><font size="-1">Leitos vagos </font></td><td><font size="-1"><?= ($total_leitos - $leitos_ocupados); ?></font></td><td><font size="-1"><?= substr($percentual_livre, 0, 3); ?>%</font></td></tr>
                <tr><td ><font size="-1">Capital </font></td><td><font size="-1"><?= $capital; ?></font></td><td><font size="-1"><?= substr($percentual_capital, 0, 3); ?>%</font></td></tr>
                <tr><td ><font size="-1">Interior </font></td><td><font size="-1"><?= ($capital2 - $capital); ?></font></td><td><font size="-1"><?= substr($percentual_interior, 0, 3); ?>%</font></td></tr>
                <tr><td ><font size="-1">Perman&ecirc;encia </font></td><td colspan="2"><font size="-1"><?= ($somatempo / $linhas); ?></font></td></tr>



</table>