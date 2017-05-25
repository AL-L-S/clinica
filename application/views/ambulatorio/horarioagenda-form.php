<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/agenda">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Horario Fixo</a></h3>
        <div>
            <fieldset>
                <form name="form_horarioagenda" id="form_horarioagenda" action="<?= base_url() ?>ambulatorio/agenda/gravarhorarioagenda" method="post">

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
                            <!--<th>Ações</th>-->

                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[1]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <option value="1 - Segunda">1 - Segunda</option>
                                    <!--                                <option value="2 - Terça">2 - Terça</option>
                                                                    <option value="3 - Quarta">3 - Quarta</option>
                                                                    <option value="4 - Quinta">4 - Quinta</option>
                                                                    <option value="5 - Sexta">5 - Sexta</option>
                                                                    <option value="6 - Sabado">6 - Sabado</option>
                                                                    <option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada1" name="txthoraEntrada[1]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida1' name="txthoraSaida[1]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo1" name="txtIniciointervalo[1]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo1" name="txtFimintervalo[1]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta1" name="txtTempoconsulta[1]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta1" name="txtQtdeconsulta[1]" value='0' class='size1' /></td>
                            <td>                
                                <select name='empresa[1]' class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[2]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <option value="2 - Terça">2 - Terça</option>
                                    <!--                                <option value="3 - Quarta">3 - Quarta</option>
                                                                    <option value="4 - Quinta">4 - Quinta</option>
                                                                    <option value="5 - Sexta">5 - Sexta</option>
                                                                    <option value="6 - Sabado">6 - Sabado</option>
                                                                    <option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada2" name="txthoraEntrada[2]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida2' name="txthoraSaida[2]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo2" name="txtIniciointervalo[2]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo2" name="txtFimintervalo[2]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta2" name="txtTempoconsulta[2]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta2" name="txtQtdeconsulta[2]" value='0' class='size1' /></td>
                            <td>                
                                <select name='empresa[2]' class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[3]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <!--<option value="2 - Terça">2 - Terça</option>-->
                                    <option value="3 - Quarta">3 - Quarta</option>
                                    <!--                                <option value="4 - Quinta">4 - Quinta</option>
                                                                    <option value="5 - Sexta">5 - Sexta</option>
                                                                    <option value="6 - Sabado">6 - Sabado</option>
                                                                    <option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada3" name="txthoraEntrada[3]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida3' name="txthoraSaida[3]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo3" name="txtIniciointervalo[3]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo3" name="txtFimintervalo[3]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta3" name="txtTempoconsulta[3]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta3" name="txtQtdeconsulta[3]" value='0' class='size1' /></td>
                            <td>                
                                <select name='empresa[3]' class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[4]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <!--<option value="2 - Terça">2 - Terça</option>-->
                                    <!--<option value="3 - Quarta">3 - Quarta</option>-->
                                    <option value="4 - Quinta">4 - Quinta</option>
                                    <!--<option value="5 - Sexta">5 - Sexta</option>-->
                                    <!--<option value="6 - Sabado">6 - Sabado</option>-->
                                    <!--<option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada4" name="txthoraEntrada[4]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida4' name="txthoraSaida[4]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo4" name="txtIniciointervalo[4]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo4" name="txtFimintervalo[4]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta4" name="txtTempoconsulta[4]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta4" name="txtQtdeconsulta[4]" value='0' class='size1' /></td>
                            <td>                
                                <select name='empresa[4]' class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[5]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <!--<option value="2 - Terça">2 - Terça</option>-->
                                    <!--<option value="3 - Quarta">3 - Quarta</option>-->
                                    <!--<option value="4 - Quinta">4 - Quinta</option>-->
                                    <option value="5 - Sexta">5 - Sexta</option>
                                    <!--<option value="6 - Sabado">6 - Sabado</option>-->
                                    <!--<option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada5" name="txthoraEntrada[5]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida5' name="txthoraSaida[5]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo5" name="txtIniciointervalo[5]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo5" name="txtFimintervalo[5]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta5" name="txtTempoconsulta[5]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta5" name="txtQtdeconsulta[5]" value='0' class='size1' /></td>
                            <td>                
                                <select name='empresa[5]' class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[6]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <!--<option value="2 - Terça">2 - Terça</option>-->
                                    <!--<option value="3 - Quarta">3 - Quarta</option>-->
                                    <!--<option value="4 - Quinta">4 - Quinta</option>-->
                                    <!--<option value="5 - Sexta">5 - Sexta</option>-->
                                    <option value="6 - Sabado">6 - Sabado</option>
                                    <!--<option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada6" name="txthoraEntrada[6]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida6' name="txthoraSaida[6]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo6" name="txtIniciointervalo[6]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo6" name="txtFimintervalo[6]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta6" name="txtTempoconsulta[6]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta6" name="txtQtdeconsulta[6]" value='0' class='size1' /></td>
                            <td>                
                                <select name='empresa[6]' class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[7]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--                                <option value="1 - Segunda">1 - Segunda</option>
                                                                    <option value="2 - Terça">2 - Terça</option>
                                                                    <option value="3 - Quarta">3 - Quarta</option>
                                                                    <option value="4 - Quinta">4 - Quinta</option>
                                                                    <option value="5 - Sexta">5 - Sexta</option>
                                                                    <option value="6 - Sabado">6 - Sabado</option>-->
                                    <option value="7 - Domingo">7 - Domingo</option>
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada7" name="txthoraEntrada[7]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida7' name="txthoraSaida[7]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo7" name="txtIniciointervalo[7]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo7" name="txtFimintervalo[7]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta7" name="txtTempoconsulta[7]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta7" name="txtQtdeconsulta[7]" value='0' class='size1' /></td>
                            <td>                
                                <select name='empresa[7]' id="empresa7" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>

                    </table>
                    <br/><br/>
                    <table>
                        <tr>
                            <td>
                                <textarea rows="2" cols="50" placeholder="obs..." value="" name="obs"></textarea>
                            </td>
                        </tr>
                    </table>
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                    <button type="reset" name="btnLimpar">Limpar</button>
                    <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
                </form>

            </fieldset>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $(function () {
        $("#data_ficha").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $('#txthoraEntrada1').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txthoraSaida1").prop('required', true);
            $("#txtIniciointervalo1").prop('required', true);
            $("#txtFimintervalo1").prop('required', true);
//            $("#txtTempoconsulta1").prop('required', true);
//            $("#txtQtdeconsulta1").prop('required', true);
        } else {
            $("#txthoraSaida1").prop('required', false);
            $("#txtIniciointervalo1").prop('required', false);
            $("#txtFimintervalo1").prop('required', false);
//            $("#txtTempoconsulta1").prop('required', false);
//            $("#txtQtdeconsulta1").prop('required', false);
        }
    });
    $('#txthoraEntrada2').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txthoraSaida2").prop('required', true);
            $("#txtIniciointervalo2").prop('required', true);
            $("#txtFimintervalo2").prop('required', true);
