<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Observa&ccedil;&atilde;o</h3>
        <div>
            <form name="form1" id="form1" action="<?= base_url() ?>ambulatorio/guia/gravarobservacaoguia/<?= $guia_id[0]->ambulatorio_guia_id ?>" method="post">
                <fieldset>
                    <table>
                       
                        <tr>
                            <td style="text-align: left">
                                Obsevação
                                   
                            </td>
                          
                        </tr>
                        
                        <tr>
                            
                            <td>
                                <textarea id="observacoes" name="observacoes" cols="50" rows="3" ><?= $guia_id[0]->observacoes ?></textarea>
                            </td>
                        </tr>



                    </table>
                    <dl class="dl_desconto_lista">

                        
                        
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar">enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    /* Máscaras ER */
    function mascara(telefone) {
        if (telefone.value.length == 0)
            telefone.value = '(' + telefone.value; //quando começamos a digitar, o script irá inserir um parênteses no começo do campo.
        if (telefone.value.length == 3)
            telefone.value = telefone.value + ') '; //quando o campo já tiver 3 caracteres (um parênteses e 2 números) o script irá inserir mais um parênteses, fechando assim o código de área.

        if (telefone.value.length == 9)
            telefone.value = telefone.value + '-'; //quando o campo já tiver 8 caracteres, o script irá inserir um tracinho, para melhor visualização do telefone.

    }
</script>