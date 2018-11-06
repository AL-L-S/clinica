<div class="content"> <!-- Inicio da DIV content -->

    <div class="bt_link_new">
        <a href="<?php echo base_url() ?>internacao/internacao/editarprocedimentoexternointernacao/0/<?=$internacao_id?>">
            Nova Procedimento
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Procedimentos</a></h3>
        <div>
            <table><!-- Início da lista de pensionistas -->

                <thead>
                    <tr>
                        
                        <th class="tabela_header">Proced.</th>
                        <th class="tabela_header">Data</th>
                        <!-- <th class="tabela_header">Conduta</th> -->
                        <th class="tabela_header">Operador</th>
                       
                        
                        <th class="tabela_header" colspan="3" width="70px"><center>A&ccedil;&otilde;es</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    if (count($lista) > 0) :
                        $i=0;
                        foreach ($lista as $item) {
                            if ($i%2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;
                            //$ficha_id = $item->ficha_id;
                            ?>
                    <tr>
                        <td class="<?=$classe;?>"><?=$item->procedimento;?></td>
                        <td class="<?=$classe;?>"><?=date("d/m/Y",strtotime($item->data));?></td>
                        <td class="<?=$classe;?>"><?=$item->operador;?></td>
                        <td class="<?=$classe;?>" width="50px;" >
                            <div class="bt_link">
                                <a  href="<?=  base_url()?>internacao/internacao/editarprocedimentoexternointernacao/<?=$item->internacao_procedimento_externo_id;?>/<?=$internacao_id?>">
                                    <b>Editar</b>
                                </a>
                            </div>    
                        </td>
                        <td class="<?=$classe;?>" width="50px;" >
                            <div class="bt_link">
                                <a onclick="javascript: return confirm('Deseja realmente exlcuir esse registro?');"
                                    href="<?=  base_url()?>internacao/internacao/excluirprocedimentoexternointernacao/<?=$item->internacao_procedimento_externo_id;?>/<?=$internacao_id?>">
                                    <b>Excluir</b>
                                </a>
                            </div>
                        </td>
                        
                    </tr>
                            <?
                            $i++;
                        }
                    else :
                        ?>
                    <tr>
                        <td class="tabela_content01" colspan="6">Sem procedimentos cadastrada.</td>
                    </tr>
                    <? endif; ?>
              </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="7">Procedimentos: <?=count($lista); ?></th>
                    </tr>
                </tfoot>
            </table><!-- Fim da lista de pensionistas -->
        </div>
     </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function() {
        $( "#servidor" ).accordion();
        $( "#accordion" ).accordion();
    });

  </script>
