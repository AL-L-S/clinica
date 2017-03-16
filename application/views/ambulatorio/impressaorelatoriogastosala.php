<div class="content"> <!-- Inicio da DIV content -->
    <meta charset="utf8"/>
    <h4>RELATORIO GASTO DE SALA</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <h4>PACIENTE: TODOS</h4>
    
    <BR>
    <HR>
    
    <table border="1" cellpadding="5">
        <thead>

           <tr>
                <th>PACIENTE</th>
                <th>PRODUTO</th>
                <th>UNIDADE</th>
                <th>QUANTIDADE</th>
                <th>DESCRIÇÃO</th>
                <th>PROCEDIMENTO</th>
            </tr>
            
        </thead>
        <tbody>
            <?  foreach ($relatorio as $value) :?>
                <tr>
                    <td><?=$value->paciente;?></td>
                    <td><?=$value->produto;?></td>
                    <td><?=$value->unidade;?></td>
                    <td><?=$value->quantidade;?></td>
                    <td><?=$value->descricao;?></td>
                    <td><?=$value->procedimento;?></td>
                 </tr>
            <? endforeach; ?>
        </tbody>


    </table>
</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>