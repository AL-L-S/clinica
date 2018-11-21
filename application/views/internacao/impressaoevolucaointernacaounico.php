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
    <?if($paciente[0]->internacao_evolucao_id == $internacao_evolucao_id){?>
    <p style='text-align:center;font-size: 15pt;font-weight: bold'> Evolução </p>
    <?}else{?>
    <p style='text-align:center;font-size: 15pt;font-weight: bold'> &nbsp; </p>
    <?}?>
    <br>
    <!-- <div class="divTamanhoMaximo"> -->
        <!-- <div> -->
            <?
            $maxLinhas = 35;
            $maxCharLinha = 100;
            $contadorLinhas = 0;
            $contadorLinhasTot = 0;
            $contadorChar = 0;
            $linhasAdicionais = 6;
            $contadorCharTot = 0;
            ?>
            <?
            foreach($paciente as $value){

                $contadorChar += strlen($value->diagnostico);
                if($contadorChar > $maxCharLinha){
                    $contadorLinhas += ceil($contadorChar/$maxCharLinha);
                }else{
                    $contadorLinhas++;
                }
                $contadorLinhas += $linhasAdicionais; 
                // Essa adição é pra suprir a questão das linhas a mais do carimbo e etc; 
                if($value->internacao_evolucao_id == $internacao_evolucao_id){
                    break;
                }
                // Quando chegar na evolucao que quer ele para a conta
               
            }
            // Descobrir quantos cabem por folha
            if($contadorLinhas > $maxLinhas){
                $linhasPular = $contadorLinhas - $maxLinhas;
                $paginas = ceil($contadorLinhas/$maxLinhas);
            }else{
                $linhasPular = 0;
                $paginas = 0;
            }
            // var_dump($linhasPular); die;
            ?>


            <?foreach ($paciente as $key => $item) {?>
                <?
                $contadorCharTot += strlen($item->diagnostico);  
                if($contadorCharTot > $maxCharLinha){
                    $contadorLinhasTot += ceil($contadorCharTot/$maxCharLinha);
                    
                }else{
                    $contadorLinhasTot++;
                }
                $contadorLinhasTot += $linhasAdicionais; 
                    
                ?>
                <?//if($contadorLinhasTot >= $maxLinhas + (($paginas - 1) * $maxLinhas) || $linhasPular == 0){?>
                    <?if($item->internacao_evolucao_id == $internacao_evolucao_id){?>
                    
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
                        <?break;?>
                    <?}else{
                        $contadorChar = strlen($item->diagnostico);
                        $contadorLinha = 1;
                        for ($i=0; $i < $contadorChar; $i++) { 
                            echo '&nbsp;';
                            if($i == 100 * $contadorLinha){
                                echo '<br>';
                                $contadorLinha++;
                            }
                            
                        }
                        echo '<br>';
                        echo '<br>';
                        // echo '<br>';
                        // echo '<br>';
                        // echo '<br>';
                        if($contadorChar <= 200){
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                        }
                    }?>
                <?//}?>
                
            <? }?>
        <!-- </div> -->
    <!-- </div> -->
    <!-- <p style='text-align:left;'> $texto </p> -->
    

    <? if ($empresapermissoes[0]->desativar_personalizacao_impressao != 't' && $timbrado) { ?>
    </div>
<? } ?>

