<?
//var_dump($co_cid); die;
//var_dump($co_cid2); die;
//$assinatura;
$corpo = $laudo[0]->texto;
$corpo = str_replace("_paciente_", $laudo['0']->paciente, $corpo);
$corpo = str_replace("_sexo_", $laudo['0']->sexo, $corpo);
$corpo = str_replace("_nascimento_",date("d/m/Y",strtotime($laudo['0']->nascimento)), $corpo);
$corpo = str_replace("_convenio_", $laudo['0']->convenio, $corpo);
//$corpo = str_replace("_sala_", $laudo['0']->sala, $corpo);
$corpo = str_replace("_CPF_", $laudo['0']->cpf, $corpo);
$corpo = str_replace("_solicitante_", $laudo['0']->solicitante, $corpo);
$corpo = str_replace("_data_", date( "d/m/Y",strtotime($laudo['0']->data)), $corpo);
$corpo = str_replace("_medico_", $laudo['0']->medico, $corpo);
$corpo = str_replace("_revisor_", $laudo['0']->medicorevisor, $corpo);
$corpo = str_replace("_procedimento_", $laudo['0']->procedimento, $corpo);
$corpo = str_replace("_laudo_", $laudo['0']->texto, $corpo);
$corpo = str_replace("_nomedolaudo_", $laudo['0']->cabecalho, $corpo);
$corpo = str_replace("_queixa_", $laudo['0']->cabecalho, $corpo);
$corpo = str_replace("_peso_", $laudo['0']->peso, $corpo);
$corpo = str_replace("_altura_", $laudo['0']->altura, $corpo);
if($imprimircid == 't'){
$corpo = str_replace("_cid1_", @$cid['0']->co_cid . "-" . @$cid['0']->no_cid, $corpo);
$corpo = str_replace("_cid2_", @$cid2['0']->co_cid . "-" . @$cid2['0']->no_cid, $corpo);
}else{
   $corpo = str_replace("_cid1_", "", $corpo);  
   $corpo = str_replace("_cid2_", "", $corpo);  
}
$corpo = str_replace("_assinatura_", $assinatura, $corpo);
if($imprimircid == 't'){
$corpo = $corpo . "<br><br><br> Resolução CFM 1.658/2002 - Art. 5º - Os médicos somente podem fornecer atestados com o diagnóstico codificado ou não quando por justa causa, exercício de dever legal, solicitação do próprio paciente ou de seu representante legal.";
}
echo $corpo;
?>
