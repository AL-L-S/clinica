<?php
//Utilitario::pmf_mensagem($message);
//unset($message);
?>
<div class="content">
<div id="accordion">
    <h3><a href="#">Manter Ocorrencia</a></h3>
    <div>
        <table>
            <thead>
                <tr>
                    <th class="tabela_header">Nome</th>
                    <th class="tabela_header">Data inicio</th>
                    <th class="tabela_header">Data fim</th>
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
        ?>
                        <tr>
                            <td class="<?= $classe; ?>"><?= $item->nome; ?></td>
                            <td class="<?= $classe; ?>"><?= substr($item->diainicio,8,2) . '/' . substr($item->diainicio,5,2) . '/' . substr($item->diainicio,0,4); ?></td>
                            <td class="<?= $classe; ?>"><?= substr($item->diafim,8,2) . '/' . substr($item->diafim,5,2) . '/' . substr($item->diafim,0,4); ?></td>
                            <td class="<?= $classe; ?>" width="50px">
                                <a onclick="javascript: return confirm('Deseja realmente excluir a ocorrencia <?= $item->nome; ?>');"
                                   href="<?= base_url() ?>ponto/ocorrencia/excluir/<?= $item->ocorrencia_id; ?>/<?= $item->funcionario_id; ?>">
                                    <img border="0" title="Excluir" alt="Excluir"
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
                        <td class="tabela_content01" colspan="4">Sem registros encontrados.</td>
                    </tr>
<? endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="tabela_footer" colspan="4">Total de registros: <?= count($lista); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <h3><a href="#">Cadastro</a></h3>
    <div><!-- Início do formulário suplementar -->
        <form name="form_ocorrencia" id="form_ocorrencia" action="<?= base_url() ?>ponto/ocorrencia/gravar" method="post">

            <dl class="dl_desconto_lista">
                <dt>
                <label>Nome</label>
                </dt>
                <dd>
                    <input type="hidden" name="txtfuncionario_id" value="<?= $funcionario_id; ?>" />
                    <select name="txtnome" id="txtnome" class="size2">
                        <option value="">Selecione</option>
<? foreach ($listaocorrenciatipo as $item) : ?>
                            <option value="<?= $item->ocorrenciatipo_id; ?>"><?= $item->nome; ?></option>
                        <? endforeach; ?>
                    </select>
                </dd>
                <dt>
                <label>Data inicio</label>
                </dt>
                <dd>
                <td><input type="text"  id="txtDatainicio" name="txtDatainicio" alt="date" class="size1" /></td>
                </dd>
                <dt>
                <label>Data fim</label>
                </dt>
                <dd>
                <td><input type="text"  id="txtDatafim" name="txtDatafim" alt="date" class="size1" /></td>
                </dd>
                <label>Observa&ccedil;&atilde;o</label>
                </dt>
                <dd class="dd_texto">
                    <textarea cols="" rows="" name="txtobservacao" class="texto_area" ></textarea><br/>
                </dd>
            </dl>    

            <hr/>
            <button type="submit" name="btnEnviar">Enviar</button>
            <button type="reset" name="btnLimpar">Limpar</button>
            <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
        </form>
    </div>

</div> <!-- accordion -->
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/ocorrencia');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_ocorrencia').validate( {
            rules: {
                txtnome: {
                    required: true,
                    minlength: 1
                },
                txtDatainicio: {
                    required: true,
                    minlength: 8
                },
                txtDatafim: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {
                txtnome: {
                    required: "*",
                    minlength: "!"
                },
                txtDatainicio: {
                    required: "*",
                    minlength: "!"
                },
                txtDatafim: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>
