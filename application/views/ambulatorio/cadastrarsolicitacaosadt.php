<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/guia/pesquisarsolicitacaosadt/<?=$paciente_id?>/<?=$convenio_id?>/<?=$solicitante_id?>">
            Voltar
        </a>

    </div>
    <div class="clear"></div>
    <form name="form_solicitacaoitens" id="form_solicitacaoitens" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentosolicitacaosadt/<?= $solicitacao_id ?>/<?=$paciente_id?>/<?=$convenio_id?>/<?=$solicitante_id?>" method="post">
        <?
        $perfil_id = $this->session->userdata('perfil_id');
        ?>
        <fieldset>
            <legend>Dados da Solicitação</legend>
            <div>
                <label>Paciente</label>
                <input type="text" class="texto06" readonly value="<?= $guia[0]->paciente ?>"/> 
            </div>

            <div>
                <label>Médico Solicitante</label>
                <input type="text" class="texto06" readonly value="<?= $guia[0]->solicitante ?>"/> 
            </div>
            <div>
                <label>Convênio</label>
                <input type="text" id="convenio" readonly value="<?= $guia[0]->convenio ?>"/> 
            </div>

        </fieldset>
        <fieldset>
            <legend>Adicionar Procedimentos</legend>

            <fieldset>
                <legend>Procedimentos</legend>
                <input type="hidden" name="solicitacao_id" value="<?php echo $solicitacao_id; ?>"/>
                <table>
                    <tr>
                        <td>Quantidade</td>
                        <td>
                            <input type="text" name="quantidade" id="quantidade" value="1" class="texto00"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Procedimento</td>
                        <td>
                            <select name="procedimento1" id="procedimento1" class="size4 chosen-select" tabindex="1" required="">
                                <option value="">Selecione</option>
                                <? foreach ($procedimento as $item) { ?>
                                    <option value="<?= $item->procedimento_convenio_id ?>"><?= $item->procedimento ?></option>
                                <? } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Valor Unitario</td>
                        <td><input readonly="" type="text" name="valor1" id="valor1" <?
                            if ($perfil_id != 1) {
                                echo 'readonly';
                            }
                            ?> class="texto01"/></td>
                    </tr>

                </table>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>

            </fieldset>

            <hr/>

            <!--<button type="submit" name="btnEnviar">Enviar</button>-->
            <!--<button type="reset" name="btnLimpar">Limpar</button>-->
        </fieldset>

        <fieldset id="cadastro"> 
            <!-- NAO REMOVA ESSE FIELDSET POIS O JAVASCRIPT IRA FUNCIONAR NELE!!! -->
        </fieldset>


    </form>
    <?
    if (count($procedimentos_cadastrados) > 0) {
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
                foreach ($procedimentos_cadastrados as $item) {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>

                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                <center>
                    <a href="<?= base_url() ?>ambulatorio/guia/excluirsolicitacaoprocedimentosadt/<?= $solicitacao_id ?>/<?= $item->solicitacao_sadt_procedimento_id; ?>" class="delete">
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
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(document).ready(function () {



        $('#procedimento1_chosen').click(function () {
//            alert($('#procedimento1').val());
            if ($('#procedimento1').val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $('#procedimento1').val(), ajax: true}, function (j) {
                    options = "";
                    options += j[0].valortotal;
                    document.getElementById("valor1").value = options
                    $('.carregando').hide();
                });
            } else {
                $('#valor1').html('value=""');
            }
        });





    });




</script>
