<div class="content ficha_ceatox">
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ceatox/ceatox">
            Voltar
        </a>
    </div>
    <div class="clear"></div>
    <h3 class="h3_title">Ficha de Notificação e de Atendimento</h3>

    <form name="ficha_form" id="ficha_form" action="<?= base_url() ?>ceatox/ceatox/gravar/" method="POST">
        <input type ="hidden" name ="fichaId" value ="<?= @$obj->_ficha_id ?>">
        <input type ="hidden" name ="acao" value ="<?= $acao ?>">
        <fieldset>
            <legend>Dados da Ficha</legend>
            <div>
                <label>N°. Ficha</label>
                <? if ($chave == 0) {
 ?>
                    <input type="text" id="n_ficha" readonly ="true" name="n_ficha" value ="<?= $valor ?>" class="size1" alt="numeromask" />
<? } else { ?>
                    <input type="text" id="n_ficha" readonly ="true" name="n_ficha" value ="<?= @$obj->valor ?>" class="size1" alt="numeromask" />
<? } ?>
            </div>
            <div>
                <label>Centro</label>
                <select name="centro_ficha" class="size1">
<? foreach ($listaCentro as $item) : ?>
                    <option value="<?= $item->centro_id; ?>"><?= $item->nome; ?></option>
<? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" value="<?php echo substr(@$obj->_data, 8, 2) . '/' . substr(@$obj->_data, 5, 2) . '/' . substr(@$obj->_data, 0, 4); ?>" class="size1"  />
            </div>
            <div>
                <label>Hora</label>
                <input type="text" name="hora_ficha" class="size1" value ="<?= @$obj->_hora; ?>" alt="time"  />
            </div>
            <div>
                <label>Vítima</label>
                <select id="tipo_vitima" name="tipo_vitima">
                    <option value="1">Humana</option>
                    <option value="2">Animal</option>
                    <option value="3">Informação</option>
                </select>
            </div>
        </fieldset>

        <fieldset>
            <legend>Dados do Paciente</legend>
            <input type="hidden" name="id_paciente" value ="<?= @$obj->_paciente_id; ?>" />

            <div>
                <label>Paciente</label>

                <input type="text" id="nome_paciente" name="nome_paciente" value ="<?= @$obj->_nomePaciente; ?>" class="size4 bestupper" />
            </div>

            <div>
                <label>Nº Registro de Atendimento</label>
                <input type="text" id="num_atendimento" name="num_atendimento" class="size2 bestupper" value ="<?= @$obj->_numero_registro; ?>" alt="numeromask" />
            </div>
            <div>

                <label>Idade</label>
                <input type="text" id="idade" name="idade" value ="<?= @$obj->_idadePaciente; ?>" class="size1 bestupper"  />
                <select name="idadeTipo" id="idadeTipo"  class="size2">
                    <option value="A" <? if (@$obj->_idadeTipoPaciente == 'A'):echo 'selected';
                    endif; ?>>Anos</option>
                    <option value="H" <? if (@$obj->_idadeTipoPaciente == 'H'):echo 'selected';
                    endif; ?>>Hora</option>
                    <option value="D" <? if (@$obj->_idadeTipoPaciente == 'D'):echo 'selected';
                    endif; ?>>Dia</option>
                    <option value="M" <? if (@$obj->_idadeTipoPaciente == 'M'):echo 'selected';
                    endif; ?>>M&ecirc;s</option>
                </select>
            </div>
            <div>

                <label>Sexo</label>
                <select name="sexo_paciente" id="sexo_paciente" value ="<?= @$obj->_sexoPaciente; ?>" class="size2">
                    <option value="M" <? if (@$obj->_sexoPaciente == 'M'):echo 'selected';
                    endif; ?> >Masculino</option>
                    <option value="F" <? if (@$obj->_sexoPaciente == 'F'):echo 'selected';
                    endif; ?> >Feminino</option>
                </select>
            </div>
            <div>

                <label>Peso</label>
                <input type="text" id="peso_paciente" name="peso_paciente" alt ="decimal" class="size1" value ="<?= @$obj->_peso; ?>"/>
            </div>
            <div>

                <label>Gestante</label>
                <select name="gestante" id="gestante" class="size1">
                    <option value="1">1° Trimestre</option>
                    <option value="2">2° Trimestre</option>
                    <option value="3">3° Trimestre</option>
                    <option value="4" selected>Não</option>
                    <option value="5">Não se Aplica</option>
                    <option value="6">Ignorado</option>
                </select>
            </div>
            <div>


                <input type="hidden" name="especie" id="especie" class="size2 bestupper" />
            </div>
            <div>

                <label>Profissão/Ocupação</label>
                <input type="text" id="profissao_paciente" name="profissao_paciente" class="size2 bestupper" value ="<?= @$obj->_profissao; ?>"/>
            </div>
            <div>

                <label>Endereço</label>
                <input type="text" name="end_paciente" id="end_paciente" value ="<?= @$obj->_enderecoPaciente; ?>" class="size4 bestupper" />
            </div>
            <div>

                <label>Telefone</label>
                <input type="text"  id="tel_paciente"  class="size2" name="tel_paciente" alt ="phone" value ="<?= @$obj->_telefonePaciente; ?>" />

            </div>
            <div>

                <label>Município</label>
                <input type="text" readonly ="true" name="municipio_id_paciente" id="municipio_id_paciente" value ="<?= @$obj->_municipioIdPaciente; ?>"  class="size1" />
                <input type="text"  name="municipio_paciente" id="municipio_paciente" value ="<?= @$obj->_municipioPaciente; ?>" class="size4 bestupper"  />
            </div>
            <div>
                <label>Bairro</label>
                <input type="text" id="bairro_paciente" name="bairro_paciente" class="size2 bestupper" value ="<?= @$obj->_bairroPaciente; ?>"/>
            </div>
            <div>

                <label>CEP</label>
                <input type="text" name="cep_paciente" id="cep_paciente" class="size2" alt ="cep" value ="<?= @$obj->_cepPaciente; ?>"/>
            </div>
            <div>

                <label>Cartão SUS</label>
                <input type="text" name="sus_paciente" id="sus_paciente" alt="integer" value ="<?= @$obj->_cns; ?>" class="size1"  />
            </div>
            <div>

                <label>Nome da Mae (se menor)</label>
                <input type="text" name="mae_paciente" id="mae_paciente" class="size4 bestupper" value ="<?= @$obj->_nomeMaePaciente; ?>"/>
            </div>

        </fieldset>
        <fieldset>
            <legend>Identifica&ccedil;&atilde;o do Solicitante</legend>

            <div>
                <input type="hidden" name="temp_solicitante_id" value ="<?= @$obj->_temp_solicitante_id; ?>"/>
                <label>Nome do Solicitante</label>
                <input type="text" name="nome_solicitante" id="nome_solicitante" value ="<?= @$obj->_nomeSolicitante; ?>" class="size4 bestupper" />
            </div>
            <div>
                <label>Endere&ccedil;o</label>
                <input type="text"  name="end_solicitante" id="end_solicitante" value ="<?= @$obj->_enderecoSolicitante; ?>" class="size4 bestupper" />
            </div>
            <div>
                <label>Bairro</label>
                <input type="text" name="bairro_solicitante" id="bairro_solicitante" value ="<?= @$obj->_bairroSolicitante; ?>" class="size2 bestupper" />
            </div>
            <div>
                <label>Munic&iacute;pio</label>
                <input type="text"  name="municipio_id_solicitante" readonly ="true" id="municipio_id_solicitante" value ="<?= @$obj->_municipioIdSolicitante; ?>" class="size1" />
                <input type="text"  name="municipio_solicitante" id="municipio_solicitante" class="size4"  value ="<?= @$obj->_municipioSolicitante; ?>"/>
            </div>
            <div>
                <label>Institui&ccedil;&atilde;o</label>
                <input type="text" name="instituicao_solicitante" id="instituicao_solicitante" class="size2 bestupper" value ="<?= @$obj->_instituicao; ?>" />
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="tel_solicitante" class="size2"  value ="<?= @$obj->_telefoneSolicitante; ?>" name="tel_solicitante" alt="phone" />

            </div>
            <div>
                <label>Ramal</label>
                <input type="text" name="ramal_tel_solicitante" alt="integer" id="ramal_tel_solicitante" class="size1" value ="<?= @$obj->_ramalSolicitante; ?>"/>
            </div>
            <div>
                <label>Categoria</label>
                <select name="categoria" id="categoria" class="size2">
                    <option value="1" <? if (@$obj->_categoria == 1):echo 'selected';
                    endif; ?>>Próprio</option>
                    <option value="2" <? if (@$obj->_categoria == 2):echo 'selected';
                    endif; ?>>Médico</option>
                    <option value="3" <? if (@$obj->_categoria == 3):echo 'selected';
                    endif; ?>>Parente</option>
                    <option value="4" <? if (@$obj->_categoria == 4):echo 'selected';
                    endif; ?>>Veterinário</option>
                    <option value="5" <? if (@$obj->_categoria == 5):echo 'selected';
                    endif; ?>>Outro Prof. Saúde</option>
                    <option value="6" <? if (@$obj->_categoria == 6):echo 'selected';
                    endif; ?>>Outro</option>
                </select>

                <span class="espec categoria_desc">Especifique</span>
                <input type="text" name="categoria_desc_solicitante" id="categoria_desc" class="size2 bestupper espec" />
            </div>

        </fieldset>
        <fieldset>
            <legend>Atendimento</legend>

            <div>
                <label>Atendimento</label>
                <select name="atendimento" id="atendimento" class="size2">
                    <option value="-1">Selecione</option>
                    <optgroup label="Telefônico">
