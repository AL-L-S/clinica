<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastrar Solicitação</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarautorizarcirurgia" method="post">

                <dl class="dl_desconto_lista">
                    <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="<?= @$solicitacao_id; ?>"/>
    
                    <dt>
                        <label>Médico Agendado</label>
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



                    <dt>
                        <label>Data Prevista</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_prevista" id="txtdata_prevista" alt="date" required="true"/>
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