<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>giah/servidor/pesquisar/<?= $servidor->_nome; ?>">
            Voltar
        </a>
    </div>

    <?php $this->load->view("giah/snippets/servidor-detalhe"); ?>

    <div id="accordion">
        <h3><a href="#">Lista de suplementares</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Compet&ecirc;ncia</th>
                        <th class="tabela_header">Valor</th>
                        <th class="tabela_header">Observa&ccedil;&atilde;o</th>
                        <th class="tabela_header" width="50px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    if (count($lista) > 0) :
                        $i=0;
                        foreach ($lista as $item) :
                            if ($i%2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;
                            ?>
                    <tr>
                        <td class="<?=$classe;?>"><?= substr($item->competencia, 0, 4) . '/' . substr($item->competencia, 4);?></td>
                        <td class="<?=$classe;?>"><?= number_format($item->valor, 2, ",", ".");?></td>
                        <td class="<?=$classe;?>"><?= $item->observacao;?></td>
                        <td class="<?=$classe;?>" width="50px">
                            <a onclick="javascript: return confirm('Deseja realmente excluir o valor \n suplementar de <?=$servidor->_nome; ?>');"
                               href="<?=base_url()?>giah/suplementar/excluir/<?=$item->servidor_id;?>">
                                <img border="0" title="Excluir" alt="Excluir"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
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
                        <th class="tabela_footer" colspan="4">Total de registros: <?=count($lista); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <? if (count($lista) == 0 ): ?>
        <h3><a href="#">Cadastro</a></h3>
        <div><!-- Início do formulário suplementar -->
            <form name="form_suplementar" id="form_suplementar" action="<?=base_url() ?>giah/suplementar/gravar" method="post">
                <input type="hidden" name="txtServidorID" value="<?=$servidor->_servidor_id;?>" />
                <dl>
                    <dt>
                        <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtValor" class="texto03"
                               alt="decimal"/>
                    </dd>
                    <dt>
                        <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd class="dd_texto">
                        <textarea cols="" rows="" name="txtObservacao" class="texto_area" ></textarea><br/>
                    </dd>
                    <dt>
                        <label>Servidor Teto </label>
                    </dt>
                    <dd>
                        <select name="txtServidorteto" size="1"  id="txtServidorteto"  >
                            <? foreach ($teto as $item) : ?>
                            <option value="<?= $item->teto_id; ?>">Salario Base: <?=number_format($item->salario_base, 2, ",", ".");?> / Matricula SAM:<?= $item->matricula_sam; ?></option>
                            <? endforeach; ?>
                        </select>
                    <dd>
                </dl>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
        <? endif; ?>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#servidor" ).accordion();
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_servidor').validate( {
            rules:
                {
                txtValor:
                    {
                    required: true,
                    minlength: 1
                }
            },
            messages:
                {
                txtValor:
                    {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>