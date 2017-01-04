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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RELATORIO CONSULTA CONVENIO</th>
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
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $relatorio[0]->grupo; ?></th>
                </tr>
            <? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></th>
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











    <? if ($contador > 0) {
        ?>

        <table>
            <thead>
                <tr>
                    <td class="tabela_teste">Emissao</th>
                    <td class="tabela_teste">Convenio</th>
                    <td class="tabela_teste">Paciente</th>
                    <td class="tabela_teste">QTDE</th>
                    <td class="tabela_teste">Procedimento</th>
                    <td class="tabela_teste">Status</th>
                    <td class="tabela_teste">Revisor</th>
                    <td class="tabela_teste" width="80px;">Autoriza&ccedil;&atilde;o</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php
                $i = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $convenio = "";
                $paciente = "";
                foreach ($relatorio as $item) :
                    $i++;
                    if ($i == 1 || $item->convenio == $convenio) {
                        $qtde++;
                        $qtdetotal++;

                        if ($i == 1) {
                            ?>
                            <tr>
                                <td colspan="8"><font ><b>Convenio:&nbsp;<?= utf8_decode($item->convenio); ?></b></td>
                            </tr>
                        <? } ?>
                        <tr>
                            <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td>&nbsp;</td>
                            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                            <? } else { ?>
                                <td><?= $item->paciente; ?></td>
                            <? } ?>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                            <td><font size="-2"><?= $item->situacaolaudo; ?></td>
                            <td><font size="-2"><?= substr($item->revisor, 0, 20); ?></td>
                            <td><font size="-2"><?= $item->autorizacao; ?></td>
                        </tr>


                        <?php
                        $paciente = $item->paciente;
                        $convenio = $item->convenio;
                    } else {
                        $convenio = $item->convenio;
                        ?>

                        <tr>
                            <td width="140px;" align="Right" colspan="9"><b>Nr. Exa:&nbsp; <?= $qtde; ?></b></td>
                        </tr>
                        <?
                        $paciente = "";
                        $qtde = 0;
                        $qtde++;
                        $qtdetotal++;
                        ?>
                        <tr>
                            <td colspan="8"><font ><b>Convenio:&nbsp;<?= utf8_decode($item->convenio); ?></b></td>
                        </tr>
                        <tr>
                            <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td>&nbsp;</td>                        
                            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                            <? } else { ?>
                                <td><?= $item->paciente; ?></td>
                            <? } ?>
                            <td><font size="-2"><?= $item->quantidade; ?></td>
                            <td><font size="-2"><?= $item->procedimento; ?></td>
                            <td><font size="-2"><?= $item->situacaolaudo; ?></td>
                            <td><font size="-2"><?= substr($item->revisor, 0, 20); ?></td>
                            <td><font size="-2"><?= $item->autorizacao; ?></td>
                        </tr>
                        <?
                        $paciente = $item->paciente;
                    }
                endforeach;
                ?>

                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Exa:&nbsp; <?= $qtde; ?></b></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
                <tr>
                    <td width="140px;" align="Right" ><b>TOTAL GERAL</b></td>
                    <td width="140px;" align="center" ><b>Nr. Exa: &nbsp;<?= $qtdetotal; ?></b></td>
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



    $(function() {
        $("#accordion").accordion();
    });

</script>