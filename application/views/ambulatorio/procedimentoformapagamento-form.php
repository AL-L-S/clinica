<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimentoplano">
            Voltar
        </a>
    </div>

    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastrar Pagamento</a></h3>
        <div>
            <form name="form_procedimento" id="form_procedimento" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarformapagamentoprocedimento" method="post">

                <dl class="dl_cadastro_teto dt">
                    <dt>
                    <label>Grupo de Pagamento</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="procedimento_convenio_id" id="procedimento_convenio_id" value="<?= $procedimento_convenio_id; ?>" />
<!--                        <input type="hidden" name="txtpagamentoid" id="txtpagamentoid" class="texto10" value="" />
                        <input type="text" name="txtpagamento" id="txtpagamento" class="texto10" value="" />-->
                        <select name="grupopagamento" id="grupopagamento" class="texto03">
                            <option value="">SELECIONE</option>
                            <? foreach ($formapagamento_grupo as $value) { ?>
                            <option value="<?= $value->financeiro_grupo_id ?>" selected><?= $value->nome ?></option>
                            <? } ?> 
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
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $("#txtpagamento").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentoformapagamento",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtpagamento").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtpagamento").val(ui.item.value);
                $("#txtpagamentoid").val(ui.item.id);
                return false;
            }
        });
    });

    $(document).ready(function () {
        jQuery('#form_procedimento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtprocedimentolabel: {
                    required: true
                },
                txtperc_medico: {
                    required: true
                },
                grupo: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtprocedimentolabel: {
                    required: "*"
                },
                txtperc_medico: {
                    required: "*"
                },
                grupo: {
                    required: "*"
                }
            }
        });
    });

</script>