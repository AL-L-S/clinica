
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
        <?
        $tipoempresa = "";
        $perfil_id = $this->session->userdata('perfil_id');
        ?>

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
                    <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="7">PERIODO: <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_inicio))); ?> ate <?= str_replace("-", "/", date("d-m-Y", strtotime($txtdata_fim))); ?></th>
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
                    <th width="130px;">Procedimento</th>
                    <th width="90px;"><div style="margin-left:8pt;">Convenio</div></th>
                    <th width="60px;">Codigo</th>
                    <th width="90px;">Medico</th>
                    <th width="130px;">Data Atendi</th>
                    <th width="130px;">Data Fatura</th>
                    <th width="110px;">Nome</th>
                    <th width="180px;">Obs.</th>
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
            $valortotal_faturado = 0;
            $valortotal_naofaturado = 0;
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
                        if ($item->faturado == 't') {
                            $valortotal_faturado = $valortotal_faturado + $item->valortotal;
                        } else {
                            $valortotal_naofaturado = $valortotal_naofaturado + $item->valortotal;
                        }

                        $guia = $item->ambulatorio_guia_id;
                        if ($item->financeiro == 't') {
                            $financeiro = 't';
                        }
                        ?>
                        <tr>
                            <td ><a onmouseover="style = 'color:red;cursor: pointer;'" onmouseout="style = 'color:black;'"style="" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoguiaconsultaspsadt/<?= $item->ambulatorio_guia_id; ?>');">
                                    <?= $item->ambulatorio_guia_id ?>
                                </a></td>
                            <td ><?= $item->autorizacao; ?></td>
                            <td ><a style="cursor: pointer; color: blue;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturamentodetalhes/" . $item->agenda_exames_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=700');"><?= substr($item->procedimento, 0, 16) . " " . $item->numero_sessao; ?></a></td>
                            <td ><div style="margin-left:8pt;"><?= $item->nome; ?></div></td>
                            <td ><?= $item->codigo; ?></td>
                            <td >
                                <? if (count($item->medico) > 0) { ?>
                                    <a style="text-decoration: none; color: black;" title="<? echo $item->medico; ?>" href="#"><font color="c60000"><? echo substr($item->medico, 0, 10); ?>(...)</a>
                                    <?
                                } else {
                                    echo $item->medico;
                                }
                                ?>
                            </td>
                            <td ><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td ><?= substr($item->data_faturar, 8, 2) . "/" . substr($item->data_faturar, 5, 2) . "/" . substr($item->data_faturar, 0, 4); ?></td>
                            <? if ($item->faturado == "t") { ?>
                                <td>
                                    <font color="green"><? echo $item->paciente; ?>

                                </td>
                                <?
                            } else {
                                ?>
                                <td>
                                    <font color="c60000"><? echo $item->paciente; ?>

                                </td>
                            <? } ?>

                            <td >
                                <div class="observacao">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/exame/alterarobservacaofaturar/" . $item->agenda_exames_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,\n\width=500,height=230');">
                                        =><?= $item->observacao_faturamento; ?>
                                    </a>
                                </div>
                            </td>
                            <td ><?= number_format($item->valortotal, 2, ",", "."); ?></td>
                            <?
                            if ($item->faturado != "t") {
                                $faturado = 1;
                                ?>
                                <td width="40px;"><div class="bt_link">
                                        <? if ($perfil_id != 10) { ?>


                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarconvenio/" . $item->agenda_exames_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=250');">Faturar
                                            </a>
                                        <? } else { ?>
                                            Faturar  
                                        <? } ?>
                                    </div>
                                </td>
                            <? } else { ?>
                                <td>Faturado&nbsp;</td>
                            <? }
                            ?>



                            <td width="110px;">
                                <div class="bt_link" style="width: 100pt">
                                    <? if ($perfil_id != 10) { ?>
                                        <a style="width: 100pt" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/exame/faturarguia/<?= $item->ambulatorio_guia_id ?>/<?= $item->paciente_id ?>');" >
                                            Faturar guia
                                        </a>
                                    <? } else { ?>
                                        Faturar guia
                                    <? } ?>
                                </div>
                            </td>

                            <td width="40px;"><div class="bt_link">
                                    <? if ($item->faturado == "t") { ?>

                                        <? if ($item->situacao_faturamento == "") { ?>
                                            <? if ($perfil_id != 10) { ?>

                                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarconveniostatus/" . $item->agenda_exames_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=250');">
                                                    Situação
                                                </a>

                                            <? } else { ?>
                                                Situação
                                            <? }
                                            ?>
                                        <? } ?>
                                        <? if ($item->situacao_faturamento == "GLOSADO") { ?>       
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarconveniostatus/" . $item->agenda_exames_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=250');">
                                                Glosado
                                            </a>
                                        <? } ?> 
                                        <? if ($item->situacao_faturamento == "PAGO") { ?>        
                                            Pago
                                        <? } ?>

                                    <? } else { ?>   
                                        Situação
                                    <? }
                                    ?>
                                </div>
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
                    <th colspan="2" >
                        Valor Total: <?php echo number_format($valortotal, 2, ',', '.'); ?>
                    </th>
                    <th colspan="3" >
                        Valor Total Faturado: <?php echo number_format($valortotal_faturado, 2, ',', '.'); ?>
                    </th>
                    <th colspan="4" >
                        Valor Total Não Faturado: <?php echo number_format($valortotal_naofaturado, 2, ',', '.'); ?>
                    </th>
                    <? if ($financeiro == 't') { ?>
                        <td width="40px;" style="color:red;">Faturamento Fechado</td>
                    <? } elseif ($faturado == 0 && $convenios != 0) { ?>
                <form name="form_caixa" id="form_caixa" action="<?= base_url() ?>ambulatorio/exame/fecharfinanceiro" method="post">
                    <input type="hidden" class="texto3" name="dinheiro" value="<?= number_format($valortotal, 2, ',', '.'); ?>" readonly/>
                    <input type="hidden" class="texto3" name="relacao" value="<?= $convenios[0]->credor_devedor_id; ?>"/>
                    <input type="hidden" class="texto3" name="conta" value="<?= $convenios[0]->conta_id; ?>"/>
                    <input type="hidden" class="texto3" name="data1" value="<?= $txtdata_inicio; ?>"/>
                    <input type="hidden" class="texto3" name="data2" value="<?= $txtdata_fim; ?>"/>
                    <input type="hidden" class="texto3" name="convenio" value="<?= $convenio; ?>"/>
                    <input type="hidden" class="texto3" name="empresa" value="<?= $_POST['empresa']; ?>"/>
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
<style>
    .observacao{
        max-height: 50pt;
        max-width: 170px;

        word-wrap: break-word;
        overflow-y: auto;
    }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/scripts.js" ></script>
<script type="text/javascript">


</script>

