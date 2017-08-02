<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Excluir Procedimentos Por Grupo</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/excluirporgrupo" method="post">
                

                
                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Grupo*</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="convenio" id="convenio" value="<?= $convenio_id ?>"/>
                        <select name="grupo" id="grupo" class="size4" required>
                            <option value="">Selecione</option>
                            <? foreach ($grupos as $value) : ?>
                                <option value="<?= $value->nome; ?>"><?php echo $value->nome; ?></option>
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