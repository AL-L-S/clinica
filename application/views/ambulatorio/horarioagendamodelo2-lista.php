<?php
$imagem = $this->session->userdata('imagem');
$consulta = $this->session->userdata('consulta');
$especialidade = $this->session->userdata('especialidade');
$geral = $this->session->userdata('geral');
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
                        <th class="tabela_header">Sala</th>
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
                            <td class="<?php echo $estilo_linha; ?>">
                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/agenda/alterarsalahorarioagenda/<?= $item->horarioagenda_id; ?>/<?= $agenda; ?>/<?= $item->empresa_id; ?>/<?= $item->sala_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">
                                    => <?= $item->sala; ?>
                                </a>
                            </td>
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
    
    <br>
    <? if ( count($lista_agenda) > 0 ) {?>
        <div id="accordion">
            <div>
                <table>
                    <thead>
                        <tr>
                            <th colspan="5" style="font-size: 12pt; background-color: #ddd; text-align: center; font-weight: bold">AGENDAS CRIADAS</th>
                        </tr>
                        <tr>
                            <th class="tabela_header" width="800">Nome</th>
                            <th class="tabela_header" width="800">Médico</th>
                            <th class="tabela_header" colspan="3">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $i = 0;
                        $estilo_linha = "tabela_content01";
                        foreach ($lista_agenda as $item) {
                            $i++;
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->medico; ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <div class="bt_link_new">
                                        <form method="get" name="editaragenda<?= $i ?>" action="<?= base_url() ?>ambulatorio/agenda/editaragendacriada/<?=@ $agenda ?>" target="_blank">
                                            <input type="hidden" name="medico_id" value="<?= @$item->medico_id ?>"/>
                                            <input type="hidden" name="nome" value="<?= @$item->nome ?>"/>
                                            <input type="hidden" name="horario_id" value="<?=@ $agenda ?>"/>
                                            <a onclick="document.editaragenda<?= $i ?>.submit()">
                                                Editar
                                            </a>
                                        </form>
                                    </div>
                                </td>
                                <td  class="<?php echo $estilo_linha; ?>">
                                    <div class="bt_link_new">
                                        <form method="get" name="excluiragenda<?= $i ?>" action="<?= base_url() ?>ambulatorio/agenda/excluiragendascriadas/<?=@ $agenda ?>">
                                            <input type="hidden" name="medico_id" value="<?= @$item->medico_id ?>"/>
                                            <input type="hidden" name="nome" value="<?= @$item->nome ?>"/>
                                            <input type="hidden" name="horario_id" value="<?=@ $agenda ?>"/>
                                            <a onclick="javascript: if (confirm('Deseja realmente excluir essa agenda?') ) { document.excluiragenda<?= $i ?>.submit(); }">
                                                Excluir
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php
                    }
                    ?>


                    </tbody>
                </table>
            </div>
        </div>
    <? } ?>
    <br>
    
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    $(function () {
        $("#accordion2").accordion();
    });

</script>
