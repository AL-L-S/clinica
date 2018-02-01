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
                        <label>ID Leito</label>
                        <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->leito; ?>" readonly/>
                    </div>
                    
                    
                    
                    <div>
                        <label>data da Internacao</label>                      
                        <input type="text" id="data_internacao" name="data_internacao"  class="texto09" value="<?= date("d/m/Y H:i:s",strtotime($paciente[0]->data_internacao)); ?>" readonly/>
                    </div>
                    
                    <div>
                        <label>data de Nascimento</label>                      
                        <input type="text" id="data_nascimento" name="data_nascimento"  class="texto09" value="<?=  date("d/m/Y",strtotime($paciente[0]->nascimento)); ?>" readonly/>
                    </div>
                    
                    <div>
                        <label>Sexo</label>
                        <input type="text" id="sexo" name="sexo"  class="texto09" value="<?=$paciente[0]->sexo == 'M'? "Masculino": "Feminino"; ?>" readonly/>
                    </div> 
                    
                     <div>
                                             
                        <input type="hidden" id="txtidpaciente" name="idpaciente"  class="texto09" value="<?= $paciente[0]->paciente_id ?>" readonly/>
                    </div>
                    
                    
                    </fieldset>
                        
                    <fieldset>
                        <?if($paciente[0]->motivo_saida ==''){?>
                          <div>
                        <label>Motivo de Saida</label>
                        <input type="text"  name="leito" id="leito" class="texto09" value="Transferencia - <?=$paciente[0]->hospital_transferencia?>" readonly/>
                        </div>  
                        <?}
                        else{?>
                        <div> 
                            <label>Motivo de Saida</label>
                               
                        <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->motivosaida; ?>" readonly/>
                        </div> 
                        <?}?>
                        
    
                    <div>
                        <label>Observações</label>
                        
                        <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->observacao_saida; ?>" readonly/>
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
