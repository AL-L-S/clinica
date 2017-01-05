<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>internacao/internacao/pesquisarmotivosaida">
            Voltar
        </a>
    </div>
    <div class="clear"></div>
    <h3 class="h3_title">Novo Motivo de Saida</h3>
    <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarmotivosaida" method="post">
         <fieldset>
            <legend>Dados do Motivo de saida</legend>
            <div>
                <label>Nome</label>                      
                <input type ="hidden" name ="internacao_motivosaida_id" value ="<?= @$obj->_internacao_motivosaida_id; ?>" id ="txtinternacao_motivosaida_id"/>
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= @$obj->_nome; ?>" />
            </div>
            
        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
    </form>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
        jQuery('#form_unidade').validate( {
            rules: {
                nome: {
                    required: true,
                    minlength: 3
                }
   
            },
            messages: {
                nome: {
                    required: "*",
                    minlength: "*"
                }
                

            }
        });
    });




</script>