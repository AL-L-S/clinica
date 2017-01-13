<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>sca/ambulancia">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Controle de Ambulâncias</a></h3>
        <div>
            <form name="form_ambulancia" id="form_ambulancia" action="<?= base_url() ?>sca/ambulancia/gravar" method="post">

                <dl id="dl_form_ambulancia">
                    <dt>
                        <label>Data</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtData" name="txtData"  class="texto02" value="<?= @$obj->_data; ?>" />
                    </dd>
                    <dt>
                        <label>Hora</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtHora" alt="time" class="texto02" value="<?= @$obj->_hora; ?>" />
                    </dd>
                    <dt>
                        <label>Placa</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtPlaca"  alt="zzz-9999" class="texto02" value="<?= @$obj->_placa; ?>" />
                    </dd>
                    <dt>
                        <label>Estado</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtEstadoID" class="texto_id" name="txtEstadoID" value="<?= @$obj->_estado_id; ?>" readonly="true" />
                        <input type="text" id="txtEstado" class="texto09" name="txtEstado" value="<?= @$obj->_estado; ?>" />
                    </dd>
                    <dt>
                        <label>Cidade</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCidadeID" class="texto_id" name="txtCidadeID" value="<?= @$obj->_cidade_id; ?>" readonly="true" />
                        <input type="text" id="txtCidade" class="texto09" name="txtCidade" value="<?= @$obj->_cidade; ?>" />
                    </dd>
                            <fieldset>

                                            <!-- Início da tabela de Agente Tóxico -->
                                            <table id="table_agente_toxico" border="0">
                                                <thead>
                                                    <tr>
                                                        <td>Paciente</td>

                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6">
                                                            <div class="bt_link_new mini_bt">
                                                                <a href="#" id="plusAgente">+ Paciente</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>

                                                <tbody>
                                            <tr class="linha1">
                                                
                                                <td>
                                                    <input type="text"  name="txtPaciente[1]" class="texto09" />
                                                </td>
                                              
                                                <td>
                                                    <a href="#" class="delete">Excluir</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Fim da tabela de Agente Tóxico -->
                                </fieldset>
                    <dt>
                        <label>Motorista</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtMotorista" class="texto10" value="<?= @$obj->_motorista; ?>"/>
                    </dd>
                    <dt>
                        <label>Vigilante</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtVigilanteID" class="texto_id" name="txtVigilanteID" value="<?= @$obj->_vigilante_id; ?>" readonly="true" />
                        <input type="text" id="txtVigilante" class="texto09" name="txtVigilante" value="<?= @$obj->_vigilante; ?>" />
                    </dd>
                </dl>
                <button type="submit" name="btnEnviar">Enviar</button>

                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>sca/ambulancia');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

     $(function() {
        $( "#txtData" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?=  base_url()?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
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
            minLength: 3,
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

    $(function() {
        $( "#txtVigilante" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=vigilante",
            minLength: 1,
            focus: function( event, ui ) {
                $( "#txtVigilante" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtVigilante" ).val( ui.item.value );
                $( "#txtVigilanteID" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(document).ready(function(){
        jQuery('#form_ambulancia').validate( {
            rules: {
                txtData: {
                    required: true

                },
                txtHora: {
                    required: true

                },
                txtNome: {
                    required: true,
                    minlength: 5
                },
                txtEstadoID: {
                    required: true
                },
                txtCidadeID: {
                    required: true
                },
                txtPaciente: {
                    required: true,
                    minlength: 3
                },
               txtMotorista: {
                    required: true,
                    minlength: 3
              },
              txtVigilanteID: {
                    required: true
              }

            },
            messages: {
                txtData: {
                    required: "*"
                },
                txtHora: {
                    required: "*"
                },
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtEstadoID: {
                    required: "*"
                },
                txtCidadeID: {
                    required: "*"
                },
                txtPaciente: {
                    required: "*",
                    minlength: "!"
                },
                txtMotorista: {
                    required: "*",
                    minlength: "!"
                },
                txtVigilanteID: {
                    required: "*"
                }
            }
        });
    });


                                                                             var idlinha=2;
                                                                                var classe = 2;

                                                                                $(document).ready(function(){

                                                                                    $('#plusAgente').click(function(){
                                                                                        //



                                                                                        var linha = "<tr class='linha"+classe+"'>";

linha += "<td><input type='text'  name='txtPaciente["+idlinha+"]'class='texto09' /></td>";

linha += "<td>";
linha += "<a href='#' class='delete'>Excluir</a>";
linha += "</td>";
linha += "</tr>";

idlinha++;
classe = (classe == 1) ? 2 : 1;
$('#table_agente_toxico').append(linha);
addRemove();
return false;
});

//$('#plusObs').click(function(){
//var linha2 = '';
//idlinha2 = 0;
//classe2 = 1;
//
//linha2 += '<tr class="classe2"><td>';
//linha2 += '<input type="text" name="DataObs['+idlinha2+']" />';
//linha2 += '</td><td>';
//linha2 += '<input type="text" name="DataObs['+idlinha2+']" />';
//linha2 += '</td><td>';
//linha2 += '<input type="text" name="DataObs['+idlinha2+']" class="size4" />';
//linha2 += '</td><td>';
//linha2 += '<a href="#" class="delete">X</a>';
//linha2 += '</td></tr>';
//
//idlinha2++;
//classe2 = (classe2 == 1) ? 2 : 1;
//$('#table_obsserv').append(linha2);
//addRemove();
//return false;
//});

function addRemove() {
$('.delete').click(function(){
$(this).parent().parent().remove();
return false;
});

}
});
</script>