<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>cadastros/pacientes/novo">
            Novo Paciente
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Manter pacientes</a></h3>
        <div>
            <table >
                <thead>
                    <tr>
                        <th class="tabela_title" colspan="7">
                            Lista de pacientes
                <form method="get" action="<?php echo base_url() ?>cadastros/pacientes/pesquisar">
                    <input type="text" name="nome" class="texto08" value="<?php echo @$_GET['nome']; ?>" />
                    <button type="submit" name="enviar">Pesquisar</button>
                </form>
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Prontuario</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Nome da Mãe</th>
                    <th class="tabela_header" width="100px;">Nascimento</th>
                    <th class="tabela_header" width="100px;">Documento</th>
                    <th class="tabela_header" colspan="2"  width="70px;"><center>Detalhes</center></th>

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
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->paciente_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome_mae; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo substr($item->nascimento, 8, 2) . '/' . substr($item->nascimento, 5, 2) . '/' . substr($item->nascimento, 0, 4); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><?php echo $item->rg; ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="70px;" >
                                    <div class="bt_link">
                                        <a href="<?= base_url() ?>cadastros/pacientes/procedimentosubstituir/<?= $item->paciente_id ?>/<?= $paciente_temp_id;?>">
                                            Substituir
                                        </a>
                                    </div>
                                    
                                </td>
                               
                            </tr>
                        </tbody>
                        <?php
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="7">
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
        $( "#accordion" ).accordion();
    });

</script>