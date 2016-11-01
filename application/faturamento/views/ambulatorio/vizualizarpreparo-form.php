<body bgcolor="#C0C0C0">
<div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Vizualizar Preparo</h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/exame/observacaogravar" method="post">
                <fieldset>
                    
                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Preparo</label>
                    </dt>
                        <textarea type="text" name="txtobservacao" cols="110" rows="15" class="texto12"><?= $preparo[0]->texto; ?></textarea>

                     
                </dl>    

            </form>
            </fieldset>
        </div>
</div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_horariostipo').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtTipo: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtTipo: {
                    required: "*"
                }
            }
        });
    });

</script>