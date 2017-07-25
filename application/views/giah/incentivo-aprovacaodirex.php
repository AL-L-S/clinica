<div class="content"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Aprovar DIREX</h3>
    <div class="competencia">
        <h3>
            <a href="#">Compet&ecirc;ncia
                <?
                $competencia = $this->competencia->competenciaAtiva();
                echo substr($competencia, 0, 4), "/" . substr($competencia, 4);
                ?>
            </a>
        </h3>
        <? $responsavel = 1  ; ?>
        <div class="competencia_div">
            <div class="comandos comandos_geral">
                <? if (isset ($lista)) : ?>
                    <? if (!isset ($item->autoriza_direx)): ?>
                <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                   href="<?= base_url()?>giah/incentivo/aprovartodos/<?=$responsavel;?>/<?= $competencia;?>/true">
                    <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png" />Aprovar Todos</a>
                <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                   href="<?= base_url()?>giah/incentivo/aprovartodos/<?=$responsavel;?>/<?= $competencia;?>/false">
                    <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png" />Reprovar Todos</a>
                    <? else: ?>
                        <? if ($item->autoriza_direx == 't'): ?>
                <div class="aprovado">APROVADO</div>
                        <? else: ?>
                <div class="reprovado">REPROVADO</div>
                        <? endif; ?>
                    <? endif; ?>
                <? endif; ?>
            </div>
        </div>
    </div>
    <? if (isset ($lista)) : ?>
    <div class="accordion">
            <? $lotacao = ""; ?>
            <? $direc = ""; ?>
            <? $dir = ""; ?>
            <? $y = 0; ?>
            <? $z = 0; ?>
            <? foreach ($lista as $item) : ?>
                <?$valortotal= 0 ?>
                <?$valortotaldirecao= 0?>
                <? $i = 1; ?>
                <? $d = 0; ?>
                <? foreach ($lista as $test) : ?>
                    <? if ($item->lotacao == $test->lotacao): ?>
                        <?$i= $i+1;?>
                        <?$valortotal= $valortotal + $test->valor?>
                    <? endif; ?>
                    <? if ($item->direcao == $test->direcao): ?>
                        <?$d= $d+1;?>
                        <?$valortotaldirecao= $valortotaldirecao + $test->valor?>
                    <? endif; ?>
                <? endforeach; ?>
                <? foreach ($direcao as $test) : ?>
                    <? if ($item->uo_id == 1): ?>
                        <?$dir = 'SUPERINTENDENCIA'?>
                        <?  break;?>
                    <? endif; ?>
                    <? if ($item->direcao == 1): ?>
                        <?$dir = 'DIRETORIAS'?>
                        <?  break;?>
                    <? endif; ?>
                    <? if (($item->direcao == $test->uo_id)): ?>
                        <?$dir = $test->lotacao?>
                        <?  break;?>
                    <? endif; ?>
                    <? if (($item->direcao == $item->direcao)): ?>
                        <?$dir = $item->lotacao?>
                    <? endif; ?>

                <? endforeach; ?>
                <? if ($direc != $item->direcao): ?>
        <h3><a href="#"><?=$dir?><?echo " | <span class='txt_destaque'> Total: R$ ".number_format($valortotaldirecao, 2, ",", ".")."</span>";?></a></h3>
        <div>
                    <? endif; ?>


                    <? if ($lotacao != $item->lotacao): ?>
            <div class="comandos">
                            <? if (!isset ($item->autoriza_direx)): ?>
                <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                   href="<?= base_url()?>giah/incentivo/aprovartodossetor/<?=$responsavel;?>/<?= $item->competencia;?>/<?=$item->uo_id?>/true">
                    <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png">Aprovar</a>
                <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                   href="<?= base_url()?>giah/incentivo/aprovartodossetor/<?=$responsavel;?>/<?= $item->competencia;?>/<?=$item->uo_id?>/false">
                    <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png">Reprovar</a>
                            <? else: ?>
                                <? if ($item->autoriza_direx == 't') : ?>
                <div class="aprovado etiqueta_aba">APROVADO</div>
                                <? else: ?>
                <div class="reprovado etiqueta_aba">REPROVADO</div>
                                <? endif; ?>
                            <? endif; ?>
            </div>
            <div class="lotacao">
                <h3><a href="#"><?=$item->lotacao?> <?echo "Total: R$ ".number_format($valortotal, 2, ",", ".");?>
                        <br>
                    </a>

                </h3>
                <div>

                                <?php $classe = "tabela_content01";?>
                    <table>
                        <thead>
                            <tr>
                                <th class="tabela_header">Servidor</th>
                                <th class="tabela_header">Observa&ccedil;&atilde;o</th>
                                <th class="tabela_header">Valor</th>
                                <th class="tabela_header" width="80px;">Aprova&ccedil;&atilde;o</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="<?php echo $classe; ?>"><?=$item->servidor;?></td>
                                <td class="<?php echo $classe; ?>"><?=$item->observacao;?></td>
                                <td class="<?php echo $classe; ?>"><?=number_format($item->valor, 2, ",", ".");?></td>
                                <td align="center" class="<?php echo $classe; ?>">
                                                <? if (!isset ($item->autoriza_direx)): ?>
                                    <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/true">
                                        <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png"></a>
                                    <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/false">
                                        <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png"></a>
                                                <? else: ?>
                                                    <? if ($item->autoriza_direx == 't') : ?>
                                    <div class="aprovado">APROVADO</div>
                                                    <? else: ?>
                                    <div class="reprovado">REPROVADO</div>
                                                    <? endif; ?>
                                                <? endif; ?>
                                </td>
                            </tr>
                                        <? $y = 1; ?>
                                    <? else: ?>
                                        <?php $classe = ($classe == "tabela_content02")? "tabela_content01" : "tabela_content02"; ?>
                            <tr>
                                <td class="<?php echo $classe; ?>"><?=$item->servidor;?></td>
                                <td class="<?php echo $classe; ?>"><?=$item->observacao;?></td>
                                <td class="<?php echo $classe; ?>"><?=number_format($item->valor, 2, ",", ".");?></td>
                                <td align="center" class="<?php echo $classe; ?>">
                                                <? if (!isset ($item->autoriza_direx)): ?>
                                    <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/true">
                                        <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png"></a>
                                    <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/false">
                                        <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png"></a>
                                                <? else: ?>
                                                    <? if ($item->autoriza_direx == 't') : ?>
                                    <div class="aprovado">APROVADO</div>
                                                    <? else: ?>
                                    <div class="reprovado">REPROVADO</div>
                                                    <? endif; ?>
                                                <? endif; ?>
                                </td>
                            </tr>


                                    <? endif; ?>
                                    <? $y = $y+1;?>
                                    <? $lotacao = $item->lotacao; ?>
                                    <? $direc = $item->direcao; ?>
                                    <? $dir = ""; ?>
                                    <? $z = $z+1;?>
                                    <? if ($i == $y ): ?>

                                        <? $y = 1; ?>
                        </tbody>
                    </table>
                </div>
                        <? endif; ?>
            </div>
                    <? if ($d == $z ): ?>

                        <? $z = 0; ?>
        </div>
                <? endif; ?>
            <? endforeach; ?>

    </div>
    <? endif; ?>
</div> <!-- Final da DIV content -->
<script type="text/javascript">
    $(function() {
        $( ".competencia" ).accordion({ autoHeight: false });
        $( ".accordion" ).accordion({ autoHeight: false, active: false });
        $( ".lotacao" ).accordion({

            active: true,
            autoheight: false,
            clearStyle: true

        });


    });
</script>