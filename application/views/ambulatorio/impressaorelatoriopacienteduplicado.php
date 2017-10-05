<!--<div class="content">  Inicio da DIV content -->
<meta charset="utf-8"/>
<? $tipoempresa = ""; ?>
<table>
    <thead>


        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Pacientes Duplicados</th>
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
                <td class="tabela_teste">Prontuário</td>
                <td class="tabela_teste">Nome</td>
                <? if ($_POST['pesquisa'] == '1') { ?>

                <? } elseif ($_POST['pesquisa'] == '2') { ?>
                    <td class="tabela_teste">Nascimento</td>   

                <? } elseif ($_POST['pesquisa'] == '3') { ?>

                    <td class="tabela_teste">Nome da Mãe</td>
                <? } elseif ($_POST['pesquisa'] == '4') { ?>

                    <td class="tabela_teste">CPF</td>  
                <? }
                ?>
                <td class="tabela_teste">Situação</td>
                <!--<td class="tabela_teste">Registros</td>-->
                <!--<td class="tabela_teste">Nome da Mãe</td>-->
                <!--<td class="tabela_teste">CPF</td>-->
            </tr>
        </thead>
        <hr>
        <tbody>
            <?php
            $contador = 0;
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

                if ($_POST['pesquisa'] == '1') {
                    if ($item->paciente == @$relatorio[$contador + 1]->paciente) {
                        $conta = 'Duplicado';
                        $cor = 'red';
                    } else {
                        $conta = 'Normal';
                        $cor = 'black';
                        if ($item->paciente == @$relatorio[$contador - 1]->paciente) {
                            $conta = 'Duplicado';
                             $cor = 'red';
                        } else {
                            $conta = 'Normal';
                             $cor = 'black';
                        }
                    }
                } elseif ($_POST['pesquisa'] == '2') {
                    if ($item->nascimento == @$relatorio[$contador + 1]->nascimento) {
                        $conta = 'Duplicado';
                         $cor = 'red';
                    } else {
                        $conta = 'Normal';
                         $cor = 'black';
                        if ($item->nascimento == @$relatorio[$contador - 1]->nascimento) {
                            $conta = 'Duplicado';
                             $cor = 'red';
                        } else {
                            $conta = 'Normal';
                             $cor = 'black';
                        }
                    }
                } elseif ($_POST['pesquisa'] == '3') {
                    if ($item->nome_mae == @$relatorio[$contador + 1]->nome_mae) {
                        $conta = 'Duplicado';
                         $cor = 'red';
                    } else {
                        $conta = 'Normal';
                        $cor = 'black';
                        if ($item->nome_mae == @$relatorio[$contador - 1]->nome_mae) {
                            $conta = 'Duplicado';
                             $cor = 'red';
                        } else {
                            $conta = 'Normal';
                             $cor = 'black';
                        }
                    }
                } elseif ($_POST['pesquisa'] == '4') {
                    if ($item->cpf == @$relatorio[$contador + 1]->cpf) {
                        $conta = 'Duplicado';
                         $cor = 'red';
                    } else {
                        $conta = 'Normal';
                         $cor = 'black';
                        if ($item->cpf == @$relatorio[$contador - 1]->cpf) {
                            $conta = 'Duplicado';
                             $cor = 'red';
                        } else {
                            $conta = 'Normal';
                             $cor = 'black';
                        }
                    }
                }







                $i++;
                $qtdetotal++;

//                $dataFuturo = date("Y-m-d");
//                $dataAtual = $item->nascimento;
//                $date_time = new DateTime($dataAtual);
//                $diff = $date_time->diff(new DateTime($dataFuturo));
//                $teste = $diff->format('%Ya %mm %dd');
//                $idade = $teste = $diff->format('%Y');
//                
                ?>
                <tr  style='color: <?=$cor?>'>

                    <td><?= $item->paciente_id; ?></td>
                    <td><?= utf8_decode($item->paciente); ?></td>
        <!--                    <td style='text-align: center;'><?
                    if ($item->sexo == "M") {
                        echo 'Masculino';
                        $masculino ++;
                    } else {
                        $feminino ++;
                        echo 'Feminino';
                    }
                    ?></td>-->

                    <? if ($_POST['pesquisa'] == '1') { ?>

                    <? } elseif ($_POST['pesquisa'] == '2') { ?>
                        <td style='text-align: center;'><?= date('d/m/Y', strtotime($item->nascimento)) ?></td>

                    <? } elseif ($_POST['pesquisa'] == '3') { ?>

                        <td style='text-align: center;'><font size="-1"><?= utf8_decode($item->nome_mae); ?></td>
                    <? } elseif ($_POST['pesquisa'] == '4') { ?>

                        <td style='text-align: center;'><?= $item->cpf ?></td>

                    <? }
                    ?>



                    <td style='text-align: center; color: <?=$cor?>'><?= $conta ?></td>
                    <!--<td style='text-align: center;'><? //= $item->conta       ?></td>-->

                </tr>
                <?
                $contador++;
            endforeach;
            ?>

            <tr>
                <td width="140px;" align="Right" colspan="4"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
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
