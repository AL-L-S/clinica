<div class="content"> <!-- Inicio da DIV content -->
    <? $tipoempresa = ""; ?>
    <table>
        <thead>

            <? if (count($empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
                <?
                $tipoempresa = $empresa[0]->razao_social;
            } else {
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
                <?
                $tipoempresa = 'TODAS';
            }
            ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RELATORIO NOTAS</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>

            <? IF ($armazem > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ARMAZEM: <?= $armazem[0]->descricao; ?></th>
                </tr>
            <? } ELSE { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ARMAZEM: TODOS</th>
                </tr>
            <? } ?>


            <? IF ($nota > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">NOTA: <?= $nota[0]->nota_fiscal; ?></th>
                </tr>
            <? } ELSE { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">NOTA: TODAS</th>
                </tr>
            <? } ?>
            <? IF ($fornecedor > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">FORNECEDOR: <?= $fornecedor[0]->fantasia; ?></th>
                </tr>
            <? } ELSE { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">FORNECEDOR: TODOS</th>
                </tr>
            <? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">DATA DE EMISSAO DO RELATORIO: <?= date("d/m/Y"); ?></th>
            </tr>
        </thead>
    </table>

    <? if ($relatorio > 0) {
        ?>

        <table width="100%">
            <thead>
                <tr>       
                    <th class="tabela_teste"><font size="-2">DATA DA ENTRADA</th>
                    <th class="tabela_teste"><font size="-2">NOTA</th>
                    <th class="tabela_teste"><font size="-2">FORNECEDOR</th>
                    <th class="tabela_teste"><font size="-2">VALOR DA NOTA</th>
                    <th class="tabela_teste"><font size="-2">STATUS</th>                    
                    <th class="tabela_teste"><font size="-2">OPERADOR</th>                    
                    <th class="tabela_teste"><font size="-2">ARMAZEM</th>                    
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $i = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $armazem = "";
                $paciente = "";
                foreach ($relatorio as $item) :
                    $i++;
                    if ($i == 1 || $item->armazem == $armazem) {
                        $qtde++;
                        $qtdetotal++;

                            ?>
                       <? // var_dump($item);die;?>
                        <tr>
                            <td style='text-align: center;'><font size="-2"><?= date("d-m-Y", strtotime($item->data_cadastro)); ?></td>
                            <td style='text-align: center;'><font size="-2"><?= $item->nota_fiscal; ?></td>
                            <td style='text-align: center;'><font size="-2"><?= $item->fantasia; ?></td>
                            <td style='text-align: center;'><font size="-2"><?= $item->valor_nota; ?></td>
                            <?if($item->ativo == 'f'){?>
                            <td style='text-align: center;'><font size="-2">PAGO</td>
                            <?}else{?>
                            <td style='text-align: center;'><font size="-2">PENDENTE</td>
                            <? } ?>
                            <td style='text-align: center;'><font size="-2"><?= $item->nome; ?></td>
                            <td style='text-align: center;'><font size="-2"><?= $item->armazem; ?></td>
                        </tr>


                        <?php
                        $armazem = $item->armazem;
                    } else {
                        $armazem = $item->armazem;
                        ?>

<!--                        <tr>
                            <td width="140px;" align="Right" colspan="9"><b>Nr. Itens:&nbsp; <?= $qtde; ?></b></td>
                        </tr>-->
                        <?
                        $qtde = 0;
                        $qtde++;
                        $qtdetotal++;
                        ?>
                        <tr>
                            <td colspan="8"><font size="-2"><b>Armazem:&nbsp;<?= utf8_decode($item->armazem); ?></b></td>
                        </tr>
                        <tr>
                            <td style='text-align: right;'><font size="-2"><?= $item->quantidade; ?></td>
                            <!--<td><font size="-2"><?= utf8_decode($item->fantasia); ?></td>-->
                            <td><font size="-2"><?= utf8_decode($item->produto); ?></td>
                        </tr>
                        <?
                    }
                endforeach;
                ?>

<!--                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Itens:&nbsp; <?= $qtde; ?></b></td>
                </tr>-->
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
                <tr>
                    <td width="140px;" align="Right" ><b>TOTAL GERAL</b></td>
                    <td width="140px;" align="center" ><b>Nr. Itens: &nbsp;<?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>

        </table>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>