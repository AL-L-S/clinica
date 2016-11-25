     <?php
    //Utilitario::pmf_mensagem($message);
    


    //unset($message);
    ?>
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ponto/horariostipo/novohorarioindividual/<?=$funcionario_id;?>">
            Nova Plantao
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Plantao</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Entrada padrao</th>
                        <th>Saida padrao</th>
                        <th>Entrada extra</th>
                        <th>Saida extra</th>
                        <th>Entrada extensao</th>
                        <th>saida extensao</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data,8,2) . '/' . substr($item->data,5,2) . '/' . substr($item->data,0,4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada2; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida2; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada3; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida3; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacao; ?></td>

                           

                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o horario');"
                                       href="<?=base_url()?>ponto/horariostipo/excluirhorarioindividual/<?=$item->horarioindividual_id;?>/<?=$funcionario_id;?>">
                                        <img border="0" title="Excluir" alt="Excluir"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
                                    </a>
                            </td>
                        </tr>

                        </tbody>
                        <?php
                                }
                            
                        ?>

            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>
