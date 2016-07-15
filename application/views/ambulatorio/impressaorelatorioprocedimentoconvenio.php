<div class="content"> <!-- Inicio da DIV content -->
    <?
    $i = 0;
    ?>
    <table>
        <thead>

            <tr>
                <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">FATURAMENTO POR GRUPO DE PRODUTO</th>
            </tr>
            <? if ($grupo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: TODOS</th>
                </tr>
            <? } elseif ($grupo == "1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: SEM RM</th>
                </tr>
            <? } else { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">ESPECIALIDADE: <?= $grupo; ?></th>
                </tr>
            <? } ?>
            <? if ($conveniotipo == "0") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">TODOS OS CONVENIOS</th>
                </tr>
            <? } elseif ($conveniotipo == "-1") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">PARTICULARES</th>
                </tr>
            <? } elseif ($conveniotipo == "") { ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIOS</th>
                </tr>
            <?
            } else {
                $i = 1;
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">CONVENIO: <?= $convenios[0]->nome; ?></th>
                </tr>

<? } ?>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="5">&nbsp;</th>
            </tr>
            <? if (count($relatorio) > 0) {
                ?>

                <tr>
                    
                    <td><font width="180px;"></td>
                    <td class="tabela_teste"><font size="-1">Codigo</th>
                    <td class="tabela_teste"><font size="-1">Procedimento</th>
                    <td class="tabela_teste"><font size="-1">Data atualiza&ccedil;&atilde;o</th>
                    <td class="tabela_teste"><font size="-1">Valor</th>
                </tr>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="5">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                $y = 0;
                $qtde = 0;
                $qtdetotal = 0;
                $perc = 0;
                $perctotal = 0;

                foreach ($relatorio as $item) :
                    $i++;


                    if ($i == 1 || $item->convenio == $convenio) {
                        if ($i == 1) {
                            $y++;
                            ?>
                            <tr>
                                <td colspan="4"><font ><b><?= utf8_decode($item->convenio); ?></b></td>
                            </tr>
                        <? }
                        ?>
                        <tr>
                            <td><font width="180px;"></td>
                            <td><font size="-2"><?= $item->codigo; ?></td>
                            <td><font size="-2"><?= $item->procedimento; ?></td>
                            <td><font size="-2"><?= substr($item->data_atualizacao, 8,2) . "/" . substr($item->data_atualizacao, 5,2) . "/" . substr($item->data_atualizacao, 0,4); ?></td>
                            <td><font size="-2"><?= number_format($item->valortotal, 2, ',', '.') ?></td>
                        </tr>
                        <?php
    
                        $convenio = $item->convenio;
                    } else {
                        ?>  

                        <tr>
                            <td colspan="3"><font ><b><?= utf8_decode($item->convenio); ?></b></td>
                        </tr>
                        <tr>
                            <td><font width="180px;"></td>
                            <td><font size="-2"><?= $item->procedimento; ?></td>
                            <td><font size="-2"><?= substr($item->data_atualizacao, 8,2) . "/" . substr($item->data_atualizacao, 5,2) . "/" . substr($item->data_atualizacao, 0,4); ?></td>
                            <td><font size="-2"><?= number_format($item->valortotal, 2, ',', '.') ?></td>
                        </tr>


                        <?
                        $convenio = $item->convenio;

                        $y = 0;
                    }
                endforeach;
                ?>
            </tbody>
        </table>
        <hr>
     
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $("#accordion").accordion();
    });

</script>
