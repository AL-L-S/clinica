
<div class="content ficha_ceatox">
        <div>
            <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarsaida" method="post" >
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
                        <input type="text" id="data_internacao" name="data_internacao"  class="texto09" value="<?php echo substr($paciente['0']->data_internacao, 8, 2) . '/' . substr($paciente['0']->data_internacao, 5, 2) . '/' . substr($paciente['0']->data_internacao, 0, 4); ?>" readonly/>
                    </div>
                    
                    <div>
                        <label>data de Nascimento</label>                      
                        <input type="text" id="data_nascimento" name="data_nascimento"  class="texto09" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" readonly/>
                    </div>
                    
                   
                    
                     <div>
                                            
                        <input type="hidden" id="txtidpaciente" name="idpaciente"  class="texto09" value="<?= $paciente[0]->paciente_id ?>" readonly/>
                    </div>
                    </fieldset>
                        
                    <fieldset>
                    <div>
                        <label>Motivo de Saida</label>
                        <select name="motivosaida" id="txtmotivosaida">
                            <?foreach($saida as $item){?>
                            <option onclick="document.getElementById('hospital').style.display='none',document.getElementById('labelhospital').style.display='none';" value="<?=$item->nome?>"><?echo $item->nome?> </option>
                            <?}?>
                            <option name="motivosaida" onclick="document.getElementById('hospital').style.display='inline',document.getElementById('labelhospital').style.display='inline';" value="transferencia" >Transferência</option>
                            
                        </select>
                        <br>
                        <label id="labelhospital">Hospital da transferência</label>  
                        <br>
                        <input type="text" id="hospital" name="hospital"  class="texto09" value=""/>
                        
                    </div>
                    <div>
                        <label>Observações</label>
                        <textarea cols="" rows="" name="observacao" id="txtobservacao" class="texto_area"></textarea><br/>
                    </div>
                </fieldset>
                        
                         <button onclick="javascript: return confirm('Deseja realmente aplicar saida ao paciente <?= $paciente[0]->paciente ?>');" type="submit">Enviar</button>
                         <button  type="reset">Limpar</button>
                </form>
                
                
        </div>
         <body onload="deixarOculto(),deixarOculto2();">
         </body>
 <div class="clear"></div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
<script type="text/javascript">

//    $(document).ready(function(){
//        jQuery('#form_unidade').validate( {
//            rules: {
//                hospital: {
//                    required: true,
//                    minlength: 3
//                }
//   
//            },
//            messages: {
//                hospital: {
//                    required: "*",
//                    minlength: "*"
//                }
//                
//
//            }
//        });
//    });




</script>
<script>
function deixarOculto(){
 document.getElementById('hospital').style.display = "none";
}
</script>
<script>
function deixarOculto2(){
 document.getElementById('labelhospital').style.display = "none";
}
</script>
