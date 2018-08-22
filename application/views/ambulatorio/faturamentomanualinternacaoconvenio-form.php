
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Deseja Faturar?</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/exame/gravarfaturaramentointernacaoconvenio" method="post">
                <fieldset>
                    <table cellspacing="5">
                        <tr>
                            <td colspan=""><label>Valor total</label></td>
                        </tr>
                        <tr>
                            <td colspan="">
                                <input type="text" name="valortotal" id="valortotal" class="texto02" alt="decimal" value="<?= number_format($valor, 2, ",", "."); ?>"  />
                                <input type="hidden" name="internacao_id" id="internacao_id" class="texto01" value="<?= $internacao_id; ?>"/>
                                <input type="hidden" name="internacao_procedimentos_id" id="internacao_procedimento_id" class="texto01" value="<?= $internacao_procedimentos_id; ?>"/>
                            </td>

                        </tr>
                    </table>

                    <hr/>
                    <button type="submit" name="btnEnviar" id="btnEnviar">
                        Enviar
                    </button>
                </fieldset>
            </form>

        </div>
    </div> <!-- Final da DIV content -->
</body>
<style>
    .texto02 { width: 80pt; }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/fullcalendar/lib/jquery.min.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-cookie.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-treeview.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.bestupper.min.js"  ></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<script type="text/javascript">

    (function ($) {
        $(function () {
            $('input:text').setMask();
        });
    })(jQuery);
</script>