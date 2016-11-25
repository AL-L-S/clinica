<div class="content ficha_ceatox">
    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>emergencia/emergencia">
            Voltar
        </a>
    </div>
    <div class="clear"></div>
    <h3 class="h3_title">Ficha de Notificação e de Atendimento</h3>
    <form name="ficha_form" id="ficha_form" action="<?=base_url() ?>emergencia/emergencia/gravar/" method="POST">
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Protuario</label>
                <input type="text" id="txtProtuario" name="txtProtuario" alt="numeromask" class="size1" alt="numeromask" />
            </div>
            <div>
                <label>Paciente</label>
                <input type="text" id="paciente" class="size4" name="paciente" />
            </div>

            <div>
                <label>N° do BE</label>
                <input type="text" id="txtBe" name="txtBe" class="size1" readonly="true"/>
            </div>
            <div>
                <label>Nome</label>
                <input type="text" id="txtNome" name="txtNome" class="size4" readonly="true"/>
            </div>


            <div>
                <label>Data de Nascimento</label>
                <input type="text"  id="txtDataNascimento" name="txtDataNascimento" class="size1" readonly="true" />
            </div>
            <div>
                <label>Solicita&ccedil;&atilde;o</label>
                <input type="text" id="txtSolicitacao" name="txtSolicitacao" class="size1" alt="numeromask" />
            </div>
            <div>
                <label>Reserva</label>
                <input type="text" id="txtReserva" name="txtReserva" class="size1" alt="numeromask" />
            </div>
            <div>
                <label>Laudo</label>
                <input type="text" id="txtLaudo" name="txtLaudo" class="size1"  />
            </div>
        </fieldset>
            
        <fieldset>
            <legend>Atendimento</legend>
            <div>
                <label>Idade</label>
                <input type="text" name="txtIdade" id="txtIdade" class="size2" readonly="true"/>
            </div>
            <div>

                <label>Leitos</label>
                <select name="txtLeito" class="size1">
                <? foreach ($listaLeito as $item) : ?>
                    <option value="<?= $item->leito_id; ?>"><?= $item->nome; ?></option>
                <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Censo</label>
                <select name="txtCenso" id="txtCenso" class="size2">
                    <option value="">Selecione</option>
                       <? foreach ($listaCenso as $item) : ?>
                        <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                       <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Tipo</label>
                <select name="txtTipo" id="txtTipo" class="size2">
                    <option value="">Selecione</option>
                       <? foreach ($listaTipo as $item) : ?>
                        <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                       <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Urgencia</label>
                <select name="txtclassificassao" id="txtclassificassao" class="size2">
                    <option value="">Selecione</option>
                       <? foreach ($listaUrgencia as $item) : ?>
                        <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                       <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>CID Prim&aacute;rio</label>
                <input type="hidden" name="txtCICPrimario" id="txtCICPrimario" class="size2" />
                <input type="text" name="txtCICPrimariolabel" id="txtCICPrimariolabel" class="size2" />
            </div>
            <div>
                <label>CID Secund&aacute;rio 1</label>
                <input type="hidden" name="txtCICsecundario1" id="txtCICsecundario1" class="size2" />
                <input type="text" name="txtCICsecundariolabel1" id="txtCICsecundariolabel1" class="size2" />
            </div>
            <div>
                <label>CID Secund&aacute;rio 2</label>
                <input type="hidden" name="txtCICsecundario2" id="txtCICsecundario2" class="size2" />
                <input type="text" name="txtCICsecundariolabel2" id="txtCICsecundariolabel2" class="size2" />
            </div>
            <div>
                <label>CID Secund&aacute;rio 3</label>
                <input type="hidden" name="txtCICsecundario3" id="txtCICsecundario3" class="size2" />
                <input type="text" name="txtCICsecundariolabel3" id="txtCICsecundariolabel3" class="size2" />
            </div>
            <div>
                <label>Plano terapeutico imediato</label>
                <input type="text" name="txtPlanoTerapeuticoImediato" id="txtPlanoTerapeuticoImediato" class="size2" />
            </div>
            <div>
                <label>Satura&ccedil;&atilde;o %</label>
                <input type="text" name="txtSaturacao" id="txtSaturacao" alt="numeromask" class="size2" />
            </div>
            <div>
                <label>FiO&sup2; %</label>
                <input type="text" name="txtFio2" id="txtFio2" alt="numeromask" class="size2" />
            </div>
            <div>
                <label>Frequencia Repiratoria</label>
                <input type="text" name="txtFrequenciaRespiratoria" alt="numeromask" id="txtFrequenciaRespiratoria" class="size2" />
            </div>
            <div>
                <label>PA Sist</label>
                <input type="text" name="txtPASist" id="txtPASist" alt="numeromask" class="size2" />
            </div>
            <div>
                <label>PA Diast</label>
                <input type="text" name="txtPADiast" id="txtPADiast" alt="numeromask" class="size2" />
            </div>
            <div>
                <label>Pulso</label>
                <input type="text" name="txtPulso" id="txtPulso" alt="numeromask" class="size2" />
            </div>

            <div>
                <label>Medico</label>
                <input type="text" id="txtmedico" name="txtmedico" class="size1" readonly="true" />
                <input type="text" id="txtmedicolabel" name="txtmedicolabel" class="size2"  />
            </div>

            
            <div>
                
                <label>Vias Areas</label>
                <select name="txtViasAereas" id="txtViasAreas" class="size2">
                    <option value="">Selecione</option>
                       <? foreach ($listaViasAereas as $item) : ?>
                        <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                       <? endforeach; ?>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>Escala de Glasgow</legend>
            <div>
                <h4>Ocular</h4>
                <label><input type="radio" value="1" name="grupo1" class="radios1" />1-Não abre os olhos</label>
                <label><input type="radio" value="2" name="grupo1" class="radios1" />2-Abre os olhos em resposta a estímulo de dor</label>
                <label><input type="radio" value="3" name="grupo1" class="radios1" />3-Abre os olhos em resposta a um chamado</label>
                <label><input type="radio" value="4" name="grupo1" class="radios1" />4-Abre os olhos espontaneamente</label>
                <input type="hidden" id="valor1" class="valorGrupo" value="0" /><br />
            </div>
            <div>
                <h4>Verbal</h4>
                <label><input type="radio" value="1" name="grupo2" class="radios2" /> 1-Emudecido</label>
                <label><input type="radio" value="2" name="grupo2" class="radios2" /> 2-Emite sons incompreensíveis</label>
                <label><input type="radio" value="3" name="grupo2" class="radios2" /> 3-Pronuncia palavras desconexas</label>
                <label><input type="radio" value="4" name="grupo2" class="radios2" /> 4-Confuso, desorientado</label>
                <label><input type="radio" value="5" name="grupo2" class="radios2" /> 5-Orientado, conversa normalmente</label>

                <input type="hidden" id="valor2" class="valorGrupo" value="0" /><br />
            </div>
            <div>
                <h4>Motor</h4>
                <label><input type="radio" value="1" name="grupo3" class="radios3" /> 1-Não se movimenta</label>
                <label><input type="radio" value="2" name="grupo3" class="radios3" /> 2-Extensão a estímulos dolorosos (descerebração)</label>
                <label><input type="radio" value="3" name="grupo3" class="radios3" /> 3-Flexão anormal a estímulos dolorosos (decorticação)</label>
                <label><input type="radio" value="4" name="grupo3" class="radios3" /> 4-Flexão inespecífica/ Reflexo de retirada a estímulos dolorosos</label>
                <label><input type="radio" value="5" name="grupo3" class="radios3" /> 5-Localiza estímulos dolorosos</label>
                <label><input type="radio" value="6" name="grupo3" class="radios3" /> 6-Obedece a comandos</label>
                <input type="hidden" id="valor3" class="valorGrupo" value="0" /><br />
            </div>
            <div>
                <h4>TOTAL</h4>
                <input type="text" readonly id="txtGlasgow" name="txtGlasgow" class="valorTotal">
            </div>
        </fieldset>
        <fieldset>
            <legend>Escala de Ramsay</legend>
                <div >
                <label ><input type=radio name="Ramsay" value="1" id="Ramsay" class="Ramsay"/>Grau 1: paciente ansioso, agitado</label>
                <label ><input type=radio name="Ramsay" value="2" id="Ramsay" class="Ramsay"/>Grau 2: cooperativo, orientado, tranqüilo</label>
                <label ><input type=radio name="Ramsay" value="3" id="Ramsay" class="Ramsay"/>Grau 3: sonolento, atendendo aos comandos</label>
                <label ><input type=radio name="Ramsay" value="4" id="Ramsay" class="Ramsay"/>Grau 4: dormindo, responde rapidamente ao estímulo glabelar</label>
                <label ><input type=radio name="Ramsay" value="5" id="Ramsay" class="Ramsay"/>Grau 5: dormindo, responde lentamente ao estímulo glabelar</label>
                <label ><input type=radio name="Ramsay" value="6" id="Ramsay" class="Ramsay"/>Grau 6: dormindo, sem resposta</label><br />
                <h4>Ramsay</h4>
                <input type="text" readonly name="txtRamsay" id="txtRamsay" class="size2" value="0"/>
                </div>
            </fieldset>
          <fieldset>
                                            <legend>Infusão de Drogas</legend>

                                            <!-- Início da tabela de Infusão de Drogas -->
                                            <table id="table_infusao_drogas" border="0">
                                                <thead>
                                                    <tr>
                                                        <td>Descrição</td>
                                                        <td>Dose</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="bt_link_new mini_bt">
                                                                <a href="#" id="plusInfusao">Adicionar Ítem</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>

                                                <tbody>
                                                    <tr class="linha1">
                                                        <td>
                                                            <select  name="txtInfusaoDrogas[1]" class="size2" >
                                                                <option value="-1">Selecione</option>
                                                               <? foreach ($listaInfusaoDrogas as $item) : ?>
                                                                <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                                               <? endforeach; ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="txtDose[1]" class="size1" /></td>
                                                <td>
                                                    <a href="#" class="delete">Excluir</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Fim da tabela de Infusão de Drogas -->
           </fieldset>
           <fieldset>
                                            <legend>Soliciação de parecer</legend>

                                            <!-- Início da tabela de Infusão de Drogas -->
                                            <table id="table_parecer" border="0">
                                                <thead>
                                                    <tr>
                                                        <td>Descrição</td>
                                                        <td>Data/Hora da solicitacao</td>
                                                        
                                                        <td>Descri&ccedil;&atilde;o</td>
                                                        <td>Urgencia</td>

                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="bt_link_new mini_bt">
                                                                <a href="#" id="plusparecer">Adicionar Ítem</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>

                                                <tbody>
                                                    <tr class="linha1">
                                                        <td>
                                                            <select  name="parecer[1]" class="size2" >
                                                                <option value="-1">Selecione</option>
                                                               <? foreach ($listaSolicitacaoParecer as $item) : ?>
                                                                <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                                               <? endforeach; ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="datasolicitacaoparecer[1]" alt="date" value="<?= $data;?>" class="size1" /><input type="text" name="horasolicitacaoparecer[1]" alt="time" value="<?= $hora;?>" class="size1" /></td>
                                                <td><textarea cols="30" rows="3" name="txtDescricao[1]"  ></textarea></td>
                                                <td>
                                                <select name="txtUrgencia[1]" id="txtUrgencia" class="size2">
                                                    <option value="">Selecione</option>
                                                    <option value="1 - 5 minutos">1 - Vermelho - 5 minutos</option>
                                                    <option value="2 - 15 minutos">2 - Laranja - 15 minutos</option>
                                                    <option value="3 - 30 minutos">3 - Amarelo - 30 minutos</option>
                                                    <option value="4 - 50 minutos">4 - Verde - 50 minutos</option>
                                                    <option value="5 - 90 minutos">5 - Azul - 90 minutos</option>
                                                </select>
                                                </td>
                                                <td>
                                                    <a href="#" class="delete">Excluir</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Fim da tabela de Agente Tóxico -->
           </fieldset>
           
                                                                                    <hr />
                                                                                    <button type="submit" name="btnEnviar">Enviar</button>
                                                                                    <button type="reset" name="btnLimpar">Limpar</button>
                                                                                </form>
                                                                            </div>
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
        $('.radios1').change(function(){
            $("#valor1").val(this.value);
            atualizaValorTotal()
        })
        $('.radios2').change(function(){
            $("#valor2").val(this.value);
            atualizaValorTotal()
        })
        $('.radios3').change(function(){
            $("#valor3").val(this.value);
            atualizaValorTotal()
        })
        $('.Ramsay').change(function(){
            $("#txtRamsay").val(this.value);
        })
        function atualizaValorTotal() {
            total=0;
            for(i=1; i<=3; i++){
                campo = "#valor"+i;
                total += $(campo).val()*1;
            }
            $('#txtGlasgow').val(total);
        }
        atualizaValorTotal();
    });

        $(function() {
        $( "#txtmedicolabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=medico",
            minLength: 1,
            focus: function( event, ui ) {
                $( "#txtmedicolabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtmedicolabel" ).val( ui.item.value );
                $( "#txtmedico" ).val( ui.item.id );
                return false;
            }
        });
    });

        $(function() {
        $( "#paciente" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=pacientebe",
            minLength: 4,
            focus: function( event, ui ) {
                $( "#paciente" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#paciente" ).val( ui.item.value );
                $( "#txtBe" ).val( ui.item.be );
                $( "#txtNome" ).val( ui.item.nome );
                $( "#txtIdade" ).val( ui.item.idade );
                $( "#txtDataNascimento" ).val( ui.item.nascimento );
                return false;
            }
        });
    });

        $(function() {
        $( "#txtCICPrimariolabel" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid10",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtCICPrimariolabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtCICPrimariolabel" ).val( ui.item.value );
                $( "#txtCICPrimario" ).val( ui.item.id );
                return false;
            }
        });
    });

        $(function() {
        $( "#txtCICsecundariolabel1" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid10",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtCICsecundariolabel1" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtCICsecundariolabel1" ).val( ui.item.value );
                $( "#txtCICsecundario1" ).val( ui.item.id );
                return false;
            }
        });
    });

        $(function() {
        $( "#txtCICsecundariolabel2" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid10",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtCICsecundariolabel2" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtCICsecundariolabel2" ).val( ui.item.value );
                $( "#txtCICsecundario2" ).val( ui.item.id );
                return false;
            }
        });
    });

        $(function() {
        $( "#txtCICsecundariolabel3" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cid10",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtCICsecundariolabel3" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtCICsecundariolabel3" ).val( ui.item.value );
                $( "#txtCICsecundario3" ).val( ui.item.id );
                return false;
            }
        });
    });
        
        
        
        $(document).ready(function(){
        jQuery('#ficha_form').validate( {
            rules: {
                txtBe: {
                    required: true
                },
                txtmedico: {
                    required: true
                }
            },
            messages: {
                txtBe: {
                    required: "*"
                },
                txtmedico: {
                    required: "*"
                }
            }
        });
    });


