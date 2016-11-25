<div align =center><a><img src="<?= base_url() ?>img/logoijf.gif" width=300 height=40></a><a><img   src="<?= base_url() ?>img/logo.png" width=200 height=70 ></a></div>
<div class="clear"></div>
<h4 class="h4_title"><center>INSTITTUTO DR. JOS&Eacute; FROTA</center></h4>
<h4 class="h4_title"><center>SERVI&Ccedil;O DE ECOCARDIOGRAMA</center></h4>
<br>
<h4 class="h4_title"><center>ECOCARDIOGRAMA BIDIMENSIONAL COM COLOR DOPPLER</center></h4>
<? $i = 0; ?>

<table>
    <tbody>
        <tr><td width=75%">Nome: <?= $laudo['0']->nome; ?></td><td>Data: <?= substr($laudo['0']->data, 8, 2); ?>/<?= substr($laudo['0']->data, 5, 2); ?>/<?= substr($laudo['0']->data, 0, 4); ?></td></tr>
        <tr ><td width=75%">Peso: <?= $laudo['0']->peso; ?> Kg</td><td></td></tr>
        <tr ><td width=75%">Altura: <?= $laudo['0']->altura; ?> cm</td><td></td></tr>
    </tbody>
</table>
<h4><center>MEDIDAS ECOCARDIOGRAFICAS</center></h4>
<!-- Início da tabela de Observações gerais -->
<table border="1">

    <tbody>
        <tr  bgcolor ="gray" class="linha1"><td width="50%">&ensp;</td><td align="center" width="20%">Pacienete</td><td align="center">Par&acirc;metros normais</td></tr>

        <tr class="linha1"><td width="50%">Di&acirc;m. Diast&oacute;lico do VE</td><td align="center" width="20%"><?= $laudo['0']->diam_diastolico_ve; ?>mm</td><td align="center">36-56 mm</td></tr>
        <tr class="linha1"><td width="50%">Di&acirc;m. Sist&oacute;lico Final do VE</td><td align="center" width="20%"><?= $laudo['0']->diam_sisto_final_ve; ?>mm</td><td align="center">25-40 mm</td></tr>
        <tr class="linha1"><td width="50%">Espes. Diast&oacute;lica Septo</td><td align="center" width="20%"><?= $laudo['0']->espes_diastolico_septo; ?>mm</td><td align="center">07-11 mm</td></tr>
        <tr class="linha1"><td width="50%">Espes. Diast&oacute;lica PP</td><td align="center" width="20%"><?= $laudo['0']->espes_diastolico_pp; ?>mm</td><td align="center">07-11 mm</td></tr>
        <tr class="linha1"><td width="50%">Fra&ccedil;&atilde;o de Eje&ccedil;&atilde;o</td><td align="center" width="20%"><?= $laudo['0']->fracao_ejecao; ?>%</td><td align="center">>55%</td></tr>
        <tr class="linha1"><td width="50%">Perc. Encurt. Sist. VE</td><td align="center" width="20%"><?= $laudo['0']->perc_encurt_sist_ve; ?>%</td><td align="center">> 27 %</td></tr>
        <tr class="linha1"><td width="50%">Di&acirc;metro Aorta</td><td align="center" width="20%"><?= $laudo['0']->diametro_aorta; ?>mm</td><td align="center">< 37 mm</td></tr>
        <tr class="linha1"><td width="50%">Di&acirc;metro AE</td><td align="center" width="20%"><?= $laudo['0']->diametro_ae; ?>mm</td><td align="center">22 - 40 mm</td></tr>
        <tr class="linha1"><td width="50%">Diam Basal do VD</td><td align="center" width="20%"><?= $laudo['0']->diam_basal_vd; ?>mm</td><td align="center">< 42 %</td></tr>
    </tbody>
</table>
<?
if ($ObservacoesGerais != null):
    $i++;
?>
    <h4><?= $i ?>.OBSERVA&Ccedil;&Otilde;ES GERAIS</h4>
