<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaoprocedimentos" method="post">
        <fieldset>
            <legend>Dados da Solicitação</legend>
            <div>
                <label>Paciente</label>
                <input type="text" class="texto06" readonly value="<?= $dados[0]->nome ?>"/> 
                <!--<input type="text" class="texto06" readonly value="//<?= $dados[0]->orcamento ?>"/>--> 
            </div>

            <div>
                <label>Médico Solicitante</label>
                <input type="text" class="texto06" readonly value="<?= $dados[0]->medico ?>"/> 
            </div>
            <div>
                <label>Convênio</label>
                <input type="text" id="convenio" readonly value="<?= $dados[0]->convenio ?>"/> 
            </div>

        </fieldset>
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
        
        <fieldset > 
            <div class="bt_link">                                  
                <a onclick="javascript: return confirm('Deseja realmente Liberar a solicitacao?');" href="<?= base_url() ?>centrocirurgico/centrocirurgico/liberar/<?= $solicitacao_id ?>/<?= $dados[0]->orcamento ?>">Liberar</a>
            </div>
        </fieldset>

    </form>
    <?
    if (count($procedimentos) > 0) {
        ?>
        <table id="table_agente_toxico" border="0" style="width:600px">
            <thead>

                <tr>
                    <th class="tabela_header">Procedimento</th>
                    <th class="tabela_header">Convenio</th>
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
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
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

<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js" type="text/javascript"></script>-->
<script type="text/javascript">
                    function legend() {
                        var leg = "<legend>Cadastrar procedimento</legend>";
                        var verifica = jQuery("#cadastro legend").length;
                        if (verifica == 0) {
                            jQuery("#cadastro").append(leg);
                        }
                    }

                    function mostraagrupador() {
                        legend();
                        var tags = '<div id="div_agrupador"><label>Agrupador</label>';
                        tags += '<select name="agrupador_id" id="agrupador_id" class="size4" required="true">';
                        tags += '<option value="">SELECIONE</option>';

<? foreach ($agrupador as $value) : ?>
                            tags += "<option value='<?= $value->agrupador_id; ?>'><?php echo $value->nome; ?></option>";
<? endforeach; ?>

                        tags += '</select></div>';

                        var verifica = jQuery("#cadastro #div_agrupador").length;
                        if (verifica == 0) {
                            jQuery("#cadastro div").remove();
                            jQuery("#cadastro").append(tags);
                            adicionarbtn();
                        }

                    }


                    function mostraprocedimentos() {
                        legend();
                        var tags = '<div id="div_procedimento"><label for="procedimento">Procedimento</label>';
                        tags += '<select style="width: 400pt" name="procedimentoID" id="procedimento" class="chosen-select" tabindex="1" required="true" >';
                        tags += '<option value="">Selecione</option>';
                    <? foreach (@$procedimento as $item3) : ?>
                        tags += '<option value="<? echo $item3->procedimento_convenio_id; ?>"><? echo $item3->codigo . " - " . $item3->nome; ?></option>';
                    <? endforeach; ?>
                        tags += '</select></div>';
//                        tags += '<input type="hidden" name="procedimentoID" id="procedimentoID" class="texto2" value="" />';
//                        tags += '<input type="text" name="procedimento" id="procedimento" class="texto10" value="" />';
//                        tags += '';

                        var verifica = jQuery("#cadastro #div_procedimento").length;
                        if (verifica == 0) {
                            jQuery("#cadastro div").remove();
                            jQuery("#cadastro").append(tags);
                            adicionarbtn();
                        }

                        //autocomplete dos procedimentos
//                        $(function () {
//                            $("#procedimento").autocomplete({
//                                source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentoproduto",
//                                minLength: 3,
//                                focus: function (event, ui) {
//                                    $("#procedimento").val(ui.item.label);
//                                    return false;
//                                },
//                                select: function (event, ui) {
//                                    $("#procedimento").val(ui.item.value);
//                                    $("#procedimentoID").val(ui.item.id);
//                                    return false;
//                                }
//                            });
//                        });

                    }
                    
//                    var procedimentosAutocomplete = function(){ 
//                        jQuery.ajax({
//                            url: "<?= base_url(); ?>" + "autocomplete/procedimentoproduto?convenio=<?= $dados[0]->convenio ?>,
//                            type: "GET",
//                            dataType: 'json'
//                        });
//                    }

                    function adicionarbtn() {
                        var btn = '<div id="btnEnviar"><label>&nbsp;</label>';
                        btn += '<button type="submit" name="btnEnviar">Adicionar</button></div>';
                        var verifica = jQuery("#cadastro #btnEnviar").length;
                        if (verifica == 0) {
                            jQuery("#cadastro").append(btn);
                        } else {
                            jQuery("#cadastro #btnEnviar").remove();
                            jQuery("#cadastro").append(btn);
                        }
                    }
                    
                    

</script>