var idlinha=2;
var classe = 2;

$(document).ready(function(){

    $('#plusInfusao').click(function(){
        
        var linha = "<tr class='linha"+classe+"'>";
        linha += "<td>";
        linha += "<select  name='txtInfusaoDrogas["+idlinha+"]' class='size2'>";
        linha += "<option value='-1'>Selecione</option>";

<?
    foreach ($listaInfusaoDrogas as $item) {
    echo 'linha += "<option value=\'' . $item->gruporesposta_id . '\'>' . $item->descricao . '</option>";';
    }
?>

linha += "</select>";
linha += "</td>";
linha += "<td><input type='text' name='txtDose["+idlinha+"]' class='size1' /></td>";
linha += "<td>";
linha += "<a href='#' class='delete'>Excluir</a>";
linha += "</td>";
linha += "</tr>";

idlinha++;
classe = (classe == 1) ? 2 : 1;
$('#table_infusao_drogas').append(linha);
addRemove();
return false;
});

$('#plusObs').click(function(){
var linha2 = '';
idlinha2 = 0;
classe2 = 1;

linha2 += '<tr class="classe2"><td>';
linha2 += '<input type="text" name="DataObs['+idlinha2+']" />';
linha2 += '</td><td>';
linha2 += '<input type="text" name="DataObs['+idlinha2+']" />';
linha2 += '</td><td>';
linha2 += '<input type="text" name="DataObs['+idlinha2+']" class="size4" />';
linha2 += '</td><td>';
linha2 += '<a href="#" class="delete">X</a>';
linha2 += '</td></tr>';

idlinha2++;
classe2 = (classe2 == 1) ? 2 : 1;
$('#table_obsserv').append(linha2);
addRemove();
return false;
});

function addRemove() {
$('.delete').click(function(){
$(this).parent().parent().remove();
return false;
});

}
});

