<div class="content"> <!-- Inicio da DIV content -->

    <? if (count($empresa) > 0) { ?>
        <h3><?= $empresa[0]->razao_social; ?></h3>
    <? } ?>
    <? if ($grupo == "0") { ?>
        <h3>GRUPO: TODOS</h3>
    <? } elseif ($grupo == "1") { ?>        
        <h3>GRUPO: SEM RM</h3>
    <? } else { ?>             
        <h3>GRUPO: <?= $grupo; ?></h3>
    <? } ?>

    <? if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_teste" >Codigo</th>
                    <th class="tabela_teste">Nome</th>
                    <th class="tabela_teste" >Descricao</th>
                    <th class="tabela_teste" >Grupo</th>
                    <th class="tabela_teste" >Perc. Medico</th>
                    <th class="tabela_teste" >Qtde</th>
                    <th class="tabela_teste" >Dencidade Calorica</th>
                    <th class="tabela_teste" >Proteina</th>
                    <th class="tabela_teste" >Carboidratos</th>
                    <th class="tabela_teste" >Lipidios</th>
                    <th class="tabela_teste" >Kcal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($relatorio as $item) :
                    ?>
                    <tr>
                        <td><?= $item->codigo; ?></td>
                        <td><?= $item->nome; ?></td>
                        <td><?= utf8_decode($item->descricao); ?></td>
                        <td><?= $item->grupo; ?></td>
                        <td><?= $item->perc_medico; ?></td>
                        <td><?= $item->qtde; ?></td>
                        <td><?= $item->dencidade_calorica; ?></td>
                        <td><?= $item->proteinas; ?></td>
                        <td><?= $item->carboidratos; ?></td>
                        <td><?= $item->lipidios; ?></td>
                        <td><?= $item->kcal; ?></td>

                    </tr>


                <? endforeach; ?>
            </tbody>
        </table>   
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>