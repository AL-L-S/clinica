
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/exame/novoagendaexame">
            Nova Agenda Exame
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Ageda Exames</a></h3>
        <div>
            <table border="1">
                <thead>

                    <tr>
                        <th class="tabela_header">

                            <a href="<?= base_url() ?>ambulatorio/exame/esquerda/<?= $diainicio ?>/<?= $agenda_exames_nome_id ?>">
                                <img border="0" title="Detalhes" alt="Detalhes"
                                     src="<?= base_url() ?>img/seta_esquerda.gif" />
                            </a></th>
                        <th class="tabela_header"><?php echo $diainicio; ?></th>
                        <th class="tabela_header"><?php echo $diainicio2 = date('d-m-Y', strtotime("+ 1 days", strtotime($diainicio))); ?></th>
                        <th class="tabela_header"><?php echo $diainicio3 = date('d-m-Y', strtotime("+ 1 days", strtotime($diainicio2))); ?></th>
                        <th class="tabela_header"><?php echo $diainicio4 = date('d-m-Y', strtotime("+ 1 days", strtotime($diainicio3))); ?></th>
                        <th class="tabela_header"><?php echo $diainicio5 = date('d-m-Y', strtotime("+ 1 days", strtotime($diainicio4))); ?></th>
                        <th class="tabela_header"><?php echo $diainicio6 = date('d-m-Y', strtotime("+ 1 days", strtotime($diainicio5))); ?></th>
                        <th class="tabela_header"><?php echo $diainicio7 = date('d-m-Y', strtotime("+ 1 days", strtotime($diainicio6))); ?></th>
                        <th class="tabela_header">
                            <a href="<?= base_url() ?>ambulatorio/exame/direita/<?= $diainicio ?>/<?= $agenda_exames_nome_id ?>">
                                <img border="0" title="Detalhes" alt="Detalhes"
                                     src="<?= base_url() ?>img/seta_direita.gif" />
                            </a></th>
                    </tr>
                </thead>

                <tbody>
                    <?
                    $estilo_linha = "tabela_content_agenda01";
                    $i = 0;
                    foreach ($repetidor as $item) {
                        ($estilo_linha == "tabela_content_agenda01") ? $estilo_linha = "tabela_content_agenda02" : $estilo_linha = "tabela_content_agenda01";
                        ?>
                        <tr class="<?php echo $estilo_linha; ?>">
                            <td ><?= $item->inicio; ?></td>
                            <td ><? if ($contadia1 == 0) {
                        echo '';
                    } else { ?><a href="<?= base_url() ?>ambulatorio/exame/pacienteexame/<?= $dia1["$i"]->agenda_exames_id ?>"><? echo $dia1["$i"]->situacao;
                    } ?></a></td>
                            <td ><? if ($contadia2 == 0) {
                        echo '';
                    } else { ?><a href="<?= base_url() ?>ambulatorio/exame/pacienteexame/<?= $dia2["$i"]->agenda_exames_id ?>"><? echo $dia2["$i"]->situacao;
                    } ?></a></td>
                            <td ><? if ($contadia3 == 0) {
                        echo '';
                    } elseif($dia3["$i"] != null) {?>
                                <a href="<?= base_url() ?>ambulatorio/exame/pacienteexame/<?= $dia3["$i"]->agenda_exames_id ?>"><? echo $dia3["$i"]->situacao;
                    } ?></a></td>
                            <td ><? if ($contadia4 == 0) {
                        echo '';
                    } else { ?><a href="<?= base_url() ?>ambulatorio/exame/pacienteexame/<?= $dia4["$i"]->agenda_exames_id ?>"><? echo $dia4["$i"]->situacao;
            } ?></a></td>
                            <td ><? if ($contadia5 == 0) {
                    echo '';
                } else { ?><a href="<?= base_url() ?>ambulatorio/exame/pacienteexame/<?= $dia5["$i"]->agenda_exames_id ?>"><? echo $dia5["$i"]->situacao;
                } ?></a></td>
                            <td ><? if ($contadia6 == 0) {
                    echo '';
                } else { ?><a href="<?= base_url() ?>ambulatorio/exame/pacienteexame/<?= $dia6["$i"]->agenda_exames_id ?>"><? echo $dia6["$i"]->situacao;
                } ?></a></td>
                            <td ><? if ($contadia7 == 0) {
                    echo '';
                } else { ?><a href="<?= base_url() ?>ambulatorio/exame/pacienteexame/<?= $dia7["$i"]->agenda_exames_id ?>"><? echo $dia7["$i"]->situacao;
                } ?></a></td>
                            <td ><?= $i; ?></td>
                        </tr>


                    </tbody>
    <?
    $i++;
}
?>

                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>
