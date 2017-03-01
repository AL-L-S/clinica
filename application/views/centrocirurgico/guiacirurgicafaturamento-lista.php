<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <?
    for($i = 0; $i < count($procedimentos); $i++){
        $valor = (float)$procedimentos[$i]->valor_total;
        $valProcedimento = ($procedimentos[$i]->horario_especial == 't') ? ($valor) + ($valor*(30/100)) : $valor;
    }
//    var_dump($procedimentos);die;
//        $maiorProcedimento;
    ?>
    <div class="clear"></div>
    <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentosgeral" method="post">
        <fieldset>
            <legend>Dados da Guia</legend>
            <div>
                <label>Paciente</label>                      
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$guia['0']->paciente; ?>" readonly/>
                <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= @$guia['0']->paciente_id; ?>"/>
                <input type="hidden" id="guia_id" name="guia_id"  value="<?= @$guia['0']->ambulatorio_guia_id; ?>"/>
            </div>

            <div>
                <label>Convenio</label>
                <input type="text" name="convenio" id="convenio" class="texto02"value="<?= @$guia['0']->convenio; ?>"readonly/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Dados da Guia</legend>
            <table>
                <thead>
                    <th>Função</th>
                    <th>Médico</th>
                    <th>Valor</th>
                </thead>
                <? foreach ($equipe as $value) :?>
                    <td><?= @$value->descricao; ?></td>
                    <td><?= @$value->medico_responsavel; ?></td>
                <? endforeach;?>
            </table>
        </fieldset>
    </form>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

                    $(function () {
                        $('#procedimento').change(function () {
                            if ($(this).val() && $('#equipe_id').val() != '') {
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/carregavalorprocedimentocirurgico', {procedimento_id: $(this).val(), equipe_id: $('#equipe_id').val()}, function (j) {
                                    options = '<option value=""></option>';
                                    for (var c = 0; c < j.length; c++) {
                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                    }
                                    $('#procedimento1').html(options).show();
                                    $('.carregando').hide();
                                });
                            }
                        });
                    });

//    $(function () {
//        $('#equipe_id').change(function () {
//            if ($(this).val() && $('#procedimento').val() != '') {
//                $('.carregando').show();
//                $.getJSON('<?= base_url() ?>autocomplete/carregavalorprocedimentocirurgico', {procedimento_id: $('#procedimento').val(), equipe_id: $(this).val()}, function (j) {
//
//                });
//            }
//        });
//    });

</script>
