<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body bgcolor="#C0C0C0">

    <? $guia = $guia_id[0]->ambulatorio_guia_id; ?>
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Declara&ccedil;&atilde;o</h3>
        <div>
            <form name="form1" id="form1" action="<?= base_url() ?>ambulatorio/guia/impressaodeclaracaoguia/<?= $guia_id[0]->ambulatorio_guia_id ?>" method="post">
                <fieldset>
                    <dl class="dl_desconto_lista">
                        <dd>
                            <textarea id="declaracao" name="declaracao" cols="90" rows="30" ><?= $guia_id[0]->declaracao ?></textarea>
                        </dd>
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar">enviar</button>
                   

            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    $('#btnimprimir').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/guia/impressaodeclaracaoguia');
    });
</script>