<? foreach ($listaTelefonico as $item) : ?>
                        <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_atendimento == $item->gruporesposta_id):echo 'selected';
                        endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                    </optgroup>
                    <optgroup label="Hospitalar">
                    <? foreach ($listaHospitalar as $item) : ?>
                                <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_atendimento == $item->gruporesposta_id):echo 'selected';
                            endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                            </optgroup>
                        </select>
                        <span class="espec atendimento_desc">Especifique</span>
                        <input type="text" name="atendimento_desc" id="atendimento_desc" class="size1 bestupper espec" />
                    </div>
                    <div>
                        <label>Tipo de Ocorrência</label>
                        <select name="tipo_ocorrencia" id="tipo_ocorrencia" class="size2">
                            <option value="-1">Selecione</option>
<? foreach ($listaTipoOcorrencia as $item) : ?>
                                <option value="<?= $item->gruporesposta_id; ?>"<? if (@$obj->_ocorrencia == $item->gruporesposta_id):echo 'selected';
                                endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                            </select>
                            <span class="espec tipo_ocorrencia_desc">Especifique</span>
                            <input type="text" name="tipo_ocorrencia_desc" id="tipo_ocorrencia_desc" class="size1 bestupper espec" />
                        </div>
                        <div>
                            <label>Circunstância</label>

                            <select name="circunstancia" id="circunstancia" class="size2">
                                <option value="-1">Selecione</option>
                    <? foreach ($listaCircunstancia as $item) : ?>
                                    <option value="<?= $item->gruporesposta_id; ?>"<? if (@$obj->_circunstancia == $item->gruporesposta_id):echo 'selected';
                                    endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                                </select>
                                <span class="espec circunstancia_desc">Especifique</span>
                                <input type="text" name="circunstancia_ocorrencia_desc" id="circunstancia_desc" class="size1 bestupper espec" />
                            </div>

                        </fieldset>
                        <fieldset>
                            <legend>Exposição</legend>

                            <div>
                                <label>Zona</label>
                                <select name="zona" id="zona" class="size1">
                                    <option value="-1">Selecione</option>
