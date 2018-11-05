<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>internacao/internacao/pesquisarstatusinternacao">
            Voltar
        </a>
    </div>
    <div class="clear"></div>
    <h3 class="h3_title">Novo Status Internação</h3>
    <form name="form_unidade" id="form_unidade" action="<?= base_url() ?>internacao/internacao/gravarstatusinternacao" method="post">
         <fieldset>
            <legend>Dados do Status Internação</legend>
            <div style="width: 100%">
                <label>Nome</label>                      
                <input type ="hidden" name ="internacao_statusinternacao_id" value ="<?= @$lista[0]->internacao_statusinternacao_id; ?>" id ="txtinternacao_statusinternacao_id"/>
                <input required type="text" id="nome" name="nome"  class="texto09" value="<?= @$lista[0]->nome; ?>" />
            </div>
            <div style="width: 100%">
                <label>Cor </label>                      
                <input type="color" id="color" class="texto04" name="color" value="<?= @$lista[0]->color; ?>" />
            </div>
            
            <div style="width: 100%">
                <label>Número de Dias Status</label>                      
                <input type="number" id="dias_status" class="texto04" name="dias_status" value="<?= @$lista[0]->dias_status; ?>" />
            </div>
            
            <div>
                <label>Observação</label>                      
                <textarea type="text" id="observacao" rows="5" cols="50" name="observacao" ><?= @$lista[0]->observacao; ?></textarea>
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
        jQuery('#form_paciente').validate( {
            rules: {
                nome: {
                    required: true,
                    minlength: 3
                },
                endereco: {
                    required: true
                },
                cep: {
                    required: true
                },
                cns: {
                    maxLength:15
                }, rg: {
                    maxLength:20
                }
   
            },
            messages: {
                nome: {
                    required: "*",
                    minlength: "*"
                },
                endereco: {
                    required: "*"
                },
                cep: {
                    required: "*"
                },
                cns: {
                    required: "Tamanho m&acute;ximo do campo CNS é de 15 caracteres"
                },
                rg: {
                    maxlength: "Tamanho m&acute;ximo do campo RG é de 20 caracteres"
                }
            }
        });
    });




</script>