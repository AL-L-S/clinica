<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaoprocedimentos" method="post">
        <fieldset>
            <legend>Outras Opções</legend>   

            <div class="bt_link">
                <a target="_blank" href="<?= base_url() ?>centrocirurgico/centrocirurgico/carregarsolicitacaomaterial/<?= $dados[0]->solicitacao_cirurgia_id; ?>">Cadastrar Material</a>
            </div>            
            <div class="bt_link">
                <a target="_blank" href="<?= base_url() ?>centrocirurgico/centrocirurgico/solicitacarorcamentoconvenio/<?= $dados[0]->solicitacao_cirurgia_id; ?>">Guia Convênio</a>
            </div>
        </fieldset>
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

        <fieldset id="fieldset_procedimento"> 

            <div>
                <label > Quantidade</label>
                <input type="number" name="quantidade" id="quantidade" value="1"/>  

            </div>
            <div ><label for="procedimento">Procedimento</label>
                <select style="" name="procedimentoID" id="procedimento" class="chosen-select" tabindex="1" >
                    <option value="">Selecione</option>
                    <? foreach (@$procedimento as $item3) : ?>   
                        <option value="<? echo $item3->procedimento_convenio_id; ?>"><? echo $item3->codigo . " - " . $item3->nome; ?></option>
                    <? endforeach; ?> 
                </select>

            </div>
            <div id="btnEnviar"><label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
        </fieldset>
        <fieldset id="fieldset_agrupador"> 
            <div id="div_agrupador"><label>Agrupador</label>
                <select name="agrupador_id" id="agrupador_id" class="size4">
                    <option value="">SELECIONE</option>
                    <? foreach ($agrupador as $value) : ?>
                        <option value='<?= $value->agrupador_id; ?>'><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>

            </div>

            <div id="btnEnviar"><label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
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
                    <th class="tabela_header">Quantidade</th>
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
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
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

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">




                    function mostraagrupador() {
                        $('#fieldset_procedimento').hide();
                        $('#fieldset_agrupador').show();

                    }


                    function mostraprocedimentos() {
                        $('#fieldset_agrupador').hide();
                        $('#fieldset_procedimento').show();

                    }

                    $('#fieldset_procedimento').hide();
                    $('#fieldset_agrupador').hide();





</script>