<? foreach ($listaZona as $item) : ?>
                                        <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_zona == $item->gruporesposta_id):echo 'selected';
                                        endif; ?>><?= $item->descricao; ?></option>
                    <? endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label>Local</label>
                                    <select name="local" id="local" class="size2">
                                        <option value="-1">Selecione</option>
<? foreach ($listaLocal as $item) : ?>
                                            <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_local == $item->gruporesposta_id):echo 'selected';
                                            endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                                        </select>
                                        <span class="espec local_desc">Especifique</span>
                                        <input type="text" name="local_desc" id="local_desc" class="size1 bestupper espec" />
                                    </div>
                                    <div>
                                        <label>Via</label>
                                        <select name="via" id="via" class="size2">
                                            <option value="-1">Selecione</option>
<? foreach ($listaVia as $item) : ?>
                                                <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_via == $item->gruporesposta_id):echo 'selected';
                                                endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                                            </select>
                                            <span class="espec local_desc">Especifique</span>
                                            <input type="text" name="via_desc" id="via_desc" class="size1 bestupper espec" />
                                        </div>
                                        <div>
                                            <label>Tipo</label>
                                            <select name="tipo_exposicao" id="tipo_exposicao" class="size2">
                                                <option value="-1">Selecione</option>
<?php foreach ($listaTipo as $item) : ?>
                                                    <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_tipo == $item->gruporesposta_id):echo 'selected';
                                                    endif; ?>><?= $item->descricao; ?></option>
