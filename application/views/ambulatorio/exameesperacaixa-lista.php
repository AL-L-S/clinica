
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Fila Caixa</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $medicos = $this->operador_m->listarmedicos();
            ?>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title">Nome</th>
                    </tr>
                    <tr>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listaresperacaixa">
                    <th colspan="2" class="tabela_title">
                        <input type="text" name="nome" class="texto07" value="<?php echo @$_GET['nome']; ?>" />
                    </th>
                    <th class="tabela_title">
                        <button type="submit" id="enviar">Pesquisar</button>
                    </th>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Valor</th>
                    <th class="tabela_header"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                
                $empresa_id = $this->session->userdata('empresa_id');
                $empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarexamecaixaespera(0, $_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                $contador_tot = 0;
                $grupo_pagamento = $this->formapagamento->listargrupos();
                foreach ($grupo_pagamento as $grupo) {
                    $lista_cont = $this->exame->listarexamecaixaespera($grupo->financeiro_grupo_id, $_GET)->groupby('g.ambulatorio_guia_id, p.nome, ae.paciente_id, g.data_criacao')->orderby('g.data_criacao')->get()->result();
                    $contador_tot = $contador_tot + count($lista_cont);
                }

                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $perfil_id = $this->session->userdata('perfil_id');
                        $forma_pagamento = $this->guia->formadepagamento();
                        $lista = $this->exame->listarexamecaixaespera($_GET)->limit($limit, $pagina)->groupby('g.ambulatorio_guia_id, p.nome, ae.paciente_id, g.data_criacao')->orderby('g.data_criacao')->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            $guia_id = $item->ambulatorio_guia_id;
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valortotal, 2, ',', '.') ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                    <?  if ($empresapermissoes[0]->ajuste_pagamento_procedimento != 't') { ?>
                                        <div class="bt_linkf">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarprocedimentos/" . $guia_id; ?> ');">Faturar Guia</a>
                                        </div>
                                    <? } else { ?>
                                        <div class="bt_linkf">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarprocedimentospersonalizados/" . $guia_id; ?> ', '_blank', 'width=800,height=600');">Faturar Procedimentos</a>
                                        </div>
                                    <? } ?>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                        }
                    
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="4">
                                <?php $this->utilitario->paginacao($url, $contador_tot, $pagina, $limit); ?>
                                Total de registros: <?php echo $contador_tot; ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            <? }
            ?>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>
