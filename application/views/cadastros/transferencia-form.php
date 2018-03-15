<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Saida</a></h3>
        <div>
            <form name="form_emprestimo" id="form_emprestimo" action="<?= base_url() ?>cadastros/caixa/gravartransferencia" method="post">
                <?
                $empresas = $this->exame->listarempresas();
                $empresa_atual = $this->session->userdata('empresa_id');
                ?>
                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Valor *</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" alt="decimal" class="texto04" required=""/>
                    </dd>
                    <dt>
                        <label>Data*</label>
                    </dt>
                    <dd>
                        <input type="text" name="inicio" id="inicio" class="texto04" required/>
                    </dd>
                    <dt>
                        <label>Empresa Saída</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresas as $value) : ?>
                                <option <?
                                if ($empresa_atual == $value->empresa_id) {
                                    echo 'selected';
                                }
                                ?> value="<?= $value->empresa_id; ?>"><?php echo $value->nome; ?></option>
<? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Conta Saida</label>
                    </dt>
                    <dd>
                        <select name="conta" id="conta" class="size2" required>
                            <? foreach ($conta as $value) : ?>
                                <option value="<?= $value->forma_entradas_saida_id; ?>"><?php echo $value->descricao; ?></option>
<? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Empresa Entrada</label>
                    </dt>
                    <dd>
                        <select name="empresaentrada" id="empresaentrada" class="size2">
                            <? foreach ($empresas as $value) : ?>
                                <option <?
                                    if ($empresa_atual == $value->empresa_id) {
                                        echo 'selected';
                                    }
                                    ?> value="<?= $value->empresa_id; ?>"><?php echo $value->nome; ?></option>
<? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Conta Entrada</label>
                    </dt>
                    <dd>
                        <select name="contaentrada" id="contaentrada" class="size2" required>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
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
        $('#empresa').change(function () {
//                                            if ($(this).val()) {
            $('.carregando').show();
            $.getJSON('<?= base_url() ?>autocomplete/contaporempresa', {empresa: $(this).val(), ajax: true}, function (j) {
                options = '<option value=""></option>';
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].forma_entradas_saida_id + '">' + j[c].descricao + '</option>';
                }
                $('#conta').html(options).show();
                $('.carregando').hide();
            });
//                                            } else {
//                                                $('#nome_classe').html('<option value="">TODOS</option>');
//                                            }
        });
    });

    $(function () {
        $('#empresaentrada').change(function () {
//                                            if ($(this).val()) {
            $('.carregando').show();
            $.getJSON('<?= base_url() ?>autocomplete/contaporempresa', {empresa: $(this).val(), ajax: true}, function (j) {
                options = '<option value=""></option>';
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].forma_entradas_saida_id + '">' + j[c].descricao + '</option>';
                }
                $('#contaentrada').html(options).show();
                $('.carregando').hide();
            });
//                                            } else {
//                                                $('#nome_classe').html('<option value="">TODOS</option>');
//                                            }
        });
    });

    $(function () {
        $("#accordion").accordion();
    });




</script>