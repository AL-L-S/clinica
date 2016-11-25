<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>giah/servidor">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Servidor</a></h3>
        <div>
            <form name="form_corrigirprocessamento" id="form_corrigirprocessamento" action="<?= base_url() ?>ponto/corrigirprocessamento/gravar/<?= @$obj->_criticafinal_id; ?>/<?= $funcionario; ?>" method="post">

                <dl id="dl_form_servidor">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>"/>
                    </dd>
                    <dt>
                    <label>Data</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata" alt="date" class="texto02" value="<?= @$obj->_data; ?>" />
                    </dd>
                    <dt>
                    <label>Ent Padrao</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtentrada1"  alt="29:59:59" class="texto03" value="<?= @$obj->_entrada1; ?>" />
                    </dd>

                    <dt>
                    <label>Saida Padrao</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtsaida1"  alt="29:59:59" class="texto03" value="<?= @$obj->_saida1; ?>" />
                    </dd>
                    <dt>
                    <dt>
                    <label>Ent Extra</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtentrada2"  alt="29:59:59" class="texto03" value="<?= @$obj->_entrada2; ?>" />
                    </dd>

                    <dt>
                    <label>Saida Extra</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtsaida2"  alt="29:59:59" class="texto03" value="<?= @$obj->_saida2; ?>" />
                    </dd>
                    <dt>
                    <dt>
                    <label>Ent Extensao</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtentrada3"  alt="29:59:59" class="texto03" value="<?= @$obj->_entrada3; ?>" />
                    </dd>

                    <dt>
                    <label>Saida Extensao</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtsaida3"  alt="29:59:59" class="texto03" value="<?= @$obj->_saida3; ?>" />
                    </dd>
                    <dt>
                    <label>Critica</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtcritica1"   class="texto10" value="<?= @$obj->_critica1; ?>" />
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/funcionario');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });





</script>
