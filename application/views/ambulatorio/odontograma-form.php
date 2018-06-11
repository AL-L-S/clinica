<?
$dataFuturo = date("Y-m-d");
$dataAtual = @$obj->_nascimento;
$date_time = new DateTime($dataAtual);
$diff = $date_time->diff(new DateTime($dataFuturo));
$teste = $diff->format('%Ya %mm %dd');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Odontograma</title>
        <link href="<?= base_url() ?>css/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
        
        <style>
            * { font-family: Arial,Helvetica Neue,Helvetica,sans-serif; }
            body { background-color: rgba(0,0,0,.1); }
            .size4 { width: 300px; }
            
            .dadosTitulo { font-weight: bold; font-size: 13pt; }

            #odontograma { position: relative; margin-left: 2%; margin-right: 2%;}
            #odontograma h4 { text-align: center; }

            #dadosPaciente { font-size: 12pt; }

            #denteCompleto, 
            #primeiroQuadrante, 
            #segundoQuadrante, 
            #terceiroQuadrante, 
            #quartoQuadrante { display: inline-block; }

            #primeiroQuadrante, 
            #segundoQuadrante, 
            #terceiroQuadrante,
            #quartoQuadrante {
                border: 1pt dashed #000; 
                border-radius: 5pt; 
                padding: 5pt; 
                margin-bottom: 5pt;
                cursor: pointer;
            }

            #denteCompleto { text-align: center; margin: 3pt; padding: 3pt; }
            #denteCompleto i { font-size: 20pt; }
            #denteCompleto i.procAdd { color: #f39c12; }

            #odontograma #denteCompleto.on {
                border: 1pt solid #e67e22;
                border-radius: 5pt;
            }

            #opcoesDenteSelecionado { position: relative; margin-top: 5%; }

            #opcoesDenteSelecionado #detalhesDente { margin-left: 3%; margin-right: 3%; margin-top: 5%;}

            #opcoesDenteSelecionado.status-off { display: none; }
            #opcoesDenteSelecionado.status-on { display: block; }

            #opcoesDenteSelecionado span#nomeDente,
            #opcoesDenteSelecionado span#informacaoDente{ 
                display: block; 
                text-align: center;
                font-size: 14pt;
            }

            #opcoesDenteSelecionado #detalhesDente svg polygon:hover { fill: #fce57e; }
            #opcoesDenteSelecionado #detalhesDente svg polygon#faceSelecionada { fill: #95a5a6; }
            
            div.principal { display: inline-block;}
            div.left { float: left; width: 65%;}
            div.right { float: right; width: 30%; margin-right: 5%; }
            
            
            
            div.principal h4 {text-align: center;}
            
            div.principal ul.lista-procedimentos { 
                border: 1pt dotted black; 
                border-radius: 10pt;
                max-height: 300pt; 
                list-style: none;
                overflow-y: auto;
                padding: 10pt;
            }
            div.principal ul.lista-procedimentos li { margin-bottom: 5pt; }
            div.principal ul.lista-procedimentos li hr.linha-abaixo { 
                border: 0;
                height: 1px;
                background: #333;
                background-image: linear-gradient(to right, #ccc, #333, #ccc);
            }
            div.principal ul.lista-procedimentos li:last-child hr.linha-abaixo { display: none; }
            div.principal ul.lista-procedimentos li td.item-dente { width: 50pt; }
            div.principal ul.lista-procedimentos li td.item-excluir { width: 30pt; text-align: right; font-size: 14pt; }
            div.principal ul.lista-procedimentos li td.item-excluir i { font-size: 15pt; cursor: pointer; }
            div.principal ul.lista-procedimentos li td.item-excluir i:hover { color: #F44336 }
        </style>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.js" ></script>
        
        <!-- PLUGIN DO TOAST -->
        <link rel="stylesheet" href="<?= base_url() ?>js/toast/toastr.min.css">
        <script type="text/javascript" src="<?= base_url() ?>js/toast/toastr.min.js" ></script>
        
        <script>
            var denteSelecionado = "";
            var faceSelecionada = "";

            
            jQuery(function () {
                jQuery("#odontograma #denteCompleto").on('click', function () {
                    var classe = jQuery(this).attr("class");
                    classe = classe.split(" ");
                    var dente = classe[0];

                    /* DEIXANDO UMA BORDA NO DENTE CLICADO */
                    if (denteSelecionado != "") { // Desmarcando o item que estava selecionado anteriormente
                        jQuery("#odontograma div." + denteSelecionado).attr("class", denteSelecionado + " off");
                    }

                    jQuery(this).attr("class", dente + " on");
                    denteSelecionado = dente;
                    /* FIM DA CRIAÇÃO DA BORDA */


                    /* MOSTRANDO OS DETALHES DO DENTE SELECIONADO */
                    jQuery("#opcoesDenteSelecionado").attr("class", 'status-on');
                    jQuery("#opcoesDenteSelecionado #numeroDenteSelecionado").attr("class", dente);
                    jQuery("#opcoesDenteSelecionado span#nomeDente").text("Dente: " + dente);
                    
                    // Atualizando o formulario quando clicar no dente
                    selecionaFace(faceSelecionada);
                    
                });
            });
            
            jQuery(function () { // SALVANDO O PROCEDIMENTO
                jQuery("#submitButton").on('click', function () {
                    if( jQuery("#ambulatorio_laudo_id").val() != '' && jQuery("#procedimento").val() != '' &&  jQuery("#txtDente").val() != ''){
                    
                        jQuery.ajax({
                            method: "GET",
                            url: "<?= base_url(); ?>ambulatorio/odontograma/gravarprocedimentoodontograma",
                            data: {
                                ambulatorio_laudo_id: jQuery("#ambulatorio_laudo_id").val(),
                                odontograma_id: jQuery("#odontograma_id").val(),
                                procedimento_id: jQuery("#procedimento").val(),
                                paciente_id: jQuery("#paciente_id").val(),
                                observacao: jQuery("#observacao").val(),
                                dente: jQuery("#txtDente").val(),
                                face: jQuery("#txtFace").val()
                            },
                            dataType: 'json',
                            success: function (retorno) {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: 'toast-bottom-left',
                                    preventDuplicates: true,
                                    onclick: null
                                };
                                toastr.success('Procedimento adicionado com sucesso.');
                                
                                var classe = jQuery("#odontograma #denteCompleto." + retorno.dente + " i").attr('class');
                                jQuery("#odontograma #denteCompleto." + retorno.dente + " i").attr('class', classe + " procAdd");
                                
                                atualizalistaprocedimentosodontograma();
                                
                                jQuery("#observacao").val('');
                                jQuery("#procedimento").val('');
                            }
                        });
                    }
                });
            });
            
            function selecionaFace(face, numFace = '-1') {
                faceSelecionada = (numFace != '-1') ? face : '';
                
                jQuery('#adcionarProcedimento #txtDente').val(denteSelecionado);
                jQuery('#adcionarProcedimento #txtFace').val(faceSelecionada);
                
                var poligonos = jQuery("polygon");
                
                for (var i = 0; i < 5; i++) {
                    if (numFace == i) jQuery(poligonos[i]).attr('id','faceSelecionada'); 
                    else jQuery(poligonos[i]).attr('id','');
                }
                
            }
            
            function excluirprocedimentoodontograma(dente_procedimento_id){
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>ambulatorio/odontograma/excluirprocedimentoodontograma",
                    data: "dente_procedimento_id=" + dente_procedimento_id,
                    dataType: 'json',
                    success: function (retorno) {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            positionClass: 'toast-bottom-left',
                            preventDuplicates: true,
                            onclick: null
                        };
                        toastr.success('Procedimento excluido com sucesso.');

                        if(retorno.total == 0){
                            jQuery("#odontograma #denteCompleto." + retorno.dente + " i").removeClass("procAdd");
                        }
                        
                        atualizalistaprocedimentosodontograma();
                    }
                });
            }
            
            function atualizalistaprocedimentosodontograma(){
                jQuery.ajax({
                    type: "GET",
                    url: "<?= base_url(); ?>ambulatorio/odontograma/listarprocedimentosodontograma",
                    data: "ambulatorio_laudo_id=" + jQuery("#ambulatorio_laudo_id").val(),
                    dataType: 'json',
                    success: function (retorno) {
                        var lista = "";
                        for (var i = 0; i < retorno.length; i++) {

                            lista += '<li class="dente-' + retorno[i].numero_dente + '">';
                            lista += '  <table>';
                            lista += '      <tr>';
                            lista += '          <td class="item-dente">' + retorno[i].numero_dente + " - " + retorno[i].face + '</td>';
                            lista += '          <td class="item-procedimento">' + retorno[i].codigo + " - " + retorno[i].procedimento + '</td>';
                            lista += '          <td class="item-excluir"><div onclick="excluirprocedimentoodontograma(' + retorno[i].dente_procedimento_id + ')"><i class="fa fa-trash-o" aria-hidden="true"></div></td>';
                            lista += '      </tr>';
                            lista += '  </table>';
                            lista += '  <hr class="linha-abaixo">';
                            lista += '</li>';
                        }
                        jQuery("div.principal div.odontograma-acoes ul.lista-procedimentos li").remove();
                        jQuery("div.principal div.odontograma-acoes ul.lista-procedimentos").append(lista);
                    }
                });
            }
        </script>
    </head>
    <body>
        <form id="dadosPaciente" action="#">
            <fieldset>
                <legend>Dados Paciente</legend>
                <input type="hidden" id="ambulatorio_laudo_id" name="ambulatorio_laudo_id" value="<?= $ambulatorio_laudo_id ?>" />
                <input type="hidden" id="paciente_id" name="paciente_id" value="<?= $paciente_id ?>" />
                <input type="hidden" id="odontograma_id" name="odontograma_id" value="" />
                
                <table>
                    <tr>
                        <td width="400px;"><span class="dadosTitulo">Paciente:</span> <?= @$obj->_nome ?></td>
                        <td width="400px;"><span class="dadosTitulo">Exame:</span> <?= @$obj->_procedimento ?></td>
                        <td width="400px;"><span class="dadosTitulo">Solicitante:</span> <?= @$obj->_solicitante ?></td>
                    </tr>
                    <tr>
                        <td><span class="dadosTitulo">Idade:</span> <?= $teste ?></td>
                        <td><span class="dadosTitulo">Nascimento:</span> <?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                        <td><span class="dadosTitulo">Sala:</span> <?= @$obj->_sala ?></td>
                    </tr>
                    <tr>
                        <td><span class="dadosTitulo">Sexo:</span> <?
                        if (@$obj->_sexo == "M"):echo 'Masculino';
                        endif;
                        if (@$obj->_sexo == "F"):echo 'Feminino';
                        endif;
                        if (@$obj->_sexo == "O"):echo 'Outro';
                        endif;
                        ?></td>
                        <td><span class="dadosTitulo">Convenio:</span> <?= @$obj->_convenio; ?></td>
                        <td><span class="dadosTitulo">Telefone:</span> <?= @$obj->_telefone ?></td>
                    </tr>
                </table>
            </fieldset>
        </form>
        <br />
        <div class="principal left">
            <table>
                <tr>
                    <td valign="top">
                        <!-- ODONTOGRAMA COMPLETO -->
                        <div id="odontograma">
                            <h4>ODONTOGRAMA</h4>
                            <div id="dentesPermanentesSuperiores">
                                <div id="primeiroQuadrante">
                                    <? for ($i = 8; $i >= 1; $i--) { 
                                        $dente = '1' . $i; 
                                        $procAdd = (in_array($dente, $primeiroQuadrante) ? 'procAdd' : ''); ?>

                                        <div id="denteCompleto" class="1<?= $i ?> off">
                                            <span class="status-item">1<?= $i ?></span><br>
                                            <i class="fa fa-circle-thin <? echo $procAdd; $procAdd = ''; ?>" aria-hidden="true"></i>
                                        </div>
                                    <? } ?>          
                                </div>
                                <div id="segundoQuadrante">
                                    <? for ($i = 1; $i <= 8; $i++) {
                                        $dente = '2' . $i; 
                                        $procAdd = (in_array($dente, $segundoQuadrante) ? 'procAdd' : ''); ?>

                                        <div id="denteCompleto" class="2<?= $i ?> off">
                                            <span class="status-item">2<?= $i ?></span><br>
                                            <i class="fa fa-circle-thin <? echo $procAdd; $procAdd = ''; ?>" aria-hidden="true"></i>
                                        </div>
                                    <? } ?>          
                                </div>
                            </div>
                            <div id="dentesPermanentesInferiores">
                                <div id="quartoQuadrante">
                                    <? for ($i = 8; $i >= 1; $i--) { 
                                        $dente = '4' . $i; 
                                        $procAdd = (in_array($dente, $quartoQuadrante) ? 'procAdd' : ''); ?>

                                        <div id="denteCompleto" class="4<?= $i ?> off">
                                            <span class="status-item">4<?= $i ?></span><br>
                                            <i class="fa fa-circle-thin <? echo $procAdd; $procAdd = ''; ?>" aria-hidden="true"></i>
                                        </div>
                                    <? } ?>          
                                </div>
                                <div id="terceiroQuadrante">
                                    <? for ($i = 1; $i <= 8; $i++) { 
                                        $dente = '3' . $i; 
                                        $procAdd = (in_array($dente, $terceiroQuadrante) ? 'procAdd' : ''); ?>

                                        <div id="denteCompleto" class="3<?= $i ?> off">
                                            <span class="status-item">3<?= $i ?></span><br>
                                            <i class="fa fa-circle-thin <? echo $procAdd; $procAdd = ''; ?>" aria-hidden="true"></i>
                                        </div>
                                    <? } ?>          
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>

                <tr>

                    <td>
                        <!-- DETALHES DO DENTE SELECIONADO -->
                        <div id="opcoesDenteSelecionado" class="status-off"> 
                            <div id="numeroDenteSelecionado" class=""></div> <!-- NÃO APAGUE ESTA DIV -->
                            <table cellspacing="0">
                                <tr>
                                    <td>
                                        <span id="nomeDente"><!-- Aqui é onde irá aparecer o nome do dente (inserido via JQUERY) --></span>
                                    </td>

                                    <td width="50" rowspan="3"></td>

                                    <td width="200">
                                        <span id="informacaoDente">Adicionar</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id="detalhesDente">  
                                            <svg width="200" height="250">                                
                                            <polygon onclick="selecionaFace('S', 0)" fill="white" stroke="navy" stroke-width="0.5" points="0,0 200,0 150,50 50,50"></polygon> <!-- SUPERIOIR -->

                                            <polygon onclick="selecionaFace('I', 1)" fill="white" stroke="navy" stroke-width="0.5" points="50,150 150,150 200,200 0,200"></polygon> <!-- INFERIOR -->

                                            <polygon onclick="selecionaFace('D', 2)" fill="white" stroke="navy" stroke-width="0.5" points="150,50 200,0 200,200 150,150"></polygon> <!-- DIREITA -->

                                            <polygon onclick="selecionaFace('E', 3)" fill="white" stroke="navy" stroke-width="0.5" points="0,0 50,50 50,150 0,200"></polygon> <!-- ESQUERDA -->

                                            <polygon onclick="selecionaFace('C', 4)" fill="white" stroke="navy" stroke-width="0.5" points="50,50 150,50 150,150 50,150"></polygon> <!-- CENTRAL -->
                                            </svg>
                                        </div>
                                    </td>
                                    <td>
                                        <form id="adcionarProcedimento" action="#">
                                            <table>
                                                <tr>
                                                    <td><label for="txtDente">Dente</label></td>
                                                    <td>
                                                        <input type="text" id="txtDente" name="txtDente" value="" required readonly=""/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td ><label for="txtFace">Face</label></td>
                                                    <td><input type="text" id="txtFace" name="txtFace" value="" required readonly=""/></td></td>
                                                </tr>
                                                <tr>
                                                    <td><label for="procedimento">Procedimento</label></td>
                                                    <td>
                                                        <select name="procedimento" id="procedimento" required class="size4 chosen-select" data-placeholder="Selecione" tabindex="1">
                                                            <option value="">Selecione</option>
                                                            <? foreach($procedimentos as $value) { ?>
                                                                <option value="<?=$value->procedimento_convenio_id?>"><?=$value->codigo?> - <?=$value->procedimento?></option>
                                                            <? } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><label for="observacao">Obs</label></td>
                                                    <td>
                                                        <textarea  id="observacao" name="observacao" rows="5" cols="40" style="resize: none"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <button type="button" id="submitButton">Enviar</button>
                                                    </td>
                                                </tr>
                                            </table>                                        
                                        </form>
                                    </td>                                
                                </tr>

                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>    
        <div class="principal right">
            <div class="odontograma-acoes">
                <h4>AÇÕES</h4>
                <ul class="lista-procedimentos"></ul>
            </div>
            <div class="dente-acoes off">
                
            </div>
        </div>    
    </body>
</html>

<script>
    atualizalistaprocedimentosodontograma();
</script>
