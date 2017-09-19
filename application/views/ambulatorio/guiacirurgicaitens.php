<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>centrocirurgico/centrocirurgico/excluirguiacirurgica/<?= @$guia_id; ?>" onclick="javascript: return confirm('Deseja realmente excluir esta guia?');">
            Cancelar Guia
        </a>
    </div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarguiacirurgicaprocedimentos" method="post">
        <fieldset>
            <legend>Dados da Guia</legend>

            <div>
                <label>Nome</label>
                <input type="hidden" id="txtguiaid" class="texto_id" name="txtguiaid" readonly="true" value="<?= @$guia[0]->ambulatorio_guia_id; ?>" />
                <input type="hidden" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" value="<?= @$guia[0]->paciente_id; ?>" />
                <input type="text" id="txtNome" required name="txtNome" class="texto10" value="<?= @$guia[0]->paciente; ?>" readonly="true"/>
            </div>
            <div>
                <label>Dt de nascimento</label>
                <input type="text" name="nascimento" id="nascimento" class="texto02" value="<?= date("d/m/Y", strtotime(@$guia[0]->nascimento)); ?>" readonly="true"/>                
            </div>

            <div>
                <label>Telefone</label>
                <input type="text" id="telefone" class="texto02" name="telefone" value="<?= @$guia[0]->telefone; ?>" readonly="true"/>
            </div>
            <div>
                <label>Convenio</label>
                <input type="text"  id="convenio" class="texto02" name="convenio" value="<?= @$guia[0]->convenio; ?>" readonly="true"/>
            </div>

        </fieldset>
        <fieldset>
            <legend>Procedimentos</legend>

            <div style="width:100%">
                <label>Procedimento *</label>
                <select  name="procedimento" id="procedimento" required="true" class="chosen-select" tabindex="1">
                    <option value="">Selecione</option>
                    <? foreach (@$procedimentos as $item) : ?>
                        <option value="<?= $item->procedimento_convenio_id; ?>"  
                                onclick="document.getElementById('valor').value = '<?= $item->valortotal; ?>'">
                                    <?= $item->codigo . " - " . $item->nome; ?>
                        </option>
                    <? endforeach; ?>
                </select>
                <!--
                                <br>--> 
            </div>

            <div >

                <label>Data/Hora Autorização*</label>
                <input type="text" name="data_autorizacao" id="data_autorizacao" alt="39/29/9999 29:69" class="texto03" required=""/>

            </div>

            <div >
                <label>Data/Hora Realização*</label>
                <input type="text" name="data_realizacao" id="data_realizacao" alt="39/29/9999 29:69"class="texto03" required=""/>
            </div>



            <!--            <div>
                            <label>Valor</label>
                            <input type="text" id="valor" class="texto01" name="valor" alt="decimal"/>
                        </div>-->

            <div>
                <label>QTDE*</label>
                <input type="text" name="qtde" id="qtde" alt="integer" class="texto01" value="1" required=""/>
            </div>


            <div>
                <label> H. Especial* </label>
                <input type="checkbox" name="horEspecial">
            </div>


            <div style="width: 100%">
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Enviar</button>
            </div>
        </fieldset>
    </form>

    <fieldset>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Procedimento</th>
                    <th class="tabela_header">Data/Hora Autorizaçao</th>
                    <th class="tabela_header">Valor</th>
                    <th class="tabela_header">Data/Hora Realizaçao</th>
                    <th class="tabela_header">Horario Especial</th>
                    <th class="tabela_header"></th>
                </tr>
            </thead>
            <?
            $estilo_linha = "tabela_content01";
            foreach ($procedimentos_cadastrados as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i", strtotime($item->data_autorizacao)); ?></td> 
                        <td class="<?php echo $estilo_linha; ?>">
                            <a style="cursor: pointer;" onmouseover="style = 'cursor: pointer;color:red;'" onmouseout="style = 'cursor: pointer;color:black;'" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/procedimentocirurgicovalor/$item->agenda_exames_id" ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=500');">
                                => <?= number_format($item->valor_total, 2, ',', '.') ?>
                            </a>
                        </td> 
                        <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i", strtotime($item->data_realizacao)); ?></td>
                        <td class="<?php echo $estilo_linha; ?>">
                            <?
                            if ($item->horario_especial == 't') {
                                echo "SIM";
                            } else {
                                echo "NAO";
                            }
                            ?>
                        </td>                            
                        <td class="<?php echo $estilo_linha; ?>" width="30px;" style="width: 60px;">
                            <a href="<?= base_url() ?>ambulatorio/exametemp/excluirprocedimentoguia/<?= $item->agenda_exames_id; ?>/<?= @$guia[0]->ambulatorio_guia_id; ?>" class="delete">
                            </a>
                        </td>

                    </tr>


                    <?
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="tabela_footer" colspan="4">
                    </th>
                </tr>
            </tfoot>
        </table> 
        <br>
        <div class="bt_link_new">
            <a href="<?php echo base_url() ?>centrocirurgico/centrocirurgico/finalizarcadastroprocedimentosguia/<?= @$guia[0]->ambulatorio_guia_id; ?>">
                Finalizar Procedimentos
            </a>
        </div>

    </fieldset>



</div> <!-- Final da DIV content -->
<!--<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>-->
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js" type="text/javascript"></script>-->
<script type="text/javascript">
//$('#data_realizacao').mask('00/00/0000  00:00');
//  $('#data_realizacao').mask('00/00/0000 00:00:00');
//  $('#data_autorizacao').mask('00/00/0000 00:00:00');



</script>
