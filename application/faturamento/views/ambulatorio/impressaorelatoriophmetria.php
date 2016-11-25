<div class="content"> <!-- Inicio da DIV content -->
    <h4>HUMANA IMAGEM</h4>
    <h4>CONFERENCIA PH METRIA</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <hr>
    <?if($contador > 0){
        ?>
    <table border="1">
        <thead>
            <tr>
                <th class="tabela_header"><font size="-1">Emissao</th>
                <th class="tabela_header"><font size="-1">Paciente</th>
                <th class="tabela_header"><font size="-1">Convenio</th>
                <th class="tabela_header"><font size="-1">Exame</th>
                <th class="tabela_header"><font size="-1">F. Pagamento</th>
                <th class="tabela_header"><font size="-1">QTDE</th>
                <th class="tabela_header"><font size="-1">Medico</th>
                <th class="tabela_header" width="80px;"><font size="-1">V. Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $valor = 0;
            $valortotal = 0;
            $convenio = "";
            $y = 0;
            
            foreach ($relatorio as $item) :
                $i++;
                
                $valortotal = $valortotal + $item->valor_total;
                
                if ($i == 1 || $item->convenio == $convenio){
                
                ?>
                <tr>
                    <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4) ; ?></td>
                    <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                    <td><font size="-2"><?= $item->convenio; ?></td>
                    <td><font size="-2"><?= utf8_decode($item->exame); ?></td>
                    <td><font size="-2"><?= $item->forma_pagamento; ?></td>
                    <td><font size="-2"><?= $item->quantidade; ?></td>
                    <td><font size="-2"><?= $item->medicosolicitante; ?></td>
                    <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                </tr>


                <?php
                $y++;
                $valor = $valor + $item->valor_total;
                $convenio = $item->convenio;
                }else{
                    $convenio = $item->convenio;
                    ?>  
        <tr>
            <td colspan="2"><font size="-1">TOTAL</td>
            <td colspan="2"><font size="-1">Nr. Exa: <?= $y; ?></td>
            <td colspan="3"><font size="-1">VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></td>
        </tr>
        <tr><td></td></tr>
        <tr><td></td></tr>


                                        <tr>
                    <td><font size="-2"><?= $item->data; ?></td>
                    <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                    <td><font size="-2"><?= $item->convenio; ?></td>
                    <td><font size="-2"><?= utf8_decode($item->exame); ?></td>
                    <td><font size="-2"><?= $item->forma_pagamento; ?></td>
                    <td><font size="-2"><?= $item->quantidade; ?></td>
                    <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.') ?></td>
                </tr>
                        <?
                        $valor = 0;
                        $valor = $valor + $item->valor_total;
                        $y = 0;
                        $y++;
                        
                }
            endforeach;
            ?>
                        <tr>
            <td colspan="2"><font size="-1">TOTAL</td>
            <td colspan="2"><font size="-1">Nr. Exa: <?= $y; ?></td>
            <td colspan="3"><font size="-1">VALOR TOTAL: <?= number_format($valor, 2, ',', '.'); ?></td>
        </tr>
                                </tbody>
    </table>
        <hr>
        <table>
            <tbody>
        <tr>
            <td width="140px;"><font size="-1">TOTAL GERAL</td>
            <td width="140px;"><font size="-1">Nr. Exa: <?= $i; ?></td>
            <td><font size="-2"></td>
            <td width="200px;"><font size="-1">Total Geral: <?= number_format($valortotal, 2, ',', '.'); ?></td>
        </tr>
        </tbody>

    </table>
<?}else{
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