<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Solicita&ccedil;&atilde;o</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>farmacia/solicitacao/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Setor</label>
                    </dt>
                    <dd>
                        <select name="setor" id="setor" class="size4">
                            <? foreach ($setor as $value) : ?>
                                <option value="<?= $value->farmacia_cliente_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">cadastrar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>farmacia/cliente');
    });

    $(function() {
        $("#accordion").accordion();
    });

</script>