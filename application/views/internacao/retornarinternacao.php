<div class="content ficha_ceatox">
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>internacao/internacao/pesquisarsaida/">
            Voltar
        </a>
    </div>

    <div>
        <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarretornarinternacao/<?= $internacao_id; ?>" method="post">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente[0]->paciente ?>" readonly/>
                </div>

                <div>
                    <label>Unidade</label>
                    <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->unidade; ?>" readonly/>
                </div>
                <div>
                    <label>Enfermaria</label>
                    <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->enfermaria; ?>" readonly/>
                </div>
                <div>
                    <label>Leito</label>
                    <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->leito_nome; ?>" readonly/>
                </div>



                <div>
                    <label>Data da Internacao</label>                      
                    <input type="text" id="data_internacao" name="data_internacao"  class="texto09" value="<?= date("d/m/Y H:i:s", strtotime(@$paciente[0]->data_internacao)); ?>" readonly/>
                </div>

                <div>
                    <label>Médico Responsável Internação</label>                      
                    <input type="text" id="data_internacao" name="medico_responsavel"  class="texto09" value="<?= @$paciente[0]->medico_internacao; ?>" readonly/>
                </div>
                <div>
                    <label>Data Saída</label>                      
                    <input type="text" id="data_internacao" name="data_internacao"  class="texto09" value="<?= date("d/m/Y H:i:s", strtotime(@$paciente[0]->data_saida)); ?>" readonly/>
                </div>

                <div>
                    <label>Médico Responsável Saída</label>                      
                    <input type="text" id="data_internacao" name="medico_responsavel"  class="texto09" value="<?= @$paciente[0]->medico_saida; ?>" readonly/>
                </div>

                <div>
                    <label>Data de Nascimento</label>                      
                    <input type="text" id="data_nascimento" name="data_nascimento"  class="texto09" value="<?= (@$paciente[0]->nascimento != '') ? date("d/m/Y", strtotime(@$paciente[0]->nascimento)) : ''; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <input type="text" id="sexo" name="sexo"  class="texto09" value="<?
                    if (@$paciente[0]->sexo == "M"):echo 'Masculino';
                    endif;
                    if (@$paciente[0]->sexo == "F"):echo 'Feminino';
                    endif;
                    if (@$paciente[0]->sexo == "O"):echo 'Outro';
                    endif;
                    ?>" readonly/>
                </div> 

                <div>

                    <input type="hidden" id="txtidpaciente" name="idpaciente"  class="texto09" value="<?= $paciente[0]->paciente_id ?>" readonly/>
                </div>


            </fieldset>

            <fieldset>
                <? if ($paciente[0]->motivo_saida == '') { ?>
                    <div>
                        <label>Motivo de Saida</label>
                        <input type="text"  name="leito" id="leito" class="texto09" value="Transferencia - <?= $paciente[0]->hospital_transferencia ?>" readonly/>
                    </div>  
                <? } else {
                    ?>
                    <div> 
                        <label>Motivo de Saida</label>

                        <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->motivosaida; ?>" readonly/>
                    </div> 
                <? } ?>


                <div>
                    <label>Observações</label>

                    <input type="text"  name="leito" id="leito" class="texto09" value="<?= @$paciente[0]->observacao_saida; ?>" readonly/>
                </div>
            </fieldset>

            <fieldset>
                <legend>Leito</legend>
                <div>
                    <label>Leito</label>
                    <!--<input type="hidden" id="txtinternacao_id" name="internacao_id"  class="texto01" value="<?= $internacao_id; ?>" readonly/>-->
                    <input type="hidden" id="txtleitoID" class="texto_id" name="leitoID" value="<?= (@$paciente[0]->leito_ativo == 't') ? @$paciente[0]->leito : ''; ?>" />
                    <input type="text" id="txtleito" class="texto10" name="txtleito" value="<?= (@$paciente[0]->leito_ativo == 't') ? @$paciente[0]->leito_nome . ' - ' . @$paciente[0]->enfermaria . ' - ' . @$paciente[0]->unidade : ''; ?>" required/>
                </div>


            </fieldset>
            <fieldset>
                <div>
                    <button type="submit">Enviar</button>
                    <button type="reset">Limpar</button> 
                </div>
            </fieldset>

        </form>


    </div>

    <div class="clear"></div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>

<script>
    $(function () {
        $("#txtleito").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=leito",
            minLength: 2,
            focus: function (event, ui) {
                $("#txtleito").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtleito").val(ui.item.value);
                $("#txtleitoID").val(ui.item.id);
                return false;
            }
        });
    });

</script>
