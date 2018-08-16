<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Setor</a></h3>
<?php
    $this->load->library('utilitario');
    Utilitario::pmf_mensagem($this->session->flashdata('message'));
    ?>
        <div>
            <form name="form_setor" id="form_setor" action="<?= base_url() ?>ambulatorio/saudeocupacional/gravarsetor" method="post">

                <dl>
                    <dt>
                    <label>Nome do Setor</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtasosetorid" class="texto10" value="<?= @$obj[0]->aso_setor_id; ?>" />
                        <input type="text" name="nome" class="texto10" value="<?= @$obj[0]->descricao_setor; ?>" />
                    </dd>
                    <dt>
                    <label>Funções</label>
                    </dt>
                    <dd>
                        <?
                        if(count(json_decode(@$obj[0]->aso_funcao_id)) > 0){
                            $array_funcao = json_decode(@$obj[0]->aso_funcao_id);
                        }else{
                            $array_funcao = array();
                        }
                        
//                        var_dump($funcao);die;
                        ?>
                        <select name="txtfuncao_id[]" id="txtfuncao_id" style="width: 38%;" class="chosen-select" data-placeholder="Selecione as Funções..." multiple>
                            <? foreach ($funcao as $value) : ?>
                                <option value="<?= $value->aso_funcao_id; ?>"<? if (in_array($value->aso_funcao_id,$array_funcao)):echo 'selected';
                    endif;
                        ?>><?= $value->descricao_funcao; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
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
        $(location).attr('href', '<?= base_url(); ?>ambulatorio/saudeocupacional/pesquisarsetor');
    });
  
    $(function() {
        $( "#accordion" ).accordion();
    });


</script>