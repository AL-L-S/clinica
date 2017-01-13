<div class="content"> <!-- Inicio da DIV content -->
    <? if ($competencia != '000000') : ?>
    <div class="bt_link_new">
        
        <a href="<?= base_url() ?>giah/incentivo/novoteto">
            Cadastrar Teto
        </a>
        
    </div>
    <? endif; ?>
    <div id="accordion">
        <h3  class="singular"><a href="#">Lista de teto do ano <?= date('Y'); ?></a></h3>
        <div>

            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Compet&ecirc;ncia</th>
                        <th class="tabela_header">Total informado</th>
                        <th class="tabela_header" width="50px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    if (count($lista) > 0) :
                        $i = 0;
                        foreach ($lista as $item) :
                            if ($i % 2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;
                            ?>
                    <tr>
                        <td class="<?= $classe; ?>"><?= $item->competencia; ?></td>
                        <td class="<?= $classe; ?>"><?= number_format ($item->valor, 2, ",", "."); ?></td>
                        <td class="<?= $classe; ?>">
                            <a href="<?= base_url() ?>giah/incentivo/pesquisarCompetenciaTeto/<?= $item->competencia; ?>">
                                <img border="0" alt="Visualizar incentivos" title="Visualizar incentivos"
                                     src="<?= base_url() ?>img/form/page_white_magnify.png" >
                            </a>
                                    
                        </td>
                    </tr>
                            <?
                            $i++;
                        endforeach;
                    else :
                        ?>
                    <tr>
                        <td class="tabela_content01" colspan="3">Sem registros encontrados.</td>
                    </tr>
                    <? endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="3">Total de registros: <?= count($lista); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>