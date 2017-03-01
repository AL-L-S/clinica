<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>centrocirurgico/centrocirurgico/cadastrarequipe" target="_blank">
            Nova Equipe
        </a>
    </div>
    <div class="clear"></div>
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
                <input type="text" id="convenio" class="texto02" name="convenio" value="<?= @$guia[0]->convenio; ?>" readonly="true"/>
            </div>

        </fieldset>
        <fieldset>

            <div >
                <label>Procedimento *</label>
                <select  name="procedimento" id="procedimento" class="size2"  required="">
                    <option value="">Selecione</option>
                    <? foreach (@$procedimentos as $item) : ?>
                        <option value="<?= $item->procedimento_convenio_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>
            
            <div>
                <label>QTDE*</label>
                <input type="text" name="qtde" id="qtde" alt="integer" style="width:40pt" value="1" required=""/>
            </div>

            <div >
                <label>Data/Hora Autorização*</label>
                <input type="text" name="data_autorizacao" id="data_autorizacao" alt="29/29/9999 29:69"class="size2" required=""/>
            </div>

            <div >
                <label>Data/Hora Realização*</label>
                <input type="text" name="data_realizacao" id="data_realizacao" alt="29/29/9999 29:69"class="size2" required=""/>
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
                        <th class="tabela_header">Data/Hora Realizaçao</th>
                        <th class="tabela_header">Horario Especial</th>
                    </tr>
                </thead>
    <?
            $estilo_linha = "tabela_content01";
            foreach ($procedimentos_cadastrados as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
    ?>
                    <tbody>
                        <tr>
                            <td class="<?php echo $estilo_linha;?>"><?= $item->nome; ?></td>
                            <td class="<?php echo $estilo_linha;?>"><?= date("d/m/Y H:i", strtotime($item->data_autorizacao)); ?></td> 
                            <td class="<?php echo $estilo_linha;?>"><?= date("d/m/Y H:i", strtotime($item->data_realizacao)); ?></td>
                            <td class="<?php echo $estilo_linha;?>">
                                <? 
                                    if ($item->horario_especial == 't'){
                                         echo "SIM";
                                    } 
                                    else{
                                         echo "NAO";
                                    }
                                ?>
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
    
        </fieldset>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

//    $(function () {
//        $('#procedimento').change(function () {
//            if ($(this).val() && $('#equipe_id').val() != '') {
//                $('.carregando').show();
//                $.getJSON('<?= base_url() ?>autocomplete/carregavalorprocedimentocirurgico', {procedimento_id: $(this).val(), equipe_id: $('#equipe_id').val()}, function (j) {
//                    options = '<option value=""></option>';
//                    for (var c = 0; c < j.length; c++) {
//                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
//                    }
//                    $('#procedimento1').html(options).show();
//                    $('.carregando').hide();
//                });
//            }
//        });
//    });

//    $(function () {
//        $('#equipe_id').change(function () {
//            if ($(this).val() && $('#procedimento').val() != '') {
//                $('.carregando').show();
//                $.getJSON('<?= base_url() ?>autocomplete/carregavalorprocedimentocirurgico', {procedimento_id: $('#procedimento').val(), equipe_id: $(this).val()}, function (j) {
//
//                });
//            }
//        });
//    });

</script>
