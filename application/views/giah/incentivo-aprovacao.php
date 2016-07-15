<div class="content"> <!-- Inicio da DIV content -->

    <div class="competencia">
        <h3>
            <a href="#">Compet&ecirc;ncia
                <?
                $competencia = $this->competencia->competenciaAtiva();
                echo substr($competencia, 0, 4), "/" . substr($competencia, 4);
                ?>
            </a>
        </h3>
        <div class="comandos">
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
            <img border="0" alt="Autorizado" title="Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                    <? else: ?>
            <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_down.png">
                    <? endif; ?>
                <? endif; ?>
            <? else : ?>
                <? if (!isset ($item->autoriza_super)): ?>
            <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
               href="<?= base_url()?>giah/incentivo/aprovartodos/<?=$responsavel;?>/<?= $competencia;?>/true">
                <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png">Aprovar</a>
            <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
               href="<?= base_url()?>giah/incentivo/aprovartodos/<?=$responsavel;?>/<?= $competencia;?>/false">
                <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png">Reprovar</a>
                <? else: ?>
                    <? if ($item->autoriza_super == 't') : ?>
            <img border="0" alt="Autorizado" title="Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                    <? else: ?>
            <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_down.png">
                    <? endif; ?>
                <? endif; ?>
            <? endif; ?>
        </div>
    </div>

    <? if (isset ($lista)) : ?>
    <div class="accordion">
            <? $lotacao = ""; ?>
            <? $direcao = ""; ?>
            <? $y = 1; ?>
            <? $z = 1; ?>

            <? foreach ($lista as $item) : ?>
                <?$valortotal= 0 ?>
                <?$valortotaldirecao= 0?>
                <? $i = 0; ?>
                <? $d = 1; ?>
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

                <? if ($direcao != $item->direcao): ?>
        <h3><a href="#"><?=$item->direcao?><?echo "Total: R$ ".number_format($valortotaldirecao, 2, ",", ".");?></a></h3>
        <div>

                    <? endif; ?>
            <div class="ui-accordion-left"></div>



            <div class="lotacao">
                        <? if ($lotacao != $item->lotacao): ?>

                <h3><a href="#"><?=$item->lotacao?> <?echo "Total: R$ ".number_format($valortotal, 2, ",", ".");?>
                        <br>
                    </a>
                </h3>
                <div>
                    <div class="comandos">
                        <? if ($responsavel == 1 ) : ?>
                                <? if (!isset ($item->autoriza_direx)): ?>
                <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                   href="<?= base_url()?>giah/incentivo/aprovartodossetor/<?=$responsavel;?>/<?= $item->competencia;?>/<?=$item->uo_id?>/true">
                    <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png">Aprovar</a>
                <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                   href="<?= base_url()?>giah/incentivo/aprovartodossetor/<?=$responsavel;?>/<?= $item->competencia;?>/<?=$item->uo_id?>/false">
                    <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png">Reprovar</a>
                                <? else: ?>
                                    <? if ($item->autoriza_direx == 't') : ?>
                <img border="0" alt="Autorizado" title="Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                                    <? else: ?>
                <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_down.png">
                                    <? endif; ?>
                                <? endif; ?>
                            <? else : ?>
                                <? if (!isset ($item->autoriza_super)): ?>
                <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                   href="<?= base_url()?>giah/incentivo/aprovartodossetor/<?=$responsavel;?>/<?= $item->competencia;?>/<?=$item->uo_id?>/true">
                    <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png">Aprovar</a>
                <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                   href="<?= base_url()?>giah/incentivo/aprovartodossetor/<?=$responsavel;?>/<?= $item->competencia;?>/<?=$item->uo_id?>/false">
                    <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png">Reprovar</a>
                                <? else: ?>
                                    <? if ($item->autoriza_super == 't') : ?>
                <img border="0" alt="Autorizado" title="Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                                    <? else: ?>
                <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_down.png">
                                    <? endif; ?>

                                <? endif; ?>

                            <? endif; ?>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th class="tabela_header">Servidor</th>
                                <th class="tabela_header">Observa&ccedil;&atilde;o</th>
                                <th class="tabela_header">Valor</th>
                                <th class="tabela_header" width="80px;">Aprova&ccedil;&atilde;o</th>
                                            <? if ($responsavel == 2): ?>
                                <th class="tabela_header" width="80px;">Direx</th>
                                            <? endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$item->servidor;?></td>
                                <td><?=$item->observacao;?></td>
                                <td><?=number_format($item->valor, 2, ",", ".");?></td>
                                <td align="center">
                                                <? if ($responsavel == 1 ) : ?>
                                                    <? if (!isset ($item->autoriza_direx)): ?>
                                    <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/true">
                                        <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png"></a>
                                    <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/false">
                                        <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png"></a>
                                                    <? else: ?>
                                                        <? if ($item->autoriza_direx == 't') : ?>
                                    <img border="0" alt="Autorizado" title="Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                                                        <? else: ?>
                                    <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_down.png">
                                                        <? endif; ?>
                                                    <? endif; ?>
                                                <? else : ?>
                                                    <? if (!isset ($item->autoriza_super)): ?>
                                    <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/true">
                                        <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png"></a>
                                    <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/false">
                                        <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png"></a>
                                                    <? else: ?>
                                                        <? if ($item->autoriza_super == 't') : ?>
                                    <img border="0" alt="Autorizado" title="Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                                                        <? else: ?>
                                    <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_down.png">
                                                        <? endif; ?>

                                                    <? endif; ?>
                                                <? endif; ?></td>
                                <td>
                                                <? if ($responsavel == 2): ?>
                                                    <? if ($item->autoriza_direx == 't') : ?>
                                    <img border="0" alt="Autorizado" title="Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                                                    <? endif; ?>
                                                    <? if ($item->autoriza_direx == 'f'): ?>
                                    <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_down.png">
                                                    <? endif; ?>
                                                    <? if ($item->autoriza_direx == ''): ?>
                                    <a>n/a</a>
                                                    <? endif; ?>
                                                <? endif; ?>
                                </td>
                            </tr>

                                    <? else: ?>
                            <tr>
                                <td><?=$item->servidor;?></td>
                                <td><?=$item->observacao;?></td>
                                <td><?=number_format($item->valor, 2, ",", ".");?></td>
                                <td align="center">
                                                <? if ($responsavel == 1 ) : ?>
                                                    <? if (!isset ($item->autoriza_direx)): ?>
                                    <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/true">
                                        <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png"></a>
                                    <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/false">
                                        <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png"></a>
                                                    <? else: ?>
                                                        <? if ($item->autoriza_direx == 't') : ?>
                                    <img border="0" alt="Autorizado" title="Autorizado"width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                                                        <? else: ?>
                                    <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px"src="<?=  base_url()?>img/form/thumb_down.png">
                                                        <? endif; ?>
                                                    <? endif; ?>
                                                <? else : ?>
                                                    <? if (!isset ($item->autoriza_super)): ?>
                                    <a onclick="javascript: return confirm('Deseja realmente aprovar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/true">
                                        <img border="0" alt="Aprovar" src="<?=  base_url()?>img/form/accept.png"></a>
                                    <a onclick="javascript: return confirm('Deseja realmente rejeitar este incentivo?');"
                                       href="<?= base_url()?>giah/incentivo/aprovar/<?=$responsavel;?>/<?= $item->competencia;?>/<?= $item->servidor_id;?>/false">
                                        <img border="0" alt="Rejeitar" src="<?=  base_url()?>img/form/cross.png"></a>
                                                    <? else: ?>
                                                        <? if ($item->autoriza_super == 't') : ?>
                                    <img border="0" alt="Autorizado" title="Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                                                        <? else: ?>
                                    <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_down.png">
                                                        <? endif; ?>
                                                    <? endif; ?>
                                                <? endif; ?>
                                </td>
                                <td>
                                                <? if ($responsavel == 2): ?>
                                                    <? if ($item->autoriza_direx == 't') : ?>
                                    <img border="0" alt="Autorizado" title="Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_up.png">
                                                    <? endif; ?>
                                                    <? if ($item->autoriza_direx == 'f'): ?>
                                    <img border="0" alt="N&atilde;o Autorizado" title="N&atilde;o Autorizado" width="20px" height="20px" src="<?=  base_url()?>img/form/thumb_down.png">
                                                    <? endif; ?>
                                                    <? if ($item->autoriza_direx == ''): ?>
                                    <a>n/a</a>
                                                    <? endif; ?>
                                                <? endif; ?>
                                </td>
                            </tr>

                                        <? $y = $y+1;?>
                                    <? endif; ?>
                                    <? $lotacao = $item->lotacao; ?>
                                    <? $direcao = $item->direcao; ?>
                                    <? $z = $z+1;?>
                                    <? if ($i == $y ): ?>

                                        <? $y = 1; ?>
                            </tbody>
                    </table>
                </div>

                        <? endif; ?>
            </div>
                    <? if ($d == $z ): ?>

                        <? $z = 1; ?>
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