
<a><img src="<?= base_url() ?>img/logoijf.gif" width="200" height="20" alt="teste"></a>
<br>
<br>
<center><a>RELA&Ccedil;&Atilde;O DOS PACIENTES DA EMERG&Ecirc;NCIA</a></center>
<br>
<table border="1">

    <thead>
        <tr bgcolor ="gray">
            <th class="tabela_header"><font size="-1">N&deg;</font></th>
            <th class="tabela_header"><font size="-1">Protuario</font></th>
            <th class="tabela_header"><font size="-1">Paciente</font></th>
            <th class="tabela_header"><font size="-1">Procedimento decricao</font></th>

            <th class="tabela_header"><font size="-1">tempo</font></th>
            <th class="tabela_header"><font size="-1">Diretoria</font></th>
            <th class="tabela_header" width="400px;"><font size="-1">Status</font></th>
        </tr>
    </thead>

    <tbody>
        <?
        $total_leitos = 0;
        $linha = 1;
        $capital = 0;
        $capital2 = 0;
        $leitos_ocupados = 0;
        $somatempo = 0;
        foreach ($paciente as $item) :

            $ano_atual = substr($data, 0, 4);
            $mes_atual = substr($data, 6, 2);
            $dia_atual = substr($data, 4, 2);
            $internacao_ano = substr($item->diretoria_data, 0, 4);
            $internacao_mes = substr($item->diretoria_data, 5, 2);
            $internacao_dia = substr($item->diretoria_data, 8, 2);
            $tempo = ($ano_atual - $internacao_ano);
            $tempo = $tempo + ($mes_atual - $internacao_mes);
            $tempo = $tempo * 30;
            $tempo = $tempo + ($dia_atual - $internacao_dia);
        ?>
            <tr>
                <td ><font size="-1"><?= $linha ?></font></td>
                <td ><font size="-1"><?= $item->prontuario; ?></font></td>
                <td ><font size="-1"><?= $item->nome; ?></font></td>
                <td ><font size="-1"><?= $item->descricao_resumida; ?></font></td>
                <td ><font size="-1"><?= $tempo; ?></font></td>
                <td ><font size="-1"><?= utf8_decode($item->descricao); ?></font></td>
                <td ><font size="-1"><?= $item->status; ?><a href="<?= base_url() ?>cadastros/pacientes/carregarpacientecensostatus/<?= $item->prontuario; ?>/<?= $item->nome; ?>">
                            <img border="0" title="Alterar registro" alt="Detalhes"
                                 src="<?= base_url() ?>img/form/page_white_edit.png" />
                        </a></font></td>
            </tr>


        <?
            $linha++;
        endforeach;
        ?>

</table>
<br>
<br>
    <div class="bt_link_new">
        <a href="<?= base_url() ?>cadastros/pacientes/novademanda">
            Nova Demanda
        </a>
    </div>
<table border="1">

    <thead>
        <tr bgcolor ="gray">
            <th class="tabela_header" width="400px;"><font size="-1">Demandas pendentes</font></th>
            <th class="tabela_header" ><font size="-1">Diretoria</font></th>
            <th class="tabela_header"><font size="-1"></font></th>
        </tr>
    </thead>

    <tbody>
        <?
        foreach ($demanda as $item) :
        ?>
            <tr>
                <td ><font size="-1"><?= $item->demanda; ?></font></td>
                <td ><font size="-1"><?= utf8_decode($item->descricao); ?></font></td>
                <td ><font size="-1"><a onclick="javascript: return confirm('Deseja realmente fechar a demanda ');"
                                       href="<?=base_url()?>cadastros/pacientes/atualizardemanda/<?=$item->censo_demanda_diretoria; ?>">
                                        <img border="0" title="Fechar" alt="Fechar"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
                                    </a></font></td>
            </tr>


        <?
        endforeach;
        ?>

</table>
<br>
