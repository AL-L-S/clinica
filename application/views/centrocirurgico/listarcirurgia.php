<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Lista de Cirurgias</a></h3>
        <div>
            <table style="margin-bottom: 5pt;">
                <thead>
                    <form method="get" action="<?php echo base_url() ?>centrocirurgico/centrocirurgico/pesquisarcirurgia">   
                    <tr>
                        <th class="tabela_title"><label for="nome">Nome</label></th>
                        <th class="tabela_title"><label for="txtdata_cirurgia">Data</label></th>
                        <th class="tabela_title"></th>
                    </tr>
                    <tr>
                        <th><input type="text" name="nome" id="nome"/></th>
                        <th><input type="text" name="txtdata_cirurgia" id="txtdata_cirurgia" alt="date"/></th>
                        <th><button type="submit" name="enviar">Pesquisar</button></th>
                    </tr>
                    </form>
                </thead>
            </table>
            <table>
                <thead>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Situação</th>
                    <th class="tabela_header">Data Solicitação</th>
                    <th class="tabela_header">Data Prevista</th>
                    <th style="text-align: center;" colspan="4" class="tabela_header">Detalhes</th>

                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->centrocirurgico_m->listarcirurgia($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->centrocirurgico_m->listarcirurgia($_GET)->orderby('p.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            $situacao = '';
                            if($item->situacao == 'FATURAMENTO_PENDENTE'){
                              $situacao = "<span style='color:red'>Faturamento</span>";  
                            }elseif($item->situacao == 'AGUARDANDO'){
                                $situacao = "<span style='color:#ff8400'>Aguardando</span>";   
                            }elseif($item->situacao == 'REALIZADA'){
                                $situacao = "<span style='color:green'>Realizada</span>";
                            }
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td  class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>                              
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $situacao; ?></td>                              
                                <td class="<?php echo $estilo_linha; ?>"><?php echo date("d/m/Y H:i:s",strtotime($item->data_cadastro)); ?></td>                              
                                <td class="<?php echo $estilo_linha; ?>">
                                                            <?$ano= substr($item->data_prevista,0,4);?>
                                                            <?$mes= substr($item->data_prevista,5,2);?>
                                                            <?$dia= substr($item->data_prevista,8,2);?>
                                                            <?$hora= substr($item->data_prevista,10,10);?>
                                                            <?$datafinal= $dia . '/' . $mes . '/' . $ano . $hora; ?>
                                    
                                                            <?php echo$datafinal?></strong></td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                        <a  href="<?= base_url() ?>centrocirurgico/centrocirurgico/faturarprocedimentos/<?= $item->solicitacao_cirurgia_id; ?>/<?= $item->guia_id; ?>" target="_blank">Faturar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                            <a  href="<?= base_url() ?>centrocirurgico/centrocirurgico/editarcirurgia/<?= $item->solicitacao_cirurgia_id; ?>">Confirmar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                            <a  href="<?= base_url() ?>centrocirurgico/centrocirurgico/editarcirurgia/<?= $item->solicitacao_cirurgia_id; ?>">Editar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="30px;"><div class="bt_link">
                                            <a  href="<?= base_url() ?>centrocirurgico/centrocirurgico/impressaoorcamento/<?= $item->solicitacao_cirurgia_id; ?>">Imprimir</a></div>
                                </td>
                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="9">
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
        $("#accordion").accordion();
    });

    $(function () {
        $("#txtdata_cirurgia").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

</script>
