<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Excluir Horários</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Data</th>
                        <th class="tabela_header">Entrada 1</th>
                        <th class="tabela_header">Sa&iacute;da 1</th>
                        <th class="tabela_header">Inicio intervalo</th>
                        <th class="tabela_header">Fim do intervalo</th>
                        <th class="tabela_header">Tempo consulta</th>
                        <th class="tabela_header">Obs</th>
                        <th class="tabela_header">Empresa</th>
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
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>



                            <td class="<?php echo $estilo_linha; ?>" width="100px;">

                            </td>
                        </tr>

                    </tbody>
                    <?php
                }
                ?>

            </table>
            <!--        </div>
               
                    <h3 class="singular"><a href="#">Excluir Agenda</a></h3>
                    <div>-->
            <br>
            <!--<br>-->
            <!--<br>-->
            <form name="form_exame" id="form_exame" action="<?= base_url() ?>ambulatorio/agenda/excluirhorarioagendamodelo2/<?=$horariovariavel_id.'/' .$horariotipo?>" method="post">

                <dl class="dl_desconto_lista">

                    <!--                    <dt>
                                            <label>Data inicial</label>
                                        </dt>
                                        <dd>
                                            <input type="text"  id="txtdatainicial" name="txtdatainicial" alt="date" class="size2" />
                                        </dd>
                                        <dt>
                                            <label>Data final</label>
                                        </dt>
                                        <dd>
                                            <input type="text"  id="txtdatafinal" name="txtdatafinal" alt="date" class="size2" />
                                        </dd>-->
                    <dt>
                        <label>Excluir Horários no Agendamento</label>
                    </dt>
                    <dd>
                        <input type="checkbox"  id="checkbox" name="excluir"  class="" />
                    </dd>

                    <dt style="display:none">
                        <label>Tipo *</label>
                    </dt>
                    <dd style="display:none">
                        <select name="txttipo" id="txttipo" class="size4" >
                            <option value="">Selecione</option>
                            <option value="TODOS">TODOS</option>
                            <option value="EXAME">EXAME</option>
                            <option value="CONSULTA">CONSULTA</option>
                            <option value="ESPECIALIDADE">ESPECIALIDADE</option>

                        </select>
                    </dd>
                    <dt style="display:none">
                        <label>Medico *</label>
                    </dt>
                    <dd style="display:none">
                        <select name="txtmedico" id="txtmedico" class="size4" >
                            <option value="">Selecione</option>
                            <option value="TODOS">TODOS</option>
                            <? foreach ($medicos as $item) : ?>
                                <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">


    $('#checkbox').change(function () {
        if ($(this).is(":checked")) {
            $("#txttipo").prop('required', true);
            $("#txtmedico").prop('required', true);
            
        } else {
            $("#txttipo").prop('required', false);
            $("#txtmedico").prop('required', false);
           
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

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $("#txtprocedimentolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtpacientelabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtpacientelabel").val(ui.item.value);
                $("#txtpacienteid").val(ui.item.id);
                return false;
            }
        });
    });

    $(document).ready(function () {
        jQuery('#form_exame').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                },
                txtTipo: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtTipo: {
                    required: "*"
                }
            }
        });
    });

</script>