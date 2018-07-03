
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Honor&aacute;rios Laboratorio</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarpercentuallaboratoriomultiplo" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Laboratorio</label>
                    </dt>
                    <dd>                    
                        <select name="laboratorio" id="laboratorio" class="size4" required="">
                            <option value="">SELECIONE</option>
                            <option value="TODOS">TODOS</option>
                            <? foreach ($laboratorios as $value) : ?>
                                <option value="<?= $value->laboratorio_id; ?>" <? if (@$laboratorio_id == $value->laboratorio_id) echo'selected';?>>
                                    <?php echo $value->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Convênio</label>
                    </dt>
                    <dd>
                        <select name="convenio_id" id="convenio_id" class="size2">
                            <option value="">Selecione</option>
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" <? if (@$convenio_id == $value->convenio_id) echo'selected';?>>
                                    <?php echo $value->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <br>
                    
                    <div class="divTabela">
                        <table id="procedimentos">
                            <tr id="trBase">
                                <td>
                                    <select id="grupoText" class="size1">
                                        <option value="">Selecione</option>
                                        <? foreach ($grupos as $value) {?>
                                        <option value="<?= $value->nome ?>"><?= $value->nome ?></option>
                                        <? } ?>
                                    </select>
                                </td>
                                <td width="50px;">
                                    <select name="procedimentoText" id="procedimentoText" class="size2 chosen-select" tabindex="1" data-placeholder="Procedimento">
                                        <option value="">Selecione</option>
                                        <? foreach ($procedimentoLista as $value) {?>
                                        <option value="<?= $value->procedimento_tuss_id; ?>"><?= $value->codigo . " - " . $value->nome; ?></option>
                                        <? } ?>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" style="display: inline-block" onclick="filtrarTabela()">Buscar</button>
                                </td>
                                <td class="tdValorText">
                                    <input type="text" id="valorText" class="texto01">
                                </td>
                                <td class="tdPercText">
                                    <select id="percText" name="percText" class="size1">
                                        <option value="">Selecione</option>
                                        <option value="1">Sim</option>
                                        <option value="0">Nao</option>
                                    </select>
                                </td>
