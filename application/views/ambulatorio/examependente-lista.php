
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Atendimentos pendentes</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            ?>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title">Salas</th>
                        <th class="tabela_title">Nome</th>
                    </tr>
                    <tr>
                        
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarexamependente">
                    <th  class="tabela_title">
                    <select name="sala" id="sala" class="size2">
                        <option value="">TODAS</option>
                        <? foreach ($salas as $value) : ?>
                            <option value="<?= $value->exame_sala_id; ?>" <?
                        if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                        endif;
                            ?>><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                    </select>
                        </th>
                        <th colspan="3" class="tabela_title">
                    <input type="text" name="nome" class="texto10 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                    </th>
                    <th class="tabela_title">
                    <button type="submit" id="enviar">Pesquisar</button>
                    </th>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Agenda</th>
                    <th class="tabela_header">Data Pendência</th>
                    <th class="tabela_header">Sala</th>
                    <th class="tabela_header">Procedimento</th>
                    <th class="tabela_header" colspan="4"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;
                $lista = $this->exame->listarexamespendentes($_GET)->limit($limit, $pagina)->get()->result();
                $total = count($lista);

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data_pendente)); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->sala; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>


                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exame/voltarexamependente/<?= $item->exames_id ?>/<?= ($item->sala_id != '')?$item->sala_id:0 ?>/<?= $item->agenda_exames_id ?> ">
                                            Voltar
                                        </a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/exame/finalizarexamependente/<?= $item->exames_id ?>/<?= ($item->sala_id != '')?$item->sala_id:0 ?>/<?= $item->agenda_exames_id ?> ">
                                            Finalizar
                                        </a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                    <? // if($item->faturado == 't') {?>
                                        <div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/exame/lancarcreditoexamependente/<?= $item->exames_id ?>/<?= $item->sala_id ?>/<?= $item->agenda_exames_id ?> ">
                                                Credito
                                            </a>
                                        </div>
                                    <? // }
//                                    else { ?>
<!--                                        <div class="bt_link">
                                            <a href="<?= base_url() ?>ambulatorio/exame/carregarcancelamentoexamecredito/<?= $item->exames_id ?>/<?= $item->sala_id ?>/<?= $item->agenda_exames_id ?> ">
                                                Credito
                                            </a>
                                        </div>                                    -->
                                    <? // } ?>
                                </td>
                            </tr>

                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="8">
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
        $( "#accordion" ).accordion();
    });

</script>
