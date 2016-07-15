<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>cadastros/pacientes/pesquisarprocedimento">
            Voltar
        </a>
    </div>
        <div id="accordion">
            <h3 class="singular"><a href="#">Cadastro de Procedimentos</a></h3>
            <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/atualizaprocedimento" method="post">
                <fieldset>
                    <dl id="dl_form_servidor">
                        <dt>
                            <label>Procedimento</label>
                        </dt>
                        <dd>
                            <input type="text" readonly id="txtProcedimento" name="txtProcedimento"  class="texto03" value="<?= $procedimento['procedimento']; ?>" />
                        </dd>
                         <dt>
                            <label>Descri&ccedil;&atilde;o</label>
                        </dt>
                        <dd>
                            <input type="text" readonly id="txtDescricao" name="txtDescricao"  class="texto10" value="<?= $procedimento['descricao']; ?>" />
                        </dd>
                        <dt>
                            <label>Desc resumida</label>
                        </dt>
                        <dd>
                            <input type="text" name="txtDescricaoResumida" id="txtDescricaoResumida" class="texto10" value="<?= $procedimento['descricao_resumida']; ?>" />
                        </dd>
                        </dl>
                    </fieldset>
                    <button type="submit">Enviar</button>
                    <button type="reset">Limpar</button>
                  
                    <a href="<?= base_url() ?>cadastros/pacientes/pesquisarprocedimento">
                       <button type="button" id="btnVoltar">Voltar</button>
                    </a>
                    
                </form>
            </div>
        
    </div> <!-- Final da DIV content -->
    <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
    <script type="text/javascript">
    $(function() {
        $( "#accordion" ).accordion();
    });
     


        $(function() {
            $( "#txtCidade" ).autocomplete({
                source: "<?= base_url() ?>index?c=autocomplete&m=cidade",
                minLength: 3,
                focus: function( event, ui ) {
                    $( "#txtCidade" ).val( ui.item.label );
                    return false;
                },
                select: function( event, ui ) {
                    $( "#txtCidade" ).val( ui.item.value );
                    $( "#txtCidadeID" ).val( ui.item.id );
                    return false;
                }
            });
        });
        $(function() {
            $( "#txtEstado" ).autocomplete({
                source: "<?= base_url() ?>index?c=autocomplete&m=estado",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtEstado" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtEstado" ).val( ui.item.value );
                $( "#txtEstadoID" ).val( ui.item.id );
                return false;
            }
        });
    });


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