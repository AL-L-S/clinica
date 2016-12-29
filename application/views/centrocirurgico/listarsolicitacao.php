<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>centrocirurgico/centrocirurgico/novasolicitacao/0">
                        Nova Solicitacao
                    </a>
            </div>
        </tr>
        </table>
    <div id="accordion">
        <h3><a href="#">Manter Solicitacoes</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title" colspan="5">
                            Lista de Solicitacoes
                <form method="get" action="<?php echo base_url() ?>centrocirurgico/centrocirurgico/pesquisar">
                    <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                    <button type="submit" name="enviar">Pesquisar</button>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Procedimento</th>
                    <th class="tabela_header" width="30px;" colspan="3"><center></center></th>

                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->centrocirurgico_m->listarsolicitacoes($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->centrocirurgico_m->listarsolicitacoes($_GET)->orderby('p.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo str_replace('-','/', date( 'd-m-Y', strtotime($item->data_prevista) ) ); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link" style="width: 70px;">
                                        <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/autorizarcirurgia/<?= $item->solicitacao_cirurgia_id; ?>" >Autorizar</a></div>
                                </td>                                 
                                <td class="<?php echo $estilo_linha; ?>" width="170px;"><div class="bt_link" style="width: 170px;">
                                    <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/solicitacarorcamento/<?= $item->solicitacao_cirurgia_id; ?>" style="width: 150px;">Solicitar Orçamento</a></div>
                                </td>                                 
                                <td class="<?php echo $estilo_linha; ?>" width="70px;" ><div class="bt_link" style="width: 70px;">
                                    <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluirsolicitacaocirurgia/<?= $item->solicitacao_cirurgia_id; ?>">Excluir</a></div>
                                </td>                              
                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="7">
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