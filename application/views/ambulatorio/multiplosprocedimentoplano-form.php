
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimentoplano">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de valor Procedimento</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarmultiplos" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Convenio *</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="teste_conv_secundario" id="conv_secundario"  value="f" />
                        <select name="convenio" id="convenio" class="size4" required="">
                            <option value="">Selecione</option>
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>"<?
                                if (@$obj->_convenio_id == $value->convenio_id):echo'selected';
                                endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Empresa *</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size4">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>"<?
                                if (@$obj->_empresa_id == $value->empresa_id):echo'selected';
                                endif;
                                ?>><?php echo $value->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    
                    <br>
                    
                    <div class="divTabela">
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
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js" ></script>
<script type="text/javascript">   
    
    var totResultados = <?= count($procedimento) ?>;  
    
    $(function () {
        $("#selTodos").live('click', function () {
            if ($(this).attr('class') == 'marcaTodos') {
                $(this).attr('class', 'desmarcaTodos');
                for (var n = 0; n < totResultados; n++) {
                    $('.checkbox').attr('checked', true);
                }
            }
            else{
                $(this).attr('class', 'marcaTodos');
                for (var n = 0; n < totResultados; n++) {
                    $('.checkbox').removeAttr('checked');
                }
            }
        });
    });
    
    
    var divPesquisa = '<div style="float: right; margin-bottom: 20pt;"><input type="text" id="procText" onkeypress="filtrarTabela()" placeholder="Pesquisar texto..." title="Pesquise pelo nome do procedimento ou pelo codigo"><select id="grupoText"><option value="">TODOS</option>';
    <? foreach ($grupos as $value) {?>
        divPesquisa +='<option value="<?= $value->nome ?>"><?= $value->nome ?></option>';
    <? } ?>
    divPesquisa += '</select><button type="button" onclick="filtrarTabela()">Buscar</button></div>';
    
    var tabelaPadrao = '<table id="procedimentos"><thead><th class="tabela_title">Procedimento</th><th class="tabela_title">Grupo</th><th class="tabela_title valor">Qtde CH</th><th class="tabela_title valor">Valor CH</th><th class="tabela_title valor">Qtde Filme</th>';
    tabelaPadrao += '<th class="tabela_title valor">Valor Filme</th><th class="tabela_title valor">Qtde Porte</th><th class="tabela_title valor">Valor Porte</th><th class="tabela_title valor">Qtde UCO</th><th class="tabela_title valor">Valor UCO</th><th class="tabela_title valor">Valor TOTAL</th>';
    tabelaPadrao += '</thead><tbody>';
    
    <? $i = 0;
    foreach($procedimento as $item){ ?>
        tabelaPadrao += '<tr class="linhaTabela" id="<?= $item->grupo ?>"><td><input type="hidden" name="procedimento_id[<?= $i ?>]" value="<?= $item->procedimento_tuss_id ?>"/><?= $item->codigo ?> - <?= $item->nome ?></td>';
        tabelaPadrao += '<td><?= $item->grupo ?></td><td class="valor"><input type="text" name="qtdech[<?= $i ?>]"  id="qtdech<?= $i ?>" class="texto01" value="0"/></td><td class="valor"><input type="text" name="valorch[<?= $i ?>]"  id="valorch<?= $i ?>" class="texto01" value="0"/></td>';
        tabelaPadrao += '<td class="valor"><input type="text" name="qtdefilme[<?= $i ?>]"  id="qtdefilme<?= $i ?>" class="texto01" value="0"/></td><td class="valor"><input type="text" name="valorfilme[<?= $i ?>]"  id="valorfilme<?= $i ?>" class="texto01" value="0"/></td>';
        tabelaPadrao += '<td class="valor"><input type="text" name="qtdeporte[<?= $i ?>]"  id="qtdeporte<?= $i ?>" class="texto01" value="0"/></td><td class="valor"><input type="text" name="valorporte[<?= $i ?>]"  id="valorporte<?= $i ?>" class="texto01" value="0"/></td>';
        tabelaPadrao += '<td class="valor"><input type="text" name="qtdeuco[<?= $i ?>]"  id="qtdeuco<?= $i ?>" class="texto01" value="0"/></td><td class="valor"><input type="text" name="valoruco[<?= $i ?>]"  id="valoruco<?= $i ?>" class="texto01" value="0"/>';
        tabelaPadrao += '</td><td class="valor"><input type="text" name="valortotal[<?= $i ?>]"  id="valortotal<?= $i ?>" class="texto01"/></td></tr>';
        
        <? $i++;
    } ?>
    tabelaPadrao += '</tbody></table>';
    
    
    if($("#conv_secundario").val() == 'f'){
        $("td.add_conv_sec").hide();
        $("th.add_conv_sec").hide(); 
        $(".divTabela").append("<div class='base'>"+divPesquisa+tabelaPadrao+"</div>");
    }    
    
    $(function () {
        $("#accordion").accordion();
    });
    
    $(function () {
        $('#convenio').change(function () {
            $.getJSON('<?= base_url() ?>autocomplete/buscarconveniosecundario', {convenio: $(this).val(), ajax: true}, function (j) {
                if(j[0].associado == 't'){                        
                    $("#conv_secundario").val('t');
                    $("td.valor").hide();
                    $("th.valor").hide();
                    $("td.add_conv_sec").show();
                    $("th.add_conv_sec").show();
                    $(".divTabela div.base").remove();
                    $.getJSON('<?= base_url() ?>autocomplete/buscarprocedimentoconveniosecundario', {convenio: $('#convenio').val(), ajax: true}, function (p) {

                        var tableProcConvSec = '<table id="tableProcConvSec"><thead><th class="tabela_title">Procedimento</th><th class="tabela_title">Grupo</th>';
                        tableProcConvSec += '<th class="tabela_title add_conv_sec">Adcionar</th><th class="tabela_title add_conv_sec"><a href="#" id="selTodos" class="marcaTodos">Selecionar Todos?</a></th></thead>';
                        for (var i = 0; i < p.length; i++) {
                            tableProcConvSec += '<tr class="linhaTabela" id="' + p[i].grupo + '">';
                            tableProcConvSec += '<td><input type="hidden" name="procedimento_id['+ i +']" value="'+ p[i].procedimento_tuss_id +'"/>' + p[i].codigo + ' - ' + p[i].nome + '</td>';
                            tableProcConvSec += '<td>' + p[i].grupo + '</td>';
                            tableProcConvSec += '<td class="add_conv_sec"><input type="checkbox" name="add_conv_sec['+ i +']"  id="add_conv_sec'+ i +'" class="checkbox" colspan="2"/></td></tr>';
                        }
                        tableProcConvSec += '</tbody></table>';
                        
                        totResultados = p.length;
                        
                        $(".divTabela").append("<div class='base'>"+divPesquisa+tableProcConvSec+"</div>");
                    });
                }
                else{                        
                    $("#conv_secundario").val('f'); 
                    $("td.valor").show();
                    $("th.valor").show();
                    $("td.add_conv_sec").hide();
                    $("th.add_conv_sec").hide();
                    $(".divTabela div.base").remove();
                    totResultados = <?= count($procedimento) ?>;  
                    $(".divTabela").append("<div class='base'>"+divPesquisa+tabelaPadrao+"</div>");
                }
            });
        }); 
    });
    
    <? for ($i = 0; $i < count($procedimento); $i++) {?>
        $(function () {
            $('#qtdech<?=$i?>').change(function () {
                valorch = parseFloat($('#qtdech<?=$i?>').val()) * parseFloat($('#valorch<?=$i?>').val());
                valorfilme = parseFloat($('#qtdefilme<?=$i?>').val()) * parseFloat($('#valorfilme<?=$i?>').val());
                valoruco = parseFloat($('#qtdeuco<?=$i?>').val()) * parseFloat($('#valoruco<?=$i?>').val());
                valorporte = parseFloat($('#qtdeporte<?=$i?>').val()) * parseFloat($('#valorporte<?=$i?>').val());
                valortotal = valoruco + valorfilme + valorporte + valorch;
                $('#valortotal<?=$i?>').val(valortotal);
            });
            $('#qtdefilme<?=$i?>').change(function () {
                valorch = parseFloat($('#qtdech<?=$i?>').val()) * parseFloat($('#valorch<?=$i?>').val());
                valorfilme = parseFloat($('#qtdefilme<?=$i?>').val()) * parseFloat($('#valorfilme<?=$i?>').val());
                valoruco = parseFloat($('#qtdeuco<?=$i?>').val()) * parseFloat($('#valoruco<?=$i?>').val());
                valorporte = parseFloat($('#qtdeporte<?=$i?>').val()) * parseFloat($('#valorporte<?=$i?>').val());
                valortotal = valoruco + valorfilme + valorporte + valorch;
    //                                    alert(valortotal);
                $('#valortotal<?=$i?>').val(valortotal);
            });
            $('#qtdeuco<?=$i?>').change(function () {
                valorch = parseFloat($('#qtdech<?=$i?>').val()) * parseFloat($('#valorch<?=$i?>').val());
                valorfilme = parseFloat($('#qtdefilme<?=$i?>').val()) * parseFloat($('#valorfilme<?=$i?>').val());
                valoruco = parseFloat($('#qtdeuco<?=$i?>').val()) * parseFloat($('#valoruco<?=$i?>').val());
                valorporte = parseFloat($('#qtdeporte<?=$i?>').val()) * parseFloat($('#valorporte<?=$i?>').val());
                valortotal = valoruco + valorfilme + valorporte + valorch;
    //                                    alert(valortotal);
                $('#valortotal<?=$i?>').val(valortotal);
            });
            $('#qtdeporte<?=$i?>').change(function () {
                valorch = parseFloat($('#qtdech<?=$i?>').val()) * parseFloat($('#valorch<?=$i?>').val());
                valorfilme = parseFloat($('#qtdefilme<?=$i?>').val()) * parseFloat($('#valorfilme<?=$i?>').val());
                valoruco = parseFloat($('#qtdeuco<?=$i?>').val()) * parseFloat($('#valoruco<?=$i?>').val());
                valorporte = parseFloat($('#qtdeporte<?=$i?>').val()) * parseFloat($('#valorporte<?=$i?>').val());
                valortotal = valoruco + valorfilme + valorporte + valorch;
    //                                    alert(valortotal);
                $('#valortotal<?=$i?>').val(valortotal);
            });
            $('#valorch<?=$i?>').change(function () {
                valorch = parseFloat($('#qtdech<?=$i?>').val()) * parseFloat($('#valorch<?=$i?>').val());
                valorfilme = parseFloat($('#qtdefilme<?=$i?>').val()) * parseFloat($('#valorfilme<?=$i?>').val());
                valoruco = parseFloat($('#qtdeuco<?=$i?>').val()) * parseFloat($('#valoruco<?=$i?>').val());
                valorporte = parseFloat($('#qtdeporte<?=$i?>').val()) * parseFloat($('#valorporte<?=$i?>').val());
                valortotal = valoruco + valorfilme + valorporte + valorch;
    //                                    alert(valortotal);
                $('#valortotal<?=$i?>').val(valortotal);
            });
            $('#valorfilme<?=$i?>').change(function () {
                valorch = parseFloat($('#qtdech<?=$i?>').val()) * parseFloat($('#valorch<?=$i?>').val());
                valorfilme = parseFloat($('#qtdefilme<?=$i?>').val()) * parseFloat($('#valorfilme<?=$i?>').val());
                valoruco = parseFloat($('#qtdeuco<?=$i?>').val()) * parseFloat($('#valoruco<?=$i?>').val());
                valorporte = parseFloat($('#qtdeporte<?=$i?>').val()) * parseFloat($('#valorporte<?=$i?>').val());
                valortotal = valoruco + valorfilme + valorporte + valorch;
    //                                    alert(valortotal);
                $('#valortotal<?=$i?>').val(valortotal);
            });
            $('#valoruco<?=$i?>').change(function () {
                valorch = parseFloat($('#qtdech<?=$i?>').val()) * parseFloat($('#valorch<?=$i?>').val());
                valorfilme = parseFloat($('#qtdefilme<?=$i?>').val()) * parseFloat($('#valorfilme<?=$i?>').val());
                valoruco = parseFloat($('#qtdeuco<?=$i?>').val()) * parseFloat($('#valoruco<?=$i?>').val());
                valorporte = parseFloat($('#qtdeporte<?=$i?>').val()) * parseFloat($('#valorporte<?=$i?>').val());
                valortotal = valoruco + valorfilme + valorporte + valorch;
    //                                    alert(valortotal);
                $('#valortotal<?=$i?>').val(valortotal);
            });
            $('#valorporte<?=$i?>').change(function () {
                valorch = parseFloat($('#qtdech<?=$i?>').val()) * parseFloat($('#valorch<?=$i?>').val());
                valorfilme = parseFloat($('#qtdefilme<?=$i?>').val()) * parseFloat($('#valorfilme<?=$i?>').val());
                valoruco = parseFloat($('#qtdeuco<?=$i?>').val()) * parseFloat($('#valoruco<?=$i?>').val());
                valorporte = parseFloat($('#qtdeporte<?=$i?>').val()) * parseFloat($('#valorporte<?=$i?>').val());
                valortotal = valoruco + valorfilme + valorporte + valorch;
    //                                    alert(valortotal);
                $('#valortotal<?=$i?>').val(valortotal);
            });
            $('#qtdech<?=$i?>').change(function () {
                valorch = parseFloat($('#qtdech<?=$i?>').val()) * parseFloat($('#valorch<?=$i?>').val());
                valorfilme = parseFloat($('#qtdefilme<?=$i?>').val()) * parseFloat($('#valorfilme<?=$i?>').val());
                valoruco = parseFloat($('#qtdeuco<?=$i?>').val()) * parseFloat($('#valoruco<?=$i?>').val());
                valorporte = parseFloat($('#qtdeporte<?=$i?>').val()) * parseFloat($('#valorporte<?=$i?>').val());
                valortotal = valoruco + valorfilme + valorporte + valorch;
    //                                    alert(valortotal);
                $('#valortotal<?=$i?>').val(valortotal);
            });

        });
    <? } ?>


    function filtrarTabela() {        
        var input, procedimento, select, grupo, table, tr, td, i;
        input = document.getElementById("procText");
        procedimento = input.value.toUpperCase();
        
        select = document.getElementById("grupoText");
//        select.selectedIndex        
        grupo = select.options[select.selectedIndex].value.toUpperCase();
        
        var id = ($("#conv_secundario").val() == 'f') ? 'procedimentos' : 'tableProcConvSec';
        table = document.getElementById(id);
        tr = table.getElementsByTagName("tr");
        
        if (grupo == "" && procedimento != "") { // CASO TENHA INFORMADO SOMENTE PROCEDIMENTO
//            alert('1');
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(procedimento) > -1) {
                      tr[i].style.display = "";
                    } else {
                      tr[i].style.display = "none";
                    }
                }       
            }
        }
        else if (grupo != "" && procedimento == "") { // CASO TENHA INFORMADO APENAS O GRUPO
//            alert('2');
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    var id = tr[i].getAttribute("id");
                    if (grupo == id) {
                      tr[i].style.display = "";
                    } else {
                      tr[i].style.display = "none";
                    }
                } 
            }       
        }
        else if (grupo != "" && procedimento != "") { // CASO TENHA INFORMADO O GRUPO E O PROCEDIMENTO
//            alert('3');
            for (i = 0; i < tr.length; i++) {
                
                td = tr[i].getElementsByTagName("td")[0];
                var id = tr[i].getAttribute("id");
                
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(procedimento) > -1 && grupo == id) {
                      tr[i].style.display = "";
                    } else {
                      tr[i].style.display = "none";
                    }
                }       
            }
        }
        else{
//            console.log(grupo);
//            alert(grupo);
            for (i = 0; i < tr.length; i++) {
                tr[i].style.display = "";
            }
        }
        
//        $("#accordion").accordion();
        
    }
        
</script>