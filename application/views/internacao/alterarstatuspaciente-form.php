<body bgcolor="#C0C0C0">
<meta charset="UTF-8">
<div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Alterar Observacao</h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>internacao/internacao/gravarstatuspaciente/<?= $internacao_id; ?>" method="post">
                <fieldset>
                <dl class="dl_desconto_lista">
                    <div>
                    <label>Status</label>
                    
                    
                        <select name="status" id="status" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($status as $value) : ?>
                                <option value="<?= $value->internacao_statusinternacao_id; ?>" <?=($value->internacao_statusinternacao_id == $status_sele[0]->internacao_statusinternacao_id)?'selected': ''?>><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </div>
                     
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