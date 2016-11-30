<div class="content"> <!-- Inicio da DIV content -->
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <hr>
    <? if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Data</th>
                    <th class="tabela_header"><font size="-1">Paciente</th>
                    <th class="tabela_header"><font size="-1">Procedimento</th>
                    <th class="tabela_header" width="220px;"><font size="-1">Qtde</th>                 
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $paciente= "";
                $atendente = "";
                $qtde = 0;
                $qtdetotal = 0;
                foreach ($relatorio as $item) :
                    $i++;
                    if ($i == 1 || $item->atendente == $atendente) {
                        $qtde++;
                        $qtdetotal++;

                        if ($i == 1) {
                            ?>
                            <tr>
                                <td colspan="8"><font ><b>Atendente:&nbsp;<?= utf8_decode($item->atendente); ?></b></td>
                            </tr>
                        <? } ?>
                        <tr>                            
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>                          
                            <td><?= $item->paciente; ?></td>                           
                            <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                            <td ><font size="-2"><?= $item->quantidade; ?></td>                                  
                        </tr>
                        <?php
                        $paciente = $item->paciente;
                        $atendente = $item->atendente;
                    } else {
                        $atendente = $item->atendente;
                        ?>

                        <tr>
                            <td width="140px;" align="Right" colspan="9"><b>Nr. Procedimentos:&nbsp; <?= $qtde; ?></b></td>
                        </tr>
                        <?
                        $paciente = "";
                        $qtde = 0;
                        $qtde++;
                        $qtdetotal++;
                        ?>
                        <tr>
                            <td colspan="8"><font ><b>Atendente:&nbsp;<?= utf8_decode($item->atendente); ?></b></td>
                        </tr>
                        <tr>
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>                          
                            <td><?= $item->paciente; ?></td>                           
                            <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                            <td ><font size="-2"><?= $item->quantidade; ?></td>   
                        </tr>
                        <?
                        $paciente = $item->paciente;
                    }
                endforeach;
                ?>

                <tr>
                    <td width="140px;" align="Right" colspan="9"><b>Nr. Procedimentos:&nbsp; <?= $qtde; ?></b></td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table>
            <tbody>
                <tr>
                    <td width="140px;" align="Right" ><b>TOTAL GERAL</b></td>
                    <td  width="340px;" align="center" ><b>Nr. Procedimentos: &nbsp;<?= $qtdetotal; ?></b></td>
                </tr>
            </tbody>

        </table>
                    
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>
