<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpacientetemp" method="post">
        <fieldset>
            <legend>Marcar Exames</legend>

            <div>
                <label>Nome</label>
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$obj->_nome; ?>" />
            </div>
            <div>
                <label>Dt de nascimento</label>

                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr(@$obj->_nascimento, 8, 2) . '/' . substr(@$obj->_nascimento, 5, 2) . '/' . substr(@$obj->_nascimento, 0, 4); ?>"/>
            </div>
            <div>
                <label>Idade</label>
                <input type="text" name="idade2" id="idade2" class="texto01" readonly/>
            </div>
            <div>
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= @$obj->_idade; ?>"  />

            </div>
            <div>
                <label>Telefone</label>


                <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
            </div>
            <div>
                <label>Celular</label>


                <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
            </div>
        </fieldset>
        <fieldset>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" class="size1"  />
                <input type="hidden" name="txtpaciente_id" value="<?= @$obj->_paciente_id; ?>" />
            </div>
            <legend>Exames tipo</legend>

            <div>
                <label>Exame</label>
                <select name="exame" id="exame" class="size1">
                    <option value="" >Selecione</option>
                    <option value="RX" >RX</option>
                    <option value="TOMOGRAFIA" >TOMOGRAFIA</option>
                    <option value="RM" >RM</option>
                    <option value="ULTRA SOM" >ULTRA SOM</option>
                    <option value="MAMO" >MX/D.O</option>
                    <option value="ECG" >ECG</option>
                    <option value="ECOCARDIOGRAMA" >ECOCARDIOGRAMA</option>
                    <option value="ECOESPIROMETRIA" >ECOESPIROMETRIA</option>
                    <option value="ERGOMETRIA" >ERGOMETRIA</option>
                    <option value="ESPIROMETRIA" >ESPIROMETRIA</option>
                    <option value="HOLTER" >HOLTER</option>
                    <option value="MAPA" >MAPA</option>
                </select>
            </div>

            <div>
                <label>Horarios</label>
                <select name="horarios" id="horarios" class="size2">
                    <option value="" >-- Escolha um exame --</option>
                </select>
            </div>
            <div>
                <label>Convenio *</label>
                <select name="convenio1" id="convenio1" class="size4">
                    <option  value="-1">Selecione</option>
                    <? foreach ($convenio as $value) : ?>
                        <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Procedimento</label>
                <select  name="procedimento1" id="procedimento1" class="size1" >
                    <option value="">Selecione</option>
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
                    <th class="tabela_header">Sala</th>
                    <th class="tabela_header">Exame</th>
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
                        <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/vizualizarpreparo/<?= $item->tuss_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                width=800,height=400');"><?= $item->procedimento; ?></a></td>
                        <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacao/<?= $item->agenda_exames_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,\n\
                                                                                width=500,height=230');">=><?= $item->observacoes; ?></a></td>

                        <? if (empty($faltou)) { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                    <a href="<?= base_url() ?>ambulatorio/exametemp/excluirexametemp/<?= $item->agenda_exames_id; ?>/<?= @$obj->_paciente_id; ?>">
                                        excluir</a></td></div>
                        <? } ?>
                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                <a href="<?= base_url() ?>ambulatorio/exametemp/reservarexametemp/<?= $item->agenda_exames_id; ?>/<?= @$obj->_paciente_id; ?>/<?= $item->agenda_exames_nome_id; ?>/<?= $item->data; ?>">
                                    reservar</a></td></div>
                    </tr>


                    <?
                }
            }
            ?>

        </tbody>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 
    <?
    if (count($examesanteriores) > 0) {
        foreach ($examesanteriores as $value) {

            $data_atual = date('Y-m-d');
            $data1 = new DateTime($data_atual);
            $data2 = new DateTime($value->data);

            $intervalo = $data1->diff($data2);
            ?>
            <h6><b><?= $intervalo->days ?> dia(s)</b>&nbsp;&nbsp;&nbsp;- ULTIMA ATENDIMENTO: <?= $value->procedimento; ?> - DATA: <b><?= substr($value->data, 8, 2) . '/' . substr($value->data, 5, 2) . '/' . substr($value->data, 0, 4); ?> </b> - M&eacute;dico: <b> <?= $value->medico; ?></b> - Convenio:  <?= $value->convenio; ?></h6>

            <?
        }
    } else {
        ?>
        <h6>NENHUM EXAME ENCONTRADO</h6>
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
                                $.getJSON('<?= base_url() ?>autocomplete/horariosambulatorio', {exame: $(this).val(), teste: $("#data_ficha").val()}, function (j) {
                                    var options = '<option value=""></option>';
                                    for (var i = 0; i < j.length; i++) {
                                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '-' + j[i].nome + '- Dr. ' + j[i].medico + '</option>';
                                    }
                                    $('#horarios').html(options).show();
                                    $('.carregando').hide();
                                });
                            } else {
                                $('#horarios').html('<option value="">-- Escolha um exame --</option>');
                            }
                        });
                    });


                    $(function () {
                        $('#convenio1').change(function () {
                            if ($(this).val()) {
                                $('.carregando').show();
                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function (j) {
                                    options = '<option value=""></option>';
                                    for (var c = 0; c < j.length; c++) {
                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                    }
                                    $('#procedimento1').html(options).show();
                                    $('.carregando').hide();
                                });
                            } else {
                                $('#procedimento1').html('<option value="">Selecione</option>');
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

                    function calculoIdade() {
                        var data = document.getElementById("txtNascimento").value;
                        var ano = data.substring(6, 12);
                        var idade = new Date().getFullYear() - ano;
                        document.getElementById("idade2").value = idade;
                    }

                    calculoIdade();

</script>