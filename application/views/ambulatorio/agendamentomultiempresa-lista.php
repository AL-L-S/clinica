
<?
//$especialidade = $this->exame->listarespecialidade();
//$medicos = $this->operador_m->listarmedicos();
$empresas = $this->exame->listarnomeclinicaexterno();
?>
<style>

    .botaoClinica{
        width: 100pt;
        height: 22pt;
        background-color: #D2D7D3;
        border: 1pt solid #000;
        font-size: 8pt;
        font-weight: bold;
        color: black;
        border-radius: 20pt;
        text-align: center;
    }
    .botaoClinica:hover{
        cursor: pointer;
        border: 1pt solid #999;
        font-weight: bold;
        /*font-size: 13pt;*/
        color: #b30707;
    }
    .botoes{
        position: fixed;
        right: -10pt;
        top: 10%;
    }
    #tot td{
        text-align: center;
        font-size: 2.5em;
        font-weight: bolder;
    }
    #semResultado{
        text-align: center;
        font-size: 1em;
        font-weight: bolder;
    }
    .wrap {
        max-width: 1200px;
        margin: 0 auto;
    }

    .nav {
        /*background: #FFF;*/
        z-index: 5;
        position: relative;
        width: 20%;
        font-size: 1em;
        float: left;
        background: #444;
        filter:alpha(opacity=50);
        opacity: 0.5;
        -moz-opacity:0.5;
        -webkit-opacity:0.5;
        font-weight: bold;
    }

    .nav ul {
        padding: 1em;
    }

    li {
        display: block;
        width: 100%;
        margin: 1em 2em 1em 0;
    }

    .nav-toggle {
        display: none;
    }

    .wrap {
        max-width: 100%;
        margin: 0;
    }

    .nav {
        min-width: 100px;
        position: absolute;
        top: 0;
        right: -13pt;
    }

    .nav ul {
        padding: .5em;
        margin: 0;
        background: #444;
    }		

    li {
        margin: 0;
        padding: 0;
        display: block;
    }

    li div {
        padding: 0.5em 0 0.5em 0;
        display: block;
        color: #FFF;
    }


    .nav-toggle {
        position: absolute;
        top: 0;
        right: 56px;
        color: #FFF;
        cursor: pointer;
        width: 20px;
        height: 24px;
        z-index: 5;
        display: block;
        background: #444;
        padding: 12px 6px 6px 6px;
    }

    /*    .foto {
            width: 100%;
            position: relative;
            float: none;
        }*/

