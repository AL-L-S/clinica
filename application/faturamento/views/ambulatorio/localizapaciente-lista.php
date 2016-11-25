
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr><td width="60px;"><center>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>cadastros/pacientes/novo">
                        Novo Paciente
                    </a></center>
                </div>
            </td>
        <td width="60px;"><center>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/exametemp/novo">
                        Marcar consulta
                    </a></center>
                </div>
        </td>
        </table>
                <div id="accordion">
                    <h3 class="singular"><a href="#">Pacientes</a></h3>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="5" class="tabela_title">
                            <form action="<?= base_url() ?>ambulatorio/localizapaciente/pesquisar" method="post">
                                <input type="text" name="nome" class="texto10 bestupper"/>
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                            </th>
                            </tr>
                            <tr>
                                <th class="tabela_header" colspan="7"><center>Pacientes Definitivos<center></th>
                                    </tr>
                                    <tr>
                                        <th class="tabela_header">Nome</th>
                                        <th class="tabela_header">Idade</th>
                                        <th class="tabela_header">Fone</th>
                                        <th class="tabela_header" colspan="2"  width="70px;">Detalhes</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    if ($totaldefinitivo > 0) {
                                        ?>
                                        <tbody>
                                            <?php
                                            $estilo_linha = "tabela_content01";
                                            foreach ($definitivo as $item) {
                                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                                ?>
                                                <tr>
                                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->idade; ?></td>
                                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->celular . ' / ' . $item->telefone; ?></td>



                                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                                        <a href="<?= base_url() ?>ambulatorio/localizapaciente/carregarlocalizapaciente/<?= $item->paciente_id; ?>">Editar</a>
                                                    </td>
                                                    <td class="<?php echo $estilo_linha; ?>" width="50px;">     
                                                        <a href="<?= base_url() ?>cadastros/pacientes/pesquisarsubstituir/<?= $item->paciente_id ?>">Confirmar</a>
                                                    </td>
                                                </tr>

                                            </tbody>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <tfoot>
                                        <tr>
                                            <th class="tabela_footer" colspan="6">
                                                Total de registros: <?php echo $totaldefinitivo; ?>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    </table>
                                    <br>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="tabela_header" colspan="7"><center>Pacientes Temporarios<center></th>
                                                </tr>
                                                <tr>
                                                    <th class="tabela_header">Nome</th>
                                                    <th class="tabela_header">Idade</th>
                                                    <th class="tabela_header">Fone</th>
                                                    <th class="tabela_header" colspan="2"  width="70px;">Detalhes</th>
                                                </tr>
                                                </thead>
                                                <?php
                                                if ($totaltemp > 0) {
                                                    ?>
                                                    <tbody>
                                                        <?php
                                                        $estilo_linha = "tabela_content01";
                                                        foreach ($listatemp as $item) {
                                                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                                            ?>
                                                            <tr>
                                                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                                                <td class="<?php echo $estilo_linha; ?>"><?= $item->idade; ?></td>
                                                                <td class="<?php echo $estilo_linha; ?>"><?= $item->celular . ' / ' . $item->telefone; ?></td>



                                                                <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                                                    <a href="<?= base_url() ?>ambulatorio/exametemp/carregarexametemp/<?= $item->ambulatorio_pacientetemp_id; ?>">Editar</a>
                                                                </td>
                                                                <td class="<?php echo $estilo_linha; ?>" width="50px;">     
                                                                    <a href="<?= base_url() ?>cadastros/pacientes/pesquisarsubstituir/<?= $item->ambulatorio_pacientetemp_id ?>">Confirmar</a>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <tfoot>
                                                    <tr>
                                                        <th class="tabela_footer" colspan="6">
                                                            Total de registros: <?php echo $totaltemp; ?>
                                                        </th>
                                                    </tr>
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
