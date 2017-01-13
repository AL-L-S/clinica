
<div class="content"> <!-- Inicio da DIV content -->

    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>ceatox/ceatox">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Lista de Observa&ccedil;&atilde;o</a></h3>
        <div>
            <table><!-- Início da lista de pensionistas -->

                <thead>
                    <tr>

                        <th class="tabela_header">Ficha</th>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Observa&ccedil;&atilde;o</th>
                        <th class="tabela_header">&nbsp;</th>
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
                            //$ficha_id = $item->ficha_id;
                            ?>
                    <tr>
                        <td class="<?=$classe;?>"><?=$item->ficha;?></td>
                        <td class="<?=$classe;?>"><?=$item->nome;?></td>
                        <td class="<?=$classe;?>"><?=$item->observacao;?></td>
                        <td class="<?=$classe;?>">
                            <a onclick="javascript: return confirm('Deseja realmente exlcuir esse registro?');"
                               href="<?=  base_url()?>ceatox/ceatox/excluirobservacao/<?=@$ficha->_ficha_id?>/<?=$item->observacao_id;?>">
                                <img border="0" title="Excluir" alt="Detalhes"
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
            </table><!-- Fim da lista de pensionistas -->
        </div>

        <h3><a href="#">Cadastro</a></h3>
        <div><!-- Início do formulário pensionistas -->
            <form name="form_observacao" id="form_observacao" action="<?php echo base_url() ?>ceatox/ceatox/gravarobservacao" method="post">
                <input type="hidden" name="txtFichaID" value="<?=@$ficha->_ficha_id; ?>" />

                <dl class="add_pensionista">
                    <dt>
                        <label>Observa&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtObservacao" class="texto10" />
                    </dd>
                </dl>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div><!-- Fim do formulário pensionistas -->
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
        jQuery('#form_observacao').validate( {
            rules:
                {
                txtObservacao:
                    {
                    required: true
                }
            },
            messages:
                {
                txtObservacao:
                    {
                    required: "*"

                }
            }
        });
    });
  </script>