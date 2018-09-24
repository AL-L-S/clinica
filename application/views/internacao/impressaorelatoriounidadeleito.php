
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h4 class="title_relatorio">Relatório Unidade Leito</h4>
    <p></p>
    <h4 class="title_relatorio">Unidade: <?= @$unidade; ?> </h4>
    <h4 class="title_relatorio">Enfermaria: <?= @$enfermaria; ?> </h4>


    <br>
   
    <? if (count($unidadeleito) > 0) { ?>
        
        <table border='1' cellspacing=0 cellpadding=5 style="border-collapse: collapse;font-size: 9pt">

            <tr>
                <?
                $unidade_conta = array();
                $contador0 = 0;
                foreach ($unidadeleito as $item) {
                    if ($contador0 == 0 || $item->unidade != $unidade_foreach) {
                        $unidade_conta[$item->unidade] = 0;
                        $unidade_vago[$item->unidade] = 0;
                        $unidade_ocupado[$item->unidade] = 0;
                    }
                    $unidade_foreach = $item->unidade;
                    $contador0++;
                }


                $vago = 0;
                $ocupado = 0;
                $contador = 0;



                $unidade_foreach = '';
                foreach ($unidadeleito as $item) {
//                     var_dump($unidadeleito);die;
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
                            Tipo Enfermaria
                        </th>
                        <th class="tabela_header">
                            Leito
                        </th>
                        <th class="tabela_header">
                            Tipo Leito
                        </th>
                        <th class="tabela_header">
                            Condição do Leito
                        </th>
                        
                    </tr>
                <? }
                if ($item->ativo == 'f') {
                    $ocupado++;
                    $unidade_ocupado[$item->unidade] ++;
                    
                    ?> 
                    <tr>
                        <td ><?= $item->enfermaria; ?></td>
                        <td ><?= $item->tipoenfermaria; ?></td>
                        <td ><?= $item->leito; ?></td>
                        <td ><?= $item->tipoleito; ?></td>
                        <td ><?= $item->condicao; ?></td>                        
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

        </table>

        <br>
        <br>
        <h2>Unidades Total</h2>
        <table border='1' cellspacing=0 cellpadding=5 style="border-collapse: collapse;font-size: 9pt">
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
        <table border='1' cellspacing=0 cellpadding=5 style="border-collapse: collapse;font-size: 9pt">
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
                <th class="tabela_header"><?= count($unidadeleito); ?></th>
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
