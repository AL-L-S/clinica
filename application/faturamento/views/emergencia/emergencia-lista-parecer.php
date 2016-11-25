<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion" >
        <h3><a href="#">Lista de Pareceres:</a></h3>
        <div>
            <table><!-- Início da lista de pensionistas -->

                <thead>
                    <tr>
                        <th class="tabela_header">Tempo da conduta</th>
                        <th class="tabela_header">Conduta</th>
                        <th class="tabela_header">Data / Hora da solicitação</th>
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
                        <td class="<?=$classe;?>"><?=$item->prioridade;?></td>
                        <td class="<?=$classe;?>"><?=$item->especialidade;?></td>
                        <td class="<?= $classe; ?>"><?$ano= substr($item->datasolicitacao,0,4);?>
                                                            <?$mes= substr($item->datasolicitacao,5,2);?>
                                                            <?$dia= substr($item->datasolicitacao,8,2);?>
                                                            <?$datafinal= $dia . '/' . $mes . '/' . $ano; ?>
                                                            <?=$datafinal?>
                                                            - <?$hora= substr($item->horasolicitacao,0,2); ?>
                                                            <?$minuto= substr($item->horasolicitacao,3,2); ?>
                                                            <?$horafinal = $hora . ':' . $minuto;?>
                                                            <?=$horafinal?> </td>
                        <td class="<?=$classe;?>">
                            <? if ($item->parecer_id != '') : ?>
                            <a  href="<?=  base_url()?>emergencia/emergencia/relatorioparecer/<?=$item->evolucao_id;?>/<?=$item->parecer_id;?>">
                                <img border="0" title="Parecer" alt="Parecer"
                                     src="<?=  base_url()?>img/form/page_white_acrobat.png" />
                            </a>
                            <? endif; ?>
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
                        <th class="tabela_footer" colspan="4">Evolu&ccedil;&otilde;es: <?=count($lista); ?></th>
                    </tr>
                </tfoot>
            </table><!-- Fim da lista de pensionistas -->
        </div>
     </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

  </script>

