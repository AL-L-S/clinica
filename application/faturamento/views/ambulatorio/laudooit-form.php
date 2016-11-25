<div class="content ficha_oit"> <!-- Inicio da DIV content -->
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>ambulatorio/laudo/gravaroit" method="post">
        <fieldset>
            <legend>LAUDO OIT</legend>
            <div>
                <label><b><u>NOME</u></b></label>                      
                <input type="text" id="txtNome" name="nome" class="texto10"  value="<?= @$obj->_nome; ?>" readonly/>
                <input type="hidden" id="ambulatorio_laudooit_id" name="ambulatorio_laudooit_id" class="texto10"  value="<?= @$obj->_ambulatorio_laudooit_id; ?>"/>
            </div>
            <div>
                <label><b><u>DATA DO RX</u></b></label>
                <input type="text" name="datarx" id="datarx" class="texto02" value="<?php echo substr(@$obj->_data_cadastro, 8, 2) . '/' . substr(@$obj->_data_cadastro, 5, 2) . '/' . substr(@$obj->_data_cadastro, 0, 4); ?>" readonly/>
            </div>
            <div>
                <label><b><u>Nº RX</u></b></label>
                <input type="text" name="exame" id="exame" class="texto06" value="<?= @$obj->_exame_id; ?>" readonly/>
            </div>
            <div>
                <label><b><u>LEITOR</u></b></label>
                <select name="medico_parecer" id="medico_parecer" class="size2">
                    <? foreach ($operadores as $value) : ?>
                        <option value="<?= $value->operador_id; ?>"<?
                        if (@$obj->_medico == $value->operador_id):echo 'selected';
                        endif;
                        ?>><?= $value->nome; ?></option>
                            <? endforeach; ?>
                </select>
            </div>
            <div>
                <label><b><u>DATA DA LEITURA</u></b></label>
                <input type="text"  id="data" name="data" class="size1"  value="<?= @$obj->_data; ?>" />
            </div>
        </fieldset>
        <fieldset>
            <legend>1</legend>
            <div>
                <label><b><u>1A QUALIDADE T&Eacute;CNICA</u></b></label>
                <select name="qualidade_tecnica" id="qualidade_tecnica" class="size4">
                    <option value="1"<?
                    if (@$obj->_qualidade_tecnica == 1):echo 'selected';
                    endif;
                    ?>>1</option>
                    <option value="2"<?
                    if (@$obj->_qualidade_tecnica == 2):echo 'selected';
                    endif;
                    ?>>2</option>
                    <option value="3"<?
                    if (@$obj->_qualidade_tecnica == 3):echo 'selected';
                    endif;
                    ?>>3</option>
                    <option value="4"<?
                    if (@$obj->_qualidade_tecnica == 4):echo 'selected';
                    endif;
                    ?>>4</option>
                </select>
            </div>
            <div>
                <label><b><u>1B RADIOGRAFIA NORMAL</u></b></label>
                <select name="radiografia_normal" id="radiografia_normal" class="size2">
                    <option value="t"<?
                    if (@$obj->_radiografia_normal == "t"):echo 'selected';
                    endif;
                    ?>>SIM</option>
                    <option value="f"<?
                    if (@$obj->_radiografia_normal == "f"):echo 'selected';
                    endif;
                    ?>>N&Atilde;O</option>
                </select>
            </div>
            <div>
                <label>Coment&aacute;rio</label>
                <input type="text"  id="comentario_1a" name="comentario_1a" class="size13"  value="<?= @$obj->_comentario_1a; ?>" />
            </div>
        </fieldset>
        <fieldset>
            <legend>2A</legend>
            <div>
                <label><b><u>2A ALGUMA ANORMALIDADE DE PARENQUIMA CONSISTENTE COM PNEUMOCONIOSE                                    </u></b></label>
                <select name="anormalidade_parenquima" id="anormalidade_parenquima" class="size2">
                    <option value="t"<?
                    if (@$obj->_anormalidade_parenquima == "t"):echo 'selected';
                    endif;
                    ?>>SIM</option>
                    <option value="f"<?
                    if (@$obj->_anormalidade_parenquima == "f"):echo 'selected';
                    endif;
                    ?>>N&Atilde;O</option>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>2B</legend>
            <div>
                <label><b><u>2B PEQUENAS OPCIDADES</u></b></label>
                <div>
                    <label>a) Forma / tamanho</label>
                    <div>
                        <label>Prim&aacute;ria</label>
                        <select name="forma_primaria" id="forma_primaria" class="size1">
                            <option value="p"<?
                            if (@$obj->_forma_primaria == "p"):echo 'selected';
                            endif;
                            ?>>p</option>
                            <option value="q"<?
                            if (@$obj->_forma_primaria == "q"):echo 'selected';
                            endif;
                            ?>>q</option>
                            <option value="r"<?
                            if (@$obj->_forma_primaria == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                            <option value="s"<?
                            if (@$obj->_forma_primaria == "s"):echo 'selected';
                            endif;
                            ?>>s</option>
                            <option value="t"<?
                            if (@$obj->_forma_primaria == "t"):echo 'selected';
                            endif;
                            ?>>t</option>
                            <option value="u"<?
                            if (@$obj->_forma_primaria == "u"):echo 'selected';
                            endif;
                            ?>>u</option>
                        </select>
                    </div>
                    <div>
                        <label>Secun&aacute;ria</label>
                        <select name="forma_secundaria" id="forma_secundaria" class="size1">
                            <option value="p"<?
                            if (@$obj->_forma_secundaria == "p"):echo 'selected';
                            endif;
                            ?>>p</option>
                            <option value="q"<?
                            if (@$obj->_forma_secundaria == "q"):echo 'selected';
                            endif;
                            ?>>q</option>
                            <option value="r"<?
                            if (@$obj->_forma_secundaria == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                            <option value="s"<?
                            if (@$obj->_forma_secundaria == "s"):echo 'selected';
                            endif;
                            ?>>s</option>
                            <option value="t"<?
                            if (@$obj->_forma_secundaria == "t"):echo 'selected';
                            endif;
                            ?>>t</option>
                            <option value="u"<?
                            if (@$obj->_forma_secundaria == "u"):echo 'selected';
                            endif;
                            ?>>u</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label>b)Zonas</label>
                    <div>
                        <label>D</label>
                        <input type="text"  id="zona_d" name="zona_d" class="size2"  value="<?= @$obj->_zona_d; ?>" />
                    </div>
                    <div>
                        <label>E</label>
                        <input type="text"  id="zona_e" name="zona_e" class="size2"  value="<?= @$obj->_zona_e; ?>" />
                    </div>
                </div>
                <div>
                    <label>c) Profus&atilde;o</label>
                    <div>
                        <select name="profusao" id="profusao" class="size1">
                            <option value="0/-"<?
                            if (@$obj->_profusao == "0/-"):echo 'selected';
                            endif;
                            ?>>0/-</option>
                            <option value="0/0"<?
                            if (@$obj->_profusao == "0/0"):echo 'selected';
                            endif;
                            ?>>0/0</option>
                            <option value="0/1"<?
                            if (@$obj->_profusao == "0/1"):echo 'selected';
                            endif;
                            ?>>0/1</option>
                            <option value="1/0"<?
                            if (@$obj->_profusao == "1/0"):echo 'selected';
                            endif;
                            ?>>1/0</option>
                            <option value="1/1"<?
                            if (@$obj->_profusao == "1/1"):echo 'selected';
                            endif;
                            ?>>1/1</option>
                            <option value="1/2"<?
                            if (@$obj->_profusao == "1/2"):echo 'selected';
                            endif;
                            ?>>1/2</option>
                            <option value="2/1"<?
                            if (@$obj->_profusao == "2/1"):echo 'selected';
                            endif;
                            ?>>2/1</option>
                            <option value="2/2"<?
                            if (@$obj->_profusao == "2/2"):echo 'selected';
                            endif;
                            ?>>2/2</option>
                            <option value="2/3"<?
                            if (@$obj->_profusao == "2/3"):echo 'selected';
                            endif;
                            ?>>2/3</option>
                            <option value="3/2"<?
                            if (@$obj->_profusao == "3/2"):echo 'selected';
                            endif;
                            ?>>3/2</option>
                            <option value="3/3"<?
                            if (@$obj->_profusao == "3/3"):echo 'selected';
                            endif;
                            ?>>3/3</option>
                            <option value="3/4"<?
                            if (@$obj->_profusao == "3/4"):echo 'selected';
                            endif;
                            ?>>3/4</option>
                        </select>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>2C</legend>
            <div>
                <label><b><u>2C GRANDES OPACIDADES</u></b></label>
                <select name="grandes_opacidades" id="grandes_opacidades" class="size2">
                    <option value="0"<?
                    if (@$obj->_grandes_opacidades == "0"):echo 'selected';
                    endif;
                    ?>>0</option>
                    <option value="A"<?
                    if (@$obj->_grandes_opacidades == "A"):echo 'selected';
                    endif;
                    ?>>A</option>
                    <option value="B"<?
                    if (@$obj->_grandes_opacidades == "B"):echo 'selected';
                    endif;
                    ?>>B</option>
                    <option value="C"<?
                    if (@$obj->_grandes_opacidades == "C"):echo 'selected';
                    endif;
                    ?>>C</option>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>3</legend>
            <div>
                <label><b><u>3A ALGUMA ANORMALIDADE PLEURAL CONSISTENTE COM PNEUMOCONIOSE</u></b></label>
                <select name="anormalidade_pleural" id="anormalidade_pleural" class="size2">
                    <option value="t"<?
                    if (@$obj->_anormalidade_pleural == "t"):echo 'selected';
                    endif;
                    ?>>SIM</option>
                    <option value="f"<?
                    if (@$obj->_anormalidade_pleural == "f"):echo 'selected';
                    endif;
                    ?>>N&Atilde;O</option>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>3B</legend>
            <div>
                <label><b><u>3B PLACAS PLEURAIS</u></b></label>
                <select name="placa_pleuras" id="placa_pleuras" class="size2">
                    <option value="t"<?
                    if (@$obj->_placa_pleuras == "t"):echo 'selected';
                    endif;
                    ?>>SIM</option>
                    <option value="f"<?
                    if (@$obj->_placa_pleuras == "f"):echo 'selected';
                    endif;
                    ?>>N&Atilde;O</option>
                </select>
                <br>
                <div>
                    <label>Local</label>
                    <div>
                        <label>Parede em perfil</label>
                        <select name="local_paredeperfil_3b" id="local_paredeperfil_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_local_paredeperfil_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_local_paredeperfil_3b == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_local_paredeperfil_3b == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div>
                    <div>
                        <label>Frontal</label>
                        <select name="local_frontal_3b" id="local_paredeperfil_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_local_frontal_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_local_frontal_3b == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_local_frontal_3b == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div>
                    <div2>
                        <label>Diagrama</label>
                        <select name="local_diafragma_3b" id="local_diafragma_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_local_diafragma_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_local_diafragma_3b == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_local_diafragma_3b == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div2>
                    <div>
                        <label>Outros locais</label>
                        <select name="local_outroslocais_3b" id="local_outroslocais_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_local_outroslocais_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_local_outroslocais_3b == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_local_outroslocais_3b == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label>CALCIFICA&Ccedil;&Atilde;O</label>
                    <div>
                        <label>Parede em perfil</label>
                        <select name="calcificacao_paredeperfil_3b" id="calcificacao_paredeperfil_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_calcificacao_paredeperfil_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_calcificacaol_paredeperfil_3b == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_calcificacao_paredeperfil_3b == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div>
                    <div2>
                        <label>Frontal</label>
                        <select name="calcificacao_frontal_3b" id="calcificacao_paredeperfil_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_calcificacao_frontal_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_calcificacao_frontal_3b == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_calcificacao_frontal_3b == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div2>
                    <div2>
                        <label>Diagrama</label>
                        <select name="calcificacao_diafragma_3b" id="calcificacao_diafragma_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_calcificacao_diafragma_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_calcificacao_diafragma_3b == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_calcificacao_diafragma_3b == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div2>
                    <div>
                        <label>Outros locais</label>
                        <select name="calcificacao_outroslocais_3b" id="calcificacao_outroslocais_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_calcificacao_outroslocais_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_calcificacao_outroslocais_3b == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_calcificacao_outroslocais_3b == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label>EXTENS&Atilde;O</label>
                    <div>
                        <label>Parede em perfil</label>
                        <select name="extensao_parede_d_3b" id="extensao_parede_d_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_extensao_parede_d_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="1"<?
                            if (@$obj->_extensao_parede_d_3b == "1"):echo 'selected';
                            endif;
                            ?>>1</option>
                            <option value="2"<?
                            if (@$obj->_extensao_parede_d_3b == "2"):echo 'selected';
                            endif;
                            ?>>2</option>
                            <option value="3"<?
                            if (@$obj->_extensao_parede_d_3b == "3"):echo 'selected';
                            endif;
                            ?>>3</option>
                        </select>
                        <table>
                            <tr><td><font size= -2>At&eacute; 1/4 da parede lateral</font></td></tr>
                            <tr><td><font size= -2>1/4 a 1/2 da parede lateral</font></td></tr>
                            <tr><td><font size= -2>1/2 da parede lateral</font></td></tr>
                        </table>
                    </div>
                    <div>
                        <label>Frontal</label>
                        <select name="extensao_parede_e_3b" id="extensao_parede_e_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_extensao_parede_e_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="1"<?
                            if (@$obj->_extensao_parede_e_3b == "1"):echo 'selected';
                            endif;
                            ?>>1</option>
                            <option value="2"<?
                            if (@$obj->_extensao_parede_e_3b == "2"):echo 'selected';
                            endif;
                            ?>>2</option>
                            <option value="3"<?
                            if (@$obj->_extensao_parede_e_3b == "3"):echo 'selected';
                            endif;
                            ?>>3</option>
                        </select>
                        <table>
                            <tr><td>= 1</td></tr>
                            <tr><td>= 2</td></tr>
                            <tr><td>= 3</td></tr>
                        </table>
                    </div>
                </div>
                <div>
                    <label>LARGURA</label>
                    <div>
                        <label>Parede em perfil</label>
                        <select name="largura_d_3b" id="largura_d_3b" class="size04">
                            <option value="a"<?
                            if (@$obj->_largura_d_3b == "a"):echo 'selected';
                            endif;
                            ?>>a</option>
                            <option value="b"<?
                            if (@$obj->_largura_d_3b == "b"):echo 'selected';
                            endif;
                            ?>>b</option>
                            <option value="c"<?
                            if (@$obj->_largura_d_3b == "c"):echo 'selected';
                            endif;
                            ?>>c</option>
                        </select>
                        <table>
                            <tr><td>3 a 5 mm</td></tr>
                            <tr><td>5 a 10 mm</td></tr>
                            <tr><td>> 10 mm</td></tr>
                        </table>
                    </div>
                    <div>
                        <label>Frontal</label>
                        <select name="largura_e_3b" id="largura_e_3b" class="size04">
                            <option value="a"<?
                            if (@$obj->_largura_e_3b == "a"):echo 'selected';
                            endif;
                            ?>>a</option>
                            <option value="b"<?
                            if (@$obj->_largura_e_3b == "b"):echo 'selected';
                            endif;
                            ?>>b</option>
                            <option value="c"<?
                            if (@$obj->_largura_e_3b == "c"):echo 'selected';
                            endif;
                            ?>>c</option>
                        </select>
                        <table>
                            <tr><td>= a</td></tr>
                            <tr><td>= b</td></tr>
                            <tr><td>= c</td></tr>
                        </table>
                    </div>
                </div>
        </fieldset>
        <fieldset>
            <legend>3C</legend>
            <div>
                <label><b><u>3C OBLITERA&Ccedil;&Atilde;O DO SEIO COSTOFRENICO</u></b></label>
                <select name="obliteracao" id="obliteracao" class="size2">
                    <option value="0"<?
                    if (@$obj->_obliteracao == "0"):echo 'selected';
                    endif;
                    ?>>0</option>
                    <option value="D"<?
                    if (@$obj->_obliteracao == "D"):echo 'selected';
                    endif;
                    ?>>D</option>
                    <option value="E"<?
                    if (@$obj->_obliteracao == "E"):echo 'selected';
                    endif;
                    ?>>E</option>
                </select>
            </div>
        </fieldset>

        <fieldset>
            <legend>3D</legend>
            <div>
                <label><b><u>3D ESPESSAMENTO PLEURAL DIFUSO</u></b></label>
                <select name="espessamento_pleural_difuso" id="espessamento_pleural_difuso" class="size2">
                    <option value="t"<?
                    if (@$obj->_espessamento_pleural_difuso == "t"):echo 'selected';
                    endif;
                    ?>>SIM</option>
                    <option value="f"<?
                    if (@$obj->_espessamento_pleural_difuso == "f"):echo 'selected';
                    endif;
                    ?>>N&Atilde;O</option>
                </select>
                <br>
                <div>
                    <label>Local</label>
                    <div>
                        <label>Parede em perfil</label>
                        <select name="local_parede_perfil_3d" id="local_parede_perfil_3d" class="size04">
                            <option value="0"<?
                            if (@$obj->_local_parede_perfil_3d == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_local_parede_perfil_3d == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_local_parede_perfil_3d == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div>
                    <div>
                        <label>Frontal</label>
                        <select name="local_parede_frontal_3d" id="local_parede_frontal_3d" class="size04">
                            <option value="0"<?
                            if (@$obj->_local_parede_frontal_3d == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_local_parede_frontal_3d == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_local_parede_frontal_3d == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label>CALCIFICA&Ccedil;&Atilde;O</label>
                    <div>
                        <label>Parede em perfil</label>
                        <select name="calcificacao_parede_perfil_3d" id="calcificacao_parede_perfil_3d" class="size04">
                            <option value="0"<?
                            if (@$obj->_calcificacao_parede_perfil_3d == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_calcificacao_parede_perfil_3d == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_calcificacao_parede_perfil_3d == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div>
                    <div2>
                        <label>Frontal</label>
                        <select name="calcificacao_parede_frontal_3d" id="calcificacao_parede_frontal_3d" class="size04">
                            <option value="0"<?
                            if (@$obj->_calcificacao_parede_frontal_3d == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="D"<?
                            if (@$obj->_calcificacao_parede_frontal_3d == "D"):echo 'selected';
                            endif;
                            ?>>D</option>
                            <option value="r"<?
                            if (@$obj->_calcificacao_parede_frontal_3d == "r"):echo 'selected';
                            endif;
                            ?>>r</option>
                        </select>
                    </div2>
                </div>
                <div>
                    <label>EXTENS&Atilde;O</label>
                    <div>
                        <label>Parede em perfil</label>
                        <select name="extensao_parede_d_3b" id="extensao_parede_d_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_extensao_parede_d_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="1"<?
                            if (@$obj->_extensao_parede_d_3b == "1"):echo 'selected';
                            endif;
                            ?>>1</option>
                            <option value="2"<?
                            if (@$obj->_extensao_parede_d_3b == "2"):echo 'selected';
                            endif;
                            ?>>2</option>
                            <option value="3"<?
                            if (@$obj->_extensao_parede_d_3b == "3"):echo 'selected';
                            endif;
                            ?>>3</option>
                        </select>
                        <table>
                            <tr><td><font size= -2>At&eacute; 1/4 da parede lateral</font></td></tr>
                            <tr><td><font size= -2>1/4 a 1/2 da parede lateral</font></td></tr>
                            <tr><td><font size= -2>1/2 da parede lateral</font></td></tr>
                        </table>
                    </div>
                    <div>
                        <label>Frontal</label>
                        <select name="extensao_parede_e_3b" id="extensao_parede_e_3b" class="size04">
                            <option value="0"<?
                            if (@$obj->_extensao_parede_e_3b == "0"):echo 'selected';
                            endif;
                            ?>>0</option>
                            <option value="1"<?
                            if (@$obj->_extensao_parede_e_3b == "1"):echo 'selected';
                            endif;
                            ?>>1</option>
                            <option value="2"<?
                            if (@$obj->_extensao_parede_e_3b == "2"):echo 'selected';
                            endif;
                            ?>>2</option>
                            <option value="3"<?
                            if (@$obj->_extensao_parede_e_3b == "3"):echo 'selected';
                            endif;
                            ?>>3</option>
                        </select>
                        <table>
                            <tr><td>= 1</td></tr>
                            <tr><td>= 2</td></tr>
                            <tr><td>= 3</td></tr>
                        </table>
                    </div>
                </div>
                <div>
                    <label>LARGURA</label>
                    <div>
                        <label>Parede em perfil</label>
                        <select name="largura_d_3b" id="largura_d_3b" class="size04">
                            <option value="a"<?
                            if (@$obj->_largura_d_3b == "a"):echo 'selected';
                            endif;
                            ?>>a</option>
                            <option value="b"<?
                            if (@$obj->_largura_d_3b == "b"):echo 'selected';
                            endif;
                            ?>>b</option>
                            <option value="c"<?
                            if (@$obj->_largura_d_3b == "c"):echo 'selected';
                            endif;
                            ?>>c</option>
                        </select>
                        <table>
                            <tr><td>3 a 5 mm</td></tr>
                            <tr><td>5 a 10 mm</td></tr>
                            <tr><td>> 10 mm</td></tr>
                        </table>
                    </div>
                    <div>
                        <label>Frontal</label>
                        <select name="largura_e_3b" id="largura_e_3b" class="size04">
                            <option value="a"<?
                            if (@$obj->_largura_e_3b == "a"):echo 'selected';
                            endif;
                            ?>>a</option>
                            <option value="b"<?
                            if (@$obj->_largura_e_3b == "b"):echo 'selected';
                            endif;
                            ?>>b</option>
                            <option value="c"<?
                            if (@$obj->_largura_e_3b == "c"):echo 'selected';
                            endif;
                            ?>>c</option>
                        </select>
                        <table>
                            <tr><td>= a</td></tr>
                            <tr><td>= b</td></tr>
                            <tr><td>= c</td></tr>
                        </table>
                    </div>
                </div>
        </fieldset>
        <fieldset>
            <legend>4A</legend>
            <div>
                <label><b><u>4A OUTRAS ANORMALIDADES:</u></b></label>
                <select name="anormalidade_parenquima" id="anormalidade_parenquima" class="size2">
                    <option value="t"<?
                    if (@$obj->_anormalidade_parenquima == "t"):echo 'selected';
                    endif;
                    ?>>SIM</option>
                    <option value="f"<?
                    if (@$obj->_anormalidade_parenquima == "f"):echo 'selected';
                    endif;
                    ?>>N&Atilde;O</option>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>4B</legend>
            <div>
                <label><b><u>4B SIMBOLOS:</u></b></label>
                <select name="simbolos" id="simbolos" class="size2">
                    <option value="aa"<?
                    if (@$obj->_simbolos == "aa"):echo 'selected';
                    endif;
                    ?>>aa</option>
                    <option value="at"<?
                    if (@$obj->_simbolos == "at"):echo 'selected';
                    endif;
                    ?>>at</option>
                    <option value="ax"<?
                    if (@$obj->_simbolos == "ax"):echo 'selected';
                    endif;
                    ?>>ax</option>
                    <option value="bu"<?
                    if (@$obj->_simbolos == "bu"):echo 'selected';
                    endif;
                    ?>>bu</option>
                    <option value="ca"<?
                    if (@$obj->_simbolos == "ca"):echo 'selected';
                    endif;
                    ?>>ca</option>
                    <option value="cg"<?
                    if (@$obj->_simbolos == "cg"):echo 'selected';
                    endif;
                    ?>>cg</option>
                    <option value="cn"<?
                    if (@$obj->_simbolos == "cn"):echo 'selected';
                    endif;
                    ?>>cn</option>
                    <option value="co"<?
                    if (@$obj->_simbolos == "co"):echo 'selected';
                    endif;
                    ?>>co</option>
                    <option value="cp"<?
                    if (@$obj->_simbolos == "cp"):echo 'selected';
                    endif;
                    ?>>cp</option>
                    <option value="cv"<?
                    if (@$obj->_simbolos == "cv"):echo 'selected';
                    endif;
                    ?>>cv</option>
                    <option value="di"<?
                    if (@$obj->_simbolos == "di"):echo 'selected';
                    endif;
                    ?>>di</option>
                    <option value="ef"<?
                    if (@$obj->_simbolos == "ef"):echo 'selected';
                    endif;
                    ?>>ef</option>
                    <option value="em"<?
                    if (@$obj->_simbolos == "em"):echo 'selected';
                    endif;
                    ?>>em</option>
                    <option value="es"<?
                    if (@$obj->_simbolos == "es"):echo 'selected';
                    endif;
                    ?>>es</option>
                    <option value="fr"<?
                    if (@$obj->_simbolos == "fr"):echo 'selected';
                    endif;
                    ?>>fr</option>
                    <option value="hi"<?
                    if (@$obj->_simbolos == "hi"):echo 'selected';
                    endif;
                    ?>>hi</option>
                    <option value="ho"<?
                    if (@$obj->_simbolos == "ho"):echo 'selected';
                    endif;
                    ?>>ho</option>
                    <option value="id"<?
                    if (@$obj->_simbolos == "id"):echo 'selected';
                    endif;
                    ?>>id</option>
                    <option value="ih"<?
                    if (@$obj->_simbolos == "ih"):echo 'selected';
                    endif;
                    ?>>ih</option>
                    <option value="kl"<?
                    if (@$obj->_simbolos == "kl"):echo 'selected';
                    endif;
                    ?>>kl</option>
                    <option value="me"<?
                    if (@$obj->_simbolos == "me"):echo 'selected';
                    endif;
                    ?>>me</option>
                    <option value="pa"<?
                    if (@$obj->_simbolos == "pa"):echo 'selected';
                    endif;
                    ?>>pa</option>
                    <option value="pb"<?
                    if (@$obj->_simbolos == "pb"):echo 'selected';
                    endif;
                    ?>>pb</option>
                    <option value="pi"<?
                    if (@$obj->_simbolos == "pi"):echo 'selected';
                    endif;
                    ?>>pi</option>
                    <option value="px"<?
                    if (@$obj->_simbolos == "px"):echo 'selected';
                    endif;
                    ?>>px</option>
                    <option value="ra"<?
                    if (@$obj->_simbolos == "ra"):echo 'selected';
                    endif;
                    ?>>ra</option>
                    <option value="rp"<?
                    if (@$obj->_simbolos == "rp"):echo 'selected';
                    endif;
                    ?>>rp</option>
                    <option value="tb"<?
                    if (@$obj->_simbolos == "tb"):echo 'selected';
                    endif;
                    ?>>tb</option>
                    <option value="od"<?
                    if (@$obj->_simbolos == "od"):echo 'selected';
                    endif;
                    ?>>od</option>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>4C</legend>
            <div>
            <div>
                <label>Coment&aacute;rio</label>
                <input type="text"  id="comentario_4c" name="comentario_4c" class="size13"  value="<?= @$obj->_comentario_4c; ?>" />
            </div>
            </div>
        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
    </form>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
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

    $(document).ready(function() {
        jQuery('#form_paciente').validate({
            rules: {
                nome: {
                    required: true,
                    minlength: 3
                },
                telefone: {
                    required: true
                },
                nascimento: {
                    required: true
                }

            },
            messages: {
                nome: {
                    required: "*",
                    minlength: "*"
                },
                telefone: {
                    required: "*"
                },
                nascimento: {
                    required: "*"
                }
            }
        });
    });

    $(function() {
        $("#txtcbo").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=cboprofissionais",
            minLength: 3,
            focus: function(event, ui) {
                $("#txtcbo").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtcbo").val(ui.item.value);
                $("#txtcboID").val(ui.item.id);
                return false;
            }
        });
    });

    $(function() {
        $("#txtCidade").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function(event, ui) {
                $("#txtCidade").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtCidade").val(ui.item.value);
                $("#txtCidadeID").val(ui.item.id);
                return false;
            }
        });
    });
    $(function() {
        $("#txtEstado").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=estado",
            minLength: 2,
            focus: function(event, ui) {
                $("#txtEstado").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtEstado").val(ui.item.value);
                $("#txtEstadoID").val(ui.item.id);
                return false;
            }
        });
    });




</script>