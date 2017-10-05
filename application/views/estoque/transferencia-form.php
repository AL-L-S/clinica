<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Transferência de Armazem</a></h3>

        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>estoque/armazem/gravartransferencia/" method="post">

                <dl class="dl_desconto_lista">

                    <dt>
                        <label>Armazem De Entrada</label>
                    </dt>
                    <dd>
                        <select name="armazementrada" id="armazementrada" class="size4" required="">
                            <option value="">SELECIONE</option>
                            <? foreach ($armazem as $value) : ?>
                                <option value="<?= $value->estoque_armazem_id; ?>"<?
                                if (@$obj->_armazem_id == $value->estoque_armazem_id):echo'selected';
                                endif;
                                ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Armazem De Saída</label>
                    </dt>
                    <dd>
                        <select name="armazem" id="armazem" class="size4" required="">
                            <option value="">SELECIONE</option>
                            <? foreach ($armazem as $value) : ?>
                                <option value="<?= $value->estoque_armazem_id; ?>"<?
                                if (@$obj->_armazem_id == $value->estoque_armazem_id):echo'selected';
                                endif;
                                ?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Produto</label>
                    </dt>
                    <dd>
                        <style>
                            #produto_chosen a{
                                width: 400px;
                            }

                        </style>
                        <select name="produto" id="produto" data-placeholder="Selecione" class="size4 chosen-select" required  tabindex="1">
                            <option value="">SELECIONE</option>

                        </select>
                    </dd>
                    <dt>
                        <label>Entrada</label>
                    </dt>
                    <dd>
                        <select name="entrada" id="entrada" class="size4" required="">

                        </select>
                    </dd>

                    <dt>
                        <label>Quantidade</label>
                    </dt>
                    <dd>
                        <input type="number" id="quantidade" class="texto02" alt="integer" name="quantidade" min="1" value="<?= @$obj->_quantidade; ?>" required=""/>
                    </dd>

                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript">

//    $("#quantidade").prop('max','5');
//    var options = $("#quantidade").prop('max','5');
    $(function () {
        $('#armazem').change(function () {
            if ($(this).val()) {

//                var teste = $("#entrada").val();
//                alert(teste);
//                $("#produto").prop('disabled', false);
            } else {
//                $("#produto").prop('disabled', true);
            }
        });
    });

    $(function () {
        $('#armazem').change(function () {
            if ($(this).val()) {

//                $('#entrada').hide();
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/armazemtransferenciaentradaproduto', {produto: $(this).val(), armazem: $("#armazem").val()}, function (j) {
                    options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].produto_id + '">' + j[i].descricao + '</option>';
                    }
//                    $('#produto').html(options).show();
                    alert(options);
                    $('#produto option').remove();
                    $('#produto').append(options);
                    $("#produto").trigger("chosen:updated");
                    $('.carregando').hide();
                });
            } else {
                alert('s');
                $('#produto').html('<option value="">ESCOLHA UM ARMAZEM</option>');
            }
        });
    });

    $(function () {
        $('#produto').change(function () {
            if ($(this).val()) {

//                $('#entrada').hide();
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/armazemtransferenciaentrada', {produto: $(this).val(), armazem: $("#armazem").val()}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        if (j[i].total < 0)
                            continue;
                        options += '<option value="' + j[i].estoque_entrada_id + '">QTDE: ' + j[i].total + '  Produto:  ' + j[i].descricao + ' Armazem:' + j[i].armazem + '  </option>';
                    }
                    $('#entrada').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#entrada').html('<option value="">ESCOLHA UM ARMAZEM E UM PRODUTO</option>');
            }
        });
    });

    $(function () {
        $('#entrada').change(function () {
            if ($(this).val()) {

//                $('#entrada').hide();
//                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/armazemtransferenciaentradaquantidade', {produto: $(this).val()}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].estoque_entrada_id + '">QTDE: ' + j[i].total + '  Produto:  ' + j[i].descricao + ' Armazem:' + j[i].armazem + '  </option>';
                    }
                    $("#quantidade").prop('max', j[0].total);
//                    alert(j[0].total);
//                    if(){
//                        
//                    }
//                    $('#entrada').html(options).show();
//                    $('.carregando').hide();
                });
            } else {
//                $('#entrada').html('<option value="">ESCOLHA UM ARMAZEM E UM PRODUTO</option>');
            }
        });
    });

    $(function () {
        $("#accordion").accordion();
    });
</script>