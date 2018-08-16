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




    if (@$empresapermissao[0]->campos_atendimentomed != '') {
        $opc_telatendimento = json_decode(@$empresapermissao[0]->campos_atendimentomed);
    } else {
        $opc_telatendimento = array();
    }
    ?>
    <?php
    $this->load->library('utilitario');
//    var_dump($this->session->flashdata('message')); die;
    Utilitario::pmf_mensagem($this->session->flashdata('message'));
    ?>
    <div >
        <form name="cirurgias_laudo" id="cirurgias_laudo" action="<?= base_url() ?>ambulatorio/laudo/gravarcirurgia/<?= $ambulatorio_laudo_id ?>" method="post">
            <div >
                <input type="hidden" name="guia_id" id="guia_id" class="texto01"  value="<?= @$obj->_guia_id; ?>"/>
                <input type="hidden" name="paciente_id" id="paciente_id" class="texto01"  value="<?= @$obj->_paciente_id; ?>"/>
                <fieldset>
                    <legend>Dados</legend>
                    <table> 
                        <tr>                          
                            <td width="400px;">Paciente:<?= @$obj->_nome ?></td>
                            <td width="400px;">Exame: <?= @$obj->_procedimento ?></td>                            
                        </tr>
                        <tr>
                            <td>Idade: <?= $teste ?></td>
                            <td>Nascimento:<?= substr(@$obj->_nascimento, 8, 2) . "/" . substr(@$obj->_nascimento, 5, 2) . "/" . substr(@$obj->_nascimento, 0, 4); ?></td>
                        </tr>


                        <tr>                        

                            <td colspan="2">Endereco: <?= @$obj->_logradouro ?>, <?= @$obj->_numero . ' ' . @$obj->_bairro ?> - <?= @$obj->_uf ?></td>
                        </tr>
                        

                    </table>


                </fieldset>
                <fieldset>
                    <table align = "center">
                        <tr>
                            <td></td>
                            <td><h1 align = "center">Cirurgias</h1></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <button type="button" name="btnconsultacirurgias"onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencheravaliacao/<?= $ambulatorio_laudo_id ?>');" >
                                    Consulta Cirurgias
                                </button> 
                            </td>
                            
                            <td>
                                <button type="button" name="btnconsultarm"onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencheravaliacao/<?= $ambulatorio_laudo_id ?>');" >
                                    Consulta Ressonância Magnética
                                </button> 
                            </td>
                            <td>
                                <button type="button" name="btnconsultaprotese"onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencheravaliacao/<?= $ambulatorio_laudo_id ?>');" >
                                    Consulta Prótese
                                </button> 
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <fieldset>
                    <? 
