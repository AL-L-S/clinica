<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Transferência de Armazem</a></h3>

        <div>
            <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>estoque/armazem/gravartransferencia/<?=$estoque_armazem_id?>" method="post">

                <dl class="dl_desconto_lista">
                    
                    <dt>
                    <label>Armazem Escolhido</label>
                    </dt>
                    <dd>
                        <input value="<?=$obj->_descricao?>" readonly="" class="texto06"> </inpu>
                    </dd>
                    <dt>
                    <label>Armazem</label>
                    </dt>
                    <dd>
                        <select name="armazem" id="armazem" class="size4">
                            <option value="">SELECIONE</option>
                            <? foreach ($armazem as $value) : ?>
                                <option value="<?= $value->estoque_armazem_id; ?>"<?
                            if(@$obj->_armazem_id == $value->estoque_armazem_id):echo'selected';
                            endif;?>><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Produto</label>
                    </dt>
                    <dd>
                        <select name="produto" id="produto" class="size4">
                            <option value="">SELECIONE</option>
                            <? foreach ($produto as $value) : ?>
                                <option value="<?= $value->estoque_produto_id; ?>"><?php echo $value->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Entrada</label>
                    </dt>
                    <dd>
                        <select name="entrada" id="entrada" class="size4">
                            
                        </select>
                    </dd>
                    
                    <dt>
                    <label>Quantidade</label>
                    </dt>
                    <dd>
                        <input type="text" id="quantidade" class="texto02" alt="integer" name="quantidade" value="<?= @$obj->_quantidade; ?>" />
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
<script type="text/javascript">
    
    $(function() {
        $( "#txtfornecedorlabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=fornecedor",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtfornecedorlabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtfornecedorlabel" ).val( ui.item.value );
                $( "#txtfornecedor" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#txtprodutolabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=produto",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtprodutolabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtprodutolabel" ).val( ui.item.value );
                $( "#txtproduto" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(function() {
        $( "#validade" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    
    
    $(function() {
        $('#produto').change(function() {
            if ($(this).val()) {
                
//                $('#entrada').hide();
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/armazemtransferenciaentrada', {produto: $(this).val(), armazem: $("#armazem").val()}, function(j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].estoque_entrada_id + '">QTDE: ' + j[i].total +  '  Produto:  ' + j[i].descricao + ' Armazem:' + j[i].armazem + '  </option>';
                    }
                    $('#entrada').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#entrada').html('<option value="">ESCOLHA UM ARMAZEM E UM PRODUTO</option>');
            }
        });
    });

    $(function() {
        $( "#accordion" ).accordion();
    });
</script>