
<div class="content ficha_ceatox">

    <?
    $operador_id = $this->session->userdata('operador_id');
    $perfil_id = $this->session->userdata('perfil_id');
    $paciente_id = $paciente['0']->paciente_id;
    ?>
    <div>
        <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentos" method="post">
            <fieldset>
                <legend>Dados do Paciente</legend>
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
                        <option value="O" <?
                        if ($paciente['0']->sexo == "O"):echo 'selected';
                        endif;
                        ?>>Outro</option>
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
    </div>
    <? foreach ($guia as $test) : ?>
        <table >
            <thead>
                <tr>
                    <th class="tabela_header" colspan="2">Guia: <?= $test->ambulatorio_guia_id ?></th>
                    <th class="tabela_header">Exame</th>
                    <th class="tabela_header">Laudo</th>
                    <th class="tabela_header">Recebido</th>
                    <th class="tabela_header" >Entregue</th>
                    <th class="tabela_header" style="text-align: center;" colspan="5">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?
                $estilo_linha = "tabela_content01";
                foreach ($exames as $item) :
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    if ($test->ambulatorio_guia_id == $item->guia_id) {
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;"><?= $item->procedimento ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="50px;"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="50px;"><?= $item->situacaoexame ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="50px;"><?= $item->situacaolaudo ?></td>
                            <? if ($item->recebido == 'f') { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><a href="<?= base_url() ?>ambulatorio/guia/recebidoresultado/<?= $paciente['0']->paciente_id; ?>/<?= $item->agenda_exames_id ?>">N&Atilde;O
                                    </a></td>
                            <? } else {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><a onclick="javascript: return confirm('Deseja realmente cancelar recebimento');" href="<?= base_url() ?>ambulatorio/guia/cancelarrecebidoresultado/<?= $paciente['0']->paciente_id; ?>/<?= $item->agenda_exames_id ?>"><b>SIM</b> Por: <?= $item->operadorrecebido . " - Dia:" . substr($item->data_recebido, 8, 2) . "/" . substr($item->data_recebido, 5, 2) . "/" . substr($item->data_recebido, 0, 4) ?></a>
                                </td>
                                <?
                            }
                            if ($item->entregue == "") {
                                ?>
                                <td class="<?php echo $estilo_linha; ?>" width="100px;"><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/entregaexame/$paciente_id/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');">
                                        N&Atilde;O
                                    </a></td>
                            <? } else { ?>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><center><a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/vizualizarobservacao/$item->agenda_exames_id"; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=600,height=400');"><?= $item->entregue ?></b> Fone: <b><?= $item->entregue_telefone ?></b> DIA: <?= substr($item->data_entregue, 8, 2) . "/" . substr($item->data_entregue, 5, 2) . "/" . substr($item->data_entregue, 0, 4) ?> Hora:  <?= substr($item->data_entregue, 11, 8); ?> Por: <b><?= $item->operadorentregue; ?></b></a></center>
                        </td>
                    <? } ?>
                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                        <a target="_blank" href="<?= base_url() ?>ambulatorio/laudo/impressaolaudo/<?= $item->ambulatorio_laudo_id; ?>/<?= $item->exames_id ?>">Impressão
                        </a>
                    </td>
                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                        <a target="_blank" href="<?= base_url() ?>ambulatorio/laudo/impressaoimagem/<?= $item->ambulatorio_laudo_id; ?>/<?= $item->exames_id ?>">Imagem
                        </a>
                    </td>
                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                        <a target="_blank" href="<?= base_url() ?>ambulatorio/guia/impressaoetiquetaunica/<?= $item->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">Etiqueta Única
                        </a>
                    </td>
                    <td class="<?php echo $estilo_linha; ?>" width="30px;">
                        <a href="<?= base_url() ?>ambulatorio/guia/impressaoetiiqueta/<?= $paciente['0']->paciente_id; ?>/<?= $item->guia_id; ?>/<?= $item->agenda_exames_id ?>">Etiqueta</a></div>
                    </td>
                    <td class="<?php echo $estilo_linha; ?>" width="50px;">
                        <a target="_blank" href="<?= base_url() ?>ambulatorio/laudo/anexarimagem/<?= $item->ambulatorio_laudo_id ?>">Arquivos
                        </a>
                    </td>
                    </tr>

                    </tbody>
                    <?
                }
            endforeach;
            ?>
            <br>
        <? endforeach; ?>
        <tfoot>
            <tr>
                <th class="tabela_footer" colspan="5">
                </th>
            </tr>
        </tfoot>
    </table>
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
