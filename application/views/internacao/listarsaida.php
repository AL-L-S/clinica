<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Manter Saidas</a></h3>
        <div>
            <?
            $unidades = $this->unidade_m->listaunidadepacientes();
            $enfermarias = $this->enfermaria_m->listaenfermariarelatorio();
            $leitos = $this->leito_m->listaleitorelatorio();
            $medicos = $this->operador_m->listarmedicos();
            ?>
            <table>
                <thead>
                <form method="get" action="<?php echo base_url() ?>internacao/internacao/pesquisarsaida">
                    <tr>
                        <th colspan="1" class="tabela_title">
                            Nome
                        </th>
                        <th colspan="1" class="tabela_title">
                            Data Inicio
                        </th>
                        <th colspan="1" class="tabela_title">
                            Data Fim
                        </th>
                        <th colspan="1" class="tabela_title">
                            Unidade
                        </th>
                        <th colspan="1" class="tabela_title">
                            Enfermaria
                        </th>
                        <th colspan="1" class="tabela_title">
                            Leito
                        </th>
                        <th colspan="1" class="tabela_title">
                            Médico Responsável
                        </th>


                    </tr>
                    <tr>
                        <th colspan="1" class="tabela_title">

                            <input name="nome" type="text" class="texto05" value="<?= @$_GET['nome'] ?>">
                            <!--<button type="submit" id="enviar">Pesquisar</button>-->

                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data_inicio" alt="date" name="data_inicio" class="size1"  value="<?php echo @$_GET['data_inicio']; ?>" />
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data_fim" alt="date" name="data_fim" class="size1"  value="<?php echo @$_GET['data_fim']; ?>" />
                        </th>
                        <th colspan="1" class="tabela_title">
                            <select name="unidade" id="unidade" class="size1" >
                                <option value=''>TODOS</option>
                                <?php
                                foreach ($unidades as $item) {
                                    ?>
                                    <option value="<?php echo $item->internacao_unidade_id; ?>" <?= (@$_GET['unidade'] == $item->internacao_unidade_id) ? 'selected' : '' ?>>

                                        <?= $item->internacao_unidade_id ?>  -  <?php echo $item->nome; ?>
                                    </option>
                                    <?php
                                }
                                ?> 
                            </select>
                        </th>
                        <th colspan="1" class="tabela_title">
                            <select name="enfermaria" id="enfermaria" class="size1" >
                                <option value=''>TODOS</option>

                            </select>
                        </th>
                        <th colspan="1" class="tabela_title">
                            <select name="leito" id="leito" class="size1" >
                                <option value=''>TODOS</option>

                            </select>
                        </th>
                        <th colspan="1" class="tabela_title">
                            <select name="medico_responsavel" id="medico_responsavel" class="size1" >
                                <option value=''>TODOS</option>
                                <?php
                                foreach ($medicos as $item) {
                                    ?>
                                    <option value="<?php echo $item->operador_id; ?>" <?= (@$_GET['medico_responsavel'] == $item->operador_id) ? 'selected' : '' ?>>

                                        <?php echo $item->nome; ?>
                                    </option>
                                    <?php
                                }
                                ?> 
                            </select>
                        </th>



                        <th>
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>
                    </tr>
                </form>
                </thead>
            </table>
            <table>    
                <tr>
                    <th class="tabela_header">Prontuario</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Data de Internação</th>
                    <th class="tabela_header">Data da Saida</th>
                    <th class="tabela_header" width="30px;"><center></center></th>
                <th class="tabela_header" width="30px;"><center></center></th>
                <th class="tabela_header" colspan="4">Detalhes</th>
                </tr>

                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->internacao_m->listarsaida($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->internacao_m->listarsaida($_GET)->orderby('data_saida desc')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->paciente_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo substr($item->data_internacao, 8, 2) . '/' . substr($item->data_internacao, 5, 2) . '/' . substr($item->data_internacao, 0, 4) . ' ' . substr($item->data_saida, 11, 8); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo substr($item->data_saida, 8, 2) . '/' . substr($item->data_saida, 5, 2) . '/' . substr($item->data_saida, 0, 4) . ' ' . substr($item->data_saida, 11, 8); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                </td>
                                <?
                                $perfil_id = $this->session->userdata('perfil_id');
                                ?>
                                <? if ($perfil_id == 1) { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <div style="width: 70px;" class="bt_link_new">
                                            <a href="<?= base_url() ?>internacao/internacao/mostrarnovasaidapaciente/<?= $item->internacao_id ?>">
                                                Editar
                                            </a>
                                        </div>

                                    </td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                    <div style="width: 80px;" class="bt_link_new">
                                        <a href="<?= base_url() ?>internacao/internacao/retornarinternacao/<?= $item->internacao_id ?>">
                                            Re-Internar
                                        </a>
                                    </div>

                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                    <div class="bt_link_new">
                                        <a href="<?= base_url() ?>internacao/internacao/mostrarsaidapaciente/<?= $item->internacao_id ?>">
                                            Detalhes
                                        </a>
                                    </div>

                                </td>
                                <td class="<?php echo $estilo_linha; ?>"style="width: 90px;"><div style="width: 90px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/listarimpressoes/<?= $item->internacao_id ?>"> Impressões</a></div></td>

                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="10">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
    $(function () {
        $("#data_inicio").datepicker({
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
        $("#data_fim").datepicker({
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

<? if (@$_GET['enfermaria'] > 0) { ?>
        var enfermaria = <?= @$_GET['enfermaria'] ?>;
<? } else { ?>
        var enfermaria = '';
<? } ?>

<? if (@$_GET['leito'] > 0) { ?>
        var leito = <?= @$_GET['leito'] ?>;
<? } else { ?>
        var leito = '';
<? } ?>


    if ($('#unidade').val() > 0) {
//        alert(unidade);
        $('.carregando').show();
        $.getJSON('<?= base_url() ?>autocomplete/enfermariaunidade', {id: $('#unidade').val(), ajax: true}, function (j) {
            options = '<option value=""></option>';
            console.log(j);

            for (var c = 0; c < j.length; c++) {
                if (enfermaria == j[c].id) {
                    options += '<option selected value="' + j[c].id + '">' + j[c].value + '</option>';
                } else {
                    options += '<option value="' + j[c].id + '">' + j[c].value + '</option>';
                }


            }
            $('#enfermaria').html(options).show();
            $('.carregando').hide();

            if ($('#enfermaria').val() > 0) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/leitoenfermaria', {id: $('#enfermaria').val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
//            console.log(j);

                    for (var c = 0; c < j.length; c++) {
                        if (leito == j[c].id) {
                            options += '<option selected value="' + j[c].id + '">' + j[c].value + '</option>';
                        } else {
                            options += '<option value="' + j[c].id + '">' + j[c].value + '</option>';
                        }


                    }
                    $('#leito').html(options).show();
                    $('.carregando').hide();
                });
            }

        });
    }

    $(function () {
        $('#unidade').change(function () {
//            alert('adsdasd');
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/enfermariaunidade', {id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
//                    console.log(j);

                    for (var c = 0; c < j.length; c++) {

                        options += '<option value="' + j[c].id + '">' + j[c].value + '</option>';

                    }
                    $('#enfermaria').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('.carregando').show();
                options = '';
                $('#enfermaria').html(options).show();
            }
        });
    });




    $(function () {
        $('#enfermaria').change(function () {
//            alert('adsdasd');
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/leitoenfermaria', {id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
//                    console.log(j);

                    for (var c = 0; c < j.length; c++) {

                        options += '<option value="' + j[c].id + '">' + j[c].value + '</option>';

                    }
                    $('#leito').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('.carregando').show();
                options = '';
                $('#leito').html(options).show();
            }
        });
    });


</script>