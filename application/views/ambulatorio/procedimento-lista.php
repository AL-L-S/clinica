

<div class="content"> <!-- Inicio da DIV content -->
    <table border="0">
        <tr>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/procedimento/carregarprocedimento/0">
                        Novo Procedimento
                    </a>
                </div>
            </td>
            <? $geral = $this->session->userdata('geral'); 
            if ($geral == 't') {?>
                <td>
                    <div class="bt_link_new">
                        <a href="<?php echo base_url() ?>ambulatorio/procedimento/carregaragrupadorprocedimento/0">
                            Novo Agrupador
                        </a>
                    </div>
                </td>
            <? } ?>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/procedimento/carregarajustevalores">
                        Ajustar Valores
                    </a>
                </div>
            </td>
<!--            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/procedimento/procedimentolaboratorio">
                        Laboratorio Proc.
                    </a>
                </div>
            </td>-->
        </tr>
    </table>

    <?
    $perfil_id = $this->session->userdata('perfil_id');
    ?>

    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Procedimento</a></h3>
        <div>
             <?
             $grupo = $this->procedimento->listargrupos(); 
             $subgrupo = $this->grupoclassificacao->listarsubgrupo2();
             ?>
            <table>
                <thead>
                     <!-- <tr>
                        <th colspan="6" class="tabela_title">
                    </tr> -->
                <form method="get" action="<?= base_url() ?>ambulatorio/procedimento/pesquisar">
                    <tr>
                        <th class="tabela_title" style="width: 300px;">Nome</th>
                        <th class="tabela_title" style="width: 200px;">Grupo</th>   
                        <th class="tabela_title" style="width: 100px;">Subgrupo</th>   
                        <th class="tabela_title"></th>  
                        <th colspan="1" class="tabela_title">Codigo</th>
                        <th colspan="1" class="tabela_title">Descrição</th>
                       
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <input type="text" name="nome" class="texto03" value="<?php echo @$_GET['nome']; ?>" />
                        </th>
                        
                        <th class="tabela_title">
                            <select name="grupo" id="grupo" class="size1">
                                <option value="">Selecione</option>
                                <? foreach ($grupo as $value) : ?>
                                    <option value="<?= $value->nome; ?>"
                                        <? if (@$_GET['grupo'] == $value->nome) echo 'selected'?>>
                                    <?= $value->nome; ?>
                                    </option>
                                <? endforeach; ?>

                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="subgrupo" id="subgrupo" class="size1">
                                <option value="">Selecione</option>
                                <? foreach ($subgrupo as $value) : ?>
                                    <option value="<?= $value->ambulatorio_subgrupo_id; ?>"
                                        <? if (@$_GET['subgrupo'] == $value->ambulatorio_subgrupo_id) echo 'selected'?>>
                                    <?= $value->nome; ?>
                                    </option>
                                <? endforeach; ?>

                            </select>
                        </th>
                        <th class="tabela_title">
                            
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="codigo" class="texto02" value="<?php echo @$_GET['codigo']; ?>" />
                        </th>
                        
                        <th class="tabela_title">
                            <input type="text" name="descricao" class="texto03" value="<?php echo @$_GET['descricao']; ?>" />
                        </th>
                        
                        <th class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                        
                    </tr>
            </table>
            <table>
                    <tr>
                        <th class="tabela_header" width="40%">Nome</th>
                        <th class="tabela_header" width="10%">Grupo</th>
                        <th class="tabela_header" width=""></th>
                        <? 
                        $subgrupo_procedimento = $this->session->userdata('subgrupo_procedimento');
                        if($subgrupo_procedimento == 't') { 
                            ?>
                            <th class="tabela_header" width="20%">Subgrupo</th>
                        <? } ?>
                        <th class="tabela_header" width="10%">Codigo</th>
                        <th class="tabela_header" width="25%">Descri&ccedil;&atilde;o</th>
                        <th style="text-align: center;" colspan="3" class="tabela_header">Detalhes</th>
                    </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->procedimento->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = $limite_paginacao;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        if ($limit != "todos") {
                            $lista = $this->procedimento->listar($_GET)->orderby('grupo')->orderby('nome')->limit($limit, $pagina)->get()->result();
                        } else {
                            $lista = $this->procedimento->listar($_GET)->orderby('grupo')->orderby('nome')->get()->result();
                        }
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><? if($item->agrupador == 't'){ echo "AGRUPADOR";}?></td>
                                <? $subgrupo_procedimento = $this->session->userdata('subgrupo_procedimento');
                                if($subgrupo_procedimento == 't') { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->subgrupo; ?></td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?> "><?= $item->codigo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>

                                <? if($item->agrupador != 't') { ?>
                                    <? if ($perfil_id != 10) { ?>
                                        <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                                <a style="cursor: pointer;" onclick="javascript: return confirm('Deseja realmente excluir o procedimento');" href="<?= base_url() . "ambulatorio/procedimento/excluir/$item->procedimento_tuss_id"; ?>"
                                                   >Excluir
                                                </a>
                                            </div>
                <!--                                    href="<?= base_url() ?>seguranca/operador/excluirOperador/<?= $item->operador_id; ?>"-->
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                                <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimento/carregarprocedimento/$item->procedimento_tuss_id"; ?> ', '_blank');">Editar
                                                </a></div>
                    <!--                                        href="<?= base_url() ?>seguranca/operador/alterar/<?= $item->operador_id ?>"-->
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                                <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/procedimento/procedimentoconveniovalor/$item->procedimento_tuss_id"; ?> ', '_blank');">Convênio
                                                </a></div>
                    <!--                                        href="<?= base_url() ?>seguranca/operador/alterar/<?= $item->operador_id ?>"-->
                                        </td>

                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                                Excluir
                                            </div>
                <!--                                    href="<?= base_url() ?>seguranca/operador/excluirOperador/<?= $item->operador_id; ?>"-->
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                                Editar
                                            </div>
                <!--                                        href="<?= base_url() ?>seguranca/operador/alterar/<?= $item->operador_id ?>"-->
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" ><div class="bt_link">
                                                Convênio
                                            </div>
                <!--                                        href="<?= base_url() ?>seguranca/operador/alterar/<?= $item->operador_id ?>"-->
                                        </td>

                                    <? } ?>
                                <? }
                                else {?>
                                    <td class="<?php echo $estilo_linha; ?>" ></td>
                                    <td class="<?php echo $estilo_linha; ?>" >
                                        <div class="bt_link">
                                            <a style="cursor: pointer;" onclick="javascript: return confirm('Deseja realmente excluir esse agrupador?');" href="<?= base_url() . "ambulatorio/procedimento/excluir/$item->procedimento_tuss_id"; ?>">Excluir</a>
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" >
                                        <div class="bt_link">
                                            <a href="<?php echo base_url() ?>ambulatorio/procedimento/carregaragrupadorprocedimento/<?= $item->procedimento_tuss_id ?>">Editar</a>
                                        </div>
                                    </td>
                                <? } ?>
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
                            <div style="display: inline">
                                <span style="margin-left: 15px; color: white; font-weight: bolder;"> Limite: </span>
                                <select style="width: 50px">
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/procedimento/pesquisar/50');" <?
                                    if ($limit == 50) {
                                        echo "selected";
                                    }
                                    ?>> 50 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/procedimento/pesquisar/100');" <?
                                            if ($limit == 100) {
                                                echo "selected";
                                            }
                                    ?>> 100 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/procedimento/pesquisar/todos');" <?
                                            if ($limit == "todos") {
                                                echo "selected";
                                            }
                                    ?>> Todos </option>
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
