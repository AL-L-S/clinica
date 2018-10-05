<div class="content"> <!-- Inicio da DIV content -->
    <meta charset="utf8"/>
    <h4>RELATORIO GUIA SADT</h4>
    <h4>MÉDICO: <?=(@$medico != '0')? $medico[0]->operador: 'TODOS';?></h4>
    <h4>CONVÊNIO: <?=(@$convenios > 0)? $convenios[0]->nome: 'TODOS';?></h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <!-- <h4>PACIENTE: TODOS</h4> -->
    <? //var_dump($convenios); die; ?>
    <BR>
    <HR>
    
    <table border="1" cellpadding="5">
        <thead>

           <tr>
                <th>Paciente</th>
                <th>Convênio</th>
                <th>Solicitante</th>
                <th>Data</th>
                <th>Procedimento</th>
                <th>Quantidade</th>
                <!-- <th>VALOR UNIT (R$)</th> -->
                <!-- <th>VALOR TOTAL (R$)</th> -->
                <!-- <th>DESCRIÇÃO</th> -->
<!--                <th>teste</th>
                <th>hora</th>-->
            </tr>
            
        </thead>
        <tbody>
            <?
            $i = 0;
            ?>
            <?  foreach ($relatorio as $value) :?>
                <tr>
                   
                    <td><?=$value->paciente;?></td>
                    <td><?=$value->convenio;?></td>
                    <td><?=$value->solicitante;?></td>
                    <td><?=date("d/m/Y ",strtotime($value->data_cadastro));?></td>
                    <td><?=$value->procedimento;?></td>
                    <td><?=$value->quantidade;?></td>

                 </tr>
            <?
            $i++;
            endforeach; 
            ?>
        </tbody>
        <tr>
            <td colspan="6"><b>TOTAL: <b><?=$i;?></b></b></td> 
            <!-- <td></td>  -->
        </tr>
            



    </table>
</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>