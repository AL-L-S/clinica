<div class="content"> <!-- Inicio da DIV content -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <table>
        <thead>


            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4"><?= $empresa[0]->razao_social; ?></th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="8">&nbsp;</th>
            </tr>
        </thead>
    </table>
    <table cellpadding="10" cellspacing="10">
        <thead>
            <? if (count($relatorio) > 0) {
                ?>
                <tr>
                    <!--<td class="tabela_teste" width="80px;">Atend.</th>-->
                    <th class="tabela_teste"  colspan="50"><center>EXPORTAÇÃO DE EMAILS</center></th>
            </tr>
            <tr>
                <th class="tabela_teste" >Prontuário</th>
                <th class="tabela_teste" >Paciente</th>
                <th class="tabela_teste" >Email</th>

            </tr>
            </thead>
            <tbody>
                <?
                foreach ($relatorio as $value) :
                    if (isset($item->cns) && $item->cns != '') {
                        $email = $email . $item->cns . ', ';
                    }
                    ?>
                    <tr>
                        <td><?= $value->paciente_id; ?></td>
                        <td><?= $value->paciente; ?></td>
                        <td><?= $value->cns; ?></td>

                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    <? } ?>


</div>  <!-- Final da DIV content -->
<!--<meta http-equiv="content-type" content="text/html;charset=utf-8" />-->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript">
//
//
//
//    $(document).ready(function () {
//        $("#mostrar").click(function () {
//            $("#mala_direta").fadeIn(1000);
//            $("#esconder").fadeIn(1000);
//            $("#mostrar").fadeOut(1000);
////            $("#adultos").css( "display", "block" );
////            $("#adultos").css( "display", "none" );
//        });
//        $("#esconder").click(function () {
//            $("#mala_direta").fadeOut(1000);
//            $("#esconder").fadeOut(1000);
//            $("#mostrar").fadeIn(1000);
//        });
//    });

</script>