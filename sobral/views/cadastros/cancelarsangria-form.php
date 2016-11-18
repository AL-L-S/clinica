<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Sangria</a></h3>
        <div>
            <form name="form_emprestimo" id="form_emprestimo" action="<?= base_url() ?>cadastros/caixa/gravarcancelarsangria" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Valor *</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" alt="decimal" value="<?= $sangria[0]->valor; ?>" class="texto04" readonly/>
                    </dd>
                    <dt>
                    <label>Caixa</label>
                    </dt>
                    <dd>
                        <input type="text" name="operador" value="<?= $sangria[0]->operador; ?>" class="texto04"/>
                        <input type="hidden" name="operador_id" value="<?= $sangria[0]->operador_caixa; ?>" class="texto04"/>
                        <input type="hidden" name="sangria_id" value="<?= $sangria[0]->sangria_id; ?>" class="texto04"/>
                    </dd>
                    <dt>
                    <label>Senha</label>
                    </dt>
                    <dd>
                        <input type="password" name="senha" id="senha" class="texto04"/>
                    </dd>
                    <dt>
                    <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="70" rows="3" name="Observacao" id="Observacao"><?= $sangria[0]->observacao; ?></textarea><br/>
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