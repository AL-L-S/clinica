<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaoprocedimentos" method="post">
        <fieldset>
            <legend>Escolha</legend>
                <input type="hidden" name="solicitacao_id" value="<?php echo $solicitacao_id; ?>"/>
            
            <div id="opcoes">
                <input type="radio" name="tipo" id="opcao_agrupador" value="agrupador" onclick="mostraagrupador()"> 
                <label for="opcao_agrupador" id="label"> Agrupador</label><br>
                <input type="radio" name="tipo" id="opcao_procedimento" value="procedimento" onclick="mostraprocedimentos()">
                <label for="opcao_procedimento" id="label">Procedimento</label>
            </div>
        </fieldset>    
        
        <fieldset id="cadastro"> 
            <!-- NAO REMOVA ESSE FIELDSET POIS O JAVASCRIPT IRA FUNCIONAR NELE!!! -->
        </fieldset>
        
    </form>
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
                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluirsolicitacaoprocedimento/<?= $item->solicitacao_procedimento_id; ?>/<?= $solicitacao_id; ?>" class="delete">
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

<style>
    #label{
        display: inline-block;
        font-size: 15px;
    }
</style>

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    function legend(){
        var leg = "<legend>Cadastrar procedimento</legend>";
        var verifica = jQuery("#cadastro legend").length;
        if(verifica == 0){
            jQuery("#cadastro").append(leg);
        }
    }
    
    function mostraagrupador(){
        legend();
        var tags = '<div id="div_agrupador"><label>Agrupador</label>';
        tags += '<select name="agrupador_id" id="agrupador_id" class="size4" required="true">';
        tags += '<option value="">SELECIONE</option>';
        
        <? foreach ($agrupador as $value) : ?>
        tags += "<option value='<?= $value->agrupador_id; ?>'><?php echo $value->nome; ?></option>";
        <? endforeach; ?>
            
        tags += '</select></div>';
        
        var verifica = jQuery("#cadastro #div_agrupador").length;
        if(verifica == 0){
            jQuery("#cadastro div").remove();
            jQuery("#cadastro").append(tags);
            adicionarbtn();
        }
        
    }
    
    
    function mostraprocedimentos(){
        legend();
        var tags = '<div id="div_procedimento"><label for="procedimento">Procedimento</label>';
        tags += '<input type="hidden" name="procedimentoID" id="procedimentoID" class="texto2" value="" />';
        tags += '<input type="text" name="procedimento" id="procedimento" class="texto10" value="" />';
        tags += '</div>';
        
        var verifica = jQuery("#cadastro #div_procedimento").length;
        if(verifica == 0){
            jQuery("#cadastro div").remove();
            jQuery("#cadastro").append(tags);
            adicionarbtn();
        }
        
        //autocomplete dos procedimentos
        $(function() {
            $( "#procedimento" ).autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentoproduto",
                minLength: 3,
                focus: function( event, ui ) {
                    $( "#procedimento" ).val( ui.item.label );
                    return false;
                },
                select: function( event, ui ) {
                    $( "#procedimento" ).val( ui.item.value );
                    $( "#procedimentoID" ).val( ui.item.id );
                    return false;
                }
            });
        });
        
    }
    
    function adicionarbtn(){
        var btn = '<div id="btnEnviar"><label>&nbsp;</label>';
        btn += '<button type="submit" name="btnEnviar">Adicionar</button></div>';
        var verifica = jQuery("#cadastro #btnEnviar").length;
        if(verifica == 0){
            jQuery("#cadastro").append(btn);
        }
        else{
            jQuery("#cadastro #btnEnviar").remove();
            jQuery("#cadastro").append(btn);
        }
    }
    
</script>