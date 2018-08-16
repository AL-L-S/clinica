<meta http-equiv="content-type" content="text/html;charset=utf-8" />


<div >

    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');
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
                        
                    </table>
                </fieldset>

                <fieldset>
                    <? 
//                   
                    $cirurgias = json_decode(@$cirurgia[0]->cirurgias);
                    $complicacoes = json_decode(@$cirurgia[0]->complicacoes);
                    ?>
                    <table border="1" align="center">
                      <tr>
                        <td>    
                            <table>
                                <tr>
                                    <td><b>RM</b><input type="checkbox" name="ressonanciamag" id="ressonanciamag" value="on" <? if (@$cirurgia[0]->ressonanciamag == "on"){ ?> checked="" <? } ?> ></td>
                                    <td width="200px;"></td>
                                    <td>MIE:</td>
                                    <td width="150px;">
                                        <? echo "$cirurgias->mie"; ?>
                                    </td>
                                    <td>Radial D:</td>
                                    <td>
                                        <? echo "$cirurgias->radiald"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="200px;"></td>
                                    <td>MID:</td>
                                    <td width="150px;">
                                        <? echo "$cirurgias->mid"; ?>
                                    </td>
                                    <td>Radial E:</td>
                                    <td>
                                        <? echo "$cirurgias->radiale"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="200px;"></td>
                                    <td>PVS 1:</td>
                                    <td width="150px;">
                                        <? echo "$cirurgias->pvs1"; ?>
                                    </td>
                                    <td>Gastroepiploica:</td>
                                    <td>
                                        <? echo "$cirurgias->gastroepiploica"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="200px;"></td>
                                    <td>PVS 2</td>
                                    <td width="150px;">
                                        <? echo "$cirurgias->pvs2"; ?>
                                    </td>
                                    <td>Endarterectomia I:</td>
                                    <td>
                                        <? echo "$cirurgias->endarterectomia1"; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td width="200px;"></td>
                                    <td>PVS 3</td>
                                    <td width="150px;">
                                        <? echo "$cirurgias->pvs3"; ?>
                                    </td>
                                    <td>Endarterectomia I:</td>
                                    <td>
                                        <? echo "$cirurgias->endarterectomia2"; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                 <tr>
                                    <td width="200px;">Prótese Valvar:</td>
                                    <td>
                                        <? echo "$cirurgias->protesevalvar1"; ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td width="200px;">Prótese Valvar:</td>
                                    <td>
                                        <? echo "$cirurgias->protesevalvar2"; ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td width="200px;">Plastia Valvar:</td>
                                    <td>
                                        <? echo "$cirurgias->plastiavalvar1"; ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td width="200px;">Plastia Valvar:</td>
                                    <td>
                                        <? echo "$cirurgias->plastiavalvar2"; ?>
                                    </td>
                                 </tr>
                                
                            </table>    
                        </td>
                      </tr>
                      <tr>
                          <td>
                              Congênitas: <? echo "$cirurgias->congenitas"; ?>
                          </td>
                          <td>
                              Outras Cirurgias: <? echo "$cirurgias->outrascirurgias"; ?>    
                          </td>
                      </tr>
                     
                    </table>
                    <br><br>
                    <table align="center">
                      <tr>
                        <td width="150px;">Compl:</td>
                        <td>Insuf. Cardíaca</td><td><input type="checkbox" name="complicacao1" id="complicacao1" value="on" <? if ($complicacoes->complicacao1 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Marcapasso</td><td><input type="checkbox" name="complicacao2" id="complicacao2" value="on" <? if ($complicacoes->complicacao2 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Infecção/Sepse</td><td><input type="checkbox" name="complicacao3" id="complicacao3" value="on" <? if ($complicacoes->complicacao3 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Derrame Pleural</td><td><input type="checkbox" name="complicacao4" id="complicacao4" value="on" <? if ($complicacoes->complicacao4 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>TVP</td><td><input type="checkbox" name="complicacao5" id="complicacao5" value="on" <? if ($complicacoes->complicacao5 == "on"){ ?> checked="" <? } ?> ></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>IAM</td><td><input type="checkbox" name="complicacao6" id="complicacao6" value="on" <? if ($complicacoes->complicacao6 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Mediastinite</td><td><input type="checkbox" name="complicacao7" id="complicacao7" value="on" <? if ($complicacoes->complicacao7 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Ins Renal c/ HD</td><td><input type="checkbox" name="complicacao8" id="complicacao8" value="on" <? if ($complicacoes->complicacao8 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Hemorragia</td><td><input type="checkbox" name="complicacao9" id="complicacao9" value="on" <? if ($complicacoes->complicacao9 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Embolia Pulmonar</td><td><input type="checkbox" name="complicacao10" id="complicacao10" value="on" <? if ($complicacoes->complicacao10 == "on"){ ?> checked="" <? } ?> ></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Pericardite</td><td><input type="checkbox" name="complicacao11" id="complicacao11" value="on" <? if ($complicacoes->complicacao11 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Reoperação</td><td><input type="checkbox" name="complicacao12" id="complicacao12" value="on" <? if ($complicacoes->complicacao12 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Ins Renal s/ HD</td><td><input type="checkbox" name="complicacao13" id="complicacao13" value="on" <? if ($complicacoes->complicacao13 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Colecistite</td><td><input type="checkbox" name="complicacao14" id="complicacao14" value="on" <? if ($complicacoes->complicacao14 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Oclusão Arterial</td><td><input type="checkbox" name="complicacao15" id="complicacao15" value="on" <? if ($complicacoes->complicacao15 == "on"){ ?> checked="" <? } ?> ></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Tampon. Cardiaco</td><td><input type="checkbox" name="complicacao16" id="complicacao16" value="on" <? if ($complicacoes->complicacao16 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>AVC</td><td><input type="checkbox" name="complicacao17" id="complicacao17" value="on" <? if ($complicacoes->complicacao17 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Coagulopatia</td><td><input type="checkbox" name="complicacao18" id="complicacao18" value="on" <? if ($complicacoes->complicacao18 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Pancreatite</td><td><input type="checkbox" name="complicacao19" id="complicacao19" value="on" <? if ($complicacoes->complicacao19 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Deiscência</td><td><input type="checkbox" name="complicacao20" id="complicacao20" value="on" <? if ($complicacoes->complicacao20 == "on"){ ?> checked="" <? } ?> ></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>Fibrilação Artrial</td><td><input type="checkbox" name="complicacao21" id="complicacao21" value="on" <? if ($complicacoes->complicacao21 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Choque</td><td><input type="checkbox" name="complicacao22" id="complicacao22" value="on" <? if ($complicacoes->complicacao22 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Insuf. Respiratória</td><td><input type="checkbox" name="complicacao23" id="complicacao23" value="on" <? if ($complicacoes->complicacao23 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Cistostomia</td><td><input type="checkbox" name="complicacao24" id="complicacao24" value="on" <? if ($complicacoes->complicacao24 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Isquemia Mess.</td><td><input type="checkbox" name="complicacao25" id="complicacao25" value="on" <? if ($complicacoes->complicacao25 == "on"){ ?> checked="" <? } ?> ></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>BAVT</td><td><input type="checkbox" name="complicacao26" id="complicacao26" value="on" <? if ($complicacoes->complicacao26 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>BIA</td><td><input type="checkbox" name="complicacao27" id="complicacao27" value="on" <? if ($complicacoes->complicacao27 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Reentubação</td><td><input type="checkbox" name="complicacao28" id="complicacao28" value="on" <? if ($complicacoes->complicacao28 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Escara Decúbito</td><td><input type="checkbox" name="complicacao29" id="complicacao29" value="on" <? if ($complicacoes->complicacao29 == "on"){ ?> checked="" <? } ?> ></td>
                        <td></td><td></td>
                      </tr>
                      <tr>                        
                        <td></td>
                        <td>Outras Arritmias</td><td><input type="checkbox" name="complicacao30" id="complicacao30" value="on" <? if ($complicacoes->complicacao30 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Swan-Ganz</td><td><input type="checkbox" name="complicacao31" id="complicacao31" value="on" <? if ($complicacoes->complicacao31 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>Pneumotorax</td><td><input type="checkbox" name="complicacao32" id="complicacao32" value="on" <? if ($complicacoes->complicacao32 == "on"){ ?> checked="" <? } ?> ></td>
                        <td>SARA</td><td><input type="checkbox" name="complicacao33" id="complicacao33" value="on" <? if ($complicacoes->complicacao33 == "on"){ ?> checked="" <? } ?> ></td>
                        <td></td>
                      </tr>
                    </table>
                        
                </fieldset>
                <br>
                    
            </div>
        </form>
    </div>
</div>

