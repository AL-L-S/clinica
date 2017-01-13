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
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">FORNECEDORES</th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
            </tr>
        </thead>
    </table>

    <? if ($contador > 0) {
        ?>

        <table>
            <thead>
                <tr>
                    <td class="tabela_teste"><font size="-2">Fornecedor</th>
                    <td style='text-align: right;' class="tabela_teste" width="100px;"><font size="-2">Telefone</th>
                    <td style='text-align: right;' class="tabela_teste" width="100px;"><font size="-2">Celular</th>
                    <td class="tabela_teste" width="300px;"><font size="-2">Endere&ccedil;o</th>
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
                    $qtde++;
                    $qtdetotal++;

                    if ($i == 1) {
                        ?>

                    <? } ?>
                    <tr>
                        <td><font size="-2"><?= utf8_decode($item->fantasia); ?></td>
                        <td style='text-align: right;'><font size="-2"><?= $item->telefone; ?></td>
                        <td style='text-align: right;'><font size="-2"><?= $item->celular; ?></td>
                        <td ><font size="-2"><?= utf8_decode($item->logradouro) . " " . $item->numero . " " . utf8_decode($item->bairro); ?></td>
                    </tr>


                    <?php
                endforeach;
                ?>

            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
                <tr>
                    <td width="140px;" align="center" ><b>TOTAL: &nbsp;<?= $qtdetotal; ?></b></td>
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