//            $("#txtTempoconsulta1").prop('required', true);
//            $("#txtQtdeconsulta1").prop('required', true);
        } else {
            $("#txthoraSaida2").prop('required', false);
            $("#txtIniciointerval2").prop('required', false);
            $("#txtFimintervalo2").prop('required', false);
//            $("#txtTempoconsulta1").prop('required', false);
//            $("#txtQtdeconsulta1").prop('required', false);
        }
    });
    
    $('#txthoraEntrada3').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txthoraSaida3").prop('required', true);
            $("#txtIniciointervalo3").prop('required', true);
            $("#txtFimintervalo3").prop('required', true);
//            $("#txtTempoconsulta1").prop('required', true);
//            $("#txtQtdeconsulta1").prop('required', true);
        } else {
            $("#txthoraSaida3").prop('required', false);
            $("#txtIniciointerval3").prop('required', false);
            $("#txtFimintervalo3").prop('required', false);
//            $("#txtTempoconsulta1").prop('required', false);
//            $("#txtQtdeconsulta1").prop('required', false);
        }
    });
    $('#txthoraEntrada4').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txthoraSaida4").prop('required', true);
            $("#txtIniciointervalo4").prop('required', true);
            $("#txtFimintervalo4").prop('required', true);
//            $("#txtTempoconsulta1").prop('required', true);
//            $("#txtQtdeconsulta1").prop('required', true);
        } else {
            $("#txthoraSaida4").prop('required', false);
            $("#txtIniciointerval4").prop('required', false);
            $("#txtFimintervalo4").prop('required', false);
//            $("#txtTempoconsulta1").prop('required', false);
//            $("#txtQtdeconsulta1").prop('required', false);
        }
    });
    $('#txthoraEntrada5').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txthoraSaida5").prop('required', true);
            $("#txtIniciointervalo5").prop('required', true);
            $("#txtFimintervalo5").prop('required', true);
