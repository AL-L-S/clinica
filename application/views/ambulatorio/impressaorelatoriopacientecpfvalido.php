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
<!--        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">EMPRESA: <?= $tipoempresa ?></th>
        </tr>-->



    </thead>
</table>

<? if (count($relatorio) > 0) {
    ?>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <td class="tabela_teste">Prontuário</td>
                <td class="tabela_teste">Nome</td>

                            <!--<td class="tabela_teste">Nascimento</td>-->   

                            <!--<td class="tabela_teste">Nome da Mãe</td>-->
                <td class="tabela_teste">CPF</td>  
                <!--<td class="tabela_teste">Situação CPF</td>-->  

                            <!--<td class="tabela_teste">Situação</td>-->
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
            $this->load->library('utilitario');

            foreach ($relatorio as $item) :
                $i++;
                $qtdetotal++;
                $cpf = $item->cpf;
                $validar = Utilitario::validaCPF($cpf);
                if ($validar) {
                    $situacao = 'Válido';
                } else {
                    $situacao = 'Inválido';
                }

                $nbr_cpf = $cpf;

                $parte_um = substr($nbr_cpf, 0, 3);
                $parte_dois = substr($nbr_cpf, 3, 3);
                $parte_tres = substr($nbr_cpf, 6, 3);
                $parte_quatro = substr($nbr_cpf, 9, 2);

                $monta_cpf = "$parte_um.$parte_dois.$parte_tres-$parte_quatro";

//                $monta_cpf;


//                $dataFuturo = date("Y-m-d");
//                $dataAtual = $item->nascimento;
//                $date_time = new DateTime($dataAtual);
//                $diff = $date_time->diff(new DateTime($dataFuturo));
//                $teste = $diff->format('%Ya %mm %dd');
//                $idade = $teste = $diff->format('%Y');
//                
                ?>
                <? if ($validar) { ?>


                    <tr  style='color: <?= $cor ?>'>

                        <td><?= $item->paciente_id; ?></td>
                        <td><?= $item->paciente; ?></td>
            <!--                    <td style='text-align: center;'><?
                        if ($item->sexo == "M") {
                            echo 'Masculino';
                            $masculino ++;
                        } else {
                            $feminino ++;
                            echo 'Feminino';
                        }
                        ?></td>-->
                        <!--<td style='text-align: center;'><? //if($item->nascimento != ''){echo date('d/m/Y', strtotime($item->nascimento)); }  ?></td>-->



                                                        <!--<td style='text-align: center;'><font size="-1"><? //= utf8_decode($item->nome_mae);    ?></td>-->


                        <td style='text-align: center;'><?= $monta_cpf ?></td>
                        <!--<td style='text-align: center;'><? //= $situacao  ?></td>-->

                                                        <!--<td style='text-align: center;'><? //= $item->conta            ?></td>-->

                    </tr>
                <? } ?>    
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
