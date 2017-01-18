<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#"></a></h3>
        <div>
            <form name="form_sala" id="form_sala" action="<?= base_url() ?>centrocirurgico/centrocirurgico/orcamentoescolha/<?=$solicitacao_id?>/<?=$convenio_id?>" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <input type="hidden" name="solicitacao_id" value="<?= $solicitacao_id ?>"/>
                        <input type="hidden" name="convenio_id" value="<?= $convenio_id ?>"/>
                        <label>Nessecita de orçamento?</label>
                    </dt>
                    <dd>
                        <select name="escolha" id="escolha" class="texto04" required>
                            <option value="">Selecione</option>
                            <option value="SIM">SIM</option>
                            <option value="NAO">NÃO</option>
                        </select>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


    $(function () {
        $("#accordion").accordion();
    });


</script>
