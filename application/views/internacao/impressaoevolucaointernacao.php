<!--<style>
    /*    .teste {
            
    
        }*/

</style>-->

<?
if ($empresapermissoes[0]->desativar_personalizacao_impressao == 'f') {

    if (file_exists("./upload/operadortimbrado/" . $paciente['0']->operador_cadastro . ".png")) {
        $caminho_background = base_url() . "upload/operadortimbrado/" . $paciente['0']->operador_cadastro . ".png";
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
     
    }

    $texto = @$paciente[0]->diagnostico;
    echo "<style> p {margin-top:0px;margin-bottom:0px;}</style>";
    echo "<p style='text-align:center;font-size: 15pt;font-weight: bold'> Evolução </p>";
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<p style='text-align:left;'> $texto </p>";
    // echo $corpo;
//    var_dump($corpo);
//    die;
    ?>
    <? if ($empresapermissoes[0]->desativar_personalizacao_impressao != 't' && $timbrado) { ?>
    </div>
<? } ?>

