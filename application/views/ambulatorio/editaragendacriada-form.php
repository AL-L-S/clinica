<?php
//Utilitario::pmf_mensagem($message);
//unset($message);
?>
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <form method="get" name="novohorarioagenda" action="<?php echo base_url() ?>ambulatorio/agenda/novohorarioagendacriada/<?= $horario_id; ?>">
                        <input type="hidden" name="medico_id" value="<?= @$_GET['medico_id'] ?>"/>
                        <input type="hidden" name="nome" value="<?= @$_GET['nome'] ?>"/>
                        <a onclick="document.novohorarioagenda.submit()">
                            Novo Horario
                        </a>
                    </form>
                </div>
            </td>
        </tr>
    </table>
    <div id="accordion">
        <? if ( count($horarios) > 0 ) { ?>
            <h3><a href="#">Editar Agenda Horarios</a></h3>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Entrada 1</th>
                            <th class="tabela_header">Sa&iacute;da 1</th>
                            <th class="tabela_header">Inicio intervalo</th>
                            <th class="tabela_header">Fim do intervalo</th>
                            <th class="tabela_header">Tempo consulta</th>
                            <th class="tabela_header">Obs</th>
                            <th class="tabela_header">Empresa</th>
                            <th class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $estilo_linha = "tabela_content01";
                        $i = 0;
                        foreach ($horarios as $item) {
                            $i++;
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->dia; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->intervaloinicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->intervalofim; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tempoconsulta; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <div class="bt_link_new">
                                        <form method="get" name="excluirhorarioagenda<?= $i ?>" action="<?= base_url() ?>ambulatorio/agenda/excluirhorarioagendacriada/<?=@ $horario_id ?>">
                                            <input type="hidden" name="medico_id" value="<?= @$_GET['medico_id'] ?>"/>
                                            <input type="hidden" name="nome" value="<?= @$_GET['nome'] ?>"/>
                                            <!--<input type="hidden" name="agenda_id" value="<?=@ $agenda ?>"/>-->
                                            <input type="hidden" name="horario_id" value="<?=@ $item->horarioagenda_id ?>"/>
                                            <a onclick="document.excluirhorarioagenda<?= $i ?>.submit()">
                                                Excluir
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                    ?>

                </table>
            </div>
        <? } 
        if ( count($horarios_consolidados) > 0 ) { ?>
            <h3><a href="#">Novos horarios consolidados</a></h3>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Entrada 1</th>
                            <th class="tabela_header">Sa&iacute;da 1</th>
                            <th class="tabela_header">Inicio intervalo</th>
                            <th class="tabela_header">Fim do intervalo</th>
                            <th class="tabela_header">Tempo consulta</th>
                            <th class="tabela_header">Obs</th>
                            <th class="tabela_header">Empresa</th>
                            <th class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $estilo_linha = "tabela_content01";
                        $i = 0;
                        foreach ($horarios_consolidados as $item) {
                            $i++;
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->dia; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->intervaloinicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->intervalofim; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tempoconsulta; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <div class="bt_link_new">
                                        <form method="get" name="excluirhorarioagendaconsolidado<?= $i ?>" action="<?= base_url() ?>ambulatorio/agenda/excluirhorarioagendaconsolidada/<?=@ $horario_id ?>">
                                            <input type="hidden" name="medico_id" value="<?= @$_GET['medico_id'] ?>"/>
                                            <input type="hidden" name="nome" value="<?= @$_GET['nome'] ?>"/>
                                            <!--<input type="hidden" name="agenda_id" value="<?=@ $agenda ?>"/>-->
                                            <input type="hidden" name="horario_id" value="<?=@ $item->horarioagenda_editada_id ?>"/>
                                            <a onclick="document.excluirhorarioagendaconsolidado<?= $i ?>.submit()">
                                                Excluir
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                    ?>

                </table>
            </div>
        <? } ?>
    </div>
    
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    $(function () {
        $("#accordion2").accordion();
    });

</script>
