<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Saida</a></h3>
        <div>
            <form name="form_saida" id="form_saida" action="<?= base_url() ?>cadastros/caixa/gravarsaida" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Valor *</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" alt="decimal" class="texto04" value="<?= @$obj->_valor; ?>"/>
                        <input type="hidden" id="saida_id" class="texto_id" name="saida_id" value="<?= @$obj->_saida_id; ?>" />
                    </dd>
                    <dt>
                    <label>Data*</label>
                    </dt>
                    <dd>
                        <input type="text" name="inicio" id="inicio" class="texto04" value="<?= substr(@$obj->_data, 8, 2) . "-" . substr(@$obj->_data, 5, 2) . "-" . substr(@$obj->_data, 0, 4); ?>"/>
                    </dd>
                    <dt>
                    <label>Pagar a:</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="devedor" class="texto_id" name="devedor" value="<?= @$obj->_devedor; ?>" />
                        <input type="text" id="devedorlabel" class="texto09" name="devedorlabel" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                    <label>Tipo *</label>
                    </dt>
                    <dd>
                        <select name="tipo" id="tipo" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($tipo as $value) : ?>
                                <option value="<?= $value->descricao; ?>" <? if (@$obj->_tipo == $value->descricao):echo'selected';
                            endif;
                                ?>><?php echo $value->descricao; ?></option>
<? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Forma *</label>
                    </dt>
                    <dd>
                        <select name="conta" id="conta" class="size4">
                            <option value="">Selecione</option>
                                    <? foreach ($conta as $value) : ?>
                                <option value="<?= $value->forma_entradas_saida_id; ?>"<? if (@$obj->_forma == $value->forma_entradas_saida_id):echo'selected';
                                    endif;
                                        ?>><?php echo $value->descricao; ?></option>
<? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="70" rows="3" name="Observacao" id="Observacao"><?= @$obj->_observacao; ?></textarea><br/>
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
        $("#devedorlabel").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=credordevedor",
            minLength: 1,
            focus: function(event, ui) {
                $("#devedorlabel").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#devedorlabel").val(ui.item.value);
                $("#devedor").val(ui.item.id);
                return false;
            }
        });
    });


    $(function() {
        $("#accordion").accordion();
    });

    $(function() {
        $("#inicio").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(document).ready(function() {
        jQuery('#form_saida').validate({
            rules: {
                valor: {
                    required: true
                },
                devedor: {
                    required: true
                },
                tipo: {
                    required: true
                },
                conta: {
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
                devedor: {
                    required: "*"
                },
                tipo: {
                    required: "*"
                },
                conta: {
                    required: "*"
                },
                inicio: {
                    required: "*"
                }
            }
        });
    });
</script>