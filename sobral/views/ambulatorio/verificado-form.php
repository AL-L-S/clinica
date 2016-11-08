<body bgcolor="#C0C0C0">
<div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">ALTERACAO</h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/guia/gravarverificado/<?= $verificado['0']->agenda_exames_id; ?>" method="post">
                <fieldset>
                <dl class="dl_desconto_lista">
                    <dt>
                    <label>VALOR</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor2" class="texto01" value="<?= $verificado['0']->valor_total; ?>" readonly/>
                    </dd>
                    <dt>
                    <label>FORMA DE PAGAMENTO</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor3" class="texto01" value="<?= $verificado['0']->forma; ?>" readonly/>
                    </dd>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">OK</button>
            </form>
            </fieldset>
        </div>
</div> <!-- Final da DIV content -->
</body>
<script type="text/javascript">
    $(function() {
        $( "#accordion" ).accordion();
    });


</script>