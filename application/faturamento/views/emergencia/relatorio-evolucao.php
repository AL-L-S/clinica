<p >
    

<?php

$html =" 
                <dl>
                    <dt>
                        <h3>Idade</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->idade."</p><br/>
                    </dd>
                    <dt>
                        <h3>CID primario</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->cid_pri ."-". utf8_decode($lista[0]->no_cid)."</p><br/>
                    </dd>
                    <dt>
                        <h3>CID secundario 1</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->cid_sec1 ."</p><br/>
                    </dd>
                    <dt>
                        <h3>CID secundario 2</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->cid_sec2."</p><br/>
                    </dd>
                    <dt>
                        <h3>CID secundario 3</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->cid_sec3."</p><br/>
                    </dd>
                    <dt>
                        <h3>Plano terapeutico</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->plano_terapeutico_imediato."</p><br/>
                    </dd>
                    <dt>
                        <h3>Satura&ccedil;&atilde;o</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->saturacao."</p><br/>
                    </dd>
                    <dt>
                        <h3>FIO2</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->fio2."</p><br/>
                    </dd>
                    <dt>
                        <h3>Frequencia Respiratoria</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->frequencia_respiratoria."</p><br/>
                    </dd>
                    <dt>
                        <h3>Pa sist</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->pa_sist."</p><br/>
                    </dd>
                    <dt>
                        <h3>Pa diast</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->pa_diast."</p><br/>
                    </dd>
                    <dt>
                        <h3>Pulso</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->pulso."</p><br/>
                    </dd>
                    <dt>
                        <h3>Ramsay</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->ramsay."</p><br/>
                    </dd>
                    <dt>
                        <h3>Glasgow</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->glasgow."</p><br/>
                    </dd>
                    <dt>
                        <h3>Medico</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->nome."</p><br/>
                    </dd>
                    <dt>
                        <h3>Leito</h3>
                    </dt>
                    <dd >
                        <p>".$lista[0]->leito."</p><br/>
                    </dd>
                </dl>
      ";


    require_once(BASEPATH.'plugins/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('letter', 'landscape');
    $dompdf->render();
    $dompdf->stream("exemplo-01.pdf");
?>