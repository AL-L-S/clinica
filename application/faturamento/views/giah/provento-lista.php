<div class="content"> <!-- Inicio da DIV content -->

    <? if ($competencia != '000000') :?>
    <div class="bt_link_new gerar_provento">
        <a onclick="javascript: return confirm('Deseja realemnte gerar os proventos para a compet&ecirc;ncia <?=  substr($competencia, 0, 4) . '/' . substr($competencia, 4);?>');"
           href="<?=  base_url()?>giah/provento/gerarproventos" >
            Gerar proventos
        </a>
    </div>
    <? endif; ?>

    <div id="accordion">
        <h3 class="singular"><a href="#">Lista de proventos</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Compet&ecirc;ncia</th>
                        <th class="tabela_header">Total</th>
                        <th class="tabela_header" style="text-align: center; width: 80px;">Arquivos</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    if (count($lista) > 0) :
                        $i=0;
                        foreach ($lista as $item) :
                            if ($i%2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;
                            $ano = substr($item->competencia, 0, 4);
                            $mes = substr($item->competencia, 4);
                            ?>
                    <tr>
                        <td class="<?=$classe;?>"><?= $ano . "/" . $mes; ?></td>
                        <td class="<?=$classe;?>">R$ <?= number_format($item->total, 2, ",", ".");?></td>
                        <td class="<?=$classe;?>" style="text-align: center; width: 80px;">
                            <a href="<?=  base_url()?>giah/provento/sam/<?=$item->competencia;?>">
                                <img border="0" alt="Arquivo SAM" title="Arquivo SAM"
                                     src="<?=  base_url()?>img/form/page_white_text.png" />
                            </a>
                            <a href="<?=  base_url() ?>giah/provento/bb/<?=$item->competencia;?>">
                                <img border="0" alt="Arquivo BB" title="Arquivo BB"
                                     src="<?=  base_url()?>img/form/page_white_text.png" />
                            </a>
                            <a href="#">
                                <img border="0" alt="Relat&oacute;rio" title="Relat&oacute;rio"
                                     src="<?=  base_url()?>img/form/page_white_acrobat.png" />
                            </a>
                        </td>
                    </tr>
                            <?
                            $i++;
                        endforeach;
                    else :
                        ?>
                    <tr>
                        <td class="tabela_content01" colspan="5">Sem registros encontrados.</td>
                    </tr>
                    <? endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="5">Total de registros: <?=  count($lista); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>