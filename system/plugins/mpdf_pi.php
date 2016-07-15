<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function pdf($html, $filename = null, $cabecalho = null, $rodape=null, $grupo ) {
    require_once("mpdf_lib/mpdf.php");
    
//    $mpdf = new mPDF('UTF-8', array (210,148));
//    if ($grupo == "US"){
//    $mpdf = new mPDF('UTF-8', array (210, 297));
//    }
    $mpdf = new mPDF('UTF-8', array (210, 297));
//    if ($grupo == "DENSITOMETRIA"){
//    $mpdf = new mPDF('UTF-8', array (210, 297));
//    }
//    $mpdf = new mPDF();
//    $mpdf = new mPDF('UTF-8', array (210, 297));
    //$mpdf->allow_charset_conversion=true;
    //$mpdf->charset_in='iso-8859-1';
    //Exibir a pagina inteira no browser
    //$mpdf->SetDisplayMode('fullpage');
    //Cabeçalho: Seta a data/hora completa de quando o PDF foi gerado + um texto no lado direito
//    $mpdf->SetHTMLHeader('Introduction','O'); 
    $mpdf->SetHTMLHeader($cabecalho);
    $mpdf->SetHTMLFooter($rodape);
//    $mpdf->DefHTMLHeaderByName("teste", $cabecalho);
//    $mpdf->SetHeader($cabecalho, $side='L');
    //Rodapé: Seta a data/hora completa de quando o PDF foi gerado + um texto no lado direito
    //$mpdf->SetFooter('{DATE j/m/Y H:i}|{PAGENO}/{nb}|Texto no rodapé');

    $mpdf->WriteHTML($html);

    // define um nome para o arquivo PDF
    if ($filename == null) {
        $filename = date("Y-m-d_his") . '_impressao.pdf';
    }

    $mpdf->Output($filename, 'I');
}

/* End of file mpdf_pdf_pi.php */
/* Location: ./system/plugins/mpdf_pi.php */