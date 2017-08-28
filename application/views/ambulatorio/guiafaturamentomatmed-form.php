<div class="content ficha_ceatox">
    <div >
        <?
        $sala = "";
        $ordenador1 = "";
        $sala_id = "";
        $medico_id = "";
        $medico = "";
        $medico_solicitante = "";
        $medico_solicitante_id = "";
        $convenio_paciente = "";
        $empresa_id = $this->session->userdata('empresa_id');
        ?>
        <h3 class="singular"><a href="#">Faturar Guia</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentosfaturamentomatmed" method="post">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                        <input type="hidden" id="txtguia_id" name="txtguia_id"  value="<?= $guia_id; ?>"/>
                        <input type="hidden" id="txtdata" name="txtdata"  value="<?= @$exames[0]->data; ?>"/>
                    </div>
                    <div>
                        <label>Sexo</label>
                        <select name="sexo" id="txtSexo" class="size2">
                            <option value="M" <?
                            if ($paciente['0']->sexo == "M"):echo 'selected';
                            endif;
                            ?>>Masculino</option>
                            <option value="F" <?
                            if ($paciente['0']->sexo == "F"):echo 'selected';
                            endif;
                            ?>>Feminino</option>
                        </select>
                    </div>

                    <div>
                        <label>Nascimento</label>


                        <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                    </div>

                    <div>

                        <label>Idade</label>
                        <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

                    </div>

                    <div>
                        <label>Nome da M&atilde;e</label>
                        <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                    </div>
                </fieldset>

                <fieldset>

                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th class="tabela_header">Qtde</th>
                                <th class="tabela_header">Medico</th>
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Material</th>
                                <!--<th class="tabela_header">Tipo</th>-->
                                <th class="tabela_header">autorizacao</th>
                                <th class="tabela_header">V. Unit</th>
                                <th class="tabela_header">Empresa</th>
                                <!--<th class="tabela_header">Laudo</th>-->
<!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td  width="10px;"><input type="text" name="qtde1" id="qtde1" value="1" onchange="alteraQuantidade()" class="texto00"/></td>
                                <td> 
                                    <select  name="medicoagenda" id="medicoagenda" class="size2"  required="">
                                        <option value="">Selecione</option>
                                        <? foreach ($medicos as $item) : ?>
                                            <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                                <? endforeach; ?>
                                    </select>
                                </td>
                                <td  width="50px;">
                                    <select  name="convenio1" id="convenio1" class="size1" required="">
                                        <option value="-1">Selecione</option>
                                        <? foreach ($convenios as $item) : ?>
                                            <option value="<?= $item->convenio_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <td  width="50px;">
                                    <select  name="procedimento1" id="procedimento1" class="size1" required="">
                                        <option value="">Selecione</option>
                                    </select>
                                </td>
                                
<!--                                <td  width="50px;">
                                    <select  name="tipo" id="tipo" class="size1" >
                                        <option value="EXAME">EXAME</option>
                                        <option value="CONSULTA">CONSULTA</option>
                                    </select>
                                </td>-->

                                <td  width="50px;"><input type="text" name="autorizacao1" id="autorizacao" class="size1"/></td>
                                <td  width="20px;">
                                    <input type="text" name="valor1" id="valor1" class="texto01" readonly=""/>
                                    <input type="hidden" name="valortot" id="valortot" class="texto01" readonly=""/>
                                </td>
                                <td>
                                    <select  name="txtempresa" id="empresa" class="size06" >
                                        <? foreach ($empresa as $item) : ?>
                                            <option value="<?= $item->empresa_id; ?>" <?
                                            if ($empresa_id == $item->empresa_id):echo 'selected';
                                            endif;
                                            ?>>
                                                <?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>
                                <!--<td  width="10px;"><input type="checkbox" name="laudo" /></td>-->
        <!--                                <td  width="70px;"><input type="text" name="observacao" id="observacao" class="texto04"/></td>-->
                            </tr>

                        </tbody>

                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="4">
                                </th>
                            </tr>
                        </tfoot>
                    </table> 
                    <hr/>
                    <button type="submit" name="btnEnviar">Adicionar</button>
                </fieldset>
            </form>
            

        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
                                        function percentual() {
                                            var valordesconto = parseFloat(document.form_guia.desconto.value.replace(",", "."));
                                            var desconto = valordesconto / 100;
                                            var valortot = document.getElementById("valortot").value;
                                            var valor = valortot * desconto;
                                            var r = valor.toFixed(2);

                                            document.getElementById("valor1").value = r;
                                        }

                                        $(function () {
                                            $("#data").datepicker({
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
                                            $("#accordion").accordion();
                                        });


                                        $(function () {
                                            $('#convenio1').change(function () {
                                                if ($(this).val()) {
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentoconveniofaturarmatmed', {convenio1: $(this).val(), ajax: true}, function (j) {
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


                                        $(function () {
                                            $('#procedimento1').change(function () {
                                                if ($(this).val()) {
                                                    $('.carregando').show();
                                                    $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function (j) {

                                                        var valorTotal = parseFloat(j[0].valortotal);
                                                        var qt = document.getElementById("qtde1").value;
                                                        document.getElementById("valor1").value = valorTotal;
                                                        document.getElementById("valortot").value = valorTotal;
                                                        $('.carregando').hide();

                                                    });
                                                } else {
                                                    $('#valor1').html('value=""');
                                                }
                                            });
                                        });

                                        function alteraQuantidade() {
                                            if ($("#procedimento1").val()) {
                                                $('.carregando').show();
                                                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $("#procedimento1").val(), ajax: true}, function (j) {

                                                    var valorTotal = parseFloat(j[0].valortotal);
                                                    var qt = document.getElementById("qtde1").value;
//                                                    document  .getElementById("valor1").value = qt * valorTotal;
                                                    document.getElementById("valortot").value = valorTotal;
                                                    $('.carregando').hide();

                                                });
                                            } else {
                                                $('#valor1').html('value=""');
                                            }
                                        }




</script>