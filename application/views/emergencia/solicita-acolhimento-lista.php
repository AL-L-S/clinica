<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Manter fila acolhimento</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title" colspan="6">
                            Lista de pacientes na fila de acolhimento
                <form method="get" action="<?php echo base_url() ?>emergencia/filaacolhimento/pesquisar">
                    Paciente<input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                    <button type="submit" name="enviar">Pesquisar</button>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header" width="100px;">Nascimento</th>
                    <th class="tabela_header" width="200px;">Data solicitacao</th>
                    <th class="tabela_header" width="100px;">Tempo</th>
                    <th class="tabela_header" colspan="2"  width="70px;"><center></center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->acolhimento->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->acolhimento->listar($_GET)->orderby('nascimento')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo substr($item->nascimento, 8, 2) . '/' . substr($item->nascimento, 5, 2) . '/' . substr($item->nascimento, 0, 4); ?></td>
                                <?php
                                // $dataSolicitacao = $item->datasolicitacao;
                                //   $horaSolicitacao = $item->horasolicitacao;
                                // $dataAtendida = $item->dataatendida;
                                //$quantidadeHoras = 0;
                                // if($item->horaatendida==''){
                                //hora sistema
                                //}
                                //else{
                                //   $quantidadeHoras = $horaAtendida - $horaSolicitacao;
                                //  if($quantidadeHoras<0){
                                //     $quantidadeHoras = $horaAtendida+24 -$horaSolicitacao;
                                //}
                                //}
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="200px;"><?php echo substr($item->data_cadastro, 8, 2) . '/' . substr($item->data_cadastro, 5, 2) . '/' . substr($item->data_cadastro, 0, 4) . ' ' . substr($item->data_cadastro, 11, 8); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"></td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                    <div class="bt_link_new">
                                        <a href="<?= base_url() ?>emergencia/filaacolhimento/novoacolhimento/<?= $item->paciente_id ?>/<?= $item->emergencia_solicitacao_acolhimento_id ?>">Acolhimento
                                        </a>
                                    </div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                    <div class="bt_link">
                                        <a onclick="javascript: return confirm('Deseja realmente excluir a triagem');"
                                           href="<?= base_url() ?>emergencia/triagem/cancelar/<?= $item->paciente_id ?>">
                                            Excluir
                                        </a>
                                    </div>

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
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
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