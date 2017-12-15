<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <thead>            
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= @$empresa[0]->razao_social; ?></th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="4">&nbsp;</th>
            </tr>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">DATA DE EMISSAO: <?= date("d/m/Y"); ?></th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PACIENTE: <?= @$credito[0]->paciente; ?></th>
            </tr>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">SALDO ATUAL: R$<?= @number_format($credito[0]->valor_total, 2, ',','.'); ?> (<?= @$extenso; ?>)</th>
            </tr>
        </thead>
    </table>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>