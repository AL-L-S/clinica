
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td width="70">
                <div class="bt_link_new">
                    <a href="#">
                        Guia Ambualtorial
                    </a>
                </div>
            </td>
            <td width="20"></td>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/exame/carregarguiacirurgica">
                        Guia Cirurgica
                    </a>
                </div>
            </td>
            <td width="20"></td>
        </tr>
    </table>

    <div id="accordion">
        <h3 class="singular"><a href="#">Faturamento Manual</a></h3>
        <div>

            <form method="get" action="<?php echo base_url() ?>ambulatorio/exame/faturamentomanual">
                <table >
                    <thead>
                        <tr>
                            <th class="tabela_title" >Guia</th>
                            <th class="tabela_title" >Paciente</th>
                            <th class="tabela_title" >Tipo</th>
                            <th class="tabela_title" ></th>
                        </tr>
                        <tr>
                            <th class="tabela_title" colspan="">
                                <input type="text" name="guia" class="texto03" value="<?php echo @$_GET['guia']; ?>" />
                            </th>
                            <th colspan="1" class="tabela_title">
                                <input type="text" name="nome" class="texto05" style="text-transform: uppercase;" value="<?php echo @$_GET['nome']; ?>" />

                            </th>
                            <th class="tabela_title" colspan="">

                                <select name="tipo" id="tipo" class="texto03">
                                    <option value="">SELECIONE</option>
                                    <option value="CIRURGICO" <?if (@$_GET['tipo'] == "CIRURGICO"):echo 'selected';endif;?>>CIRURGICO</option>
                                    <option value="CONSULTA" <?if (@$_GET['tipo'] == "CONSULTA"):echo 'selected';endif;?>>CONSULTA</option>
                                    <option value="EXAME" <?if (@$_GET['tipo'] == "EXAME"):echo 'selected';endif;?>>EXAME</option>
                                    <option value="ESPECIALIDADE" <?if (@$_GET['tipo'] == "ESPECIALIDADE"):echo 'selected';endif;?>>ESPECIALIDADE</option>
                                </select> 
                            </th>
                            <th class="tabela_title" colspan="">
                                <button type="submit" name="enviar">Pesquisar</button>
                            </th>
                        </tr>
                    </thead>
                </table>
            </form>

            <table >
                <thead>
                    <tr>
                        <th class="tabela_header">Guia</th>
                        <th class="tabela_header">Paciente</th>
                        <th class="tabela_header">Convenio</th>
                        <th class="tabela_header">Tipo</th>
                        <th class="tabela_header" colspan="4"  width="70px;"><center>Detalhes</center></th>

                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->guia->listarguias($_GET);
                $total = $consulta->count_all_results();
                $limit = 20;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $lista = $this->guia->listarguias($_GET)->orderby('ambulatorio_guia_id')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->ambulatorio_guia_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->paciente; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->tipo; ?></td>
                                <?if($item->tipo == 'CIRURGICO'):?>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;" ><div class="bt_link_new">
                                        <a href="<?= base_url() ?>ambulatorio/exame/guiacirurgicaitens/<?= $item->ambulatorio_guia_id ?>">
                                            <b>Prcedimentos</b>
                                        </a></div>
                                </td>
                                <?  endif;?>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link_new">
                                        <a href="<?= base_url() ?>emergencia/filaacolhimento/novo/<?= $item->ambulatorio_guia_id ?>">
                                            <b>Op&ccedil;&otilde;es</b>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $(document).ready(function () {

        $(function () {
            $("#accordion").accordion();
        });

    });
</script>
