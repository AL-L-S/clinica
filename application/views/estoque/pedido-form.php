<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Pedido</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/pedido/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Descrição</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="pedido_id" id="pedido_id" value="<?= @$obj->_estoque_pedido_id ?>"/>
                        <input type="text" name="descricao" id="descricao" value="<?= @$obj->_descricao ?>"/>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Cadastrar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
        $("#accordion").accordion();
    });

</script>