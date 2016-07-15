<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
    ?>

    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarlaudoeco/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>/<?= $paciente_id ?>/<?= $procedimento_tuss_id ?>" method="post">
            <div >
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr><td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>
                            <td>Solicitante: <?= @$obj->_solicitante ?></td>
                        </tr>
                        <tr><td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                            <td>Sala:<?= @$obj->_sala ?></td>
                        </tr>
                    </table>
                </fieldset>
                <?
                $i = 0;
                if ($arquivo_pasta != false):
                    foreach ($arquivo_pasta as $value) {
                        $i++;
                    }
                endif
                ?>
                <fieldset>
                    <legend>Imagens : <font size="2"><b> <?= $i ?></b></legend>
                    <?
                    if ($arquivo_pasta != false):
                        foreach ($arquivo_pasta as $value) {
                            ?>
                            <a onclick="javascript:window.open('<?= base_url() . "upload/" . $exame_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');"><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"></a></li>
                            <?
                        }
                    endif
                    ?>
                    <!--                <ul id="sortable">
                    <?
                    if ($arquivo_pasta != false):
                        foreach ($arquivo_pasta as $value) {
                            ?>
                                                                                                                                                                                                                                                                                                                                                                        <li class="ui-state-default"> <input type="hidden"  value="<?= $value ?>" name="teste[]" class="size2" /><img  width="100px" height="100px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"></li>
                            <?
                        }
                    endif
                    ?>
                                    </ul>-->
                </fieldset>
                <table>
                    <tr><td width="60px;"><center>
                        <div class="bt_link_new">
                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/galeria/" . $exame_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                <font size="-1"> vizualizar imagem</font>
                            </a>
                        </div>
                        </td>
                        <td width="60px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/exame/anexarimagemmedico/" . $exame_id . "/" . @$obj->_sala_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=yes,width=1200,height=400');">
                                    <font size="-1"> adicionar/excluir</font>
                                </a>
                            </div></center>
                        </td>
                        <td width="60px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/carregarlaudoanterior/" . $paciente_id . "/" . $ambulatorio_laudo_id; ?> ');">
                                    <font size="-1">Laudo anterior</font>
                                </a>
                            </div></center>
                        </td>
                        <td width="250px;"><font size="-2"><center>
                            <div>
                                <h4>Imagens por pagina</h4>
                                <?
