<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Guia</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>ambulatorio/exame/gravarguiacirurgica" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Paciente</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtambulatorioguiaid" id="txtambulatorioguiaid" class="texto10" value="<?= @$guia[0]->ambulatorio_guia_id; ?>" />
                        <input type="hidden" name="txtpacienteid" id="txtpacienteid" class="texto01" value="<?= @$guia[0]->paciente_id; ?>" required/>
                        <input type="text" name="txtpaciente" id="txtpaciente" class="texto10" value="<?= @$guia[0]->paciente; ?>" required/>
                    </dd>
                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio_id" id="convenio_id" class="size2" required>
                            <option value="">Selecione</option>
                            <? foreach ($convenios as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" <?
                                if (@$guia[0]->convenio_id == $value->convenio_id):echo 'selected';
                                endif;
                                ?>>
                                            <?= $value->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <dt>
                        <label>Hospital *</label>
                    </dt>
                    <dd>
                        <select name="hospital_id" id="hospital_id" class="size2"  required="">
                            <option value="">Selecione</option>
                            <? foreach (@$hospitais as $item) : ?>
                                <option value="<?= $item->hospital_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>

                    <dt>
                        <label>Leito </label>
                    </dt>
                    <dd>
                        <div>
                            <input type="radio" name="leito" id="enf" value="ENFERMARIA" required/> <label for="enf">Enfermaria</label>
                            <input type="radio" name="leito" id="apt" value="APARTAMENTO" required/> <label for="apt">Apartamento</label>
                        </div>
                    </dd>
                    
                    
                     <dt>
                        <label>Via </label>
                    </dt>
                    <dd>
                        <div>
                            <input type="radio" name="via" id="m" value="M" required/> <label for="m">Mesma Via</label>
                            <input type="radio" name="via" id="d" value="D" required/> <label for="d">Via Diferente</label>
                        </div>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

    $(function () {
        $("#txtpaciente").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtpaciente").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtpaciente").val(ui.item.value);
                $("#txtpacienteid").val(ui.item.id);
                return false;
            }
        });
    });


    $(function () {
        $("#accordion").accordion();
    });

</script>

