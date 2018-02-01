<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->

    <h4>TODAS AS CLINICAS</h4>

    <h4>Relatorio Paciente Telefone</h4>
    <h4>PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></h4>
</h4>
<hr>
<table border="1" cellpadding="5">
    <thead>
        <tr>

            <th class="tabela_header" width="350px;">Paciente</th>
            <th class="tabela_header">Grupo</th>
            <th class="tabela_header">Convenio</th>
            <th class="tabela_header" width="450px;">Pocedimento</th>
            <th class="tabela_header">Telefone</th>
            <th class="tabela_header">Email</th>
            <th class="tabela_header">Data</th>
            <th class="tabela_header">Previsao Retorno</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $paciente = "";
        $convenio = "";

        if (count($relatorio) > 0) {
            foreach ($relatorio as $item) {

                if ($item->celular != "") {
                    $telefone = $item->celular;
                } elseif ($item->telefone != "") {
                    $telefone = $item->telefone;
                } else {
                    $telefone = "";
                }


                $data = $item->data;
                $dia = strftime("%A", strtotime($data));

                switch ($dia) {
                    case"Sunday": $dia = "Domingo";
                        break;
                    case"Monday": $dia = "Segunda";
                        break;
                    case"Tuesday": $dia = "Terça";
                        break;
                    case"Wednesday": $dia = "Quarta";
                        break;
                    case"Thursday": $dia = "Quinta";
                        break;
                    case"Friday": $dia = "Sexta";
                        break;
                    case"Saturday": $dia = "Sabado";
                        break;
                }
                ?>
                <tr>

                    <td><?= $item->paciente; ?></td>
                    <td><?= $item->grupo; ?></td>
                    <td><?= $item->convenio; ?></td>
                    <td><?= $item->nome; ?></td>
                    <td ><?= $telefone; ?></td>
                    <td ><?= $item->email; ?></td>
                    <td><?= date("d/m/Y", strtotime($item->data)); ?></td>
                    <td><? 
                        if( $item->dias_retorno != "" ){
                            echo date("d/m/Y", strtotime("+" . $item->dias_retorno . ' day', strtotime($item->data))); 
                        } else {
                            echo "--";
                        }?>
                    </td>
                </tr>

            </tbody>
            <?php
        }
    }
    ?>

</table>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
