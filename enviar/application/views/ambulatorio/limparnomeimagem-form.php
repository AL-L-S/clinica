<body bgcolor="#C0C0C0">
<div class="content"> <!-- Inicio da DIV content -->
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/laudo/gravarlimparnomes/<?= $exame_id;?>" method="post">
                <fieldset>
                    
                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Tem certeza que quer limpar os nome das imagens?</label>
                    </dt>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar" >OK</button>
            </form>
            </fieldset>
        </div>
</div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

</script>