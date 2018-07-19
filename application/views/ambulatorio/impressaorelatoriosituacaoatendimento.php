<div class="content">
    <meta charset="utf-8">
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>RELATÓRIO SITUAÇÃO DE ATENDIMENTO</h4>
    <h4>SITUAÇÃO: <?= ($_POST['situacao'] == '')?"TODOS":$_POST['situacao']; ?></h4>
    <h4>PERÍODO INICIAL: <?= $txtdata_inicio; ?></h4>
    <h4>PERÍODO FINAL: <?= $txtdata_fim; ?></h4>
     <style>
        
        #circulo{
            display: inline-block;
            width: 10pt;
            height: 10pt;
            border: 1pt solid black;
            border-radius: 50%;
        }
    </style>
    <table cellpadding="5" cellspacing="0" style = "position: absolute; right: 100px; top: 100px ">
    <thead>
    
                <th class="tabela_header">Situação do Atendimento</th>
    
    
    </thead>
    <tbody>
         <td>
                            <div>
                                <div id="circulo" style="background-color: black"></div> Normal
                            </div>
                            <div>
                                <div id="circulo" style="background-color: red"></div> Entrega do Exame Atrasado
                            </div>
         </td> 
    </tbody>
    </table>

    <hr>
    <? if (count($relatorio) > 0) {
        ?>
      
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Paciente</th>
                    <th class="tabela_header"><font size="-1">Médico</th>
                    <th class="tabela_header"><font size="-1">Data Agendamento</th>
                    <th class="tabela_header"><font size="-1">Data Atendimento</th>
                    <th class="tabela_header"><font size="-1">Situação</th>
                    <th class="tabela_header"><font size="-1">Convênio</th>
                    <th class="tabela_header"><font size="-1">Grupo</th>
                    <th class="tabela_header"><font size="-1">Procedimento</th>
                    <th class="tabela_header" title="Data prevista para o recebimento do exame."><font size="-1">Data Prevista</th>
                    <th class="tabela_header"><font size="-1">Observação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($relatorio as $item) :
                    
                    $dt_prazo = "";
                    $cor = "";
                    
                    if ($item->entrega != '') {
                        $dt_prazo = date("d/m/Y", strtotime("+".$item->entrega." days", strtotime($item->data_atendimento)));
                        if($dt_prazo <= date("d/m/Y") && $item->situacaolaudo != "FINALIZADO"){
                            $cor = "red";
                        }
                    }
                    
                    ?>
                    <tr>
                        <td><font size="-2" color="<?= $cor ?>"><?= $item->paciente; ?></font></td>
                        <td><font size="-2" color="<?= $cor ?>"><?= $item->medicoconsulta; ?></font></td></font>
                        <td><font size="-2" color="<?= $cor ?>"><?= date("d/m/Y", strtotime($item->data)); ?></font></td>
                        <td><font size="-2" color="<?= $cor ?>"><?= date("d/m/Y", strtotime($item->data_atendimento)); ?></font></td>
                        <td><font size="-2" color="<?= $cor ?>"><?= $item->situacaolaudo; ?></font></td>
                        <td><font size="-2" color="<?= $cor ?>"><?= $item->convenio; ?></font></td>
                        <td><font size="-2" color="<?= $cor ?>"><?= $item->grupo; ?></font></td>
                        <td><font size="-2" color="<?= $cor ?>"><?= $item->procedimento; ?></font></td>
                        <td title="Data prevista para o recebimento do exame.">
                            <? if($item->entrega != ''){ ?>
                                <font size="-2" color="<?= $cor ?>"><?= $dt_prazo; ?></font>
                            <? } ?>
                        </td>
                        <td>
                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/alterarobservacaolaudo/<?= $item->ambulatorio_laudo_id ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=230');">
                                <font size="-2" color="<?= $cor ?>">=><?= $item->observacao_laudo; ?></font>
                            </a>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
        <?
    } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div>

