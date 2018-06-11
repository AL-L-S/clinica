<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Sala</a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>ambulatorio/sala/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtexamesalaid" class="texto10" value="<?= @$obj->_exame_sala_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </dd>
<!--                    <dt>
                        <label>Nome Chamada</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtnomechamada" class="texto10" value="<?= @$obj->_nome_chamada; ?>" />
                    </dd>-->
<!--                    <dt>
                        <label>Tipo de sala</label>
                    </dt>
                    <dd>
                        <select name="tipo" id="tipo" class="size2" >
                            <option value='CONSULTORIO'<?
                            if (@$obj->_tipo == 'CONSULTORIO'):echo 'selected';
                            endif;
                            ?>>CONSULTORIO</option>
                            <option value='EXAME'<?
                                    if (@$obj->_tipo == 'EXAME'):echo 'selected';
                                    endif;
                                    ?>>EXAME</option>
                        </select>
                    </dd>-->
                    <dt>
                        <label>Armazem</label>
                    </dt>
                    <dd>
                        <select name="armazem" id="armazem" class="size2">   
                            <option value="">SELECIONE</option>
                            <? foreach ($armazem as $value) : ?>
                                <option value="<?= $value->estoque_armazem_id; ?>"
                                        <? if (@$obj->_armazem_id == $value->estoque_armazem_id) {
                                            echo 'selected';
                                        }
                                        ?>><?php echo $value->descricao; ?></option>
<? endforeach; ?>

                        </select>
                    </dd>
<!--                    <dt>
                        <label>Grupo</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size2" >
                            <option value='' >Selecione</option>
                            <? // foreach ($grupos as $grupo) { ?>                                
                                <option value='<?= $grupo->nome ?>' <?
//                                if (@$obj->_grupo == $grupo->nome):echo 'selected';
//                                endif;
                                ?>><?= $grupo->nome ?></option>
                                    <? // } ?>
                        </select>
                    </dd>-->
                    <dt>
                        <label>Toten Sala ID</label>
                    </dt>
                    <dd>
                       <input type="number" name="toten_sala_id" class="texto01" value="<?= @$obj->_toten_sala_id; ?>" />
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <!--<button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>-->
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
//    $('#btnVoltar').click(function () {
//        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
//    });

    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_sala').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>