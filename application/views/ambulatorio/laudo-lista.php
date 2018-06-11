
<div class="content"> <!-- Inicio da DIV content -->
    <?
    $salas = $this->exame->listartodassalas();
    $medicos = $this->operador_m->listarmedicos();
    $especialidade = $this->exame->listarespecialidade();
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Laudo</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/laudo/pesquisar">
                                <tr>
                                    <th class="tabela_title">Salas</th>
                                    <th class="tabela_title">Especialidade</th>
                                    <th class="tabela_title">Medico</th>
                                    <th class="tabela_title">Status</th>
                                    <th class="tabela_title">Data</th>
                                    <th colspan="2" class="tabela_title">Nome</th>
                                </tr>
                                <tr>
                                    <th class="tabela_title">
                                        <select name="sala" id="sala" class="size1">
                                            <option value=""></option>
                                            <? foreach ($salas as $value) : ?>
                                                <option value="<?= $value->exame_sala_id; ?>" <?
                                                if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                                endif;
                                                ?>><?php echo $value->nome; ?></option>
                                                    <? endforeach; ?>
                                        </select>
                                    </th>
                                    <th class="tabela_title">
                                        <select name="especialidade" id="especialidade" class="size1">
                                            <option value=""></option>
                                            <? foreach ($especialidade as $value) : ?>
                                                <option value="<?= $value->cbo_ocupacao_id; ?>" <?
                                                if (@$_GET['especialidade'] == $value->cbo_ocupacao_id):echo 'selected';
                                                endif;
                                                ?>><?php echo $value->descricao; ?></option>
                                                    <? endforeach; ?>
                                        </select>
                                    </th>
                                    <th class="tabela_title">
                                        <select name="medico" id="medico" class="size2">
                                            <option value=""> </option>
                                            <? foreach ($medicos as $value) : ?>
                                                <option value="<?= $value->operador_id; ?>" <?
                                                if (@$_GET['medico'] == $value->operador_id):echo 'selected';
                                                endif;
                                                ?>><?php echo $value->nome; ?></option>
                                                    <? endforeach; ?>
                                        </select>
                                    </th>
                                    <th class="tabela_title">
                                        <select name="situacao" id="situacao" class="size1" >
                                            <option value='' ></option>
                                            <option value='AGUARDANDO' >AGUARDANDO</option>
                                            <option value='DIGITANDO' >DIGITANDO</option>
                                            <option value='FINALIZADO' >FINALIZADO</option>
                                            <option value='REVISAR' >REVISAR</option>
                                        </select>
                                    </th>
                                    <th class="tabela_title">
                                        <input type="text"  id="data" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                                    </th>
                                    <th colspan="2" class="tabela_title">
                                        <input type="text" name="nome" class="texto06 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                                    </th>
                                    <th class="tabela_title">
                                        <button type="submit" id="enviar">Pesquisar</button>
                                    </th>
                            </form>
                </thead>
            </table>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header" width="300px;">Nome</th>
                        <th class="tabela_header" width="30px;">Idade</th>
                        <th class="tabela_header" width="30px;">Data</th>
                        <th class="tabela_header" width="130px;">M&eacute;dico</th>
                        <th class="tabela_header">Status</th>
                        <th class="tabela_header" width="300px;">Procedimento</th>
