<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Risco</a></h3>

        <div>
            <form name="form_risco" id="form_risco" action="<?= base_url() ?>ambulatorio/saudeocupacional/gravarrisco" method="post">

                <dl>
                    <dt>
                    <label>Nome do Risco</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtasoriscoid" class="texto10" value="<?= @$obj[0]->aso_risco_id; ?>" />
                        <input type="text" name="nome" class="texto10" value="<?= @$obj[0]->descricao_risco; ?>" />
                    </dd>                                   
                 </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
                                    
                                       
                    
                    
                     
                    
                    

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 130px; }
</style>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/saudeocupacional/pesquisarrisco');
    });
  
    $(function() {
        $( "#accordion" ).accordion();
    });


</script>

