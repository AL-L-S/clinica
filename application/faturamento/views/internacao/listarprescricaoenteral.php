<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Prescri&ccedil;&atilde;o</h3>

</table>
<? if (count($prescricao) > 0) { ?>
    <br>
    <br>
    <hr/>
    <table>
        <tr>
            <th class="tabela_header">
                Prescricao
            </th>
            <th class="tabela_header">
                Etapas
            </th>
            <th class="tabela_header">
                Produto
            </th>
            <th class="tabela_header">
                Volume
            </th>
            <th class="tabela_header">
                Vazão
            </th>
            <th class="tabela_header">
                Equipo
            </th>
            <th class="tabela_header">&nbsp;</th>
        </tr>
        <tr>
            <?
            $etapas = "";
            $internacao_precricao_id = "";
            $estilo_linha = "tabela_content01";
            $teste = 0;
            foreach ($prescricao as $item) {
                $i = $item->etapas;

                if ($item->internacao_precricao_id != $internacao_precricao_id) {
                    $data = substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2)  . '/' . substr($item->data, 0, 4);
                    $internacao_precricao_id = $item->internacao_precricao_id;
                    foreach ($prescricaoequipo as $value) {
                        if($value->internacao_precricao_id == $item->internacao_precricao_id){
                        $equipo = $value->nome;
                        }
                    }
                } else {
                    $data = '&nbsp;';
                    $equipo = '&nbsp;';
                }
                if ($item->internacao_precricao_etapa_id == $etapas) {
                    $i = '&nbsp;';
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content01" : $estilo_linha = "tabela_content02";
                } else {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                }
                ?>
            <tr>
                <td class="<?php echo $estilo_linha; ?>"><?= $data; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $i; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $item->volume; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $item->vasao; ?></td>
                <td class="<?php echo $estilo_linha; ?>"><?= $equipo; ?></td>
            </tr>
            <?
            $i++;
            $etapas = $item->internacao_precricao_etapa_id;
        }
        ?>
        </tr>
    <? } ?>
</table>

</div> 
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

</script>