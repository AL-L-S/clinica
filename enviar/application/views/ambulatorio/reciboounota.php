<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Procedimento</a></h3>
        <div>
            <form name="form" id="form" action="<?= base_url() ?>ambulatorio/guia/reciboounotaindicador" method="post">

                <input type="hidden" name="paciente_id" value="<?= $paciente_id ?>"/>
                <input type="hidden" name="guia_id" value="<?= $guia_id ?>"/>
                <input type="hidden" name="exames_id" value="<?= $exames_id ?>"/>
                <dl class="dl_cadastro_teto dt">

                    <dt>
                        <label>Recibo/Nota</label>
                    </dt>
                    <dd>
                        <select name="escolha" id="escolha" class="size1" >
                            <option value='' >Selecione</option>
                            <option value='R' >Recibo</option>
                            <option value='N' >Nota</option>
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

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });





</script>