<? foreach ($ObservacoesGerais as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
        if ($VentEsquerdoDimensoesHipertrofia != null):
            $i++;
?>
            <h4><?= $i ?>.VENTR&Iacute;CULO ESQUERDO - DIMENS&Otilde;ES E HIPERTROFIA</h4>
<? foreach ($VentEsquerdoDimensoesHipertrofia as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>


<?
                if ($VentEsquerdoAnaliseSgmentar != null):
                    $i++;
?>
                    <h4><?= $i ?>.VENTR&Iacute;CULO ESQUERDO - AN&Aacute;LISE SEGMENTAR</h4>
<? foreach ($VentEsquerdoAnaliseSgmentar as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                        if ($VentEsquerdoFuncoes != null):
                            $i++;
?>
                            <h4><?= $i ?>.VENTR&Iacute;CULO ESQUERDO - FUN&Ccedil;&Otilde;ES</h4>
<? foreach ($VentEsquerdoFuncoes as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                if ($Aorta != null):
                                    $i++;
?>
                                    <h4><?= $i ?>.AORTA</h4>
<? foreach ($Aorta as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                        if ($ValvulaAortica != null):
                                            $i++;
?>
                                            <h4><?= $i ?>.V&Aacute;LVULA A&Oacute;RTICA</h4>
<? foreach ($ValvulaAortica as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                if ($AtrioEsquerdo != null):
                                                    $i++;
?>
                                                    <h4><?= $i ?>.&Aacute;TRIO ESQUERDO</h4>
<? foreach ($AtrioEsquerdo as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                        if ($Valvulamitral != null):
                                                            $i++;
?>
                                                            <h4><?= $i ?>.V&Aacute;LVULA MITRAL</h4>
<? foreach ($Valvulamitral as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                                if ($Ventriculoireito != null):
                                                                    $i++;
?>
                                                                    <h4><?= $i ?>.VENTR&Iacute;CULO DIREITO</h4>
<? foreach ($Ventriculoireito as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                                        if ($AtrioDireito != null):
                                                                            $i++;
?>
                                                                            <h4><?= $i ?>.&Aacute;TRIO DIREITO</h4>
<? foreach ($AtrioDireito as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                                                if ($ValvulaTricuspide != null):
                                                                                    $i++;
?>
                                                                                    <h4><?= $i ?>.V&Aacute;LVULA TRIC&Uacute;SPIDE</h4>
<? foreach ($ValvulaTricuspide as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                                                        if ($Valvulapulmonar != null):
                                                                                            $i++;
?>
                                                                                            <h4><?= $i ?>.V&Aacute;LVULA PULMONAR</h4>
<? foreach ($Valvulapulmonar as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                                                                if ($Pericardio != null):
                                                                                                    $i++;
?>
                                                                                                    <h4><?= $i ?>.PERIC&Aacute;RDIO</h4>
<? foreach ($Pericardio as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                                                                        if ($EstudoProteses != null):
                                                                                                            $i++;
?>
                                                                                                            <h4><?= $i ?>.ESTUDO PR&Oacute;TESES</h4>
<? foreach ($EstudoProteses as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                                                                                if ($AnaliseFluxoDoppler != null):
                                                                                                                    $i++;
?>
                                                                                                                    <h4><?= $i ?>.AN&Aacute;LISE DE FLUXO PELO DOPPLER</h4>
<? foreach ($AnaliseFluxoDoppler as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

<?
                                                                                                                        if ($AnaliseMapeamentoFluxoCores != null):
                                                                                                                            $i++;
?>
                                                                                                                            <h4><?= $i ?>.AN&Aacute;LISE PELO MAPEAMENTO DE FLUXO DE CORES</h4>
<? foreach ($AnaliseMapeamentoFluxoCores as $item) : ?>
<?= utf8_decode($item->descricao); ?><br>
<? endforeach; ?>
<? endif; ?>

    <? if ($Conclusao != null): ?>
                                                                                                                                <h3>&ensp;&ensp;&ensp;&ensp;&ensp;CONCLUS&Atilde;O</h3>
<? foreach ($Conclusao as $item) : ?>
                                                                                                                                    &ensp;&ensp;&ensp;&ensp;&ensp;<?= utf8_decode($item->descricao); ?><br>
    <? endforeach; ?>
<? endif; ?>
                                                                                                                                    <br>
                                                                                                                                    <br>
                                                                                                                                    <br>
                                                                                                                                    <label><center>_________________________________________</center></label>
                                                                                                                                    <label><center><?= utf8_decode($laudo['0']->medico); ?></center></label>
                                                                                                                                    <label><center><?= utf8_decode($laudo['0']->crm_cpf); ?></center></label>

                                                                                                                                    <table>
<? if ($arquivo_pasta != false):
                                                                                                                                            foreach ($arquivo_pasta as $value) : ?>
                                                                                                                                                <td><a><img src="<?= base_url() . "arquivos/eco/" . $laudo_id . "/" . $value ?>"></a></td>
<? endforeach;
                                                                                                                                            endif ?>
</table>



