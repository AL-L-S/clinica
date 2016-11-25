<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Lista de par&acirc;metros GIAH</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Compet&ecirc;ncia</th>
                        <th class="tabela_header">SIH</th>
                        <th class="tabela_header">AIH</th>
                        <th class="tabela_header">CIB</th>
                        <th class="tabela_header">TOTAL</th>
                        <th class="tabela_header" width="50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $capc = true; // variavel para testar se a competencia aberta possui cadastro
                    if (count($lista) > 0) :
                        $i=0;
                        $capc = false;
                        foreach ($lista as $item) :

                            if ($item->competencia == $competenciaativa &&
                                    isset ($item->competencia_id)) {
                                $capc = true;
                            }

                            if ($i%2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;
        ?>
                    <tr>
                        <td class="<?=$classe;?>"><?= substr($item->competencia, 0, 4) . "/" . substr($item->competencia, 4);?></td>
                        <td class="<?=$classe;?>"><?= number_format($item->valor_sih, 2, ",", "."); ?></td>
                        <td class="<?=$classe;?>"><?= number_format($item->valor_aih, 2, ",", ".");?></td>
                        <td class="<?=$classe;?>"><?= number_format($item->valor_cib, 2, ",", ".");?></td>
                        <td class="<?=$classe;?>"><?= number_format($item->soma, 2, ",", ".");?></td>
                        <td class="<?=$classe;?>">
                                    <? if ($competenciaativa == $item->competencia) :?>
            <?  if (isset ($item->competencia_id)) :?>
                            <a onclick="javascript: return confirm('Deseja realmente excluir os dados da compet&ecirc;ncia <?= substr($item->competencia, 0, 4) . "/" . substr($item->competencia, 4); ?>');"
                               href="<?=base_url()?>giah/parametrogiah/excluir/<?=$item->competencia;?>">
                                <img border="0" title="Excluir" alt="Excluir" src="<?=  base_url()?>img/form/page_white_delete.png" />
                            </a>
                                        <?  endif; ?>
        <? endif; ?>
                        </td>
                    </tr>
                            <?
                            $i++;
                        endforeach;
else : ?>
                    <tr>
                        <td class="">Sem registros encontrados.</td>
                    </tr>
<? endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="6">Total de registros: <?=count($lista); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
<? if (!$capc && $competenciaativa != '000000') : ?>
        <h3><a href="#">Cadastro de par&acirc;metros GIAH</a></h3>
        <div>
            <form name="form_parametrogiah" id="form_parametrogiah" action="<?= base_url() ?>giah/parametrogiah/gravar" method="post">
                <dl>
                    <dt>
                        <label>Valor SIH</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtValor_sih" name="txtValor_sih" class="texto03" value="" alt="decimal"/>
                    </dd>
                    <dt>
                        <label>Valor AIH</label><br/>
                    </dt>
                    <dd>
                        <input type="text" id="txtValor_aih" name="txtValor_aih" class="texto03" value="" alt="decimal"/>
                    </dd>
                    <dt>
                        <label>Valor CIB</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtValor_cib" name="txtValor_cib" class="texto03" value="" alt="decimal"/><br/>
                    </dd>
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
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_parametrogiah').validate( {
            rules: {
                txtValor_sih: {
                    required: true,
                    minlength: 1
                },
                txtValor_aih: {
                    required: true,
                    minlength: 1
                },
                txtValor_cib: {
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                txtValor_sih: {
                    required: "*",
                    minlength: "!"
                },
                txtValor_aih: {
                    required: "*",
                    minlength: "!"
                },
                txtValor_cim: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>