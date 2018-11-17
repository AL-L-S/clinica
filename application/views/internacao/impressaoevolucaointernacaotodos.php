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

    // $texto = @$paciente[0]->diagnostico;
    ?>
    <style> 
    p {margin-top:0px;margin-bottom:0px;}
    table{
        border-collapse: collapse;
        width: 100%;
        padding: 0px;
        font-size: 9pt;
        
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
    <?
    $teste = '';
    // 5000- Caracteres Máximo
    // 40 Linhas
    // 100 Caracteres Horizontais
    // Divide a quantidade de caracteres na evolução por 100 e depois aplica o Ceil pra poder ter 
    // o numero de linhas arredondadas pra cima
    ?>
    <?
    //for($i = 0; $i < 2500; $i++){
    //    $teste = $teste . 'A ';
    //}
    ?>
    <p style='text-align:center;font-size: 15pt;font-weight: bold'> Evolução </p>
    <br>
    <!-- <div class="divTamanhoMaximo"> -->
        <!-- <div> -->
            <?
            $maxLinhas = 40;
            $maxCharLinha = 100;
            $contadorLinhas = 0;
            $contadorChar = 0;
            $linhasAdicionais = 6;
            ?>
            <?foreach ($paciente as $key => $item) {?>
                
                <table border="1">
                    <tr>
                        <td class="textoCentro">
                         <?=date("d/m/Y", strtotime($item->data_cadastro))?>
                        </td>
                        <td>
                            <?=$item->diagnostico?>
                        </td>
                    </tr>
                    <tr class="semBorda">
                    
                        <td colspan="2" class="textoDireita">
                            <?=$item->medico?> <br> 
                            <?=$item->especialidade?> - <?=$item->conselho?>
                        </td>
                    </tr>
                    
                </table>
                <br>
                <?
                    $contadorChar = strlen($item->diagnostico);
                    if($contadorChar > $maxCharLinha){
                        $contadorLinhas += ceil($contadorChar/$maxCharLinha);
                        
                    }else{
                        $contadorLinhas++;
                    }
                    $contadorLinhas += $linhasAdicionais; 
                    if($contadorLinhas >= $maxLinhas){
                        $pulos = $contadorLinhas - $maxLinhas;
                        for ($i=1; $i <= $pulos; $i++) { 
                           echo '<br>';
                        }                        
                        $contadorLinhas = 0;
                    }
                ?>
            <? }?>
        <!-- </div> -->
    <!-- </div> -->
    <!-- <p style='text-align:left;'> $texto </p> -->
    

    <? if ($empresapermissoes[0]->desativar_personalizacao_impressao != 't' && $timbrado) { ?>
    </div>
<? } ?>

