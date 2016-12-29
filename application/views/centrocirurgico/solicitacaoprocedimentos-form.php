<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaoprocedimentos" method="post">
        <fieldset>
            <legend>Cadastrar procedimento</legend>
            <div>
                <input type="hidden" name="solicitacao_id" value="<?php echo $solicitacao_id; ?>"/>
                <label>Agrupador</label>
                <select name="agrupador_id" id="agrupador_id" class="size4">
                    <option value="">SELECIONE</option>
                    <? foreach ($agrupador as $value) : ?>
                        <option value="<?= $value; ?>"><?php echo $value; ?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div>
                <label>Procedimento</label>
                <select name="procedimento_id" id="procedimento_id" class="size4">
                    <option value="">SELECIONE</option>
                    <? foreach ($procedimento as $item) : ?>
                        <option value="<?= $item->procedimento_tuss_id; ?>"><?php echo $item->descricao; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>
<?
if (count($procedimentos) > 0) {
    ?>
        <table id="table_agente_toxico" border="0" style="width:600px">
        <thead>

            <tr>
                <th class="tabela_header">Procedimento</th>
                <th class="tabela_header">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?
            $estilo_linha = "tabela_content01";
            foreach ($procedimentos as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>

                <tr>
                    <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                    <td class="<?php echo $estilo_linha; ?>" width="100px;">
            <center>
                <a href="<?= base_url() ?>estoque/solicitacao/excluirsolicitacao/<?= $item->solicitacao_procedimento_id; ?>" class="delete">
                </a>
            </center>
            </td>
            </tr>


            <?
        }
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <th class="tabela_footer" colspan="4">
            </th>
        </tr>
    </tfoot>
</table> 
</fieldset>
</div> <!-- Final da DIV content -->



<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

</script>