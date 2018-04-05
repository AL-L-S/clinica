<div class="content"> <!-- Inicio da DIV content -->
    <meta charset="utf8"/>
    <? if (count($empresa) > 0) { ?>
        <h3><?= $empresa[0]->razao_social; ?></h3>
    <? } ?>
    <? if ($grupo == "0") { ?>
        <h3>GRUPO: TODOS</h3>
    <? } elseif ($grupo == "1") { ?>        
        <h3>GRUPO: SEM RM</h3>
    <? } else { ?>             
        <h3>GRUPO: <?= $grupo; ?></h3>
    <? } ?>

    <? if (count($relatorio) > 0) {
        ?>
        <table border="1" cellpadding="3" cellspacing="0">
            <thead>
                <tr>
                    <th class="tabela_teste" >Codigo</th>
                    <th class="tabela_teste" >Nome</th>
                    <th class="tabela_teste" >Descricao</th>
                    <th class="tabela_teste" >Grupo</th>
                    <th class="tabela_teste" >Perc. Medico</th>
                    <th class="tabela_teste" >Perc. Revisor</th>
                    <th class="tabela_teste" >Qtde</th>
                    <th class="tabela_teste" >Prazo Entrega</th>
                    <th class="tabela_teste" >HOME CARE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($relatorio as $item) :
                    ?>
                    <tr>
                        <td><?= $item->codigo; ?></td>
                        <td><?= $item->nome; ?></td>
                        <td><?= $item->descricao; ?></td>
                        <td><?= $item->grupo; ?></td>
                        <td style="text-align: right"><? 
                            if($item->perc_medico != ''){
                                if($item->percentual == 't'){
                                    echo $item->perc_medico . " %";
                                }
                                else{
                                    echo "R$ ".$item->perc_medico;
                                }
                            }
                        ?>
                        </td>
                        <td style="text-align: right"><? 
                            if($item->valor_revisor != ''){
                                if($item->percentual_revisor == 't'){
                                    echo $item->valor_revisor . " %";
                                }
                                else{
                                    echo "R$ ".$item->valor_revisor;
                                }
                            }
                        ?>
                        </td>
                        <td style="text-align: right"><?= $item->qtde; ?></td>
                        <td style="text-align: right"><?= $item->entrega; ?> Dia(s)</td>
                        <td style="text-align: right"><?= ($item->home_care == 't')? "SIM": "NÃO"; ?></td>

                    </tr>


                <? endforeach; ?>
            </tbody>
        </table>   
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
    <? }
    ?>


</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>