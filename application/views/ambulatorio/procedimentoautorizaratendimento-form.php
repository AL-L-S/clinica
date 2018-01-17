<? 
$recomendacao_obrigatorio = $this->session->userdata('recomendacao_obrigatorio'); 
$empresa = $this->guia->listarempresapermissoes(); 
$odontologia_alterar = $empresa[0]->odontologia_valor_alterar;
$retorno_alterar = $empresa[0]->selecionar_retorno;
$empresa_id = $this->session->userdata('empresa_id');
$empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);
//var_dump($retorno_alterar); die;

?>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <!--<div class="clear"></div>-->
    <div class="bt_link_new" style="width: 150pt">
        <a style="width: 150pt" onclick="javascript:window.open('<?= base_url() ?>seguranca/operador/novorecepcao');">
            Novo Medico Solicitante
        </a>
    </div>
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/novo/<?= $paciente_id ?>');">
            Nova guia
        </a>
    </div>

    <div>
        <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>cadastros/pacientes/autorizarambulatoriotempgeral/<?= $paciente_id; ?>" method="post">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <input name="sexo" id="txtSexo" class="size2" 
                           value="<?
                           if ($paciente['0']->sexo == "M"):echo 'Masculino';
                           endif;
                           if ($paciente['0']->sexo == "F"):echo 'Feminino';
                           endif;
                           ?>" readonly="true">
                </div>

                <div>
                    <label>Nascimento</label>


                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                </div>

                <div>

                    <label>Idade</label>
                    <input type="text" name="txtIdade" id="txtIdade" class="texto01" readonly/>

                </div>

                <div>
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
            </fieldset>
            <fieldset>
                <legend>Atendimentos anteriores</legend>
                <?
                if (count($consultasanteriores) > 0) {
                    foreach ($consultasanteriores as $value) {
                        $data_atual = date('Y-m-d');
                        $data1 = new DateTime($data_atual);
                        $data2 = new DateTime($value->data);

                        $intervalo = $data1->diff($data2);
                        ?>
                        <h6><?= $value->procedimento; ?> - DATA: <b><?= substr($value->data, 8, 2) . '/' . substr($value->data, 5, 2) . '/' . substr($value->data, 0, 4); ?> </b> - M&eacute;dico: <b> <?= $value->medico; ?></b> - Convenio:  <?= $value->convenio; ?> - <?= $intervalo->days ?> dia(s)</h6>

                        <?
                    }
                } else {
                    ?>
                    <h6>NENHUM ATENDIMENTO ENCONTRADO</h6>
                    <?
                }
                ?>
            </fieldset>
            <input type="hidden" name="paciente_id" value="<?= $paciente_id; ?>" />

            <fieldset>
                <legend>Autorizar Atendimento</legend>
                <table id="table_justa">
                    <thead>

                        <tr>
                            <th class="tabela_header">Hora</th>
                            <th class="tabela_header">Sala</th>
                            <th class="tabela_header">Medico</th>
                            <th class="tabela_header">Solicitante</th>
                            <th class="tabela_header">Convenio</th>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">Procedimento</th>
                            <th class="tabela_header">autorizacao</th>
                            <th class="tabela_header" <?if(@$empresapermissoes[0]->valor_autorizar == 'f'){?>style="display: none;" <?}?>>V. Unit</th>
                            <th class="tabela_header">Qtde</th>
                            <th class="tabela_header">Pagamento</th>
                            <th class="tabela_header">Recomendação</th>
                            <th class="tabela_header">ordenador</th>
                            <th class="tabela_header">Confir.</th>
                            <th class="tabela_header">Descricao</th>
                        </tr>
                    </thead>
                    <?
                    $estilo_linha = "tabela_content01";
                    $i = 0;
                    foreach ($exames as $item) {
                        $i++;
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        $agenda_exame_id = $item->agenda_exames_id;
                        ?>
                        <tbody>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= substr($item->inicio, 0, 5); ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="sala[<?= $i; ?>]" id="sala<?= $i; ?>" class="size1"  >
                                        <option value="">Selecione</option>
                                        <? foreach ($salas as $itens) : ?>
                                            <option value="<?= $itens->exame_sala_id; ?>" <?if (@$item->agenda_exames_nome_id == @$itens->exame_sala_id) echo "selected"; ?>>
                                                <?= $itens->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="medico_id[<?= $i; ?>]" id="medico_id<?= $i; ?>" class="size1" >
                                        <option value="">Selecione</option>
                                        <? foreach ($medicos as $itens) : ?>
                                            <option value="<?= $itens->operador_id; ?>" <?if (@$item->medico_consulta_id == @$itens->operador_id) echo "selected"; ?>>
                                                <?= $itens->nome; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="medico[<?= $i; ?>]" id="medico<?= $i; ?>" class="size1"/>
                                    <input type="hidden" name="crm[<?= $i; ?>]" id="crm<?= $i; ?>" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="convenio[<?= $i; ?>]" id="convenio<?= $i; ?>" class="size1"  >
                                        <option value="">Selecione</option>
                                    </select>
                                </td>
                                
                                <td class="<?php echo $estilo_linha; ?>" >
                                    <select  name="grupo1" id="grupo<?= $i; ?>" class="size1" >
                                        <!--<option value="">Selecione</option>-->
                                        <? //foreach ($grupos as $item2) :?>
<!--                                            <option value="<?= $item2->nome; ?>" <? if ($item2->nome == $item->grupo) echo "selected"; ?>><?= $item2->nome; ?></option>-->
                                        <? // endforeach; ?>
                                    </select>
                                </td>
                                
                                <td class="<?php echo $estilo_linha; ?>" >
                                    <select  name="procedimento[<?= $i; ?>]" id="procedimento<?= $i; ?>" class="size1"  >
                                        <option value="">-- Escolha um procedimento --</option>
                                    </select>
                                </td>

                                <td class="<?php echo $estilo_linha; ?>"><input type="text" name="autorizacao[<?= $i; ?>]" id="autorizacao" class="size1"/></td>
                                <td class="<?php echo $estilo_linha; ?>" <?if(@$empresapermissoes[0]->valor_autorizar == 'f'){?>style="display: none;" <?}?>><input type="text" name="valor[<?= $i; ?>]" id="valor<?= $i; ?>" class="texto01" readonly=""/></td>
                                <td class="<?php echo $estilo_linha; ?>"><input type="number" name="qtde[<?= $i; ?>]" id="qtde<?= $i; ?>"  value="1"  min="1" class="texto01"/></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select  name="formapamento[<?= $i; ?>]" id="formapamento<?= $i; ?>" class="size1" >
                                        <option value="0">Selecione</option>
                                        <? foreach ($forma_pagamento as $value) : ?>
                                            <option value="<?= $value->forma_pagamento_id; ?>"><?= $value->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <select name="indicacao[<?= $i; ?>]" id="indicacao<?= $i; ?>" class="size1" >
                                        <option value=''>Selecione</option>
                                        <?php
                                        $indicacao = $this->paciente->listaindicacao($_GET);
                                        foreach ($indicacao as $itens) {
                                            ?>
                                            <option value="<?php echo $itens->paciente_indicacao_id; ?>">
                                                <?php echo $itens->nome . ( ($itens->registro != '' ) ? " - " . $itens->registro : '' ); ?>
                                            </option>
                                            <?php
                                        }
                                        ?> 
                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                    <select name="ordenador" id="ordenador" class="size1" >
                                        <option value='1' >Normal</option>
                                        <option value='2' >Prioridade</option>
                                        <option value='3' >Urgência</option>

                                    </select>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" ><input type="checkbox" name="confimado[<?= $i; ?>]" id="checkbox<?= $i; ?>"/> <input type="hidden" name="agenda_exames_id[<?= $i; ?>]" value="<?= $agenda_exame_id; ?>" /></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?= substr(@$item->medico, 0, 12); ?> <br><?= substr(@$item->procedimento, 0, 12); ?></td>
                            </tr>

                        </tbody>
                        <?
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="4">
                            </th>
                        </tr>
                    </tfoot>
                </table> 
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </fieldset>
        </form>
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">


    $(document).ready(function () { 

        var convenio_agendado = new Array();
        var proc_agendado = new Array();

        <? for ($b = 1; $b <= $i; $b++) { 
            $it = ($b == 1) ? '' : $b; ?>

            $.getJSON('<?= base_url() ?>autocomplete/listargruposala', { sala: $('#sala<?= $b ?>').val() }, function (j) {
                options = '<option value=""></option>';
                for (var c = 0; c < j.length; c++) {
                    options += '<option value="' + j[c].nome + '">' + j[c].nome + '</option>';
                }
                $('#grupo<?= $b ?> option').remove();
                $('#grupo<?= $b ?>').append(options);
                $("#grupo<?= $b ?>").trigger("chosen:updated");
                $('.carregando').hide();
            }); 
            
            // Traz os convenios liberados para esse médico
            $.getJSON('<?= base_url() ?>autocomplete/medicoconveniogeral', {exame: $('#medico_id<?= $b ?>').val(), ajax: true}, function (j) {
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    var selected = '';
                    

                    convenio_agendado[<?= $b - 1 ?>] = <?= @$exames[$b - 1]->convenio_agenda ?>;
                    proc_agendado[<?= $b - 1 ?>] = <?= @$exames[$b - 1]->procedimento_tuss_id ?>;

                    // Quando ele estiver iterando sobre o convenio que esta marcado o exame, ele entra aqui
                    if(convenio_agendado[<?= $b - 1 ?>] == j[i].convenio_id){ 
                        
                        selected = "selected='true'";
                        <?$it = ($b == 1)?'':$b;?>
                        
                        // Traz todos os procedimentos dos grupos associados a sala
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedicocadastrosala', {convenio1: j[i].convenio_id, sala: $('#sala<?= $b ?>').val(), teste: $('#medico_id<?= $b ?>').val(), ajax: true}, function (t) {
//                            alert('teste');
                            var opt = '<option value=""></option>';
                            for (var c = 0; c < t.length; c++) {
                                // Quando ele estiver iterando sobre o procedimento que estava marcado, ele entra aqui
                                if(proc_agendado[<?= $b - 1 ?>] == t[c].procedimento_convenio_id){
                                    opt += '<option value="' + t[c].procedimento_convenio_id + '" selected="true">' + t[c].procedimento + '</option>';
                                    
                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia<?= $it ?>', {procedimento<?= $b ?>: t[c].procedimento_convenio_id, ajax: true}, function (a) {
                                        var valor = a[0].valortotal;
                                        var qtde = a[0].qtde;
                                        if(qtde == 0){
                                            qtde = 1;
                                        }
                                        <? if($odontologia_alterar == 't'){ ?>
                                            if(a[0].grupo == 'ODONTOLOGIA'){
                                                $("#valor<?=$b?>").prop('readonly', false);
                                            }else{
                                                $("#valor<?=$b?>").prop('readonly', true);
                                            }    
                                        <? }
                                        if(@$exames[$b - 1]->valor != ''){ ?>
                                            document.getElementById("valor<?= $b ?>").value = <?=@$exames[$b - 1]->valor?>;
                                            document.getElementById("qtde<?= $b ?>").value =  <?=@$exames[$b - 1]->quantidade?>;
                                        <? } else { ?>
                                            document.getElementById("valor<?= $b ?>").value = valor;
                                            document.getElementById("qtde<?= $b ?>").value = qtde;  
                                        <? } ?>

                                        $('.carregando').hide();
                                    });


                                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento<?= $b ?>', {procedimento<?= $b ?>: t[c].procedimento_convenio_id, ajax: true}, function (j) {
                                        var options = '<option value="0">Selecione</option>';
                                        for (var c = 0; c < j.length; c++) {
                                            if (j[c].forma_pagamento_id != null) {
                                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                                            }
                                        }
                                        $('#formapamento<?= $b ?>').html(options).show();
                                        $('.carregando').hide();
                                    });
//                                                            formapagamentoporprocedimento
                                }
                                else{
                                    opt += '<option value="' + t[c].procedimento_convenio_id + '">' + t[c].procedimento + '</option>';
                                }
                            }
                            $('#procedimento<?= $b ?>').html(opt).show();
                            $('.carregando').hide();
                        });
                    }
                    options += '<option value="' + j[i].convenio_id + '"'+ selected + '>' + j[i].nome + '</option>';
                    selected = '';
                }


                $('#convenio<?= $b ?>').html(options).show();
                $('.carregando').hide();
            });

            $('#grupo<?= $b ?>').change(function () {
                if ($('#convenio<?= $b ?>').val()) {
                    if ($(this).val()) {
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupomedico', {grupo1: $(this).val(), convenio1: $('#convenio<?= $b ?>').val(), teste: $('#medico_id<?= $b ?>').val(), ajax: true}, function (j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                            }
                            $('#procedimento<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
                    }
                    else{
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedicocadastrosala', {convenio1: $('#convenio<?= $b ?>').val(), sala: $('#sala<?= $b ?>').val(), teste: $('#medico_id<?= $b ?>').val(), ajax: true}, function (j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                            }
//                                                $('#procedimento1').html(options).show();
                            $('#procedimento<?= $b ?> option').remove();
                            $('#procedimento<?= $b ?>').append(options);
                            $("#procedimento<?= $b ?>").trigger("chosen:updated");
                            $('.carregando').hide();
                        });
                    }
                }
            });

            $('#sala<?= $b ?>').change(function () {
                if ($('#sala<?= $b ?>').val()) {
                    $('.carregando').show();
                    var grupo = $('#grupo<?= $b ?>').val();
                    $.getJSON('<?= base_url() ?>autocomplete/listargruposala', { sala: $(this).val() }, function (j) {
                        var options = '<option value=""></option>';
                        for (var c = 0; c < j.length; c++) {
                            if (grupo == j[c].nome) {
                                options += '<option value="' + j[c].nome + '" selected>' + j[c].nome + '</option>';
                            }
                            else{
                                options += '<option value="' + j[c].nome + '">' + j[c].nome + '</option>';
                            }
                        }                                
                        $('#grupo<?= $b ?> option').remove();
                        $('#grupo<?= $b ?>').append(options);
                        $("#grupo<?= $b ?>").trigger("chosen:updated");
                        $('.carregando').hide();
                    }); 

                    if( $('#convenio<?= $b ?>').val() ) {
                        
                        
                        if ( $('#grupo<?= $b ?>').val() ){
                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupomedico', {grupo1: $('#grupo<?= $b ?>').val(), convenio1: $('#convenio<?= $b ?>').val(), teste: $('#medico_id<?= $b ?>').val(), ajax: true}, function (j) {
                                options = '<option value=""></option>';
                                for (var c = 0; c < j.length; c++) {
                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                }
                                $('#procedimento<?= $b ?>').html(options).show();
                                $('.carregando').hide();
                            });
                        }
                        else{
                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedicocadastrosala', {convenio1: $('#convenio<?= $b ?>').val(), sala: $('#sala<?= $b ?>').val(), teste: $('#medico_id<?= $b ?>').val(), ajax: true}, function (j) {
                                options = '<option value=""></option>';
                                for (var c = 0; c < j.length; c++) {
                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                }
                                $('#procedimento<?= $b ?> option').remove();
                                $('#procedimento<?= $b ?>').append(options);
                                $("#procedimento<?= $b ?>").trigger("chosen:updated");
                                $('.carregando').hide();
                            });
                        }
                    }
                }
            });

            $('#procedimento<?= $b; ?>').change(function () {
                if ($(this).val()) {
                    $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimento', {procedimento_id: $(this).val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {
//                          console.log(r);
                        if (r.qtdeConsultas == 0 && r.grupo == "RETORNO") {
                            alert("Erro ao selecionar retorno. Esse paciente não executou o procedimento associado a esse retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
                            $("select[name=procedimento<?= $b; ?>]").val($("select[name=procedimento<?= $b; ?>] option:first-child").val(''));
                        } else if (r.qtdeConsultas > 0 && r.grupo == "RETORNO" && r.retorno_realizado > 0) {
                            alert("Erro ao selecionar retorno. Esse paciente já realizou o retorno associado a esse procedimento no tempo cadastrado");
                            $("select[name=procedimento<?= $b; ?>]").val($("select[name=procedimento<?= $b; ?>] option:first-child").val(''));
                        }
                    });

                    $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimentoinverso', {procedimento_id: $(this).val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {

                        if (r.qtdeConsultas > 0 && r.retorno_realizado == 0) {
//                              alert('asdasd'); 
//                              alert("Esse paciente executou um procedimento associado a um retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
//                              alert(r.procedimento_retorno);
                            if('<?=$retorno_alterar?>' == 'f'){
                                if (confirm("Esse paciente já executou esse procedimento num período de " + r.diasRetorno + " dia(s) e tem direito a um retorno. Deseja atribuí-lo?")) {
//                                  alert('asdas');
                                      $("#procedimento<?= $b; ?>").val(r.procedimento_retorno);
                                      //                                                            $('#valor1').val('0.00');
                                      $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                          options = "";
                                          options += j[0].valortotal;
                                          document.getElementById("valor<?= $b; ?>").value = options;
                                          $('.carregando').hide();
                                      });
                                  } 
                                else {

                              }    
                            } else {
                                alert("Este paciente tem direito a um retorno associado ao procedimento escolhido");
                                $("#procedimento<?= $b; ?>").val(r.procedimento_retorno);    
                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                    options = "";
                                    options += j[0].valortotal;
                                    document.getElementById("valor<?= $b; ?>").value = options;
                                    $('.carregando').hide();
                                });
                            }

                        }
                    });
                }
            });

            $('#checkbox<?= $b ?>').change(function () {
                if ($(this).is(":checked")) {
                    $("#medico_id<?= $b; ?>").prop('required', true);
                    $("#sala<?= $b; ?>").prop('required', true);
                    $("#convenio<?= $b; ?>").prop('required', true);
                    $("#qtde<?= $b; ?>").prop('required', true);
                    $("#procedimento<?= $b; ?>").prop('required', true);
                    <? if ( $recomendacao_obrigatorio == 't' ){ ?>
                        $("#indicacao<?= $b; ?>").prop('required', true);
                    <? } ?>
                     if ($("#procedimento<?= $b; ?>").val() != '') {

                          $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimento', {procedimento_id: $("#procedimento<?= $b; ?>").val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {
//                                    g(r); 
//                                        d');
                              if (r.qtdeConsultas == 0 && r.grupo == "RETORNO") {
                                  alert("Erro ao selecionar retorno. Esse paciente não executou o procedimento associado a esse retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
                                  $("select[name=procedimento<?= $b; ?>]").val($("select[name=procedimento<?= $b; ?>] option:first-child").val(''));
                              } else if (r.qtdeConsultas > 0 && r.grupo == "RETORNO" && r.retorno_realizado > 0) {
                                  alert("Erro ao selecionar retorno. Esse paciente já realizou o retorno associado a esse procedimento no tempo cadastrado");
                                  $("select[name=procedimento<?= $b; ?>]").val($("select[name=procedimento<?= $b; ?>] option:first-child").val(''));
                              }
                          });

                          $.getJSON('<?= base_url() ?>autocomplete/validaretornoprocedimentoinverso', {procedimento_id: $("#procedimento<?= $b; ?>").val(), paciente_id: <?= $paciente_id; ?>, ajax: true}, function (r) {

//                                    g(r);

                              if (r.qtdeConsultas > 0 && r.retorno_realizado == 0) {
//                                    'asdasd'); 
//                                    "Esse paciente executou um procedimento associado a um retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");
//                                    r.procedimento_retorno);
                               if('<?=$retorno_alterar?>' == 'f'){
                                   if (confirm("Esse paciente já executou esse procedimento num período de " + r.diasRetorno + " dia(s) e tem direito a um retorno. Deseja atribuí-lo?")) {
//                                               cutou um procedimento associado a um retorno no(s) ultimo(s) " + r.diasRetorno + " dia(s).");    alert('asdas');
                                         $("#procedimento<?= $b; ?>").val(r.procedimento_retorno);

                                         $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                             options = "";
                                             options += j[0].valortotal;
                                             document.getElementById("valor<?= $b; ?>").value = options;
                                             $('.carregando').hide();
                                         });
                                     } else {

                                     }    
                                   }else{
                                   alert("Este paciente tem direito a um retorno associado ao procedimento escolhido");
                                   $("#procedimento<?= $b; ?>").val(r.procedimento_retorno);    
                                   $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: r.procedimento_retorno, ajax: true}, function (j) {
                                             options = "";
                                             options += j[0].valortotal;
                                             document.getElementById("valor<?= $b; ?>").value = options;
                                             $('.carregando').hide();
                                         });
                                   }
                              }
                          });
                      }   
                } else {
                    $("#medico_id<?= $b; ?>").prop('required', false);
                    $("#sala<?= $b; ?>").prop('required', false);
                    $("#convenio<?= $b; ?>").prop('required', false);
                    $("#qtde<?= $b; ?>").prop('required', false);
                    $("#procedimento<?= $b; ?>").prop('required', false);
                    <? if ( $recomendacao_obrigatorio == 't' ){ ?>
                        $("#indicacao<?= $b; ?>").prop('required', false);
                    <? } ?>
                }
            });

            $("#medico<?= $b ?>").autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=medicos",
                minLength: 3,
                focus: function (event, ui) {
                    $("#medico<?= $b ?>").val(ui.item.label);
                    return false;
                },
                select: function (event, ui) {
                    $("#medico<?= $b ?>").val(ui.item.value);
                    $("#crm<?= $b ?>").val(ui.item.id);
                    return false;
                }
            });

            $('#medico_id<?= $b ?>').change(function () {
                if ($(this).val()) {
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/medicoconvenio', {exame: $(this).val(), ajax: true}, function (j) {
                        var options = '<option value=""></option>';
                        for (var i = 0; i < j.length; i++) {
                            options += '<option value="' + j[i].convenio_id + '">' + j[i].nome + '</option>';
                        }
                        $('#convenio<?= $b ?>').html(options).show();
                        $('.carregando').hide();
                    });
                } else {
                    $('#convenio<?= $b ?>').html('<option value="">-- Escolha um hora --</option>');
                }
            });

            $('#convenio<?= $b ?>').change(function () {
                if ($(this).val()) {
                    $('.carregando').show();
                    
                    if( $('#grupo<?= $b ?>').val() ){
                        $('.carregando').show();
                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniogrupomedico', {grupo1: $('#grupo<?= $b ?>').val(), convenio1: $('#convenio<?= $b ?>').val(), teste: $('#medico_id<?= $b ?>').val(), ajax: true}, function (j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                            }
                            $('#procedimento<?= $b ?>').html(options).show();
                            $('.carregando').hide();
                        });
                    }
                    else{
                        if( $('#sala<?= $b ?>').val() ) {
                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniomedicocadastrosala', {convenio1: $('#convenio<?= $b ?>').val(), sala: $('#sala<?= $b ?>').val(), teste: $('#medico_id<?= $b ?>').val(), ajax: true}, function (j) {
                                options = '<option value=""></option>';
                                for (var c = 0; c < j.length; c++) {
                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                }
    //                                                $('#procedimento1').html(options).show();
                                $('#procedimento<?= $b ?> option').remove();
                                $('#procedimento<?= $b ?>').append(options);
                                $("#procedimento<?= $b ?>").trigger("chosen:updated");
                                $('.carregando').hide();
                            });
                        }
                        else{
                            alert("Favor, selecione uma sala.");
                        }
                    }
                } else {
                    $('#procedimento<?= $b ?>').html('<option value="">-- Escolha um exame --</option>');
                }
            });

            $('#procedimento<?= $b ?>').change(function () {
                if ($(this).val()) {
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalorfisioterapia', {procedimento1: $(this).val(), ajax: true}, function (j) {
                        options = "";
                        options += j[0].valortotal;
                        qtde = "";
                        if(j[0].qtde == ''){
                           qtde += j[0].qtde; 
                        }else{
                           qtde = 1; 
                        }
                        <? if ($odontologia_alterar == 't') { ?>
                             if(j[0].grupo == 'ODONTOLOGIA'){
                                 $("#valor<?= $b ?>").prop('readonly', false);
                             } else {
                                 $("#valor<?= $b ?>").prop('readonly', true);
                             }    
                        <? } ?>
                        document.getElementById("valor<?= $b ?>").value = options;
                        document.getElementById("qtde<?= $b ?>").value = qtde;
                        $('.carregando').hide();
                    });
                } else {
                    $('#valor<?= $b ?>').html('value=""');
                }
            });

            $('#procedimento<?= $b ?>').change(function () {
                if ($(this).val()) {
//                                    alert('sadasd');
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/formapagamentoporprocedimento1', {procedimento1: $(this).val(), ajax: true}, function (j) {
                        var options = '<option value="0">Selecione</option>';
                        for (var c = 0; c < j.length; c++) {
                            if (j[c].forma_pagamento_id != null) {
                                options += '<option value="' + j[c].forma_pagamento_id + '">' + j[c].nome + '</option>';
                            }
                        }
                        $('#formapamento<?= $b ?>').html(options).show();
                        $('.carregando').hide();
                    });

                } else {
                    $('#formapamento<?= $b ?>').html('<option value="0">Selecione</option>');
                }
            });


        <? } ?>

    });

    $(function () {
        $("#accordion").accordion();
    });

</script>
