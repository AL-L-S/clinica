<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Lista Rae</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="6" class="tabela_title">
                            Lista Rae
                            <form name="form_busca" method="get" action="<?php echo base_url() ?>emergencia/emergencia/pesquisar">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">RAE</th>
                        <th class="tabela_header">Paciente</th>
                        <th class="tabela_header">Data de Nascimento</th>
                        <th class="tabela_header">Detalhes</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->acolhimento->listarrae($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->acolhimento->listarrae($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->emergencia_rae_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?$ano= substr($item->nascimento,0,4);?>
                                                            <?$mes= substr($item->nascimento,5,2);?>
                                                            <?$dia= substr($item->nascimento,8,2);?>
                                                            <?$datafinal= $dia . '/' . $mes . '/' . $ano; ?>
                                                            <?php echo$datafinal?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="200px;">
                                    <a href="<?php echo base_url() ?>emergencia/emergencia/evolucao/<?php echo $item->emergencia_rae_id ?>">
                                            Imprimir
                                    </a>
                                    <a href="<?php echo base_url() ?>emergencia/emergencia/pesquisarevolucao/<?php echo $item->emergencia_rae_id ?>">
                                        Atender
                                    </a>
                                    <?if ($item->ativo == true){?>
                                    <a href="<?php echo base_url() ?>emergencia/filaacolhimento/fecharRae/<?php echo $item->paciente_id ?>">
                                      Finalizar
                                    </a>
                                          <?}  ?>
                      
                            </td>
                        </tr>
                         </tbody>
                        <?php
                                }
                            }
                        ?>
                        <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
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
