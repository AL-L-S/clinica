<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Grupo Conta</a></h3>
        <div>
            <form name="form_grupoconta" id="form_grupoconta" action="<?= base_url() ?>cadastros/grupoconta/gravaradicionar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="grupocontaid" class="texto10" value="<?= @$obj->_conta_grupo_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                    <label>Conta</label>
                </dt>
                <dd>
                    <select name="conta" id="conta" class="texto04">
                        <option value="">Selecione</option>
                        <? foreach ($contas as $value) { ?>
                            <option value="<?= $value->forma_entradas_saida_id ?>"><?= $value->descricao ?> - <?= $value->nome ?></option>
                        <? } ?>                            
                    </select>
                </dd>
                </dl>
                
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
            <br>
            <br>
            <? if (count($relatorio) > 0) { ?>

                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Nome</th>
                            <th class="tabela_header" width="70px;" colspan="2"><center>Detalhes</center></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($relatorio as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->descricao;?> - <?= $item->nome;?></td>

                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a href="<?= base_url() ?>cadastros/formapagamento/carregarformapagamento/<?= $item->conta_grupo_id ?>">Editar</a>
                                </td>
                                                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir essa conta do grupo?');" href="<?= base_url() ?>cadastros/grupoconta/excluircontagrupo/<?= $item->conta_grupo_contas_id ?>/<?=$item->conta_grupo_id?>">Excluir</a>
                                </td>
                            </tr>

                        </tbody>
                    <? } ?>

                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="6">
                                Valor Total: <?php echo number_format(count($relatorio)); ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>

            <? } ?>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
                                $('#btnVoltar').click(function () {
                                    $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
                                });

                                $(function () {
                                    $("#accordion").accordion();
                                });


                                $(document).ready(function () {
                                    jQuery('#form_grupomedico').validate({
                                        rules: {
                                            txtNome: {
                                                required: true,
                                                minlength: 2
                                            }
                                        },
                                        messages: {
                                            txtNome: {
                                                required: "*",
                                                minlength: "!"
                                            }
                                        }
                                    });
                                });

</script>