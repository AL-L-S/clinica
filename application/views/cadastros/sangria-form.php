<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Sangria</a></h3>
        <div>
            <form name="form_emprestimo" id="form_emprestimo" action="<?= base_url() ?>cadastros/caixa/gravarsangria" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Valor *</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" alt="decimal" class="texto04"/>
                    </dd>
                    <dt>
                    <label>Caixa</label>
                    </dt>
                    <dd>
                        <select name="caixa" id="caixa" class="size4">
                            <? foreach ($operadorcaixa as $value) : ?>
                                <option value="<?= $value->operador_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Operador</label>
                    </dt>
                    <dd>
                        <select name="operador" id="operador" class="size4">
                            <? foreach ($operador as $value) : ?>
                                <option value="<?= $value->operador_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Senha do Operador</label>
                    </dt>
                    <dd>
                        <input type="password" name="senha" id="senha" class="texto04"/>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


    $(function() {
        $("#accordion").accordion();
    });


    $(document).ready(function() {
        jQuery('#form_emprestimo').validate({
            rules: {
                valor: {
                    required: true
                },
                senha: {
                    required: true
                }
            },
            messages: {
                valor: {
                    required: "*"
                },
                senha: {
                    required: "*"
                }
            }
        });
    });
</script>