</style>
<script>
<? foreach ($empresas as $emp) { ?>
        jQuery(function () {
            jQuery("#botaoCli<?= $emp->empresas_acesso_externo_id ?>").click(function () {
                jQuery('html, body').animate({
                    scrollTop: jQuery("#clinica<?= $emp->empresas_acesso_externo_id ?>").offset().top
                }, 1000);
            });
        });
<? } ?>
</script>
<div class="content ficha_ceatox">
    <h3 class="singular"><a href="#">Agendamento Multiempresas</a></h3>

    <fieldset >

        <div>
            <table >
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listaragendamentomultiempresa">

                    <tr>
                        <td class="tabela_title">Especialidade</td>
                        <td class="tabela_title">Medico</td>
                        <td class="tabela_title">Data</td>
                        <td colspan="2" class="tabela_title">Nome</td>
                    </tr>
                    <tr>
                        <td class="tabela_title">
                            <select name="especialidade" id="especialidade" class="size1">
                                <option value=""></option>
                                <?
                                foreach ($especialidade as $chave => $it) :
                                    $clinica = $this->exame->listarnomeclinicaexterno($chave);
                                    ?>

                                    <optgroup label="<?= @$clinica[0]->nome_clinica ?>">

                                        <? foreach ($it as $value) : ?>
                                            <option value="<?= $value->cbo_ocupacao_id; ?>" <?
                                            if (@$_GET['especialidade'] == $value->cbo_ocupacao_id):echo 'selected';
                                            endif;
                                            ?>>
                                                        <?php echo $value->descricao; ?>
                                            </option>

                                        <? endforeach; ?>
                                    </optgroup>
                                <? endforeach; ?>
                            </select>
                        </td>


                        <td class="tabela_title">
                            <select name="medico" id="medico" class="size1">
                                <option value=""> </option>
                                <?
                                foreach ($medicos as $chave => $it) :
                                    $clinica = $this->exame->listarnomeclinicaexterno($chave);
                                    ?>
                                    <optgroup label="<?= @$clinica[0]->nome_clinica ?>">
                                        <? foreach ($it as $value) : ?>
                                            <option value="<?= $value->conselho; ?>" <? if ($value->conselho == @$_GET['medico'] && @$_GET['medico'] != '') echo 'selected'; ?>>
                                                <?php echo $value->nome . ' - CRM: ' . $value->conselho; ?>
                                            </option>
                                        <? endforeach; ?>
                                    </optgroup>
                                <? endforeach; ?>

                            </select>
                        </td>

                        <td class="tabela_title">
                            <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </td>
                        <td colspan="2" class="tabela_title">
                            <input type="text" name="nome" class="texto02 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        </td>
                        <td colspan="3" class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </td>

                    </tr>
                </form>
            </table>
            <hr>
            <div class="botoes">
                <nav class="nav nav-aberta side-fechado">
                    <div class="wrap">
                        <ul class="listaNav">
                            <? foreach ($empresas as $value) { ?>
                                <li>
                                    <div id="botaoCli<?= $value->empresas_acesso_externo_id ?>"><?= (strlen($value->nome_clinica) > 14) ? substr($value->nome_clinica, 0, 14) . '...' : $value->nome_clinica ?></div>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                </nav>
            </div>

            <?php
            if (count(@$dados['agenda']) > 0) {
                $estilo_linha = "tabela_content01";
                $i = 0;
                foreach ($dados['agenda'] as $key => $value) {
                    $nomeClinica = $this->exame->listarnomeclinicaexterno($key);
                    if ($value == "") {
                        continue;
                    }
                    ?>
                    <div id="clinica<?= @$nomeClinica[0]->empresas_acesso_externo_id ?>" class="tabela">
                        <table>
                            <tr id="tot">
                                <td colspan="10">
                                    <span><?= @$nomeClinica[0]->nome_clinica ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="tabela_header" >Status</td>
                                <td class="tabela_header" width="250px;">Nome</td>
                                <td class="tabela_header" width="70px;">Data</td>
                                <td class="tabela_header" width="50px;">Dia</td>
                                <td class="tabela_header" width="70px;">Agenda</td>
                                <td class="tabela_header" width="150px;">Tipo</td>
                                <td class="tabela_header" width="150px;">Telefone</td>
                                <td class="tabela_header" width="150px;">Convenio</td>
                                <td class="tabela_header">Medico</td>
                                <td class="tabela_header" colspan="5"><center>A&ccedil;&otilde;es</center></td>
                            </tr>
                            <?
                            foreach ($value as $item) {
                                if ($item->celular != "") {
                                    $telefone = $item->celular;
                                } elseif ($item->telefone != "") {
                                    $telefone = $item->telefone;
                                } else {
                                    $telefone = "";
                                }
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";

                                $faltou = false;
                                if ($item->paciente == "" && $item->bloqueado == 't') {
                                    $situacao = "Bloqueado";
                                    $paciente = "Bloqueado";
                                    $verifica = 5;
                                } else {
                                    $paciente = "";

                                    if ($item->realizada == 't' && $item->situacaoexame == 'EXECUTANDO') {
                                        $situacao = "Atendendo";
                                        $verifica = 2;
                                    } elseif ($item->realizada == 't' && $item->situacaoexame == 'FINALIZADO') {
                                        $situacao = "Finalizado";
                                        $verifica = 4;
                                    } elseif ($item->confirmado == 'f' && $item->operador_atualizacao == null) {
                                        $situacao = "agenda";
                                        $verifica = 1;
                                    } elseif ($item->confirmado == 'f' && $item->operador_atualizacao != null) {
                                        $verifica = 6;
                                        date_default_timezone_set('America/Fortaleza');
                                        $data_atual = date('Y-m-d');
                                        $hora_atual = date('H:i:s');
                                        if ($item->data < $data_atual) {
                                            $situacao = "<font color='gray'>faltou";
                                            $faltou = true;
                                        } else {
                                            $situacao = "agendado";
                                        }
                                    } else {
                                        $situacao = "espera";
                                        $verifica = 3;
                                    }
                                }
                                if ($item->paciente == "" && $item->bloqueado == 'f') {
                                    $paciente = "vago";
                                }
                                $data = $item->data;
                                $dia = strftime("%A", strtotime($data));

                                switch ($dia) {
                                    case"Sunday": $dia = "Domingo";
                                        break;
                                    case"Monday": $dia = "Segunda";
                                        break;
                                    case"Tuesday": $dia = "Terça";
                                        break;
                                    case"Wednesday": $dia = "Quarta";
                                        break;
                                    case"Thursday": $dia = "Quinta";
                                        break;
                                    case"Friday": $dia = "Sexta";
                                        break;
                                    case"Saturday": $dia = "Sabado";
                                        break;
                                }
                                ?>
                                <tr>
                                    <?
                                    if ($verifica == 1) {
                                        if ($item->ocupado == 't') {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>"><b><strike><?= $situacao; ?></strike></b></td>
                                            <td class="<?php echo $estilo_linha; ?>"><b><strike><?= $item->paciente; ?></strike></b></td>
                                        <? } else {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>"><b><?= $situacao; ?></b></td>
                                            <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                            <?
                                        }
                                    }

                                    if ($verifica == 2) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $situacao; ?></b></td>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="green"><b><?= $item->paciente; ?></b></td>
                                        <?
                                    }

                                    if ($verifica == 3) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $situacao; ?></b></td>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="red"><b><?= $item->paciente; ?></b></td>
                                        <?
                                    }

                                    if ($verifica == 4) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $situacao; ?></b></td>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="blue"><b><?= $item->paciente; ?></b></td>
                                        <?
                                    }

                                    if ($verifica == 5) {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><?= $situacao; ?></b></td>
                                        <td class="<?php echo $estilo_linha; ?>"><font color="gray"><b><?= $item->paciente; ?></b></td>
                                        <?
                                    }

                                    // NOME
                                    if ($verifica == 6) {
                                        if ($item->ocupado == 't') {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>"><b><strike><?= $situacao; ?></strike></b></td>
                                            <td class="<?php echo $estilo_linha; ?>"><b><strike><?= $item->paciente; ?></strike></b></td>
                                        <? } else {
                                            ?>
                                            <td class="<?php echo $estilo_linha; ?>"><b><?= $situacao; ?></b></td>
                                            <td class="<?php echo $estilo_linha; ?>"><b><?= $item->paciente; ?></b></td>
                                            <?
                                        }
                                    }
                                    ?>

                                    <!--DATA, DIA E AGENDA--> 
                                    <? if ($item->ocupado == 't') { ?>
                                        <td class="<?php echo $estilo_linha; ?>"><strike><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></strike></td>
                                    <td class="<?php echo $estilo_linha; ?>"><strike><?= substr($dia, 0, 3); ?></strike></td>
                                    <td class="<?php echo $estilo_linha; ?>"><strike><?= $item->inicio; ?></strike></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . "/" . substr($item->data, 5, 2) . "/" . substr($item->data, 0, 4); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= substr($dia, 0, 3); ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                <? } ?>

                                <!--TIPO--> 
                                <td class="<?php echo $estilo_linha; ?>"><?= @$item->tipo; ?></td>

                                <!--TELEFONE--> 
                                <td class="<?php echo $estilo_linha; ?>"><?= $telefone; ?></td>

                                <!--CONVENIO--> 
                                <? if ($item->convenio != "") { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio . " - " . $item->procedimento; ?></td>
                                <? } else { ?>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio_paciente . " - " . $item->procedimento; ?></td>
                                <? } ?>

                                <!--MEDICO-->    
                                <td class="<?php echo $estilo_linha; ?>" width="150px;"><?= $item->medicoagenda; ?></td>

                                <?
                                if ($item->paciente_id == "" && $item->bloqueado == 'f') {
                                    if ($item->medicoagenda != "") {
                                        ?>
                                        <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link_new">
                                                <a target="_blank" href="<?= base_url() ?>ambulatorio/exametemp/carregaragendamultiempresa/<?= $item->agenda_exames_id ?>/<?= $item->medico_agenda ?>/<?= $nomeClinica[0]->empresas_acesso_externo_id ?>">Agendar
                                                </a>


                                            </div>
                                        </td>
                                        <?
                                    }
                                } elseif ($item->bloqueado == 't') {
                                    ?>
                                    <td class="<?php echo $estilo_linha; ?>" width="60px;"> Bloqueado</td>
                                <? } else {
                                    ?>
                                    <td colspan="3" class="<?php echo $estilo_linha; ?>" ></td>
                                <? }
                                ?>

                                </tr>

                                </tbody>
                            <?php }
                            ?>

                        </table>

                    </div>
                    <?
                }
            }
            ?>
        </div>
    </fieldset>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(document).ready(function () {
        $(function () {
            $('#especialidade').change(function () {
                $('#medico *').remove();
                if ($(this).val()) {
                    var todos = '<option value=""></option>';
                    $('#medico').append(todos);
                    
                    <? foreach ($empresas as $emp) { ?>
                        var opt = '<optgroup label="<?= @$emp->nome_clinica ?>">';
                        $.getJSON('http://<?= @$emp->ip_externo ?>/clinicas/autocomplete/medicoespecialidade', {txtcbo: $(this).val(), ajax: true}, function (j) {
                            if(j.length > 0){
                                $('#medico').append(opt);
                                var options = '';
                                for (var c = 0; c < j.length; c++) {
                                    if (j[0].operador_id != undefined) {
                                        options += '<option value="' + j[c].conselho + '">' + j[c].nome + ' - CRM: ' + j[c].conselho+'</option>';

                                    }
                                }
                                console.log('teste');
                                $('#medico').append(options);
                            }
                        });
                        var optFim = '</optgroup>';
                        $('#medico').append(optFim);
//                  <? } ?>
//
                }
            });
        });
        $(function () {
            $("#data").datepicker({
                autosize: true,
                changeYear: true,
                changeMonth: true,
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                buttonImage: '<?= base_url() ?>img/form/date.png',
                dateFormat: 'dd/mm/yy'
            });
        });
    });
</script>
