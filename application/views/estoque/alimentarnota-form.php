<div class="content"> <!-- Inicio da DIV content -->
    <?
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <? if (@$notafiscal[0]->situacao != "FINALIZADA") { ?>
        <div id="accordion">
            <h3 class="singular"><a href="#">Cadastro de Entrada-Nota</a></h3>
            <div>
                <form name="form_entrada" id="form_entrada" action="<?= base_url() ?>estoque/entrada_nota/gravar/<?= $nota[0]->estoque_nota_id ?>" method="post">
                    <? // echo '<pre>';var_dump($notafiscal[0]);die;?>
                    <dl class="dl_desconto_lista">
                        <dt>
                            <label>Produto</label>
                        </dt>
                        <dd>
                            <input type="hidden" name="txtestoque_entrada_nota_id" id="txtestoque_entrada_nota_id" value="" />
                            <input type="hidden" name="txtproduto" id="txtproduto" value="" />
                            <input type="text" name="txtprodutolabel" id="txtprodutolabel" class="texto10" value="" required=""/>
                        </dd>
                        <dt>
                            <label>Nota Fiscal</label>
                        </dt>
                        <dd>
                            <input type="text" id="nota" alt="integer" class="texto04" name="nota" value="<?= @$nota[0]->nota_fiscal; ?>" readonly=""/>
                        </dd>                    
                        <dt>
                            <label>Fornecedor</label>
                        </dt>
                        <dd>
                            <input type="hidden" name="txtfornecedor" id="txtfornecedor" value="<?= @$nota[0]->fornecedor_id; ?>" />
                            <input type="text" name="txtfornecedorlabel" id="txtfornecedorlabel" class="texto10" value="<?= @$nota[0]->fornecedor; ?>" readonly=""/>
                        </dd>
                        <dt>
                            <label>Armazem</label>
                        </dt>
                        <dd>
                            <input type="hidden" name="txtarmazem" id="txtarmazem" value="<?= @$nota[0]->armazem_id; ?>" />
                            <input type="text" name="txtarmazemlabel" id="txtarmazemlabel" class="texto10" value="<?= @$nota[0]->armazem; ?>" readonly=""/>
                        </dd>
                        <dt>
                            <label>Valor de compra</label>
                        </dt>
                        <dd>
                            <input type="text" id="compra" alt="decimal" class="texto02" name="compra" value="" />
                        </dd>
                        <dt>
                            <label>Lote</label>
                        </dt>
                        <dd>
                            <input type="text" id="lote" class="texto02" name="lote" value="" />
                        </dd>
                        <dt>
                            <label>Quantidade</label>
                        </dt>
                        <dd>
                            <input type="text" id="quantidade" class="texto02" alt="integer" name="quantidade" value="" />
                        </dd>                    
                        <dt>
                            <label>Validade</label>
                        </dt>
                        <dd>
                            <input type="text" id="validade" class="texto02" name="validade" value="" />
                        </dd>
                    </dl>    
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                </form>
            </div>
        </div>
    <? } ?>
    <div>
        <table>

            <tr>
                <th class="tabela_header">Nota Fiscal: <?= $nota[0]->nota_fiscal ?></th>
                <th class="tabela_header">Valor Total: <?= $nota[0]->valor_nota ?></th> 
            </tr>
            <tr>
                <th class="tabela_header">Produto</th>
                <th class="tabela_header">Data</th>
                <th class="tabela_header">Fornecedor</th>
                <th class="tabela_header">Armazem</th>
                <th class="tabela_header">Valor Compra</th>
                <th class="tabela_header">Qtde</th>
                <th class="tabela_header">Nota</th>
                <th class="tabela_header">Situação</th>
                <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
            </tr>
            </thead>
            <?php
            $url = $this->utilitario->build_query_params(current_url(), $_GET);
            $consulta = $this->entrada_nota->listar($_GET);
            $total = $consulta->count_all_results();
            $limit = 10;
            isset($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

            if ($total > 0) {
                ?>
                <tbody>
                    <?php
//                            var_dump($nota);die;
                    $lista = $this->entrada_nota->listar($nota)->orderby('en.estoque_entrada_nota_id DESC, p.descricao, f.razao_social')->limit($limit, $pagina)->get()->result();
                    $estilo_linha = "tabela_content01";
                    $valor = 0;
                    foreach ($lista as $item) {

                        if ($item->nota_fiscal == $nota[0]->nota_fiscal) {

                            $valor += $item->valor_compra;
//                            $valor_teste = $item->valor_compra - 484.07;

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->produto; ?> <?
                                    if ($item->transferencia == 't') {
                                        echo " <span style='color:red;'>(Transferência)</span>";
                                    }
                                    ?><?
                                    if ($item->fracionamento_id > 0) {
                                        echo " <span style='color:red;'>(Fracionamento)</span>";
                                    }
                                    ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y", strtotime($item->data_cadastro)); ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->fantasia; ?></td>

                                <td class="<?php echo $estilo_linha; ?>"><?= $nota[0]->armazem; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_compra; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nota_fiscal; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->situacao; ?></td>
                                <?
                                if ($perfil_id != 10) {
                                    if (date("Y-m-d", strtotime($item->data_cadastro)) == date("Y-m-d")) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;">
                                        </td>
                                    <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"></td>
                                    <? } ?>
                                    <? if (@$notafiscal[0]->situacao != "FINALIZADA") { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                                <a onclick="javascript: return confirm('Deseja realmente exlcuir esse Entrada?');" href="<?= base_url() ?>estoque/entrada_nota/excluir/<?= $item->estoque_entrada_nota_id ?>/<?= $nota[0]->estoque_nota_id ?>">Excluir</a></div>
                                        </td> 
                                    <? } ?>

                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"><div class="bt_link">                                  
                                        </div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="70px;"> <div class="bt_link">                                 
                                        </div>
                                    </td>  

                                <? }
                                ?>
                        <!--                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                                                <a href="<?= base_url() ?>estoque/entrada/anexarimagementrada/<?= $item->estoque_entrada_nota_id ?>">Arquivos</a></div>
                                                        </td>-->
                            </tr>

                        </tbody>
                        <?php
                    }
                }
//                var_dump($valor);
//                var_dump($nota[0]->valor_nota);
//                echo '<pre>';var_dump($valor);die;
            }
            ?>

        </table>
        <table style="width: 180px">
            <tr>
                <?
                $valor1 = (float) round($nota[0]->valor_nota, 2);
                $valor2 = (float) round($valor, 2);               
                ?>
                <? if (@$notafiscal[0]->situacao != "FINALIZADA") { ?>
                    <? if ($valor1 < $valor2) { ?>                
                        <td>
                            <div class="bt_link" style="width: 100px">
                                <a onclick="javascript: return alert('A soma dos valores dos produtos é maior que o valor total da nota. Não é possível finalizar!');">Finalizar Nota</a>
                            </div>
                        </td>
                    <? } elseif ($valor1 > $valor2) {
                        ?>
                        <td>
                            <div class="bt_link" style="width: 100px">
                                <a onclick="javascript: return alert('A soma dos valores dos produtos é menor que o valor total da nota. Não é possível finalizar!');">Finalizar Nota</a>
                            </div>
                        </td>
                    <? } else { ?>
                        <td>
                            <div class="bt_link" style="width: 100px">
                                <a onclick="javascript: return confirm('Deseja realmente finalizar essa Nota? Ao finalizar não será mais possível fazer alterações.');" href="<?= base_url() ?>estoque/nota/finalizarnota/<?= $nota[0]->estoque_nota_id ?>/<?= $nota[0]->nota_fiscal ?>"style="color: green">Finalizar Nota</a>
                            </div>
                        </td>    
                    <? } ?>
                <? } ?>
                <td>
                    <div class="bt_link" style="width: 60px">
                        <a href="<?= base_url() ?>estoque/nota/"style="color: black">Voltar</a>
                    </div>
                </td>
            <tr>
        </table>    
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

                                    $(function () {
                                        $("#txtfornecedorlabel").autocomplete({
                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=fornecedor",
                                            minLength: 2,
                                            focus: function (event, ui) {
                                                $("#txtfornecedorlabel").val(ui.item.label);
                                                return false;
                                            },
                                            select: function (event, ui) {
                                                $("#txtfornecedorlabel").val(ui.item.value);
                                                $("#txtfornecedor").val(ui.item.id);
                                                return false;
                                            }
                                        });
                                    });

                                    $(function () {
                                        $("#txtprodutolabel").autocomplete({
                                            source: "<?= base_url() ?>index.php?c=autocomplete&m=produto",
                                            minLength: 2,
                                            focus: function (event, ui) {
                                                $("#txtprodutolabel").val(ui.item.label);
                                                return false;
                                            },
                                            select: function (event, ui) {
                                                $("#txtprodutolabel").val(ui.item.value);
                                                $("#txtproduto").val(ui.item.id);
                                                return false;
                                            }
                                        });
                                    });

                                    $(function () {
                                        $("#validade").datepicker({
                                            autosize: true,
                                            changeYear: true,
                                            changeMonth: true,
                                            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                            buttonImage: '<?= base_url() ?>img/form/date.png',
                                            dateFormat: 'dd/mm/yy'
                                        });
                                    });


                                    $(document).ready(function () {
                                        jQuery('#form_entrada').validate({
                                            rules: {
                                                txtproduto: {
                                                    required: true
                                                },
                                                quantidade: {
                                                    required: true
                                                },
                                                compra: {
                                                    required: true
                                                }

                                            },
                                            messages: {
                                                txtproduto: {
                                                    required: "*"
                                                },
                                                quantidade: {
                                                    required: "*"
                                                },
                                                compra: {
                                                    required: "*"
                                                }
                                            }
                                        });
                                    });


                                    $(function () {
                                        $("#accordion").accordion();
                                    });
</script>