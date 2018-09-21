<head>
    <title>Prescrição</title>
</head>
<div >
    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = $paciente[0]->nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');

    if (count($receita) == 0) {
        $receituario_id = 0;
        $texto = "";
        $medico = "";
        $procedimento;
    } else {
        $procedimento = $receita[0]->procedimento;
        $texto = $receita[0]->texto;
        $receituario_id = $receita[0]->ambulatorio_receituario_id;
        $medico = $receita[0]->medico_parecer1;
    }
    $operador_id = $this->session->userdata('operador_id');
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarreceituariosollis/<?= $ambulatorio_laudo_id ?>/<?= $paciente_id ?>/<?= $prescricao[0]->prescricao_id ?>" method="post">
            <div >
                <fieldset>
                    <legend>Dados</legend>
                    <table>
                        <? // var_dump($prescricao[0]);die;?>
                        <tr><td width="400px;">Paciente:<?= $paciente[0]->nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>
                            <td>Solicitante: <?= $paciente[0]->medico ?></td>
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento: <?= substr($paciente[0]->nascimento, 8, 2) . "/" . substr($paciente[0]->nascimento, 5, 2) . "/" . substr($paciente[0]->nascimento, 0, 4); ?></td>
                            <td>Sala:<?= @$obj->_sala ?></td>
                        </tr>
                    </table>
                </fieldset>
                <table>
                    <tr>
                        <? // var_dump($obj->_paciente_id);die;?>
                        <td>
                            <div class="bt_link_new" style="width: 80px; margin: 5px">
                                <a href="<?= base_url() ?>ambulatorio/laudo/carregarprescricao/<?= $ambulatorio_laudo_id ?>/<?= $obj->_paciente_id ?>');" style="width: 80px; margin: 5px">
                                    Voltar</a></div>
                        </td>                       
                    </tr>
                </table><br><br>
                <fieldset>
                    <table style="padding-left: 50px;">
                        <tr height="60px">
                            <th>CID:</th><td><input type="text" id="cid" name="cid" class="texto6" /></td>
                        </tr>
                        <tr height="60px">
                            <th>Frequência:</th><td><input type="text" id="freq" name="freq" class="texto6" />
                                <select name="frequnit" id="frequnit" class="size1">
                                    <option value=''>SELECIONE</option>
                                    <option value='horas'<?
//                                    if (@$prescricao[0]->frequnit == 'horas'):echo 'selected';
//                                    endif;
                                    ?> >Hora</option>
                                    <option value='dias' <?
//                                    if (@$prescricao[0]->frequnit == 'dias'):echo 'selected';
//                                    endif;
                                    ?> >Dia</option>
                                    <!--                                    <option value='semanas' <?
//                                    if (@$prescricao[0]->frequnit == 'semanas'):echo 'selected';
//                                    endif;
                                    ?> >Semana(s)</option>-->
                                </select><font>
                            </td>

                        </tr>
                        <tr height="60px">
                            <th>Quantidade do Medicamento:</th><td><input type="text" id="qtdmed" name="qtdmed" class="texto6" /></td>
                        </tr>
                        <tr height="60px">
                            <th>Medicamento ID:</th><td><input type="text" id="medid" name="medid" class="texto6" /></td>
                        </tr>
                        <tr height="60px">
                            <th>Período:</th><td><input type="text" id="periodo" name="periodo" class="texto6" />
                                <select name="perunit" id="perunit" class="size1">
                                    <option value=''>SELECIONE</option>                                    
                                    <option value='dias' <?
//                                    if (@$prescricao[0]->perunit == 'dias'):echo 'selected';
//                                    endif;
                                    ?> >Dia(s)</option>
                                    <option value='semanas' <?
//                                    if (@$prescricao[0]->perunit == 'semanas'):echo 'selected';
//                                    endif;
                                    ?> >Semana(s)</option>
                                    <option value='meses'<?
//                                    if (@$prescricao[0]->perunit == 'meses'):echo 'selected';
//                                    endif;
                                    ?> >Mes(es)</option>
                                    <option value='anos'<?
//                                    if (@$prescricao[0]->perunit == 'anos'):echo 'selected';
//                                    endif;
                                    ?> >Ano(s)</option>
                                    <option value='indeterminado'<?
//                                    if (@$prescricao[0]->perunit == 'indeterminado'):echo 'selected';
//                                    endif;
                                    ?> >Indeterminado</option>

                                </select><font></td>
                        </tr>                   
                        <tr height="60px">
                            <th>Observações:</th><td><textarea type="text" id="observacao" name="observacao" class="texto"  cols="42" rows="8"></textarea></td>
                        </tr>

                    </table><br><br>

                    <div>

                        <hr>
                        <div>
                            
                        <button type="submit" name="btnEnviar">Adicionar</button>
                </fieldset>
    </div> 
        </form>
</div>
                    <div>
        <fieldset>
            <table id="table_agente_toxico" border="1" style="border-collapse: collapse; text-align: center" align="center" width="100%">
                <tr>
                    <th class="tabela_header">CID</th>
                    <th class="tabela_header">Frequência</th>
                    <th class="tabela_header">Quantidade</th>
                    <th class="tabela_header">Medicamento ID</th>
                    <th class="tabela_header">Período</th>
                    <th class="tabela_header">Observações</th>
                    <th class="tabela_header"></th>
                                   
                </tr>
                               <? $estilo_linha = "tabela_content01";?>   
                                <? foreach ($prescricaosollis as $value) :
//                                     var_dump($value);die;
                                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                    ?>
                                    <? if ($prescricao_id == $value->prescricao_id ) { ?>
                                    <tr>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $value->cid_id ?></td>
                                            <? if ($value->frequnit == 'horas') { ?>
                                            <td class="<?php echo $estilo_linha; ?>">de <?= $value->frequencia ?> em <?= $value->frequencia ?> horas</td>
                                            <? } ?>
                                            <? if ($value->frequnit == 'dias') { ?>
                                            <td class="<?php echo $estilo_linha; ?>"><?= $value->frequencia ?> por dia</td>
                                            <? } ?>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $value->qtdmed ?></td>                        
                                        <td class="<?php echo $estilo_linha; ?>"><?= $value->medid ?></td>                                
                                        <td class="<?php echo $estilo_linha; ?>"><?= $value->periodo ?> <?= $value->perunit ?></td>                                
                                        <td class="<?php echo $estilo_linha; ?>"><?= $value->observacao ?></td>                        
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                            <a onclick="javascript: return confirm('Deseja realmente excluir esse item? ');" target="_blank"
                                               href="<?= base_url() ?>ambulatorio/laudo/excluirmedicamento/<?= $value->receituario_sollis_id ?>/<?= $prescricao[0]->prescricao_id ?>/<?= $ambulatorio_laudo_id ?>/<?= $obj->_paciente_id ?>">
                                                Excluir
                                            </a></div>
                                        </td> 
                                  
                                    </tr>
                                    <? } ?>
                                    <?
                                endforeach;
                                ?>
            </table>
        </fieldset>
    </div>
 
</div> <!-- Final da DIV content -->
<style>
                #sortable { list-style-type: none; margin: 0; padding: 0; width: 1300px; }
                #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
</style>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

                                    </script>