//            $("#txtTempoconsulta1").prop('required', true);
//            $("#txtQtdeconsulta1").prop('required', true);
        } else {
            $("#txthoraSaida5").prop('required', false);
            $("#txtIniciointerval5").prop('required', false);
            $("#txtFimintervalo5").prop('required', false);
//            $("#txtTempoconsulta1").prop('required', false);
//            $("#txtQtdeconsulta1").prop('required', false);
        }
    });
    $('#txthoraEntrada6').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txthoraSaida6").prop('required', true);
            $("#txtIniciointervalo6").prop('required', true);
            $("#txtFimintervalo6").prop('required', true);
//            $("#txtTempoconsulta1").prop('required', true);
//            $("#txtQtdeconsulta1").prop('required', true);
        } else {
            $("#txthoraSaida6").prop('required', false);
            $("#txtIniciointerval6").prop('required', false);
            $("#txtFimintervalo6").prop('required', false);
//            $("#txtTempoconsulta1").prop('required', false);
//            $("#txtQtdeconsulta1").prop('required', false);
        }
    });
    $('#txthoraEntrada7').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txthoraSaida7").prop('required', true);
            $("#txtIniciointervalo7").prop('required', true);
            $("#txtFimintervalo7").prop('required', true);
//            $("#txtTempoconsulta1").prop('required', true);
//            $("#txtQtdeconsulta1").prop('required', true);
        } else {
            $("#txthoraSaida7").prop('required', false);
            $("#txtIniciointerval7").prop('required', false);
            $("#txtFimintervalo7").prop('required', false);
//            $("#txtTempoconsulta1").prop('required', false);
//            $("#txtQtdeconsulta1").prop('required', false);
        }
    });
    
    
    
    

    $('#txtTempoconsulta1').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txtQtdeconsulta1").prop('readonly', true);
//            
        } else {
            $("#txtQtdeconsulta1").prop('readonly', false);
//            
        }
    });
    
    $('#txtQtdeconsulta1').blur(function () {
        if ($(this).val() > 0) {
//            alert('sd');
            $("#txtTempoconsulta1").prop('readonly', true);
//            
        } else {
            $("#txtTempoconsulta1").prop('readonly', false);
//            
        }
    });
    $('#txtTempoconsulta2').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txtQtdeconsulta2").prop('readonly', true);
//            
        } else {
            $("#txtQtdeconsulta2").prop('readonly', false);
//            
        }
    });
    
    $('#txtQtdeconsulta2').blur(function () {
        if ($(this).val() > 0) {
//            alert('sd');
            $("#txtTempoconsulta2").prop('readonly', true);
//            
        } else {
            $("#txtTempoconsulta2").prop('readonly', false);
//            
        }
    });
    $('#txtTempoconsulta3').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txtQtdeconsulta3").prop('readonly', true);
//            
        } else {
            $("#txtQtdeconsulta3").prop('readonly', false);
//            
        }
    });
    
    $('#txtQtdeconsulta3').blur(function () {
        if ($(this).val() > 0) {
//            alert('sd');
            $("#txtTempoconsulta3").prop('readonly', true);
//            
        } else {
            $("#txtTempoconsulta3").prop('readonly', false);
//            
        }
    });
    $('#txtTempoconsulta4').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txtQtdeconsulta4").prop('readonly', true);
//            
        } else {
            $("#txtQtdeconsulta4").prop('readonly', false);
//            
        }
    });
    
    $('#txtQtdeconsulta4').blur(function () {
        if ($(this).val() > 0) {
//            alert('sd');
            $("#txtTempoconsulta4").prop('readonly', true);
//            
        } else {
            $("#txtTempoconsulta4").prop('readonly', false);
//            
        }
    });
    $('#txtTempoconsulta5').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txtQtdeconsulta5").prop('readonly', true);
