<!--<div class="content">  Inicio da DIV content -->
<meta charset="utf-8"/>
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
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Perfil Paciente</th>
        </tr>
        <tr>
            <th style='width:10pt;border:solid windowtext 1.0pt;
                border-bottom:none;mso-border-top-alt:none;border-left:
                none;border-right:none;' colspan="4">&nbsp;</th>
        </tr>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
        </tr>

        <? if ($tipoempresa == "0") { ?>
            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODAS RECOMENDAÇÕES</th>
            </tr>
        <? } else { ?>
            <tr>
                <!--<th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">RECOMENDAÇÃO: <?= $indicacao; ?></th>-->
            </tr>
        <? } ?>
        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PERIODO: <?= date("d/m/Y", strtotime(str_replace('/', '-', $txtdata_inicio))); ?> até <?= date("d/m/Y", strtotime(str_replace('/', '-', $txtdata_fim))); ?></th>
        </tr>

    </thead>
</table>

<? if (count($relatorio) > 0) {
    ?>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th class="tabela_teste">Nome</th>
                <th class="tabela_teste">Data de Nascimento</th>
                <th class="tabela_teste">WhatsApp</th>
                <th class="tabela_teste">Telefone/Celular</th>
                <th class="tabela_teste">Email</th>
                <th class="tabela_teste">Sexo</td>
                <th class="tabela_teste">Estado Civil</th>
            </tr>
        </thead>
        <hr>
        <tbody>
            <?php
            $i = 0;
            $b = 0;
            $c = 0;
            $qtde = 0;
            $qtdetotal = 0;
            $tecnicos = "";
            $paciente = "";
            $indicacao = "";
            $masculino = 0;
            $feminino = 0;
            $solteiro = 0;
            $casado = 0;
            $divorciado = 0;
            $fundamental1 = 0;
            $fundamental2 = 0;
            $medio1 = 0;
            $medio2 = 0;
            $superior1 = 0;
            $superior2 = 0;
            $viuvo = 0;
            $outros = 0;
            $crianca = 0;
            $adoles = 0;
            $adulto = 0;
            $adulto2 = 0;
            $adulto3 = 0;
            $adulto4 = 0;
            $adulto5 = 0;
            $adulto6 = 0;
            $adulto7 = 0;
            $adulto8 = 0;
            $adulto9 = 0;
            $adulto10 = 0;
            $idosos = 0;
            $idades = array();
            foreach ($relatorio as $item) :
                if (@$item->whatsapp != '' && strlen(@$item->whatsapp) > 3) {
                    if (preg_match('/\(/', @$item->whatsapp)) {
                        $whatsapp = @$item->whatsapp;
                    } else {
                        $whatsapp = "(" . substr(@$item->whatsapp, 0, 2) . ")" . substr(@$item->whatsapp, 2, strlen(@$item->whatsapp) - 2);
                    }
                } else {
                    $whatsapp = '';
                }

                $i++;
                $qtdetotal++;

                $dataFuturo = date("Y-m-d");
                $dataAtual = $item->nascimento;
                $date_time = new DateTime($dataAtual);
                $diff = $date_time->diff(new DateTime($dataFuturo));
                $teste = $diff->format('%Ya %mm %dd');
                $idade = $teste = $diff->format('%Y');
                ?>
                <tr>

                    <td><?= utf8_decode($item->paciente); ?></td>
                    <td style='text-align: center;'><font size="-1"><?= date("d/m/Y",strtotime($item->nascimento)); ?></td>
                    <td style='text-align: center;'><font size="-1"><?= @$whatsapp; ?></td>
                    
                    <td><?= $item->telefone . " / " . $item->celular; ?></td>
                    <td style='text-align: center;'><font size="-1"><?= $item->cns; ?></td>
                    <td style='text-align: center;'><?
                        if ($item->sexo == "M") {
                            echo 'Masculino';
                            $masculino ++;
                        } else {
                            $feminino ++;
                            echo 'Feminino';
                        }
                        ?></td>
                    
                    <td style='text-align: center;'><?
                        if ($item->estado_civil_id == "1") {
                            echo 'Solteiro(a)';
                            $solteiro++;
                        } elseif ($item->estado_civil_id == "2") {
                            echo 'Casado(a)';
                            $casado++;
                        } elseif ($item->estado_civil_id == "3") {
                            echo 'Divorciado(a)';
                            $divorciado++;
                        } elseif ($item->estado_civil_id == "4") {
                            echo 'Viuvo(a)';
                            $viuvo++;
                        } elseif ($item->estado_civil_id == "5") {
                            echo 'Outros';
                            $outros++;
                        }
                        ?></td>
                </tr>
            <? endforeach; ?>

            <tr>
                <td width="140px;" align="Right" colspan="7"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
            </tr>
        </tbody>
    </table>



<? } else {
    ?>
    <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
<? }
?>


<!--</div>  Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>js/morris/morris.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/Gruntfile.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/morris.js" ></script>
<script src="<?= base_url() ?>js/morris/raphael.js"></script>


<script>

    $(document).ready(function () {
        $("#teste").click(function () {
            $("#adultos").fadeIn(1000);
            $("#adultoslabel").fadeIn(1000);
            $("#esconder").fadeIn(1000);
//            $("#adultos").css( "display", "block" );
//            $("#adultos").css( "display", "none" );
        });
        $("#esconder").click(function () {
            $("#adultos").fadeOut(1000);
            $("#adultoslabel").fadeOut(1000);
            $("#esconder").fadeOut(1000);
        });
    });
</script>
