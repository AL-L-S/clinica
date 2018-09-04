<meta charset="utf-8">

<?
$impressao_aso = json_decode($relatorio[0]->impressao_aso);
//echo'<pre>'; var_dump($impressao_aso);die;
?>
<br><br><br>

<table style="width: 100%">
    <tr height="100px">
        <td colspan="3" style="padding-top: 30px">
            <? $convenio = $this->convenio->listarconvenioselecionado($impressao_aso->convenio1); ?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?= $convenio[0]->nome ?> 
        </td>
    </tr> 
    <tr height="30px">
        <td colspan="2" width="500px">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?= $relatorio[0]->paciente ?>
        </td>
        <td>
            <?= $relatorio[0]->rg ?> 
        </td>
    </tr>
    <tr>
        <td>
            <? $funcao = $this->saudeocupacional->carregarfuncao($impressao_aso->funcao); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?= $funcao[0]->descricao_funcao ?>
        </td>
        <td width="350px" style="text-align: center">
            <?= ($relatorio[0]->nascimento != '') ? date("d/m/Y", strtotime($relatorio[0]->nascimento)) : '' ?>
        </td>
        
    </tr>
    <tr height="70px">
        <td colspan="3">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
            <?
            if (isset($impressao_aso->riscos)) {
                foreach ($impressao_aso->riscos as $key => $item) :
                    $risco = $this->saudeocupacional->carregarriscoaso($item);
                    ?>
                    <? if ($key == count($impressao_aso->riscos) - 1) {
                        echo $risco[0]->descricao_risco;
                    } else {
                        echo $risco[0]->descricao_risco . ", ";
                    }
                    ?>                

            <?
            endforeach;
        } else {
            echo "SEM RISCOS OCUP. ESPECÍFICOS";
        }
        ?>
        </td>    
    </tr>
    <tr height="70px">
        <td colspan="3">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
            
            <?
                                if (isset($impressao_aso->procedimento1)) {
                                    foreach ($impressao_aso->procedimento1 as $key => $item) :
                                        $procedimentos = $this->procedimento->listarprocedimentoaso($item);
                                        ?>
                                        <?
                                        if ($key == count($impressao_aso->procedimento1) - 1) {
                                            echo $procedimentos[0]->nome;
                                        } else {
                                            echo $procedimentos[0]->nome . ", ";
                                        }
                                        ?>

                                        <?
                                    endforeach;
                                } else {
                                    echo "NENHUM EXAME COMPLEMENTAR NECESSÁRIO";
                                }
                                ?>
        </td>
    </tr>
    <tr height="30px">
        <td colspan="3">
            &nbsp;&nbsp;&nbsp;            
            <? if($impressao_aso->avaliacao_clinica == ""){
                echo "APTO PARA A FUNÇÃO QUE EXERCE";
            } else{
            $impressao_aso->avaliacao_clinica; 
            }?>
        </td>    
    </tr>
</table>


<table style="width: 100%">
    <tr height="55px">
        <td colspan="2" width="400px">
            &nbsp;&nbsp;&nbsp;
            <?= $impressao_aso->validade_exame ?> 
        </td>
        <td colspan="2" width="400px">
            &nbsp;&nbsp;&nbsp;
            <?= $impressao_aso->tipo ?>
        </td>        
    </tr>
    <tr height="40px">
        <td colspan="2" width="400px">
            &nbsp;&nbsp;&nbsp;
            <?= $relatorio[0]->medico ?><br>
            &nbsp;&nbsp;&nbsp;&nbsp;MEDICO EXAMINADOR CRM: <?=@$relatorio[0]->conselho?>
        </td>
        <td colspan="2" width="400px">
            &nbsp;&nbsp;&nbsp;
            <?= $relatorio[0]->medico ?><br>
            &nbsp;&nbsp;&nbsp;&nbsp;MEDICO COORDENADOR CRM: <?=@$relatorio[0]->conselho?>
        </td>
    </tr>

</table>
