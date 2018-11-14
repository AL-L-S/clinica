<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular">Detalhar NR</h3>
        <div>            
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gravardetalhamentonr/<?= $aso_id?>/<?= $paciente_id?>">
                <? $detalhamento = $this->guia->preencherdetalhamento($aso_id);
                   $diagnostico = json_decode(@$detalhamento[0]->detalhamento_nr);
//                   echo '<pre>';var_dump($diagnostico);
                ?>
                <table>
                    <h3>Selecione os Crit&eacute;rios a baixo:</h3>
                    <tr>
                        <td width="400px"><input type="radio" name="diagnostico1" id="d11" value="APTO" <? if (@$diagnostico->diagnostico1 == "APTO"):echo 'checked'; endif; ?>>Apto para as atividades da fun&ccedil;&atilde;o</td>
                        <td width="400px"><input type="radio" name="diagnostico1" id="d12" value="INAPTO" <? if (@$diagnostico->diagnostico1 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para as atividades da fun&ccedil;&atilde;o</td>
                        <td width="250px"><input type="radio" name="diagnostico1" id="d13" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico1 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>                            
                    </tr>
                    <tr>
                        <td><input type="radio" name="diagnostico2" id="d21" value="APTO" <? if (@$diagnostico->diagnostico2 == "APTO"):echo 'checked'; endif; ?>>Apto para trabalho em altura</td>
                        <td><input type="radio" name="diagnostico2" id="d22" value="INAPTO" <? if (@$diagnostico->diagnostico2 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para trabalho em altura</td>
                        <td><input type="radio" name="diagnostico2" id="d23" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico2 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>                            
                        <td><input type="radio" name="diagnostico2" id="d24" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico2 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>                            
                    </tr>
                    <tr>
                        <td><input type="radio" name="diagnostico3" id="d31" value="APTO" <? if (@$diagnostico->diagnostico3 == "APTO"):echo 'checked'; endif; ?>>Apto para espa&ccedil;o confinado</td>
                        <td><input type="radio" name="diagnostico3" id="d32" value="INAPTO" <? if (@$diagnostico->diagnostico3 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para espa&ccedil;o confinado</td>                                                        
                        <td><input type="radio" name="diagnostico3" id="d33" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico3 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>                                                        
                        <td><input type="radio" name="diagnostico3" id="d34" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico3 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>                                                        
                    </tr>
                    <tr>
                        <td><input type="radio" name="diagnostico4" id="d41" value="APTO" <? if (@$diagnostico->diagnostico4 == "APTO"):echo 'checked'; endif; ?>>Apto para trabalho noturno</td>
                        <td><input type="radio" name="diagnostico4" id="d42" value="INAPTO" <? if (@$diagnostico->diagnostico4 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para trabalho noturno</td>
                        <td><input type="radio" name="diagnostico4" id="d43" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico4 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>
                        <td><input type="radio" name="diagnostico4" id="d44" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico4 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="radio" name="diagnostico5" id="d51" value="APTO" <? if (@$diagnostico->diagnostico5 == "APTO"):echo 'checked'; endif; ?>>Apto para brigada de inc&ecirc;ndio</td>
                        <td><input type="radio" name="diagnostico5" id="d52" value="INAPTO" <? if (@$diagnostico->diagnostico5 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para brigada de inc&ecirc;ndio</td>
                        <td><input type="radio" name="diagnostico5" id="d53" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico5 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>
                        <td><input type="radio" name="diagnostico5" id="d54" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico5 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="radio" name="diagnostico6" id="d61" value="APTO" <? if (@$diagnostico->diagnostico6 == "APTO"):echo 'checked'; endif; ?>>Apto para trabalho Mov. Cargas</td>
                        <td><input type="radio" name="diagnostico6" id="d62" value="INAPTO" <? if (@$diagnostico->diagnostico6 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para trabalho Mov. Cargas</td>
                        <td><input type="radio" name="diagnostico6" id="d63" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico6 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>
                        <td><input type="radio" name="diagnostico6" id="d64" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico6 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="radio" name="diagnostico7" id="d71" value="APTO" <? if (@$diagnostico->diagnostico7 == "APTO"):echo 'checked'; endif; ?>>Apto para Manipula&ccedil;&atilde;o de Alimentos</td>
                        <td><input type="radio" name="diagnostico7" id="d72" value="INAPTO" <? if (@$diagnostico->diagnostico7 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para manipula&ccedil;&atilde;o de Alimentos</td>
                        <td><input type="radio" name="diagnostico7" id="d73" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico7 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>
                        <td><input type="radio" name="diagnostico7" id="d74" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico7 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="radio" name="diagnostico8" id="d81" value="APTO" <? if (@$diagnostico->diagnostico8 == "APTO"):echo 'checked'; endif; ?>>Apto para Equipamento M&oacute;vel</td>
                        <td><input type="radio" name="diagnostico8" id="d82" value="INAPTO" <? if (@$diagnostico->diagnostico8 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para Equipamento M&oacute;vel</td>
                        <td><input type="radio" name="diagnostico8" id="d83" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico8 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>
                        <td><input type="radio" name="diagnostico8" id="d84" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico8 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="radio" name="diagnostico9" id="d91" value="APTO" <? if (@$diagnostico->diagnostico9 == "APTO"):echo 'checked'; endif; ?>>Apto para Ve&iacute;culos Auto Motores</td>
                        <td><input type="radio" name="diagnostico9" id="d92" value="INAPTO" <? if (@$diagnostico->diagnostico9 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para Ve&iacute;culos Auto Motores</td>
                        <td><input type="radio" name="diagnostico9" id="d93" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico9 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>
                        <td><input type="radio" name="diagnostico9" id="d94" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico9 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="radio" name="diagnostico10" id="d101" value="APTO" <? if (@$diagnostico->diagnostico10 == "APTO"):echo 'checked'; endif; ?>>Apto para trabalho com Eletricidade</td>
                        <td><input type="radio" name="diagnostico10" id="d102" value="INAPTO" <? if (@$diagnostico->diagnostico10 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para trabalho com Eletricidade</td>
                        <td><input type="radio" name="diagnostico10" id="d103" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico10 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>
                        <td><input type="radio" name="diagnostico10" id="d104" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico10 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="radio" name="diagnostico11" id="d111" value="APTO" <? if (@$diagnostico->diagnostico11 == "APTO"):echo 'checked'; endif; ?>>Apto para Produtos Qu&iacute;micos</td>
                        <td><input type="radio" name="diagnostico11" id="d112" value="INAPTO" <? if (@$diagnostico->diagnostico11 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para Produtos Qu&iacute;micos</td>
                        <td><input type="radio" name="diagnostico11" id="d113" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico11 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>
                        <td><input type="radio" name="diagnostico11" id="d114" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico11 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="radio" name="diagnostico12" id="d121" value="APTO" <? if (@$diagnostico->diagnostico12 == "APTO"):echo 'checked'; endif; ?>>Apto para Produtos Inflam&aacute;veis</td>
                        <td><input type="radio" name="diagnostico12" id="d122" value="INAPTO" <? if (@$diagnostico->diagnostico12 == "INAPTO"):echo 'checked'; endif; ?>>Inapto para Produtos Inflam&aacute;veis</td>
                        <td><input type="radio" name="diagnostico12" id="d123" value="NAO MAPEADO" <? if (@$diagnostico->diagnostico12 == "NAO MAPEADO"):echo 'checked'; endif; ?>>N&atilde;o Mapeado</td>
                        <td><input type="radio" name="diagnostico12" id="d124" value="NAO SE APLICA" <? if (@$diagnostico->diagnostico12 == "NAO SE APLICA"):echo 'checked'; endif; ?>>N&atilde;o se Aplica</td>
                    </tr> 
                </table>
                <br><br>
                <table>
                    <tr>
                        <td>
                            <button type="submit" name="btnEnviar">Enviar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>

