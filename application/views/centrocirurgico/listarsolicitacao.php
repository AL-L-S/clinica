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
                        <th class="tabela_title" colspan="4">
                            Lista de Solicitacoes
                            <form method="get" action="<?php echo base_url() ?>centrocirurgico/centrocirurgico/pesquisar">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" name="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Paciente</th>
                        <th class="tabela_header">Médico</th>
                        <th class="tabela_header">Convenio</th>
                        <th class="tabela_header">Situação</th>
                       <!--<th class="tabela_header">Data Prevista</th>-->
                        <th class="tabela_header" width="30px;" colspan="6"><center></center></th>
<!--                <th class="tabela_header" width="30px;"><center></center></th>
                <th class="tabela_header" width="30px;"><center></center></th>-->

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
                        $lista = $this->centrocirurgico_m->listarsolicitacoes2($_GET)->orderby('p.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $situacao = '';
                            if ($item->situacao == 'ABERTA') {
                                $situacao = "<font color='blue'>ABERTA";
                            } 
                            elseif ($item->situacao == 'LIBERADA') {
                                $situacao = "<font color='green'>LIBERADA";
                            } 
                            elseif ($item->situacao == 'ORCAMENTO_INCOMPLETO' && $item->orcamento == 't') {
                                $situacao = "<font color='red'>ORÇAMENTO INCOMPLETO";
                            } 
                            elseif ($item->situacao == 'ORCAMENTO_COMPLETO'  && $item->orcamento == 't') {
                                $situacao = "<font color='green'>ORÇAMENTO COMPLETO";
                            } 
                            elseif ($item->situacao == 'EQUIPE_MONTADA') {
                                $situacao = "<font color='green'>EQUIPE MONTADA";
                            }

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->medico; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $situacao; ?></td>
                                <? if ($item->situacao != 'ABERTA' && $item->situacao == 'EQUIPE_MONTADA') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/mostraautorizarcirurgia/<?= $item->solicitacao_cirurgia_id; ?>">Autorizar</a></div>
                                    </td> 
                                <? } ?>
                                <? if ($item->situacao != 'ABERTA' && $item->situacao == 'ORCAMENTO_COMPLETO' && $item->situacao != 'EQUIPE_MONTADA') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/montarequipe/<?= $item->solicitacao_cirurgia_id; ?>">Equipe</a></div>
                                    </td> 
                                <? } ?>
                                <? if ($item->situacao != 'ORCAMENTO_COMPLETO' && $item->orcamento == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/solicitacarorcamento/<?= $item->solicitacao_cirurgia_id; ?>/<?= $item->convenio_id; ?>">Orçamento</a></div>
                                    </td> 
                                <? } ?>
                                <? if (($item->situacao != 'ABERTA' && $item->situacao == 'ORCAMENTO_COMPLETO') || $item->situacao == 'EQUIPE_MONTADA') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                            <a  href="<?= base_url() ?>centrocirurgico/centrocirurgico/impressaoorcamento/<?= $item->solicitacao_cirurgia_id; ?>">Imprimir</a></div>
                                    </td>
                                <? } ?>
                                <? if ($item->situacao != 'ORCAMENTO_COMPLETO' && $item->situacao != 'EQUIPE_MONTADA') { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/carregarsolicitacao/<?= $item->solicitacao_cirurgia_id; ?>">Cadastrar</a></div>
                                    </td>
                                <? } ?>
<!--                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluirsolicitacaocirurgia/<?= $item->solicitacao_cirurgia_id; ?>">Editar</a></div>
                                </td> -->
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
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
                        <th class="tabela_footer" colspan="10">
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
