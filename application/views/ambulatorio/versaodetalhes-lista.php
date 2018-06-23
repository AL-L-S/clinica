<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Vers&atilde;o Detalhes</a></h3>
        <div>
            <table>
                <thead>

                    <tr>
                        <th class="tabela_header">Versão</th>
                        <th class="tabela_header">Alteração</th>
                        <th class="tabela_header">Chamado</th>
                    </tr>
                </thead>
                <?php
                if (count($lista) > 0) {
                    ?>
                    <tbody>
                        <?php
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->versao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->alteracao; ?></td>                                                    
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->chamado; ?></td>                                                    


                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="6">

                            Total de registros: <?php echo count($lista); ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>