<?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div>
                                                <label>Tempo decorrido da exposição</label>
                                                <input type="text" name="tempo_decor_exp" id="tempo_decor_exp" alt="integer" value ="<?= @$obj->_tempo_valor; ?>" class="size2"/>
                                                <select name="tempo_decor_exp_metrica">
                                                    <option <? if (@$obj->_tempo_metrica == "m"):echo 'selected';
                                                    endif; ?> value="m" selected>Minutos</option>
                                                    <option <? if (@$obj->_tempo_metrica == "h"):echo 'selected';
                                                    endif; ?> value="h">Horas</option>
                                                    <option <? if (@$obj->_tempo_metrica == "d"):echo 'selected';
                                                    endif; ?> value="d">Dias</option>
                                                            <option <? if (@$obj->_tempo_metrica == "me"):echo 'selected';
                                                    endif; ?> value="me">Meses</option>
                                                            <option <? if (@$obj->_tempo_metrica == "a"):echo 'selected';
                                                    endif; ?> value="a">Anos</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label>Duração da exposição</label>
                                                        <input type="text" name="duracao_exp" id="duracao_exp" alt="integer" value ="<?= @$obj->_duracao_valor; ?>" class="size2" />
                                                        <select name="duracao_exp_metrica">
                                                            <option <? if (@$obj->_duracao_metrica == "s"):echo 'selected';
                                                    endif; ?> value="s">Segundos</option>
                                                    <option <? if (@$obj->_duracao_metrica == "m"):echo 'selected';
                                                    endif; ?> value="m" selected>Minutos</option>
                                                    <option <? if (@$obj->_duracao_metrica == "h"):echo 'selected';
                                                    endif; ?> value="h">Horas</option>
                                                    <option <? if (@$obj->_duracao_metrica == "d"):echo 'selected';
                                                    endif; ?> value="d">Dias</option>
                                                    <option <? if (@$obj->_duracao_metrica == "me"):echo 'selected';
                                                    endif; ?> value="me">Meses</option>
                                                    <option <? if (@$obj->_duracao_metrica == "a"):echo 'selected';
                                                    endif; ?> value="a">Anos</option>
                                                </select>
                                            </div>

                                        </fieldset>

                                        <fieldset>
                                            <legend>Agente T&oacute;xico</legend>

                                            <!-- Início da tabela de Agente Tóxico -->
