<meta charset="utf-8">
<style>
    /*    .teste {
            
    
        }*/

</style>

<?
if ($empresapermissoes[0]->desativar_personalizacao_impressao != 't') {

    if (file_exists("./upload/operadortimbrado/" . $internacao['0']->medico_id . ".png")) {
        $caminho_background = base_url() . "upload/operadortimbrado/" . $internacao['0']->medico_id . ".png";
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
        if (file_exists("./upload/1ASSINATURAS/" . $internacao['0']->medico_id . ".jpg")) {
            $assinatura = "<img   width='200px' height='100px' src='" . base_url() . "./upload/1ASSINATURAS/" . $internacao['0']->medico_id . ".jpg'>";
        } else {
            $assinatura = "";
        }
    }

//echo $assinatura;
    @$corpo = $impressaointernacao[0]->texto;
//    @$corpo = str_replace("<p", '<div', @$corpo);
//    @$corpo = str_replace("</p>", '</div><br>', @$corpo);
//    var_dump($impressaointernacao);
//    die;
    $nascimento = new DateTime($internacao[0]->nascimento);
    $atual = new DateTime(date("Y-m-d"));

    // Resgata diferença entre as datas
    $dateInterval = $nascimento->diff($atual);

    $data_inicio = new DateTime($internacao[0]->data_internacao);
    $data_fim = new DateTime(date("Y-m-d H:i:s"));

    // Resgata diferença entre as datas
    $dateInterval2 = $data_inicio->diff($data_fim);
    $dias_int = $dateInterval2->days . " Dias";
    $idade = $dateInterval->y . " Anos";
//    $texto = $internacao['0']->texto;
//    $texto = str_replace("<p", '<div', $texto);
//    $texto = str_replace("</p>", '</div><br>', $texto);
    $codigoUF = $this->utilitario->codigo_uf($internacao[0]->codigo_ibge);
    
    $dia_atual = date("d");
    $mes_atual = date("m");
    $ano_atual = date("Y");
    $mes_atual_nome = $this->utilitario->retornarNomeMes($mes_atual);
    $data_atual = date("d/m/Y");
    $corpo = str_replace("_paciente_", $internacao['0']->paciente, $corpo);
    $corpo = str_replace("_sexo_", $internacao['0']->sexo, $corpo);
    $corpo = str_replace("_nascimento_", date("d/m/Y", strtotime($internacao['0']->nascimento)), $corpo);
    $corpo = str_replace("_convenio_", $internacao['0']->convenio, $corpo);
    $corpo = str_replace("_municipio_", $internacao['0']->municipio, $corpo);
    $corpo = str_replace("_idade_", $idade, $corpo);
    $corpo = str_replace("_dias_internacao_", $dias_int, $corpo);
    $corpo = str_replace("_dia_atual_", $dia_atual, $corpo);
    $corpo = str_replace("_mes_atual_", $mes_atual_nome, $corpo);
    $corpo = str_replace("_ano_atual_", $ano_atual, $corpo);
    $corpo = str_replace("_data_atual_", $data_atual, $corpo);
    $corpo = str_replace("_CRM_", $internacao['0']->conselho, $corpo);
    $corpo = str_replace("_UF_", $codigoUF, $corpo);
    $corpo = str_replace("_RG_", $internacao['0']->rg, $corpo);
    $corpo = str_replace("_CPF_", $internacao['0']->cpf, $corpo);
//    $corpo = str_replace("_solicitante_", $internacao['0']->solicitante, $corpo);
    $corpo = str_replace("_data_internacao_", substr($internacao['0']->data_internacao, 8, 2) . '/' . substr($internacao['0']->data_internacao, 5, 2) . '/' . substr($internacao['0']->data_internacao, 0, 4), $corpo);
    $corpo = str_replace("_medico_responsavel_", $internacao['0']->medico, $corpo);
    $corpo = str_replace("_leito_", $internacao['0']->leito_nome, $corpo);
    $corpo = str_replace("_enfermaria_", $internacao['0']->enfermaria, $corpo);
    $corpo = str_replace("_unidade_", $internacao['0']->unidade, $corpo);
//    $corpo = str_replace("_revisor_", $internacao['0']->medicorevisor, $corpo);
    $corpo = str_replace("_procedimento_", $internacao['0']->procedimento, $corpo);
//    $corpo = str_replace("_internacao_", $texto, $corpo);
//    $corpo = str_replace("_nomedointernacao_", $internacao['0']->cabecalho, $corpo);
//    $corpo = str_replace("_queixa_", $internacao['0']->cabecalho, $corpo);
//    $corpo = str_replace("_peso_", $internacao['0']->peso, $corpo);
//    $corpo = str_replace("_altura_", $internacao['0']->altura, $corpo);
    $corpo = str_replace("_CID1_", $internacao['0']->codcid, $corpo);
    $corpo = str_replace("_CID2_", $internacao['0']->codcid2, $corpo);
    $corpo = str_replace("_assinatura_", $assinatura, $corpo);
    echo $corpo;
//    var_dump($corpo);
//    die;
    ?>
    <? if ($empresapermissoes[0]->desativar_personalizacao_impressao != 't' && $timbrado) { ?>
    </div>
<? } ?>

