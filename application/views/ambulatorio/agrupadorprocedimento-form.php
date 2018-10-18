
<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimento">
            Voltar
        </a>
        <?
        $procedimentos_array = array();
        $quantidade_array = array();

        foreach ($procedimentoagrupados as $key => $item) {
            array_push($procedimentos_array, $item->procedimento_tuss_id);
            $quantidade_array[$item->procedimento_tuss_id] = $item->quantidade_agrupador;
        }
//        var_dump($procedimentos_array); die;
        $procedimentos_json = json_encode($procedimentos_array);
//        $procedimentos_json = json_encode($quantidade_array);
        ?>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Agrupador Procedimento</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimento/gravaragrupadorprocedimento" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome*</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtprocedimentotussid" value="<?= @$obj->_procedimento_tuss_id; ?>" />
                        <input type="hidden" name="array_proc" value='<?= @$procedimentos_json; ?>' />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" required=""/>
                    </dd>
                    <dt>
                        <label>Grupo</label>
                    </dt>
                    <dd>
                        <select name="agrupador_grupo" id="agrupador_grupo" required="">
                            <option value="">Selecione</option>
                            <? foreach ($grupos as $value) { ?>
                                <option value="<?= $value->nome ?>" <?= ($value->nome == @$obj->_agrupador_grupo) ? 'selected' : '' ?>>
                                    <?= $value->nome ?>
                                </option>
                            <? } ?>
                        </select>
                    </dd>
<!--                    <p style="font-style: italic;">Obs: Caso seja informado um grupo para o agrupador, ele só irá salvar os procedimentos pertencentes a este grupo.</p>
                    --><br>

                    <div class="divTabela">
                        <div class='base'>

                            

                            <table id="procedimentos">
                                <thead>
                                    <tr>
                                        <th class="tabela_title">Procedimento</th>
                                        <th class="tabela_title">Grupo</th>
                                        <th class="tabela_title">Quantidade</th>
                                        <th class="tabela_title">Adicionar</th>
                                    </tr>
                                </thead>
                                    <tr class="linhaPesquisar">
                                        <td class="tabela_title">
                                            <input type="text" id="procText" onkeypress="filtrarTabela()" placeholder="Pesquisar texto..." title="Pesquise pelo nome do procedimento ou pelo codigo">

                                        </td>
                                        <td class="tabela_title">
                                            <!-- <div style="float: left; margin-bottom: 20pt;"> -->
                                               
                                                <select id="grupoText">
                                                    <option value="">TODOS</option>
                                                    <?
                                                    foreach ($grupos as $value) {
                                                        if ($value->nome == 'AGRUPADOR')
                                                            continue;
                                                        ?>
                                                        <option value="<?= $value->nome ?>"><?= $value->nome ?></option>
                                                    <? } ?>
                                                </select>
                                                <button type="button" onclick="filtrarTabela()">Buscar</button>
                                            <!-- </div> -->
                                        </td>
                                        <td class="tabela_title"></td>
                                        <td class="tabela_title"></td>
                                    </tr>
                                <tbody>
                                    <?
                                    $i = 0;
                                    foreach ($procedimento as $item) {
                                        ?>
                                        <tr class="linhaTabela" id="<?= $item->grupo ?>">
                                            <td>
                                                <input type="hidden" name="procedimento_id[<?= $i ?>]" value="<?= $item->procedimento_tuss_id ?>"/>
                                                <?= $item->codigo ?> - <?= $item->nome ?>
                                            </td>

                                            <td><?= $item->grupo ?></td>
                                            <?
                                            if (in_array($item->procedimento_tuss_id, $procedimentos_array)) {
                                                $quantidade = $quantidade_array[$item->procedimento_tuss_id];
                                            } else {
                                                $quantidade = '';
                                            }
                                            ?>
                                            <td >
                                                <input type="number" min="1" name="quantidade[<?= $i ?>]" value="<?= $quantidade ?>"   class="texto01" colspan="2"/>
                                            </td>
                                            <td class="add_conv_sec">
                                                <input <?= (in_array($item->procedimento_tuss_id, $procedimentos_array)) ? 'checked' : ''; ?> type="checkbox" name="add_agrupador[<?= $i ?>]"  id="add_conv_sec<?= $i ?>" class="checkbox" colspan="2"/>
                                            </td>
                                        </tr>

                                        <?
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>      
                        </div>
                    </div>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>

        <? if (count($procedimentoagrupados) > 0) { ?>
            <h3 class="singular"><a href="#">Lista Procedimentos Agrupados</a></h3>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Codigo</th>
                            <th class="tabela_header">Nome</th>
                            <th class="tabela_header">Grupo</th>
                            <th class="tabela_header">Quantidade</th>
                            <th colspan="3" class="tabela_header"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($procedimentoagrupados as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->codigo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupo; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->quantidade_agrupador; ?></td>
                                <td class="<?php echo $estilo_linha; ?>">
                                    <a href="<?= base_url() ?>ambulatorio/procedimento/excluirprocedimentoagrupado/<?= $item->procedimento_agrupador_id; ?>/<?= @$obj->_procedimento_tuss_id; ?>" class="delete"></a>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
        <? } ?>
    </div>
</div> <!-- Final da DIV content -->
<style>
    .divTabela { border: 1pt solid #aaa; border-radius: 10pt; padding: 5pt; }
    .linhaTabela { border-bottom: 1pt solid #aaa; }
    .base { max-height: 400pt; overflow-y: auto; }
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

                                    function filtrarTabela() {
                                        var input, procedimento, select, grupo, table, tr, td, i;
                                        input = document.getElementById("procText");
                                        procedimento = input.value.toUpperCase();

                                        select = document.getElementById("grupoText");
                                        grupo = select.options[select.selectedIndex].value.toUpperCase();

                                        var id = 'procedimentos';
                                        table = document.getElementById(id);
                                        tr = table.getElementsByTagName("tr");
                                        // console.log(tr);
                                        if (grupo == "" && procedimento != "") { // CASO TENHA INFORMADO SOMENTE PROCEDIMENTO
                                            for (i = 0; i < tr.length; i++) {
                                                if(tr[i].getAttribute('class') != 'linhaPesquisar'){
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
                                        } else if (grupo != "" && procedimento == "") { // CASO TENHA INFORMADO APENAS O GRUPO
                                            for (i = 0; i < tr.length; i++) {
                                                if(tr[i].getAttribute('class') != 'linhaPesquisar'){
                                                    // alert('aa');
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
                                        } else if (grupo != "" && procedimento != "") { // CASO TENHA INFORMADO O GRUPO E O PROCEDIMENTO
                                            for (i = 0; i < tr.length; i++) {
                                                if(tr[i].getAttribute('class') != 'linhaPesquisar'){
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
                                        } else {
                                            for (i = 0; i < tr.length; i++) {
                                                tr[i].style.display = "";
                                            }
                                        }
                                    }

</script>