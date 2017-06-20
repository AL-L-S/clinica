
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div style="width: 100%">
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/empresa/gravarconfiguracaoemail" method="post">
            <fieldset>
                <legend>Configurações Serviço de Email</legend>
                <div style="width: 100%">
                    <label>Lembrete de Consulta</label>
                    <input type="text" id="lembrete" class="mensagem_texto" name="lembrete" value="<?= @$mensagem[0]->email_mensagem_confirmacao ?>"/>
                    <input type="hidden" id="empresa_id" name="empresa_id" value="<?= @$empresa_id ?>"/>
                </div>
                <div  style="width: 100%">
                    <label>Mensagem de Agradecimento</label>
                    <input type="text" id="agradecimento" class="mensagem_texto" name="agradecimento" value="<?= @$mensagem[0]->email_mensagem_agradecimento ?>"/>
                </div>

                <div style="width: 100%">
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                    <button type="reset" name="btnLimpar">Limpar</button>
                </div>
            </fieldset>
        </form>
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->
<style>
    .mensagem_texto{
        width: 500pt;
        /*font-size: 18pt;*/
        /*height: 50pt;*/
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });


</script>
