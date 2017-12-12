<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>giah/incentivo">
            Voltar
        </a>
    </div>

    <div id="accordion">
        <? $competencia_formata = substr($competencia, 0, 4) . '/' . substr($competencia,4); ?>
        <h3><a href="#">Lista de incentivos da compet&ecirc;ncia <?=$competencia_formata;?></a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="6" class="tabela_title">
                            <form name="form_busca" method="post" action="<?=  base_url()?>giah/incentivo/pesquisarCompetencia">
                                <input type="hidden" name="competencia" value="<?=@$competencia;?>" />
                                <input type="text" name="filtro" value="<?=@$filtro;?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Servidor</th>
                        <th class="tabela_header">Valor</th>
                        <th class="tabela_header">Autorizado DIREX</th>
                        <th class="tabela_header">Autorizado SUPER</th>
                        <th class="tabela_header">Observa&ccedil;&atilde;o</th>
                        <th class="tabela_header" width="50px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?
                        if (count($lista) > 0) :
                            $i=0;
                            foreach ($lista as $item) :
                                if ($i%2 == 0) : $classe = "tabela_content01";
                                else: $classe = "tabela_content02";
                                endif;
                                ?>
                        <td class="<?=$classe;?>"><?= $item->servidor;?></td>
                        <td class="<?=$classe;?>"><?= number_format($item->valor, 2, ",", ".");?></td>
                                <? if ($item->autoriza_direx == 't') : ?>
                        <td class="<?=$classe;?>" align="center"><img border="0" alt="Autorizado" title="Autorizado" width="15px" height="15px" src="<?=  base_url()?>img/form/thumb_up.png"></td>
                                <? else: ?>
                                    <? if ($item->autoriza_direx == 'f') : ?>
                        <td class="<?=$classe;?>" align="center"><img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="15px" height="15px" src="<?=  base_url()?>img/form/thumb_down.png"></td>
                                    <? else: ?>
                        <td class="<?=$classe;?>" align="center"><?= $item->autoriza_direx;?></td>
                                    <? endif ?>
                                <? endif; ?>

                                <? if ($item->autoriza_super == 't') : ?>
                        <td class="<?=$classe;?>" align="center">
                            <img border="0" alt="Autorizado" title="Autorizado" width="15px" height="15px" src="<?=  base_url()?>img/form/thumb_up.png"></td>
                                <? else: ?>
                                    <? if ($item->autoriza_super == 'f') : ?>
                        <td class="<?=$classe;?>" align="center">
                            <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="15px" height="15px" src="<?=  base_url()?>img/form/thumb_down.png"></td>
                                    <? else: ?>
                        <td class="<?=$classe;?>" align="center"><?= $item->autoriza_super;?></td>
                                    <? endif ?>
                                <? endif; ?>
                        <td class="<?=$classe;?>"><?= $item->observacao;?></td>
                        <td class="<?=$classe;?>">
                                    <? if (($competenciaativa == $item->competencia) && ($item->autoriza_super == null) && ($item->autoriza_direx == null)): ?>
                            <a onclick="javascript: return confirm('Deseja realmente excluir o valor de \n incentivo de <?=$item->servidor; ?>');"
                               href="<?=base_url()?>giah/incentivo/excluir/<?=$item->competencia;?>/<?=$item->servidor_id;?>">
                                <img border="0" title="Excluir" alt="Excluir"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
                            </a>
                                    <? endif; ?>
                        </td>
                    </tr>
                            <?
                            $i++;
                        endforeach;
                    else :
                        ?>
                    <tr>
                        <td class="tabela_content01" colspan="6">Sem registros encontrados.</td>
                    </tr>
                    <? endif; ?>
                </tbody>
            </table>
        </div>
        <? if ($competencia == $competenciaativa): ?>
        <h3><a href="#">Cadastro de incentivo compet&ecirc;ncia <?= $competencia_formata; ?></a></h3>
        <div>
            <form name="form_incentivo" id="form_incentivo" action="<?=base_url() ?>giah/incentivo/gravar" method="post">
                <dl>
                    <dt>
                        <label>Servidor</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtServidorID" name="txtServidorID"
                               class="texto_id"
                               readonly="true" />
                        <input type=hidden id="txtUo_id" name="txtUo_id"
                               class="texto_id" />
                        <input type=hidden id="txtTeto_id" name="txtTeto_id"
                               class="texto_id" />
                        <input type="text" id="txtServidor" name="txtServidor" class="texto10"/>
                    </dd>
                    <dt>
                        <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtValor" class="texto03" alt="decimal"/>
                    </dd>
                    <dt>
                        <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="" rows="" name="txtObservacao" class="texto_area"></textarea>
                    </dd>
                </dl>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
        <? endif; ?>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
<? if (isset ($novo) && $novo == true ): ?>
        $( "#accordion" ).accordion({active: 1});
<? else: ?>
        $( "#accordion" ).accordion({active: 0});
<? endif; ?>
    });

    $(function() {
        $( "#txtServidor" ).autocomplete({
            source: "<?=  base_url()?>index.php?c=autocomplete&m=servidorteto",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtServidor" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtServidor" ).val( ui.item.value );
                $( "#txtServidorID" ).val( ui.item.id );
                $( "#txtUo_id" ).val( ui.item.uo );
                $( "#txtTeto_id" ).val( ui.item.teto );
                return false;
            }
        });
    });



</script>