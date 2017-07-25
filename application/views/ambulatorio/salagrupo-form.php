<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>ambulatorio/sala/gravarsalagrupo" method="post">
        <fieldset>
            <legend>Cadastro de Grupos</legend>
            <div style="width: 100%; margin-bottom: 10pt">
                <label>Nome</label>
                <input type="hidden" name="exame_sala_id" value="<?php echo $exame_sala_id; ?>"/>
                <select name="grupo" id="grupo" class="size4" required="">
                    <? foreach ($grupos as $grupo) { ?>                                
                        <option value='<?= $grupo->nome ?>' ><?= $grupo->nome ?></option>
                    <? } ?>
                </select>

            </div>
            <button type="submit" name="btnEnviar">Enviar</button>
        </fieldset>
        <?
        if (count($gruposAssociados) > 0) {
            ?>
            <fieldset>
                <table id="table_agente_toxico" border="0">
                    <thead>

                        <tr>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    foreach ($gruposAssociados as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>ambulatorio/sala/excluirsalagrupo/<?= $item->exame_sala_grupo_id; ?>/<?= $exame_sala_id; ?>" class="delete">
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                        <?
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
        <? } ?>
</div> <!-- Final da DIV content -->



<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

</script>