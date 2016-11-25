<div class="content"> <!-- Inicio da DIV content -->
    <div>
        <a href="<?php echo base_url() ?>sca/ambulancia/novo">
            Nova Ambulância
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Relação de entrada de Ambulâncias - Instituto Dr. José Frota</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="9" class="tabela_title">
                            Lista de Ambulâncias
                            <form name="form_busca" method="get" action="<?= base_url() ?>sca/ambulancia/pesquisar">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Placa</th>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Hora</th>
                        <th class="tabela_header">Cidade</th>
                        <th class="tabela_header">Estado</th>
                        <th class="tabela_header">Paciente</th>
                        <th class="tabela_header">Motorista</th>
                        <th class="tabela_header">Vigilante</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->ambulancia_m->listarCadastros($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                      <?php
                        $lista = $this->ambulancia_m->listarCadastros($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->placa; ?></td>

                                <td class="<?php echo $estilo_linha; ?>"><?$ano= substr($item->data,0,4);?>
                                                            <?$mes= substr($item->data,5,2);?>
                                                            <?$dia= substr($item->data,8,2);?>
                                                            <?$datafinal= $dia . '/' . $mes . '/' . $ano; ?>
                                                            <?=$datafinal?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>"><?$hora= substr($item->hora,0,2); ?>
                                                            <?$minuto= substr($item->hora,3,2); ?>
                                                            <?$horafinal = $hora . ':' . $minuto;?>
                                                            <?=$horafinal?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->cidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->estado; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->motorista; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                            <a onclick="javascript: return confirm('Deseja realmente exlcuir esse registro?');"
                               href="<?=  base_url()?>sca/ambulancia/excluir/<?=$item->ambulancia_id?>">
                                <img border="0" title="Excluir" alt="Detalhes"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
                            </a>
                        </td>
                                    

                        </tr>
    
          
                        </tbody>
                <?php
                        }
                    }
                ?>
                        <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="9">
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
