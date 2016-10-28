
<div class="content ficha_ceatox">
    <div class="bt_link_new">
        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/novo/<?= $paciente['0']->paciente_id ?>');">
            Nova guia
        </a>
    </div>
    <?
    $operador_id = $this->session->userdata('operador_id');
    $empresa = $this->session->userdata('empresa');
    $perfil_id = $this->session->userdata('perfil_id');
    ?>
    <div>
        <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentos" method="post">
            <fieldset>
                <legend>Dados do Pacienete</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <select name="sexo" id="txtSexo" class="size2">
                        <option value="M" <?
                        if ($paciente['0']->sexo == "M"):echo 'selected';
                        endif;
                        ?>>Masculino</option>
                        <option value="F" <?
                        if ($paciente['0']->sexo == "F"):echo 'selected';
                        endif;
                        ?>>Feminino</option>
                    </select>
                </div>

                <div>
                    <label>Nascimento</label>


                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                </div>

                <div>

                    <label>Idade</label>
                    <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

                </div>

                <div>
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
            </fieldset>
        </form>

        <fieldset>
            <?
            foreach ($guia as $test) :
                $guia_id = $test->ambulatorio_guia_id;
                $cancelado = 0;
                ?>
                <table >
                    <thead>
                        <tr>
                            <th class="tabela_header">Guia: <?= $test->ambulatorio_guia_id ?></th>

                            <th class="tabela_header"><div class="bt_link">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturarguia/" . $guia_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=500');">F. Guia
                                 
                                    </a></div></th>
                            <th class="tabela_header"><div class="bt_link">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/anexarimagem/" . $guia_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=500');">Arquivos

                                    </a></div></th>
                            <th class="tabela_header"><div class="bt_link">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/guiadeclaracao/" . $guia_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=700');">Declara&ccedil;&atilde;o

                                    </a></div></th>
                            <th class="tabela_header"><div class="bt_link">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/guiaobservacao/" . $guia_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=500');">Observa&ccedil;&atilde;o

                                    </a></div></th>
                            <th class="tabela_header"><div class="bt_link">
                                    <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/guiaconvenio/" . $guia_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=500,height=250');">N. Guia

                                    </a></div></th>
                            <th class="tabela_header" colspan="7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($exames as $item) :
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";

                            if ($test->ambulatorio_guia_id == $item->guia_id) {
                                $cancelado++;
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>" width="100px;"><a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoguiaconsultaconvenio/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');"><?= $item->procedimento ?></a></td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>" width="50px;"><?= $item->inicio ?></td>

                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaodeclaracao/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Declaracao
                                        </a>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaorecibo/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Recibo
                                        </a>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" >
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaoficha/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Ficha
                                        </a>
                                        
                                        <?$teste = $this->guia->listarfichatexto($item->agenda_exames_id);
                                        if(isset($teste[0]->agenda_exames_id)){
                                        ?>
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/editarfichaxml/<?= $paciente['0']->paciente_id; ?>/<?= $item->agenda_exames_id ?>/<?= $item->agenda_exames_id ?>');"> //  Editar F. RM
                                        </a>
                                        <?}?>

                                    </td>
                                    <? if(isset($item->atendente) || isset($item->medicorealizou)){ ?>
                                        <td class="<?php echo $estilo_linha; ?>" >
                                            <? if(isset($item->atendente)): ?>
                                                <span>Atendente: <? echo $item->atendente; ?></span><br>
                                            <?
                                            endif;
                                            if(isset($item->atendente)):?>
                                                <span>Medico: <? echo $item->medicorealizou; ?></span>
                                            <? endif; ?>
                                        </td>
                                    <?}?>

            <!--                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/editarfichaxml/<?= $paciente['0']->paciente_id; ?>/<?= $item->agenda_exames_id ?>');">Editar Ficha RM
                                        </a>
                                    </td>-->
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/impressaofichaconvenio/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>');">Ficha-convenio
                                        </a>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <a href="<?= base_url() ?>ambulatorio/guia/impressaoetiiqueta/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">Etiqueta</a></div>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <a href="<?= base_url() ?>ambulatorio/guia/impressaoetiquetaunica/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">Etiq. unica
                                        </a>
                                    </td>
                                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        <a href="<?= base_url() ?>ambulatorio/guia/editarexame/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">Editar
                                        </a>
                                    </td>

            <? if ($perfil_id == 1 || $perfil_id == 6) { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                            <a href="<?= base_url() ?>ambulatorio/guia/valorexame/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">valor
                                            </a>
                                        </td>

                                        <?
                                    }
                                    ?>
            <? if (($item->faturado == "f" || $perfil_id == 1) && ($item->dinheiro == "t")) { ?>

                                        <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                            <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturar/" . $item->agenda_exames_id; ?>/<?= $item->procedimento_tuss_id ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=800,height=600');">Faturar

                                            </a>
                                        </td>
            <? } else { ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="30px;">
                                        </td>
            <? } ?>
                                </tr>


                            <?
                        }
                    endforeach;
                    if($cancelado == 0){?>
                        <tr>
                            <td colspan="6"><center><span style="color: red; font-weight: bold; font-size: 17px;">EXAME CANCELADO</span></center></td>
                        </tr>
                    <? } ?>
                </tbody>                                
                    <br>
<? endforeach; ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="11">
                        </th>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    </div>


    <script type="text/javascript">



        $(function () {
            $(".competencia").accordion({autoHeight: false});
            $(".accordion").accordion({autoHeight: false, active: false});
            $(".lotacao").accordion({
                active: true,
                autoheight: false,
                clearStyle: true

            });


        });
    </script>