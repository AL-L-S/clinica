 <?php
$head ="
<h3>Prefeitura Municipal de Fortaleza </h3>
<h3>Instituto Dr. Jos&eacute; Frota </h3>
<h5>Per&iacute;odo: 01/01/2009 a 31/12/2009 </h5>
<h5>Casos Registrados de Intoxica&ccedil;&atilde; Humana e Solicita&ccedil;&otilde;es de Informa&ccedil;&otilde;es por AGENTE T&Oacute;XICO </h5>

<table border=\"1\" >

        <thead>
            <tr>
                <th width=\"100px;\">Agente T&oacute;xico</th>
                <th width=\"100px;\">TOTAL</th>
                <th width=\"100px;\">%</th>
            </tr>
        </thead>
                
        <tbody>";
            
            $body = "";

                       foreach ($lista as $item) :
                        $i = $item->codigo_agente_toxico;
                        $i = str_pad($i, 2,"0",STR_PAD_LEFT);

                   $totalparcial = $this->ceatoxrelatorio_m->listaParcialAgenteToxico($i);

                    $porcentagem = ($totalparcial * 100)/$this->ceatoxrelatorio_m->listaTotalAgenteToxico();
                    $porcentagem = number_format($porcentagem,2,".","");
$body = $body . "
                <tr>
              <td width=\"300px;\"> " . utf8_decode($item->descricao_agente_toxico) . "  </td>

              <td width=\"100px;\"> " .


                   $totalparcial . " </td>
              <td width=\"100px;\">" .

                    $porcentagem . "%" . "

              </td>
            </tr>";

            endforeach;
            //$totalgeral = $this->ceatoxrelatorio_m->listaTotalAgenteToxico();
           

              
                $footer = "  </tbody>
    </table> TOTAL GERAL
                <b>" .  $this->ceatoxrelatorio_m->listaTotalAgenteToxico() . " </b> ";

$html = $head . $body . $footer;
require_once(BASEPATH.'plugins/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('letter', 'landscape');
    $dompdf->render();
    $dompdf->stream("relatorio_agentetoxico.pdf");
?>


