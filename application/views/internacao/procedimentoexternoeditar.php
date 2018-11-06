<div class="content ficha_ceatox">
    <h3 class="h3_title">Procedimentos Externos</h3>
    <form name="procedimentoexterno_form" id="procedimentoexterno_form" action="<?=base_url() ?>internacao/internacao/gravarprocedimentoexternointernacao/<?=$internacao_id?>" method="post">
        <fieldset>
            <legend>Procedimento </legend>
            <div style="width:100%">
                <label>Procedimento* (Campo aberto)</label>                      
                <input required type="text" id="procedimento" name="procedimento"  class="texto09" value="<?= @$lista[0]->procedimento ?>"/>
            </div>
            <div style="width:100%">
                <label>Duração (Campo aberto)</label>                      
                <input type="text" id="duracao" name="duracao"  class="texto04" value="<?= @$lista[0]->duracao ?>"/>
            </div>
            <div style="width:100%">
                <label>Data*</label>                      
                <input required type="text" id="data" name="data"  class="texto04" value="<?=(@$lista[0]->data != '') ? date("d/m/Y",strtotime(@$lista[0]->data)) : ''; ?>"/>
            </div>
            <div>
                <label>Observações</label>
                <input type="hidden" name="internacao_procedimentoexterno_id" id="txtdiagnostico" value="<?=@$internacao_procedimentoexterno_id?>" >
                <textarea cols="" rows="" name="observacao" id="observacao" value="" class="texto_area"><?=@$lista[0]->observacao?></textarea>
            </div>
            
           
        </fieldset>
        <button type="submit" name="btnEnviar">Enviar</button>
        <button type="reset" name="btnLimpar">Limpar</button>
    </form>
</div>
<div class="clear"></div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script>

$(function () {
        $("#data").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

</script>