var idlinhaparecer=2;
var classeparecer = 2;

$(document).ready(function(){

    $('#plusparecer').click(function(){

        var linha = "<tr class='linha"+classeparecer+"'>";
        linha += "<td>";
        linha += "<select  name='parecer["+idlinhaparecer+"]' class='size2'>";
        linha += "<option value='-1'>Selecione</option>";

<?
    foreach ($listaSolicitacaoParecer as $item) {
    echo 'linha += "<option value=\'' . $item->gruporesposta_id . '\'>' . $item->descricao . '</option>";';
    }
?>

linha += "</select>";
linha += "</td>";
linha += "<td><input type='text'  name='datasolicitacaoparecer["+idlinhaparecer+"]' alt='date' value='<?= $data;?>' class='size1' />";
linha += "<input type='text' name='horasolicitacaoparecer["+idlinhaparecer+"]' alt='time' value='<?= $hora;?>' class='size1' /></td>";
linha += "<td><textarea cols='30' rows='3' name='txtDescricao["+idlinhaparecer+"]'  ></textarea></td>";
linha += "<td>";
linha += "<select name='txtUrgencia["+idlinhaparecer+"]'  class='size2'>";
linha += "<option value=''>Selecione</option>";
linha += "<option value='1 - 5 minutos'>1 - Vermelho - 5 minutos</option>";
linha += "<option value='2 - 15 minutos'>2 - Laranja - 15 minutos</option>";
linha += "<option value='3 - 30 minutos'>3 - Amarelo - 30 minutos</option>";
linha += "<option value='4 - 50 minutos'>4 - Verde - 50 minutos</option>";
linha += "<option value='5 - 90 minutos'>5 - Azul - 90 minutos</option>";
linha += "</select>";
linha += "</td>";
linha += "<td>";
linha += "<a href='#' class='delete'>Excluir</a>";
linha += "</td>";
linha += "</tr>";

idlinhaparecer++;
classeparecer = (classeparecer == 1) ? 2 : 1;
$('#table_parecer').append(linha);
$('input:text').setMask();
addRemove();
return false;
});

$('#plusObsp').click(function(){
var linha2 = '';
idlinhaparecer2 = 0;
classeparecer2 = 1;

linha2 += '<tr class="classeparecer2"><td>';
linha2 += '<input type="text" name="DataObs['+idlinhaparecer2+']" />';
linha2 += '</td><td>';
linha2 += '<input type="text" name="DataObs['+idlinhaparecer2+']" />';
linha2 += '</td><td>';
linha2 += '<input type="text" name="DataObs['+idlinhaparecer2+']" class="size4" />';
linha2 += '</td><td>';
linha2 += '<a href="#" class="delete">X</a>';
linha2 += '</td></tr>';

idlinhaparecer2++;
classeparecer2 = (classeparecer2 == 1) ? 2 : 1;
$('#table_obsserv').append(linha2);
$('input:text').setMask();
addRemove();
return false;
});

function addRemove() {
$('.delete').click(function(){
$(this).parent().parent().remove();
return false;
});

}
});






</script>