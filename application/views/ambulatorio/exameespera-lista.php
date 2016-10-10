
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Sala de Espera</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $medicos = $this->operador_m->listarmedicos();
            $situacaocaixa = $this->exame->listarcaixaempresa();
//            var_dump($situacaocaixa);
//            die;
            ?>
            <table>
                <thead>
                    <tr>
                        <th colspan="2" class="tabela_title">Salas</th>
                        <th class="tabela_title">Medico</th>
                        <th class="tabela_title">Tipo</th>
                        <th class="tabela_title">Nome</th>
                    </tr>
                    <tr>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarsalasespera">
                    <th colspan="2" class="tabela_title">
                        <select name="sala" id="sala" class="size1">
                            <option value="">TODAS</option>
                            <? foreach ($salas as $value) : ?>
                                <option value="<?= $value->exame_sala_id; ?>" <?
                                if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </th>
                    <th class="tabela_title">
                        <select name="medico" id="medico" class="size1">
                            <option value=""></option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" <?
                                if (@$_GET['medico'] == $value->operador_id):echo 'selected';
                                endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </th>
                    <th class="tabela_title">
                        <select name="tipo" id="tipo" class="size1" >
                            <option value='' ></option>
                            <option value='EXAME' <?
                            if (@$_GET['tipo'] == 'EXAME'):echo 'selected';
                            endif;
                            ?> >EXAME</option>
                            <option value='CONSULTA'  <?
                            if (@$_GET['tipo'] == 'CONSULTA'):echo 'selected';
                            endif;
                            ?>>CONSULTA</option>
                        </select>
                    </th>
                    <th colspan="3" class="tabela_title">
                        <input type="text" name="nome" class="texto07" value="<?php echo @$_GET['nome']; ?>" />
                    </th>
                    <th class="tabela_title">
                        <button type="submit" id="enviar">Pesquisar</button>
                    </th>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Ordem</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Tempo</th>
                    <th class="tabela_header">Agenda</th>
                    <th class="tabela_header">Sala</th>
                    <th class="tabela_header">Procedimento</th>              
                    <th class="tabela_header">Obs.</th>
                    <th class="tabela_header" colspan="4"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->exame->listarexameagendaconfirmada($_GET);
                $total = $consulta->count_all_results();
                $limit = 100;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $perfil_id = $this->session->userdata('perfil_id');
                        $lista = $this->exame->listarexameagendaconfirmada2($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $dataFuturo = date("Y-m-d H:i:s");                           
                            $dataAtual = $item->data_autorizacao;
                            $date_time = new DateTime($dataAtual);
                            $diff = $date_time->diff(new DateTime($dataFuturo));                         
                            $teste = $diff->format('%H:%I:%S');                          
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->ordenador; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/examepacientedetalhes/<?= $item->paciente_id; ?>/<?= $item->procedimento_tuss_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id; ?>', 'toolbar=no,Location=no,menubar=no,width=500,height=200');"><?= $item->paciente; ?></a></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $teste; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><? echo $item->sala; if(isset($item->numero_sessao)){ echo "/" . $item->numero_sessao; }?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                
                                <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->observacoes; ?></b></td>
                                <? if ($situacaocaixa[0]->caixa == 't') { ?>
                                    <? if ($item->dinheiro == 'f') { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/examesala/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id ; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Enviar
                                                </a></div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>ambulatorio/exame/examesalatodos/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id ?>">Todos

                                                </a></div>
                                        </td>
                                    <? } elseif ($item->faturado == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/examesala/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id ; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Enviar

                                                </a></div>
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a href="<?= base_url() ?>ambulatorio/exame/examesalatodos/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id ?>">Todos

                                                </a></div>
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                        </td>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;">
                                        </td>
                                    <? } ?>
                                <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                                <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/examesala/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id ; ?> ', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">Enviar
                                                </a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/exame/examesalatodos/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>/<?= $item->guia_id ?>/<?= $item->agenda_exames_id ?>">Todos

                                            </a></div>
                                    </td>
                                <? } ?>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exame/esperacancelamento/<?= $item->agenda_exames_id ?>/<?= $item->paciente_id ?>/<?= $item->procedimento_tuss_id ?>">Cancelar

                                        </a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/observacao/<?= $item->agenda_exames_id ?>/<?= $item->paciente; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=230');">Obs.
                                        </a></div>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="11">
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

                                            $(function() {
                                                $("#accordion").accordion();
                                            });

</script>