<? if ($chave2 == 1) { ?>
                                                        <table >
                                                            <thead>
                                                                <tr>
                                                                    <td>Agente Tóxico</td>
                                                                    <td>Nome Comercial/Espécie</td>
                                                                    <td>Dose/Quant</td>
                                                                    <td>Classificação</td>
                                                                    <td>Clandestino</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
<?php
                                                        foreach ($lista as $item) {
?>
                                                                    <tr >
                                                                        <td><?= $item->descricao; ?></td>
                                                                        <td><?= $item->nomecomercial_especie; ?></td>

                                                                        <td><?= $item->dose_quantidade ?></td>
                                                                        <td><?= $item->classificacao ?></td>
                                                                        <td><? if ($item->clandestino == 't') { ?> sim  <? } else { ?> não <? } ?></td>
                                                                    </tr>
<? } ?>
                                                            </tbody>
                                                        </table>
<? } ?>

                                <!-- Início da tabela de Agente Tóxico -->
                                <table id="table_agente_toxico" border="0">
                                    <thead>
                                        <tr>
                                            <td>Agente Tóxico</td>
                                            <td>Nome Comercial/Espécie</td>
                                            <td>Dose/Quant</td>
                                            <td>Classificação</td>
                                            <td>Clandestino</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <div class="bt_link_new mini_bt">
                                                    <a href="#" id="plusAgente">Adicionar Ítem</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <tr class="linha1">
                                            <td>
                                                <select  name="agenteToxico[1]" class="size2" >
                                                    <option value="-1">Selecione</option>
<? foreach ($listaAgenteToxico as $item) : ?>
                                                        <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
            <? endforeach; ?>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text"  name="nomeComercial[1]" class="size2 bestupper" /></td>
                                                                    <td><input type="text" name="dose[1]" class="size1 bestupper" /></td>
                                                                    <td><input type="text" name="classificacao[1]" class="size1 bestupper" /></td>
                                                                    <td>
                                                                        <input type="radio" name="clandestino[1]" value="t" />Sim&nbsp;
                                                                        <input type="radio" name="clandestino[1]" value="f" checked />Não
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="delete">Excluir</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Fim da tabela de Agente Tóxico -->
                                                    </fieldset>

                                                    <fieldset>
                                                        <legend>Tratamento</legend>
                                                        <div class="aux_legenda">
                                                            <ol type="A">
                                                                <li>Tratamento Inicial</li>
                                                                <li>Tratamento Proposto</li>
                                                                <li>Tratamento Realizado</li>
                                                            </ol>
                                                        </div>

<? $i = 1; ?>
<? foreach ($listaTratamentoA as $item) : ?>
<? $tratamentoa = $item->gruporesposta_id; ?>
<? foreach ($listaTratamentoB as $itens) : ?>
<? if ($item->descricao == $itens->descricao): ?>
                    <? $tratamentob = $itens->gruporesposta_id; ?>
<? endif; ?>
                        <? endforeach; ?>
<? foreach ($listaTratamentoC as $itens) : ?>
<? if ($item->descricao == $itens->descricao): ?>
<? $tratamentoc = $itens->gruporesposta_id; ?>
<? endif; ?>
<? endforeach; ?>
<?php
                                                                            $qtd = count($listaTratamentoA);
                                                                            $metade = (($qtd + ($qtd % 2)) / 2);

                                                                            if ($i - 1 == $metade || $i == 1) {

                                                                                if ($i != 0) {
                                                                                    $j = 82;
                                                                                    echo "<tfoot></tfoot>";
                                                                                    echo "</table>";
                                                                                }
?>

                                                                        <table border="0" class="ceatox_ficha_table ceatox_ficha_table_tratamento">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td class="tdList">A</td>
                                                                                    <td class="tdList">B</td>
                                                                                    <td class="tdList">C</td>
                                                                                    <td class="tratamento_descrição">Descrição</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
<? } ?>
                                                                            <tr>
<? $i++ ?>

                                                                                <td><input type="checkbox" <? if (@$obj->_tratamento["tratamentoinicial" . ($i)] != null):echo 'checked';
                                                                            endif; ?>  name="tratamentoa<?= $i ?>" value="<?= $tratamentoa; ?>" /></td>
                                                                                <td><input type="checkbox" <? if (@$obj->_tratamento["tratamentoproposto" . ($i)] != null):echo 'checked';
                                                                            endif; ?>  name="tratamentob<?= $i ?>" value="<?= $tratamentob; ?>" /></td>
                                                                                <td><input type="checkbox" <? if (@$obj->_tratamento["tratamentorealizado" . ($i)] != null):echo 'checked';
                                                                            endif; ?>  name="tratamentoc<?= $i ?>" value="<?= $tratamentoc; ?>" /></td>
                                                                                <td><?= $item->descricao; ?></td>

                                                                            </tr>
