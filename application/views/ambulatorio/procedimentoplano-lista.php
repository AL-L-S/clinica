
<? 
$data['empresa_permissao'] = $this->guia->listarempresapermissoes(); 
?>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <? if($data['empresa_permissao'][0]->apenas_procedimentos_multiplos != 't'){ ?>
                <td>
                    <div class="bt_link_new">
                        <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplano/0" target="_blank">
                            Novo Procedimento
                        </a>
                    </div>
                </td>
                <? $geral = $this->session->userdata('geral'); 
                if ($geral == 't') {?>
                    <td>
                        <div class="bt_link_new">
                            <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanoagrupador/0">
                                Novo Agrupador
                            </a>
                        </div>
                    </td>
                <? } ?>
                <td>
                    <div class="bt_link_new">
                        <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarmultiplosprocedimentoplano" target="_blank">
                            Multiplos Procedimentos 
                        </a>
                    </div>
                </td>
            <? } 
            else { ?>
                <td>
                    <div class="bt_link_new">
                        <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarmultiplosprocedimentoplano" target="_blank">
                            Novo Procedimento 
                        </a>
                    </div>
                </td>
                <? $geral = $this->session->userdata('geral'); 
                if ($geral == 't') {?>
                    <td>
                        <div class="bt_link_new">
                            <a href="<?php echo base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanoagrupador/0" target="_blank">
                                Novo Agrupador
                            </a>
                        </div>
                    </td>
                <? } ?>
            <? } ?>
        </tr>
    </table>

    <?
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Procedimento Convenio</a></h3>
        <div>
            <? $grupo = $this->procedimento->listargruposprocedimentoplano(); 
               $convenio = $this->convenio->listardados(); ?>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                    </tr>
                <form method="get" action="<?= base_url() ?>ambulatorio/procedimentoplano/pesquisar">
                    <tr>
                        <th class="tabela_title">Plano</th>
                        <th class="tabela_title">Grupo</th>
                        <th class="tabela_title">Procedimento</th>
                        <th colspan="2" class="tabela_title">Codigo</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <!--<input type="text" name="nome" class="texto04" value="<?php echo @$_GET['nome']; ?>" />-->
                            <select name="convenio" id="convenio" class="size2">
                                <option value="">Selecione</option>
                                <? foreach ($convenio as $value) : ?>
                                    <option value="<?= $value->convenio_id; ?>"
                                        <?if($value->convenio_id == @$_GET['convenio']) echo 'selected';?>>
                                        <?= $value->nome; ?>
                                    </option>
                                <? endforeach; ?>

                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="grupo" id="grupo" class="size2">
                                <option value="">Selecione</option>
                                <? foreach ($grupo as $value) : ?>
                                    <option value="<?= $value->nome; ?>"
                                        <? if (@$_GET['grupo'] == $value->nome) echo 'selected'?>>
                                    <?= $value->nome; ?>
                                    </option>
                                <? endforeach; ?>

                            </select>
                            <!--<input type="text" name="" class="texto04" value="<?php echo @$_GET['grupo']; ?>" />-->

                        </th>
