<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Situação</a></h3>
<?php
    $this->load->library('utilitario');
    Utilitario::pmf_mensagem($this->session->flashdata('message'));
    ?>
        <div>
            <form name="form_situacao" id="form_situacao" action="<?= base_url() ?>ambulatorio/saudeocupacional/gravarsituacao" method="post">

                <dl>
                    <dt>
                    <label>Situação</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtasosituacao" class="texto10" value="<?= @$obj[0]->aso_situacao_id; ?>" />
                        <input type="text" name="nome" class="texto10" value="<?= @$obj[0]->descricao_situacao; ?>" />
                    </dd>

                 </dl> 
                <br><br>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>                
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
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/saudeocupacional/pesquisarsituacao');
    });
  
    $(function() {
        $( "#accordion" ).accordion();
    });


</script>

