<div class="content"> <!-- Inicio da DIV content -->
    <h4>CONFERENCIA DOS CONVENIOS</h4>
    <h4>PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></h4>
    <hr>
        <?if(count($relatorio) > 0){
        ?>
    <table>
        <thead>
            <tr>
                <th class="tabela_header">Prontuario</th>
                <th class="tabela_header">Convenio</th>
                <th class="tabela_header">Nascimento</th>
                <th class="tabela_header">Paciente</th>
                <th class="tabela_header">Data de Casdatro</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($relatorio as $item) :
                $i++;
                ?>
                <tr>
                    <td><?= $item->paciente_id; ?></td>
                    <td><?= $item->convenio; ?></td>
                    <td><?= substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4) ; ?></td>
                    <td><?= $item->paciente; ?></td>
                    <td><?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4) ; ?></td>
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
            <td width="140px;">Nr. Pacientes: <?= $i; ?></td>
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