<div class="content"> <!-- Inicio da DIV content -->
<!--    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/agenda">
            Voltar
        </a>
    </div>-->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastrar Horario em Agendas Criadas</a></h3>
        <div>
            <fieldset>
                <form name="form_horarioagenda" id="form_horarioagenda" action="<?= base_url() ?>ambulatorio/agenda/gravarhorarioagendacriada/<?= $agenda_id; ?>" method="post">

                    <dl class="dl_desconto_lista">
                        <dd>
                            <input type="hidden" id="agenda_id" name="agenda_id" value="<?= $agenda_id; ?>" />
                            <input type="hidden" id="medico_id" name="medico_id" value="<?= $_GET['medico_id']; ?>" />
                            <input type="hidden" id="nome_agenda" name="nome_agenda" value="<?= $_GET['nome']; ?>" />
                        </dd>
                    </dl> 
                    <table class="table" id="tabela-agenda">
                        <tr>
                            <th>Dia</th>
                            <th>Inicio</th>
                            <th>Fim</th>
                            <th>Inicio intervalo</th>
                            <th>Fim do intervalo</th>
                            <th>Tempo Consulta</th>
                            <th>QTDE Consulta</th>
                            <th>Sala</th>
                            <th>Empresa</th>
                            <!--<th>Ações</th>-->

                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[1]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <option value="1 - Segunda">1 - Segunda</option>
                                    <!--                                <option value="2 - Terça">2 - Terça</option>
                                                                    <option value="3 - Quarta">3 - Quarta</option>
                                                                    <option value="4 - Quinta">4 - Quinta</option>
                                                                    <option value="5 - Sexta">5 - Sexta</option>
                                                                    <option value="6 - Sabado">6 - Sabado</option>
                                                                    <option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text' id="txthoraEntrada1" name="txthoraEntrada[1]" alt='time' class='size1 hora' /></td>
                            <td><input type='text' id='txthoraSaida1' name="txthoraSaida[1]" alt='time' class='size1 hora' /></td>
                            <td><input type='text' id="txtIniciointervalo1" name="txtIniciointervalo[1]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text' id="txtFimintervalo1" name="txtFimintervalo[1]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text' id="txtTempoconsulta1" name="txtTempoconsulta[1]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text' id="txtQtdeconsulta1" name="txtQtdeconsulta[1]" value='0' class='size1' /></td>
                            <td>                
                                <select name='sala[1]' id="sala1" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($salas as $row) : ?>
                                        <option value="<?= $row->exame_sala_id ?>">
                                            <?= $row->nome ?>
                                        </option> 
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                
                                <select name='empresa[1]' id="empresa1" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[2]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <option value="2 - Terça">2 - Terça</option>
                                    <!--                                <option value="3 - Quarta">3 - Quarta</option>
                                                                    <option value="4 - Quinta">4 - Quinta</option>
                                                                    <option value="5 - Sexta">5 - Sexta</option>
                                                                    <option value="6 - Sabado">6 - Sabado</option>
                                                                    <option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada2" name="txthoraEntrada[2]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida2' name="txthoraSaida[2]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo2" name="txtIniciointervalo[2]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo2" name="txtFimintervalo[2]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta2" name="txtTempoconsulta[2]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta2" name="txtQtdeconsulta[2]" value='0' class='size1' /></td>
                            <td>                
                                <select name='sala[2]' id="sala2" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($salas as $row) : ?>
                                        <option value="<?= $row->exame_sala_id ?>">
                                            <?= $row->nome ?>
                                        </option> 
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                
                                <select name='empresa[2]' id="empresa2" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[3]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <!--<option value="2 - Terça">2 - Terça</option>-->
                                    <option value="3 - Quarta">3 - Quarta</option>
                                    <!--                                <option value="4 - Quinta">4 - Quinta</option>
                                                                    <option value="5 - Sexta">5 - Sexta</option>
                                                                    <option value="6 - Sabado">6 - Sabado</option>
                                                                    <option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada3" name="txthoraEntrada[3]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida3' name="txthoraSaida[3]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo3" name="txtIniciointervalo[3]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo3" name="txtFimintervalo[3]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta3" name="txtTempoconsulta[3]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta3" name="txtQtdeconsulta[3]" value='0' class='size1' /></td>
                            <td>                
                                <select name='sala[3]' id="sala3" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($salas as $row) : ?>
                                        <option value="<?= $row->exame_sala_id ?>">
                                            <?= $row->nome ?>
                                        </option> 
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                
                                <select name='empresa[3]' id="empresa3" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[4]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <!--<option value="2 - Terça">2 - Terça</option>-->
                                    <!--<option value="3 - Quarta">3 - Quarta</option>-->
                                    <option value="4 - Quinta">4 - Quinta</option>
                                    <!--<option value="5 - Sexta">5 - Sexta</option>-->
                                    <!--<option value="6 - Sabado">6 - Sabado</option>-->
                                    <!--<option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada4" name="txthoraEntrada[4]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida4' name="txthoraSaida[4]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo4" name="txtIniciointervalo[4]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo4" name="txtFimintervalo[4]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta4" name="txtTempoconsulta[4]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta4" name="txtQtdeconsulta[4]" value='0' class='size1' /></td>
                            <td>                
                                <select name='sala[4]' id="sala4" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($salas as $row) : ?>
                                        <option value="<?= $row->exame_sala_id ?>">
                                            <?= $row->nome ?>
                                        </option> 
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                
                                <select name='empresa[4]' id="empresa4" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[5]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <!--<option value="2 - Terça">2 - Terça</option>-->
                                    <!--<option value="3 - Quarta">3 - Quarta</option>-->
                                    <!--<option value="4 - Quinta">4 - Quinta</option>-->
                                    <option value="5 - Sexta">5 - Sexta</option>
                                    <!--<option value="6 - Sabado">6 - Sabado</option>-->
                                    <!--<option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada5" name="txthoraEntrada[5]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida5' name="txthoraSaida[5]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo5" name="txtIniciointervalo[5]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo5" name="txtFimintervalo[5]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta5" name="txtTempoconsulta[5]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta5" name="txtQtdeconsulta[5]" value='0' class='size1' /></td>
                            <td>                
                                <select name='sala[5]' id="sala5" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($salas as $row) : ?>
                                        <option value="<?= $row->exame_sala_id ?>">
                                            <?= $row->nome ?>
                                        </option> 
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                
                                <select name='empresa[5]' id="empresa5" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[6]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--<option value="1 - Segunda">1 - Segunda</option>-->
                                    <!--<option value="2 - Terça">2 - Terça</option>-->
                                    <!--<option value="3 - Quarta">3 - Quarta</option>-->
                                    <!--<option value="4 - Quinta">4 - Quinta</option>-->
                                    <!--<option value="5 - Sexta">5 - Sexta</option>-->
                                    <option value="6 - Sabado">6 - Sabado</option>
                                    <!--<option value="7 - Domingo">7 - Domingo</option>-->
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada6" name="txthoraEntrada[6]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida6' name="txthoraSaida[6]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo6" name="txtIniciointervalo[6]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo6" name="txtFimintervalo[6]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta6" name="txtTempoconsulta[6]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta6" name="txtQtdeconsulta[6]" value='0' class='size1' /></td>
                            <td>                
                                <select name='sala[6]' id="sala6" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($salas as $row) : ?>
                                        <option value="<?= $row->exame_sala_id ?>">
                                            <?= $row->nome ?>
                                        </option> 
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                
                                <select name='empresa[6]' id="empresa6" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>
                        <tr>
                            <td>                
                                <select name="txtDia[7]" id="txtData" class='size1' >
                                    <!--<option value=""></option>-->
                                    <!--                                <option value="1 - Segunda">1 - Segunda</option>
                                                                    <option value="2 - Terça">2 - Terça</option>
                                                                    <option value="3 - Quarta">3 - Quarta</option>
                                                                    <option value="4 - Quinta">4 - Quinta</option>
                                                                    <option value="5 - Sexta">5 - Sexta</option>
                                                                    <option value="6 - Sabado">6 - Sabado</option>-->
                                    <option value="7 - Domingo">7 - Domingo</option>
                                </select>
                            </td>
                            <td><input type='text'  id="txthoraEntrada7" name="txthoraEntrada[7]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id='txthoraSaida7' name="txthoraSaida[7]" alt='time' class='size1 hora' /></td>
                            <td><input type='text'  id="txtIniciointervalo7" name="txtIniciointervalo[7]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtFimintervalo7" name="txtFimintervalo[7]" alt='time' value='00:00' class='size1 hora' /></td>
                            <td><input type='text'  id="txtTempoconsulta7" name="txtTempoconsulta[7]" class='size1' data-container="body" data-toggle="popover" data-placement="left" data-content="Digite o tempo de consulta em minutos. Não digite letras, por favor. (Clique novamente no campo para sumir esta mensagem)" /></td>
                            <td><input type='text'  id="txtQtdeconsulta7" name="txtQtdeconsulta[7]" value='0' class='size1' /></td>
                            <td>                
                                <select name='sala[7]' id="sala7" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($salas as $row) : ?>
                                        <option value="<?= $row->exame_sala_id ?>">
                                            <?= $row->nome ?>
                                        </option> 
                                    <? endforeach; ?>
                                </select>
                            </td>
                            <td>                
                                <select name='empresa[7]' id="empresa7" class='size2' >
                                    <option value="" ></option>
                                    <? foreach ($empresas as $row) : ?>
                                        <option value="<?= $row->empresa_id ?>"
                                        <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                        ?>><?= $row->nome ?></option> 
                                            <? endforeach; ?>
                                </select>
                            </td>


                        </tr>

                    </table>
                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                    <button type="reset" name="btnLimpar">Limpar</button>
                    <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
                </form>

            </fieldset>
            <br>
            <?
            if (count($horarios) > 0) {
                ?>
                <br>
                <fieldset>
                    <table id="table_agente_toxico" border="0">
                            <thead>
                                <tr>
                                    <th class="tabela_header">Data</th>
                                    <th class="tabela_header">Entrada 1</th>
                                    <th class="tabela_header">Sa&iacute;da 1</th>
                                    <th class="tabela_header">Inicio intervalo</th>
                                    <th class="tabela_header">Fim do intervalo</th>
                                    <th class="tabela_header">Tempo consulta</th>
                                    <!--<th class="tabela_header">Obs</th>-->
                                    <th class="tabela_header">Sala</th>
                                    <th class="tabela_header">Empresa</th>
                                    <th class="tabela_header">&nbsp;</th>
                                </tr>
                            </thead>
                            <?
                            $estilo_linha = "tabela_content01";
                            foreach ($horarios as $item) {
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                                ?>
                                <tbody>
                                    <tr>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->dia; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->horaentrada1; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->horasaida1; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->intervaloinicio; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->intervalofim; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->tempoconsulta; ?></td>
                                        <!--<td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>-->
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->sala; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                            <a target="_blank" href="<?= base_url() ?>ambulatorio/agenda/excluirhorarioagendaeditada/<?= $item->horarioagenda_editada_id ?>">
                                                <img border="0" title="Excluir" alt="Excluir"
                                                     src="<?= base_url() ?>img/form/page_white_delete.png" />
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                                <?
                            }
                        ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="4">
                                </th>
                            </tr>
                        </tfoot>
                    </table> 
                </fieldset>
                <br>
                <table>
                    <tr>
                        <td>
                            <div class="bt_link_new">
                                <form method="get" name="consolidarnovoshorarios" action="<?php echo base_url() ?>ambulatorio/exame/gravaralteracaoagendacriada">
                                    <input type="hidden" id="agenda_id" name="agenda_id" value="<?= $agenda_id; ?>" />
                                    <input type="hidden" id="medico_id" name="medico_id" value="<?= $_GET['medico_id']; ?>" />
                                    <input type="hidden" id="nome_agenda" name="nome_agenda" value="<?= $_GET['nome']; ?>" />
                                    <a onclick="document.consolidarnovoshorarios.submit()">
                                        Consolidar Horarios
                                    </a>
                                </form>
                            </div>
                        </td>
                    </tr>
                </table>
            <? }  ?>
        </div>
        
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
     <? for($i = 1; $i <= 100; $i++){ ?>
        $('#txthoraEntrada<?= $i ?>').blur(function () {
            if ($(this).val() != '') {
                $("#txthoraSaida<?= $i ?>").prop('required', true);
                $("#txtIniciointervalo<?= $i ?>").prop('required', true);
                $("#txtFimintervalo<?= $i ?>").prop('required', true);
                $("#empresa<?= $i ?>").prop('required', true);
                $("#sala<?= $i ?>").prop('required', true);
                $("#txtTempoconsulta<?= $i ?>").prop('required', true);
    //            $("#txtQtdeconsulta<?= $i ?>").prop('required', true);
            } else {
                $("#txthoraSaida<?= $i ?>").prop('required', false);
                $("#txtIniciointervalo<?= $i ?>").prop('required', false);
                $("#txtFimintervalo<?= $i ?>").prop('required', false);
                $("#empresa<?= $i ?>").prop('required', false);
                $("#sala<?= $i ?>").prop('required', false);
                $("#txtTempoconsulta<?= $i ?>").prop('required', false);
    //            $("#txtQtdeconsulta<?= $i ?>").prop('required', false);
            }        

            $('#txtTempoconsulta<?= $i ?>').blur(function () {
                if ($(this).val() != '') {
                    $("#txtQtdeconsulta<?= $i ?>").prop('readonly', true);
                } else {
                    $("#txtQtdeconsulta<?= $i ?>").prop('readonly', false);
                }
            });

            $('#txtQtdeconsulta<?= $i ?>').blur(function () {
                if ($(this).val() > 0) {
                    $("#txtTempoconsulta<?= $i ?>").prop('readonly', true);
                } else {
                    $("#txtTempoconsulta<?= $i ?>").prop('readonly', false);
                }
            });
        });
    <? } ?>



    $(function () {
        $("#accordion").accordion();
    });


</script>