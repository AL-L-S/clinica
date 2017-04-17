<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Guia Ambulatorial</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>ambulatorio/exame/faturarguiamanual" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Paciente</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtambulatorioguiaid" id="txtambulatorioguiaid" class="texto10" value="<?= @$guia[0]->ambulatorio_guia_id; ?>" />
                        <input type="hidden" name="txtpacienteid" id="txtpacienteid" class="texto01" value="<?= @$guia[0]->paciente_id; ?>" required/>
                        <input type="text" name="txtpaciente" id="txtpaciente" class="texto10" value="<?= @$guia[0]->paciente; ?>" required/>
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

