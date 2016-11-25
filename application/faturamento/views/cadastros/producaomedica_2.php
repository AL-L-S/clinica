<?php
//                            echo "<pre>";
//                            var_dump($producao);
//                            echo "</pre>";
//                            die;
?>
<a><img src="<?= base_url() ?>img/logoijf.gif" width="200" height="20" alt="teste"></a>
<br>
<br>
<table border="1">

    <thead>




        <tr>
            <th class="tabela_header" colspan="2"></th></tr>

        <tr>
            <th class="tabela_header"><font size="-1">Procedimento</font></th>
            <th class="tabela_header"><font size="-1">Procedimento Ant</font></th>
            <th class="tabela_header"><font size="-1">CPF</font></th>
            <th class="tabela_header"><font size="-1">CRM</font></th>
            <th class="tabela_header"><font size="-1">Nome</font></th>
            <th class="tabela_header"><font size="-1">Competencia</font></th>
            <th class="tabela_header"><font size="-1">Quantidade</font></th>

        </tr>
    </thead>
    <?
    $cpfimpresso = 0;
    $procedimentoimpresso = 0;
    $estilo_linha = "tabela_content01";
    foreach ($lista as $item) {
        $quantidade_procedimento = 0;
        foreach ($lista as $value) {
            if ($item->procedimento == $value->procedimento) {
                if ($item->cpf == $value->cpf) {
                    $procedimento = $item->procedimento;
                    $cpf = $item->cpf;
                    $quantidade_procedimento++;
                }
            }
        }
        if ($item->cpf == $cpf && $item->cpf != $cpfimpresso) {
            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
    ?>
            <tr>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $procedimento; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1">&ensp;&ensp;&ensp;</font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $item->cpf; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1">&ensp;<?= $item->crm; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $item->nome; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $item->competencia; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $quantidade_procedimento; ?></font></td>
            </tr>
<?
            $cpfimpresso = $item->cpf;
        }
    }
?>

</table>
<br>
