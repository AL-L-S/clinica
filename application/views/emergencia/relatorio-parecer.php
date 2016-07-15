<p >

<?php
$teste = nl2br($lista[0]->descricao);
$data = substr($lista[0]->dataparecer,8,2) ."/". substr($lista[0]->dataparecer,5,2) ."/".substr($lista[0]->dataparecer,0,4);

?>
<div>
    <a><img src="<?= base_url() ?>img/logoijf.gif" width="300" height="40" alt="teste"></a><a><img align="right" src="<?= base_url() ?>img/logo.png" width="200" height="70" alt="teste"></a>
</div>
<br>
<br>
<div>
    <a><center>Parecer do Especialista</center></a>

</div>
<hr>
    

                <dl>
                    <dt>
                        <a>Paciente</a>
                    </dt>
                    <dd >
                        <p><?=utf8_decode($lista[0]->nome);?></p><br/>
                    </dd>
                    <dt>
                        <a>Descri&ccedil;&atilde;o</a>
                    </dt>
                    <dd >
                        <p><?= utf8_decode($teste);?></p><br/>
                    </dd>
                    <dt>
                        <a>Especialidade</a>
                    </dt>
                    <dd >
                        <p><?=utf8_decode($lista[0]->especialidadesolicitada);?></p><br/>
                    </dd>
                    <dt>
                        <a>Conduta / tempo estimado</a>
                    </dt>
                    <dd >
                        <p><?= utf8_decode($lista[0]->especialidade);?> / <?= utf8_decode($lista[0]->tempoconduta);?></p>
                    </dd>
                    <dt>
                        <a>Data/hora do parecer</a>
                    </dt>
                    <dd><p><?= $data;?> / <?=$lista[0]->horaparecer;?> </p><br/></dd>
                </dl>
<hr>
      
<?
//      $html = $head . $body;
//
//    require_once(BASEPATH.'plugins/dompdf/dompdf_config.inc.php');
//    $dompdf = new DOMPDF();
//    $dompdf->load_html($html);
//    $dompdf->set_paper('letter', 'landscape');
//    $dompdf->render();
//    $dompdf->stream("exemplo-01.pdf");
?>