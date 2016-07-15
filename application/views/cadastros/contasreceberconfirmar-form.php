<div class="content"> <!-- Inicio da DIV content -->
        <?
        $data = @$obj->_data;
        $data = substr($data, 8,2) . "/" . substr($data, 5,2) . "/" . substr($data, 0,4);
        ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Contas a Receber</a></h3>
        <div>
            <form name="form_contasreceber" id="form_contasreceber" action="<?= base_url() ?>cadastros/contasreceber/confirmar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Valor *</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="financeiro_contasreceber_id" class="texto_id" name="financeiro_contasreceber_id" value="<?= @$obj->_financeiro_contasreceber_id; ?>" />
                        <input type="text" name="valor" alt="decimal" class="texto04" value="<?= @$obj->_valor; ?>"/>
                    </dd>
                    <dt>
                    <label>Data*</label>
                    </dt>
                    <dd>
                        <input type="text" name="inicio" id="inicio" class="texto04" value="<?= $data; ?>" readonly="true"/>
                    </dd>
                    <dt>
                    <label>Pagar a:</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="devedor" class="texto_id" name="devedor" value="<?= @$obj->_devedor; ?>" />
                        <input type="text" id="devedorlabel" class="texto09" name="devedorlabel" value="<?= @$obj->_razao_social; ?>" readonly="true"/>
                    </dd>
                    <dt>
                    <label>Tipo *</label>
                    </dt>
                    <dd>
                        <input type="text" name="tipo" id="tipo"  class="texto04" value="<?= @$obj->_tipo; ?>" readonly="true"/>
                    </dd>
                    <dt>
                    <label>Tipo numero</label>
                    </dt>
                    <dd>
                        <input type="text" name="tiponumero" id="tiponumero" class="texto04" value="<?= @$obj->_tipo_numero; ?>" readonly="true"/>
                    </dd>
                    <dt>
                    <label>Conta </label>
                    </dt>
                    <dd>
                        <input type="text" name="conta" class="texto02" value="<?= @$obj->_conta; ?>" readonly="true"/>
                        <input type="hidden" name="conta_id" class="texto02" value="<?= @$obj->_conta_id; ?>"/>
                    </dd>
                    <dt>
                    <label>Repetir </label>
                    </dt>
                    <dd>
                        <input type="text" name="repitir" alt="integer" class="texto02" value="<?= @$obj->_numero_parcela; ?>" readonly="true"/> nos proximos meses
                    </dd>
                    <dt>
                    <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="70" rows="3" name="Observacao" id="Observacao" readonly="true" ><?= @$obj->_observacao; ?></textarea><br/>
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
        $( "#accordion" ).accordion();
    });
    
    
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
                contasreceber: {
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
                contasreceber: {
                    required: "*"
                },
                inicio: {
                    required: "*"
                }
            }
        });
    });
</script>