<!--                            <th class="tabela_header">M&eacute;dico Revisor</th>
                        <th class="tabela_header">Status Revisor</th>-->
                        <th class="tabela_header" colspan="5" width="140px;"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->laudo->listar($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->laudo->listar2($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
                            $dataAtual = $item->data_cadastro;
                            $operador_id = $this->session->userdata('operador_id');
                            $perfil_id = $this->session->userdata('perfil_id');
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));
                            $teste = $diff->format('%d');

                            $ano_atual = date("Y");
                            $ano_nascimento = substr($item->nascimento, 0, 4);
                            $idade = $ano_atual - $ano_nascimento;

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?= $idade; ?></td>

                                <?
                                if (isset($item->data_antiga)) {
                                    $data_alterada = 'alterada';
                                } else {
                                    $data_alterada = '';
                                }
                                ?>

                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/alterardata/<?= $item->ambulatorio_laudo_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=250');">
                                        <?= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?><br/><?= $data_alterada ?></a></td>

                                <td class="<?php echo $estilo_linha; ?>" width="130px;"><?= substr($item->medico, 0, 18); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
        <!--                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->medicorevisor; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao_revisor; ?></td>-->
                                <?
                                if (($item->medico_parecer1 == $operador_id && $item->situacao == 'FINALIZADO') || $item->situacao != 'FINALIZADO' || $operador_id == 1  || $perfil_id == 1) {
                                    if ($item->grupo == 'ECOCARDIOGRAMA' && false) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarlaudoeco/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');" >
                                                    Laudo</a></div>
                                        </td>
                                        <?
                                    } else {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregarlaudo/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>');" >
                                                    Laudo</a></div>
                                        </td>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="40px;"><font size="-2">
                                        <a>Bloqueado</a></font>
                                    </td>
                                <? }
                                ?>
        <!--                                    <td class="<?php echo $estilo_linha; ?>" width="70px;">
        <a href="<?= base_url() ?>ambulatorio/laudo/carregarrevisao/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>">
        Revis&atilde;o</a>
        </td>-->

                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>');">
                                            Imprimir</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoimagem/<?= $item->ambulatorio_laudo_id ?>/<?= $item->exame_id ?>');">
                                            imagem</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoetiiqueta/<?= $item->paciente_id ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">
                                            Etiqueta</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/listarxml/<?= $item->convenio ?>/<?= $item->paciente_id ?>');">
                                            XML</a></div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="14">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">
    $(document).ready(function () {
//alert('teste_parada');
 if ($('#especialidade').val() != '') {
            $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $('#especialidade').val(), ajax: true}, function (j) {
                var options = '<option value=""></option>';
                var slt = '';
                for (var c = 0; c < j.length; c++) {
                    if (j[0].operador_id != undefined) {
                        if (j[c].operador_id == '<?= @$_GET['medico'] ?>') {
                            slt = 'selected';
                        }
                        options += '<option value="' + j[c].operador_id + '" ' + slt + '>' + j[c].nome + '</option>';
                        slt = '';
                    }
                }
                $('#medico').html(options).show();
                $('.carregando').hide();



            });
        }
        $(function () {
            $('#especialidade').change(function () {

                if ($(this).val()) {

//                                                  alert('teste_parada');
                    $('.carregando').show();
//                                                        alert('teste_parada');
                    $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidade', {txtcbo: $(this).val(), ajax: true}, function (j) {
                        options = '<option value=""></option>';
                        console.log(j);

                        for (var c = 0; c < j.length; c++) {


                            if (j[0].operador_id != undefined) {
                                options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                            }
                        }
                        $('#medico').html(options).show();
                        $('.carregando').hide();



                    });
                } else {
                    $('.carregando').show();
//                                                        alert('teste_parada');
                    $.getJSON('<?= base_url() ?>autocomplete/medicoespecialidadetodos', {txtcbo: $(this).val(), ajax: true}, function (j) {
                        options = '<option value=""></option>';
                        console.log(j);

                        for (var c = 0; c < j.length; c++) {


                            if (j[0].operador_id != undefined) {
                                options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';

                            }
                        }
                        $('#medico').html(options).show();
                        $('.carregando').hide();



                    });

                }
            });
        });



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

//                                        setTimeout('delayReload()', 20000);
//                                        function delayReload()
//                                        {
//                                            if (navigator.userAgent.indexOf("MSIE") != -1) {
//                                                history.go(0);
//                                            } else {
//                                                window.location.reload();
//                                            }
//                                        }

    });

    setInterval(function () {
        window.location.reload();
    }, 180000);
</script>
