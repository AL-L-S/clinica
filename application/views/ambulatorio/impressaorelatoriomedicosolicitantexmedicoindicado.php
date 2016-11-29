<div class="content"> <!-- Inicio da DIV content -->
    <?if (count($empresa)>0){?>
    <h4><?= $empresa[0]->razao_social; ?></h4>
    <?}else{?>
    <h4>TODAS AS CLINICAS</h4>
    <?}?>
    <h4>Medico Solicitante</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <hr>
    <? if ($contador > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Medico Solicitante</th>
                    <th class="tabela_header"><font size="-1">Medico</th>
                    <th class="tabela_header"><font size="-1">Paciente</th>
                    <th class="tabela_header"><font size="-1">Procedimento</th>
                    <th class="tabela_header"><font size="-1">Laudo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $y = 0;
                $qtde = 0;
                $qtdetotal = 0;
                foreach ($relatorio as $item) :
                    $i++;


                        ?>
                        <tr>
                            <td><font size="-2"><?= utf8_decode($item->medicosolicitante); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->medico); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                            <td><font size="-2"><?= $item->situacao; ?></td>
                        </tr>


                        <?php
                        $valortotal = $valortotal + $item->valor;
                endforeach;
                ?>
                <tr>
                    <td ><font size="-1">TOTAL</td>
                    <td ><font size="-1">Nr. Exa: <?= $i; ?></td>
                    <td width="200px;"><font size="-1">VALOR TOTAL: <?= number_format($valortotal, 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
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
        $( "#accordion" ).accordion();
    });

</script>