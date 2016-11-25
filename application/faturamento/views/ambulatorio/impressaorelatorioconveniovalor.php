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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONFERENCIA DOS CONVENIOS</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>

            <? if ($convenio == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO:TODOS OS CONVENIOS</th>
                </tr>
            <? } elseif ($convenio == "-1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO:PARTICULARES</th>
                </tr>
            <? } elseif ($convenio == "") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: CONVENIOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= $convenios[0]->nome; ?></th>
                </tr>
            <? } ?>
            <? if ($grupo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                </tr>
            <?
            } else {
                if (isset($relatorio[0]->grupo)) {
                    $nome_grupo = $relatorio[0]->grupo;
                } else {
                    $nome_grupo = $grupo;
                }
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $nome_grupo; ?></th>
                </tr>
<? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></th>
            </tr>
<? IF (COUNT($medico) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: <?= $medico[0]->nome; ?></th>
                </tr>
<? } ELSE { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">MEDICO: TODOS</th>
                </tr>
<? } ?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>

        </thead>
    </table>

    <?
    $qtdetotal = 0;
    $valortotal = 0;
    ?>
    <table border="1">
        <tr>
            <th colspan="3" >EXAMES ATENDIDOS</th>
        </tr>
        <tr>
            <th width="100px;">DATA</th>
            <th width="400px;">DESCRI&Ccedil;&Atilde;O</th>
            <th width="200px;">VALOR</th>
        </tr>
        <?
        foreach ($atendidos as $itens) :
            $qtdetotal = $qtdetotal + 1;
            $valortotal = $valortotal + $itens->valortotal;
            ?>
            <tr>
                <td><?= ($itens->data); ?></td>
                <td><?= utf8_decode($itens->nome); ?></td>
                <td style='text-align: right;'><?= $itens->valortotal; ?></td>
            </tr>
            <?
        endforeach;
        if (isset($atendidosdatafim) && count($atendidosdatafim) > 0) {
            foreach ($atendidosdatafim as $itens) :
                $qtdetotal = $qtdetotal + 1;
                ?>
                <tr>
                    <td><?= ($itens->data); ?></td>
                    <td><?= utf8_decode($itens->nome); ?></td>
                    <td style='text-align: right;'><?= $itens->valortotal; ?></td>
                </tr>
                <?
            endforeach;
        }
        ?>

    </table>
    <p>
    <table border="1">
        <tr>
            <th colspan="3" >EXAMES AGENDADOS</th>
        </tr>
        <tr>
            <th width="100px;">DATA</th>
            <th width="400px;">DESCRI&Ccedil;&Atilde;O</th>
            <th width="200px;">VALOR</th>
        </tr>
        <?
        foreach ($naoatendidos as $itens) :
            $qtdetotal = $qtdetotal + 1;
            $valortotal = $valortotal + $itens->valortotal;
            ?>
            <tr>
                <td><?= ($itens->data); ?></td>
                <td><?= utf8_decode($itens->nome); ?></td>
                <td style='text-align: right;'><?= $itens->valortotal; ?></td>
            </tr>
            <?
        endforeach;

        if (isset($naoatendidosdatafim) && count($naoatendidosdatafim) > 0) {
            foreach ($naoatendidosdatafim as $itens) :
                $qtdetotal = $qtdetotal + 1;
                $valortotal = $valortotal + $itens->valortotal;
                ?>
                <tr>
                    <td><?= ($itens->data); ?></td>
                    <td><?= utf8_decode($itens->nome); ?></td>
                    <td style='text-align: right;'><?= $itens->valortotal; ?></td>
                </tr>
                <?
            endforeach;
        }
        ?>

    </table>
    <p>
    <table border="1">
        <tr>
            <th colspan="3">CONSULTAS ATENDIDAS</th>
        </tr>
        <tr>
            <th width="100px;">DATA</th>
            <th width="400px;">DESCRI&Ccedil;&Atilde;O</th>
            <th width="200px;">VALOR</th>
        </tr>
        <?
        foreach ($consultasatendidos as $itens) :
            $qtdetotal = $qtdetotal + 1;
            $valortotal = $valortotal + $itens->valortotal;
            ?>
            <tr>
                <td><?= ($itens->data); ?></td>
                <td><?= utf8_decode($itens->nome); ?></td>
                <td style='text-align: right;'><?= $itens->valortotal; ?></td>
            </tr>
            <?
        endforeach;
        if (isset($consultasatendidosdatafim) && count($consultasatendidosdatafim) > 0) {
            foreach ($consultasatendidosdatafim as $itens) :
                $qtdetotal = $qtdetotal + 1;
                $valortotal = $valortotal + $itens->valortotal;
                ?>
                <tr>
                    <td><?= ($itens->data); ?></td>
                    <td><?= utf8_decode($itens->nome); ?></td>
                    <td style='text-align: right;'><?= $itens->valortotal; ?></td>
                </tr>
                <?
            endforeach;
        }
        ?>
    </table>
    <p>
    <table border="1">
        <tr>
            <th colspan="3" >CONSULTAS AGENDADAS</th>
        </tr>
        <tr>
            <th width="100px;">DATA</th>
            <th width="400px;">DESCRI&Ccedil;&Atilde;O</th>
            <th width="200px;">VALOR</th>
        </tr>
        <?
        foreach ($consultasnaoatendidos as $itens) :
            $qtdetotal = $qtdetotal + 1;
            $valortotal = $valortotal + $itens->valortotal;
            ?>
            <tr>
                <td><?= ($itens->data); ?></td>
                <td><?= utf8_decode($itens->nome); ?></td>
                <td style='text-align: right;'><?= $itens->valortotal; ?></td>
            </tr>
            <?
        endforeach;

        if (isset($consultasnaoatendidosdatafim) && count($consultasnaoatendidosdatafim) > 0) {
            foreach ($consultasnaoatendidosdatafim as $itens) :
                $qtdetotal = $qtdetotal + 1;
                $valortotal = $valortotal + $itens->valortotal;
                ?>
                <tr>
                    <td><?= ($itens->data); ?></td>
                    <td><?= utf8_decode($itens->nome); ?></td>
                    <td style='text-align: right;'><?= $itens->valortotal; ?></td>
                </tr>
                <?
            endforeach;
        }
        ?>

    </table>
    <P>
    <table border="1">
        <tr>
            <th width="400px;">QTDE TOTAL</th>
            <th width="200px;">VALOR TOTAL</th>
        </tr>
        <tr>
            <td><?= $qtdetotal; ?></td>
            <td><?= $valortotal; ?></td>
        </tr>
    </table>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>