<body bgcolor="#C0C0C0">
<div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">ALTERACAO</h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/laudo/calcularvolume" method="post">
                <fieldset>
                <dl class="dl_desconto_lista">
                    <dt>
                    <label>CONVENIO</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" class="texto01" value="<?= $alterado['0']->convenio; ?>" readonly/>
                    </dd>
                    <dt>
                    <label>PROCEDIMENTO</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor1" class="texto03" value="<?= utf8_decode($alterado['0']->procedimento); ?>" readonly/>
                    </dd>
                    <dt>
                    <label>VALOR</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor2" class="texto01" value="<?= $alterado['0']->editarvalor_total; ?>" readonly/>
                    </dd>
                    <dt>
                    <label>FORMA DE PAGAMENTO</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor3" class="texto01" value="<?= $alterado['0']->forma; ?>" readonly/>
                    </dd>
                    <dt>
                    <label>USUARIO ANTIGO</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor3" class="texto01" value="<?= $alterado['0']->usuario_antigo; ?>" readonly/>
                    </dd>
                    <dt>
                    <label>ALTERADO POR</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor3" class="texto01" value="<?= $alterado['0']->nome; ?>" readonly/>
                    </dd>
                </dl>    

                <hr/>
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