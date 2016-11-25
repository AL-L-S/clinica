<div class="content"> <!-- Inicio da DIV content -->
    <?if (count($empresa)>0){?>
    <h4><?= $empresa[0]->razao_social; ?></h4>
    <?}else{?>
    <h4>TODAS AS CLINICAS</h4>
    <?}?>
    <h4>CONFERENCIA DOS CONVENIOS</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <hr>
        <?if($contador > 0){
        ?>
    <table>
        <thead>
            <tr>
                <th class="tabela_header">Num.</th>
                <th class="tabela_header">Convenio</th>
                <th class="tabela_header">Emissao</th>
                <th class="tabela_header">Paciente</th>
                <th class="tabela_header">Autorizacao</th>
                <th class="tabela_header">Exame</th>
                <th class="tabela_header">Codigo</th>
                <th class="tabela_header">QTDE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $valor = 0;
            $valortotal = 0;
            foreach ($relatorio as $item) :
                $i++;
                $valortotal = $valortotal + $item->valor_total;
                $valor = $valor + $item->valortotal;
                ?>
                <tr>
                    <td><?= $item->agenda_exames_id; ?></td>
                    <td><?= $item->convenio; ?></td>
                    <td><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4) ; ?></td>
                    <td><?= $item->agenda_exames_id; ?></td>
                    <td><?= $item->paciente; ?></td>
                    <td><?= $item->autorizacao; ?></td>
                    <td><?= utf8_decode($item->exame); ?></td>
                    <td><?= $item->codigo; ?></td>
                    <td><?= $item->quantidade; ?></td>
                </tr>


                <?php
            endforeach;
            ?>
                                </tbody>
    </table>
        <hr>
        <table>
            <tbody>
        <tr>
            <td width="140px;">TOTAL GERAL</td>
            <td width="140px;">Nr. Exa: <?= $i; ?></td>
            <td></td>
        </tr>
        </tbody>

    </table>
        <?}else{
    ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
}?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $( "#accordion" ).accordion();
    });

</script>