<!--                        <th class="tabela_title">
                            <input type="text" name="nome" class="texto04" value="<?php echo @$_GET['nome']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="grupo" class="texto04" value="<?php echo @$_GET['grupo']; ?>" />
                        </th>-->
                        <th class="tabela_title">
                            <select name="procedimento" id="procedimento" class="size4 chosen-select" tabindex="1">
                                <option value="">Selecione</option>
                                <? foreach ($procedimento as $value) : ?>
                                    <option value="<?= $value->nome; ?>"<?
                                    if (@$_GET['procedimento'] == $value->nome):echo'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text" name="codigo" class="texto04" value="<?php echo @$_GET['codigo']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                    </tr>
                </form>
                </th>
                </tr>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <?
                        $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
                        if ($procedimento_multiempresa == 't') { ?>
                            <th class="tabela_header">Empresa</th>
                        <? } ?>
                        <th class="tabela_header">Plano</th>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Grupo</th>
                        <th class="tabela_header">codigo</th>
                        <th class="tabela_header">Valor</th>
                        <th class="tabela_header" colspan="4"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->procedimentoplano->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = $limite_paginacao;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        if ($limit != "todos") {
                            $lista = $this->procedimentoplano->listar($_GET)->orderby('c.nome')->orderby('pt.grupo')->orderby('pt.nome')->limit($limit, $pagina)->get()->result();
                        } else {
                            $lista = $this->procedimentoplano->listar($_GET)->orderby('c.nome')->orderby('pt.grupo')->orderby('pt.nome')->get()->result();
                        }
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <?
                                $procedimento_multiempresa = $this->session->userdata('procedimento_multiempresa');
                                if ($procedimento_multiempresa == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                                <?}?>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>                               
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->codigo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->valortotal; ?></td>


                                <? if ($perfil_id != 10) { ?>
                                    <? if ($item->agrupador != 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <a onclick="javascript: return confirm('Deseja realmente excluir o procedimento? ');" target="_blank"
                                               href="<?= base_url() ?>ambulatorio/procedimentoplano/excluir/<?= $item->procedimento_convenio_id ?>">
                                               Excluir
                                            </a>
                <!--                                    href="<?= base_url() ?>ambulatorio/procedimentoplano/excluir/<?= $item->procedimento_convenio_id; ?>"-->
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"> 
                                            <a target="_blank" href="<?= base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplano/<?= $item->procedimento_convenio_id ?>">
                                                Editar
                                            </a>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="80px;"> 
                                            <a target="_blank" href="<?= base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoformapagamento/<?= $item->procedimento_convenio_id ?>">
                                                Pagamento
                                            </a>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="80px;"> 
                                            <a target="_blank" href="<?= base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanosessao/<?= $item->procedimento_convenio_id ?>">
                                                Sessão
                                            </a>
                                        </td>
                                        
                                    <? } 
                                    else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="80px;"> </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="80px;"> </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <a target="_blank" onclick="javascript: return confirm('Deseja realmente excluir o procedimento? ');" href="<?= base_url() ?>ambulatorio/procedimentoplano/excluir/<?= $item->procedimento_convenio_id ?>">
                                                Excluir
                                            </a>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"> 
                                            <a target="_blank" href="<?= base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanoagrupador/<?= $item->procedimento_convenio_id ?>">
                                                Editar
                                            </a>
                                        </td>
                                    <? } ?>

                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                        Excluir
            <!--                                    href="<?= base_url() ?>ambulatorio/procedimentoplano/excluir/<?= $item->procedimento_convenio_id; ?>"-->
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"> 
                                        Editar
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="80px;"> 
                                        Pagamento
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="80px;"> 
                                        Sessão
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
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/procedimentoplano/pesquisar/50');" <? if ($limit == 50) {
                                echo "selected";
                            } ?>> 50 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/procedimentoplano/pesquisar/100');" <? if ($limit == 100) {
                                echo "selected";
                            } ?>> 100 </option>
                                    <option onclick="javascript:window.location.href = ('<?= base_url() ?>ambulatorio/procedimentoplano/pesquisar/todos');" <? if ($limit == "todos") {
                                echo "selected";
                            } ?>> Todos </option>
                                </select>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<style>
    /*.chosen-single span{ width: 130px; }*/
    /*#procedimento_chosen a { width: 130px; }*/
</style>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
        $("#procedimento").chosen({
            width: '100%'
        });
    });
    
//    $(function() {
//        $("#procedimento").autocomplete({
//            source: "<?= base_url() ?>index.php?c=autocomplete&m=listarprocedimentoautocomplete",
//            minLength: 3,
//            focus: function( event, ui ) {
//                $( "#procedimento" ).val( ui.item.label );
//                return false;
//            },
//            select: function( event, ui ) {
//                $( "#procedimento" ).val( ui.item.value );
//                return false;
//            }
//        });
//    });

</script>
