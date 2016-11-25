    <?php
    //Utilitario::pmf_mensagem($message);
    


    //unset($message);
    ?>
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>giah/servidor/carregar/0">
            Novo Servidor
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Servidor</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                            Lista de Servidores
                            <form method="get" action="<?= base_url() ?>giah/servidor/pesquisar">
                                <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Matr&iacute;cula</th>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">CPF</th>
                        <th class="tabela_header">Lota&ccedil;&atilde;o</th>
                        <th class="tabela_header">Produtividade</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->servidor->listar($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    $competencia = $this->competencia->competenciaAtiva();
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                    <?php
                        $lista = $this->servidor->listar($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                     ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->matricula; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <?$cpfservidor= $item->cpf; ?>
                                <td class="<?php echo $estilo_linha; ?>"><?echo $cpfmodificado = substr($cpfservidor,0,3).".".substr($cpfservidor,3,3).".".substr($cpfservidor,6,3)."-".substr($cpfservidor,9,2)?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->lotacao; ?></td>


                            <?php
                                     if ( $item->situacao_id == "1") {
                                ?>
                                     <td class="<?php echo $estilo_linha; ?>">sim</td>
                                     
                                <?php
                                      }else{
                                ?>
                                      <td class="<?php echo $estilo_linha; ?>">n&atilde;o</td>
                                <?php
                                     }
                            ?>

                                <td class="<?php echo $estilo_linha; ?>" width="140px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o servidor <?=$item->nome; ?>');"
                                       href="<?=base_url()?>giah/servidor/excluirServidor/<?=$item->servidor_id;?>">
                                        <img border="0" title="Excluir" alt="Excluir"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
                                    </a>
                                    <a href="<?= base_url() ?>giah/servidor/carregar/<?= $item->servidor_id ?>">
                                        <img border="0" title="Detalhes" alt="Detalhes"
                                             src="<?= base_url() ?>img/form/page_white_edit.png" />
                                    </a>
                           <? if ($item->situacao_id == '1') : ?>
                                    <a href="<?= base_url() ?>giah/pensionista/pesquisar/<?= $item->servidor_id; ?>">
                                        <img border="0" title="Pensionistas" alt="Pensionistas"
                                             src="<?= base_url() ?>img/form/status_online.png" />
                                    </a>
                            
                                    <a href="<?= base_url() ?>giah/servidor/pesquisarteto/<?= $item->servidor_id; ?>">
                                        <img border="0" title="Cadastrar Teto" alt="Cadastrar Teto"
                                             src="<?= base_url() ?>img/form/coins.gif" />
                                    </a>
                            
                            <? if ($competencia != '000000') : ?>
                                <a href="<?= base_url() ?>giah/suplementar/pesquisar/<?= $item->servidor_id; ?>">
                                    <img border="0" title="Suplementar" alt="Suplementar"
                                         src="<?= base_url() ?>img/form/coins_add.png" />
                                </a>
                                <a href="<?= base_url() ?>giah/desconto/pesquisar/<?= $item->servidor_id; ?>">
                                    <img border="0" title="Informar descontos" alt="Informar descontos"
                                         src="<?= base_url() ?>img/form/coins_delete.png" />
                                </a>
                            <? endif; ?>
                            <? endif; ?>
                                    <a href="<?= base_url() ?>giah/veiculo/pesquisar/<?= $item->servidor_id; ?>">
                                        <img border="0" title="Cadastrar Veiculo" alt="Cadastrar Veiculo"
                                             src="<?= base_url() ?>img/form/carro.png" />
                                    </a>
                            </td>
                        </tr>

                        </tbody>
                        <?php
                                }
                            }
                        ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="6">
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
