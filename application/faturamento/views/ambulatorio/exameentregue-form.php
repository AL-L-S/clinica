        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">ENTREGA</h3>
        <div>
            <form name="form1" id="form1" action="<?= base_url() ?>ambulatorio/guia/gravarentregaexame" method="post">
                <fieldset>
                    <dl class="dl_desconto_lista">
                        <dt>
                        <label>NOME</label>
                        </dt>
                        <dd>
                            <input type="text" name="txtentregue" value="<?= $paciente[0]->nome; ?>" style="width: 400px;" />
                            <input type="hidden" name="agenda_exames_id" value="<?= $agenda_exames_id?>"  class="texto01" />
                        </dd>
                        <dt>
                        <label>TELEFONE</label>
                        </dt>
                        <dd>
                            <input name="telefone" id="telefone" size="20" maxlength="14" value="<?= $paciente[0]->telefone; ?>" onkeypress="mascara(this)" type="text"> 
                        </dd>
                        <dt>
                        <label>Observacao</label>
                        </dt>
                        <dd>
                            <textarea id="observacaocancelamento" name="observacaocancelamento" cols="50" rows="3" ></textarea>
                        </dd>
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar">enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>
<script type="text/javascript">
/* Máscaras ER */
function mascara(telefone){
   if(telefone.value.length == 0)
     telefone.value = '(' + telefone.value; //quando começamos a digitar, o script irá inserir um parênteses no começo do campo.
   if(telefone.value.length == 3)
      telefone.value = telefone.value + ') '; //quando o campo já tiver 3 caracteres (um parênteses e 2 números) o script irá inserir mais um parênteses, fechando assim o código de área.
 
 if(telefone.value.length == 9)
     telefone.value = telefone.value + '-'; //quando o campo já tiver 8 caracteres, o script irá inserir um tracinho, para melhor visualização do telefone.
  
}
</script>