<div class="content ficha_ceatox">
    <div class="clear"></div>
    <h3 class="h3_title"><center>Laudo Eco</center></h3>
    <form name="ficha_form" id="ficha_form" action="<?= base_url() ?>eco/eco/gravar/" method="POST">
        <fieldset>
        <legend>Nome</legend>
        <input type="text" name="nome" class="size10" />
        <label>M&eacute;dico</label>
        <select name="medico">
            <option>Dra Ana Aécia Alexandrino de Oliveira</option>
            <option>Dra Marilia H. Bessa Gadelha</option>
        </select>
        </fieldset>
        <fieldset>
            <legend>MEDIDAS</legend>

            <!-- Início da tabela de Observações gerais -->
            <table border="0">

                <tbody>
                    <tr class="linha1"><td width="20%">Peso</td><td width="20%"><input type="text" name="peso" class="size2" /></td><td></td></tr>
                    <tr class="linha1"><td width="20%">Altura</td><td width="20%"><input type="text" name="altura" class="size2" /></td><td></td></tr>
                    <tr class="linha1"><td width="20%">Di&acirc;m. Diast&oacute;lico do VE</td><td width="20%"><input type="text" name="diamdiasve" class="size2" /></td><td>36-56 mm</td></tr>
                    <tr class="linha1"><td width="20%">Di&acirc;m. Sist&oacute;lico Final do VE</td><td width="20%"><input type="text" name="diamsistve" class="size2" /></td><td>25-40 mm</td></tr>
                    <tr class="linha1"><td width="20%">Espes. Diast&oacute;lica Septo</td><td width="20%"><input type="text" name="espdiassep" class="size2" /></td><td>07-11 mm</td></tr>
                    <tr class="linha1"><td width="20%">Espes. Diast&oacute;lica PP</td><td width="20%"><input type="text" name="espdiaspp" class="size2" /></td><td>07-11 mm</td></tr>
                    <tr class="linha1"><td width="20%">Fra&ccedil;&atilde;o de Eje&ccedil;&atilde;o</td><td width="20%"><input type="text" name="fraeje" class="size2" /></td><td>>55%</td></tr>
                    <tr class="linha1"><td width="20%">Perc. Encurt. Sist. VE</td><td width="20%"><input type="text" name="percenc" class="size2" /></td><td>>27%</td></tr>
                    <tr class="linha1"><td width="20%">Di&acirc;metro Aorta</td><td width="20%"><input type="text" name="diamaorta" class="size2" /></td><td><37 mm</td></tr>
                    <tr class="linha1"><td width="20%">Di&acirc;metro AE</td><td width="20%"><input type="text" name="diamae" class="size2" /></td><td>22 - 40 mm</td></tr>
                    <tr class="linha1"><td width="20%">Diam Basal do VD</td><td width="20%"><input type="text" name="diamvd" class="size2" /></td><td><42 %</td></tr>
                </tbody>
            </table>
            <!-- Fim da tabela de Observações gerais -->
        </fieldset>
        <fieldset>
            <legend>OBSERVA&Ccedil;&Otilde;ES GERAIS</legend>

            <!-- Início da tabela de Observações gerais -->
            <table id="table_observacao_geral" border="0">
                <thead>
                    <tr>
                        <td>Descrição</td>
                        <td>&nbsp;</td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <div class="bt_link_new mini_bt">
                                <a href="#" id="plusobservacao">Adicionar Ítem</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr class="linha1">
                        <td>
                            <select  name="txtObservacaoGeral[1]" class="size10" >
                                <option value="-1">Selecione</option>
                                <? foreach ($ObservacoesGerais as $item) : ?>
                                    <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <a href="#" class="delete">Excluir</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Fim da tabela de Observações gerais -->
            </fieldset>
            <fieldset>
                <legend>VENTR&Iacute;CULO ESQUERDO - DIMENS&Otilde;ES E HIPERTROFIA</legend>
                <!-- Início da tabela de Observações gerais -->
                <table id="table_ventriculo_esquerdo_dimensoes_hipertrofia" border="0">
                    <thead>
                        <tr>
                            <td>Descrição</td>
                            <td>&nbsp;</td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <div class="bt_link_new mini_bt">
                                    <a href="#" id="plusventriculo_esquerdo_dimensoes_hipertrofia">Adicionar Ítem</a>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr class="linha1">
                            <td>
                                <select  name="txtVentEsquerdoDimensoesHipertrofia[1]" class="size10" >
                                    <option value="-1">Selecione</option>
                                <? foreach ($VentEsquerdoDimensoesHipertrofia as $item) : ?>
                                        <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <a href="#" class="delete">Excluir</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Fim da tabela de Observações gerais -->
                </fieldset>
                <fieldset>
                    <legend>VENTR&Iacute;CULO ESQUERDO - AN&Aacute;LISE SEGMENTAR</legend>

                    <!-- Início da tabela de Observações gerais -->
                    <table id="table_ventriculo_esquerdo_analise_segmentar" border="0">
                        <thead>
                            <tr>
                                <td>Descrição</td>
                                <td>&nbsp;</td>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <div class="bt_link_new mini_bt">
                                        <a href="#" id="plusventriculo_esquerdo_analise_segmentar">Adicionar Ítem</a>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr class="linha1">
                                <td>
                                    <select  name="txtVentEsquerdoAnaliseSgmentar[1]" class="size10" >
                                        <option value="-1">Selecione</option>
                                <? foreach ($VentEsquerdoAnaliseSgmentar as $item) : ?>
                                            <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="#" class="delete">Excluir</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Fim da tabela de Observações gerais -->
                    </fieldset>
                    <fieldset>
                        <legend>VENTR&Iacute;CULO ESQUERDO - FUN&Ccedil;&Otilde;ES</legend>

                        <!-- Início da tabela de Observações gerais -->
                        <table id="table_ventriculo_esquerdo_funcoes" border="0">
                            <thead>
                                <tr>
                                    <td>Descrição</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <div class="bt_link_new mini_bt">
                                            <a href="#" id="plusventriculo_esquerdo_funcoes">Adicionar Ítem</a>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr class="linha1">
                                    <td>
                                        <select  name="txtVentEsquerdoFuncoes[1]" class="size10" >
                                            <option value="-1">Selecione</option>
                                <? foreach ($VentEsquerdoFuncoes as $item) : ?>
                                                <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <a href="#" class="delete">Excluir</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Fim da tabela de Observações gerais -->
                        </fieldset>
                        <fieldset>
                            <legend>AORTA</legend>

                            <!-- Início da tabela de Observações gerais -->
                            <table id="table_aorta" border="0">
                                <thead>
                                    <tr>
                                        <td>Descrição</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <div class="bt_link_new mini_bt">
                                                <a href="#" id="plusaorta">Adicionar Ítem</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr class="linha1">
                                        <td>
                                            <select  name="txtAorta[1]" class="size10" >
                                                <option value="-1">Selecione</option>
                                <? foreach ($Aorta as $item) : ?>
                                                    <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <a href="#" class="delete">Excluir</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- Fim da tabela de Observações gerais -->
                            </fieldset>
                            <fieldset>
                                <legend>V&Aacute;LVULA A&Oacute;RTICA</legend>

                                <!-- Início da tabela de Observações gerais -->
                                <table id="table_valvula_aortica" border="0">
                                    <thead>
                                        <tr>
                                            <td>Descrição</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bt_link_new mini_bt">
                                                    <a href="#" id="plusvalvulaaortica">Adicionar Ítem</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr class="linha1">
                                            <td>
                                                <select  name="txtValvulaAortica[1]" class="size10" >
                                                    <option value="-1">Selecione</option>
                                <? foreach ($ValvulaAortica as $item) : ?>
                                                        <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href="#" class="delete">Excluir</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Fim da tabela de Observações gerais -->
                                </fieldset>
                                <fieldset>
                                    <legend>&Aacute;TRIO ESQUERDO</legend>

                                    <!-- Início da tabela de Observações gerais -->
                                    <table id="table_atrio_esquerdo" border="0">
                                        <thead>
                                            <tr>
                                                <td>Descrição</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="bt_link_new mini_bt">
                                                        <a href="#" id="plusatrioesquerdo">Adicionar Ítem</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr class="linha1">
                                                <td>
                                                    <select  name="txtAtrioEsquerdo[1]" class="size10" >
                                                        <option value="-1">Selecione</option>
                                <? foreach ($AtrioEsquerdo as $item) : ?>
                                                            <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="delete">Excluir</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- Fim da tabela de Observações gerais -->
                                    </fieldset>
                                    <fieldset>
                                        <legend>V&Aacute;LVULA MITRAL</legend>

                                        <!-- Início da tabela de Observações gerais -->
                                        <table id="table_valvula_mitral" border="0">
                                            <thead>
                                                <tr>
                                                    <td>Descrição</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="bt_link_new mini_bt">
                                                            <a href="#" id="plusvalvulamitral">Adicionar Ítem</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <tr class="linha1">
                                                    <td>
                                                        <select  name="txtValvulamitral[1]" class="size10" >
                                                            <option value="-1">Selecione</option>
                                <? foreach ($Valvulamitral as $item) : ?>
                                                                <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="delete">Excluir</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- Fim da tabela de Observações gerais -->
                                        </fieldset>
                                        <fieldset>
                                            <legend>VENTR&Iacute;CULO DIREITO</legend>

                                            <!-- Início da tabela de Observações gerais -->
                                            <table id="table_ventriculo_direito" border="0">
                                                <thead>
                                                    <tr>
                                                        <td>Descrição</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="bt_link_new mini_bt">
                                                                <a href="#" id="plusventriculodireito">Adicionar Ítem</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <tr class="linha1">
                                                        <td>
                                                            <select  name="txtVentriculoireito[1]" class="size10" >
                                                                <option value="-1">Selecione</option>
                                <? foreach ($Ventriculoireito as $item) : ?>
                                                                    <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="delete">Excluir</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- Fim da tabela de Observações gerais -->
                                            </fieldset>
                                            <fieldset>
                                                <legend>&Aacute;TRIO DIREITO</legend>

                                                <!-- Início da tabela de Observações gerais -->
                                                <table id="table_atrio_direito" border="0">
                                                    <thead>
                                                        <tr>
                                                            <td>Descrição</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="bt_link_new mini_bt">
                                                                    <a href="#" id="plusatriodireito">Adicionar Ítem</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <tr class="linha1">
                                                            <td>
                                                                <select  name="txtAtrioDireito[1]" class="size10" >
                                                                    <option value="-1">Selecione</option>
                                <? foreach ($AtrioDireito as $item) : ?>
                                                                        <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="delete">Excluir</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- Fim da tabela de Observações gerais -->
                                                </fieldset>
                                                <fieldset>
                                                    <legend>V&Aacute;LVULA TRIC&Uacute;SPIDE</legend>

                                                    <!-- Início da tabela de Observações gerais -->
                                                    <table id="table_valvula_tricuspide" border="0">
                                                        <thead>
                                                            <tr>
                                                                <td>Descrição</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="bt_link_new mini_bt">
                                                                        <a href="#" id="plusvalvulatricuspide">Adicionar Ítem</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <tr class="linha1">
                                                                <td>
                                                                    <select  name="txtValvulaTricuspide[1]" class="size10" >
                                                                        <option value="-1">Selecione</option>
                                <? foreach ($ValvulaTricuspide as $item) : ?>
                                                                            <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="delete">Excluir</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Fim da tabela de Observações gerais -->
                                                    </fieldset>
                                                <fieldset>
                                                    <legend>V&Aacute;LVULA PULMONAR</legend>

                                                    <!-- Início da tabela de Observações gerais -->
                                                    <table id="table_valvula_pulmonar" border="0">
                                                        <thead>
                                                            <tr>
                                                                <td>Descrição</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="bt_link_new mini_bt">
                                                                        <a href="#" id="plusvalvulapulmonar">Adicionar Ítem</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <tr class="linha1">
                                                                <td>
                                                                    <select  name="txtValvulapulmonar[1]" class="size10" >
                                                                        <option value="-1">Selecione</option>
                                <? foreach ($Valvulapulmonar as $item) : ?>
                                                                            <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="delete">Excluir</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Fim da tabela de Observações gerais -->
                                                    </fieldset>
                                                <fieldset>
                                                    <legend>PERIC&Aacute;RDIO</legend>

                                                    <!-- Início da tabela de Observações gerais -->
                                                    <table id="table_pericardio" border="0">
                                                        <thead>
                                                            <tr>
                                                                <td>Descrição</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="bt_link_new mini_bt">
                                                                        <a href="#" id="pluspericardio">Adicionar Ítem</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <tr class="linha1">
                                                                <td>
                                                                    <select  name="txtPericardio[1]" class="size10" >
                                                                        <option value="-1">Selecione</option>
                                <? foreach ($Pericardio as $item) : ?>
                                                                            <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="delete">Excluir</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Fim da tabela de Observações gerais -->
                                                    </fieldset>
                                                <fieldset>
                                                    <legend>ESTUDO PR&Oacute;TESES</legend>

                                                    <!-- Início da tabela de Observações gerais -->
                                                    <table id="table_estudo_proteses" border="0">
                                                        <thead>
                                                            <tr>
                                                                <td>Descrição</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="bt_link_new mini_bt">
                                                                        <a href="#" id="plusestudoproteses">Adicionar Ítem</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <tr class="linha1">
                                                                <td>
                                                                    <select  name="txtEstudoProteses[1]" class="size10" >
                                                                        <option value="-1">Selecione</option>
                                <? foreach ($EstudoProteses as $item) : ?>
                                                                            <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="delete">Excluir</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Fim da tabela de Observações gerais -->
                                                    </fieldset>
                                                <fieldset>
                                                    <legend>AN&Aacute;LISE DE FLUXO PELO DOPPLER</legend>

                                                    <!-- Início da tabela de Observações gerais -->
                                                    <table id="table_analise_fluxo_doppler" border="0">
                                                        <thead>
                                                            <tr>
                                                                <td>Descrição</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="bt_link_new mini_bt">
                                                                        <a href="#" id="plusanalisefluxodoppler">Adicionar Ítem</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <tr class="linha1">
                                                                <td>
                                                                    <select  name="txtAnaliseFluxoDoppler[1]" class="size10" >
                                                                        <option value="-1">Selecione</option>
                                <? foreach ($AnaliseFluxoDoppler as $item) : ?>
                                                                            <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="delete">Excluir</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Fim da tabela de Observações gerais -->
                                                    </fieldset>
                                                <fieldset>
                                                    <legend>AN&Aacute;LISE PELO MAPEAMENTO DE FLUXO DE CORES</legend>

                                                    <!-- Início da tabela de Observações gerais -->
                                                    <table id="table_analise_mapeamento_fluxo_cores" border="0">
                                                        <thead>
                                                            <tr>
                                                                <td>Descrição</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="bt_link_new mini_bt">
                                                                        <a href="#" id="plusanalisemapeamentofluxocores">Adicionar Ítem</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <tr class="linha1">
                                                                <td>
                                                                    <select  name="txtAnaliseMapeamentoFluxoCores[1]" class="size10" >
                                                                        <option value="-1">Selecione</option>
                                <? foreach ($AnaliseMapeamentoFluxoCores as $item) : ?>
                                                                            <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="delete">Excluir</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Fim da tabela de Observações gerais -->
                                                    </fieldset>
                                                <fieldset>
                                                    <legend>CONCLUS&Atilde;O</legend>

                                                    <!-- Início da tabela de Observações gerais -->
                                                    <table id="table_conclusao" border="0">
                                                        <thead>
                                                            <tr>
                                                                <td>Descrição</td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="bt_link_new mini_bt">
                                                                        <a href="#" id="plusconclusao">Adicionar Ítem</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <tr class="linha1">
                                                                <td>
                                                                    <select  name="txtConclusao[1]" class="size10" >
                                                                        <option value="-1">Selecione</option>
                                <? foreach ($Conclusao as $item) : ?>
                                                                            <option value="<?= $item->exame_gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                                <? endforeach; ?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="delete">Excluir</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Fim da tabela de Observações gerais -->
                                                    </fieldset>
                   <fieldset>
                       <legend>Cadastrar &Iacute;tens</legend>

                                            <!-- Início da tabela de Infusão de Drogas -->
                                            <table id="table_itens" border="0">
                                                <thead>
                                                    <tr>
                                                        <td>Tipo</td>
                                                        <td>Descri&ccedil;&atilde;o</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="bt_link_new mini_bt">
                                                                <a href="#" id="plusitens">Adicionar Ítem</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>

                                                <tbody>
                                                    <tr class="linha1">
                                                        <td>
                                                            <select  name="Classificacao[1]" class="size2" >
                                                                <option value="-1">Selecione</option>
                                                               <? foreach ($Classificacao as $item) : ?>
                                                                <option value="<?= $item->exame_classeresposta_id; ?>"><?= $item->nome; ?></option>
                                                               <? endforeach; ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="descricaoClassificacao[1]" class="size10" /></td>
                                                <td>
                                                    <a href="#" class="delete">Excluir</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- Fim da tabela de Agente Tóxico -->
           </fieldset>



                                                    <hr />
                                                    <button type="submit" name="btnEnviar">Enviar</button>
                                                    <button type="reset" name="btnLimpar">Limpar</button>
                                                </form>
                                            </div>
                                            <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
                                            <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
                                            <script type="text/javascript">

                                                var idlinha=2;
                                                var classe = 2;

                                                $(document).ready(function(){

                                                    $('#plusobservacao').click(function(){

                                                        var linha = "<tr class='linha"+classe+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtObservacaoGeral["+idlinha+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($ObservacoesGerais as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idlinha++;
                                                        classe = (classe == 1) ? 2 : 1;
                                                        $('#table_observacao_geral').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idVentEsquerdoDimensoesHipertrofia=2;
                                                var classeVentEsquerdoDimensoesHipertrofia = 2;

                                                $(document).ready(function(){

                                                    $('#plusventriculo_esquerdo_dimensoes_hipertrofia').click(function(){

                                                        var linha = "<tr class='linha"+classeVentEsquerdoDimensoesHipertrofia+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtVentEsquerdoDimensoesHipertrofia["+idVentEsquerdoDimensoesHipertrofia+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($VentEsquerdoDimensoesHipertrofia as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idVentEsquerdoDimensoesHipertrofia++;
                                                        classeVentEsquerdoDimensoesHipertrofia = (classeVentEsquerdoDimensoesHipertrofia == 1) ? 2 : 1;
                                                        $('#table_ventriculo_esquerdo_dimensoes_hipertrofia').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idVentriculoEsquerdoAnaliseSegmentar=2;
                                                var classeVentriculoEsquerdoAnaliseSegmentar = 2;

                                                $(document).ready(function(){

                                                    $('#plusventriculo_esquerdo_analise_segmentar').click(function(){

                                                        var linha = "<tr class='linha"+classeVentriculoEsquerdoAnaliseSegmentar+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='VentEsquerdoAnaliseSgmentar["+idVentriculoEsquerdoAnaliseSegmentar+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($VentEsquerdoAnaliseSgmentar as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idVentriculoEsquerdoAnaliseSegmentar++;
                                                        classeVentriculoEsquerdoAnaliseSegmentar = (classeVentriculoEsquerdoAnaliseSegmentar == 1) ? 2 : 1;
                                                        $('#table_ventriculo_esquerdo_analise_segmentar').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idplusVentriculoEsquerdoFuncoes = 2;
                                                var classeVentriculoEsquerdoFuncoes = 2;

                                                $(document).ready(function(){

                                                    $('#plusventriculo_esquerdo_funcoes').click(function(){

                                                        var linha = "<tr class='linha"+classeVentriculoEsquerdoFuncoes+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtVentEsquerdoFuncoes["+idplusVentriculoEsquerdoFuncoes+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($VentEsquerdoFuncoes as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idplusVentriculoEsquerdoFuncoes++;
                                                        classeVentriculoEsquerdoFuncoes = (classeVentriculoEsquerdoFuncoes == 1) ? 2 : 1;
                                                        $('#table_ventriculo_esquerdo_funcoes').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idAorta = 2;
                                                var classeAorta = 2;

                                                $(document).ready(function(){

                                                    $('#plusaorta').click(function(){

                                                        var linha = "<tr class='linha"+classeAorta+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtAorta["+idAorta+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($Aorta as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idAorta++;
                                                        classeAorta = (classeAorta == 1) ? 2 : 1;
                                                        $('#table_aorta').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idValvulaAortica = 2;
                                                var classeValvulaAortica = 2;

                                                $(document).ready(function(){

                                                    $('#plusvalvulaaortica').click(function(){

                                                        var linha = "<tr class='linha"+classeValvulaAortica+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtValvulaAortica["+idValvulaAortica+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($ValvulaAortica as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idValvulaAortica++;
                                                        classeValvulaAortica = (classeValvulaAortica == 1) ? 2 : 1;
                                                        $('#table_valvula_aortica').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idAtrioEsquerdo = 2;
                                                var classeAtrioEsquerdo = 2;

                                                $(document).ready(function(){

                                                    $('#plusatrioesquerdo').click(function(){

                                                        var linha = "<tr class='linha"+classeAtrioEsquerdo+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtValvulaAortica["+idAtrioEsquerdo+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($ValvulaAortica as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idAtrioEsquerdo++;
                                                        classeAtrioEsquerdo = (classeAtrioEsquerdo == 1) ? 2 : 1;
                                                        $('#table_atrio_esquerdo').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idValvuladireito = 2;
                                                var classeValvuladireito = 2;

                                                $(document).ready(function(){

                                                    $('#plusvalvulamitral').click(function(){

                                                        var linha = "<tr class='linha"+classeValvuladireito+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtValvulamitral["+idValvuladireito+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($Valvulamitral as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idValvuladireito++;
                                                        classeValvuladireito = (classeValvuladireito == 1) ? 2 : 1;
                                                        $('#table_valvula_mitral').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idVentriculoireito = 2;
                                                var classeVentriculoireito = 2;

                                                $(document).ready(function(){

                                                    $('#plusventriculodireito').click(function(){

                                                        var linha = "<tr class='linha"+classeVentriculoireito+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtVentriculoireito["+idVentriculoireito+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($Ventriculoireito as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idVentriculoireito++;
                                                        classeVentriculoireito = (classeVentriculoireito == 1) ? 2 : 1;
                                                        $('#table_ventriculo_direito').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idAtrioDireito = 2;
                                                var classeAtrioDireito = 2;

                                                $(document).ready(function(){

                                                    $('#plusatriodireito').click(function(){

                                                        var linha = "<tr class='linha"+classeAtrioDireito+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtAtrioDireito["+idAtrioDireito+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($AtrioDireito as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
                                                        linha += "</select>";
                                                        linha += "</td>";
                                                        linha += "<td><a href='#' class='delete'>Excluir</a></td>";
                                                        linha += "</tr>";

                                                        idAtrioDireito++;
                                                        classeAtrioDireito = (classeAtrioDireito == 1) ? 2 : 1;
                                                        $('#table_atrio_direito').append(linha);
                                                        addRemove();
                                                        return false;
                                                    });

                                                    function addRemove() {
                                                        $('.delete').click(function(){
                                                            $(this).parent().parent().remove();
                                                            return false;
                                                        });

                                                    }
                                                });

                                                var idValvulaTricuspide = 2;
                                                var classeValvulaTricuspide = 2;

                                                $(document).ready(function(){

                                                    $('#plusvalvulatricuspide').click(function(){

                                                        var linha = "<tr class='linha"+classeValvulaTricuspide+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtValvulaTricuspide["+idValvulaTricuspide+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($ValvulaTricuspide as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
            linha += "</select>";
            linha += "</td>";
            linha += "<td><a href='#' class='delete'>Excluir</a></td>";
            linha += "</tr>";

            idValvulaTricuspide++;
            classeValvulaTricuspide = (classeValvulaTricuspide == 1) ? 2 : 1;
            $('#table_valvula_tricuspide').append(linha);
            addRemove();
            return false;
        });

        function addRemove() {
            $('.delete').click(function(){
                $(this).parent().parent().remove();
                return false;
            });

        }
    });

                                                var idValvulapulmonar = 2;
                                                var classeValvulapulmonar = 2;

                                                $(document).ready(function(){

                                                    $('#plusvalvulapulmonar').click(function(){

                                                        var linha = "<tr class='linha"+classeValvulapulmonar+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtValvulaTricuspide["+idValvulapulmonar+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($ValvulaTricuspide as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
            linha += "</select>";
            linha += "</td>";
            linha += "<td><a href='#' class='delete'>Excluir</a></td>";
            linha += "</tr>";

            idValvulapulmonar++;
            classeValvulapulmonar = (classeValvulapulmonar == 1) ? 2 : 1;
            $('#table_valvula_pulmonar').append(linha);
            addRemove();
            return false;
        });

        function addRemove() {
            $('.delete').click(function(){
                $(this).parent().parent().remove();
                return false;
            });

        }
    });

                                                var idPericardio = 2;
                                                var classePericardio = 2;

                                                $(document).ready(function(){

                                                    $('#pluspericardio').click(function(){

                                                        var linha = "<tr class='linha"+classePericardio+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtPericardio["+idPericardio+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($Pericardio as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
            linha += "</select>";
            linha += "</td>";
            linha += "<td><a href='#' class='delete'>Excluir</a></td>";
            linha += "</tr>";

            idPericardio++;
            classePericardio = (classePericardio == 1) ? 2 : 1;
            $('#table_pericardio').append(linha);
            addRemove();
            return false;
        });

        function addRemove() {
            $('.delete').click(function(){
                $(this).parent().parent().remove();
                return false;
            });

        }
    });

                                                var idEstudoProteses = 2;
                                                var classeEstudoProteses = 2;

                                                $(document).ready(function(){

                                                    $('#plusestudoproteses').click(function(){

                                                        var linha = "<tr class='linha"+classeEstudoProteses+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtEstudoProteses["+idEstudoProteses+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($EstudoProteses as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
            linha += "</select>";
            linha += "</td>";
            linha += "<td><a href='#' class='delete'>Excluir</a></td>";
            linha += "</tr>";

            idEstudoProteses++;
            classeEstudoProteses = (classeEstudoProteses == 1) ? 2 : 1;
            $('#table_estudo_proteses').append(linha);
            addRemove();
            return false;
        });

        function addRemove() {
            $('.delete').click(function(){
                $(this).parent().parent().remove();
                return false;
            });

        }
    });

                                                var idAnaliseFluxoDoppler = 2;
                                                var classeAnaliseFluxoDoppler = 2;

                                                $(document).ready(function(){

                                                    $('#plusanalisefluxodoppler').click(function(){

                                                        var linha = "<tr class='linha"+classeAnaliseFluxoDoppler+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtAnaliseFluxoDoppler["+idAnaliseFluxoDoppler+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($AnaliseFluxoDoppler as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
            linha += "</select>";
            linha += "</td>";
            linha += "<td><a href='#' class='delete'>Excluir</a></td>";
            linha += "</tr>";

            idAnaliseFluxoDoppler++;
            classeAnaliseFluxoDoppler = (classeAnaliseFluxoDoppler == 1) ? 2 : 1;
            $('#table_analise_fluxo_doppler').append(linha);
            addRemove();
            return false;
        });

        function addRemove() {
            $('.delete').click(function(){
                $(this).parent().parent().remove();
                return false;
            });

        }
    });

                                                var idAnaliseMapeamentoFluxoCores = 2;
                                                var classeAnaliseMapeamentoFluxoCores = 2;

                                                $(document).ready(function(){

                                                    $('#plusanalisemapeamentofluxocores').click(function(){

                                                        var linha = "<tr class='linha"+classeAnaliseMapeamentoFluxoCores+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtAnaliseMapeamentoFluxoCores["+idAnaliseMapeamentoFluxoCores+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($AnaliseMapeamentoFluxoCores as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
            linha += "</select>";
            linha += "</td>";
            linha += "<td><a href='#' class='delete'>Excluir</a></td>";
            linha += "</tr>";

            idAnaliseMapeamentoFluxoCores++;
            classeAnaliseMapeamentoFluxoCores = (classeAnaliseMapeamentoFluxoCores == 1) ? 2 : 1;
            $('#table_analise_mapeamento_fluxo_cores').append(linha);
            addRemove();
            return false;
        });

        function addRemove() {
            $('.delete').click(function(){
                $(this).parent().parent().remove();
                return false;
            });

        }
    });

                                                var idConclusao = 2;
                                                var classeConclusao = 2;

                                                $(document).ready(function(){

                                                    $('#plusconclusao').click(function(){

                                                        var linha = "<tr class='linha"+classeConclusao+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='txtConclusao["+idConclusao+"]' class='size10'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($Conclusao as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                            }
?>
            linha += "</select>";
            linha += "</td>";
            linha += "<td><a href='#' class='delete'>Excluir</a></td>";
            linha += "</tr>";

            idConclusao++;
            classeConclusao = (classeConclusao == 1) ? 2 : 1;
            $('#table_conclusao').append(linha);
            addRemove();
            return false;
        });

        function addRemove() {
            $('.delete').click(function(){
                $(this).parent().parent().remove();
                return false;
            });

        }
    });

                                                var idClassificacao = 2;
                                                var classeClassificacao = 2;

                                                $(document).ready(function(){

                                                    $('#plusitens').click(function(){

                                                        var linha = "<tr class='linha"+classeClassificacao+"'>";
                                                        linha += "<td>";
                                                        linha += "<select  name='Classificacao["+idClassificacao+"]' class='size2'>";
                                                        linha += "<option value='-1'>Selecione</option>";
<?
                                                                            foreach ($Classificacao as $item) {
                                                                                echo 'linha += "<option value=\'' . $item->exame_classeresposta_id . '\'>' . $item->nome . '</option>";';
                                                                            }
?>
            linha += "</select>";
            linha += "</td>";
            linha += "<td><input type='text'  name='descricaoClassificacao["+idClassificacao+"]' class='size10' /></td>";
            linha += "<td><a href='#' class='delete'>Excluir</a></td>";
            linha += "</tr>";

            idClassificacao++;
            classeClassificacao = (classeClassificacao == 1) ? 2 : 1;
            $('#table_itens').append(linha);
            addRemove();
            return false;
        });

        function addRemove() {
            $('.delete').click(function(){
                $(this).parent().parent().remove();
                return false;
            });

        }
    });








</script>
