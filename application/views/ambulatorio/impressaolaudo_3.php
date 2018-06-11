<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />

<BODY>

    <p><b><?= $laudo['0']->cabecalho; ?></b></p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>MEDIDAS E C&Aacute;LCULOS</b>
     <table border="1">
                                        <tr>
                                            <td><font size = -2>Peso:</font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->peso); ?> Kg</font></td>
                                            <td width="60px;"><font size = -2></font></td>
                                            <td ><font size = -2>Altura:</font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->altura); ?> Cm</font></td>
                                            <td width="60px;"><font size = -2></font></td>
                                            <td ><font size = -2>Superf. corp.:</font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->superficie_corporea); ?>m²</font></td>
                                            <td><font size = -2></font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="9">&nbsp;</font></td>

                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>VENTRÍCULO ESQUERDO</font></td>
                                            <td width="60px;"></td>
                                            <td ></td>
                                            <td colspan="2"><font size = -2>Valor normal</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Volume telediastólico</font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_volume_telediastolico); ?></font></td>
                                            <td ><font size = -2>ml</font></td>
                                            <td ><font size = -2>50-176</font></td>
                                            <td ><font size = -2>ml</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Volume telessistólico</font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_volume_telessistolico); ?></font></td>
                                            <td ><font size = -2>ml</font></td>
                                            <td ><font size = -2>12-47</font></td>
                                            <td ><font size = -2>ml</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Diâmetro telediastólico </font></td>
                                            <td width="60px;"><?= str_replace(".", ",", $laudo['0']->ve_diametro_telediastolico); ?></font></td>
                                            <td ><font size = -2>mm</font></td>
                                            <td ><font size = -2>42-56 </font></td>
                                            <td ><font size = -2>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Diâmetro telessistólico</font> </td>
                                            <td width="60px;"><?= str_replace(".", ",", $laudo['0']->ve_diametro_telessistolico); ?></font></td>
                                            <td ><font size = -2>mm</font></td>
                                            <td ><font size = -2>23-36 </td>
                                            <td ><font size = -2>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Índice do diâmetro diastólico </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_indice_do_diametro_diastolico); ?></font></td>
                                            <td ><font size = -2>mm/m²</font></td>
                                            <td ><font size = -2>22-31</font></td>
                                            <td ><font size = -2>mm/m²</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Septo interventricular </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_septo_interventricular); ?></font></td>
                                            <td ><font size = -2>mm</font></td>
                                            <td ><font size = -2>6-10</font></td>
                                            <td ><font size = -2>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Parede posterior </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_parede_posterior); ?></font></td>
                                            <td ><font size = -2>mm</font></td>
                                            <td ><font size = -2>6-10</font></td>
                                            <td ><font size = -2>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Relação septo/parede posterior</font> </td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_relacao_septo_parede_posterior); ?></font></td>
                                            <td ></td>
                                            <td ><font size = -2>< 1,30</font></td>
                                            <td ></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Espessura relativa das paredes </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_espessura_relativa_paredes); ?></font></td>
                                            <td ></td>
                                            <td ><font size = -2>< 0,42</font></td>
                                            <td ></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Massa ventricular </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_massa_ventricular); ?></font></td>
                                            <td ><font size = -2>g</font></td>
                                            <td ><font size = -2>< 166  </font></td>
                                            <td ><font size = -2>g</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Índice de massa</font> </td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_indice_massa); ?></font></td>
                                            <td ><font size = -2>g/m²</font></td>
                                            <td ><font size = -2>< 116 </font> </td>
                                            <td ><font size = -2>g/m²</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Relação volume/massa</font> </td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_relacao_volume_massa); ?></font></td>
                                            <td ></td>
                                            <td ></td>
                                            <td ></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Fração de ejeção </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_fracao_ejecao); ?></font></td>
                                            <td ><font size = -2>%</font></td>
                                            <td ><font size = -2>> 55 </font></td>
                                            <td ><font size = -2>%</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Fração de encurtamento </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ve_fracao_encurtamento); ?></font></td>
                                            <td ><font size = -2>%</font></td>
                                            <td ><font size = -2>30-45</font> </td>
                                            <td ><font size = -2>%</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="9"><font size = -2>&nbsp;</font></td>

                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>VENTRÍCULO DIREITO</font></font></td>
                                            <td width="60px;"></td>
                                            <td ></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Diâmetro telediastólico</font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->vd_diametro_telediastolico); ?></font></td>
                                            <td ><font size = -2>mm</font></font></td>
                                            <td ><font size = -2>< 34 </font></td>
                                            <td <font size = -2>>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Área telediastólica</font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->vd_area_telediastolica); ?></font></td>
                                            <td ><font size = -2>cm²</font></td>
                                            <td ><font size = -2>< 29 </font></td>
                                            <td ><font size = -2>cm²</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="9"><font size = -2>&nbsp;</font></td>

                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>ÁTRIO ESQUERDO</font></td>
                                            <td width="60px;"></td>
                                            <td ></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Diâmetro </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ae_diametro); ?></font></td>
                                            <td ><font size = -2>mm</font></td>
                                            <td ><font size = -2>30-40  </font></font></td>
                                            <td ><font size = -2>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Índice de diâmetro</font> </td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ae_indice_diametro); ?></font></td>
                                            <td ><font size = -2>mm/m²</font></td>
                                            <td ><font size = -2>15-23</font> </td>
                                            <td ><font size = -2>mm/m²</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="9"><font size = -2>&nbsp;</font></td>

                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>AORTA</font></td>
                                            <td width="60px;"></td>
                                            <td ></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Diâmetro da raiz </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ao_diametro_raiz); ?></font></td>
                                            <td ><font size = -2>mm</font></td>
                                            <td ><font size = -2>20-37</font></td>
                                            <td ><font size = -2>mm</font></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"><font size = -2>Relação átrio esquerdo/aorta </font></td>
                                            <td width="60px;"><font size = -2><?= str_replace(".", ",", $laudo['0']->ao_relacao_atrio_esquerdo_aorta); ?></font></td>
                                            <td ></td>
                                            <td ><font size = -2>< 1,50</font></td>
                                            <td ></td>
                                        </tr>
                                        <tr>
                                    </table>
    
    
    <p><?= $laudo['0']->texto; ?></p>




            <?
            if ( $laudo['0']->situacao == "FINALIZADO" && $laudo['0']->medico_parecer2 == "" || $laudo['0']->medico_parecer1 == 38 ) {
                ?>
    <br>
    <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img width="180px" height="110px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".bmp" ?>"></center>
                <?
            }
            if ($laudo['0']->situacao == "FINALIZADO" && $laudo['0']->medico_parecer2 != "") {
                ?>
    <br>
    <br>
                <img  width="180px" height="110px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer1 . ".bmp" ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img  width="130px" height="80px" src="<?= base_url() . "upload/1ASSINATURAS/" . $laudo['0']->medico_parecer2 . ".bmp" ?>">
            <? }
            ?>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <?
        if ($laudo['0']->rodape == "t") {
            ?>
            <FONT size="-1"> REALIZAMOS EXAMES DE RESSON&Acirc;NCIA MAGN&Eacute;TICA DE ALTO CAMPO (1,5T)
            <?
        }
        ?>
</BODY>
</HTML>