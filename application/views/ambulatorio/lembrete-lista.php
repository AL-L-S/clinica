<? $operadores = $this->operador->listaroperadoreslembrete(); ?>
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>ambulatorio/empresa/carregarlembrete/0">
            Novo Lembrete
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Lembretes</a></h3>
        <div>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/empresa/pesquisarlembrete">
                    <tr>
                        <th class="tabela_title">Operador</th>
                        <th class="tabela_title">Texto</th>
                        <th class="tabela_title"></th>
                    </tr>

                    <tr>
                        <th class="tabela_title">
                            <select name="operador_id" id="operador_id" class="size2">
                                <option value="">TODOS</option>
                                <? foreach ($operadores as $value) : ?>
                                    <option value="<?= $value->operador_id; ?>" 
                                            <? if (@$_GET['operador_id'] == $value->operador_id) echo 'selected' ?>>
                                                <?php echo $value->nome; ?>
                                    </option>
                                <? endforeach; ?>
                            </select>
                        </th>

                        <th class="tabela_title" colspan="3">
                            <input type="text"  id="texto" name="texto" class="texto10" value="<?php echo @$_GET['texto']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>

                </form>

                <tr>
                    <th class="tabela_header">Operador</th>
                    <th class="tabela_header">Texto</th>
                    <th class="tabela_header">Status</th>
                    <th class="tabela_header"></th>
                    <th class="tabela_header" colspan="3"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), @$_GET);
                $consulta = $this->empresa->listarlembretes(@$_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->empresa->listarlembretes($_GET)->limit($limit, $pagina)->orderby("ativo DESC, nome")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->operador; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->texto; ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <?
                                    if($item->visualizado != 0){
                                        echo "Visualizado";
                                    } else{
                                        echo "Nao visualizado";
                                    }
                                    ?>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <? 
                                    if($item->ativo != 't'){
                                        echo "Excluido";
                                    }
                                    ?>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>" colspan="3"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/empresa/excluirlembrete/<?= $item->empresa_lembretes_id ?>">Excluir</a></div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="8">
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