//                        var_dump($cirurgia); die;
                    $cirurgias = json_decode(@$cirurgia[0]->cirurgias);
                    $complicacoes = json_decode(@$cirurgia[0]->complicacoes);
                    ?>
                    <table border="1" align="center">
                      <tr>
                        <td>    
                            <table>
                                <tr>
                                    <td><b>RM</b><input type="checkbox" name="ressonanciamag" id="ressonanciamag" value="on" ></td>
                                    <td width="200px;"></td>
                                    <td>MIE</td>
                                    <td width="150px;">
                                        <select name="mie" id="mie" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->mie == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->mie == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->mie == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->mie == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->mie == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->mie == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->mie == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->mie == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->mie == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                    <td>Radial D</td>
                                    <td>
                                        <select name="radiald" id="radiald" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->radiald == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->radiald == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->radiald == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->radiald == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->radiald == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->radiald == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->radiald == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->radiald == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->radiald == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="200px;"></td>
                                    <td>MID</td>
                                    <td width="150px;">
                                        <select name="mid" id="mid" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->mid == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->mid == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->mid == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->mid == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->mid == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->mid == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->mid == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->mid == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->mid == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                    <td>Radial E</td>
                                    <td>
                                        <select name="radiale" id="radiale" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->radiale == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->radiale == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->radiale == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->radiale == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->radiale == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->radiale == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->radiale == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->radiale == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->radiale == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="200px;"></td>
                                    <td>PVS 1</td>
                                    <td width="150px;">
                                        <select name="pvs1" id="pvs1" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->pvs1 == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->pvs1 == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->pvs1 == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->pvs1 == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->pvs1 == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->pvs1 == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->pvs1 == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->pvs1 == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->pvs1 == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                    <td>Gastroepiploica</td>
                                    <td>
                                        <select name="gastroepiploica" id="gastroepiploica" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->gastroepiploica == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->gastroepiploica == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->gastroepiploica == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->gastroepiploica == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->gastroepiploica == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->gastroepiploica == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->gastroepiploica == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->gastroepiploica == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->gastroepiploica == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="200px;"></td>
                                    <td>PVS 2</td>
                                    <td width="150px;">
                                        <select name="pvs2" id="pvs2" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->pvs2 == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->pvs2 == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->pvs2 == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->pvs2 == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->pvs2 == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->pvs2 == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->pvs2 == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->pvs2 == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->pvs2 == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                    <td>Endarterectomia I</td>
                                    <td>
                                        <select name="endarterectomia1" id="endarterectomia1" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->endarterectomia1 == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->endarterectomia1 == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->endarterectomia1 == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->endarterectomia1 == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->endarterectomia1 == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->endarterectomia1 == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->endarterectomia1 == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->endarterectomia1 == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->endarterectomia1 == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="200px;"></td>
                                    <td>PVS 3</td>
                                    <td width="150px;">
                                        <select name="pvs3" id="pvs3" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->pvs3 == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->pvs3 == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->pvs3 == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->pvs3 == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->pvs3 == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->pvs3 == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->pvs3 == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->pvs3 == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->pvs3 == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                    <td>Endarterectomia I</td>
                                    <td>
                                        <select name="endarterectomia2" id="endarterectomia2" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='DA' <? if (@$cirurgias->endarterectomia2 == 'DA'):echo 'selected';endif; ?>>DA</option>
                                            <option value='CX' <? if (@$cirurgias->endarterectomia2 == 'CX'):echo 'selected';endif; ?>>CX</option>                
                                            <option value='1MgCX' <? if (@$cirurgias->endarterectomia2 == '1MgCX'):echo 'selected';endif; ?>>1MgCX</option>                
                                            <option value='2MgCX' <? if (@$cirurgias->endarterectomia2 == '2MgCX'):echo 'selected';endif; ?>>2MgCX</option>                
                                            <option value='3MgCX' <? if (@$cirurgias->endarterectomia2 == '3MgCX'):echo 'selected';endif; ?>>3MgCX</option>                
                                            <option value='CD' <? if (@$cirurgias->endarterectomia2 == 'CD'):echo 'selected';endif; ?>>CD</option>                
                                            <option value='DP da CD' <? if (@$cirurgias->endarterectomia2 == 'DP da CD'):echo 'selected';endif; ?>>DP da CD</option>                
                                            <option value='Diagonal' <? if (@$cirurgias->endarterectomia2 == 'Diagonal'):echo 'selected';endif; ?>>Diagonal</option>                
                                            <option value='Diagonalis' <? if (@$cirurgias->endarterectomia2 == 'Diagonalis'):echo 'selected';endif; ?>>Diagonalis</option>                
                                             
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                 <tr>
                                    <td width="200px;">Prótese Valvar</td>
                                    <td>
                                        <select name="protesevalvar1" id="protesevalvar1" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='bioprotesemitral' <? if (@$cirurgias->protesevalvar1 == 'bioprotesemitral'):echo 'selected';endif; ?>>Bioprótese Mitral</option>
                                            <option value='bioproteaortica' <? if (@$cirurgias->protesevalvar1 == 'bioproteaortica'):echo 'selected';endif; ?>>Bioprótese Aórtica</option>                
                                            <option value='metalicamitral' <? if (@$cirurgias->protesevalvar1 == 'metalicamitral'):echo 'selected';endif; ?>>Metálica Mitral</option>                
                                            <option value='metalicaaortica' <? if (@$cirurgias->protesevalvar1 == 'metalicaaortica'):echo 'selected';endif; ?>>Metálica Aórtica</option>             
                                                           
                                             
                                        </select>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td width="200px;">Prótese Valvar</td>
                                    <td>
                                        <select name="protesevalvar2" id="protesevalvar2" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='bioprotesemitral' <? if (@$cirurgias->protesevalvar2 == 'bioprotesemitral'):echo 'selected';endif; ?>>Bioprótese Mitral</option>
                                            <option value='bioproteaortica' <? if (@$cirurgias->protesevalvar2 == 'bioproteaortica'):echo 'selected';endif; ?>>Bioprótese Aórtica</option>                
                                            <option value='metalicamitral' <? if (@$cirurgias->protesevalvar2 == 'metalicamitral'):echo 'selected';endif; ?>>Metálica Mitral</option>                
                                            <option value='metalicaaortica' <? if (@$cirurgias->protesevalvar2 == 'metalicaaortica'):echo 'selected';endif; ?>>Metálica Aórtica</option>                
                                                            
                                             
                                        </select>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td width="200px;">Plastia Valvar</td>
                                    <td>
                                        <select name="plastiavalvar1" id="plastiavalvar1" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='mitral' <? if (@$cirurgias->plastiavalvar1 == 'mitral'):echo 'selected';endif; ?>>Mitral</option>
                                            <option value='aortica' <? if (@$cirurgias->plastiavalvar1 == 'aortica'):echo 'selected';endif; ?>>Aórtica</option>                
                                            <option value='tricuspide' <? if (@$cirurgias->plastiavalvar1 == 'tricuspide'):echo 'selected';endif; ?>>Tricúspide</option>                
                                            <option value='pulmonar' <? if (@$cirurgias->plastiavalvar1 == 'pulmonar'):echo 'selected';endif; ?>>Pulmonar</option>                
                                                            
                                             
                                        </select>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td width="200px;">Plastia Valvar</td>
                                    <td>
                                        <select name="plastiavalvar2" id="plastiavalvar2" class="size1">
                                            <option value=''>SELECIONE</option>

                                            <option value='mitral' <? if (@$cirurgias->plastiavalvar2 == 'mitral'):echo 'selected';endif; ?>>Mitral</option>
                                            <option value='aortica' <? if (@$cirurgias->plastiavalvar2 == 'aortica'):echo 'selected';endif; ?>>Aórtica</option>                
                                            <option value='tricuspide' <? if (@$cirurgias->plastiavalvar2 == 'tricuspide'):echo 'selected';endif; ?>>Tricúspide</option>                
                                            <option value='pulmonar' <? if (@$cirurgias->plastiavalvar2 == 'pulmonar'):echo 'selected';endif; ?>>Pulmonar</option>                
                                                            
                                             
                                        </select>
                                    </td>
                                 </tr>
                                
                            </table>    
                        </td>
                      </tr>
                      <tr>
                          <td>
                              Congênitas <select name="congenitas" id="congenitas" class="size3">
                                            <option value=''>SELECIONE</option>
                                            <option value='atrioseptoplastia' <? if (@$cirurgias->congenitas == 'atrioseptoplastia'):echo 'selected';endif; ?>>Atrioseptoplastia</option>
                                         </select>
                          </td>
                          <td>
                              Outras Cirurgias <select name="outrascirurgias" id="outrascirurgias" class="size2">
                                                   <option value=''>SELECIONE</option>
                                                   <option value='cirurgiadeross' <? if (@$cirurgias->outrascirurgias == 'cirurgiadeross'):echo 'selected';endif; ?>>Cirurgia de Ross</option>
                                                   <option value='homoenxerto' <? if (@$cirurgias->outrascirurgias == 'homoenxerto'):echo 'selected';endif; ?>>Homoenxerto</option>
                                                   <option value='cirurgiadecox' <? if (@$cirurgias->outrascirurgias == 'cirurgiadecox'):echo 'selected';endif; ?>>Cirurgia de Cox</option>
                                                   <option value='aneurismectomia' <? if (@$cirurgias->outrascirurgias == 'aneurismectomia'):echo 'selected';endif; ?>>Aneurismectomia</option>
                                                   <option value='ventriculectomia' <? if (@$cirurgias->outrascirurgias == 'ventriculectomia'):echo 'selected';endif; ?>>Ventriculectomia</option>
                                                   <option value='pericardiocentese' <? if (@$cirurgias->outrascirurgias == 'pericardiocentese'):echo 'selected';endif; ?>>Pericardiocentese</option>
                                                   <option value='pericardiectomia' <? if (@$cirurgias->outrascirurgias == 'pericardiectomia'):echo 'selected';endif; ?>>Pericardiectomia</option>
                                               </select>    
                          </td>
                      </tr>
                     
                    </table>
                    <br><br>
                    <table align="center">
                      <tr>
                        <td width="150px;">Compl:</td>
                        <td>Insuf. Cardíaca</td><td><input type="checkbox" name="complicacao1" id="complicacao1" value="on"></td>
                        <td>Marcapasso</td><td><input type="checkbox" name="complicacao2" id="complicacao2" value="on"></td>
                        <td>Infecção/Sepse</td><td><input type="checkbox" name="complicacao3" id="complicacao3" value="on"></td>
                        <td>Derrame Pleural</td><td><input type="checkbox" name="complicacao4" id="complicacao4" value="on"></td>
                        <td>TVP</td><td><input type="checkbox" name="complicacao5" id="complicacao5" value="on"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>IAM</td><td><input type="checkbox" name="complicacao6" id="complicacao6" value="on"></td>
                        <td>Mediastinite</td><td><input type="checkbox" name="complicacao7" id="complicacao7" value="on"></td>
                        <td>Ins Renal c/ HD</td><td><input type="checkbox" name="complicacao8" id="complicacao8" value="on"></td>
                        <td>Hemorragia</td><td><input type="checkbox" name="complicacao9" id="complicacao9" value="on"></td>
                        <td>Embolia Pulmonar</td><td><input type="checkbox" name="complicacao10" id="complicacao10" value="on"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Pericardite</td><td><input type="checkbox" name="complicacao11" id="complicacao11" value="on"></td>
                        <td>Reoperação</td><td><input type="checkbox" name="complicacao12" id="complicacao12" value="on"></td>
                        <td>Ins Renal s/ HD</td><td><input type="checkbox" name="complicacao13" id="complicacao13" value="on"></td>
                        <td>Colecistite</td><td><input type="checkbox" name="complicacao14" id="complicacao14" value="on"></td>
                        <td>Oclusão Arterial</td><td><input type="checkbox" name="complicacao15" id="complicacao15" value="on"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Tampon. Cardiaco</td><td><input type="checkbox" name="complicacao16" id="complicacao16" value="on"></td>
                        <td>AVC</td><td><input type="checkbox" name="complicacao17" id="complicacao17" value="on"></td>
                        <td>Coagulopatia</td><td><input type="checkbox" name="complicacao18" id="complicacao18" value="on"></td>
                        <td>Pancreatite</td><td><input type="checkbox" name="complicacao19" id="complicacao19" value="on"></td>
                        <td>Deiscência</td><td><input type="checkbox" name="complicacao20" id="complicacao20" value="on"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Fibrilação Artrial</td><td><input type="checkbox" name="complicacao21" id="complicacao21" value="on"></td>
                        <td>Choque</td><td><input type="checkbox" name="complicacao22" id="complicacao22" value="on"></td>
                        <td>Insuf. Respiratória</td><td><input type="checkbox" name="complicacao23" id="complicacao23" value="on"></td>
                        <td>Cistostomia</td><td><input type="checkbox" name="complicacao24" id="complicacao24" value="on"></td>
                        <td>Isquemia Mess.</td><td><input type="checkbox" name="complicacao25" id="complicacao25" value="on"></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>BAVT</td><td><input type="checkbox" name="complicacao26" id="complicacao26" value="on"></td>
                        <td>BIA</td><td><input type="checkbox" name="complicacao27" id="complicacao27" value="on"></td>
                        <td>Reentubação</td><td><input type="checkbox" name="complicacao28" id="complicacao28" value="on"></td>
                        <td>Escara Decúbito</td><td><input type="checkbox" name="complicacao29" id="complicacao29" value="on"></td>
                        <td></td><td></td>
                      </tr>
                      <tr>                        
                        <td></td>
                        <td>Outras Arritmias</td><td><input type="checkbox" name="complicacao30" id="complicacao30" value="on"></td>
                        <td>Swan-Ganz</td><td><input type="checkbox" name="complicacao31" id="complicacao31" value="on"></td>
                        <td>Pneumotorax</td><td><input type="checkbox" name="complicacao32" id="complicacao32" value="on"></td>
                        <td>SARA</td><td><input type="checkbox" name="complicacao33" id="complicacao33" value="on"></td>
                        <td></td><td>
                            <button type="button" name="btnconsultacomp"onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/preencheravaliacao/<?= $ambulatorio_laudo_id ?>');" >
                                    Consulta Complicações
                                </button>
                        </td>
                      </tr>
                    </table>
                        
                </fieldset>
                <br>
                    <table align="center">
                        <td><button type="submit" name="btnEnviar">Salvar</button></td>
                        <td width="40px;"><button type="button" name="btnImprimir" onclick="javascript:window.open('<?= base_url() ?>ambulatorio/laudo/impressaocirurgia/<?= $ambulatorio_laudo_id ?>');">

                                Imprimir
                            </button>
                        </td>
                    </table>
            </div>
        </form>
    </div>
</div>

