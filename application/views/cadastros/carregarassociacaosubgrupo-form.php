<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_grupoclassificacao" id="form_grupoclassificacao" action="<?= base_url() ?>cadastros/grupoclassificacao/gravarassociacaosubgrupo" method="post">
        <fieldset>
            <legend>Adicionar Subgrupo</legend>
            <dl class="dl_desconto_lista">
                <dt>
                    <label>Grupo</label>
                </dt>
                <dd>
                    <input type="text" name="grupo" id="grupo" value="<?= $grupo ?>" class="texto06" readonly=""/>
                </dd>
                <dt>
                    <label>Subgrupos</label>
                </dt>
                <dd>
                    <!--<input type="hidden" name="grupo" id="grupo" value="<?= $grupo ?>"/>-->
                    <select name="subgrupo_id" id="subgrupo_id" class="size4 chosen-select" required="">
                        <option value="">Selecione</option>
                        <? foreach ($subgrupos as $item) {?>
                            <option value="<?=$item->ambulatorio_subgrupo_id?>"><?=$item->nome?></option>
                        <? } ?>
                    </select>
                </dd>
            </dl>    
            <hr/>
            <button type="submit" name="btnEnviar">Enviar</button>
            <button type="reset" name="btnLimpar">Limpar</button>
            <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
        </fieldset>

        <fieldset>
            <?
            if (count($lista) > 0) {
                ?>
                <table id="table_agente_toxico" border="0">
                    <thead>

                        <tr>
                            <th class="tabela_header">Subgrupo</th>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    foreach ($lista as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->subgrupo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $grupo ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>cadastros/grupoclassificacao/excluirassociacaosubgrupo/<?= $item->ambulatorio_subgrupo_grupo_id; ?>/<?= $grupo ?>" class="delete"></a>
                                </td>
                            </tr>

                        </tbody>
                        <?
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                        </th>
                    </tr>
                </tfoot>
            </table> 
        </fieldset>
    </form>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>

<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

//    $(function () {
//        $("#accordion").accordion();
//    });


</script>