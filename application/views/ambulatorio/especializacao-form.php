<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/agenda/listarhorarioagenda/<?= $agenda_id ?>">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Consolidar Agenda de Especialidades</a></h3>
        <div>
            <form name="form_exame" id="form_exame" action="<?= base_url() ?>ambulatorio/exame/gravarintervaloespecialidade" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" class="texto10 bestupper" required/>
                    </dd>
                    <dt>
                    <label>Data inicial</label>
                    </dt>
                    <dd>
                        <input type="text"  id="txtdatainicial" name="txtdatainicial" alt="date" class="size2" required />
                    </dd>
                    <dt>
                    <label>Data final</label>
                    </dt>
                    <dd>
                        <input type="text"  id="txtdatafinal" name="txtdatafinal" alt="date" class="size2" required/>
                    </dd>
                    <dt>
                        <label title="Aqui é possivel criar uma agenda alternando entre as semanas. Por exemplo: Uma semana sim e outra não (nesse exmplo, basta informa o numero 1). Caso queira a criação normal, não digite nada ou digite 0.">Intervalo de Semanas. (Ex: 2)</label>
                    </dt>
                    <dd>
                        <input title="Aqui é possivel criar uma agenda alternando entre as semanas. Por exemplo: Uma semana sim e outra não (nesse exmplo, basta informa o numero 1). Caso queira a criação normal, não digite nada ou digite 0." type="number" min="1"  id="txtintervalo" name="txtintervalo" class="size2"/>
                    </dd>
                    <dt>
                    <label>Horario *</label>
                    </dt>
                    <dd>
                         <input type="hidden"  id="txthorario" name="txthorario" value="<?= $agenda_id ?>"  class="size2" />
                        <input type="text"  id="txthorariolabel" name="txthorariotitulo" value="<?= $agenda[0]->nome ?>"  class="size4" readonly=""/>
                    </dd>
                    <dt>
                    <label>Medico *</label>
                    </dt>
                    <dd>
                        <select name="txtmedico" id="txtsala" class="size4" required>
                            <option value="">Selecione</option>
                            <? foreach ($medico as $item) : ?>
                                <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Especialidade *</label>
                    </dt>
                    <dd>
                        <select name="txtespecialidade" id="txtespecialidade" class="size4" required>
                            <option value="">Selecione</option>
                            <? foreach ($tipo as $item) : ?>
                                <option value="<?= $item->ambulatorio_grupo_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <? if (@$empresaPermissao[0]->repetir_horarios_agenda == 't') { 
                        // Obs: Essa funcionalidade esta implementada diretamente no model. ?>
                        <div title="Essa opção permitir que você repita os horarios na criação da agenda. Por padrão o sistema irá criar apenas um horário.
                                    Contudo, caso seja necessario criar uma agenda com dois ou mais horarios (por exemplo, dois horarios de 08:00) esse valor deve ser alterado.">
                            <dt>
                                <label>Quantidade horarios</label>
                            </dt>
                            <dd>
                                <input type="number" id="numero_repeticao" name="numero_repeticao" min="1" value="1" class="size1" required=""/>
                            </dd>
                        </div>
                    <? } ?>
                    
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar" id="submitButton">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    // Fazendo com que ao clicar no botão de submit, este passe a ficar desabilitado
    var formID = document.getElementById("form_exame");
    var send = $("#submitButton");
    $(formID).submit(function(event){ 
        if (formID.checkValidity()) {
            send.attr('disabled', 'disabled');
        }
    });
    
    
       $(function() {
        $( "#txtdatainicial" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    
       $(function() {
        $( "#txtdatafinal" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $("#txtespecialidade").on("click", function(){
        var valor = $("#txtespecialidade option").val();
        if( valor == 8 ){
            $(".sessoes").css("display", "block");
        }
        else{
            $(".sessoes").css("display", "none");
        }
    });
    
    $(function() {
        $( "#txtprocedimentolabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtpacientelabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtpacientelabel" ).val( ui.item.value );
                $( "#txtpacienteid" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(document).ready(function(){
        jQuery('#form_exame').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                },
                txtespecialidade: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtespecialidade: {
                    required: "*"
                }
            }
        });
    });

</script>
