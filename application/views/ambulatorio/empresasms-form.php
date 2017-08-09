<script>
    function mostrarPopUpIndentificao(){
        var mens = "Numeros de Indentificação:\n";
        <? foreach ($numeros_indentificacao as $value) {?>
                mens += "<?= $value->nome_empresa; ?> = <?= $value->numero_indentificacao; ?>\n";
        <?}?>
        alert(mens);
    }
</script>

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div style="width: 100%">
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/empresa/gravarconfiguracaosms" method="post">
            <fieldset>
                <legend>Dados do Pacote</legend>
                <? $operador_id = $this->session->userdata('operador_id');
                if ($operador_id == 1) {
                    ?>
                    <div style="width: 100%">
                        <label>Pacote</label>
                        <input type="hidden" name="sms_id" value="<?= @$mensagem[0]->empresa_sms_id ?>"/>
                        <input type="hidden" name="empresa_id" value="<?= $empresa_id ?>"/>
                        <select name="txtpacote" id="txtpacote" class="size2" required="">
                            <option value="">Selecione</option>
                                <? foreach ($pacotes as $item) : ?>
                                <option value="<?= $item->pacote_sms_id; ?>" <?= (@$item->pacote_sms_id == @$mensagem[0]->pacote_id) ? "selected" : ''; ?>>
                                <?= $item->descricao_pacote; ?>
                                </option>
                                <? endforeach; ?>
                        </select>
                    </div>
                    <div style="width: 100%">
                        <label onclick="mostrarPopUpIndentificao()">Identificação da Empresa</label>
                        <input type="text" name="numero_identificacao_sms" value="<?= @$mensagem[0]->numero_indentificacao_sms ?>"/>
                    </div>
                <? } ?>
                <div style="width: 100%">
                    <input type="checkbox" id="msgensExcedentes" name="msgensExcedentes" <? if (@$mensagem[0]->enviar_excedentes == 't') echo "checked" ?>/>
                    <label for="msgensExcedentes" style="display: inline; font-size: 10pt; color: black;"> 
                        <span title="Isso implicara em cobranças a cada mensagem excedente.">Permitir envio de mensagens ao fim do pacote?</span>
                    </label>
                </div>
                <div style="width: 100%">
                    <label>Mensagem Confirmaçao</label>
                    <input type="text" id="txtMensagemConfirmacao" class="mensagem_texto" name="txtMensagemConfirmacao" value="<?= @$mensagem[0]->mensagem_confirmacao ?>"/>
                </div>
                <div  style="width: 100%">
                    <label>Mensagem de Agradecimento</label>
                    <input type="text" id="txtMensagemAgradecimento" class="mensagem_texto" name="txtMensagemAgradecimento" value="<?= @$mensagem[0]->mensagem_agradecimento ?>"/>
                </div>
                <div style="width: 100%">
                    <label>Mensagem de Aniversariantes</label>
                    <input type="text" id="txtMensagemAniversariantes" class="mensagem_texto" name="txtMensagemAniversariantes" value="<?= @$mensagem[0]->mensagem_aniversariante ?>"/>
                </div>

                <div style="width: 100%">
                    <label>Mensagem de Revisão</label>
                    <input type="text" id="txtMensagemRevisao" class="mensagem_texto" name="txtMensagemRevisao" value="<?= @$mensagem[0]->mensagem_revisao ?>"/>
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
