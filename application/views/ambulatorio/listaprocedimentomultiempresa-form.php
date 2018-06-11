
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <th>
                <div class="bt_link_voltar">
                    <a href="<?= base_url() ?>ambulatorio/procedimentoplano/pesquisar2">
                        Voltar
                    </a>
                </div>
            </th>
        </tr>
    </table>
    <div id="accordion">
        <h3 class="singular"><a href="#">Lista de Procedimentos</a></h3>
        <div>
            <? $perfil_id = $this->session->userdata('perfil_id'); ?>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Empresa</th>
                        <th class="tabela_header">Plano</th>
                        <th class="tabela_header">Procedimento</th>
                        <th class="tabela_header">Grupo</th>
                        <th class="tabela_header">Valor</th>
                        <th class="tabela_header" colspan="4"><center>Detalhes</center></th>
                </tr>
                </thead>
                <tbody>
                    <? 
                    $estilo_linha = "tabela_content01";
                    foreach ($procedimentos as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>                               
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->valortotal; ?></td>
                            <? 
                            if ($perfil_id != 10) { 
                                if ($item->agrupador != 't') { 
                                    if($item->ativo == 't'){?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <a onclick="javascript: return confirm('Deseja realmente desativar o procedimento? ');" target="_blank"
                                               href="<?= base_url() ?>ambulatorio/procedimentoplano/excluir/<?= $item->procedimento_convenio_id ?>">
                                                Desativar
                                            </a>
                                        </td>
                                        <? if($item->associado != 't') { ?>
                                            <td class="<?php echo $estilo_linha; ?>" width="60px;"> 
                                                <a target="_blank" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplano/<?= $item->procedimento_convenio_id ?>');">
                                                    Editar
                                                </a>
                                            </td>
                                        <? } ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="80px;"> 
                                            <a target="_blank" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoformapagamento/<?= $item->procedimento_convenio_id ?>');">
                                                Pagamento
                                            </a>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="80px;"> 
                                            <a target="_blank" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanosessao/<?= $item->procedimento_convenio_id ?>');">
                                                Sessão
                                            </a>
                                        </td>                                        
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <a onclick="javascript: return confirm('Deseja realmente ativar o procedimento? ');" target="_blank"
                                               href="<?= base_url() ?>ambulatorio/procedimentoplano/reativarprocedimentoconvenio/<?= $item->procedimento_convenio_id ?>">
                                                Reativar
                                            </a>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <a target="_blank" onclick="javascript: return confirm('Deseja realmente excluir o procedimento? ');" href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirdesativado/<?= $item->procedimento_convenio_id ?>">
                                                Excluir
                                            </a>
                                        </td>
                                    <? } ?>

                                <? } 
                                else {
                                    if($item->ativo == 't'){ ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="80px;"> </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="80px;"> </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <a target="_blank" onclick="javascript: return confirm('Deseja realmente desativar o procedimento? ');" href="<?= base_url() ?>ambulatorio/procedimentoplano/excluir/<?= $item->procedimento_convenio_id ?>">
                                                Desativar
                                            </a>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"> 
                                            <a target="_blank" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/procedimentoplano/carregarprocedimentoplanoagrupador/<?= $item->procedimento_convenio_id ?>');">
                                                Editar
                                            </a>
                                        </td>
                                <?  } 
                                    else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <a onclick="javascript: return confirm('Deseja realmente ativar o procedimento? ');" target="_blank"
                                               href="<?= base_url() ?>ambulatorio/procedimentoplano/reativarprocedimentoconvenio/<?= $item->procedimento_convenio_id ?>">
                                                Reativar
                                            </a>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                            <a target="_blank" onclick="javascript: return confirm('Deseja realmente excluir o procedimento? ');" href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirdesativado/<?= $item->procedimento_convenio_id ?>">
                                                Excluir
                                            </a>
                                        </td>
                                <?  } 
                                }
                            } 
                            else { ?>
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
                        <?  } ?>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $("#accordion").accordion();
    });

</script>
