<a><img src="<?= base_url() ?>img/logoijf.gif" width="200" height="20" alt="teste"></a>
<br>
<br>
<table border="1">

    <thead>




        <tr>
            <th class="tabela_header" colspan="2"></th></tr>

        <tr>
            <th class="tabela_header"><font size="-1">Procedimento</font></th>
            <th class="tabela_header"><font size="-1">CPF</font></th>
            <th class="tabela_header"><font size="-1">CRM</font></th>
            <th class="tabela_header"><font size="-1">Nome</font></th>
            <th class="tabela_header"><font size="-1">Competencia</font></th>
            <th class="tabela_header"><font size="-1">Quantidade</font></th>
            <th class="tabela_header"><font size="-1">Pontos</font></th>

        </tr>
    </thead>
    <?
    $procedimentoimpresso = 0;
    $estilo_linha = "tabela_content01";
    foreach ($lista as $item) {
        $quantidade_procedimento = 0;
        foreach ($lista as $value) {
            if ($item->cpf == $value->cpf) {
                if ($item->procedimento == $value->procedimento) {
                    $procedimento = $item->procedimento;
                    $cpf = $item->cpf;
                    $quantidade_procedimento++;
                }
            }
        }
        if ($item->procedimento == $procedimento && $item->procedimento != $procedimentoimpresso) {
            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
            $pontos = 0;
         foreach ($ponto as $valor) {
             $procedimentomodificado = substr($valor->codigo, 1,10);
                if ($procedimento == $procedimentomodificado) {
                    $pontos = $quantidade_procedimento * $valor->pontos;
                }
        }
    ?>
            <tr>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $procedimento; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $item->cpf; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $item->crm; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $item->nome; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $item->competencia; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $quantidade_procedimento; ?></font></td>
                <td class="<?php echo $estilo_linha; ?>"><font size="-1"><?= $pontos; ?></font></td>
            </tr>
<?
            $procedimentoimpresso = $item->procedimento;
        }
    }
?>

</table>
<br>
