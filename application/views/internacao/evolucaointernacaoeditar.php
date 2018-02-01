<div class="content ficha_ceatox">
    <h3 class="h3_title">Evolucao de Notificação e de Atendimento</h3>
    <form name="evolucao_form" id="evolucao_form" action="<?=base_url() ?>internacao/internacao/gravarevolucaointernacao/<?=$internacao_id?>" method="post">
        <fieldset>
            <legend>Atendimento</legend>
            <div>
                <label>Diagnostico</label>
                <input type="hidden" name="internacao_evolucao_id" id="txtdiagnostico" value="<?=$internacao_evolucao_id?>" >
                <textarea cols="" rows="" name="txtdiagnostico" id="txtdiagnostico" value="" class="texto_area"><?=$lista[0]->diagnostico?></textarea>
            </div>
            <div>
                <label>Conduta</label>
                <textarea cols="" rows="" name="txtconduta" id="txtconduta" value="" class="texto_area"><?=$lista[0]->conduta?></textarea>
            </div>
            <div style="border-top: 1px solid rgba(0,0,0,.5); margin: 5pt; width: 89%; padding: 5pt;">
                <input type="checkbox" name="solicitasaida" value="on"> Solicitar saida
            </div>
        </fieldset>
        <button type="submit" name="btnEnviar">Enviar</button>
        <button type="reset" name="btnLimpar">Limpar</button>
    </form>
</div>
<div class="clear"></div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
