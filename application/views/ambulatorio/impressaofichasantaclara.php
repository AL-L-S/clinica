<meta charset="UTF-8">
<div class="content ficha_ceatox">

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente['0']->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>
    <? // echo'<pre>';    var_dump($exame[0]->email);die;?>
    <table border="1" width="100%" style="border-collapse: collapse">
        <tr height="100px">
        <td colspan="1">
            <table style="width: 100%;">
                <tbody>
                    <tr>                        
                        <td width="900px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td align="center"><font size = -1>Telefone:<?= $exame[0]->telefoneempresa; ?></td>                        
                    </tr>
                    <tr>
                        <td align="center"><font size = -1>Email:<?= $exame[0]->email; ?></td>                        
                    </tr>

                </tbody>
            </table>
        </td>
        <td colspan="1">
            <table style="width: 250px;">
                <tr>
                    <td>
                        <b>Data Coleta:</b> 23/11/2018 <?= ($exame[0]->data_entrega != '') ? date("d/m/Y", strtotime($exame[0]->data_entrega)) : ''; ?>
                    </td>
                </tr>
            </table>
        </td>
        </tr>
        <tr>
            <td colspan="2">
            <table style="width: 100%;">
                <tbody>
                    <tr>                        
                        <td width="900px" align="center"><span style="font-weight: normal"><?= $exame[0]->razao_social; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td align="center"><font size = -1>Telefone:<?= $exame[0]->telefoneempresa; ?></td>                        
                    </tr>
                    <tr>
                        <td align="center"><font size = -1>Email:<?= $exame[0]->email; ?></td>                        
                    </tr>

                </tbody>
            </table>
        </td>            
        </tr>
    </table>

    
</div>












