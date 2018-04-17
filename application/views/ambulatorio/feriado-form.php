<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/agenda/pesquisarferiados">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Feriado</a></h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/agenda/gravarferiado" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="feriado_id" value="<?= @$obj->feriado_id; ?>" />
                        <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$obj->nome; ?>" />
                    </dd>
                    <dt>
                        <label>Data</label>
                    </dt>
                    <dd>
                        <input type="text" id="data" alt="date" name="data" class="size1"  value="<?= @$obj->data; ?>" />
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
    $(function() {
        $( "#accordion" ).accordion();
    });
        
    $(function () {
        $("#data").datepicker({
            autosize: true,
//            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm'
        });
    });

</script>