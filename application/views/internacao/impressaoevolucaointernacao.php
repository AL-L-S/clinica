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
    ?>
    <style> 
    p {margin-top:0px;margin-bottom:0px;}
    table{
        border-collapse: collapse;
        width: 100%;
        padding: 0px;
        
    }
    .textoCentro{
        text-align: center;
        vertical-align: middle;
        height: 50px;
        width: 100px;
    }
    .semBorda{
        border: 0px;
    }
    .textoDireita{
        text-align: right;
    }
    .divTamanhoMaximo{
        height: 80%;
        /* display: flex; */
        /* padding-top: 40%; */
        /* border: 1px solid; */
    }
    
    </style>
    <p style='text-align:center;font-size: 15pt;font-weight: bold'> Evolução </p>
    <div class="divTamanhoMaximo">
        <div>
            <table border="1">
                <tr>
                    <td class="textoCentro">
                    <?=date("d/m/Y", strtotime($paciente[0]->data_cadastro))?>
                    </td>
                    <td>
                        <?=$texto?>
                    </td>
                </tr>
                <tr class="semBorda">
                
                    <td colspan="2" class="textoDireita">
                        Nome <br> 
                        Especialidade - CRM
                    </td>
                </tr>
                
            </table>
        </div>
    </div>
    <!-- <p style='text-align:left;'> $texto </p> -->
    

    <? if ($empresapermissoes[0]->desativar_personalizacao_impressao != 't' && $timbrado) { ?>
    </div>
<? } ?>

