<html>
    <meta http-equiv="Content-Type" content="text/xhtml; charset=UTF-8" />
    <h3><center>PROVENTOS</center></h3>
    <table id ="alter" border="1" >
        <thead>
            <tr>
            <tr bgcolor ="gray">
                <th>Matr&iacute;cula</th>
                <th>Nome</th>
                <th>Classifica&ccedil;&atilde;o</th>
                <th>Valor</th>
                <th>Incentivo</th>
                <th>INSS</th>
                <th>IR</th>
                <th>Pens&atilde;o</th>
                <th>VlrLIQ</th>
            </tr>
            <?php
            $i = 0;
            $grupo = '';
            $sub_soma = 0;
            $sub_valor = 0;
            $sub_incentivo = 0;
            $sub_inss = 0;
            $sub_ir = 0;
            $sub_pensao = 0;
            $sub_liq = 0;
            $total_bruto = 0;
            $total_liquido = 0;
            $total_valor = 0;
            $total_incentivos = 0;
            $total_incentivo = 0;
            $total_inss = 0;
            $total_ir = 0;
            $total_pensao = 0;
            foreach ($lista as $item) {
                $i++;
                $total_incentivos = $total_incentivos + $item->incentivovalor;
                if ($grupo == $item->nomeclassificacao || $grupo == '') {
                    $valorliq = ($item->valor + $item->incentivovalor) - ($item->pensao + $item->inss + $item->ir);
                    $soma = $sub_soma + $item->valor - ($item->pensao + $item->inss + $item->ir);
                    $sub_valor = $sub_valor + $item->valor;
                    $sub_incentivo = $sub_incentivo + $item->incentivovalor;
                    $sub_inss = $sub_inss + $item->inss;
                    $sub_ir = $sub_ir + $item->ir;
                    $sub_pensao = $sub_pensao + $item->pensao;
                    $sub_liq = $sub_liq + $valorliq;
            ?>
                    <tr>
                        <td><?php echo $item->matricula; ?></td>
                        <td><?php echo $item->nome; ?></td>
                        <td><?php echo $item->nomeclassificacao; ?></td>
                        <td>R$<?php echo number_format($item->valor, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($item->incentivovalor, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($item->inss, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($item->ir, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($item->pensao, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($valorliq, 2, ",", "."); ?></td>
                    </tr>
            <?php } else {
            ?>
                    <tr bgcolor ="gray">
                        <td class ="body1" colspan="3" ><?php echo "sub-total"; ?></td>
                        <td>R$<?php echo number_format($sub_valor, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($sub_incentivo, 2, ",", "."); ?>                                                         </td>
                        <td>R$<?php echo number_format($sub_inss, 2, ",", "."); ?>
                        <td>R$<?php echo number_format($sub_ir, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($sub_pensao, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($sub_liq, 2, ",", "."); ?></td>
                    </tr>
            <?
                    $valorliq = ($item->valor + $item->incentivovalor) - ($item->pensao + $item->inss + $item->ir);
                    $soma = $sub_soma + $item->valor - ($item->pensao + $item->inss + $item->ir);
                    $sub_valor = $sub_valor + $item->valor;
                    $sub_incentivo = $sub_incentivo + $item->incentivovalor;
                    $sub_inss = $sub_inss + $item->inss;
                    $sub_ir = $sub_ir + $item->ir;
                    $sub_pensao = $sub_pensao + $item->pensao;
                    $sub_liq = $sub_liq + $valorliq;
            ?>
                    <tr>
                        <td><?php echo $item->matricula; ?></td>
                        <td><?php echo $item->nome; ?></td>
                        <td><?php echo $item->nomeclassificacao; ?></td>
                        <td>R$<?php echo number_format($item->valor, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($item->incentivovalor, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($item->inss, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($item->ir, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($item->pensao, 2, ",", "."); ?></td>
                        <td>R$<?php echo number_format($valorliq, 2, ",", "."); ?></td>
                    </tr>
            <?php
                    $total_bruto = $total_bruto + $sub_valor + $sub_incentivo + $sub_inss + $sub_ir;
                    $total_valor = $total_valor + $sub_valor;
                    $total_incentivo = $total_incentivo + $sub_incentivo;
                    $total_inss = $total_inss + $sub_inss;
                    $total_ir = $total_ir + $sub_ir;
                    $total_pensao = $total_pensao + $sub_pensao;
                    $total_liquido = $total_liquido + $sub_liq;
                    $sub_soma = 0;
                    $sub_valor = 0;
                    $sub_incentivo = 0;
                    $sub_inss = 0;
                    $sub_ir = 0;
                    $sub_pensao = 0;
                    $sub_liq = 0;
                }
                $grupo = $item->nomeclassificacao;
            }
            $total_bruto = $total_bruto + $sub_valor + $sub_incentivo + $sub_inss + $sub_ir;
            $total_valor = $total_valor + $sub_valor;
            $total_incentivo = $total_incentivo + $sub_incentivo;
            $total_inss = $total_inss + $sub_inss;
            $total_ir = $total_ir + $sub_ir;
            $total_pensao = $total_pensao + $sub_pensao;
            $total_liquido = $total_liquido + $sub_liq;
            ?>
            <tr bgcolor ="gray">
                <td class ="body1" colspan="3"><?php echo "sub-total"; ?></td>
                <td>R$<?php echo number_format($sub_valor, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($sub_incentivo, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($sub_inss, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($sub_ir, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($sub_pensao, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($sub_liq, 2, ",", "."); ?></td>
            </tr>
            <tr bgcolor ="gray">
                <td colspan="3"><?php echo "TOTAL"; ?></td>
                <td>R$<?php echo number_format($total_valor, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($total_incentivo, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($total_inss, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($total_ir, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($total_pensao, 2, ",", "."); ?></td>
                <td>R$<?php echo number_format($total_liquido, 2, ",", "."); ?></td>
            <tr bgcolor ="gray">
                <td colspan="8"><?php echo "VALOR  ARQUIVO SAM - SOMA DOS BRUTOS"; ?></td>
                <td>R$<?php echo number_format($total_bruto, 2, ",", "."); ?></td></tr>
            <tr bgcolor ="gray">
                <td colspan="8"><?php echo "VALOR  GERAL  DO  DEB473A1.REM - SOMA DOS LIQUIDOS"; ?></td>
                <td>R$<?php echo number_format($total_liquido, 2, ",", "."); ?></td></tr>

    </table>