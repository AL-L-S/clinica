<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>internacao/internacao/novoleito">
            Novo Leito
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Manter Leitos</a></h3>
        <div>
            <form method="get" action="<?php echo base_url() ?>internacao/internacao/pesquisarleito">
                <table>
                    <tr>
                        <th class="tabela_title" colspan="1">
                            Nome
                        </th>
                        <th class="tabela_title" colspan="1">
                            Unidade
                        </th>
                        <th class="tabela_title" colspan="1">
                            Enfermaria
                        </th>
                    </tr>
                    <tr>
                        <? $unidade = $this->unidade_m->listaunidadepacientes(); ?>
                        <th class="tabela_title" colspan="1">
                            <input type="text" name="nome" value="<?php echo @$_GET['nome']; ?>" />
                        </th>
                        <th class="tabela_title" colspan="1">
                            <select name="unidade" id="unidade" class="size2" >
                                <option value=''>TODOS</option>
                                <?php
                                foreach ($unidade as $item) {
                                    ?>
                                    <option <?=($item->internacao_unidade_id == @$_GET['unidade'])? 'selected' : '';?> value="<?php echo $item->internacao_unidade_id; ?>">
                                        <?php echo $item->nome; ?>
                                    </option>
                                    <?php
                                }
                                ?> 
                            </select>
                        </th>
                        <th class="tabela_title" colspan="1">
                            <select name="enfermaria" id="enfermaria" class="size2" >
                                <option value=''>TODOS</option>
                            
                            </select>
                        </th>
                        <th class="tabela_title" colspan="1">
                            <button type="submit" name="enviar">Pesquisar</button>
                        </th>
                        
                    </tr>
                </table> 
            </form>
            <table>
                
                </th>
                </tr>
                <tr>
                    <th class="tabela_header">Codigo</th>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Unidade</th>
                    <th class="tabela_header">Enfermaria</th>
                    <th class="tabela_header" width="30px;"><center></center></th>
                    <th class="tabela_header" colspan="3" width="30px;"><center></center></th>

                </tr>
                </thead>
                <?php
                $url = $this->utilitario->build_query_params(current_url(), $_GET);
                $consulta = $this->leito_m->listaleito($_GET);
                $total = $consulta->count_all_results();
                $limit = 10;
                isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        
                        $operador_id = $this->session->userdata('operador_id');
                        
                        $lista = $this->leito_m->listaleito($_GET)->orderby('iu.internacao_unidade_id,ie.internacao_enfermaria_id, il.nome')->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->internacao_leito_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->unidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?php echo $item->enfermaria; ?></td>
                                
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <a href="<?= base_url() ?>internacao/internacao/carregarleito/<?= $item->internacao_leito_id ?>"><center>
                                                <img border="0" title="Alterar registro" alt="Detalhes"
                                                    src="<?= base_url() ?>img/form/page_white_edit.png" />
                                            </center></a>
                                    </td>
                               
                                <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o Leito?');"
                                       href="<?=base_url()?>internacao/internacao/excluirleito/<?= $item->internacao_leito_id ?>">
                                        <center><img border="0" title="Excluir" alt="Excluir"
                                                    src="<?=  base_url()?>img/form/page_white_delete.png" /></center>
                                    </a>
                                    
                                </td>
                                <?if($operador_id == 1){?>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <a onclick="javascript: return confirm('Deseja realmente ativar o Leito?');"
                                        href="<?=base_url()?>internacao/internacao/ativarleito/<?= $item->internacao_leito_id ?>">
                                            Ativar Leito
                                        </a>
                                        
                                    </td>
                                <?}?>
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
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">

<?if(@$_GET['enfermaria'] > 0){
    $enfermaria = $_GET['enfermaria'];
}else{
    $enfermaria = 0;
}?>
<script type="text/javascript">
   
    $(function() {
        $( "#accordion" ).accordion();
    });

    $(function () {
        $('#unidade').change(function () {
//            alert('adsdasd');
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/enfermariaunidade', {id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    console.log(j);

                    for (var c = 0; c < j.length; c++) {

                        options += '<option value="' + j[c].id + '">' + j[c].value + '</option>';

                    }
                    $('#enfermaria').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('.carregando').show();
                options = '';
                $('#enfermaria').html(options).show();
            }
        });
    });


    if ($('#unidade').val()) {
        $('.carregando').show();
        $.getJSON('<?= base_url() ?>autocomplete/enfermariaunidade', {id: $('#unidade').val(), ajax: true}, function (j) {
            options = '<option value=""></option>';
            // console.log(j);
            // var selected = '';
            for (var c = 0; c < j.length; c++) {
                if(j[c].id == <?=$enfermaria?>){
                    options += '<option selected value="' + j[c].id + '">' + j[c].value + '</option>';
                }else{
                    options += '<option value="' + j[c].id + '">' + j[c].value + '</option>';
                }
               

            }
            $('#enfermaria').html(options).show();
            $('.carregando').hide();
        });
    } else {
        $('.carregando').show();
        options = '';
        $('#enfermaria').html(options).show();
    }
</script>