<?php if( count($paciente) == 0){ 
    echo "<p>Não há paciente neste leito.</p>";
} else {?>

<div class="content ficha_ceatox">
        <div>
            <form name="form_paciente" id="form_paciente">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente[0]->paciente ?>" readonly/>
                    </div>
                    
                    <div>
                        <label>Leito</label>
                        <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->leito; ?>" readonly/>
                    </div>
                    
                    
                    <div>
                        <label>data da Internacao</label>                      
                        <input type="text" id="data_internacao" name="data_internacao"  class="texto09" value="<?= $paciente[0]->data_internacao; ?>" readonly/>
                    </div>
                    
                    <div>
                        <label>data de Nascimento</label>                      
                        <input type="text" id="data_nascimento" name="data_nascimento"  class="texto09" value="<?= date('d/m/Y',  strtotime($paciente[0]->nascimento)); ?>" readonly/>
                    </div>
                    
                    <div>
                        <label>Sexo</label>
                        <input type="text" id="sexo" name="sexo"  class="texto09" value="<?=$paciente[0]->sexo == 'M'? "Masculino": "Feminino"; ?>" readonly/>
                    </div>    
                </fieldset>
                <fieldset>
                    <legend>A&ccedil;&otilde;es</legend>
                <div>
                <table>
                    <tr>
                    <td width="150px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/mostratransferirpaciente/<?= $paciente[0]->paciente_id ?>">Transferir Leito</a></div></td>
                    <td width="150px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/mostrapermutapaciente/<?= $paciente[0]->paciente_id ?>">Permuta</a></div></td>
                    <td width="150px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/mostrarnovasaidapaciente/<?= $paciente[0]->internacao_id ?>">Saida</a></div></td>
                    </tr>
                    <tr>
                    <td width="150px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/prescricaopaciente/<?= $paciente[0]->internacao_id ?>">Prescricao</a></div></td> 
                    <td width="150px;"><div class="bt_link_new"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/solicitacirurgia/<?= $paciente[0]->internacao_id ?>">Solicitar Cirurgia</a></div></td> 
                    <td width="150px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/evolucaointernacao/<?= $paciente[0]->internacao_id ?>">Evolucao</a></div></td> 
                    </tr>    
                </table>            
                </div>
                </fieldset>
            </form>    
        </div>
    
 <div class="clear"></div>
</div>
<?}?>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
