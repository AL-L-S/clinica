
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
        <? $tipoempresa = ""; ?>
        <table>
            <thead>

                <? if (count($empresa) > 0) { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7"><?= $empresa[0]->razao_social; ?></th>
                    </tr>
                    <?
                    $tipoempresa = $empresa[0]->razao_social;
                } else {
                    ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7">TODAS AS CLINICAS</th>
                    </tr>
                    <?
                    $tipoempresa = 'TODAS';
                }
                ?>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7">FATURAMENTO POR PER&Iacute;ODO DE COMPET&Ecirc;NCIA</th>
                </tr>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="9">&nbsp;</th>
                </tr>
                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7">EMPRESA: <?= $tipoempresa ?></th>
                </tr>

                <? if ($convenio == "0") { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7">CONVENIO:TODOS OS CONVENIOS</th>
                    </tr>
                <? } elseif ($convenio == "-1") { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7">CONVENIO:PARTICULARES</th>
                    </tr>
                <? } elseif ($convenio == "") { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7">CONVENIO: CONVENIOS</th>
                    </tr>
                <? } else { ?>
                    <tr>
                        <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7">CONVENIO: <?= $convenios[0]->nome; ?></th>
                    </tr>
                <? } ?>

                <tr>
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7">PERIODO: <?= $txtdata_inicio; ?> ate <?= $txtdata_fim; ?></th>
                </tr>
                <tr>
                    <th style='width:10pt;border:solid windowtext 1.0pt;
                        border-bottom:none;mso-border-top-alt:none;border-left:
                        none;border-right:none;' colspan="9">&nbsp;</th>
                </tr>

            <thead>
                <tr>
                    <th width="60px;">Guia</th>
                    <th width="90px;">Autoriza&ccedil;&atilde;o</th>
                    <th width="90px;">Procedimento</th>
                    <th width="60px;">Codigo</th>
                    <th width="90px;">Medico</th>
                    <th width="60px;">Data</th>
                    <th width="300px;">Nome</th>
                    <th >Obs.</th>
                    <th width="60px;">Valor Fatur.</th>
                    
                    <th colspan="3"><center>A&ccedil;&otilde;es</center></th>
            </tr>
            <tr>
                <th style='width:10pt;border:solid windowtext 1.0pt;
                    border-bottom:none;mso-border-top-alt:none;border-left:
                    none;border-right:none;' colspan="9">&nbsp;</th>
            </tr>
            </thead>
            <?php
            $financeiro = 'f';
            $valortotal = 0;
            $faturado = 0;
            $pendente = 0;
            $guia = "";
            $total = count($listar);
//                $consulta = $this->exame->listarguiafaturamento($_GET);
//                $total = $consulta->count_all_results();
            if (count($listar) > 0) {
                ?>
                <tbody>
                    <?php
                    foreach ($listar as $item) {
                        $valortotal = $valortotal + $item->valortotal;
                        $guia = $item->ambulatorio_guia_id;
                        if ($item->financeiro == 't') {
                            $financeiro = 't';
                        }
                        ?>
                        <tr>
                            <td ><?= $item->ambulatorio_guia_id; ?></td>
                            <td ><?= $item->autorizacao; ?></td>
                            <td ><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturamentodetalhes/" . $item->agenda_exames_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=500');"><?= substr($item->procedimento, 0, 16) . " ". $item->numero_sessao; ?></a></td>
                            <td ><?= $item->codigo; ?></td>
                            <td ><?= substr($item->medico, 0, 10); ?></td>
                            <td ><?= substr($item->data_criacao, 8, 2) . "/" . substr($item->data_criacao, 5, 2) . "/" . substr($item->data_criacao, 0, 4); ?></td>
                            <? if ($item->faturado == "t") { ?>
                                <td><font color="green"><?= $item->paciente; ?></td>
                                <?
                            } else {
                                ?>
                                <td><font color="c60000"><?= $item->paciente; ?></td>
                            <? } ?>

                            <td ><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/exame/alterarobservacaofaturar/" . $item->agenda_exames_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,\n\width=500,height=230');">
                                    =><?= $item->observacao_faturamento; ?></a></td>
                            <td ><?= number_format($item->valortotal, 2, ",", "."); ?></td>
                            <?
                            if ($item->faturado != "t") {
                                $faturado = 1;
                                ?>
                                <td width="40px;"><div class="bt_link">
                                        <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarconvenio/" . $item->agenda_exames_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=250');">Faturar
                                        </a></div>
                                </td>
                            <? } else { ?>
                                <td>Faturado&nbsp;</td>
                            <? }
                            ?>
                            <td width="40px;"><div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/faturarguia/<?= $item->ambulatorio_guia_id ?>/<?= $item->paciente_id ?>');" >
                                        Faturar guia</a></div>
                            </td>
                        </tr>

                    </tbody>
                    <?php
                }
            }
            ?>

                <tfoot>
                    <tr>
                        <th colspan="2" >
                            Registros: <?php echo $total; ?>
                        </th>
                        <th colspan="3" >
                            Valor Total: <?php echo number_format($valortotal, 2, ',', '.'); ?>
                        </th>
                        <? if ($faturado == 0 && $convenios != 0) { ?>
                                    <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/exame/fecharfinanceiro" method="post">
                <input type="hidden" class="texto3" name="dinheiro" value="<?= number_format($valortotal, 2, ',', '.'); ?>" readonly/>
                <input type="hidden" class="texto3" name="relacao" value="<?= $convenios[0]->credor_devedor_id; ?>"/>
                <input type="hidden" class="texto3" name="conta" value="<?= $convenios[0]->conta_id; ?>"/>
                <input type="hidden" class="texto3" name="data1" value="<?= $txtdata_inicio; ?>"/>
                <input type="hidden" class="texto3" name="data2" value="<?= $txtdata_fim; ?>"/>
                <input type="hidden" class="texto3" name="convenio" value="<?= $convenio; ?>"/>
                            <th colspan="3" align="center"><center>
                        <button type="submit" name="btnEnviar">Financeiro</button></center></th>
                         </form>
                <? } else { ?>
                    <th colspan="3" >PENDENTE DE FATURAMENTO
                    </th>
                <? } ?>
                </tr>
                </tfoot>
           
        </table>
        <br>
        <table border="1">
            <tr>
                <td bgcolor="c60000" width="4px;"></td>
                <td width="40px;">&nbsp;Em Aberto</td>
                <td bgcolor="green" width="4px;"></td>
                <td width="40px;">&nbsp;Faturado</td>
            </tr>
        </table>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>
<script type="text/javascript">


</script>

