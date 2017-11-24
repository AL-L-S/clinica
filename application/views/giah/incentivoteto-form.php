<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>giah/incentivo/pesquisarteto">
            Voltar
        </a>
    </div>

    <div id="accordion">
        <? $competencia_formata = substr($competencia, 0, 4) . '/' . substr($competencia,4); ?>
        <h3><a href="#">Lista teto da compet&ecirc;ncia <?=$competencia_formata;?></a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Dire&ccedil;&atilde;o</th>
                        <th class="tabela_header">Valor</th>
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
                        <td class="<?=$classe;?>"><?= $item->lotacao;?></td>
                        <td class="<?=$classe;?>"><?= number_format($item->valor, 2, ",", ".");?></td>
                        <td class="<?=$classe;?>">
                            <a onclick="javascript: return confirm('Deseja realmente excluir o valor de \n teto de <?=$item->uo_id; ?>');"
                               href="<?=base_url()?>giah/incentivo/excluirteto/<?=$item->competencia;?>/<?=$item->uo_id;?>">
                                <img border="0" title="Excluir" alt="Excluir"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
                            </a>
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
        <h3><a href="#">Cadastro teto compet&ecirc;ncia <?= $competencia_formata; ?></a></h3>
        <div>
            <form name="form_incentivo" id="form_incentivo" action="<?=base_url() ?>giah/incentivo/gravarTeto" method="post">
                <dl>
                    <dt>
                        <label>Dire&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtDirecaoID" name="txtDirecaoID"
                               class="texto_id"
                               readonly="true" />
                        <input type="text" id="txtDirecao" name="txtDirecao" class="texto10"/>
                    </dd>
                    <dt>
                        <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtValor" class="texto03" alt="decimal"/>
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
        $( "#txtDirecao" ).autocomplete({
            source: "<?=  base_url()?>index.php?c=autocomplete&m=uoteto",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtDirecao" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtDirecao" ).val( ui.item.value );
                $( "#txtDirecaoID" ).val( ui.item.id );
                return false;
            }
        });
    });



</script>