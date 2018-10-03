
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Honorários Médicos</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarpercentualmedicomultiplo" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Médico</label>
                    </dt>
                    <dd>                    
                        <select name="medico" id="medico" class="size4" required="">
                            <option value="">SELECIONE</option>
                            <option value="TODOS">TODOS</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" <? if (@$medico_id == $value->operador_id) echo'selected';?>>
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
                                <td width="50px;">
                                    <select name="procedimentoText" id="procedimentoText" class="size2 chosen-select" tabindex="1" data-placeholder="Procedimento">
                                        <option value="">Selecione</option>
                                        <? foreach ($procedimentoLista as $value) {?>
                                        <option value="<?= $value->procedimento_tuss_id; ?>"><?= $value->codigo . " - " . $value->nome; ?></option>
                                        <? } ?>
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
                                <td>
                                    <select id="subgrupoText" class="size1">
                                        <option value="">Selecione</option>
                                        <? foreach ($subgrupos as $value) {?>
                                        <option value="<?= $value->nome ?>"><?= $value->nome ?></option>
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
                                <td class="tdValorText">
                                    <input type="text" id="valorRevisorText" class="texto01">
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
                                <td>
                                    <button type="button" onclick="limparValores()">Limpar</button>
                                </td>
                            </tr>
                            <tr id="trBase">
                                <td class="tabela_title">Procedimento</td>
                                
                                
                                <td class="tabela_title">Grupo</td>
                                <td class="tabela_title">Subgrupo</td>
                                <td class="tabela_title"></td>
                                
                                <td class="tabela_title">Valor</td>
                                <td class="tabela_title">Percentual</td>
                                <td class="tabela_title">Valor Revisor</td>
                                <td class="tabela_title">Dia Faturamento</td>
                                <td class="tabela_title">Tempo Recebimento</td>
                                <td class="tabela_title">Limpar?</td>
                            </tr>
                            <? 
                            $i = 0;
//                            var_dump($procedimento); die;
                            foreach($procedimento as $item){ ?>
                                <tr class="linhaTabela">
                                    <td style="width: 300px;" colspan="1" class="<?= $item->procedimento_tuss_id ?>">
                                        <input type="hidden" name="procedimento_convenio_id[<?= $i ?>]" value="<?= $item->procedimento_convenio_id ?>"/>
                                        <?= $item->codigo ?> - <?= $item->procedimento ?>
                                    </td>
                                    <td class="<?= $item->grupo ?>"><?= $item->grupo ?></td>
                                    <td class="<?= $item->subgrupo ?>" colspan="2"><?= $item->subgrupo ?></td>
                                    
                                    <td class="tdValor">
                                        <input type="text" name="valor[<?= $i ?>]"  id="valor<?= $i ?>" class="texto01"/>
                                    </td>
                                    <td class="tdPercentual">
                                        <select name="percentual[<?= $i ?>]"  id="percentual<?= $i ?>" class="size1">
                                            <option value="1"> SIM</option>
                                            <option value="0"> NÃO</option>
                                        </select>
                                    </td>
                                    <td class="tdValor">
                                        <input type="text" name="valor_revisor[<?= $i ?>]"  id="valor_revisor<?= $i ?>" class="texto01"/>
                                    </td>
                                    <td class="tdDiaRecebimento">
                                        <input type="text" name="dia_recebimento[<?= $i ?>]" alt="99" id="dia_recebimento<?= $i ?>" class="texto01"/>
                                    </td>
                                    <td class="tdTempoRecebimento">
                                        <input type="text" name="tempo_recebimento[<?= $i ?>]" alt="99" id="tempo_recebimento<?= $i ?>" class="texto01"/>
                                    </td>
                                    <td class="tdLimpar">
                                        <input type="checkbox" name="limparLinha" id="limparLinha<?= $i ?>" class="<?= $i ?>"/>
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

    function limparValores(){
        var tr = document.getElementById('procedimentos').getElementsByTagName("tr");
              
        for (var i = 0; i < tr.length; i++) {
            if(tr[i].getAttribute("id") != 'trBase' && tr[i].style.display == ""){
                var td = tr[i].getElementsByTagName("td");
                var checkbox = td[td.length - 1].getElementsByTagName("input")[0];
                var id = checkbox.getAttribute("id");
                var id_linha = checkbox.getAttribute("class");
                
                var checkbox_limpar = document.getElementById(id);
                if(checkbox_limpar.checked == true){
                    // alert('Teste');
                    $("#valor"+id_linha).val('');
                    $("#valor_revisor"+id_linha).val('');
                    // $("#revisor"+id_linha).val('');
                    $("#percentual"+id_linha).val('');
                    $("#dia_recebimento"+id_linha).val('');
                    $("#tempo_recebimento"+id_linha).val('');

                }else{
                 
                }

                // console.log(id);  

             }
        }
    }
    
    // $(function () {
    //     $('input[name=limparLinha]').change(function () {
    //         var id = $(this).attr('class');
            
    //         $("#valor"+id).val('');
    //         $("#revisor"+id).val('');
    //         $("#percentual"+id).val('');
    //         $("#dia_recebimento"+id).val('');
    //         $("#tempo_recebimento"+id).val('');
            
    //         $(this).removeAttr('checked');
    //     }); 
    // });
    
    $(function () {
        $('#convenio_id').change(function () {
            window.open('<?= base_url() ?>ambulatorio/procedimentoplano/percentualmedicomultiplo/' + $(this).val(), '_self');
        }); 
    });
    
    function aplicandoValores(){
        
        var tr = document.getElementById('procedimentos').getElementsByTagName("tr"),
            valor = $("#valorText").val(),
            diaRecebimento = $("#diaRecText").val(),
            tempoRecebimento = $("#tempoRecText").val(),
            revisor = $("#valorRevisorText").val(),
            percentual = $("#percText option:selected").val();
        
        for (var i = 0; i < tr.length; i++) {
            if(tr[i].getAttribute("id") != 'trBase' && tr[i].style.display == ""){
                var td = tr[i].getElementsByTagName("td");
                var checkbox = td[td.length - 1].getElementsByTagName("input")[0];
                var id = checkbox.getAttribute("class");
                
                if(valor != "") $("#valor"+id).val(valor);
                if(revisor != "") $("#valor_revisor"+id).val(revisor);
                if(percentual != "") $("#percentual"+id).val(percentual);
                if(diaRecebimento != "") $("#dia_recebimento"+id).val(diaRecebimento);
                if(tempoRecebimento != "") $("#tempo_recebimento"+id).val(tempoRecebimento);
            }
        }
    }
    
    function filtrarTabela() {
        var procedimento = document.getElementById("procedimentoText").value;
        var grupo = document.getElementById("grupoText").value;
        var grupo2 = document.getElementById("subgrupoText").value;
        
        var tr = document.getElementById('procedimentos').getElementsByTagName("tr")

        for (var i = 0; i < tr.length; i++) {
            if(tr[i].getAttribute("id") != 'trBase'){
                
                var td = tr[i].getElementsByTagName("td");
                
                var visivelGrupo = true;
                var visivelSubGrupo = true;
                // alert(grupo);
                // console.log(td);
                // alert(td[1].getAttribute("class"));
                // Filtro do grupo
                if (grupo == td[1].getAttribute("class") || grupo == '') {
                    tr[i].style.display = "";
                } 
                else { 
                    visivelGrupo = false;
                    visivelSubGrupo = false;
                    tr[i].style.display = "none";
                }
                
                // Filtro do procedimento
                if (procedimento == td[0].getAttribute("class") || procedimento == '') {
                    if (visivelGrupo) tr[i].style.display = "";
                } else {
                    visivelSubGrupo = false;
                    tr[i].style.display = "none";
                }

                if (grupo2 == td[2].getAttribute("class") || grupo2 == '') {
                    if (visivelSubGrupo) tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                
            }
        }
        
    }
        
</script>