<? endforeach; ?>
                                                                        <input type="hidden" name="variavel" value="<?= $i ?>" />                                                       </tbody>
                                                                        <tfoot></tfoot>
                                                                    </table>

                                                                </fieldset>

                                                                <fieldset>
                                                                    <legend>Resumo</legend>
                                                                    <div>
                                                                        <label>Manifestação Clínica</label>
                                                                        <select name="manif_clinica" id="manif_clinica" class="size2">
                                                                            <option value="-1">Selecione</option>
<? foreach ($listaManifClinica as $item) : ?>
                                                                                <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_manifestacao == $item->gruporesposta_id):echo 'selected';
                                                                                endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                                                                            </select>
                                                                        </div>


                                                                        <div>
                                                                            <label>Internação</label>
                                                                            <select name="internacao" id="internacao"  class="size2">
                                                                                <option value="-1">Selecione</option>
<? foreach ($listaInternacao as $item) : ?>
                                                                                    <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_internacao == $item->gruporesposta_id):echo 'selected';
                                                                                    endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div>
                                                                                <label>Análise Toxicológica</label>
                                                                                <select name="toxicologica" id="toxicologica" class="size2">
                                                                                    <option value="-1">Selecione</option>
<? foreach ($listaAnaliseToxicologica as $item) : ?>
                                                                                            <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_toxicologia == $item->gruporesposta_id):echo 'selected';
                                                                                        endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                                                                                        </select>
                                                                                        <span class="espec toxicologica_desc">Especificar</span>
                                                                                        <input type="text" name="toxicologica_desc" id="toxicologica_desc" class="espec bestupper size1" />
                                                                                    </div>
                                                                                    <div>
                                                                                        <label>Evolu&ccedil;&atilde;o</label>
                                                                                        <select name="evolucao" id="evolucao" class="size2">
                                                                                            <option value="-1">Selecione</option>
<? foreach ($listaEvolucao as $item) : ?>
                                                                                                <option value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_evolucao == $item->gruporesposta_id):echo 'selected';
                                                                                            endif; ?>><?= $item->descricao; ?></option>
<? endforeach; ?>
                                                                                            </select>
                                                                                            <span class="espec evolucao_desc">Especificar</span>
                                                                                            <input type="text" name="evolucao_desc" id="evolucao_desc" class="espec bestupper size1" />
                                                                                        </div>                                                                            

                                                                                        <div>
                                                                                            <label>Diagnóstico Definitivo</label>
                                                                                            <input type="texto" name="diag_defin" id="diag_defin" class="size2 bestupper" value="<?= @$obj->_diagnostico_definitivo; ?>"/>
                                                                                        </div>
                                                                                        <div>
                                                                                            <label>C.I.D. 10:</label>
                                                                                            <input type="texto" readonly name="cid" id="cid" class="size1" value="<?= @$obj->_cid; ?>"/>
                                                                                            <input type="texto" name="cidLabel" id="cidLabel" class="size3 bestupper"/>
                                                                                        </div>
                                                                                    </fieldset>
                                                                                    <fieldset>
                                                                                        <legend>Avaliação</legend>
                                                                                        <div class="radio_colums">
<? foreach ($listaAvaliacao as $item) : ?>
                                                                                                <div><input type="radio" name="aval" value="<?= $item->gruporesposta_id; ?>" <? if (@$obj->_avaliacao == $item->gruporesposta_id):echo 'checked';
                                                                                                endif; ?>/><label for="aval_1"><?= $item->descricao; ?></label></div>
