<!--<style>
    /*    .teste {
            
    
        }*/

</style>-->

<?
if ($empresapermissoes[0]->desativar_personalizacao_impressao == 'f') {

    if (file_exists("./upload/operadortimbrado/" . $laudo['0']->medico_parecer1 . ".png")) {
        $caminho_background = base_url() . "upload/operadortimbrado/" . $laudo['0']->medico_parecer1 . ".png";
        $timbrado = true;
    } elseif (file_exists("./upload/upload/timbrado/timbrado.png")) {
        $caminho_background = base_url() . 'upload/timbrado/timbrado.png';
        $timbrado = true;
    } else {
        $timbrado = false;
    }
    ?>

    <? if ($timbrado) { ?>
        <div class="teste" style="background-size: contain; height: 70%; width: 100%;background-image: url(<?= $caminho_background ?>);">
        <? } ?>

        <?
        if (file_exists("./upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".jpg")) {
            $assinatura = "<img src='" . base_url() . "./upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".jpg'>";
        } else {
            $assinatura = "";
        }
    }

//echo $assinatura;
    @$corpo = $impressaolaudo[0]->texto;
    @$corpo = str_replace("<p", '<div', @$corpo);
    @$corpo = str_replace("</p>", '</div>', @$corpo);
//    echo($corpo);
//    die;

    $texto = $laudo['0']->texto;
//    $texto = str_replace("<p", '<div', $texto);
//    $texto = str_replace("</p>", '</div><br>', $texto);
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
    $corpo = str_replace("_laudo_", $texto, $corpo);
    $corpo = str_replace("_nomedolaudo_", $laudo['0']->cabecalho, $corpo);
    $corpo = str_replace("_queixa_", $laudo['0']->cabecalho, $corpo);
    $corpo = str_replace("_peso_", $laudo['0']->peso, $corpo);
    $corpo = str_replace("_altura_", $laudo['0']->altura, $corpo);
    $corpo = str_replace("_cid1_", $laudo['0']->cid1, $corpo);
    $corpo = str_replace("_cid2_", $laudo['0']->cid2, $corpo);
    $corpo = str_replace("_guia_", $laudo[0]->guia_id, $corpo);
    $operador_id = $this->session->userdata('operador_id');
    $operador_atual = $this->operador_m->operadoratualsistema($operador_id);
    @$corpo = str_replace("_usuario_logado_", @$operador_atual[0]->nome, $corpo);
    $corpo = str_replace("_prontuario_", $laudo[0]->paciente_id, $corpo);
    $corpo = str_replace("_telefone1_", $laudo[0]->telefone, $corpo);
    $corpo = str_replace("_telefone2_", $laudo[0]->celular, $corpo);
    $corpo = str_replace("_whatsapp_", $laudo[0]->whatsapp, $corpo);
//    if($laudo['0']->situacao == "FINALIZADO"){
    $corpo = str_replace("_assinatura_", $assinatura, $corpo);
//    }else{
//        $corpo = str_replace("_assinatura_", '', $corpo);
//    }

    echo "<style> p {margin-top:0px;margin-bottom:0px;}</style>";
    echo $corpo;
//    var_dump($corpo);
//    die;
    ?>
    <? if ($empresapermissoes[0]->desativar_personalizacao_impressao != 't' && $timbrado) { ?>
    </div>
<? } ?>

