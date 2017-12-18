<div class="content"> <!-- Inicio da DIV content -->
    <meta charset="utf8"/>
    <?
    $tipoempresa = "";
    ?>
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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RELATORIO SALDO CRÉDITO</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>
            <?if($txtNome != ''){?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PACIENTE: <?= $txtNome ?></th>
                </tr>
            <?}?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left;' width="320px;"><font size="-1">Paciente</th>
                <th style='text-align: right;'width="320px;"><font size="-1">Telefone</th>
                <th style='text-align: right;'width="320px;"><font size="-1">Saldo</th>
            </tr> 
            <?

            foreach ($pacientes as $item) {
                if($item->telefone != ''){
                    $telefone = $item->telefone;
                } 
                else{
                    $telefone = $item->celular;
                }
                ?>
                <tr>
                    <td ><font size="-1"><?= $item->paciente ?></td>
                    <td style='text-align: right;'><font size="-1"><?= $telefone ?></td>
                    <td style='text-align: right;'><font size="-1"><?= "R$ " . number_format($item->saldo, 2, ',', '.') ?></td>
                </tr> 

                <?
            }
            ?>
    </table>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>