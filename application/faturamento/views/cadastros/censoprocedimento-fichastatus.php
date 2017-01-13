<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>cadastros/pacientes/pesquisarprocedimento">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Procedimento Paciente</a></h3>
        <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravarpacientecenso" method="post">
            <fieldset>
                <dl id="dl_form_servidor">
                    <dt>
                        <label>Prontuario</label>
                    </dt>
                    <dd>
                        <input type="text" readonly id="txtProntuario" name="txtProntuario"  class="texto02" value="<?= $prontuario; ?>" />
                    </dd>
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" readonly id="txtNome" name="txtNome"  class="texto08" value="<?= $nome; ?>" />
                    </dd>
                    <dt>
                        <label>Procedimento</label>
                    </dt>
                    <dd>
                        <input type="text" readonly id="txtProcedimento" name="txtProcedimento"  class="texto02" value="<?= $procedimento; ?>" />
                    </dd>
                    <dt>
                        <label>Descri&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtDescricaoResumida" readonly id="txtDescricaoResumida" class="texto10" value="<?= $procedimentodescricao; ?>" />
                    </dd>
                    <dt>
                        <label>Status</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="" rows="" name="txtStatus"  class="texto_area"><?= $status; ?></textarea>
                    </dd>
                    <dt>
                        <label>Diretoria</label>
                    </dt>
                    <dd>
                        <select name="txtDiretoria" id="txtDiretoria" class="size2">
                            <option value="100">Superintend&ecirc;ncia</option>
                            <option value="99">Diretoria Executiva</option>
                            <option value="101">Diretoria T&eacute;cnica</option>
                            <option value="6">Diretoria Cl&iacute;nica</option>
                            <option value="98">Diretoria de Emerg&ecirc;ncia</option>
                            <option value="43">Diretoria Administrativa</option>
                        </select>
                    </dd>
                    <dd>
                        <input type="hidden" name="txtunidade" id="txtunidade"  value="<?= $unidade; ?>" />
                        <input type="hidden" name="txtvalida" id="txtvalida" value="1" />
                    </dd>
                </dl>
            </fieldset>
            <button type="submit">Enviar</button>
            <button type="reset">Limpar</button>

            <a href="<?= base_url() ?>cadastros/pacientes/pesquisarpacientecenso">
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