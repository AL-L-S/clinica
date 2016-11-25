
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <thead>
            <tr>
                <th >        <div class="bt_link_new">
            <a href="<?php echo base_url() ?>ambulatorio/exame/novoagendaexame" target="_blank">
                Nova Agenda Exame
            </a>
        </div></th>

        <th >                <div class="bt_link_new">
            <a href="<?php echo base_url() ?>ambulatorio/exame/novoagendaconsulta" target="_blank">
                Nova Agenda Consulta
            </a>
        </div></th>

        <th > <div class="bt_link_new" style="width: 180px">
            <a href="<?php echo base_url() ?>ambulatorio/exame/novoagendaespecializacao" style="width: 180px" target="_blank">
                Nova Agenda Especializacao
            </a>
        </div></th>
        
        </tr>


    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Agenda</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/pesquisar">
                    <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                    <button type="submit" id="enviar">Pesquisar</button>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Detalhes</th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = $limite_paginacao;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        if($limit != "todos"){
                            $lista = $this->exame->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                        } else {
                            $lista = $this->exame->listar($_GET)->orderby('nome')->get()->result();

                        }
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>

<!--                                <td class="<?php echo $estilo_linha; ?>" width="100px;">

                                    <a href="<?= base_url() ?>ambulatorio/exame/listaragendaexame/<?= $item->agenda_exames_nome_id ?>">
                                        <img border="0" title="Detalhes" alt="Detalhes"
                                             src="<?= base_url() ?>img/form/page_white_edit.png" />
                                    </a>
                                </td>-->
                                <td class="<?php echo $estilo_linha; ?>" width="50px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o horario <?= $item->nome; ?>');"
                                       href="<?= base_url() ?>ambulatorio/exame/excluiragenda/<?= $item->agenda_exames_nome_id; ?>">
                                        delete
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
                        <th class="tabela_footer" colspan="6">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                            <div style="display: inline">
                                        <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                                        <select style="width: 50px">
                                            <option onclick="javascript:window.location.href=('<?= base_url()?>ambulatorio/exame/pesquisar/10');" <? if($limit == 10){ echo "selected"; } ?>> 10 </option>
                                            <option onclick="javascript:window.location.href=('<?= base_url()?>ambulatorio/exame/pesquisar/50');" <? if($limit == 50){ echo "selected"; } ?>> 50 </option>
                                            <option onclick="javascript:window.location.href=('<?= base_url()?>ambulatorio/exame/pesquisar/100');" <? if($limit == 100){ echo "selected"; } ?>> 100 </option>
                                            <option onclick="javascript:window.location.href=('<?= base_url()?>ambulatorio/exame/pesquisar/todos');" <? if($limit == "todos"){ echo "selected"; } ?>> Todos </option>
                                        </select>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

                                        $(function() {
                                            $("#accordion").accordion();
                                        });

</script>
