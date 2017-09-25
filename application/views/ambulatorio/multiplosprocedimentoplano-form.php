
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
                        <select name="convenio" id="convenio" class="size4">
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
                        <div style="float: right; margin-bottom: 20pt;">
                            <input type="text" id="procText" onkeypress="filtrarTabela()" placeholder="Pesquisar texto..." title="Pesquise pelo nome do procedimento ou pelo codigo">
                            <select id="grupoText">
                                    <option value="">TODOS</option>
                                <? foreach ($grupos as $value) {?>
                                    <option value="<?= $value->nome ?>"><?= $value->nome ?></option>
                                <? } ?>
                            </select>
                            <button type="button" onclick="filtrarTabela()">Buscar</button>
                        </div>
                        <table id="procedimentos">
                            <thead>
                                <th class="tabela_title">Procedimento</th>
                                <th class="tabela_title">Grupo</th>
                                <th class="tabela_title">Qtde CH</th>
                                <th class="tabela_title">Valor CH</th>
                                <th class="tabela_title">Qtde Filme</th>
                                <th class="tabela_title">Valor Filme</th>
                                <th class="tabela_title">Qtde Porte</th>
                                <th class="tabela_title">Valor Porte</th>
                                <th class="tabela_title">Qtde UCO</th>
                                <th class="tabela_title">Valor UCO</th>
                                <th class="tabela_title">Valor TOTAL</th>
                            </thead>
<!--                        </table>        
                        <table>        -->
                            <tbody>
                            <? 
                            $i = 0;
                            foreach($procedimento as $item){ ?>
                                <tr class="linhaTabela" id="<?= $item->grupo ?>">
                                    <td>
                                        <input type="hidden" name="procedimento_id[<?= $i ?>]" value="<?= $item->procedimento_tuss_id ?>"/>
                                        <?= $item->codigo ?> - <?= $item->nome ?>
                                    </td>
                                    <td><?= $item->grupo ?></td>
                                    <td><input type="text" name="qtdech[<?= $i ?>]"  id="qtdech<?= $i ?>" class="texto01" value="0"/></td>
                                    <td><input type="text" name="valorch[<?= $i ?>]"  id="valorch<?= $i ?>" class="texto01" value="0"/></td>
                                    <td><input type="text" name="qtdefilme[<?= $i ?>]"  id="qtdefilme<?= $i ?>" class="texto01" value="0"/></td>
                                    <td><input type="text" name="valorfilme[<?= $i ?>]"  id="valorfilme<?= $i ?>" class="texto01" value="0"/></td>
                                    <td><input type="text" name="qtdeporte[<?= $i ?>]"  id="qtdeporte<?= $i ?>" class="texto01" value="0"/></td>
                                    <td><input type="text" name="valorporte[<?= $i ?>]"  id="valorporte<?= $i ?>" class="texto01" value="0"/></td>
                                    <td><input type="text" name="qtdeuco[<?= $i ?>]"  id="qtdeuco<?= $i ?>" class="texto01" value="0"/></td>
                                    <td><input type="text" name="valoruco[<?= $i ?>]"  id="valoruco<?= $i ?>" class="texto01" value="0"/></td>
                                    <td><input type="text" name="valortotal[<?= $i ?>]"  id="valortotal<?= $i ?>" class="texto01"/></td>
                                </tr>
                            <? 
                            $i++;
                            } ?>
                            </tbody>
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
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.quicksearch.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    
    function filtrarTabela() {
//        procText
//grupoText
        
        var input, procedimento, select, grupo, table, tr, td, i;
        input = document.getElementById("procText");
        procedimento = input.value.toUpperCase();
        
        select = document.getElementById("grupoText");
//        select.selectedIndex        
        grupo = select.options[select.selectedIndex].value.toUpperCase();
        
        table = document.getElementById("procedimentos");
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

    $(function () {
        $("#accordion").accordion();
    });

//                            $(document).ready(function () {

//                            function multiplica()
//                            {
//                                total = 0;
//                                numer1 = parseFloat(document.form_procedimentoplano.qtdech.value);
//                                numer2 = parseFloat(document.form_procedimentoplano.valorch.value);
//                                soma = numer1 * numer2;
//                                numer3 = parseFloat(document.form_procedimentoplano.qtdefilme.value);
//                                numer4 = parseFloat(document.form_procedimentoplano.valorfilme.value);
//                                soma2 = numer3 * numer4;
//                                numer5 = parseFloat(document.form_procedimentoplano.qtdeuco.value);
//                                numer6 = parseFloat(document.form_procedimentoplano.valoruco.value);
//                                soma3 = numer5 * numer6;
//                                numer7 = parseFloat(document.form_procedimentoplano.qtdeporte.value);
//                                numer8 = parseFloat(document.form_procedimentoplano.valorporte.value);
//                                soma4 = numer7 * numer8;
//                                total += soma + soma2 + soma3 + soma4;
//                                y = total.toFixed(2);
//                                $('#valortotal').val(y);
//                                //document.form_procedimentoplano.valortotal.value = total;
//                            }
//                            multiplica();


//                            });

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
</script>