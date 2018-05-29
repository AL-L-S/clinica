
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Editar Honorários Médicos</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravareditarmedicopercentualmultiplos" method="post">
                <input type="hidden" id="medico_id" name="medico_id" value="<?= $medico_id ?>"/>
                <div class="divTabela">
                    <table id="procedimentos">
                        <tr id="trBase">
                            <td>
                                <select name="convenioText" id="convenioText" class="size1">
                                    <option value="">Selecione</option>
                                    <? foreach ($convenio as $value) : ?>
                                    <option value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                                </select>
                            </td>
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
                            <td class="tdRevText">
                                <select id="revText" name="revText" class="size1">
                                    <option value="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Nao</option>
                                </select>
                            </td>
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
                            <td class="tabela_title">Convenio</td>
                            <td class="tabela_title">Grupo</td>
                            <td class="tabela_title">Procedimento</td>
                            <td class="tabela_title"></td>
                            <td class="tabela_title">Valor</td>
                            <td class="tabela_title">Percentual</td>
                            <td class="tabela_title">Revisor</td>
                            <td class="tabela_title">Dia Faturamento</td>
                            <td class="tabela_title">Tempo Recebimento</td>
                            <td class="tabela_title" style="text-align: center">Excluir</td>
                        </tr>
                        <? 
                        $i = 0;
                        foreach($procedimento as $item){ ?>
                            <tr class="linhaTabela">
                                <td class="<?= $item->convenio_id ?>"><?= $item->convenio ?></td>
                                <td class="<?= $item->grupo ?>"><?= $item->grupo ?></td>
                                <td colspan="2" class="<?= $item->procedimento_tuss_id ?>">
                                    <input type="hidden" id="percentual_id<?= $i ?>" name="percentual_id[<?= $i ?>]" value="<?= $item->percentual_id ?>"/>
                                    <?= $item->codigo ?> - <?= $item->procedimento ?>
                                </td>
                                <td class="tdValor">
                                    <input type="text" name="valor[<?= $i ?>]"  id="valor<?= $i ?>" class="texto01" value="<?= $item->valor ?>"/>
                                </td>
                                <td class="tdPercentual">
                                    <select name="percentual[<?= $i ?>]"  id="percentual<?= $i ?>" class="size1">
                                        <option value="1" <? if($item->percentual == 't') echo "selected"; ?>> SIM</option>
                                        <option value="0" <? if($item->percentual == 'f') echo "selected"; ?>> NÃO</option>
                                    </select>
                                </td>
                                <td class="tdRevisor">
                                    <select name="revisor[<?= $i ?>]"  id="revisor<?= $i ?>" class="size1">
                                        <option value="1" <? if($item->revisor == 't') echo "selected"; ?>> SIM</option>
                                        <option value="0" <? if($item->revisor == 't') echo "selected"; ?>> NÃO</option>
                                    </select>
                                </td>
                                <td class="tdDiaRecebimento">
                                    <input type="text" name="dia_recebimento[<?= $i ?>]" alt="99" id="dia_recebimento<?= $i ?>" class="texto01" value="<?= $item->dia_recebimento ?>"/>
                                </td>
                                <td class="tdTempoRecebimento">
                                    <input type="text" name="tempo_recebimento[<?= $i ?>]" alt="99" id="tempo_recebimento<?= $i ?>" class="texto01" value="<?= $item->tempo_recebimento ?>"/>
                                </td>
                                <td class="tdLimpar" style="text-align: center">
                                    <input type="checkbox" name="excluir" id="excluir" class="<?= $i ?>"/>
                                </td>
                             </tr>
                            <? 
                            $i++;
                        } ?>
                    </table>
                </div>

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" style="float: right; font-weight: bold" onclick="excluirSelecionados()">
                    Excluir
                </button>
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
    
    function excluirSelecionados(){
        var percentuais = [];
        var tr = document.getElementById('procedimentos').getElementsByTagName("tr");
        for (var i = 0; i < tr.length; i++) {
            if(tr[i].getAttribute("id") != 'trBase' && tr[i].style.display == ""){
                var td = tr[i].getElementsByTagName("td");
                var checkbox = td[td.length - 1].getElementsByTagName("input")[0];
                if(checkbox.checked){
                    percentuais.push(td[2].getElementsByTagName("input")[0].value);
                }
            }
        }
        if( confirm("Após essa ação, "+percentuais.length+" registro(s) serão apagado(s). Deseja continuar?") ){
            var parametro = percentuais.toString();
            window.open('<?= base_url() ?>ambulatorio/procedimentoplano/excluirpercentualmultiplos?&percentual='+parametro, '_blank');
        }
    }
    
    function aplicandoValores(){
        
        var tr = document.getElementById('procedimentos').getElementsByTagName("tr"),
            valor = $("#valorText").val(),
            diaRecebimento = $("#diaRecText").val(),
            tempoRecebimento = $("#tempoRecText").val(),
            revisor = $("#revText option:selected").val(),
            percentual = $("#percText option:selected").val();
        
        for (var i = 0; i < tr.length; i++) {
            if(tr[i].getAttribute("id") != 'trBase' && tr[i].style.display == ""){
                var td = tr[i].getElementsByTagName("td");
                var checkbox = td[td.length - 1].getElementsByTagName("input")[0];
                var id = checkbox.getAttribute("class");
                
                if(valor != "") $("#valor"+id).val(valor);
                if(revisor != "") $("#revisor"+id).val(revisor);
                if(percentual != "") $("#percentual"+id).val(percentual);
                if(diaRecebimento != "") $("#dia_recebimento"+id).val(diaRecebimento);
                if(tempoRecebimento != "") $("#tempo_recebimento"+id).val(tempoRecebimento);
            }
        }
    }
    
    function filtrarTabela() {
        var procedimento = document.getElementById("procedimentoText").value;
        var convenio = document.getElementById("convenioText").value;
        var grupo = document.getElementById("grupoText").value;
        
        var tr = document.getElementById('procedimentos').getElementsByTagName("tr")

        for (var i = 0; i < tr.length; i++) {
            if(tr[i].getAttribute("id") != 'trBase'){
                
                var td = tr[i].getElementsByTagName("td");
                
                var visivelConv = true, visivelGrupo = true;
                
                // Filtro do convenio
                if (convenio == td[0].getAttribute("class") || convenio == '') {
                    tr[i].style.display = "";
                } 
                else {
                    visivelConv = false;
                    tr[i].style.display = "none";
                }
                
                // Filtro do grupo
                if (grupo == td[1].getAttribute("class") || grupo == '') {
                    if (visivelConv) tr[i].style.display = "";
                } 
                else { 
                    visivelGrupo = false;
                    tr[i].style.display = "none";
                }
                
                // Filtro do procedimento
                if (procedimento == td[2].getAttribute("class") || procedimento == '') {
                    if (visivelConv && visivelGrupo) tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                
            }
        }
        
    }
        
</script>