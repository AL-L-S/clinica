<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>farmacia/saida/gravarsaidapaciente/<?= $internacao_id ?>" method="post">
        <fieldset>
            <legend>Saída por paciente farmácia</legend>
            <div>
                <label>Nome</label>
                <!--<input type="hidden" name="txtfarmacia_solicitacao_id" value="<?php echo $farmacia_solicitacao_id; ?>"/>-->
                <!--<input type="hidden" name="txtfarmacia_solicitacao_itens_id" value="<?php echo $farmacia_solicitacao_itens_id; ?>"/>-->
                <input type="text" name="txtNome" class="texto10" value="<?= $lista[0]->paciente ?>" readonly />
            </div>
        </fieldset>
        <fieldset>
            <?
            ?>
            <table id="table_agente_toxico" border="0">
                <thead>

                    <tr>
                        <th class="tabela_header">Produto</th>
                        <th class="tabela_header">Solicitado</th>
                        <th class="tabela_header">Qtde</th>
                        <th class="tabela_header">Entrada</th>
                    </tr>
                </thead>
                <?
                $estilo_linha = "tabela_content01";
                $contador = 0;
                foreach ($lista as $item) {
//                    echo $item->internacao_prescricao_id;
                    $produto = $this->saida->listarprodutositemfarmacia($item->farmacia_produto_id);
                    $saida = $this->saida->listarprodutositemfarmaciasaida($item->internacao_prescricao_id);
//                    var_dump($saida); die;
                    if ($item->aprasamento == 1) {
                        $quantidade_solicitada = 1 * $item->dias;
                    } else {
                        $quantidade_solicitada = (int) (24 / $item->aprasamento) * $item->dias;
                    }

                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tbody>
                        <tr>
                            <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>-->
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $quantidade_solicitada; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><input type="number" name="qtde[<?= $contador ?>]" id='qtde<?= $contador ?>' min="0" max="<?= $quantidade_solicitada ?>" class="texto02"/></td>
                    <input type="hidden" name="produto_id[<?= $contador ?>]" id='produto_id<?= $contador ?>' class="texto02"  value="<?= $item->farmacia_produto_id; ?>"/>
                    <input type="hidden" name="internacao_prescricao_id[<?= $contador ?>]" id='internacao_prescricao_id<?= $contador ?>' class="texto02"  value="<?= $item->internacao_prescricao_id; ?>"/>
                    <? if (count($saida) == 0) { ?>
                        <?
//                    echo 'asudhasd';
                        ?>

                        <td class="<?php echo $estilo_linha; ?>">
                            <select  name="entrada_id[<?= $contador ?>]" id="entrada_id<?= $contador ?>" class="size2">
                                <option value=""> Selecione</option>
                                <? foreach ($produto as $value) { ?>
                                    <option value="<?= $value->farmacia_entrada_id ?>"> <?php echo $value->descricao; ?> - QTDE: <?php echo $value->total; ?> - Armazem: <?php echo $value->armazem; ?> - VALIDADE: <?php echo substr($value->validade, 8, 2) . "/" . substr($value->validade, 5, 2) . "/" . substr($value->validade, 0, 4); ?></option>   
                                <? }
                                ?>   

                            </select>
                        </td>
                    <? } else { ?>
                        <td style="display: none;" class="<?php echo $estilo_linha; ?>">
                            <select  name="entrada_id[<?= $contador ?>]" id="entrada_id<?= $contador ?>" class="size2">
                                <option value=""> Selecione</option>
                                <? foreach ($produto as $value) { ?>
                                    <option value="<?= $value->farmacia_entrada_id ?>"> <?php echo $value->descricao; ?> - QTDE: <?php echo $value->total; ?> - Armazem: <?php echo $value->armazem; ?> - VALIDADE: <?php echo substr($value->validade, 8, 2) . "/" . substr($value->validade, 5, 2) . "/" . substr($value->validade, 0, 4); ?></option>   
                                <? }
                                ?>   

                            </select>
                        </td>
                        <td class="<?php echo $estilo_linha; ?>">   
                            <span style="color:green;">Saída Efetuada</span>
                        </td>
                    <? } ?>
                    </tr>

                    </tbody>
                    <?
                    $contador++;
                }
                ?>

            </table> 

            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Enviar</button>
            </div>
    </form>

