<?php
$head ="

<label>PREFEITURA MUNICIPAL DE FORTALEZA </label><br>
<label>INSTITUTO DR. JOS&Eacute; FROTA</label><br>
<label>CENTRO DE ASSIST&Ecirc;NCIA TOXICOL&Oacute;GICA - CEATOX-IJF</label><p>
<label>Tabela 1: Casos Registrados de Intoxica&ccedil;&atilde;o Humana e Solicita&ccedil;&otilde;es de Informa&ccedil;&otilde; por AGENTE T&Oacute;XICO</label>
<table border=\"1\">
                <thead>
                    <tr>
                        <th>AGENTE TOXICO</th>
                        <th>VITIMA<br> HUMANA</th>
                        <th>TOTAL</th>
                        <th>%</th>
                        <th>INFORMACOES</th>
                    </tr>
                </thead>
                <tbody>";
                    $body = "";
                        $i = 0;
                        foreach ($lista as $value) :
                        $i= $i + $value->total;
                        endforeach;
                        
                        $pertotal = 0;
                        foreach ($lista as $item):
                             $per = ($item->total/$i)*100;
                             $pertotal = $pertotal +$per;
                             $body = $body . "
                            <tr>
                                <td>" . utf8_decode($item->descricao) . " </td>
                                <td>" . $item->total . " </td>
                                <td>" . $item->total . " </td>
                                <td>" . substr($per,0,4) . " %</td>
                                <td> </td>
                                
                        </tr> ";
                                endforeach;
                           $body = $body .
                                "
                                <tr>
                                <td >TOTAL</td>
                                <td>" . $i . "</td>
                                <td>" . $i . "</td>
                                <td>" . $pertotal . "%</td>
                                <td> </td>
                                </tr>";
$footer = "</tbody></table>";
                                $html = $head . $body . $footer;?>

<?php
require_once(BASEPATH.'plugins/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('letter', 'landscape');
    $dompdf->render();
    $dompdf->stream("agente - vitima.pdf");
?>