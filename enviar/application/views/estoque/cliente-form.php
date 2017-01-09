<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Setor</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>estoque/cliente/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtestoqueclienteid" class="texto10" value="<?= @$obj->_estoque_cliente_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                    <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" name="txttelefone" class="texto10 bestupper" alt="phone" value="<?= @$obj->_telefone; ?>" />
                    </dd>
                    
                    <dt>
                    <label>Menu</label>
                    </dt>
                    <dd>
                        <select name="menu" id="menu" class="size4">
                            <? foreach ($menu as $value) : ?>
                                <option value="<?= $value->estoque_menu_id; ?>"<?
    if (@$obj->_menu == $value->estoque_menu_id):echo 'selected';
    endif;
    ?>><?php echo $value->descricao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <dt>
                    <label>Sala</label>
                    </dt>
                    <dd>
                        <select name="sala" id="sala" class="size4">
                            <option value="">SELECIONE</option>
                            <? foreach ( $sala as $item ){ ?>
                            <option value="<?= $item->exame_sala_id; ?>"><?= $item->nome; ?></option>
                            <? } ?>
                        </select>
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

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>estoque/cliente');
    });

    $(function() {
        $("#accordion").accordion();
    });

</script>