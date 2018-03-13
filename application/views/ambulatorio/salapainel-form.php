<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>ambulatorio/sala/gravarsalapainel" method="post">
        <fieldset>
            <legend>Cadastro de Painel</legend>
            <div style="width: 100%;">
                <dt>
                    <label>Nome Chamada</label>
                </dt>
                <dd>
                    <input type="hidden" name="exame_sala_id" value="<?= $exame_sala_id; ?>" />
                    <input type="text" name="txtnomechamada" class="texto10" required=""/>
                </dd>
                
                <dt>
                    <label>Painel</label> 
                </dt>
                <dd>
                    <select name="painel_numero" id="painel_numero" class="size2" required="">
                        <? for ($i = 1; $i <= 10; $i++) { ?>                                
                            <option value='<?=$i?>' ><?=$i?></option>
                        <? } ?>
                    </select>
                </dd>
            </div>
            <div style="width: 100%; margin-bottom: 10pt">
            </div>
                          
            <button type="submit" name="btnEnviar">Enviar</button>
        </fieldset>
        <?
        if (count($paineis) > 0) {
            ?>
            <fieldset>
                <table id="table_agente_toxico" border="0">
                    <thead>

                        <tr>
                            <th class="tabela_header">Nome Chamada</th>
                            <th class="tabela_header">Painel</th>
                            <th class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    foreach ($paineis as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome_chamada; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->painel_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>ambulatorio/sala/excluirsalapainel/<?= $item->exame_sala_painel_id; ?>/<?= $exame_sala_id; ?>" class="delete">
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