//            
        } else {
            $("#txtQtdeconsulta5").prop('readonly', false);
//            
        }
    });
    
    $('#txtQtdeconsulta5').blur(function () {
        if ($(this).val() > 0) {
//            alert('sd');
            $("#txtTempoconsulta5").prop('readonly', true);
//            
        } else {
            $("#txtTempoconsulta5").prop('readonly', false);
//            
        }
    });
    $('#txtTempoconsulta6').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txtQtdeconsulta6").prop('readonly', true);
//            
        } else {
            $("#txtQtdeconsulta6").prop('readonly', false);
//            
        }
    });
    
    $('#txtQtdeconsulta6').blur(function () {
        if ($(this).val() > 0) {
//            alert('sd');
            $("#txtTempoconsulta6").prop('readonly', true);
//            
        } else {
            $("#txtTempoconsulta6").prop('readonly', false);
//            
        }
    });
    $('#txtTempoconsulta7').blur(function () {
        if ($(this).val() != '') {
//            alert('sd');
            $("#txtQtdeconsulta7").prop('readonly', true);
//            
        } else {
            $("#txtQtdeconsulta7").prop('readonly', false);
//            
        }
    });
    
    $('#txtQtdeconsulta7').blur(function () {
        if ($(this).val() > 0) {
//            alert('sd');
            $("#txtTempoconsulta7").prop('readonly', true);
//            
        } else {
            $("#txtTempoconsulta7").prop('readonly', false);
//            
        }
    });



    $(function () {
        $("#accordion").accordion();
    });

    var idlinha = 2;
    var classe = 2;



    $(document).ready(function () {



        $('#plusInfusao43').click(function () {
//            alert('asd');
//        if(){
//            
//        }

            var linha = "<tr>";
            linha += "<td>";
            linha += "<select  name='txtDia[" + idlinha + "]' class='size1' >";
            linha += "<option value=''></option>";
            linha += "<option value='1 - Segunda'>1 - Segunda</option>";
            linha += "<option value='2 - Terça'>2 - Terça</option>";
            linha += "<option value='3 - Quarta'>3 - Quarta</option>";
            linha += "<option value='4 - Quinta'>4 - Quinta</option>";
            linha += "<option value='5 - Sexta'>5 - Sexta</option>";
            linha += "<option value='6 - Sabado'>6 - Sabado</option>";
            linha += "<option value='7 - Domingo'>7 - Domingo</option>";
            linha += "</select>";
            linha += "</td>";

            linha += "<td><input type='text'  id='txthoraEntrada1[" + idlinha + "]' name='txthoraEntrada[" + idlinha + "]' alt='time' class='size1 hora' /></td>";
            linha += "<td><input type='text'  id='txthoraSaida1' name='txthoraSaida[" + idlinha + "]' alt='time' class='size1 hora' /></td>";
            linha += "<td><input type='text'  id='txtIniciointervalo' name='txtIniciointervalo[" + idlinha + "]' alt='time' value='00:00' class='size1 hora' /></td>";
            linha += "<td><input type='text'  id='txtFimintervalo' name='txtFimintervalo[" + idlinha + "]' alt='time' value='00:00' class='size1 hora' /></td>";
            linha += "<td><input type='text'  id='txtTempoconsulta' name='txtTempoconsulta[" + idlinha + "]' class='size1' data-container='body' data-toggle='popover' data-placement='left' data-content='Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)' /></td>";
            linha += "<td><input type='text'  id='txtQtdeconsulta' name='txtQtdeconsulta[" + idlinha + "]' value='0' class='size1' /></td>";
            linha += "<td>";

            linha += "<select  name='empresa[" + idlinha + "]' class='size2' >";
            linha += "<option value=''></option>";

<?
foreach ($empresas as $item) {
    echo 'linha += "<option value=\'' . $item->empresa_id . '\'>' . $item->nome . '</option>";';
}
?>

            linha += "</select>";
            linha += "</td>";
            linha += "<td>";
            linha += "<a href='#' class='btn btn-outline btn-danger btn-sm delete'>Excluir</a>";
            linha += "</td>";
            linha += "</tr>";
//            alert(linha);



            idlinha++;
            classe = (classe == 1) ? 2 : 1;
            $('#tabela-agenda').append(linha);
//            $(".hora").mask('99:99');
            (function ($) {
                $(function () {
                    $('input:text').setMask();
                });
            })(jQuery);
            addRemove();
            return false;
        });

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
//
//        }
    });

</script>