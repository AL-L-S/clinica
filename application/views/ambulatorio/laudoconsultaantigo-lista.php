
<div class="content"> <!-- Inicio da DIV content -->
    <?
    $salas = $this->exame->listartodassalas();
    $medicos = $this->operador_m->listarmedicos();
    $especialidade = $this->exame->listarespecialidade();
    ?>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Consultas</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            <form method="get" action="<?= base_url() ?>ambulatorio/laudo/pesquisarconsultaantigo">
                                <tr>
                                    
                                    <th colspan="2" class="tabela_title">Nome</th>
                                </tr>
                                <tr>
                                   
                                    <th colspan="2" class="tabela_title">
                                        <input type="text" name="paciente" class="texto06 bestupper" value="<?php echo @$_GET['paciente']; ?>" />
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
                        <th class="tabela_header" width="30px;">Prontuario</th>
                        <th class="tabela_header" width="300px;">Nome</th>
                        <th class="tabela_header" width="30px;"></th>
                        <th class="tabela_header" width="30px;"></th>
                        <th class="tabela_header" width="130px;"></th>
                        <th class="tabela_header"></th>
                        <th class="tabela_header" width="300px;"></th>
<!--                            <th class="tabela_header">M&eacute;dico Revisor</th>
                        <th class="tabela_header">Status Revisor</th>-->
                        <th class="tabela_header" colspan="3" width="140px;"><center>Ações</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->laudo->listarhistoricoantigo($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->laudo->listarhistoricoantigo2($_GET)->limit($limit, $pagina)->get()->result();
//                        var_dump($lista); die;
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");
//                            $dataAtual = $item->data_cadastro;
                            $operador_id = $this->session->userdata('operador_id');
                            $perfil_id = $this->session->userdata('perfil_id');
//                            $date_time = new DateTime($dataAtual);
//                            $diff = $date_time->diff(new DateTime($dataFuturo));
//                            $teste = $diff->format('%d');

                            $ano_atual = date("Y");
                            
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><?//= substr($item->data_cadastro, 8, 2) . "/" . substr($item->data_cadastro, 5, 2) . "/" . substr($item->data_cadastro, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="130px;"></td>
                                <td class="<?php echo $estilo_linha; ?>" width="130px;"></td>
                                <td class="<?php echo $estilo_linha; ?>"></td>
                                <td class="<?php echo $estilo_linha; ?>"></td>
                                <td class="<?php echo $estilo_linha; ?>" width="40px;"><div class="bt_link_new">
                                        <a style="text-align: center;cursor: pointer;" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/carregaranamineseantigo/<?= $item->paciente_id; ?>');" >
                                                Histórico</a></div>
                                </td>
                                
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="12">
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

                                        setTimeout('delayReload()', 20000);
                                        function delayReload()
                                        {
                                            if (navigator.userAgent.indexOf("MSIE") != -1) {
                                                history.go(0);
                                            } else {
                                                window.location.reload();
                                            }
                                        }

                                    });

</script>
