<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>cadastros/contaspagar">
            Voltar
        </a>
        <!--ponto/horarioscontaspagar-->        
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Contas a pagar</a></h3>
        <div>
            <form name="form_contaspagar" id="form_contaspagar" action="<?= base_url() ?>cadastros/contaspagar/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Valor *</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="financeiro_contaspagar_id" class="texto_id" name="financeiro_contaspagar_id" value="<?= @$obj->_financeiro_contaspagar_id; ?>" />
                        <input type="text" name="valor" id="valor" alt="decimal" class="texto04" value="<?= @$obj->_valor; ?>"/>
                    </dd>
                    <dt>
                        <label>Data*</label>
                    </dt>
                    <dd>
                        <input type="text" name="inicio" id="inicio" class="texto04" value="<?= @$obj->_data; ?>"/>
                    </dd>
                    <dt>
                        <label>Pagar a:</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="credor" class="texto_id" name="credor" value="<?= @$obj->_credor; ?>" />
                        <input type="text" id="credorlabel" class="texto09" name="credorlabel" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                        <label>Tipo numero</label>
                    </dt>
                    <dd>
                        <input type="text" name="tiponumero" id="tiponumero" class="texto04" value="<?= @$obj->_tipo_numero; ?>"/>
                    </dd>
                    <dt>
                        <label>Tipo</label>
                    </dt>
                    <dd>
                        <select name="tipo" id="tipo" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($tipo as $value) : ?>
                                <option value="<?= $value->tipo_entradas_saida_id; ?>"                            <?
                                if ($value->descricao == @$obj->_tipo):echo'selected';
                                endif;
                                ?>
                                        ><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Classe</label>
                    </dt>
                    <dd>
                        <select name="classe" id="classe" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($classe as $value) : ?>
                                <option value="<?= $value->descricao; ?>"
                                <?
                                if ($value->descricao == @$obj->_classe):echo'selected';
                                endif;
                                ?>
                                        ><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Conta *</label>
                    </dt>
                    <dd>
                        <select name="conta" id="conta" class="size4">
                            <option value="">Selecione</option>
                            <? foreach ($conta as $value) : ?>
                                <option value="<?= $value->forma_entradas_saida_id; ?>"<?
                                if (@$obj->_conta_id == $value->forma_entradas_saida_id):echo'selected';
                                endif;
                                ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>

                    <dt>
                        <label>Repetir </label>
                    </dt>
                    <dd>
                        <input type="text" name="repitir" alt="integer" class="texto02" value="<?= @$obj->_numero_parcela; ?>"/> nos proximos meses
                    </dd>
                    <dt>
                        <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="70" rows="3" name="Observacao" id="Observacao" ><?= @$obj->_observacao; ?></textarea><br/>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function () {
        $("#credorlabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=credordevedor",
            minLength: 1,
            focus: function (event, ui) {
                $("#credorlabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#credorlabel").val(ui.item.value);
                $("#credor").val(ui.item.id);
                return false;
            }
        });
    });


    $(function () {
        $('#tipo').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/classeportiposaidalista', {nome: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].classe + '">' + j[c].classe + '</option>';
                    }
                    $('#classe').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#classe').html('<option value="">TODOS</option>');
            }
        });
    });

    $(function () {
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

    $(function () {
        $("#accordion").accordion();
    });



    $(document).ready(function () {
        jQuery('#form_contaspagar').validate({
            rules: {
                valor: {
                    required: true
                },
                credor: {
                    required: true
                },
                classe: {
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
                credor: {
                    required: "*"
                },
                classe: {
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