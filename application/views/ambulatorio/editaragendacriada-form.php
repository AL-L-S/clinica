<?php
//Utilitario::pmf_mensagem($message);
//unset($message);
?>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Editar Agenda Horarios</a></h3>
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
                    foreach ($horarios as $item) {
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



<!--                            <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                <a 
                                    href="<?= base_url() ?>ambulatorio/agenda/carregarexclusaohorario/<?= $item->horarioagenda_id; ?>/<?= $horario_id; ?>">
                                    <img border="0" title="Excluir" alt="Excluir"
                                         src="<?= base_url() ?>img/form/page_white_delete.png" />
                                </a>
                            </td>-->
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

    $(function () {
        $("#accordion").accordion();
    });
    $(function () {
        $("#accordion2").accordion();
    });

</script>
