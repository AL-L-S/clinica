<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastrar Solicitação de Orçamento</a></h3>
        <div>
            <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaorcamento" method="post">
                <div style="padding-bottom: 50px;">
                    <dl class="dl_desconto_lista">
                        <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="<?= @$solicitacao_id; ?>"/>

                        <dt>
                            <label>Convenio</label>
                        </dt>
                        <dd>
                            <select name="convenio" id="convenio" class="size4" required="true">
                                <option  value="">Selecione</option>
                                <? foreach ($convenio as $value) : ?>
                                    <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </dd>                    

                        <dt>
                            <label>Medico Responsavel</label>
                        </dt>
                        <dd>
                            <select name="medico_responsavel" id="medico_responsavel" class="size4" required="true">
                                <option  value="">Selecione</option>
                                <? foreach ($medicos as $item) : ?>
                                    <option value="<?= $item->operador_id; ?>">
                                        <?= $item->nome; ?>
                                    </option>
                                <? endforeach; ?>
                            </select>
                        </dd>                    

                        <dt>
                            <label>Data Solicitacao</label>
                        </dt>
                        <dd>
                            <input type="text" name="txtdata_prevista" id="txtdata_prevista" alt="date" required="true"/>
                        </dd>

                        <dt>
                            <label>Observação</label>
                        </dt>
                        <dd>
                            <!--<textarea name="observacao" id="observacao"></textarea>-->
                            <textarea cols="49" rows="3" name="observacao" id="observacao"></textarea><br/>
                        </dd>

                    </dl>  
                </div>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

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

//
//    $(document).ready(function(){
//        jQuery('#form_sala').validate( {
//            rules: {
//                txtNome: {
//                    required: true,
//                    minlength: 2
//                }
//            },
//            messages: {
//                txtNome: {
//                    required: "*",
//                    minlength: "!"
//                }
//            }
//        });
//    });

</script>