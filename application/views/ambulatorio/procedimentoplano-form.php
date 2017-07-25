<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de valor Procedimento</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <input type="hidden" name="txtprocedimentoplanoid" value="<?= @$obj->_procedimento_convenio_id; ?>" />
                    <dt>
                        <label>Procedimento *</label>
                    </dt>
                    <dd>
                        <select name="procedimento" id="procedimento" class="size4">
                            <? foreach ($procedimento as $value) : ?>
                                <option value="<?= $value->procedimento_tuss_id; ?>"<?
                                if (@$obj->_procedimento_tuss_id == $value->procedimento_tuss_id):echo'selected';
                                endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Convenio *</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size4">
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>"<?
                                if (@$obj->_convenio_id == $value->convenio_id):echo'selected';
                                endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Qtde CH</label>
                    </dt>
                    <dd>
                        <input type="text" name="qtdech" id="qtdech" class="texto01" value="<?= @$obj->_qtdech; ?>"/>
                    </dd>
                    <dt>
                        <label>Valor CH</label>
                    </dt>
                    <dd>
                        <input type="text" name="valorch" id="valorch" class="texto01" value="<?= @$obj->_valorch; ?>"/>
                    </dd>
                    <dt>
                        <label>Qtde Filme</label>
                    </dt>
                    <dd>
                        <input type="text" name="qtdefilme" id="qtdefilme" class="texto01" value="<?= @$obj->_qtdefilme; ?>" />
                    </dd>
                    <dt>
                        <label>Valor Filme</label>
                    </dt>
                    <dd>
                        <input type="text" name="valorfilme" id="valorfilme" class="texto01" value="<?= @$obj->_valorfilme; ?>" />
                    </dd>
                    <dt>
                        <label>Qtde Porte</label>
                    </dt>
                    <dd>
                        <input type="text" name="qtdeporte" id="qtdeporte" class="texto01" value="<?= @$obj->_qtdeporte; ?>" />
                    </dd>
                    <dt>
                        <label>Valor Porte</label>
                    </dt>
                    <dd>
                        <input type="text" name="valorporte" id="valorporte" class="texto01" value="<?= @$obj->_valorporte; ?>" />
                    </dd>
                    <dt>
                        <label>Qtde UCO</label>
                    </dt>
                    <dd>
                        <input type="text" name="qtdeuco" id="qtdeuco" class="texto01" value="<?= @$obj->_qtdeuco; ?>" />
                    </dd>
                    <dt>
                        <label>Valor UCO</label>
                    </dt>
                    <dd>
                        <input type="text" name="valoruco" onblur="history.go(0)"id="valoruco" class="texto01" value="<?= @$obj->_valoruco; ?>" />
                    </dd>
                    <dt>
                        <label>Valor TOTAL</label>
                    </dt>
                    <dd>
                        <input type="text" name="valortotal" onkeyup="multiplica()" id="valortotal" class="texto01" value="<?= @$obj->valortotal; ?>" />
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
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
                            $('#btnVoltar').click(function () {
                                $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
                            });

                            $(function () {
                                $("#accordion").accordion();
                            });

                            $(document).ready(function () {

                                function multiplica()
                                {
                                    total = 0;
                                    numer1 = parseFloat(document.form_procedimentoplano.qtdech.value);
                                    numer2 = parseFloat(document.form_procedimentoplano.valorch.value);
                                    soma = numer1 * numer2;
                                    numer3 = parseFloat(document.form_procedimentoplano.qtdefilme.value);
                                    numer4 = parseFloat(document.form_procedimentoplano.valorfilme.value);
                                    soma2 = numer3 * numer4;
                                    numer5 = parseFloat(document.form_procedimentoplano.qtdeuco.value);
                                    numer6 = parseFloat(document.form_procedimentoplano.valoruco.value);
                                    soma3 = numer5 * numer6;
                                    numer7 = parseFloat(document.form_procedimentoplano.qtdeporte.value);
                                    numer8 = parseFloat(document.form_procedimentoplano.valorporte.value);
                                    soma4 = numer7 * numer8;
                                    total += soma + soma2 + soma3 + soma4;
                                    y = total.toFixed(2);
                                    $('#valortotal').val(y);
                                    //document.form_procedimentoplano.valortotal.value = total;
                                }
                                multiplica();


                            });

</script>