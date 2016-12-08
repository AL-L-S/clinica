<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>

    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarconsultapacientetemp" method="post">
        <fieldset>
            <div>
                <td width="100px;"><center>
                    <div class="bt_link_new">
                        <a href="<?php echo base_url() ?>ambulatorio/exametemp/novopacienteconsulta">
                            Nova Consulta
                        </a>
                    </div>
                    </td>
            </div>
        </fieldset>
        <fieldset>
            <legend>Marcar Consulta</legend>

            <div>
                <label>Nome</label>
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$obj->_nome; ?>" />
            </div>
            <div>
                <label>Dt de nascimento</label>

                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>"/>
            </div>
            <div>
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= @$obj->_idade; ?>"  />

            </div>
            <div>
                <label>End.</label>
                <input type="text" id="txtEnd" class="texto06" name="txtEnd"  value="<?= @$obj->_endereco; ?> - <?= @$obj->_numero; ?>" />
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
            </div>
            <div>
                <label>Convenio</label>
                <input type="text" id="txtCelular" class="texto02" name="convenio" value="<?= @$obj->_descricaoconvenio; ?>" />
            </div>
        </fieldset>
        <fieldset>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" class="size1"  />
                <input type="hidden" name="txtpaciente_id" value="<?= @$obj->_paciente_id; ?>" />
            </div>
            <legend>Medicos</legend>

            <div>
                <label>Medico</label>
                <select name="exame" id="exame" class="size4">
                    <option value="" >Selecione</option>
                    <? foreach ($medico as $item) : ?>
                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div>
                <label>Horarios</label>
                <select name="horarios" id="horarios" class="size2">
                    <option value="" >-- Escolha um exame --</option>
                </select>
            </div>
            <div>
                <label>Obsedrva&ccedil;&otilde;es</label>
                <input type="text" id="observacoes" class="size3" name="observacoes" />
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
    </form>
</fieldset>

<fieldset>
    <?
    if ($contador > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Data</th>
                    <th class="tabela_header">Hora</th>
                    <th class="tabela_header">M&eacute;dico</th>
                    <th class="tabela_header">Tempo</th>
                    <th class="tabela_header">Observa&ccedil;&otilde;es</th>
                    <th class="tabela_header" colspan="2">&nbsp;</th>
                </tr>
            </thead>
            <?
            $estilo_linha = "tabela_content01";
            foreach ($exames as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->sala . "-" . $item->medico; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><? 
                            $horarioteste = str_replace('-', '', date('Y-m-d') );
                            $data         = str_replace('-', '', $item->data);
                            
                            if( (int)$data > (int)$horarioteste ){
                                $data = date_create($item->data);
                                $horario = date_create(date('Y-m-d'));
                                $intervalo = date_diff($horario, $data);
                                echo  $intervalo->format('%a dias');
                            }
                            else if ( (int)$data == (int)$horarioteste ){
                                echo 'Hoje';
                            }
                            else {
                                echo 'Ainda nao ocorreu';
                            }
                        ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                        width=500,height=230');">=><?= $item->observacoes; ?></a></td>

                        <? if (empty($faltou)) { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                    <a href="<?= base_url() ?>ambulatorio/exametemp/excluirconsultatemp/<?= $item->agenda_exames_id; ?>/<?= @$obj->_paciente_id; ?>">
                                        excluir</a></td></div>
                        <? } ?>
                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                <a href="<?= base_url() ?>ambulatorio/exametemp/reservarconsultatemp/<?= $item->agenda_exames_id; ?>/<?= @$obj->_paciente_id; ?>/<?= $item->medico_consulta_id; ?>/<?= $item->data; ?>">
                                    reservar</a></td></div>

                    </tr>

                </tbody>
                <?
            }
        }
        ?>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 
    <?
    if (count($consultasanteriores) > 0) {
        foreach ($consultasanteriores as $value) {

            $data_atual = date('Y-m-d');
            $data1 = new DateTime($data_atual);
            $data2 = new DateTime($value->data);

            $intervalo = $data1->diff($data2);
            ?>
    <h6><b><?= $intervalo->days ?> dias</b>&nbsp;&nbsp;&nbsp;-ULTIMA ATENDIMENTO: <?= $value->procedimento; ?> - DATA: <b><?= substr($value->data, 8, 2) . '/' . substr($value->data, 5, 2) . '/' . substr($value->data, 0, 4); ?> </b> - M&eacute;dico: <b> <?= $value->medico; ?></b> - Convenio:  <?= $value->convenio; ?></h6>

            <?
        }
    } else {
        ?>
        <h6>NENHUMA CONSULTA ENCONTRADA</h6>
        <?
    }
    ?>


</fieldset>
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
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

                    $(function () {
                        $('#exame').change(function () {
                            if ($(this).val()) {
                                $('#horarios').hide();
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/horariosambulatorioconsulta', {exame: $(this).val(), teste: $("#data_ficha").val()}, function (j) {
                                    var options = '<option value=""></option>';
                                    for (var i = 0; i < j.length; i++) {
                                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '</option>';
                                    }
                                    $('#horarios').html(options).show();
                                    $('.carregando').hide();
                                });
                            } else {
                                $('#horarios').html('<option value="">-- Escolha um hora --</option>');
                            }
                        });
                    });





                    //$(function(){     
                    //    $('#exame').change(function(){
                    //        exame = $(this).val();
                    //        if ( exame === '')
                    //            return false;
                    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
                    //            var option = new Array();
                    //            $.each(data, function(i, obj){
                    //                console.log(obl);
                    //                option[i] = document.createElement('option');
                    //                $( option[i] ).attr( {value : obj.id} );
                    //                $( option[i] ).append( obj.nome );
                    //                $("select[name='horarios']").append( option[i] );
                    //            });
                    //        });
                    //    });
                    //});





                    $(function () {
                        $("#accordion").accordion();
                    });


                    $(document).ready(function () {
                        jQuery('#form_exametemp').validate({
                            rules: {
                                txtNome: {
                                    required: true,
                                    minlength: 3
                                }
                            },
                            messages: {
                                txtNome: {
                                    required: "*",
                                    minlength: "!"
                                }
                            }
                        });
                    });

</script>
