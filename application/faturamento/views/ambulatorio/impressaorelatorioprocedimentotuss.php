<div class="content"> <!-- Inicio da DIV content -->

    <? if (count($empresa) > 0) { ?>
        <h3><center><?= $empresa[0]->razao_social; ?></center></h3>
    <? } ?>

    <? if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_teste" >Codigo</th>
                    <th class="tabela_teste">Descricao</th>
                    <th class="tabela_teste" >Valor</th>
                    <th class="tabela_teste" >Classificacao</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($relatorio as $item) :
                    ?>
                    <tr>
                        <td><?= $item->codigo; ?></td>
                        <td><?= utf8_decode($item->descricao); ?></td>
                        <td><?= number_format($item->valor, 2, ',', '.') ?></td>
                        <td><?= $item->classificacao; ?></td>

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



    $(function() {
        $("#accordion").accordion();
    });

</script>