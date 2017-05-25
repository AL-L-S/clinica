<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Agrupador</a></h3>
        <div>
            <form name="form_formapagamento" id="form_formapagamento" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravaragrupadornome" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="agrupador_id" class="texto10" value="<?= @$agrupador[0]->agrupador_id; ?>" />
                        <input type="text" name="txtNome" class="texto05" value="<?= @$agrupador[0]->nome; ?>"/>
                    </dd>
                    
                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <select  name="convenio" id="convenio" class="size2" required="" >
                            <option value="">Selecione</option>
                            <? foreach ($convenio as $item) : ?>
                                <option value="<?= $item->convenio_id; ?>" <? if(@$agrupador[0]->convenio_id == $item->convenio_id) echo "selected";?>>
                                    <?= $item->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <!--<button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>-->
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
//    $('#btnVoltar').click(function () {
//        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
//    });

    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_formapagamento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                conta: {
                    required: true,
                    equal: ""
                }

            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                conta: {
                    required: "*",
                    equal: "*"
                }
            }
        });
    });

</script>
