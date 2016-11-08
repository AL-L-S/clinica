<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Marcar Exame</a></h3>
        <div>
            <form name="form_pacienteexame" id="form_pacienteexame" action="<?= base_url() ?>ambulatorio/exame/gravarpaciente" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type ="hidden" name ="txtagenda_exames_id" id ="txtagenda_exames_id" value ="<?= $agenda_exames_id; ?>">
                        <input type ="hidden" name ="txtpacienteid" id ="txtpacienteid">
                        <input type="text" id="txtpacientelabel" name="txtpacientelabel"  class="texto09" />
                    </dd>
                    <dt>
                    <label>Procedimento *</label>
                    </dt>
                    <dd>
                        <select name="txprocedimento" id="txprocedimento" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($procedimento as $item) : ?>
                                <option value="<?= $item->procedimento_tuss_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    </dl>  
                        <div id="chk_desc_inss">
                        <input type="checkbox" name="txtConfirmado"/><label>Confirmado</label>
                        </div>
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
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });
    
    $(function() {
        $( "#txtpacientelabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtpacientelabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtpacientelabel" ).val( ui.item.value );
                $( "#txtpacienteid" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(document).ready(function(){
        jQuery('#form_exame').validate( {
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