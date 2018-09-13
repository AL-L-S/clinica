<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>

<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');

    if (isset($obj->_peso)) {
        $peso = @$obj->_peso;
    } else {
        $peso = @$laudo_peso[0]->peso;
    }
    if (isset($obj->_altura)) {
        $altura = @$obj->_altura;
    } else {
        $altura = @$laudo_peso[0]->altura;
    }


    if (@$empresapermissao[0]->campos_atendimentomed != '') {
        $opc_telatendimento = json_decode(@$empresapermissao[0]->campos_atendimentomed);
    } else {
        $opc_telatendimento = array();
    }
    ?>
    <?php
    $this->load->library('utilitario');
    Utilitario::pmf_mensagem($this->session->flashdata('message'));
    ?>
    <div >
        <form name="form_laudo" id="form_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarparecer/<?= $ambulatorio_laudo_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
                <input type="hidden" name="paciente_id" id="paciente_id" class="texto01"  value="<?= @$obj->_paciente_id; ?>"/>
                <fieldset>

                    <table> 
                        <tr>
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>                                                        
                        </tr>

                    </table>


                </fieldset>
                <fieldset>
                    <h2 align = "center">Laudo de US para Apendicite</h2>
                    <br>
                    <table width="90%">
                        <tr height="30px">
                            <td style="padding-left: 350px"><b>Histórico Clínico:</b></td>
                            <td>
                                <input type="text" name="historicoclinico" id="historicoclinico" value="<?= @$obj->_ciddescricao; ?>" class="size3" />
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px"><b>Estudos Anteriores:</b></td>
                            <td>
                                <input type="text" name="estudosanteriores" id="estudosanteriores" value="<?= @$obj->_ciddescricao; ?>" class="size3" />
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px"><b>Descobertas:</b></td>
                            <td>
                                <input type="text" name="descobertas" id="descobertas" value="<?= @$obj->_ciddescricao; ?>" class="size3" />
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px"><b><u>Apêndice:</u></b></td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Visualizado:</td>
                            <td>
                                <input type="text" name="visualizado" id="visualizado" value="<?= @$obj->_ciddescricao; ?>" class="size3" />
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Com Fluido:</td>
                            <td>
                                <input type="radio" id="comfluidosim" name="comfluido" value='SIM'>
                                Sim
                                <input type="radio" id="comfluidonao" name="comfluido" value='NAO'>
                                Não
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Compressível:</td>

                            <td>
                                <input type="radio" id="compressivelsim" name="compressivel" value='SIM'>
                                Sim
                                <input type="radio" id="compressivelnao" name="compressivel" value='NAO'>
                                Não
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Diâmetro máximo com compressão (parede exterior a parede exterior):</td>
                            <td>
                                <input type="text" name="diametromax" id="diametromax" value="<?= @$obj->_ciddescricao; ?>" class="size3" />
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;- Apendicólito:</td>
                            <td>
                                <input type="radio" id="apendicolitosim" name="apendicolito" value='SIM'>
                                Sim
                                <input type="radio" id="apendicolitonao" name="apendicolito" value='NAO'>
                                Não
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;<u>- Parede:</u></td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Hiperemia:</td>
                            <td>
                                <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                <input type="radio" id="hiperemiasim" name="hiperemia" value='SIM'>
                                Sim
                                <input type="radio" id="hiperemianao" name="hiperemia" value='NAO'>
                                Não
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Espessamento (>2mm):</td>
                            <td>
                                <input type="radio" id="espessamentosim" name="espessamento" value='SIM'>
                                Sim
                                <input type="radio" id="espessamentonao" name="espessamento" value='NAO'>
                                Não
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Perda de estratificação mural:</td>
                            <td>
                                <input type="radio" id="pemuralsim" name="pemural" value='SIM'>
                                Sim
                                <input type="radio" id="pemuralnao" name="pemural" value='NAO'>
                                Não
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px"><b>Fluido Livre:</b></td>
                            <td>
                                <input type="radio" id="fluidolivresim" name="fluidolivre" value='SIM'>
                                Sim
                                <input type="radio" id="fluidolivrenao" name="fluidolivre" value='NAO'>
                                Não 
                            </td>

                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px"><b>Aumento da ecogenicidade da gordura periapendicular:</b></td>
                            <td>
                                <input type="radio" id="aegperiapendicular2sim" name="aegperiapendicular" value='SIM'>
                                Sim
                                <input type="radio" id="aegperiapendicularnao" name="aegperiapendicular" value='NAO'>
                                Não
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px"><b>Abscesso:</b></td>
                            <td>
                                <input type="radio" id="abscessosim" name="abscesso" value='SIM'>
                                Sim
                                <input type="radio" id="abscessonao" name="abscesso" value='NAO'>
                                Não
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px"><b>Descobertas Adicionais:</b></td>
                            <td>
                                <input type="text" name="descobertasadc" id="descobertasadc" value="<?= @$obj->_ciddescricao; ?>" class="size3" />
                            </td>
                        </tr>
                        <tr height="60px">
                            <td style="padding-left: 350px"><b><u>IMPRESSÕES:</u></b></td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">Escore de Apendicite:</td>
                            <td>
                                <input type="text" name="escoreapendicite" id="escoreapendicite" value="<?= @$obj->_ciddescricao; ?>" class="size3" />
                            </td>
                        </tr>
                        <tr height="30px">
                            <td style="padding-left: 350px">Diagnóstico adicional/alternativo</td>
                            <td>
                                <input type="text" name="diagnosticoadc" id="diagnosticoadc" value="<?= @$obj->_ciddescricao; ?>" class="size3" />
                            </td>
                        </tr>
                    </table>
                    <br><br>
                    <h4 align = "center">Classificação de achados cirurgicos da Apendicite</h4>
                    <table align="center" border="1" style="border-collapse: collapse; text-align: center">
                        <tr>
                            <td><b>&nbsp;&nbsp;&nbsp;&nbsp;Grau&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                            <td><b>&nbsp;&nbsp;&nbsp;&nbsp;Achados Laparoscópicos&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                        </tr>
                        <tr>
                            <td>0</td>
                            <td>Apêndice de aparência normal</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Hiperemia e edema</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Exsudado fibrinoso</td>
                        </tr>
                        <tr>
                            <td>3A</td>
                            <td>Necrose segmentar</td>
                        </tr>
                        <tr>
                            <td>3B</td>
                            <td>Necrose de base</td>
                        </tr>
                        <tr>
                            <td>4A</td>
                            <td>Abscesso</td>
                        </tr>
                        <tr>
                            <td>4B</td>
                            <td>Peritonite Regional</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Peritonite Difusa</td>
                        </tr>
                    </table>
                    <br>                    
                </fieldset>    
                <br>
                <table align="center">
                    <td><button type="submit" name="btnEnviar">Salvar</button></td>
                    <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaoparecer/<?= $ambulatorio_laudo_id ?>');">

                            Imprimir
                        </button>
                    </td>
                </table>                                               

            </div>
        </form>
