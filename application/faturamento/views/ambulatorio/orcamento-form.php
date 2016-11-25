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
        ?>
        <h3 class="singular"><a href="#">Or&ccedil;amento exames</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarorcamento" method="post">
                <fieldset>
                    <legend>Dados do Pacienete</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
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
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Procedimento</th>
                                <th class="tabela_header">Qtde</th>
                                <th class="tabela_header">V. Unit</th>
<!--                                <th class="tabela_header">Observa&ccedil;&otilde;es</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td  width="50px;">
                                    <select  name="convenio1" id="convenio1" class="size1" >
                                        <option value="-1">Selecione</option>
                                        <? foreach ($convenio as $item) : ?>
                                            <option value="<?= $item->convenio_id; ?>"><?= $item->nome; ?></option>
                                        <? endforeach; ?>
                                    </select>
                                </td>

                                <td  width="50px;">
                                    <select  name="procedimento1" id="procedimento1" class="size1" >
                                        <option value="">Selecione</option>
                                    </select>
                                </td>
                                <td  width="10px;"><input type="text" name="qtde1" id="qtde1" value="1" class="texto00"/></td>
                                <td  width="20px;"><input type="text" name="valor1" id="valor1" class="texto01" readonly=""/></td>
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
            <fieldset>
                <?
                $total = 0;
                $orcamento = 0;
                if (count($exames) > 0) {
                    ?>
                    <table id="table_agente_toxico" border="0">
                        <thead>

                            <tr>
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Procedimento</th>
                                <th class="tabela_header">V. Unit</th>
                            </tr>
                        </thead>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($exames as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            $total = $total + $item->valor_total;
                            $orcamento = $item->orcamento_id;
                            ?>
                            <tbody>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento . "-" . $item->codigo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                </tr>

                            </tbody>
                            <?
                        }
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="6">
                                Valor Total: <?php echo number_format($total, 2, ',', '.'); ?>
                            </th>
                            <th colspan="2" align="center"><center><div class="bt_linkf">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/impressaoorcamento/" . $orcamento; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=600');">Imprimir Or&ccedil;amento

                            </a></div></center></th>
                    </tr>
                    </tfoot>
                </table> 

            </fieldset>

        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

                            $(function() {
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

                            $(function() {
                                $("#accordion").accordion();
                            });


                            $(function() {
                                $("#medico1").autocomplete({
                                    source: "<?= base_url() ?>index?c=autocomplete&m=medicos",
                                    minLength: 3,
                                    focus: function(event, ui) {
                                        $("#medico1").val(ui.item.label);
                                        return false;
                                    },
                                    select: function(event, ui) {
                                        $("#medico1").val(ui.item.value);
                                        $("#crm1").val(ui.item.id);
                                        return false;
                                    }
                                });
                            });

                            $(function() {
                                $('#convenio1').change(function() {
                                    if ($(this).val()) {
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenio', {convenio1: $(this).val(), ajax: true}, function(j) {
                                            options = '<option value=""></option>';
                                            for (var c = 0; c < j.length; c++) {
                                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                                            }
                                            $('#procedimento1').html(options).show();
                                            $('.carregando').hide();
                                        });
                                    } else {
                                        $('#procedimento1').html('<option value="">Selecione</option>');
                                    }
                                });
                            });


                            $(function() {
                                $('#procedimento1').change(function() {
                                    if ($(this).val()) {
                                        $('.carregando').show();
                                        $.getJSON('<?= base_url() ?>autocomplete/procedimentovalor', {procedimento1: $(this).val(), ajax: true}, function(j) {
                                            options = "";
                                            options += j[0].valortotal;
                                            document.getElementById("valor1").value = options
                                            $('.carregando').hide();
                                        });
                                    } else {
                                        $('#valor1').html('value=""');
                                    }
                                });
                            });




</script>