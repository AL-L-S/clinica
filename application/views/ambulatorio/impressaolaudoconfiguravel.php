<style>
    /*    .teste {
            
    
        }*/

</style>
<? if($empresapermissao[0]->desativar_personalizacao_impressao != 't') {
    
    if (file_exists("./upload/operadortimbrado/" . $laudo['0']->medico_parecer1 . ".png")) {
        $caminho_background = base_url() . "upload/operadortimbrado/" . $laudo['0']->medico_parecer1 . ".png";
    } else {
        $caminho_background = base_url() . 'upload/timbrado/timbrado.png';
    }
    ?>
    <div class="teste" style="background-size: contain; height: 70%; width: 90%;background-image: url(<?=$caminho_background ?>);">


    <?
    if (file_exists("./upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".jpg")) {
        $assinatura = "<img   width='200px' height='100px' src='" . base_url() . "./upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".jpg'>";
    } else {
        $assinatura = "";
    }
}

//echo $assinatura;
@$corpo = $impressaolaudo[0]->texto;
$corpo = str_replace("_paciente_", $laudo['0']->paciente, $corpo);
$corpo = str_replace("_sexo_", $laudo['0']->sexo, $corpo);
$corpo = str_replace("_nascimento_", date("d/m/Y", strtotime($laudo['0']->nascimento)), $corpo);
$corpo = str_replace("_convenio_", $laudo['0']->convenio, $corpo);
$corpo = str_replace("_sala_", $laudo['0']->sala, $corpo);
$corpo = str_replace("_CPF_", $laudo['0']->cpf, $corpo);
$corpo = str_replace("_solicitante_", $laudo['0']->solicitante, $corpo);
$corpo = str_replace("_data_", substr($laudo['0']->data_cadastro, 8, 2) . '/' . substr($laudo['0']->data_cadastro, 5, 2) . '/' . substr($laudo['0']->data_cadastro, 0, 4), $corpo);
$corpo = str_replace("_medico_", $laudo['0']->medico, $corpo);
$corpo = str_replace("_revisor_", $laudo['0']->medicorevisor, $corpo);
$corpo = str_replace("_procedimento_", $laudo['0']->procedimento, $corpo);
$corpo = str_replace("_laudo_", $laudo['0']->texto, $corpo);
$corpo = str_replace("_nomedolaudo_", $laudo['0']->cabecalho, $corpo);
$corpo = str_replace("_queixa_", $laudo['0']->cabecalho, $corpo);
$corpo = str_replace("_peso_", $laudo['0']->peso, $corpo);
$corpo = str_replace("_altura_", $laudo['0']->altura, $corpo);
$corpo = str_replace("_cid1_", $laudo['0']->cid1, $corpo);
$corpo = str_replace("_cid2_", $laudo['0']->cid2, $corpo);
$corpo = str_replace("_assinatura_", $assinatura, $corpo);
echo $corpo;
?>

</div>
