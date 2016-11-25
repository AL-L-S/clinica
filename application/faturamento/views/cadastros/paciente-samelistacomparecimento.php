<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3><a href="#">Lista de interna&ccedil;&otilde;es</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Data interna&ccedil;&atilde;o</th>
                        <th class="tabela_header">M&eacute;dico responsavel</th>
                        <th class="tabela_header"><center></center></th>
                        
                    </tr>
                </thead>

                <tbody>
                    <?php
//                    echo "<pre>";
//                    var_dump($lista);
//                    echo "</pre>";
//                    die;
                    $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item['IB6NOME']; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?php echo substr($item['D15INTER'],7,2) . "/" . substr($item['D15INTER'],5,2) . "/" . substr($item['D15INTER'],1,4); ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item['IC0NOME']; ?></td>
                        <td class="<?php echo $estilo_linha; ?>">
                                    <a href="<?= base_url() ?>cadastros/pacientes/samecomparecimento/<?= $item['IB6REGIST'] ?>/<?= $item['D15INTER'] ?>"><center>
                                        <img border="0" title="Relatorio de comparecimento" alt="Detalhes"
                                             src="<?= base_url() ?>img/form/page_white_edit.png" />
                                        </center></a>
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
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
   
    $(function() {
        $( "#accordion" ).accordion();
    });

</script>