<meta charset="UTF-8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Autorizar Orçamento</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/exame/gravarautorizarorcamento/<?= $ambulatorio_orcamento_id; ?>" method="post">
                <fieldset>

                    <input type="hidden" name="ambulatorio_orcamento_id" id="ambulatorio_orcamento_id" value="<?= $ambulatorio_orcamento_id; ?>" onblur="history.go(0)" />
                    <table>
                        <tr>                            
                            <td>
                                <label>Medico</label>
                            </td>
                        </tr>
                        <tr>                            
                            <td>
                                <select name="medico_id" id="medico_id" class="size1" required>
                                    <option value="">Selecione</option>
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