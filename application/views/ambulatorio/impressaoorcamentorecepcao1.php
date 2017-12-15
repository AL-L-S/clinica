<meta charset="UTF-8">
<div style="border: solid 1px;min-height: 800px;" class="content ficha_ceatox">



    <table  style="text-align: center;width: 100%;" >
        <tbody>
            <?if($empresa[0]->cabecalho_config == 't'){
              echo $cabecalho;  
            }else{?>
             <tr >
                <td style="font-weight: bold"><font size = -1> <?= $empresa[0]->razao_social; ?></td>
                <!--<td ><font size = -1>Emissao:<?= str_replace("-", "/", $emissao); ?></td>-->
            </tr>
            <tr>
                <td ><font size = -1><?= $empresa[0]->logradouro; ?><?= $empresa[0]->numero; ?> - <?= $empresa[0]->bairro; ?></td>
                <!--<td ></td>-->
            </tr>
            <tr>
                <td ><font size = -1>Fone: <?= $empresa[0]->telefone; ?></td>
                <!--<td ></td>-->
            </tr>   
           <? }
            ?>
            

<!--            <tr>
                <td ><b><font size = -1>Paciente: <?= $exames['0']->paciente; ?></b></td>
                <td ></td>
            </tr>-->


        </tbody>
    </table>
    <div style="border-top: solid 1px;border-bottom: solid 1px;">


        <table  style="text-align: left;width: 100%;font-size: 9pt;margin-top: 10px;margin-bottom: 10px;" >

            <tbody>


                <tr>
                    <td style="background-color: #aaaaaf;font-size: 9pt;width: 400px;" >Paciente: <?= $exames['0']->paciente; ?></td>
                    <td style="width: 250px;"> Orçamento Solicitado Por Paciente</td>
                    <td style="background-color: #aaaaaf;font-size: 9pt;width: 130px;" >Data do Orçamento: </td>
                    <td ><?= date("d/m/Y H:i:s",strtotime($exames['0']->data_cadastro));?></td>
    <!--                <td style="background-color: #aaaaaf;font-size: 9pt" >Data: </td>
                    <td ><?= substr($exames['0']->data_cadastro, 8, 2) . '/' . substr($exames['0']->data_cadastro, 5, 2) . '/' . substr($exames['0']->data_cadastro, 0, 4); ?></td>-->
                </tr>


            </tbody>
        </table>
    </div>
    <!--<hr>-->
    <table style="text-align: left;width: 100%;font-size: 9pt" >
        <tr style="background-color: #aaaaaf;font-size: 9pt;">
            <th >Descrição</th>

            <th >Principais Orientações</th>
            <!--<th >Convenio</th>-->
            <!--<th >Forma de Pagamento</th>-->
            <th >Qtde</th>
            <th >V. Unit</th>
            <th >V. Total</th>
        </tr>
        <?
        $total = 0;
        $quantidade = 0;
        foreach ($exames as $item) :
            $total = $total + $item->valor_total;
            $quantidade++;
            ?>
        <tr style="background: #d8d7de">

                <td width="25%;"><?= $item->procedimento ?></td>
                <td ></td>
                <td width="10%;"><?= $item->quantidade ?></td>
                <td width="10%;"><?= number_format($item->valor, 2, ',', '.') ?></td>
                <!--<td width="15%;"><?= $item->grupo ?></td>-->
                <!--<td width="25%;"><?= $item->convenio ?></td>-->
                <!--<td width="25%;"><?= $item->forma_pagamento ?></td>-->
                <td width="25%;"><?= number_format($item->valor_total, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td width="25%;"></td>
                <td > <?= $item->observacao ?></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td> 
            </tr>


            <?
        endforeach;
        ?>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="25%;"><b></b></td>
            <td ><b></b></td>
            <td ><b></b></td>
            <td ><b>Total (<?= $quantidade ?>)</b></td>
            <td width="25%;"><b> <?= number_format($total, 2, ',', '.') ?></b></td>
        </tr>
        </tbody>
    </table>
    
    <?if($empresa[0]->rodape_config == 't'){
              echo $rodape;  
            }else{?>
             
           <? }
            ?>



</div>
