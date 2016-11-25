    <?php
    //Utilitario::pmf_mensagem($message);
    


    //unset($message);
    ?>
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ponto/horariostipo/novohorariosemiflexivel/<?=$horariotipo;?>">
            Nova Horario
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Horario Fixo</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Inicio</th>
                        <th class="tabela_header">Quantidade</th>
                        <th class="tabela_header">Entrada 1</th>
                        <th class="tabela_header">Sa&iacute;da 1</th>
                        <th class="tabela_header">Entrada 2</th>
                        <th class="tabela_header">Sa&iacute;da 2</th>
                        <th class="tabela_header">Entrada 3</th>
                        <th class="tabela_header">Sa&iacute;da 3</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada2; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida2; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada3; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida3; ?></td>

                           

                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o horario');"
                                       href="<?=base_url()?>ponto/horariostipo/excluirhorariosemiflexivel/<?=$item->horariosemiflexivel_id;?>/<?=$horariotipo;?>">
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
