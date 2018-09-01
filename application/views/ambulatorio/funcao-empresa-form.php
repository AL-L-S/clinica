<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Fun&ccedil;&atilde;o</a></h3>

        <div>
            <form name="form_funcao" id="form_funcao" action="<?= base_url() ?>ambulatorio/saudeocupacional/gravarfuncao" method="post">

                <dl>
                    <dt>
                    <label>Nome da Fun&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtasofuncaoid" class="texto10" value="<?= @$obj[0]->aso_funcao_id; ?>" />
                        <input type="text" name="nome" class="texto10" value="<?= @$obj[0]->descricao_funcao; ?>" />
                    </dd> 
<!--                    <dt>
                    <label>Riscos</label>
                    </dt>
                    <dd>
                        <?
                        if(count(json_decode(@$obj[0]->aso_risco_id)) > 0){
                            $array_riscos = json_decode(@$obj[0]->aso_risco_id);
                        }else{
                            $array_riscos = array();
                        }
                        
                        
                        ?>
                        
                        <select name="txtrisco_id[]" id="txtrisco_id" style="width: 38%;" class="chosen-select" data-placeholder="Selecione os Riscos..." multiple>
                            <? foreach ($risco as $value) : ?>
                                <option value="<?= $value->aso_risco_id; ?>"<? if (in_array($value->aso_risco_id,$array_riscos)):echo 'selected';
                    endif;
                        ?>><?= $value->descricao_risco; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>-->
                 </dl> 
                <br><br>
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
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/saudeocupacional/pesquisarfuncao');
    });
  
    $(function() {
        $( "#accordion" ).accordion();
    });


</script>



