<?php
$head ="

<label>PREFEITURA MUNICIPAL DE FORTALEZA </label><br>
<label>INSTITUTO DR. JOS&Eacute; FROTA</label><br>
<label>CENTRO DE ASSIST&Ecirc;NCIA TOXICOL&Oacute;GICA - CEATOX-IJF</label><p>
<label>Tabela 4: Casos Registrados de Intoxica&ccedil;&atilde;o Humana por AGENTE T&Oacute;XICO x SEXO</label>
<table border=\"1\">
                <thead>
                    <tr>
                        <th>AGENTE TOXICO</th>
                        <th>FEMININO</th>
                        <th>MASCULINO</th>
                        <th>TOTAL</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>";
                    $body = "";
                        $i = 0;
                        foreach ($lista as $value) :
                        $i= $i + $value->total;
                        endforeach;
                        $grupoid = "";
                        $pertotal = 0;
                        $subtotal = 0;
                        $totalf = 0;
                        $totalm = 0;
                        foreach ($lista as $item):
                             $per = ($item->total/$i)*100;
                             $pertotal = $pertotal +$per;
                             $sexoF = 0;
                             $sexoM = 0;
                              foreach ($lista as $value):
                                     if ($item->gruporesposta_id == $value->gruporesposta_id & $value->sexo == 'F'):
                                             $sexoF = $value->total;
                                     endif;
                                     if ($item->gruporesposta_id == $value->gruporesposta_id & $value->sexo == 'M'):
                                             $sexoM = $value->total;
                                     endif;
                               endforeach;
                               if ($item->gruporesposta_id != $grupoid ):
                                       $subtotal = $sexoF + $sexoM;
                                       $totalf = $totalf+ $sexoF;
                                       $totalm = $totalm+ $sexoM;
                                       $per = ($subtotal/$i)*100;
                             $body = $body . "
                            <tr>
                                <td>" . utf8_decode($item->descricao) . " </td>
                                <td>" . $sexoF . " </td>
                                <td>" . $sexoM . " </td>
                                <td>" .  $subtotal . "</td>
                                <td>" . substr($per,0,4) . " %</td>
                        </tr> ";

                         endif;
                         $grupoid = $item->gruporesposta_id;
                         
                                endforeach;
                                $perf = ($totalf/$i)*100;
                                $perm = ($totalm/$i)*100;
                           $body = $body .
                                "
                                <tr>
                                <td >TOTAL</td>
                                <td>" . $totalf . "</td>
                                <td>" . $totalm . "</td>
                                <td>" . $i . "</td>
                                <td>" . $pertotal . "%</td>
                                </tr>
                                <tr>
                                <td ></td>
                                <td>" . $perf . "%</td>
                                <td>" . $perm . "%</td>
                                <td>" . $pertotal . "%</td>
                                <td></td>
                                </tr>";
$footer = "</tbody></table>";
                                $html = $head . $body . $footer;?>

<?php
require_once(BASEPATH.'plugins/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('letter', 'landscape');
    $dompdf->render();
    $dompdf->stream("sexo - vitima.pdf");
?>