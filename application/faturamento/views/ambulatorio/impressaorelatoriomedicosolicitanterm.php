<div class="content"> <!-- Inicio da DIV content -->
    <h4>HUMANA IMAGEM</h4>
    <h4>Medico Solicitante</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <hr>
    <? if ($contador > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Medico</th>
                    <th class="tabela_header"><font size="-1">Quantidade</th>
                    <th class="tabela_header" width="80px;"><font size="-1">V. Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $y = 0;
                $qtde = 0;
                $qtdetotal = 0;
                foreach ($relatorio as $item) :
                    $i++;


                        ?>
                        <tr>
                            <td><font size="-2"><?= $item->medico; ?></td>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= number_format($item->valor, 2, ',', '.') ?></td>
                        </tr>


                        <?php
                        $qtdetotal = $qtdetotal + $item->quantidade;
                        $valortotal = $valortotal + $item->valor;
                endforeach;
                ?>
                <tr>
                    <td ><font size="-1">TOTAL</td>
                    <td ><font size="-1">Nr. Exa: <?= $qtdetotal; ?></td>
                    <td width="200px;"><font size="-1">VALOR TOTAL: <?= number_format($valortotal, 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $( "#accordion" ).accordion();
    });

</script>