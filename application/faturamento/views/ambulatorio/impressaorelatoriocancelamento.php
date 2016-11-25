<div class="content"> <!-- Inicio da DIV content -->
<table>
        <thead>

            <? if (count($empresa) > 0) { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS AS CLINICAS</th>
                </tr>
            <? } ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RELATORIO DE CANCELAMENTOS</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></th>
            </tr>
            <? if ($grupo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                </tr>
            <? } else {
                  if(isset($relatorio[0]->grupo)){
                      $nome_grupo = $relatorio[0]->grupo;
                  }else{
                      $nome_grupo = $grupo;
                  }
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $nome_grupo; ?></th>
                </tr>
            <? } ?>
            <? if ($convenio == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS CONVENIOS</th>
                </tr>
            <? } elseif ($convenio == "-1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PARTICULARES</th>
                </tr>
            <? } elseif ($convenio == "") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIOS</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= $convenios[0]->nome; ?></th>
                </tr>
            <? } ?>
                            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
        border-bottom:none;mso-border-top-alt:none;border-left:
        none;border-right:none;' colspan="9">&nbsp;</th>
            </tr>
    <? if ($contador > 0) {
        ?>
                <tr>
                    <td class="tabela_teste" width="80px;"><font size="-2">Atend.</th>
                    <td class="tabela_teste"><font size="-2">Data</th>
                    <td class="tabela_teste" width="150px;"><font size="-2">Paciente</th>
                    <td class="tabela_teste" ><font size="-2">Exame</th>
                    <td class="tabela_teste" ><font size="-2">D. Cancelamento</th>
                    <td class="tabela_teste"><font size="-2">Convenio</th>
                    <td class="tabela_teste"><font size="-2">Motivo</th>
                    <td class="tabela_teste"><font size="-2">Usuario</th>
                    <td class="tabela_teste"><font size="-2">Observa&ccedil;&atilde;o</th>
                </tr>
                                            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
        border-bottom:none;mso-border-top-alt:none;border-left:
        none;border-right:none;' colspan="9">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $paciente = "";
                $contadorpaciente = "";
                $contadorpacientetotal = "";
                foreach ($relatorio as $item) :
                    $i++;
                        $qtde++;
                        $qtdetotal++;
?>
                        <tr>

                            <? if ($paciente == $item->paciente) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            <? } else { ?>
                                <td><font size="-2"><?= $item->agenda_exames_id; ?></td>
                                <td><font size="-2"><?= substr($item->data_autorizacao, 8, 2) . "/" . substr($item->data_autorizacao, 5, 2) . "/" . substr($item->data_autorizacao, 0, 4); ?></td>
                                <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                                <?
                                $contadorpaciente++;
                                $contadorpacientetotal++;
                            }
                            ?>
                            <td><font size="-2"><?= utf8_decode($item->exame); ?></td>
                             <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->convenio); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->descricao); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->operador); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->observacao_cancelamento); ?></td>
                        </tr>


                        <?php
                        $paciente = $item->paciente;
                        $convenio = $item->convenio;
                endforeach;
                ?>
                <tr>
                </tr>
                <tr>
                    <td width="2000px;" align="Right" colspan="9"><b>Nr. Pacientes: <?= $contadorpaciente; ?></b></td>
                </tr>
                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Exa: <?= $qtde; ?></b></td>
                </tr>
            </tbody>
        </table>
        <hr>

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