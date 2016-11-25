<body bgcolor="#C0C0C0">
<div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Confirmar horario</h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/exame/bloqueargravar/<?= $agenda_exame_id; ?>" method="post">
                <fieldset>
                    
                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Deseja confirmar Bloqueio de Horario</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="agenda_exame_id" value="<?= $agenda_exame_id; ?>" />
                        <input type="text" name="txtNome" class="texto10 bestupper" value="<?= $inicio; ?>" readonly/>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">OK</button>
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