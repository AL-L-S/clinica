<div class="content ficha_ceatox">
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>internacao/internacao/pesquisarsaida/">
            Voltar
        </a>
    </div>
    
        <div>
            <form name="form_paciente" id="form_paciente">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente[0]->paciente ?>" readonly/>
                    </div>
                    
                    <div>
                        <label> Leito</label>
                        <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->leito; ?>" readonly/>
                    </div>
                    
                    
                    
                    <div>
                        <label>Data da Internacao</label>                      
                        <input type="text" id="data_internacao" name="data_internacao"  class="texto09" value="<?php echo substr($paciente['0']->data_internacao, 8, 2) . '/' . substr($paciente['0']->data_internacao, 5, 2) . '/' . substr($paciente['0']->data_internacao, 0, 4); ?>" readonly/>
                    </div>
                    
                    <div>
                        <label>Data de Saída</label>                      
                        <input type="text" id="data_nascimento" name="data_nascimento"  class="texto09" value="<?php echo substr($paciente['0']->data_saida, 8, 2) . '/' . substr($paciente['0']->data_saida, 5, 2) . '/' . substr($paciente['0']->data_saida, 0, 4); ?>" readonly/>
                    </div>
                    
                   
                    
                     
                    
                    </fieldset>
                        
                    <fieldset>
                        <?if($paciente[0]->motivo_saida ==''){?>
                          <div>
                        <label>Motivo de Saida</label>
                        <input type="text"  name="leito" id="leito" class="texto09" value="Transferencia" readonly/>
                        </div>  
                        <?}
                        else{?>
                        <div> 
                            <label>Motivo de Saida</label>
                               
                        <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->motivo_saida; ?>" readonly/>
                        </div> 
                        <?}?>
                        <div>
                         <? if($paciente[0]->hospital_transferencia == null) {?><?
                             
                         } else { ?>
                          <label> Hospital de Transferência</label>                   
                        <input type="text" id="txtidpaciente" name="idpaciente"  class="texto09" value="<?= $paciente[0]->hospital_transferencia ?>" readonly/>
                    </div>
                    <?}?>
                        
    
                        <div>
                        <label>Observações</label>
                        <textarea  cols="" rows="" name="observacao" id="txtobservacao" class="texto_area" readonly><?= $paciente[0]->observacao_saida; ?></textarea>
                    </div>
                </fieldset>
               
                        
                </form>
                
                
        </div>
         
 <div class="clear"></div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
