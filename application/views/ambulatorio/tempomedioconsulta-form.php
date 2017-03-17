<body bgcolor="#C0C0C0">
    <meta charset="UTF-8">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Cadastrar Tempo Médio</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravartempomedioatendimento" method="post">
                <fieldset>

                    <dl class="dl_desconto_lista">
                        <dt>
                            <label title="Tempo médio de chegada até o Horário Marcado"> Tempo Chegada/Horário </label>
                        </dt>
                        <dd>
                            <input title="Tempo médio de chegada até o Horário Marcado" type="text" name="chegada" id="chegada" class="texto01" value="<?=@$tempo[0]->tempo_chegada;?>" />

                        </dd>
                        <dt>
                            <label title="Tempo médio do horário marcado até o Horário De Atendimento">Tempo Horário/Atend</label>
                        </dt>
                        <dd>
                            <input title="Tempo médio do horário marcado até o Horário De Atendimento" type="text" name="atendimento" id="atendimento" class="texto01" value="<?=@$tempo[0]->tempo_atendimento;?>" />

                        </dd>
                        <dt>
                            <label title="Tempo médio do horário de Atendimento até finalizar">Tempo Atend/Final</label>
                        </dt>
                        <dd>
                            <input type="text" name="finalizado" id="finalizado" class="texto01" value="<?=@$tempo[0]->tempo_finalizado;?>" />

                        </dd>
                        
                        
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

    //    (function($){
    //        $(function(){
    //            $('input:text').setMask();
    //        });
    //    })(jQuery);
    $('#chegada').mask('99:99:99');
    $('#atendimento').mask('99:99:99');
    $('#finalizado').mask('99:99:99');

</script>