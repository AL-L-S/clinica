<div > <!-- Inicio da DIV content -->
        <div class="bt_link_voltar">
        <a href="<?=  base_url()?>ambulatorio/modelolaudo">
            Voltar
        </a>
    </div>
    <div>
        <h3 class="singular">Cadastro Modelo Laudo</h3>
        <div>
            <form name="form_modelolaudo" id="form_modelolaudo" action="<?= base_url() ?>ambulatorio/modelolaudo/gravar" method="post">
                <div>
                    <textarea id="laudo" name="laudo" class="jqte-test" ><?= @$obj->_texto; ?></textarea>
                </div>

            <fieldset>
                <div>
                <label>Nome</label>
                    <input type="hidden" name="ambulatorio_modelo_laudo_id" class="texto10" value="<?= @$obj->_ambulatorio_modelo_laudo_id; ?>" />
                    <input type="text" name="txtNome" id="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                </div>
                <div>
                    <label>Medicos</label>
                        <select name="medico" id="medico" class="size4">
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>"<?
                            if (@$obj->_medico_id == $value->operador_id):echo'selected';
                            endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </div>
                <div>
                    <label>Procedimento</label>
                        <select name="procedimento" id="procedimento" class="size4">
                            <? foreach ($procedimentos as $value) : ?>
                                <option value="<?= $value->procedimento_tuss_id; ?>"<?
                            if (@$obj->_procedimento_tuss_id == $value->procedimento_tuss_id):echo'selected';
                            endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </div>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-te-1.4.0.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $('.jqte-test').jqte();
    $(document).ready(function(){
        jQuery('#form_modelolaudo').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>