<? endforeach; ?>
                                                                                            </div>
                                                                                        </fieldset>
                                                                                        <hr />
                                                                                        <button type="submit" name="btnEnviar">Enviar</button>
                                                                                        <button type="reset" name="btnLimpar">Limpar</button>
                                                                                    </form>
                                                                                </div>
                                                                                <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
                                                                                <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
                                                                                <script type="text/javascript">
                                                                                    $(function() {
                                                                                        $( "#data_ficha" ).datepicker({
                                                                                            autosize: true,
                                                                                            changeYear: true,
                                                                                            changeMonth: true,
                                                                                            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                                                                                            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                                                                            buttonImage: '<?= base_url() ?>img/form/date.png',
                                                                                            dateFormat: 'dd/mm/yy'
                                                                                        });
                                                                                    });


                                                                                    var idlinha=2;
                                                                                    var classe = 2;

                                                                                    $(document).ready(function(){

                                                                                        $('#plusAgente').click(function(){
                                                                                            //



                                                                                            var linha = "<tr class='linha"+classe+"'>";
                                                                                            linha += "<td>";
                                                                                            linha += "<select  name='agenteToxico["+idlinha+"]' class='size2'>";
                                                                                            linha += "<option value='-1'>Selecione</option>";

<?
                                                                                                foreach ($listaAgenteToxico as $item) {
                                                                                                    echo 'linha += "<option value=\'' . $item->gruporesposta_id . '\'>' . $item->descricao . '</option>";';
                                                                                                }
?>

                                                                                            linha += "</select>";
                                                                                            linha += "</td>";
                                                                                            linha += "<td><input type='text'  name='nomeComercial["+idlinha+"]'class='size2' /></td>";
                                                                                            linha += "<td><input type='text' name='dose["+idlinha+"]' class='size1' /></td>";
                                                                                            linha += "<td><input type='text' name='classificacao["+idlinha+"]' class='size1' /></td>";
                                                                                            linha += "<td>";
                                                                                            linha += "<input type='radio' name='clandestino["+idlinha+"]' value='t' />Sim &nbsp;";
                                                                                            linha += "<input type='radio' name='clandestino["+idlinha+"]' value='f' checked />Não";
                                                                                            linha += "</td>";
                                                                                            linha += "<td>";
                                                                                            linha += "<a href='#' class='delete'>Excluir</a>";
                                                                                            linha += "</td>";
                                                                                            linha += "</tr>";

                                                                                            idlinha++;
                                                                                            classe = (classe == 1) ? 2 : 1;
                                                                                            $('#table_agente_toxico').append(linha);
                                                                                            addRemove();
                                                                                            return false;
                                                                                        });

                                                                                        $('#plusObs').click(function(){
                                                                                            var linha2 = '';
                                                                                            idlinha2 = 0;
                                                                                            classe2 = 1;

                                                                                            linha2 += '<tr class="classe2"><td>';
                                                                                            linha2 += '<input type="text" name="DataObs['+idlinha2+']" />';
                                                                                            linha2 += '</td><td>';
                                                                                            linha2 += '<input type="text" name="DataObs['+idlinha2+']" />';
                                                                                            linha2 += '</td><td>';
                                                                                            linha2 += '<input type="text" name="DataObs['+idlinha2+']" class="size4" />';
                                                                                            linha2 += '</td><td>';
                                                                                            linha2 += '<a href="#" class="delete">X</a>';
                                                                                            linha2 += '</td></tr>';

                                                                                            idlinha2++;
                                                                                            classe2 = (classe2 == 1) ? 2 : 1;
                                                                                            $('#table_obsserv').append(linha2);
                                                                                            addRemove();
                                                                                            return false;
                                                                                        });

                                                                                        /*
                                                                                $(function() {
                                                                                            $( "#nome_solicitante" ).autocomplete({
                                                                                                source: "<?= base_url() ?>index?c=autocomplete&m=ceatox1",
                                                                                                minLength: 3,
                                                                                                focus: function( event, ui ) {
                                                                                                    $( "#nome_solicitante" ).val( ui.item.label );
                                                                                                    return false;
                                                                                                },
                                                                                                select: function( event, ui ) {
                                                                                                    $( "#nome_solicitante" ).val( ui.item.value );
                                                                                                    $( "#nome_solicitanteID" ).val( ui.item.id );
                                                                                                    $( "#end_solicitante" ).val( ui.item.endereco );

                                                                                                    $( "#bairro_solicitante" ).val( ui.item.bairro );
                                                                                                    $( "#tel_solicitante" ).val( ui.item.telefone );
                                                                                                    $( "#ramal_tel_solicitante" ).val( ui.item.ramal );
                                                                                                    $( "#instituicao_solicitante" ).val( ui.item.instituicao );
                                                                                                    $( "#municipio_solicitante" ).val( ui.item.municipio );
                                                                                                    $('input:text').setMask();
                                                                                                    return false;
                                                                                                }
                                                                                            });
                                                                                        });
                                                                                         */
                                                                                        //$(function() {
                                                                                        //            $( "#nome_paciente" ).autocomplete({
                                                                                        //                source: "<?= base_url() ?>index?c=autocomplete&m=pacienteceatox",
                                                                                        //                minLength: 3,
                                                                                        //                focus: function( event, ui ) {
                                                                                        //                    $( "#nome_paciente" ).val( ui.item.label );
                                                                                        //                    return false;
                                                                                        //                },
                                                                                        //                select: function( event, ui ) {
                                                                                        //                    $( "#nome_paciente" ).val( ui.item.value );
                                                                                        //                    $( "#nome_pacienteID" ).val( ui.item.id );
                                                                                        //                    $( "#municipio_id_paciente" ).val( ui.item.municipio_id );
                                                                                        //                    $( "#municipio_paciente" ).val( ui.item.municipio );
                                                                                        //                    $( "#idade_data" ).val( ui.item.nascimento );
                                                                                        //                    $( "#idade_ano" ).val( ui.item.idade );
                                                                                        //                    $( "#mae_paciente" ).val( ui.item.mae);
                                                                                        //                    $( "#sexo_paciente" ).val( ui.item.sexo);
                                                                                        //                    $( "#end_paciente" ).val( ui.item.endereco);
                                                                                        //                    $( "#bairro_paciente" ).val( ui.item.bairro);
                                                                                        //                    $( "#cep_paciente" ).val( ui.item.cep);
                                                                                        //                    $( "#tel_paciente" ).val( ui.item.telefone);
                                                                                        //                    $('input:text').setMask();
                                                                                        //                    return false;
                                                                                        //                }
                                                                                        //            });
                                                                                        //        });

                                                                                        $(function() {
                                                                                            $( "#municipio_paciente" ).autocomplete({
                                                                                                source: "<?= base_url() ?>index?c=autocomplete&m=cidade",
                                                                                                minLength: 3,
                                                                                                focus: function( event, ui ) {
                                                                                                    $( "#municipio_paciente" ).val( ui.item.label );
                                                                                                    return false;
                                                                                                },
                                                                                                select: function( event, ui ) {
                                                                                                    $( "#municipio_paciente" ).val( ui.item.value );
                                                                                                    $( "#municipio_id_paciente" ).val( ui.item.id );
                                                                                                    return false;
                                                                                                }
                                                                                            });
                                                                                        });

                                                                                        $(function() {
                                                                                            $( "#municipio_solicitante" ).autocomplete({
                                                                                                source: "<?= base_url() ?>index?c=autocomplete&m=cidade",
                                                                                                minLength: 3,
                                                                                                focus: function( event, ui ) {
                                                                                                    $( "#municipio_solicitante" ).val( ui.item.label );
                                                                                                    return false;
                                                                                                },
                                                                                                select: function( event, ui ) {
                                                                                                    $( "#municipio_solicitante" ).val( ui.item.value );
                                                                                                    $( "#municipio_id_solicitante" ).val( ui.item.id );
                                                                                                    return false;
                                                                                                }
                                                                                            });
                                                                                        });

                                                                                        $(function() {
                                                                                            $( "#cidLabel" ).autocomplete({
                                                                                                source: "<?= base_url() ?>index?c=autocomplete&m=cid10",
                minLength: 3,
                focus: function( event, ui ) {
                    $( "#cidLabel" ).val( ui.item.label );
                    return false;
                },
                select: function( event, ui ) {
                    $( "#cidLabel" ).val( ui.item.value );
                    $( "#cid" ).val( ui.item.id );
                    return false;
                }
            });
        });

        function addRemove() {
            $('.delete').click(function(){
                $(this).parent().parent().remove();
                return false;
            });

        }
    });




</script>