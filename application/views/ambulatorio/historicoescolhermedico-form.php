<meta charset="UTF-8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Escolher Médico Histórico</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/laudo/impressaohistorico/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>" method="get">
                <fieldset>

                    <input type="hidden" name="ambulatorio_laudo_id" id="ambulatorio_laudo_id" value="<?= $ambulatorio_laudo_id; ?>" onblur="history.go(0)" />
                    <table>
                        <tr>                            
                            <td>
                                <label>Medico</label>
                            </td>
                        </tr>
                        <tr>                            
                            <td>
                                <select name="medico_id" id="medico_id" class="size1">
                                    <option value="">Selecione</option>
                                    <option value="TODOS">Todos</option>
                                    <? foreach ($medicos as $item) : ?>
                                        <option value="<?= $item->operador_id; ?>" <?= ($item->operador_id == @$obj->_medico_encaminhamento_id) ? 'selected' : ''?>><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                                </select>

                            </td>
                        </tr>
                    </table>    

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(document).ready(function () {


    });

</script>