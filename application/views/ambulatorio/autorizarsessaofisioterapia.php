
<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">

        <h3 class="singular"><a href="#">Sessao Fisioterapia</a></h3>
        <div>

            <table>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" width="250px;">Nome</th>
                        <th class="tabela_header" width="250px;">Procedimento</th>
                        <th class="tabela_header" width="250px;">Convenio</th>
                        <th class="tabela_header" width="250px;">Sessao</th>
                        <th class="tabela_header" width="120px;" colspan="2"><center>A&ccedil;&otilde;es<div class="bt_link_new">
                                    <a href="<?= base_url() ?>ambulatorio/exame/cancelartodosfisioterapia/<?= $paciente_id ?>">Cancelar todos

                                    </a></div></center></th>
                </tr>
                </thead>

                <tbody>
                    <?php
                    
                    $estilo_linha = "tabela_content01";
                    foreach ($lista as $item) {

                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->numero_sessao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link_new">
                                    <a href="<?= base_url() ?>ambulatorio/exame/autorizarsessao/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->guia_id ?>">Encaminhar p/ Espera
                                    </a></div>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                    <a href="<?= base_url() ?>ambulatorio/exame/esperacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>">Cancelar

                                    </a></div>
                            </td>
                            <?
                        }
                        ?>
                    </tr>
                </tbody>
                <?php
                ?>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $("#accordion").accordion();
    });  

</script>
