<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Saida</a></h3>
        <div>
            <form name="form_emprestimo" id="form_emprestimo" action="<?= base_url() ?>cadastros/caixa/gravartransferencia" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Valor *</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" alt="decimal" class="texto04"/>
                    </dd>
                    <dt>
                    <label>Data*</label>
                    </dt>
                    <dd>
                        <input type="text" name="inicio" id="inicio" class="texto04"/>
                    </dd>
                    <dt>
                    <label>Conta Saida</label>
                    </dt>
                    <dd>
                        <select name="conta" id="conta" class="size2">
                            <? foreach ($conta as $value) : ?>
                                <option value="<?= $value->forma_entradas_saida_id; ?>"><?php echo $value->descricao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Conta Entrada</label>
                    </dt>
                    <dd>
                        <select name="contaentrada" id="contaentrada" class="size2">
                            <? foreach ($conta as $item) : ?>
                                <option value="<?= $item->forma_entradas_saida_id; ?>"><?php echo $item->descricao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="70" rows="3" name="Observacao" id="Observacao"></textarea><br/>
                    </dd>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    
    $(function() {
        $( "#devedorlabel" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=credordevedor",
            minLength: 1,
            focus: function( event, ui ) {
                $( "#devedorlabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#devedorlabel" ).val( ui.item.value );
                $( "#devedor" ).val( ui.item.id );
                return false;
            }
        });
    });


    $(function() {
        $( "#accordion" ).accordion();
    });

    $(function() {
        $( "#inicio" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(document).ready(function(){
        jQuery('#form_emprestimo').validate( {
            rules: {
                valor: {
                    required: true
                },
                tipo: {
                    required: true
                },
                inicio: {
                    required: true
                }
            },
            messages: {
                valor: {
                    required: "*"
                },
                tipo: {
                    required: "*"
                },
                inicio: {
                    required: "*"
                }
            }
        });
    });
</script>