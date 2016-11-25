<div class="content"> <!-- Inicio da DIV content -->
    <?if (count($empresa)>0){?>
    <h4><?= $empresa[0]->razao_social; ?></h4>
    <?}else{?>
    <h4>TODAS AS CLINICAS</h4>
    <?}?>
    <h4>AJUSTAR VALORES</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <h4>NOVO VALOR:</h4>

    <? 
    if ($contador > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Data</th>
                    <th class="tabela_header"><font size="-1">Paciente</th>
                    <th class="tabela_header"><font size="-1">Convenio</th>
                    <th class="tabela_header"><font size="-1">Procedimento</th>
                    <th class="tabela_header"><font size="-1">Valor</th>
                    <th class="tabela_header"><font size="-1">Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $procedimento = "";
                foreach ($relatorio as $item) :
                    $procedimento = $item->procedimento_tuss_id;

                        ?>
                        <tr>
                            <td><font size="-2"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                            <td><font size="-2"><?= $item->convenio; ?></td>
                            <td><font size="-2"><?= $item->exame; ?></td>
                            <td><font size="-2"><?= number_format($item->valor, 2, ',', '.'); ?></td>
                            <td><font size="-2"><?= number_format($item->valor_total, 2, ',', '.'); ?></td>
                        </tr>
<?              
                endforeach;
                ?>
            <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/guia/gravarnovovalorprocedimento" method="post">
                <input type="hidden" class="texto3" name="txtdata_inicio" value="<?= $txtdata_inicio; ?>"/>
                <input type="hidden" class="texto3" name="txtdata_fim" value="<?= $txtdata_fim; ?>" />
                <input type="hidden" class="texto3" name="procedimento" value="<?= $procedimento; ?>"/>
                <input type="text" class="texto3" name="valor" alt="decimal"/>
               <button type="submit" name="btnEnviar">Atualizar</button>

            </form>
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
