<div class="content ficha_ceatox">
    <div>
        <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaocirurgia" method="post"> 
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente[0]->paciente ?>" readonly/>
                </div>

                <div>
                    <label>data da Internacao</label>                      
                    <input type="text" id="data_internacao" name="data_internacao"  class="texto09" value="<?= $paciente[0]->data_internacao; ?>" readonly/>
                </div>

                <div>
                    <label>data de Nascimento</label>                      
                    <input type="text" id="data_nascimento" name="data_nascimento"  class="texto09" value="<?= date('d/m/Y', strtotime($paciente[0]->nascimento)); ?>" readonly/>
                </div>

                <div>
                    <label>Sexo</label>
                    <input type="text" id="sexo" name="sexo"  class="texto09" value="<?= $paciente[0]->sexo == 'M' ? "Masculino" : "Feminino"; ?>" readonly/>
                </div>    

                <div>

                    <input type="hidden" id="txtidpaciente" name="internacao_id"  class="texto09" value="<?= $paciente[0]->internacao_id ?>" readonly/>
                </div>
            </fieldset>


            <fieldset>
                <div>
                    <label>Procedimento</label>

                    <input type="text" id="txtprocedimentoID" class="texto_id" name="procedimentoID" value="<?= @$obj->_procedimento_id; ?>" />
                    <input type="text" id="txtprocedimento" class="texto10" name="txtprocedimento" value="<?= @$obj->_procedimento_nome; ?>" />
                </div>

            </fieldset>
            <button onclick="javascript: return confirm('Confirmar solicitação de cirurgia do paciente(a) <?= $paciente[0]->paciente ?>');" type="submit">Enviar</button>
            <button  type="reset">Limpar</button>
        </form>
    </div>



</div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>

<script>
                     $(function () {
                         $("#txtprocedimento").autocomplete({
                             source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentotuss",
                             minLength: 2,
                             focus: function (event, ui) {
                                 $("#txtprocedimento").val(ui.item.label);
                                 return false;
                             },
                             select: function (event, ui) {
                                 $("#txtprocedimento").val(ui.item.value);
                                 $("#txtprocedimentoID").val(ui.item.id);
                                 return false;
                             }
                         });
                     });


                     $(function () {
                         $('#convenio1').change(function () {
                             if ($(this).val()) {
                                 $('.carregando').show();
                                 $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniofisioterapia', {convenio1: $(this).val(), ajax: true}, function (j) {
                                     options = '<option value=""></option>';
                                     for (var c = 0; c < j.length; c++) {
                                         options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                     }
                                     $('#procedimento1').html(options).show();
                                     $('.carregando').hide();
                                 });
                             } else {
                                 $('#procedimento1').html('<option value="">Selecione</option>');
                             }
                         });
                     });


</script>