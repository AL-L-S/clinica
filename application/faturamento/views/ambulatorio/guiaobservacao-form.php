        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Observa&ccedil;&atilde;o</h3>
        <div>
            <form name="form1" id="form1" action="<?= base_url() ?>ambulatorio/guia/gravarobservacaoguia/<?= $guia_id[0]->ambulatorio_guia_id?>" method="post">
                <fieldset>
                    <dl class="dl_desconto_lista">
                        <dt>
                        <label>Nota Fiscal</label>
                        </dt>
                        <dd>
                <?php
                      if ($guia_id[0]->nota_fiscal == "t") {
                  ?>
                    <input type="checkbox" name="nota_fiscal" checked ="true" />
                  <?php
                    }else{                       
                  ?>
                    <input type="checkbox" name="nota_fiscal"  />
                  <?php
                         }
                ?>
                        </dd>
                        <dt>
                        <label>Recibo</label>
                        </dt>
                        <dd>

              <?php
                
                    if ($guia_id[0]->recibo == "t") {

                  ?>
                    <input type="checkbox" name="recibo" checked ="true" />
                  <?php
                    }else{
                                                
                  ?>
                    <input type="checkbox" name="recibo" />
                  <?php
                         }
              ?>
                    </dd>
                        <dt>
                        <label>Observacao</label>
                        </dt>
                        <dd>
                            <textarea id="observacoes" name="observacoes" cols="50" rows="3" ><?=$guia_id[0]->observacoes?></textarea>
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