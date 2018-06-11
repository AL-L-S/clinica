
<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Listar Internações</a></h3>
        <div>

            <table>
                <form method="get" action="<?= base_url() ?>internacao/internacao/pesquisarinternacaolista">
                    <thead>
                        <tr>
                            <th colspan="1" class="tabela_title">
                                Nome
                            </th>

                        </tr>
                        <tr>
                            <th colspan="1" class="tabela_title">

                                <input name="nome" type="text" class="texto05" value="<?= @$_GET['nome'] ?>">
                                <!--<button type="submit" id="enviar">Pesquisar</button>-->

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
                                <td class="<?php echo $estilo_linha; ?>" style="width: 150px;"><div style="width: 150px;" class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/termoresponsabilidade/<?= $item->internacao_id ?>">Termo de Respon[...]</a></div></td>  
                               
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
