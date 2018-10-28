
<meta charset="UTF-8">

<style>
    .input_grande{
        width: 400px;
    }
    .input_pequeno{
        width: 150px;
    }
    input, label{
        margin-left: 10px;
    }
    legend{
        font-size: 15px;
    }
    #conteudo{
        overflow-y: auto;
    }
</style>
<?
if(count($forma_cadastrada) > 0){
    $valor_restante = $forma_cadastrada[0]->valor_restante;
}else{
    $valor_restante = $exame[0]->valor;
}
// var_dump($forma_cadastrada);



?>
    <div id="conteudo"> <!-- Inicio da DIV content -->
        
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarfaturadomodelo2" method="post">
                <fieldset>
                    <legend>Faturar</legend>
                    <div>
                            <table>
                                <tr>
                                    <td>
                                        <label>Valor Total a Faturar</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="valor_proc" id="valor_proc" class="input_pequeno" value="<?= number_format($exame[0]->valor, 2, ',', '.'); ?>" readonly />
                                        <input type="hidden" name="valorafaturar" id="valorafaturar" class="input_pequeno" value="<?= number_format($valor_restante, 2, ',', '.'); ?>" readonly />
                                        <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" class="texto01" value="<?= $agenda_exames_id; ?>"/>
                                        <input type="hidden" name="guia_id" id="guia_id" class="texto01" value="<?= $guia_id; ?>"/>
                                        <input type="hidden" name="procedimento_convenio_id" id="procedimento_convenio_id" class="texto01" value="<?= $procedimento_convenio_id; ?>"/>
                                    </td>
                                </tr>
                                
                                
                            </table>
                            <br>
                        </div>
                        </fieldset>        

                        <fieldset>        
                        <legend>Adicionar Pagamento</legend>
                        <table>  
                                <tr>
                                    <td>
                                        <label>Desconto</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input step="0.01" type="number" name="desconto" min="0" max="<?=$valor_restante?>" value="0" id="desconto" class="input_pequeno" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Valor</label>
                                    </td>
                                    <td>
                                        <label>Forma de pagamento</label>
                                    </td>
                                    <td>
                                        <label>Ajuste(%)</label>
                                    </td>
                                    <td>
                                        <label>Valor Ajustado</label>
                                    </td>
                                    <td>
                                        <label>Parcelas</label>
                                    </td>
                                </tr>
                                <tr>
                                        <td>
                                            <input required type="number" class="input_pequeno" step="0.01" min=0 max='<?=$valor_restante?>' name="valor1" id="valor1" value="0"  />
                                        </td>
                                        <td>
                                            <select required  name="forma_pagamento_id" id="forma_pagamento_id" class="size2" >
                                                <option value="">Selecione</option>
                                                <? foreach ($forma_pagamento as $item) : ?>
                                                    <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
                                                <? endforeach; ?>
                                            </select>

                                        </td>
                                        <td>
                                            <input readonly type="text" class="input_pequeno" name="ajuste1" id="ajuste1" size="2" value="<?= $valor; ?>"/> 
                                        </td>
                                        <td>
                                            <input readonly type="text" class="input_pequeno" name="valorajuste1" id="valorajuste1" size="2" value="<?= $valor; ?>"/> 
                                        </td>
                                        <td>
                                            <input  style="width: 60px;" class="input_pequeno" type="number" name="parcela1" id="parcela1"  value="1" min="1" /> 
                                        </td>

                                </tr>
                                <tr>
                                        <td>
                                            <label>Valor Pendente</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text"  name="valorFaturarVisivel" id="valorFaturarVisivel" class="input_pequeno" value="<?= number_format($valor_restante, 2, ',', '.'); ?>" readonly />
                                            
                                        </td>
                                    </tr>  
                                <tr>
                                    <td>
                                        <?
                                        // Ele não deixa adicionar mais formas se o valor for igual a zero.
                                        // Caso o valor seja zero, ele só vê se já tem alguma forma cadastrada, senão, ele deixa cadastrar
                                        // já que existem procedimentos do tipo retorno e etc que não contam no caixa.
                                        // Mas pra todos os efeitos, não é necessário faturar.
                                        ?>
                                      
                                    <?if($valor_restante > 0 || count(@$forma_cadastrada) == 0){?>
                                        <button type="submit" name="btnEnviar" id="btnEnviar" >
                                            Adicionar
                                        </button>
                                     <?}else{?>
                                        <button disabled type="submit" name="btnEnviar" id="btnEnviar" >
                                            Faturado
                                        </button>
                                     <?}?>
                                    </td>
                                </tr>

                        </table>
                        <!-- <table>
                            <tr>
                                <td>
                                    <label>Observa&ccedil;&atilde;o</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <textarea type="text" id="observacao" name="observacao" class="texto"  value="" cols="50" rows="4"></textarea>  
                                </td>
                            </tr>
                        </table> -->
                    
                        
                </fieldset>    
                <fieldset>
                    <?
                    $desconto_total = 0;
                    if (count(@$forma_cadastrada) > 0) {
                        ?>
                        <table id="table_agente_toxico" border="0">
                            <thead>

                                <tr>
                                    <th class="tabela_header">Valor</th>
                                    <th class="tabela_header">Valor Ajustado</th>
                                    <th class="tabela_header">Forma de Pag.</th>
                                    <th class="tabela_header">Ajuste</th>
                                    <th class="tabela_header">Desconto</th>
                                    <th class="tabela_header">Parcelas</th>
                                    <!-- <th class="tabela_header">Data</th> -->
                                    <th class="tabela_header">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $estilo_linha = "tabela_content01";
                                $y = 0;
                                $data_for = '';
                                $total_pago = 0;
                                foreach ($forma_cadastrada as $item) {
                                    $total_pago+= $item->valor;
                                    $desconto_total += $item->desconto;
                                    if($item->data != $data_for){?>
                                        <tr>
                                            <th class="tabela_header" colspan="8"><?= date("d/m/Y", strtotime($item->data)); ?></th>
                                            
                                        </tr>
                                    <?}
                                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                    ?>

                                    <tr>
                                        <td class="<?php echo $estilo_linha; ?>" width="120px;"><center>R$ <?=number_format($item->valor_bruto, 2, ',', '.'); ?></center></td>
                                        <td class="<?php echo $estilo_linha; ?>" width="120px;"><center>R$ <?=number_format($item->valor, 2, ',', '.'); ?></center></td>
                                        <td class="<?php echo $estilo_linha; ?>" style="min-width: 300px;"><center><? echo $item->forma_pagamento; ?></center></td>
                                        <td class="<?php echo $estilo_linha; ?>" width="120px;"><center><?=$item->ajuste . "%"; ?></center></td>
                                        <td class="<?php echo $estilo_linha; ?>" width="120px;"><center>R$ <?=number_format($item->desconto, 2, ',', '.'); ?></center></td>
                                        <td class="<?php echo $estilo_linha; ?>"><center><? echo $item->parcela; ?></center></td>
                                        <!-- <td class="<?php echo $estilo_linha; ?>"><center><?= date("d/m/Y", strtotime($item->data)); ?></center></td> -->
                                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                        <?$perfil_id = $this->session->userdata('perfil_id');?>
                                        <?$operador_id = $this->session->userdata('operador_id');?>
                                        <?if(($perfil_id == 1 && $item->financeiro == 'f')){?> 
                                            <a onclick="javascript:return confirm('Deseja realmente excluir o pagamento?');" href="<?= base_url() ?>ambulatorio/guia/apagarfaturarmodelo2/<?= $item->agenda_exames_faturar_id; ?>/<?= $agenda_exames_id?>/<?= $procedimento_convenio_id?>/<?=$guia_id?>" class="delete">
                                            </a>
                                        <?}?>    
                                        </td>
                                    </tr>


                                <?
                                $data_for = $item->data;
                            }
                            ?>
                            <tr>
                                <th class="tabela_header" colspan="7">Total Pago: <?=number_format($total_pago,2,',', '.')?> | Desconto: <?=number_format($desconto_total,2,',', '.')?></th>
                                
                            </tr>
                            </tbody>
                            <?
                        }
                        ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="5">
                                </th>
                            </tr>
                        </tfoot>
                    </table> 
                </fieldset>                    
            </form>
            
        
    </div> <!-- Final da DIV content -->
