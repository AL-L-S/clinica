<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Armazem</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarnovasolicitacao" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Paciente</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="solicitacao_cirurgia_id" class="texto10" value="<?= @$solicitacao_id; ?>" />
                        <input type="hidden" name="txtNomeid" id="txtNomeid" class="texto02" value="<?= @$paciente[0]->paciente_id;?>"/>
                        <input type="text" name="txtNome" id="txtNome" class="texto10" <? if( isset($paciente[0]->paciente ) ){ echo "value='".$paciente[0]->paciente."' readonly"; } ?>/>
<!--                        <input type="text" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" />
                <input type="text" id="txtNome" name="txtNome" class="texto10"/>-->
                        
                    </dd>
                 
                    <dt>
                        <label>Médico</label>
                    </dt>
                    <dd>
                        <select  name="medicoagenda" id="medicoagenda" class="size4" required="true">
                            <option value="">Selecione</option>
                            <? foreach ($medicos as $item) : ?>
                                <option value="<?= $item->operador_id; ?>">
                                    <?= $item->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>


                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    
<?php if ($this->session->flashdata('message') != ''): ?>
        alert("<? echo $this->session->flashdata('message') ?>");
<? endif; ?>

    $(function () {
        $("#accordion").accordion();
    });


    $(function () {
        $("#txtdata_prevista").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


    $(function () {
        $("#procedimento").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentoconveniocirurgia",
            minLength: 3,
            focus: function (event, ui) {
                $("#procedimento").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#procedimento").val(ui.item.value);
                $("#procedimentoID").val(ui.item.id);
                return false;
            }
        });
    });


                    $(function () {
                        $("#txtNome").autocomplete({
                            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
                            minLength: 3,
                            focus: function (event, ui) {
                                $("#txtNome").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $("#txtNome").val(ui.item.value);
                                $("#txtNomeid").val(ui.item.id);
                                return false;
                            }
                        });
                    });


    $(document).ready(function(){
        jQuery('#form_sala').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>
