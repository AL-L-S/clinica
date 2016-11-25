<div class="content"> <!-- Inicio da DIV content -->

    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ceatox/ceatox">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Evolu&ccedil;&atilde;o selecionada:</a></h3>
        <div>
            <table><!-- Início da lista de pensionistas -->

                <thead>
                    <tr>
                        <th class="tabela_header">Nº Ficha</th>
                        <th class="tabela_header">Evolu&ccedil;&atilde;o</th>
                        <th class="tabela_header">Descri&ccedil;&atilde;o</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?
                    if (count($lista) > 0) :
                        $i = 0;
                        foreach ($lista as $item) :
                            if ($i % 2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;
                            //$ficha_id = $item->ficha_id;
                    ?>
                            <tr>
                                <td class="<?= $classe; ?>"><?= $item->ficha_id; ?></td>
                                <td class="<?= $classe; ?>"><?= $item->nome; ?></td>
                                <td class="<?= $classe; ?>"><?= $item->descricao; ?></td>
                                <td class="<?= $classe; ?>">
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse registro?');"
                                       href="<?= base_url() ?>ceatox/ceatox/excluirevolucao/<?= @$ficha->_ficha_id ?>/<?= $item->evolucao_id; ?>">
                                        <img border="0" title="Excluir" alt="Detalhes"
                                             src="<?= base_url() ?>img/form/page_white_delete.png" />
                                    </a>
                                </td>
                            </tr>
                    <?
                            $i++;
                        endforeach;
                    else :
                    ?>
                        <tr>
                            <td class="tabela_content01" colspan="4">Sem Evolu&ccedil;&atilde;o cadastrada.</td>
                        </tr>
                    <? endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="4">Evolu&ccedil;&otilde;es: <?= count($lista); ?></th>
                        </tr>
                    </tfoot>
                </table><!-- Fim da lista de pensionistas -->
            </div>
        <? if (count($lista) == 0): ?>
                            <h3><a href="#">Cadastro</a></h3>
                            <div><!-- Início do formulário pensionistas -->
                                <form name="form_observacao" id="form_observacao" action="<?php echo base_url() ?>ceatox/ceatox/gravarevolucao" method="post">
                                    <input type="hidden" name="txtFichaID" value="<?= @$ficha->_ficha_id; ?>" />

                                    <select name="evolucao" id="evolucao" class="size2">

                    <? foreach ($listaEvolucao as $item) : ?>
                                <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                    <? endforeach; ?>
                            </select>
                            <span class="espec evolucao_desc">Especifique</span>
                            <input type="text" name="evolucao_desc" id="evolucao_desc" class="size1 espec" />
                            <hr/>
                            <button type="submit" name="btnEnviar">Enviar</button>
                            <button type="reset" name="btnLimpar">Limpar</button>
                        </form>
                    </div><!-- Fim do formulário pensionistas -->
                </div>
    <? endif; ?>
                            </div> <!-- Final da DIV content -->
                            <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function() {
        $( "#servidor" ).accordion();
        $( "#accordion" ).accordion();
    });

</script>