</body>
<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<?php
$this->load->library('utilitario');
// var_dump($this->session->flashdata('message'));die;
Utilitario::pmf_mensagem($this->session->flashdata('message'));
?>
<script type="text/javascript">
         $(function () {
            $('#desconto').change(function () {
                // alert('asdasd');
                descontoFuncao();
            });
        });

        function descontoFuncao(){
            // alert('asdasd');
                desconto = parseFloat(document.form_faturar.desconto.value.replace(",", "."));
                restante = parseFloat(document.form_faturar.valorafaturar.value.replace(",", "."));
                valor_max = restante - desconto;      
                if(valor_max < 0){
                    valor_max = 0;
                }
                $('#valor1').prop("max", valor_max);
                $('#valorFaturarVisivel').val(valor_max);
                return true;
        }
        descontoFuncao();
            
        $(function () {
            $('#forma_pagamento_id').change(function () {

                if (this.value == 1000) {
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 1) {
                            continue;
                        }
                        if ($('#formapamento' + i).val() == 1000) {
                            selecionado = true;
                        }
                    }

                    if (!selecionado) {
                        $('#valor1').val('0');
                  
                        var valorDiferenca = $('#valortotal').val();

                        $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {
                            if (parseFloat(j.saldo) >= parseFloat(valorDiferenca)) {
                                $('#valor1').val(valorDiferenca);
                            } else {
                                $('#valor1').val(j.saldo);
                            }
                            $('#valorcredito').val($('#valor1').val());


                            $('#paciente_id').val(j.paciente_id);
                            $('#valor1').attr("readonly", 'true');

                            
                        });
                    } else {
                        $('#forma_pagamento_id').val('');
                    }
                } else {
                    $('#valor1').removeAttr("readonly");
                    
                }

                if ($(this).val()) {
                    forma_pagamento_id = document.getElementById("forma_pagamento_id").value;
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/formapagamento/' + forma_pagamento_id + '/', {forma_pagamento_id: $(this).val(), ajax: true}, function (j) {
                        options = "";
                        parcelas = "";
                        options = j[0].ajuste;
                        parcelas = j[0].parcelas;
                        numer_1 = parseFloat(document.form_faturar.valor1.value.replace(",", "."));
                        // alert(numer_1);
                        if (j[0].parcelas != null) {
                            document.getElementById("parcela1").max = parcelas;
                        } else {
                            document.getElementById("parcela1").max = '1';
                        }
                        if (j[0].ajuste != null) {
                            document.getElementById("ajuste1").value = options;
                            valorajuste1 = (numer_1 * options) / 100;
                            pg1 = numer_1 + valorajuste1;
                            document.getElementById("valorajuste1").value = pg1;
//                                                        document.getElementById("desconto1").type = 'text';
//                                                        document.getElementById("valordesconto1").type = 'text';
                        } else {
                            document.getElementById("ajuste1").value = '0';
                            document.getElementById("valorajuste1").value = '0';

                        }
                        $('.carregando').hide();
                    });
                } else {
                    $('#ajuste1').html('value=""');
                }
            });
        });
        $(function () {
            $('#valor1').change(function () {
                // console.log($('#forma_pagamento_id').val());
                if ($('#forma_pagamento_id').val() == 1000) {
                    var selecionado = false;

                    for (var i = 1; i < 5; i++) {
                        if (i == 1) {
                            continue;
                        }
                        if ($('#formapamento' + i).val() == 1000) {
                            selecionado = true;
                        }
                    }

                    if (!selecionado) {
                        $('#valor1').val('0');
                  
                        var valorDiferenca = $('#valortotal').val();

                        $.getJSON('<?= base_url() ?>autocomplete/buscarsaldopaciente', {guia_id: <?= $guia_id ?>, ajax: true}, function (j) {
                            if (parseFloat(j.saldo) >= parseFloat(valorDiferenca)) {
                                $('#valor1').val(valorDiferenca);
                            } else {
                                $('#valor1').val(j.saldo);
                            }
                            $('#valorcredito').val($('#valor1').val());


                            $('#paciente_id').val(j.paciente_id);
                            $('#valor1').attr("readonly", 'true');

                            
                        });
                    } else {
                        $('#forma_pagamento_id').val('');
                    }
                } else {
                    $('#valor1').removeAttr("readonly");
                    
                }

                if ($('#forma_pagamento_id').val() && $('#valor1').val() != '') {
                    forma_pagamento_id = document.getElementById("forma_pagamento_id").value;
                    $('.carregando').show();
                    $.getJSON('<?= base_url() ?>autocomplete/formapagamento/' + forma_pagamento_id + '/', {forma_pagamento_id: $('#forma_pagamento_id').val(), ajax: true}, function (j) {
                        options = "";
                        parcelas = "";
                        options = j[0].ajuste;
                        parcelas = j[0].parcelas;
                        numer_1 = parseFloat(document.form_faturar.valor1.value.replace(",", "."));
                        console.log(numer_1);
                        if (j[0].parcelas != null) {
                            document.getElementById("parcela1").max = parcelas;
                        } else {
                            document.getElementById("parcela1").max = '1';
                        }
                        if (j[0].ajuste != null) {
                            document.getElementById("ajuste1").value = options;
                            valorajuste1 = (numer_1 * options) / 100;
                            pg1 = numer_1 + valorajuste1;
                            valor_ajuste = parseFloat(pg1.toFixed(2));
                            document.getElementById("valorajuste1").value = valor_ajuste;
                            console.log(valor_ajuste);
//                                                        document.getElementById("desconto1").type = 'text';
//                                                        document.getElementById("valordesconto1").type = 'text';
                        } else {
                            document.getElementById("ajuste1").value = '0';
                            document.getElementById("valorajuste1").value = '0';

                        }
                        $('.carregando').hide();
                    });
                } else {
                    $('#ajuste1').html('value=""');
                }
            });
        });

</script>