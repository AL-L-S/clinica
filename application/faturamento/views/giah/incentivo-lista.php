<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Lista de incentivos do ano <?=date('Y');?></a></h3>
        <div>
        <table>
            <thead>
                <tr>
                    <th class="tabela_header">Compet&ecirc;ncia</th>
                    <th class="tabela_header">Servidores solicitados</th>
                    <th class="tabela_header">Servidores aprovados</th>
                    <th class="tabela_header">Total solicitado</th>
                    <th class="tabela_header">Total aprovado</th>
                    <th class="tabela_header">Situa&ccedil;&atilde;o</th>
                    <th class="tabela_header" width="50px;">&nbsp;</th>
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
                ?>
                <tr>
                    <td class="<?=$classe;?>"><?= substr($item->competencia, 0, 4)
                            . "/" . substr($item->competencia, 4);?></td>
                    <td class="<?=$classe;?>"><?= number_format($item->total, 0, ",", ".");?></td>
                    <td class="<?=$classe;?>"><?= number_format($item->total_autorizado, 0, ",", ".");?></td>
                    <td class="<?=$classe;?>"><?= number_format($item->valor, 2, ",", ".");?></td>
                    <td class="<?=$classe;?>"><?= number_format($item->valor_autorizado, 2, ",", ".");?></td>
                    <td class="<?=$classe;?>"><?= $item->situacao;?></td>
                    <td class="<?=$classe;?>">
                        <a href="<?= base_url()?>giah/incentivo/pesquisarcompetencia/<?= $item->competencia;?>">
                        <img border="0" alt="Visualizar incentivos" title="Visualizar incentivos"
                             src="<?= base_url()?>img/form/page_white_magnify.png" >
                        </a>
                    <? if ($item->situacao_id == 21 ): ?>
                        <a href="<?= base_url()?>giah/incentivo/novo">
                        <img border="0" alt="Cadastrar incentivo" title="Cadastrar incentivo"
                             src="<?= base_url()?>img/form/page_white_add.png" >
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
                    <td class="tabela_content01" colspan="7">Sem registros encontrados.</td>
                </tr>
                <? endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="tabela_footer" colspan="7">Total de registros: <?=count($lista); ?></th>
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