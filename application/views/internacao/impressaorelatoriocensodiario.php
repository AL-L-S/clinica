
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h4 class="title_relatorio">Relatório Censo Diário</h4>
    <p></p>
    <h4 class="title_relatorio">Unidade: <?= @$unidade; ?> </h4>
    <h4 class="title_relatorio">Enfermaria: <?= @$enfermaria; ?> </h4>
    <h4 class="title_relatorio">Status: <?= ($_POST['status_leito'] != '') ? $_POST['status_leito'] : 'TODOS'; ?> </h4>

    <br>
    <!--<br>-->
    <? if (count($censodiario) > 0) { ?>
        <!--<hr/>-->
        <table border='1' cellspacing=0 cellpadding=5>

            <tr>
                <?
                $unidade_conta = array();
                $contador0 = 0;
                foreach ($censodiario as $item) {
                    if ($contador0 == 0 || $item->unidade != $unidade_foreach) {
                        $unidade_conta[$item->unidade] = 0;
                        $unidade_vago[$item->unidade] = 0;
                        $unidade_ocupado[$item->unidade] = 0;
                    }
                    $unidade_foreach = $item->unidade;
                    $contador0++;
                }
//                var_dump($unidade_conta); die;

                $vago = 0;
                $ocupado = 0;
                $contador = 0;



                $unidade_foreach = '';
                foreach ($censodiario as $item) {
                    $unidade_conta[$item->unidade] ++;
                    ?>

                    <? if ($contador == 0 || $item->unidade != $unidade_foreach) {
                        ?>
                    <tr>
                        <td colspan="8" style="font-weight: bold;"><h3>Unidade: <?= $item->unidade; ?></h3></td>

                    </tr>  
                    <tr>
                        <th class="tabela_header">
                            Enfermaria
                        </th>
                        <th class="tabela_header">
                            Leito
                        </th>
                        <th class="tabela_header">
                            Paciente
                        </th>
                        <th class="tabela_header">
                            Sexo
                        </th>
                        <th class="tabela_header">
                            Idade
                        </th>
                        <th class="tabela_header">
                            Procedimento
                        </th>
                        <th class="tabela_header">
                            Cid
                        </th>
                        <th class="tabela_header">
                            Dias De Internação
                        </th>



                    </tr>
                <? }
                ?>    
                <?
                if ($item->ativo == 'f') {
                    $ocupado++;
                    $unidade_ocupado[$item->unidade] ++;
                    // Idade
                    $nascimento = new DateTime($item->nascimento);
                    $atual = new DateTime(date("Y-m-d"));

                    // Resgata diferença entre as datas
                    $dateInterval = $nascimento->diff($atual);

                    $data_inicio = new DateTime($item->data_internacao);
                    $data_fim = new DateTime(date("Y-m-d H:i:s"));

                    // Resgata diferença entre as datas
                    $dateInterval2 = $data_inicio->diff($data_fim);
                    ?>
                    <tr>
                        <td ><?= $item->enfermaria; ?></td>
                        <td ><?= $item->leito; ?></td>
                        <td ><?= $item->paciente; ?></td>
                        <td ><?= $item->sexo; ?></td>
                        <td ><?= $dateInterval->y; ?> Anos</td>
                        <td ><?= $item->procedimento; ?></td>
                        <td ><?= $item->cid1; ?></td>
                        <td ><?= $dateInterval2->days; ?> Dias</td>
                    </tr>
                    <?
                } else {
                    $vago++;
                    $unidade_vago[$item->unidade] ++;
                    ?>
                    <tr>
                        <td ><?= $item->enfermaria; ?></td>
                        <td ><?= $item->leito; ?></td>
                        <td colspan="6" style="color: #029302; text-align: center;">Vago</td>

                    </tr>
                <? } ?>
                <?
                $unidade_foreach = $item->unidade;
                $contador++;
            }
            ?>
<!--            <tr>

                <th colspan="3" class="tabela_header">Leitos Vagos: <?= $vago; ?></th>
                <th colspan="3" class="tabela_header">Leitos Ocupados: <?= $ocupado; ?></th>
                <th colspan="3" class="tabela_header">Total de Registros: <?= count($censodiario); ?></th>
            </tr>-->
        </table>

        <!--<br>-->
        <!--<br>-->
        <!--<hCr>-->
        <br>
        <br>
        <h2>Unidades Total</h2>
        <table border='1' cellspacing=0 cellpadding=5>
            <tr>
                <th>
                    Unidade
                </th>
                <th>
                    Ocupados
                   
                </th>
                <th>
                    Vagos
                </th>
            </tr>
            <? foreach ($unidade_conta as $key => $value) { ?>
                <tr>

                    <td  class="tabela_header"><?= $key; ?></td>
                    <td class="tabela_header"><?= $unidade_ocupado[$key]; ?></td>
                    <td  class="tabela_header"><?= $unidade_vago[$key]; ?></td>
                </tr>  
            <? }
            ?>

        </table>
        <br>
        <br>
        <br>
        <table border='1' cellspacing=0 cellpadding=5>
            <tr>
                <th>
                    Leitos Vagos Total
                </th>
                <th>
                    Leitos Ocupados Total
                </th>
                <th>
                    Total de Registros
                </th>
            </tr> 
            <tr>

                <th class="tabela_header"><?= $vago; ?></th>
                <th class="tabela_header"><?= $ocupado; ?></th>
                <th class="tabela_header"><?= count($censodiario); ?></th>
            </tr>

        </table>
        <br>
        <br>
        <br>
        <br>
    <? } else { ?>
        <br> <hr/>
        <h2 class="title_relatorio">Sem Registros </h2>
    <? } ?>


</div> 

<!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->

<script type="text/javascript">

</script>