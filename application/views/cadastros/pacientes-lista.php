<div class="content"> <!-- Inicio da DIV content -->

    <table>
        <tr>
            <td width="60px;">
                <div class="bt_link">
                <a href="<?php echo base_url() ?>cadastros/pacientes/novo">
                    Cadastro
                </a>
            </div>
            </td>
<!--            
            <td width="100px;"><center>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/exametemp/novopaciente">
                        Agendar Exame
                    </a>
                </div>
                </td>
                <td width="100px;"><center>
                    <div class="bt_link_new">
                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteexameencaixe');">
                            Encaixar Exame
                        </a>
                    </div>
                    </td>
                    <td width="100px;"><center>
                        <div class="bt_link_new">
                            <a href="<?php echo base_url() ?>ambulatorio/exametemp/novopacienteconsulta">
                                Agendar Consulta
                            </a>
                        </div>
                        </td>

                        <td width="100px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exametemp/novopacienteconsultaencaixe');">
                                    Encaixar Consulta
                                </a>
                            </div>
                            </td>-->
                            
                            </table>
                            <div id="accordion">
                                <h3><a href="#">Manter pacientes</a></h3>
                                <div>
                                    <table >
                                        <thead>
                                            <tr>
                                                <th class="tabela_title" ></th>
                                                <th class="tabela_title" >Prontuario</th>
                                                <th class="tabela_title" colspan="3">Nome / Telefone / Nome da Mae / CPF</th>
                                                <th class="tabela_title" colspan="3">Dt. Nascimento</th>
                                            </tr>
                                            <tr>
                                                <th class="tabela_title" colspan="9">

                                        <form method="get" action="<?php echo base_url() ?>cadastros/pacientes/pesquisar">
                                            <input type="text" name="prontuario" class="texto03" value="<?php echo @$_GET['prontuario']; ?>" />
                                            <input type="text" name="nome" class="texto08" value="<?php echo @$_GET['nome']; ?>" />
                                            <input type="text" name="nascimento" class="texto03" alt="date" value="<?php echo @$_GET['nascimento']; ?>" />
                                            <button type="submit" name="enviar">Pesquisar</button>
                                        </form>
                                        </th>
                                        </tr>
                                        <tr>
                                            <th class="tabela_header">Prontuario</th>
                                            <th class="tabela_header">Foto</th>
                                            <th class="tabela_header">Nome</th>
                                            <th class="tabela_header">Nome da Mãe</th>
                                            <th class="tabela_header" width="100px;">Nascimento</th>
                                            <th class="tabela_header" width="100px;">Telefone</th>
                                            <th class="tabela_header" colspan="4"  width="70px;"><center>A&ccedil;&otilde;es</center></th>

                                        </tr>
                                        </thead>
                                        <?php
                                        $url = $this->utilitario->build_query_params(current_url(), $_GET);
                                        $consulta = $this->paciente->listar($_GET);
                                        $total = $consulta->count_all_results();
                                        $limit = 10;
                                        isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                                        if ($total > 0) {
                                            ?>
                                            <tbody>
                                                <?php
                                                $lista = $this->paciente->listar($_GET)->orderby('nome')->limit($limit, $pagina)->get()->result();
                                                $estilo_linha = "tabela_content01";
                                                foreach ($lista as $item) {
                                                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                                    if ($item->celular == "") {
                                                        $telefone = $item->telefone;
                                                    } else {
                                                        $telefone = $item->celular;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->paciente_id; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="25px;"><img src="<?= base_url() ?>upload/webcam/pacientes/<?= $item->paciente_id ?>.jpg" alt="" width="25" height="25" /></td>
                                                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome_mae; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo substr($item->nascimento, 8, 2) . '/' . substr($item->nascimento, 5, 2) . '/' . substr($item->nascimento, 0, 4); ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo $telefone; ?></td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="50px;" ><div class="bt_link">
                                                                <a href="<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>">
                                                                    <b>Editar</b>
                                                                </a></div>
                                                        </td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                                                <a href="<?= base_url() ?>emergencia/filaacolhimento/novo/<?= $item->paciente_id ?>">
                                                                    <b>Op&ccedil;&otilde;es</b>
                                                                </a></div>
                                                        </td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="50px;" ><div class="bt_link">
                                                                <a href="<?= base_url() ?>ambulatorio/exametemp/carregarpacientetemp/<?= $item->paciente_id ?>">
                                                                    <b>Exames</b>
                                                                </a></div>
                                                        </td>
                                                        <td class="<?php echo $estilo_linha; ?>" width="50px;" ><div class="bt_link">
                                                                <a href="<?= base_url() ?>ambulatorio/exametemp/carregarpacienteconsultatemp/<?= $item->paciente_id ?>">
                                                                    <b>Consultas</b>
                                                                </a></div>
                                                        </td>
                        <!--                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                                                <a href="<?= base_url() ?>cadastros/pacientes/procedimentoautorizar/<?= $item->paciente_id ?>">
                                                                    <b>Autorizar</b>
                                                                </a></div>
                                                        </td>-->
                        <!--                                                                <td class="<?php echo $estilo_linha; ?>" width="50px;" ><div class="bt_link">
                                                                <a href="<?= base_url() ?>cadastros/pacientes/carregar/<?= $item->paciente_id ?>">
                                                                    <b>Autorizar</b>
                                                                </a></div>
                                                        </td>-->
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

            $(function() {
                $("#accordion").accordion();
            });

                            </script>