<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/examepacientedetalhes/<?= $paciente_id; ?>/<?= $procedimento_tuss_id; ?>/<?= $guia_id; ?>/<?= $agenda_exames_id ?>', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Detalhes
                                                </a></div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Horario</a></h3>
        <div>
            <form name="form_exameespera" id="form_exameespera" action="<?= base_url() ?>ambulatorio/exame/gravarexame" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Sala *</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtpaciente_id" value="<?= $paciente_id; ?>" />
                        <input type="hidden" name="txtprocedimento_tuss_id" value="<?= $procedimento_tuss_id; ?>" />
                        <input type="hidden" name="txtguia_id" value="<?= $guia_id; ?>" />
                        <input type="hidden" name="txttipo" value="<?= $agenda_exames_nome_id[0]->tipo; ?>" />
                        <input type="hidden" name="txtagenda_exames_id" value="<?= $agenda_exames_id; ?>" />
                        <select name="txtsalas" id="txtsalas" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($salas as $item) : ?>
                                <option value="<?= $item->exame_sala_id; ?>" <?
                                if ($agenda_exames_nome_id[0]->agenda_exames_nome_id == $item->exame_sala_id):echo 'selected';
                                endif;
                                ?>><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Medico</label>
                    </dt>
                    <dd>
                        <select name="txtmedico" id="txtmedico" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($medicos as $item) : ?>
                                <option value="<?= $item->operador_id; ?>" <?
                                if ($medico_id[0]->medico_agenda == $item->operador_id):echo 'selected';
                                endif;
                                ?>><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Tecnico</label>
                    </dt>
                    <dd>
                        <select name="txttecnico" id="txttecnico" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($tecnicos as $item) : ?>
                                <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>

                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $("#accordion").accordion();
    });

    $(function() {
        $("#txtprocedimentolabel").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function(event, ui) {
                $("#txtpacientelabel").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtpacientelabel").val(ui.item.value);
                $("#txtpacienteid").val(ui.item.id);
                return false;
            }
        });
    });

    $(document).ready(function() {
        jQuery('#form_exameespera').validate({
            rules: {
                txtsalas: {
                    required: true
                }
            },
            messages: {
                txtsalas: {
                    required: "*"
                }
            }
        });
    });
    

</script>