</fieldset>
<fieldset>
    <?
    if (count($produtossaida) > 0) {
        ?>
        <table id="table_agente_toxico" border="0">
            <thead>

                <tr>
                    <th class="tabela_header">Produtos Saída</th>
                    <th class="tabela_header">Status</th>
                    <th class="tabela_header">Qtde</th>
                    <th class="tabela_header" colspan="3">&nbsp;</th>
                </tr>
            </thead>
            <?
            $estilo_linha = "tabela_content01";
            $perfil_id = $this->session->userdata('perfil_id');
            foreach ($produtossaida as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                ?>
                <tbody>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao; ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><? if ($item->confirmado == 't') { ?><span style="color:green;">Confirmado</span> <? } ?></td>
                        <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>

                        <? if ($item->confirmado == 'f') { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                <a href="<?= base_url() ?>farmacia/saida/excluirsaida/<?= $item->farmacia_saida_id; ?>/<?= $internacao_id ?>/<?= $item->internacao_prescricao_id; ?>" class="delete">
                                </a>

                            </td>
                        <? } elseif ($item->confirmado == 't' && $perfil_id == 1) { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                <a href="<?= base_url() ?>farmacia/saida/excluirsaida/<?= $item->farmacia_saida_id; ?>/<?= $internacao_id ?>/<?= $item->internacao_prescricao_id; ?>" class="delete">
                                </a>

                            </td>   
                        <? } else { ?>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;">
            <!--                                <a href="<?= base_url() ?>farmacia/saida/excluirsaida/<?= $item->farmacia_saida_id; ?>/<?= $internacao_id ?>" class="delete">
                                </a>-->

                            </td> 
                        <? } ?>
                    </tr>

                </tbody>
                <?
            }
        }
        ?>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="4">
                </th>
            </tr>
        </tfoot>
    </table> 
    <br>

</fieldset>        

</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
<? for ($i = 0; $i <= $contador; $i++) { ?>
        $(function () {
            $('#entrada_id<?= $i ?>').change(function () {
                //                alert('asd');
                if ($('#entrada_id<?= $i ?>').val() != '') {
                    $("#qtde<?= $i ?>").prop('required', true);

                    $.getJSON('<?= base_url() ?>autocomplete/saldofarmacia', {entrada_id: $(this).val(), ajax: true}, function (j) {
                        //                        alert(j[0].value);
                        if (j[0].value < <?= $quantidade_solicitada ?>) {
                            $("#qtde<?= $i ?>").prop('max', j[0].value);
                        } else {
                            $("#qtde<?= $i ?>").prop('max', <?= $quantidade_solicitada ?>);
                        }

                        $.getJSON('<?= base_url() ?>autocomplete/saidaprescricaofarmacia', {prescricao_id: $("#internacao_prescricao_id<?= $i ?>").val(), ajax: true}, function (j) {
                            //                        alert(j[0].value); internacao_prescricao_id
                            if (j[0].value < <?= $quantidade_solicitada ?>) {
                                quantidade_solicitada = <?= (int) $quantidade_solicitada ?>;
                                quantidade_menos_saida = quantidade_solicitada + parseInt(j[0].value);
                                //                                    alert(quantidade_menos_saida);
                                $("#qtde<?= $i ?>").val('');
                                //                                    $("#qtde<?= $i ?>").setCustomValidity('The email address entered is already registerd.');
                                $("#qtde<?= $i ?>").prop('max', quantidade_menos_saida);
                            }
                        });

                    });


                } else {
                    $("#qtde<?= $i ?>").prop('required', false);
                    $("#qtde<?= $i ?>").prop('max', <?= $quantidade_solicitada ?>);
                }
            });
        });

<? } ?>

    function selecionaTexto()
    {
        document.getElementById("txtNome").focus();
    }


    $(function () {
        $("#accordion").accordion();
    });



</script>