//                    var_dump(@$obj->_quantidade);
//                    die;
                                ?>
                                <? if (@$obj->_imagens == "2") { ?>
                                    <label><input type="radio" value="2" name="imagem" class="radios3" checked ="true"/> 2</label>
                                <? } else { ?>
                                    <label><input type="radio" value="2" name="imagem" class="radios3" /> 2</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "4") { ?>
                                    <label><input type="radio" value="4" name="imagem" class="radios3" checked ="true"/> 4</label>
                                <? } else { ?>
                                    <label><input type="radio" value="4" name="imagem" class="radios3" /> 4</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "6") { ?>
                                    <label><input type="radio" value="6" name="imagem" class="radios3" checked ="true"/> 6</label>
                                <? } else { ?>
                                    <label><input type="radio" value="6" name="imagem" class="radios3" /> 6</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "8") { ?>
                                    <label><input type="radio" value="8" name="imagem" class="radios3" checked ="true"/> 8</label>
                                <? } else { ?>
                                    <label><input type="radio" value="8" name="imagem" class="radios3" /> 8</label>
                                <? } ?>
                                <? if (@$obj->_imagens == "10") { ?>
                                    <label><input type="radio" value="10" name="imagem" class="radios3" checked ="true"/> 10</label>
                                <? } else { ?>
                                    <label><input type="radio" value="10" name="imagem" class="radios3" /> 10</label>
                                <? } ?>
                            </div>
                            </font></center></td>
                        <td width="60px;"><center>
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/modelolaudo"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650 ');">
                                    <font size="-1">laudo Modelo</font>
                                </a>
                            </div>
                            </td>
                            <td width="60px;"><center>
                                <div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/modelolinha"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=650');">
                                        <font size="-1">  Linha Modelo </font>
                                    </a>
                                </div></center>
                            </td>
                            <td width="60px;"><center>
                                <div class="bt_link_new">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/calculadora"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=400,height=450');">
                                        <font size="-1">  Calculadora </font>
                                    </a>
                                </div></center>
                            </td>
                            </table>

                            </div>
                            <div>

                                <fieldset>
                                    <legend>MEDIDAS E C&Aacute;LCULOS</legend>
                                    <table>
                                        <tr>
                                            <td><font size = -1>Peso:</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="Peso" id="Peso" class="texto01" value="<?= @$obj->_peso; ?>"/></font></td>
                                            <td width="60px;"><font size = -1>Kg</font></td>
                                            <td ><font size = -1>Altura:</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="Altura" id="Altura" class="texto01" value="<?= @$obj->_altura; ?>" onblur="history.go(0)"/></font></td>
                                            <td width="60px;"><font size = -1>Cm</font></td>
                                            <td ><font size = -1>Superf. corp.:</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="Superf" id="Superf" class="texto02" value="<?= number_format(@$obj->_superficie_corporea, 2, ',', '.'); ?>" readonly/></font></td>
                                            <td><font size = -1>m²</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="9">&nbsp;</font></td>

                                        </tr>
                                        <tr>
                                            <td colspan="2"><font size = -1></font></td>
                                            <td colspan="4"><font size = -1>PARAMETROS ESTRUTURAIS</font></td>
                                            <td ></td>
                                            <td colspan="2"><font size = -1>VALOR NORMAL</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>AORTA</font></td>
                                            <td width="60px;"></td>
                                            <td ></td>
                                            <td colspan="2"><font size = -1></font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Di&acirc;metro da aorta no seio de Valsalva  </font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="ao_diametro_raiz" id="ao_diametro_raiz" class="texto02"  value="<?= @$obj->_ao_diametro_raiz; ?>"/></font></td>
                                            <td ><font size = -1>mm</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 37</font></td>
                                            <td ><font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>ATR&Iacute;O ESQUERDO</font></td>
                                            <td width="60px;"></td>
                                            <td ></td>
                                            <td colspan="2"><font size = -1></font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Di&acirc;metro antero-posterior (modo M ou 2D)</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="ae_diametro" id="ae_diametro" class="texto02" value="<?= @$obj->_ae_diametro; ?>"/></font></td>
                                            <td ><font size = -1>mm</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 40</font></td>
                                            <td ><font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Volume (biplano)</font> </td>
                                            <td width="60px;"><font size = -1><input type="text" name="ae_volume" id="ae_volume" class="texto02" value="<?= @$obj->_ae_volume; ?>"/></font></td>
                                            <td ><font size = -1>mL</font></td>
                                            <td ><font size = -1></font></td>
                                            <td ><font size = -1>mL</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Volume indexado</font> </td>
                                            <td width="60px;"><font size = -1><input type="text" name="ae_volume_indexado" id="ae_volume_indexado" class="texto02" value="<?= @$obj->_ae_volume_indexado; ?>" readonly/></font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 34</font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Rela&ccedil;&atilde;o atr&iacute;o esquerdo / aorta</font> </td>
                                            <td width="60px;"><font size = -1><input type="text" name="ao_relacao_atrio_esquerdo_aorta" id="ao_relacao_atrio_esquerdo_aorta" class="texto02" value="<?= @$obj->_ao_relacao_atrio_esquerdo_aorta; ?>" readonly/></font></td>
                                            <td ><font size = -1></font></td>
                                            <td ><font size = -1>1.0 &plusmn; 0.5</font></td>
                                            <td ><font size = -1></font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>ATR&Iacute;O DIREITO</font></td>
                                            <td width="60px;"></td>
                                            <td ></td>
                                            <td colspan="2"><font size = -1></font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Volume (4C)</font> </td>
                                            <td width="60px;"><font size = -1><input type="text" name="ad_volume" id="ad_volume" class="texto02" value="<?= @$obj->_ad_volume; ?>"/></font></td>
                                            <td ><font size = -1>mL</font></td>
                                            <td ><font size = -1></font></td>
                                            <td ><font size = -1>mL</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Volume indexado</font> </td>
                                            <td width="60px;"><font size = -1><input type="text" name="ad_volume_indexado" id="ad_volume_indexado" class="texto02" value="<?= @$obj->_ad_volume_indexado; ?>" readonly/></font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 32</font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>VENTR&Iacute;CULO DIREITO</font></td>
                                            <td width="60px;"></td>
                                            <td ></td>
                                            <td colspan="2"><font size = -1></font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Di&acirc;metro PEL</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="vd_diametro_pel" id="vd_diametro_pel" class="texto02" value="<?= @$obj->_vd_diametro_pel; ?>"/></font></td>
                                            <td ><font size = -1>mm</font></font></td>
                                            <td ><font size = -1>&LessSlantEqual; 30</font></td>
                                            <td <font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Di&acirc;metro basal 2D</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="vd_diametro_basal" id="Diametro_telediastolico_vd" class="texto02" value="<?= @$obj->_vd_diametro_telediastolico; ?>"/></font></td>
                                            <td ><font size = -1>mm</font></font></td>
                                            <td ><font size = -1>&LessSlantEqual; 41</font></td>
                                            <td <font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Di&acirc;metro m&eacute;dio 2D</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="vd_diametro_medio" id="Diametro_telediastolico_vd" class="texto02" value="<?= @$obj->_vd_diametro_telediastolico; ?>"/></font></td>
                                            <td ><font size = -1>mm</font></font></td>
                                            <td ><font size = -1>&LessSlantEqual; 35</font></td>
                                            <td <font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Di&acirc;metro longitudinal 2D</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="vd_diametro_longitudinal" id="vd_diametro_longitudinal" class="texto02" value="<?= @$obj->_vd_diametro_longitudinal; ?>"/></font></td>
                                            <td ><font size = -1>mm</font></font></td>
                                            <td ><font size = -1>&LessSlantEqual; 83</font></td>
                                            <td <font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Espessura diastolica da parede Lateral</font></td>
                                            <td width="60px;"><input type="text" name="vd_espessura_parede" id="vd_espessura_parede"  class="texto02" value="<?= @$obj->_vd_espessura_parede; ?>" /></font></td>
                                            <td ><font size = -1>mm</font></font></td>
                                            <td ><font size = -1>&LessSlantEqual; 5</font></td>
                                            <td <font size = -1>mm</font></td>
                                        </tr>

                                        <tr>
                                            <td colspan="5"><font size = -1>TAPSE do VD:</font></td>
                                            <td width="60px;"><input type="text" name="vd_tapse" id="vd_tapse"  class="texto02" value="<?= @$obj->_vd_tapse; ?>" /></font></td>
                                            <td ><font size = -1>mm</font></font></td>
                                            <td ><font size = -1>&ge; 17</font></td>
                                            <td <font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Redu&ccedil;&atilde;o da &aacute;rea fracional</font></td>
                                            <td width="60px;"><input type="text" name="vd_espessura_parede" id="vd_espessura_parede"  class="texto02" value="<?= @$obj->_vd_espessura_parede; ?>" /></font></td>
                                            <td ><font size = -1></font></font></td>
                                            <td ><font size = -1>&ge; 35 %</font></td>
                                            <td <font size = -1></font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Onda S do anel lateral</font> </td>
                                            <td width="60px;"><input type="text" name="vd_onda_s" id="vd_onda_s" class="texto02" value="<?= @$obj->_vd_onda_s; ?>"/></font></td>
                                            <td ><font size = -1></font></td>
                                            <td ><font size = -1>&ge; 9,5 cm/s</td>
                                            <td ><font size = -1></font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>VENTR&Iacute;CULO ESQUERDO</font></td>
                                            <td width="60px;"></td>
                                            <td ></td>
                                            <td colspan="2"><font size = -1></font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Di&acirc;metro diast&oacute;lico</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="ve_diametro_diastolico" id="ve_diametro_diastolico" class="texto02" value="<?= @$obj->_ve_diametro_diastolico; ?>"/></font></td>
                                            <td ><font size = -1>mm</font></font></td>
                                            <td ><font size = -1>&LessSlantEqual; 58</font></td>
                                            <td <font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Di&acirc;metro  sist&oacute;lico</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="ve_diametro_sistolico" id="ve_diametro_sistolico" class="texto02" value="<?= @$obj->_ve_diametro_sistolico; ?>"/></font></td>
                                            <td ><font size = -1>mm</font></font></td>
                                            <td ><font size = -1>&LessSlantEqual; 39</font></td>
                                            <td <font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Espessura diastolica do septo interventricular </font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="septo_interventricular" id="septo_interventricular" class="texto02" value="<?= @$obj->_ve_septo_interventricular; ?>"/></font></td>
                                            <td ><font size = -1>mm</font></td>
                                            <td ><font size = -1>6-10</font></td>
                                            <td ><font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Espessura diastolica da parede posterior</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="parede_posterior" id="parede_posterior" class="texto02" value="<?= @$obj->_ve_parede_posterior; ?>" onblur="history.go(0)"/></font></td>
                                            <td ><font size = -1>mm</font></td>
                                            <td ><font size = -1>6-10</font></td>
                                            <td ><font size = -1>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Volume diastólico </font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="ve_volume_telediastolico" id="ve_volume_telediastolico" onkeyup="multiplica()"  class="texto02" value="<?= @$obj->_ve_volume_telediastolico; ?>"/></font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 74</font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Volume sistólico</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="ve_volume_telessistolico" id="ve_volume_telessistolico" class="texto02" value="<?= @$obj->_ve_volume_telessistolico; ?>"/></font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 31</font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Volume sistólico residual</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="ve_volume_sistolico_residual" id="ve_volume_sistolico_residual" class="texto02" value="<?= @$obj->_ve_volume_sistolico_residual; ?>" readonly/></font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 31</font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Volume diastólico indexado </font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="ve_volume_telediastolico_indexado" id="ve_volume_telediastolico_indexado" onkeyup="multiplica()"  class="texto02" value="<?= @$obj->_ve_volume_telediastolico_indexado; ?>" readonly/></font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 74</font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Volume sistólico indexado</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="ve_volume_telessistolico_indexado" id="ve_volume_telessistolico_indexado" class="texto02" value="<?= @$obj->_ve_volume_telessistolico_indexado; ?>" readonly/></font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 31</font></td>
                                            <td ><font size = -1>mL/m&sup2;</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Fração de ejeção </font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="fracao_ejecao" id="fracao_ejecao" class="texto02" value="<?= @$obj->_ve_fracao_ejecao; ?>" readonly/></font></td>
                                            <td ><font size = -1>%</font></td>
                                            <td ><font size = -1>&ge; 52 </font></td>
                                            <td ><font size = -1>%</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Fração de encurtamento </font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="fracao_encurtamento" id="fracao_encurtamento" class="texto02" value="<?= @$obj->_ve_fracao_encurtamento; ?>" readonly/></font></td>
                                            <td ><font size = -1>%</font></td>
                                            <td ><font size = -1>30-45</font> </td>
                                            <td ><font size = -1>%</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>&Iacute;ndice de massa</font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="massa_ventricular" id="massa_ventricular" class="texto02" value="<?= @$obj->_ve_massa_ventricular; ?>" readonly/></font></td>
                                            <td ><font size = -1>g/m&sup2;</font></td>
                                            <td ><font size = -1>&LessSlantEqual; 102  </font></td>
                                            <td ><font size = -1>g/m&sup2;</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -1>Espessura relativa das paredes </font></td>
                                            <td width="60px;"><font size = -1><input type="text" name="espessura_relativa" id="espessura_relativa" class="texto02" value="<?= @$obj->_ve_espessura_relativa_paredes; ?>" readonly/></font></td>
                                            <td ></td>
                                            <td ><font size = -1>&LessSlantEqual; 0,42</font></td>
                                            <td ></td>
                                        </tr>
                                    </table>
                                </fieldset>
                                <fieldset>
                                    <legend>Laudo</legend>
                                    <div>
                                        <?
                                        if (@$obj->_cabecalho == "") {
                                            $cabecalho = @$obj->_procedimento;
                                        } else {
                                            $cabecalho = @$obj->_cabecalho;
                                        }
                                        ?>
                                        <label>Nome do Laudo</label>
                                        <input type="text" id="cabecalho" class="texto10" name="cabecalho" value="<?= $cabecalho ?>"/>
                                    </div>
                                    <div>
                                        <label>Laudo</label>
                                        <select name="exame" id="exame" class="size2" >
                                            <option value='' >selecione</option>
                                            <?php foreach ($lista as $item) { ?>
                                                <option value="<?php echo $item->ambulatorio_modelo_laudo_id; ?>" ><?php echo $item->nome; ?></option>
                                            <?php } ?>
                                        </select>

                                        <label>Linha</label>
                                        <input type="text" id="linha2" class="texto02" name="linha2"/>
                <!--                        <select name="linha" id="linha" class="size2" >
                                            <option value='' >selecione</option>
                                        <?php foreach ($linha as $item) { ?>
                                                                                                                                                                                                            <option value="<?php echo $item->nome; ?>" ><?php echo $item->nome; ?></option>
                                        <?php } ?>
                                        </select>-->

                                        <div class="bt_link">
                                            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                                <font size="-1"> Imprimir</font></a></div>
                                    </div>
                                    <div>
                                        <textarea id="laudo" name="laudo" rows="30" cols="80" style="width: 80%"><?= @$obj->_texto; ?></textarea>
                                    </div>
                                    <div>
                                        <label>M&eacute;dico respons&aacutevel</label>
                                        <select name="medico" id="medico" class="size2">
                                            <option value=0 >selecione</option>
                                            <? foreach ($operadores as $value) : ?>
                                                <option value="<?= $value->operador_id; ?>"<?
                                                if (@$obj->_medico_parecer1 == $value->operador_id):echo 'selected';
                                                endif;
                                                ?>><?= $value->nome; ?></option>
                                                    <? endforeach; ?>
                                        </select>
                                        <?php
                                        if (@$obj->_revisor == "t") {
                                            ?>
                                            <input type="checkbox" name="revisor" checked ="true" /><label>Revisor</label>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="checkbox" name="revisor"  /><label>Revisor</label>
                                            <?php
                                        }
                                        ?>
                                        <select name="medicorevisor" id="medicorevisor" class="size2">
                                            <option value="">Selecione</option>
                                            <? foreach ($operadores as $valor) : ?>
                                                <option value="<?= $valor->operador_id; ?>"<?
                                                if (@$obj->_medico_parecer2 == $valor->operador_id):echo 'selected';
                                                endif;
                                                ?>><?= $valor->nome; ?></option>
                                                    <? endforeach; ?>
                                        </select>
                                        <?php
                                        if (@$obj->_assinatura == "t") {
                                            ?>
                                            <input type="checkbox" name="assinatura" checked ="true" /><label>Assinatura</label>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="checkbox" name="assinatura"  /><label>Assinatura</label>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if (@$obj->_rodape == "t") {
                                            ?>
                                            <input type="checkbox" name="rodape" checked ="true" /><label>Rodape</label>
                                            <?php
                                        } else {
                                            ?>
                                            <input type="checkbox" name="rodape"  /><label>Rodape</label>
                                            <?php
                                        }
                                        ?>


                                        <label>situa&ccedil;&atilde;o</label>
                                        <select name="situacao" id="situacao" class="size2" onChange="muda(this)">
                                            <option value='DIGITANDO'<?
                                            if (@$obj->_status == 'DIGITANDO'):echo 'selected';
                                            endif;
                                            ?> >DIGITANDO</option>
                                            <option value='FINALIZADO' <?
                                            if (@$obj->_status == 'FINALIZADO'):echo 'selected';
                                            endif;
                                            ?> >FINALIZADO</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label id="titulosenha">Senha</label>
                                        <input type="password" name="senha" id="senha" class="size1" />
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Impress&atilde;o</legend>
                                    <div>
                                        <table>
                                            <tr>
                                                <td >
                                                    <div class="bt_link">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaolaudoeco/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                                            <font size="-1"> Imprimir</font></a></div></td>
                                                <td ><div class="bt_link">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoimagem/<?= $ambulatorio_laudo_id ?>/<?= $exame_id ?>');">
                                                            <font size="-1"> fotos</font></a></div></td>
                                                <td ><div class="bt_link">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/pesquisarlaudoantigo');">
                                                            <font size="-1">L. Antigo</font></a></div></td>
                                                <td ><div class="bt_link">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $ambulatorio_laudo_id ?>');" >
                                                            <font size="-1">Arquivos</font></a></div></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div>


                        <!--<input name="textarea" id="textarea"></input>
                   <!-- <input name="textarea" id="textarea" ></input>-->

                                        <hr/>

                                        <button type="submit" name="btnEnviar">Salvar</button>
                                    </div>
                                </fieldset>
                                </form>

                            </div> 
                            </div> 
                            </div> 
                            </div> <!-- Final da DIV content -->
                            <style>
                                #sortable { list-style-type: none; margin: 0; padding: 0; width: 1300px; }
                                #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
                            </style>
                            <meta http-equiv="content-type" content="text/html;charset=utf-8" />
                            <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
                            <script type="text/javascript">

                                document.getElementById('titulosenha').style.display = "none";
                                document.getElementById('senha').style.display = "none";


                                $(document).ready(function() {
                                    $('#sortable').sortable();
                                });


                                $(document).ready(function() {

                                    function multiplica()
                                    {

                                        //CALCULO DA SUPERFICIE CORPOREA
                                        pesob1 = document.getElementById('Peso').value;
                                        alturae1 = document.getElementById('Altura').value;
                                        peso_altura = (pesob1 * alturae1) / 3600;
                                        meio = 0.5;
                                        superfh1 = Math.pow(peso_altura, meio);
                                        document.getElementById('Superf').value = superfh1.toFixed(2);

                                        //Relação atrío esquerdo / aorta
                                        ao_diametro_raiz = new Number(document.getElementById('ao_diametro_raiz').value);
                                        ae_diametro = new Number(document.getElementById('ae_diametro').value);
                                        relacao_atrio_esquerdo = ae_diametro / ao_diametro_raiz;
                                        document.getElementById('ao_relacao_atrio_esquerdo_aorta').value = relacao_atrio_esquerdo.toFixed(2);

                                        //VOLUME INDEXADO ATRIO ESQUERDO
                                        Superf = new Number(document.getElementById('Superf').value);
                                        ae_volume = new Number(document.getElementById('ae_volume').value);
                                        ae_volume_indexado = ae_volume / Superf;
                                        document.getElementById('ae_volume_indexado').value = ae_volume_indexado.toFixed(2);

                                        //VOLUME INDEXADO ATRIO DIREITO
                                        Superf = new Number(document.getElementById('Superf').value);
                                        ad_volume = new Number(document.getElementById('ad_volume').value);
                                        ad_volume_indexado = ad_volume / Superf;
                                        document.getElementById('ad_volume_indexado').value = ad_volume_indexado.toFixed(2);

                                        //VOLUME DIASTOLICO VE DDVE3 *7 / 2,4+ DDVE
                                        ve_diametro_diastolico = new Number(document.getElementById('ve_diametro_diastolico').value);
                                        calculo_ve_diametro_diastolico = (Math.pow(ve_diametro_diastolico, 3) * 7) / (2, 4 + ve_diametro_diastolico);
                                        document.getElementById('ve_volume_telediastolico').value = calculo_ve_diametro_diastolico.toFixed(2);

                                        //VOLUME SISTOLICO VE DSVE3 *7 / 2,4+ DSVE
                                        ve_diametro_sistolico = new Number(document.getElementById('ve_diametro_sistolico').value);
                                        calculo_ve_diametro_diastolico = (Math.pow(ve_diametro_sistolico, 3) * 7) / (2, 4 + ve_diametro_sistolico);
                                        document.getElementById('ve_volume_telessistolico').value = calculo_ve_diametro_diastolico.toFixed(2);

                                        //VOLUME SISTOLICO RESIDUAL -  VDF DO VE – VSF DO VE
                                        ve_volume_telediastolico = new Number(document.getElementById('ve_volume_telediastolico').value);
                                        ve_volume_telessistolico = new Number(document.getElementById('ve_volume_telessistolico').value);
                                        ve_volume_sistolico_residual = ve_volume_telediastolico - ve_volume_telessistolico;
                                        document.getElementById('ve_volume_sistolico_residual').value = ve_volume_sistolico_residual.toFixed(2);

                                        //ve_volume_telediastolico_indexado
                                        ve_volume_telediastolico = new Number(document.getElementById('ve_volume_telediastolico').value);
                                        Superf = new Number(document.getElementById('Superf').value);
                                        calculo_ve_volume_telediastolico_indexado = ve_volume_telediastolico / Superf;
                                        document.getElementById('ve_volume_telediastolico_indexado').value = calculo_ve_volume_telediastolico_indexado.toFixed(2);

                                        //ve_volume_telessistolico_indexado
                                        ve_volume_telessistolico = new Number(document.getElementById('ve_volume_telessistolico').value);
                                        Superf = new Number(document.getElementById('Superf').value);
                                        calculo_ve_volume_telessistolico_indexado = ve_volume_telessistolico / Superf;
                                        document.getElementById('ve_volume_telessistolico_indexado').value = calculo_ve_volume_telessistolico_indexado.toFixed(2);

                                        //fracao_ejecao - (VDF DO VE – VSF DO VE) / VDF DO VE
                                        ve_volume_telediastolico = new Number(document.getElementById('ve_volume_telediastolico').value);
                                        ve_volume_telessistolico = new Number(document.getElementById('ve_volume_telessistolico').value);
                                        calculo_fracao_ejecao = (ve_volume_telediastolico - ve_volume_telessistolico) / ve_volume_telediastolico;
                                        document.getElementById('fracao_ejecao').value = calculo_fracao_ejecao.toFixed(2);

                                        //espessura_relativa - (2*PPVE)/DDVE 
                                        parede_posterior = new Number(document.getElementById('parede_posterior').value);
                                        ve_diametro_diastolico = new Number(document.getElementById('ve_diametro_diastolico').value);
                                        calculo_espessura_relativa = ((ve_diametro_diastolico - ve_diametro_sistolico) / ve_diametro_diastolico);
                                        document.getElementById('espessura_relativa').value = calculo_espessura_relativa.toFixed(2);

                                        //massa_ventricular - [(DDVE + SEPTO + PPVE)3 – (DDVE)3 ]* 1,04  *0,8+0,6
                                        parede_posterior = new Number(document.getElementById('parede_posterior').value);
                                        ve_diametro_diastolico = new Number(document.getElementById('ve_diametro_diastolico').value);
                                        septo_interventricular = new Number(document.getElementById('septo_interventricular').value);
                                        calculo_massa_ventricular = (Math.pow(ve_diametro_diastolico + septo_interventricular + parede_posterior, 3) - Math.pow(ve_diametro_diastolico, 3)) * 1,04 * 0,8+0,6;
                                        document.getElementById('massa_ventricular').value = calculo_massa_ventricular.toFixed(2);

                                    }
                                    multiplica();


                                });



                                function muda(obj) {
                                    if (obj.value != 'DIGITANDO') {
                                        document.getElementById('titulosenha').style.display = "block";
                                        document.getElementById('senha').style.display = "block";
                                    } else {
                                        document.getElementById('titulosenha').style.display = "none";
                                        document.getElementById('senha').style.display = "none";
                                    }
                                }



                                tinyMCE.init({
                                    // General options
                                    mode: "textareas",
                                    theme: "advanced",
                                    plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                                    // Theme options
                                    theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                                    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                                    theme_advanced_toolbar_location: "top",
                                    theme_advanced_toolbar_align: "left",
                                    theme_advanced_statusbar_location: "bottom",
                                    theme_advanced_resizing: true,
                                    // Example content CSS (should be your site CSS)
                                    //                                    content_css : "css/content.css",
                                    content_css: "js/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/img/content.css",
                                    // Drop lists for link/image/media/template dialogs
                                    template_external_list_url: "lists/template_list.js",
                                    external_link_list_url: "lists/link_list.js",
                                    external_image_list_url: "lists/image_list.js",
                                    media_external_list_url: "lists/media_list.js",
                                    // Style formats
                                    style_formats: [
                                        {title: 'Bold text', inline: 'b'},
                                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                                        {title: 'Table styles'},
                                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                                    ],
                                    // Replace values for the template plugin
                                    template_replace_values: {
                                        username: "Some User",
                                        staffid: "991234"
                                    }

                                });

                                $(function() {
                                    $('#exame').change(function() {
                                        if ($(this).val()) {
                                            //$('#laudo').hide();
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/modeloslaudo', {exame: $(this).val(), ajax: true}, function(j) {
                                                options = "";

                                                options += j[0].texto;
                                                //                                                document.getElementById("laudo").value = options

                                                $('#laudo').val(options)
                                                var ed = tinyMCE.get('laudo');
                                                ed.setContent($('#laudo').val());

                                                //$('#laudo').val(options);
                                                //$('#laudo').html(options).show();
                                                //                                                $('.carregando').hide();
                                                //history.go(0) 
                                            });
                                        } else {
                                            $('#laudo').html('value=""');
                                        }
                                    });
                                });

                                $(function() {
                                    $('#linha').change(function() {
                                        if ($(this).val()) {
                                            //$('#laudo').hide();
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/modeloslinhas', {linha: $(this).val(), ajax: true}, function(j) {
                                                options = "";

                                                options += j[0].texto;
                                                //                                                document.getElementById("laudo").value = $('#laudo').val() + options
                                                $('#laudo').val() + options
                                                var ed = tinyMCE.get('laudo');
                                                ed.setContent($('#laudo').val());
                                                //$('#laudo').html(options).show();
                                            });
                                        } else {
                                            $('#laudo').html('value=""');
                                        }
                                    });
                                });

                                $(function() {
                                    $("#linha2").autocomplete({
                                        source: "<?= base_url() ?>index?c=autocomplete&m=linhas",
                                        minLength: 1,
                                        focus: function(event, ui) {
                                            $("#linha2").val(ui.item.label);
                                            return false;
                                        },
                                        select: function(event, ui) {
                                            $("#linha2").val(ui.item.value);
                                            tinyMCE.triggerSave(true, true);
                                            document.getElementById("laudo").value = $('#laudo').val() + ui.item.id
                                            $('#laudo').val() + ui.item.id
                                            var ed = tinyMCE.get('laudo');
                                            ed.setContent($('#laudo').val());
                                            //$( "#laudo" ).val() + ui.item.id;
                                            document.getElementById("linha2").value = ''
                                            return false;
                                        }
                                    });
                                });

                                $(function(a) {
                                    $('#anteriores').change(function() {
                                        if ($(this).val()) {
                                            //$('#laudo').hide();
                                            $('.carregando').show();
                                            $.getJSON('<?= base_url() ?>autocomplete/laudosanteriores', {anteriores: $(this).val(), ajax: true}, function(i) {
                                                option = "";

                                                option = i[0].texto;
                                                tinyMCE.triggerSave();
                                                document.getElementById("laudo").value = option
                                                //$('#laudo').val(options);
                                                //$('#laudo').html(options).show();
                                                $('.carregando').hide();
                                                history.go(0)
                                            });
                                        } else {
                                            $('#laudo').html('value="texto"');
                                        }
                                    });
                                });
                                //bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
                                $('.jqte-test').jqte();








                            </script>


                            <? if ($mensagem == 2) { ?>
                                <script type="text/javascript">
                                    alert("Sucesso ao finalizar Laudo");
                                </script>
                                <?
                            }
                            if ($mensagem == 1) {
                                ?>
                                <script type="text/javascript">
                                    alert("Erro ao finalizar Laudo");
                                </script>
                                <?
                            }