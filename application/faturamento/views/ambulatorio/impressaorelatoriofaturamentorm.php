<div class="content"> <!-- Inicio da DIV content -->
    <h4>HUMANA IMAGEM</h4>
    <h4>Faturamento por Grupo</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <hr>
    <? if ($contador > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Grupo</th>
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
                $RM = 0;
                $NUMERORM = 0;
                foreach ($relatorio as $item) :
                    $i++;


                    if ($i == 1 || $item->convenio == $convenio) {
                        if ($i == 1) {
                            $y++;
                            ?>
                            <tr>
                                <td colspan="3" bgcolor="#C0C0C0"><font ><?= $item->convenio; ?></td>
                            </tr>
                        <? }
                        ?>
                        <tr>
                            <td><font size="-2"><?= $item->grupo; ?></td>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= number_format($item->valor, 2, ',', '.') ?></td>
                        </tr>
                        <?php
                        if ($item->grupo == "RM") {
                            $RM = $RM + $item->valor;
                            $NUMERORM = $NUMERORM + $item->quantidade;
                        }

                        $qtde = $qtde + $item->quantidade;
                        $qtdetotal = $qtdetotal + $item->quantidade;
                        $valor = $valor + $item->valor;
                        $valortotal = $valortotal + $item->valor;
                        $convenio = $item->convenio;
                    } else {
                        $convenio = $item->convenio;
                        ?>  
                        <tr>
                            <td ><font size="-1">TOTAL</td>
                            <td ><font size="-1">Nr. Exa: <?= $qtde; ?></td>
                            <td ><font size="-1">VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><td></td></tr>
                        <tr>
                            <td colspan="3" bgcolor="#C0C0C0"><font ><?= $item->convenio; ?></td>
                        </tr>
                        <tr>
                            <td><font size="-2"><?= $item->grupo; ?></td>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= number_format($item->valor, 2, ',', '.') ?></td>
                        </tr>


                        <?
                        if ($item->grupo == "RM") {
                            $RM = $RM + $item->valor;
                            $NUMERORM = $NUMERORM + $item->quantidade;
                        }

                        $qtde = 0;
                        $qtde = $qtde + $item->quantidade;
                        $qtdetotal = $qtdetotal + $item->quantidade;
                        $valor = 0;
                        $valor = $valor + $item->valor;
                        $valortotal = $valortotal + $item->valor;
                        $y = 0;
                    }
                endforeach;
                ?>
                <tr>
                    <td ><font size="-1">TOTAL</td>
                    <td ><font size="-1">Nr. Exa: <?= $qtde; ?></td>
                    <td width="200px;"><font size="-1">VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table BORDER="1">
            <tbody>
                <tr>
                    <td width="140px;" colspan="4" bgcolor="#C0C0C0"><center><font size="-1">Resumo da Clinica</center></td>
                </tr>

                <tr>
                    <td width="140px;"><font size="-1">RM</td>
                    <td width="140px;"><font size="-1"><?= $NUMERORM; ?></td>
                    <td><font size="-2"></td>
                    <td width="200px;"><font size="-1"><?= number_format($RM, 2, ',', '.'); ?></td>
                </tr>
            </tbody>

        </table>
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