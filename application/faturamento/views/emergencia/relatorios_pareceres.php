<?php
$head ="
    <div align = left><img src=img/logoijf.gif width=300 height=40><div><div align = right><img src=img/logo.png width=200 height=70 ></div>
    <hr heigh=100>
      <h3>Lista das solicita&ccedil;&atilde;o </h3>
      <table border=\"1\" >
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Especialidade</th>
                <th>Leito</th>
                   <th>descri&ccedil;&atilde;o</th>
                <th>Data/Hora da solicita&ccedil;&atilde;o</th>
                <th>Prioridade</th>
                
            </tr>
        </thead>
        <tbody>";
        $body = "";
        $i = 0;
        foreach ($lista as $item) :

            $body = $body . "
                 <tr>
                    <td>" . $item->nome . "</td>
                    <td>" . $item->especialidade . "</td>
                    <td>" . $item->leito . "</td>
                    <td>" . $item->detalhes. "</td>
                   <td>" . substr($item->datasolicitacao,8,2) . '/' . substr($item->datasolicitacao,5,2). '/' . substr($item->datasolicitacao,0,4). '-' .substr($item->horasolicitacao,0,2) .':'.substr($item->horasolicitacao,3,2)."</td>
                   <td>" . $item->prioridade. "</td>
                 </tr>";
        endforeach;
$footer = "</tbody></table>";
$html = $head . $body . $footer;

require_once(BASEPATH.'plugins/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);    
    $dompdf->set_paper('letter', 'landscape');
    $dompdf->render();
    $dompdf->stream($arqui);
   // $domper->stream("my_pdf.pdf", array("Attachment" => 0));


?>