
<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Listar Internações</a></h3>
        <div>
            <?
            $unidades = $this->unidade_m->listaunidadepacientes();
            $enfermarias = $this->enfermaria_m->listaenfermariarelatorio();
            $leitos = $this->leito_m->listaleitorelatorio();
            $medicos = $this->operador_m->listarmedicos();
            ?>
            <table>
                <form method="get" action="<?= base_url() ?>internacao/internacao/pesquisarinternacaolista">
                    <thead>
                        <tr>
                            <th colspan="1" class="tabela_title">
                                Nome
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
                            <th colspan="1" class="tabela_title">
                                Situação
                            </th>

                        </tr>
                        <tr>
                            <th colspan="1" class="tabela_title">

                                <input name="nome" type="text" class="texto05" value="<?= @$_GET['nome'] ?>">
                                <!--<button type="submit" id="enviar">Pesquisar</button>-->

                            </th>
                            <th colspan="1" class="tabela_title">
                                <select name="unidade" id="unidade" class="size2" >
                                    <option value=''>TODOS</option>
                                    <?php
                                    foreach ($unidades as $item) {
                                        ?>
                                        <option value="<?php echo $item->internacao_unidade_id; ?>" <?= (@$_GET['unidade'] == $item->internacao_unidade_id) ? 'selected' : '' ?>>

                                            <?php echo $item->nome; ?>
                                        </option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </th>
                            <th colspan="1" class="tabela_title">
                                <select name="enfermaria" id="enfermaria" class="size2" >
                                    <option value=''>TODOS</option>
                                    <?php
                                    foreach ($enfermarias as $item) {
                                        ?>
                                        <option value="<?php echo $item->internacao_enfermaria_id; ?>" <?= (@$_GET['enfermaria'] == $item->internacao_enfermaria_id) ? 'selected' : '' ?>>

                                            <?php echo $item->nome; ?>
                                        </option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </th>
                            <th colspan="1" class="tabela_title">
                                <select name="leito" id="leito" class="size2" >
                                    <option value=''>TODOS</option>
                                    <?php
                                    foreach ($leitos as $item) {
                                        ?>
                                        <option value="<?php echo $item->internacao_leito_id; ?>" <?= (@$_GET['leito'] == $item->internacao_leito_id) ? 'selected' : '' ?>>

                                            <?php echo $item->nome; ?>
                                        </option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </th>
                            <th colspan="1" class="tabela_title">
                                <select name="medico_responsavel" id="medico_responsavel" class="size2" >
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
                            <th colspan="1" class="tabela_title">
                                <select name="situacao" id="situacao" class="size2" >
                                    <option value="t" <?= (@$_GET['situacao'] == 't') ? 'selected' : '' ?>>
                                        INTERNADOS   

                                    </option>
                                    <option value="f" <?= (@$_GET['situacao'] == 'f') ? 'selected' : '' ?>>
                                        SAÍDA

                                    </option>

                                </select>
                            </th>


                            <th>
                                <button type="submit" id="enviar">Pesquisar</button>
                            </th>
                        </tr>
                        <tr>
                            <th class="tabela_header">Nome Paciente</th>
                            <th class="tabela_header">Leito</th>

                            <th class="tabela_header">Data Internação</th>
                            <!--<th class="tabela_header">Ligação</th>-->
                            <!--<th class="tabela_header">Aprovação</th>-->
                            <!--<th class="tabela_header">Raz&atilde;o social</th>-->
                            <th class="tabela_header" colspan="10"><center>Detalhes</center></th>
                    </tr>
                    </thead>
                </form>
            </table>
            <table>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->internacao_m->listarinternacaolista($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->internacao_m->listarinternacaolista($_GET)->limit($limit, $pagina)->orderby("i.data_internacao desc")->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>

                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->leito; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i:s", strtotime($item->data_internacao)); ?></td>

                                <td class="<?php echo $estilo_linha; ?>" style="width: 70px;"><div style="width: 70px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/carregarinternacao/<?= $item->internacao_id ?>/<?= $item->paciente_id ?>">Editar</a></div></td>    
                                <td class="<?php echo $estilo_linha; ?>" style="width: 110px;"><div style="width: 110px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/mostratransferirpaciente/<?= $item->paciente_id ?>">Transferir Leito</a></div></td>
                                <td class="<?php echo $estilo_linha; ?>" style="width: 70px;"><div style="width: 70px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/mostrapermutapaciente/<?= $item->paciente_id ?>">Permuta</a></div></td>
                                <td class="<?php echo $estilo_linha; ?>" style="width: 70px;"><div style="width: 70px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/mostrarnovasaidapaciente/<?= $item->internacao_id ?>">Saída</a></div></td>
                                <td class="<?php echo $estilo_linha; ?>"style="width: 90px;"><div style="width: 90px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/prescricaopaciente/<?= $item->internacao_id ?>">Prescrição</a></div></td> 
                                <td class="<?php echo $estilo_linha; ?>"  style="width: 120px;"><div style="width: 120px;" class="bt_link_new"><a href="<?= base_url() ?>centrocirurgico/centrocirurgico/novasolicitacaointernacao/<?= $item->internacao_id ?>/<?= $item->paciente_id ?>">Solicitar Cirurgia</a></div></td> 
                                <!--<td width="150px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/evolucaointernacao/<?= $item->internacao_id ?>">Evolucao</a></div></td>--> 
                                <td class="<?php echo $estilo_linha; ?>"style="width: 70px;"><div style="width: 70px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/listarevolucaointernacao/<?= $item->internacao_id ?>"> Evolução</a></div></td>
                                <td class="<?php echo $estilo_linha; ?>"style="width: 90px;"><div style="width: 90px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/listarimpressoes/<?= $item->internacao_id ?>"> Impressões</a></div></td>
                                <!--<td class="<?php echo $estilo_linha; ?>" style="width: 150px;"><div style="width: 150px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/termoresponsabilidade/<?= $item->internacao_id ?>">Termo de Respon[...]</a></div></td>-->  

                                <?
                                $perfil_id = $this->session->userdata('perfil_id');
                                $operador_id = $this->session->userdata('operador_id');
                                if ($perfil_id == 1):
                                    ?>

                                <? endif; ?>
                                <?
//                                $perfil_id = $this->session->userdata('perfil_id');
                                if ($operador_id == 1):
                                    ?>

                                <? endif; ?>
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
