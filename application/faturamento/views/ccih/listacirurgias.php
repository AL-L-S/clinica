<a><img src="<?= base_url() ?>img/logoijf.gif" width="200" height="20" alt="teste"></a>
<br>
<br>
<h3><center>Consolidado Procedimento \ Classifica&ccedil;&atilde;o</center></h3>
<h4>Classica&ccedil;&atilde;o: <?= $tipo; ?></h4>
<h4>Competencia: <?= $competencia ?></h4>
<table border="1">

    <thead>




        <tr>
            <th class="tabela_header" colspan="2"></th></tr>

        <tr>
            <th class="tabela_header"><font size="-1">Descricao</font></th>
            <th class="tabela_header"><font size="-1">Procedimento</font></th>
            <th class="tabela_header"><font size="-1">Quant.</font></th>
        </tr>
    </thead>
    <?
    $total = 0;
    $procedimentoimpresso = 0;
    $estilo_linha = "tabela_content01";
    foreach ($lista as $item) {
        $quantidade_procedimento = 0;
        foreach ($lista as $value) {
            if ($item->procedimento == $value->procedimento) {
                $quantidade_procedimento++;
            }
        }
        if ($item->procedimento != $procedimentoimpresso) {
            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
            $pontos = 0;
    ?>
            <tr>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $item->descricao; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $item->procedimento; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $quantidade_procedimento; ?></font></td>
            </tr>
<?
            $procedimentoimpresso = $item->procedimento;
            $total = $total + $quantidade_procedimento;
        }
    }
?>
    <tr>
        <td colspan="2" class="<?php echo $estilo_linha; ?>"><font size="-1">TOTAL</font></td>
        <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $total; ?></font></td>
    </tr>

</table>
<br>