<!--                                <td class="tdRevText">
                                    <select id="revText" name="revText" class="size1">
                                        <option value="">Selecione</option>
                                        <option value="1">Sim</option>
                                        <option value="0">Nao</option>
                                    </select>
                                </td>-->
                                <td class="tdDiaRecText">
                                    <input type="text" id="diaRecText" class="texto01">
                                </td>
                                <td class="tdTempoRecText">
                                    <input type="text" id="tempoRecText" class="texto01">
                                </td>
                                <td>
                                    <button type="button" onclick="aplicandoValores()">Aplicar</button>
                                </td>
                            </tr>
                            <tr id="trBase">
                                <td class="tabela_title">Grupo</td>
                                <td class="tabela_title">Procedimento</td>
                                <td class="tabela_title"></td>
                                <td class="tabela_title">Valor</td>
                                <td class="tabela_title">Percentual</td>
                                <!--<td class="tabela_title">Revisor</td>-->
                                <td class="tabela_title">Dia Faturamento</td>
                                <td class="tabela_title">Tempo Recebimento</td>
                                <td class="tabela_title">Limpar?</td>
                            </tr>
                            <? 
                            $i = 0;
                            foreach($procedimento as $item){ ?>
                                <tr class="linhaTabela">
                                    <td class="<?= $item->grupo ?>"><?= $item->grupo ?></td>
                                    <td colspan="2" class="<?= $item->procedimento_tuss_id ?>">
                                        <input type="hidden" name="procedimento_convenio_id[<?= $i ?>]" value="<?= $item->procedimento_convenio_id ?>"/>
                                        <?= $item->codigo ?> - <?= $item->procedimento ?>
                                    </td>
                                    <td class="tdValor">
                                        <input type="text" name="valor[<?= $i ?>]"  id="valor<?= $i ?>" class="texto01"/>
                                    </td>
                                    <td class="tdPercentual">
                                        <select name="percentual[<?= $i ?>]"  id="percentual<?= $i ?>" class="size1">
                                            <option value="1"> SIM</option>
                                            <option value="0"> NÃO</option>
                                        </select>
                                    </td>
<!--                                    <td class="tdRevisor">
                                        <select name="revisor[<?= $i ?>]"  id="revisor<?= $i ?>" class="size1">
                                            <option value="1"> SIM</option>
                                            <option value="0"> NÃO</option>
                                        </select>
                                    </td>-->
                                    <td class="tdDiaRecebimento">
                                        <input type="text" name="dia_recebimento[<?= $i ?>]" alt="99" id="dia_recebimento<?= $i ?>" class="texto01"/>
                                    </td>
                                    <td class="tdTempoRecebimento">
                                        <input type="text" name="tempo_recebimento[<?= $i ?>]" alt="99" id="tempo_recebimento<?= $i ?>" class="texto01"/>
                                    </td>
                                    <td class="tdLimpar">
                                        <input type="checkbox" name="limparLinha" id="limparLinha" class="<?= $i ?>"/>
                                    </td>
                                 </tr>
                                <? 
                                $i++;
                            } ?>
                        </table>
                    </div>

                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<style>
    .divTabela { border: 1pt solid #aaa; border-radius: 10pt; padding: 5pt; }
    .linhaTabela { border-bottom: 1pt solid #aaa; }
    #procedimentoText_chosen a { width: 90%; }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">

<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js" ></script>
<script type="text/javascript">   
    
    
    $(function () {
        $("#accordion").accordion();
    });
    
    $(function () {
        $('input[name=limparLinha]').change(function () {
            var id = $(this).attr('class');
            
            $("#valor"+id).val('');
//            $("#revisor"+id).val('');
            $("#percentual"+id).val('');
            $("#dia_recebimento"+id).val('');
            $("#tempo_recebimento"+id).val('');
            
            $(this).removeAttr('checked');
        }); 
    });
    
    $(function () {
        $('#convenio_id').change(function () {
            window.open('<?= base_url() ?>ambulatorio/procedimentoplano/percentuallaboratoriomultiplo/' + $(this).val(), '_self');
        }); 
    });
    
    function aplicandoValores(){
        
        var tr = document.getElementById('procedimentos').getElementsByTagName("tr"),
            valor = $("#valorText").val(),
            diaRecebimento = $("#diaRecText").val(),
            tempoRecebimento = $("#tempoRecText").val(),
            percentual = $("#percText option:selected").val();
        
        for (var i = 0; i < tr.length; i++) {
            if(tr[i].getAttribute("id") != 'trBase' && tr[i].style.display == ""){
                var td = tr[i].getElementsByTagName("td");
                var checkbox = td[td.length - 1].getElementsByTagName("input")[0];
                var id = checkbox.getAttribute("class");
                
                if(valor != "") $("#valor"+id).val(valor);
                if(percentual != "") $("#percentual"+id).val(percentual);
                if(diaRecebimento != "") $("#dia_recebimento"+id).val(diaRecebimento);
                if(tempoRecebimento != "") $("#tempo_recebimento"+id).val(tempoRecebimento);
            }
        }
    }
    
    function filtrarTabela() {
        var procedimento = document.getElementById("procedimentoText").value;
        var grupo = document.getElementById("grupoText").value;
        
        var tr = document.getElementById('procedimentos').getElementsByTagName("tr")

        for (var i = 0; i < tr.length; i++) {
            if(tr[i].getAttribute("id") != 'trBase'){
                
                var td = tr[i].getElementsByTagName("td");
                
                var visivelGrupo = true;
                
                // Filtro do grupo
                if (grupo == td[0].getAttribute("class") || grupo == '') {
                    tr[i].style.display = "";
                } 
                else { 
                    visivelGrupo = false;
                    tr[i].style.display = "none";
                }
                
                // Filtro do procedimento
                if (procedimento == td[2].getAttribute("class") || procedimento == '') {
                    if (visivelGrupo) tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                
            }
        }
        
    }
        
</script>