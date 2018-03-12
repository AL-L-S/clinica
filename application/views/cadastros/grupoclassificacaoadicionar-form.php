<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro Grupo Classificação</a></h3>
        <div>
            <form name="form_grupoclassificacao" id="form_grupoclassificacao" action="<?= base_url() ?>cadastros/grupoclassificacao/gravaradicionar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="grupoclassificacaoid" class="texto10" value="<?= @$obj->_classificacao_grupo_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                        <label>Classificação</label>
                    </dt>
                    <dd>
                        <select name="classificacao" id="classificacao" class="texto03">
                            <option value="">Selecione</option>
                            <? foreach ($classificacao as $value) { ?>
                                <option value="<?= $value->tuss_classificacao_id; ?>" ><?php echo $value->nome; ?></option>
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
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->operador; ?></td><!--

                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a href="<?= base_url() ?>cadastros/formapagamento/carregarformapagamento/<?= $item->classificacao_grupo_id ?>">Editar</a>
                                </td>
                                -->                                <td class="<?php echo $estilo_linha; ?>" width="70px;">                                  
                                    <a onclick="javascript: return confirm('Deseja realmente excluir essa classificação?');" href="<?= base_url() ?>cadastros/grupoclassificacao/excluirclassificacaogrupo/<?= $item->classificacao_grupo_associar_id ?>/<?= $item->classificacao_grupo_id ?>">Excluir</a>
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
                                            jQuery('#form_grupoclassificacao').validate({
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