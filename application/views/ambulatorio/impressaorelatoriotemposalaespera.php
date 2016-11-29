<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <thead>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RELATORIO TEMPO DE ESPERA SALA DE EXAMES</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></th>
            </tr>
            <? if ($convenios == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS CONVENIOS</th>
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
            <? if (count($listar) > 0) {
                ?>
                <tr>
                    <td class="tabela_teste"><font size="-2">Data</th>
                    <td class="tabela_teste" width="150px;"><font size="-2">Paciente</th>
                    <td class="tabela_teste" ><font size="-2">Procedimento</th>
                    <td class="tabela_teste"><font size="-2">Tempo</th>
                    <td class="tabela_teste"><font size="-2">Tecnico</th>
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
                foreach ($listar as $item) :

                    $dataFuturo = $item->data_autorizacao;
                    $dataAtual = $item->data_realizacao;

                    $date_time = new DateTime($dataAtual);
                    $diff = $date_time->diff(new DateTime($dataFuturo));
                    $teste = $diff->format('%H:%I:%S');
                    ?>
                    <tr>


                        <td><font size="-2"><?= substr($item->data_autorizacao, 8, 2) . "/" . substr($item->data_autorizacao, 5, 2) . "/" . substr($item->data_autorizacao, 0, 4); ?></td>
                        <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                        <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                        <td><font size="-2"><?= $teste; ?></td>
                        <td><font size="-2"><?= utf8_decode($item->tecnico); ?></td>
                    </tr>


                    <?php
                endforeach;
                ?>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="9">&nbsp;</th>
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