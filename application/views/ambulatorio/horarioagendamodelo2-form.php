<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/agenda/pesquisaragendamodelo2">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Horario Fixo</a></h3>
        <div>
            <style>
                .dtMenor dt{
                    width: 50px;
                }
            </style>

            <fieldset>

                <dl class="dtMenor">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="AgendatxtNome" class="texto10 bestupper" value="<?= @$agenda[0]->nome; ?>" readonly/>
                    </dd>
                    <dt>
                        <label>Médico</label>
                    </dt>
                    <dd>
                        <input type="text" name="medico_id" class="texto10 bestupper" value="<?= @$agenda[0]->medico; ?>" readonly/>
                    </dd>
                    <dt>
                        <label>Tipo Agenda</label>
                    </dt>
                    <dd>
                        <input type="text" name="tipo_agenda" class="texto10 bestupper" value="<?= @$agenda[0]->tipo_agenda; ?>" readonly/>
                    </dd>

                    
                    
                </dl>

                <form name="form_horarioagenda" id="form_horarioagenda" action="<?= base_url() ?>ambulatorio/agenda/gravarhorarioagendamodelo2" method="post">

                    <dl class="dl_desconto_lista">
                        <dd>
                            <input type="hidden" id="txthorariostipoID" name="txtagendaID" value="<?= $agenda_id; ?>" />
                        </dd>
                    </dl> 
                    <table class="table" id="tabela-agenda">
                        <tr>
                            <th>Dia</th>
                            <th>Inicio</th>
                            <th>Fim</th>
                            <th>Inicio intervalo</th>
                            <th>Fim do intervalo</th>
                            <th>Tempo Consulta</th>
                            <th>QTDE Consulta</th>
                            <th>Empresa</th>
                            <th>Sala</th>
                            <!--<th>Ações</th>-->

                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[1]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <option value="1 - Segunda">1 - Segunda</option>
                                    <option value="2 - Terça">2 - Terça</option>
                                    <option value="3 - Quarta">3 - Quarta</option>
                                    <option value="4 - Quinta">4 - Quinta</option>
                                    <option value="5 - Sexta">5 - Sexta</option>
                                    <option value="6 - Sabado">6 - Sabado</option>
                                    <option value="7 - Domingo">7 - Domingo</option>
                                </select>
                            </td>
                            <td><input type='text' id="txthoraEntrada1" name="txthoraEntrada[1]" alt='time' class='size1 hora' /></td>
                            <td><input type='text' id='txthoraSaida1' name="txthoraSaida[1]" alt='time' class='size1 hora' /></td>
                            <td><input type='text' id="txtIniciointervalo1" name="txtIniciointervalo[1]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text' id="txtFimintervalo1" name="txtFimintervalo[1]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text' id="txtTempoconsulta1" name="txtTempoconsulta[1]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text' id="txtQtdeconsulta1" name="txtQtdeconsulta[1]" value='0' class='size1' /></td>
                            <td>                
                                <select name='empresa[1]' id="empresa1" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>" <?= (count($empresas) == 1 ) ? "selected" : '' ?>>
                                            <?= $row->nome ?>
                                        </option> 
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                
                                <select name='sala[1]' id="sala1" class='size2' >
                                    <option value="" ></option>
                                </select>
                            </td>


                        </tr>
                        

                    </table>
                    <!--<button type="button" id="plusInfusao43">Adicionar</button>-->
                    <br/><br/>
                    <table>
                        <tr>
                            <td>
                                <textarea rows="2" cols="50" placeholder="obs..." value="" name="obs"></textarea>
                            </td>
                        </tr>
                    </table>
                    <hr/>
                    <button type="submit" name="btnEnviar">Adicionar</button>
                </form>

            </fieldset>
            <br>
            <br>
            <br>
            <fieldset>
                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Data</th>
                            <th class="tabela_header">Entrada 1</th>
                            <th class="tabela_header">Sa&iacute;da 1</th>
                            <th class="tabela_header">Inicio intervalo</th>
                            <th class="tabela_header">Fim do intervalo</th>
                            <th class="tabela_header">Tempo consulta</th>
                            <th class="tabela_header">Empresa</th>
                            <th class="tabela_header">Sala</th>
                            <th class="tabela_header">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->dia; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida1; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->intervaloinicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->intervalofim; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->tempoconsulta; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/agenda/alterarsalahorarioagenda/<?= $item->horarioagenda_id; ?>/<?= $agenda_id; ?>/<?= $item->empresa_id; ?>/<?= $item->sala_id; ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">
                                        => <?= $item->sala; ?>
                                    </a>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                    <a href="<?= base_url() ?>ambulatorio/agenda/carregarexclusaohorariomodelo2/<?= $item->horarioagenda_id; ?>/<?= $agenda_id; ?>">
                                        <img border="0" title="Excluir" alt="Excluir" src="<?= base_url() ?>img/form/page_white_delete.png" />
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                    ?>
                </table>
            </fieldset>
            <br>
            <br>
            <br>
            <!-- <br> -->
            <!-- <hr> -->
            <form name="form_exame" id="form_exame" action="<?= base_url() ?>ambulatorio/exame/gravarintervalogeralmodelo2" method="post">
                <fieldset>
                    <hr>
                    <?if(@$agenda[0]->consolidada == 't'){?>
                        <h2 style="font-weight: bolder;font-size: 13pt;">Editar Agenda</h2>
                    <?}else{?>
                        <h2 style="font-weight: bolder;font-size: 13pt;">Consolidar Agenda</h2>
                    <?}?>
                    <hr>
                    <br>
                    <dl class="dl_desconto_lista">
                        <input type="hidden" name="txthorario" class="texto10 bestupper" value="<?= $agenda_id; ?>" readonly/>   
                        <input type="hidden" name="txtNome" class="texto10 bestupper" value="<?= @$agenda[0]->nome; ?>" readonly/>   
                        <input type="hidden" name="txtmedico" class="texto10 bestupper" value="<?= @$agenda[0]->medico_id; ?>" readonly/>   
                        <input type="hidden" name="tipo_agenda_id" class="texto10 bestupper" value="<?= @$agenda[0]->tipo_agenda_id; ?>" readonly/>   
                        <dt>
                            <label>Data inicial</label>
                        </dt>
                        <dd>
                            <input type="text"  id="txtdatainicial" name="txtdatainicial" alt="date" class="size2" value="<?=($agenda[0]->datacon_inicio != '')? date("d/m/Y",strtotime($agenda[0]->datacon_inicio)) : ''; ?>" required/>
                        </dd>
                        <dt>
                            <label>Data final</label>
                        </dt>
                        <dd>
                            <input type="text"  id="txtdatafinal" name="txtdatafinal" alt="date" class="size2" value="<?=($agenda[0]->datacon_fim != '')? date("d/m/Y",strtotime($agenda[0]->datacon_fim)) : ''; ?>" required/>
                        </dd>
                        <dt>
                            <label title="Aqui é possivel criar uma agenda alternando entre as semanas. Por exemplo: Uma semana sim e outra não (nesse exemplo, basta informa o numero 1). Caso queira a criação normal, não digite nada ou digite 0.">Intervalo de Semanas. (Ex: 2)</label>
                        </dt>
                        <dd>
                            <input title="Aqui é possivel criar uma agenda alternando entre as semanas. Por exemplo: Uma semana sim e outra não (nesse exemplo, basta informa o numero 1). Caso queira a criação normal, não digite nada ou digite 0." type="number" min="0" value="<?= @$agenda[0]->intervalo; ?>"  id="txtintervalo" name="txtintervalo" class="size2"/>
                        </dd>
                    </dl>  
                    <br> 
                    <br> 
                    <button type="submit" name="btnEnviar" id="submitButtonCons">Consolidar</button> 
                </fieldset>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    var formID = document.getElementById("form_exame");
    var send = $("#submitButtonCons");
    $(formID).submit(function(event){ 
        if (formID.checkValidity()) {
            send.attr('disabled', 'disabled');
        }
    });
    
    $(function () {
        $("#txtdatainicial").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function () {
        $("#txtdatafinal").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    <? for($i = 1; $i <= 100; $i++){ ?>
        $('#txthoraEntrada<?= $i ?>').blur(function () {
            if ($(this).val() != '') {
                $("#txthoraSaida<?= $i ?>").prop('required', true);
                $("#txtIniciointervalo<?= $i ?>").prop('required', true);
                $("#txtFimintervalo<?= $i ?>").prop('required', true);
                $("#empresa<?= $i ?>").prop('required', true);
                $("#sala<?= $i ?>").prop('required', true);
                $("#txtTempoconsulta<?= $i ?>").prop('required', true);
    //            $("#txtQtdeconsulta<?= $i ?>").prop('required', true);
            } else {
                $("#txthoraSaida<?= $i ?>").prop('required', false);
                $("#txtIniciointervalo<?= $i ?>").prop('required', false);
                $("#txtFimintervalo<?= $i ?>").prop('required', false);
                $("#empresa<?= $i ?>").prop('required', false);
                $("#sala<?= $i ?>").prop('required', false);
                $("#txtTempoconsulta<?= $i ?>").prop('required', false);
    //            $("#txtQtdeconsulta<?= $i ?>").prop('required', false);
            }        

            $('#txtTempoconsulta<?= $i ?>').blur(function () {
                if ($(this).val() != '') {
                    $("#txtQtdeconsulta<?= $i ?>").prop('readonly', true);
                } else {
                    $("#txtQtdeconsulta<?= $i ?>").prop('readonly', false);
                }
            });

            $('#txtQtdeconsulta<?= $i ?>').blur(function () {
                if ($(this).val() > 0) {
                    $("#txtTempoconsulta<?= $i ?>").prop('readonly', true);
                } else {
                    $("#txtTempoconsulta<?= $i ?>").prop('readonly', false);
                }
            });
        });
        
        $("#empresa<?= $i ?>").change(function(){
            if($("#empresa<?= $i ?>").val()){
                $.getJSON('<?= base_url() ?>autocomplete/agendaempresasala', {txtempresa: $("#empresa<?= $i ?>").val(), ajax: true}, function (j) {
                    var options = '<option value=""></option>';
                    
                    var selected = (j.length == 1)?'selected':'';
                
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].exame_sala_id + '"'+selected+'>' + j[c].nome + '</option>';
                    }
                    $("#sala<?= $i ?>").html(options).show();
                    $('.carregando').hide();
                });
            }
            else{
                var options = '<option value=""></option>';
                $("#sala<?= $i ?>").html(options).show();
            }
        });
        
        // Caso so tenha uma empresa, ele ja deve carregar todas as salas dessa empresa.
        if($("#empresa<?= $i ?>").val()){
            $.getJSON('<?= base_url() ?>autocomplete/agendaempresasala', {txtempresa: $("#empresa<?= $i ?>").val(), ajax: true}, function (j) {
                var options = '<option value=""></option>';
                
                var selected = (j.length == 1)?'selected':'';
                
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].exame_sala_id + '"'+selected+'>' + j[c].nome + '</option>';
                }
                $("#sala<?= $i ?>").html(options).show();
                $('.carregando').hide();
            });
        }
        
    <? } ?>

    $(function () {
        $("#accordion").accordion();
    });

    var idlinha = 8;
    
    $(document).ready(function () {
        
//        $('#plusInfusao43').click(function () {
//
//            var linha = "<tr>";
//            linha += "<td>";
//            linha += "<select  name='txtDia[" + idlinha + "]' class='size1' >";
//            linha += "<option value=''></option>";
//            linha += "<option value='1 - Segunda'>1 - Segunda</option>";
//            linha += "<option value='2 - Terça'>2 - Terça</option>";
//            linha += "<option value='3 - Quarta'>3 - Quarta</option>";
//            linha += "<option value='4 - Quinta'>4 - Quinta</option>";
//            linha += "<option value='5 - Sexta'>5 - Sexta</option>";
//            linha += "<option value='6 - Sabado'>6 - Sabado</option>";
//            linha += "<option value='7 - Domingo'>7 - Domingo</option>";
//            linha += "</select>";
//            linha += "</td>";
//
//            linha += "<td><input type='text'  id='txthoraEntrada1[" + idlinha + "]' name='txthoraEntrada[" + idlinha + "]' alt='time' class='size1 hora' /></td>";
//            linha += "<td><input type='text'  id='txthoraSaida1' name='txthoraSaida[" + idlinha + "]' alt='time' class='size1 hora' /></td>";
//            linha += "<td><input type='text'  id='txtIniciointervalo' name='txtIniciointervalo[" + idlinha + "]' alt='time' value='00:00' class='size1 hora' /></td>";
//            linha += "<td><input type='text'  id='txtFimintervalo' name='txtFimintervalo[" + idlinha + "]' alt='time' value='00:00' class='size1 hora' /></td>";
//            linha += "<td><input type='text'  id='txtTempoconsulta' name='txtTempoconsulta[" + idlinha + "]' class='size1' data-container='body' data-toggle='popover' data-placement='left' data-content='Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)' /></td>";
//            linha += "<td><input type='text'  id='txtQtdeconsulta' name='txtQtdeconsulta[" + idlinha + "]' value='0' class='size1' /></td>";
//            linha += "<td>";
//
//            linha += "<select  name='empresa[" + idlinha + "]' class='size2' >";
//            linha += "<option value=''></option>";
//            <? foreach ($empresas as $item) {
                echo 'linha += "<option value=\'' . $item->empresa_id . '\'>' . $item->nome . '</option>";';
            } ?>//
//            linha += "</select>";
//            linha += "</td>";
//            linha += "</tr>";
//            
//            idlinha++;
//            $('#tabela-agenda').append(linha);
//            
//            $("#accordion").accordion("refresh");
//            return false;
//        });
//        
//        
//        $('.delete').click(function () {
//            $(this).parent().parent().remove();
//            return false;
//        });

//            $('#plusObs').click(function () {
//                var linha2 = '';
//                idlinha2 = 0;
//                classe2 = 1;
//
//                linha2 += '<tr class="classe2"><td>';
//                linha2 += '<input type='text' name="DataObs[' + idlinha2 + ']" />';
//                linha2 += '</td><td>';
//                linha2 += '<input type='text' name="DataObs[' + idlinha2 + ']" />';
//                linha2 += '</td><td>';
//                linha2 += '<input type='text' name="DataObs[' + idlinha2 + ']" />';
//                linha2 += '</td><td>';
//                linha2 += '<input type='text' name="DataObs[' + idlinha2 + ']" class="size4" />';
//                linha2 += '</td><td>';
//                linha2 += '<a href="#" class="delete">X</a>';
//                linha2 += '</td></tr>';
//
//                idlinha2++;
//                classe2 = (classe2 == 1) ? 2 : 1;
//                $('#table_obsserv').append(linha2);
//                addRemove();
//                return false;
//            });

//        function addRemove() {
//            $('.delete').click(function () {
//                $(this).parent().parent().remove();
//                return false;
//            });
//        }
        
    });

</script>