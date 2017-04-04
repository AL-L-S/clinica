<body bgcolor="#C0C0C0">
    <meta charset="UTF-8">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Alterar Valor Procedimento</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentocirurgicovalor/<?=$valor[0]->agenda_exames_id?>" method="post">
                <fieldset>

                    <dl class="dl_desconto_lista">
                        <dt>
                            <label > Valor Antigo </label>
                        </dt>
                        <dd>
                            <input type="text" name="valor_antigo" alt="decimal" id="valor_antigo" readonly class="texto01" value="<?=number_format($valor[0]->valor_total, 2, ',', '.') ?>" />

                        </dd>
                        <dt>
                            <label > Novo Valor </label>
                        </dt>
                        <dd>
                            <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" class="texto01" value="<?=$valor[0]->agenda_exames_id;?>" />
                            <input type="text" name="valor" alt="decimal" id="valor" class="texto01" value="<?=number_format($valor[0]->valor_total, 2, ',', '.') ?>" />

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
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskMoney.js"></script>
<script type="text/javascript">

    //    (function($){
    //        $(function(){
    //            $('input:text').setMask();
    //        });
    //    })(jQuery);
    
    $(function() {
    $('#valor').maskMoney();
  })
   

</script>