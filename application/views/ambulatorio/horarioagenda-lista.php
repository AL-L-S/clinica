<?php
//Utilitario::pmf_mensagem($message);
//unset($message);
?>
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/agenda/novohorarioagenda/<?= $agenda; ?>">
                        Novo Horario
                    </a>
                </div>  
            </td>
            <td>
                <div class="bt_link_new" style="width: 250px">
                    <a style="width: 250px" href="<?php echo base_url() ?>ambulatorio/exame/novoagendaexame/<?= $agenda; ?>" target="_blank">
                        Consolidar Agenda Exame
                    </a>
                </div> 
            </td>
            <td>
                <div class="bt_link_new" style="width: 250px">
                    <a style="width: 250px" href="<?php echo base_url() ?>ambulatorio/exame/novoagendaconsulta/<?= $agenda; ?>" target="_blank">
                        Consolidar Agenda Consulta
                    </a>
                </div> 
            </td>
            <td>
                <div class="bt_link_new" style="width: 300px">
                    <a href="<?php echo base_url() ?>ambulatorio/exame/novoagendaespecializacao/<?= $agenda; ?>" style="width: 300px" target="_blank">
                        Consolidar Agenda Especializacao
                    </a>
                </div> 
            </td>
        </tr>
    </table>


    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Horario Fixo</a></h3>
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
                    foreach ($lista as $item) {
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
                                <a 
                                    href="<?= base_url() ?>ambulatorio/agenda/carregarexclusaohorario/<?= $item->horarioagenda_id; ?>/<?= $agenda; ?>">
                                    <img border="0" title="Excluir" alt="Excluir"
                                         src="<?= base_url() ?>img/form/page_white_delete.png" />
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
    <!--<br>-->
    <br>
<!--    <div id="accordion2">
        <h3 class="singular"><a href="#">Agendas Criadas A Partir Desse(s) Horário(s)</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" colspan="2">Agenda</th>
                        <th class="tabela_header"></th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    $estilo_linha = "tabela_content01";
                    foreach ($lista_agenda as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->horarioagenda_id; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>



                            <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                <div class="bt_link">
                                    <a href="<?= base_url() ?>ambulatorio/agenda/carregar/<?= $item->horarioagenda_id ?>" target="_blank">
                                        Excluir
                                    </a>
                                </div>

                            </td>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                <div class="bt_link">
                                    <a href="<?= base_url() ?>ambulatorio/agenda/carregar/<?= $item->horarioagenda_id ?>" target="_blank">
                                        Editar
                                    </a>
                                </div>

                            </td>
                        </tr>

                    </tbody>
                    <?php
                }
                ?>

            </table>
        </div>
    </div>-->

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    $(function () {
        $("#accordion2").accordion();
    });

</script>
