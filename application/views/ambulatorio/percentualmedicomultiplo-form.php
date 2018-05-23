
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
                        <label>Convenio *</label>
                    </dt>
                    <dd>
                        <select name="covenio" id="covenio" class="size4" required="">
                            <option value="">Selecione</option>
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>"<? if (@$convenio_id == $value->convenio_id) echo'selected';?>>
                                    <?php echo $value->nome; ?>
                                </option>
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
    
    
    $(function () {
        $("#accordion").accordion();
    });
    
    $(function () {
        $('#covenio').change(function () {
//            alert('teste');
            window.open('<?= base_url() ?>ambulatorio/procedimentoplano/percentualmedicomultiplo/'+$('#covenio').val()+"/"+$('#medico').val(), '_self');
        }); 
    });
    
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
    
    function filtrarTabela() {        
        var input, procedimento, select, grupo, table, tr, td, i;
        input = document.getElementById("procText");
        procedimento = input.value.toUpperCase();
        
        select = document.getElementById("grupoText");
//        select.selectedIndex        
        grupo = select.options[select.selectedIndex].value.toUpperCase();
        
        var id = 'procedimentos';
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
        
    }
    
    var divPesquisa = '<div style="float: right; margin-bottom: 20pt;"><input type="text" id="procText" onkeypress="filtrarTabela()" placeholder="Pesquisar texto..." title="Pesquise pelo nome do procedimento ou pelo codigo"><select id="grupoText"><option value="">TODOS</option>';
    <? foreach ($grupos as $value) {?>
        divPesquisa +='<option value="<?= $value->nome ?>"><?= $value->nome ?></option>';
    <? } ?>
    divPesquisa += '</select><button type="button" onclick="filtrarTabela()">Buscar</button></div>';
    
    var tabelaPadrao = '<table id="procedimentos">\n\
                            <thead>\n\
                                <th class="tabela_title">Procedimento</th>\n\
                                <th class="tabela_title">Grupo</th>\n\
                                <th class="tabela_title valor">Valor</th>\n\
                                <th class="tabela_title valor">Percentual</th>\n\
                                <th class="tabela_title valor">Revisor</th>\n\
                                <th class="tabela_title valor">Dia Faturamento</th>\n\
                                <th class="tabela_title valor">Tempo Recebimento</th>\n\
                            </thead>\n\
                        <tbody>';
    
    <? $i = 0;
    foreach($procedimento as $item){ ?>
        tabelaPadrao += '<tr class="linhaTabela" id="<?= $item->grupo ?>">\n\
                            <td><input type="hidden" name="procedimento_convenio_id[<?= $i ?>]" value="<?= $item->procedimento_convenio_id ?>"/><?= $item->codigo ?> - <?= $item->procedimento ?></td>\n\
                            <td><?= $item->grupo ?></td>\n\
                            <td class="valor"><input type="text" name="valor[<?= $i ?>]"  id="valor<?= $i ?>" class="texto01" value=""/></td>\n\
                            <td>\n\
                                <select name="percentual[<?= $i ?>]"  id="percentual<?= $i ?>" class="size1">\n\
                                    <option value="1"> SIM</option>\n\
                                    <option value="0"> NÃO</option>\n\
                                </select>\n\
                            </td>\n\
                            <td>\n\
                                <select name="revisor[<?= $i ?>]"  id="revisor<?= $i ?>" class="size1">\n\
                                    <option value="1"> SIM</option>\n\
                                    <option value="0"> NÃO</option>\n\
                                </select>\n\
                            </td>\n\
                            <td class="valor"><input type="text" name="dia_recebimento[<?= $i ?>]" alt="99" id="dia_recebimento<?= $i ?>" class="texto01"/></td>\n\
                            <td class="valor"><input type="text" name="tempo_recebimento[<?= $i ?>]" alt="99" id="tempo_recebimento<?= $i ?>" class="texto01"/></td>\n\
                         </tr>';
        
        <? $i++;
    } ?>
    tabelaPadrao += '</tbody></table>';
    $(".divTabela").append("<div class='base'>"+divPesquisa+tabelaPadrao+"</div>");
        
</script>