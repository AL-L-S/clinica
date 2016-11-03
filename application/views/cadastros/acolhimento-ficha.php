<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>cadastros/pacientes">
            Voltar
        </a>
    </div>
    <h3 class="h3_title">Ficha de Acolhimento</h3>
    <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/acolhimento/gravar" method="post">
        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Paciente</label>
                <input type="text" id="paciente_id" class="size1" name="paciente_id" value="0" readonly="true" />
                <input type="text" id="paciente" class="size4" name="paciente" />
            </div>
            <div>
                <label>Nascimento</label>
                <input type="text" id="nascimento" class="size2" name="nascimento" readonly="true" />
            </div>
            <div>
                <label>Nome da Mae</label>
                <input type="text" id="nome_mae" class="size4" name="nome_mae"  readonly="true" />
            </div>
        </fieldset>
        <fieldset>
            <legend>Ocorrencias</legend>
            <div>
                <label>Local</label>
                <select name="ocorrencia_local" id="ocorrencia_local" class="size2">
                    <option >Residencia</option>
                    <option >Trabalho</option>
                    <option >Outro</option>
                </select>

                <span class="espec ocorrencia_local_desc">Especifique</span>
                <input type="text" name="ocorrencia_local_desc_especifique" id="ocorrencia_local_desc" class="size2 espec" />
            </div>
            <div>
                <label>Data/hora</label>
                <input type="text" id="ocorrencia_datahora" class="size2" name="ocorrencia_datahora" alt="99-99-9999 99:99:99" />
            </div>
            <div>
                <label>Transporte</label>
                <select name="ocorrencia_transporte" id="ocorrencia_transporte" class="size2">
                    <option value="1">SAMU</option>
                    <option value="2">Carro particular</option>
                    <option value="3">Ambulancia</option>
                    <option value="4">Outro</option>
                </select>

                <span class="espec ocorrencia_transporte_desc">Especifique</span>
                <input type="text" name="ocorrencia_transporte_desc_especifique" id="ocorrencia_transporte_desc" class="size2 espec" />
            </div>
            <div>
                <label>Grau de dependencia da enfermagem</label>
                <select name="ocorrencia_dependencia_enfermagem" id="ocorrencia_dependencia_enfermagem" class="size3">
                    <option value="1">Autonomo</option>
                    <option value="2">Cadeira Rodeira</option>
                    <option value="3">Maca</option>
                </select>
            </div>
            <div>
                <label>Intervencao social</label>

                <label><input type="radio" value="0" name="ocorrencia_intervencao_social" />1-Não</label>
            </div>
            <div>
                <label class="size1">&nbsp;</label>
                <label><input type="radio" value="1" name="ocorrencia_intervencao_social" />2-Sim</label>
            </div>
            <div>
                <label >Veiculo:</label>
                <label>Placa:</label>
                <input type="text" id="ocorrencia_veiculo_placa" class="size2" name="ocorrencia_veiculo_placa"/>
            </div>
            <div>
                <label>Identificacao:</label>
                <input type="text" id="ocorrencia_veiculo_identificacao" class="size2" name="ocorrencia_veiculo_identificacao"/>
            </div>
            <div>
                <label>Condutor:</label>
                <input type="text" id="ocorrencia_veiculo_condutor" class="size2" name="ocorrencia_veiculo_condutor"/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Queixa</legend>
            <div>
                <label>Descricao</label>
                <textarea cols="88" rows="3" name="queixa_descricao" ></textarea><br/>
            </div>
            <div>
                <label>Quanto tempo</label>
                <input type="text" id="queixa_tempo" class="size2" name="queixa_tempo" value="0"/>
            </div>
            <div>
                <label>Unidade</label>
                <select name="queixa_unidade_medida" id="queixa_unidade_medida" class="size2">
                    <option value="1">Dia</option>
                    <option value="2">Mes</option>
                    <option value="3">Ano</option>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>Sinais e Sintomas</legend>
            <div>
                <textarea cols="88" rows="3" name="sintomas_descricao" ></textarea><br/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Sinais Vitais</legend>
            <div >
                <label>PA</label>
                <input type="text" id="sinais_vitais_pa" name="sinais_vitais_pa" value="0">
            </div>
            <div >
                <label>P</label>
                <input type="text" id="sinais_vitais_p" name="sinais_vitais_p" value="0">
            </div>
            <div >
                <label>FR</label>
                <input type="text" id="sinais_vitais_fr" name="sinais_vitais_fr" value="0">
            </div>
            <div >
                <label>Temp</label>
                <input type="text" id="sinais_vitais_temp" name="sinais_vitais_temp" value="0">
            </div>
            <div >
                <label>SATO2</label>
                <input type="text" id="sinais_vitais_sato" name="sinais_vitais_sato" value="0">
            </div>
            <div >
                <select name="conduta" id="conduta" class="size2">
                    <option >Adulto</option>
                    <option >Crianca</option>
                    <option >Recem nascidos</option>
                </select>
            </div >
            <div id="conduta_select4" class="size2 espec" >
                <h4>Escala de dor adulto</h4>

                <label ><input type=radio name="Ramsay" value="0" class="sinais_vitais1"/>Grau 0: sem dor</label>
                <label ><input type=radio name="Ramsay" value="1" class="sinais_vitais1"/>Grau 1: dor leve</label>
                <label ><input type=radio name="Ramsay" value="2" class="sinais_vitais1"/>Grau 2: dor leve</label>
                <label ><input type=radio name="Ramsay" value="3" class="sinais_vitais1"/>Grau 3: dor moderada</label>
                <label ><input type=radio name="Ramsay" value="4" class="sinais_vitais1"/>Grau 4: dor moderada</label>
                <label ><input type=radio name="Ramsay" value="5" class="sinais_vitais1"/>Grau 5: dor moderada</label>
                <label ><input type=radio name="Ramsay" value="6" class="sinais_vitais1"/>Grau 6: dor forte</label>
                <label ><input type=radio name="Ramsay" value="7" class="sinais_vitais1"/>Grau 7: dor forte</label>
                <label ><input type=radio name="Ramsay" value="8" class="sinais_vitais1"/>Grau 8: dor forte</label>
                <label ><input type=radio name="Ramsay" value="9" class="sinais_vitais1"/>Grau 9: pior dor possivel</label>
                <label ><input type=radio name="Ramsay" value="10" class="sinais_vitais1"/>Grau 10: pior dor possivel</label>
                <h4>Pontos</h4>
                <input type="text" readonly name="sinais_vitais1" id="sinais_vitais1" class="size2" value="0"/>
            </div>
            <div id="conduta_select5" class="size2 espec">
                <h4>Escala de dor crianca</h4>

                <label ><input type=radio name="Ramsay" value="0" id="Ramsay" class="sinais_vitais2"/>Grau 0: sem dor</label>
                <label ><input type=radio name="Ramsay" value="1" id="Ramsay" class="sinais_vitais2"/>Grau 1: dor leve</label>
                <label ><input type=radio name="Ramsay" value="2" id="Ramsay" class="sinais_vitais2"/>Grau 2: dor moderada</label>
                <label ><input type=radio name="Ramsay" value="3" id="Ramsay" class="sinais_vitais2"/>Grau 3: dor forte</label>
                <label ><input type=radio name="Ramsay" value="4" id="Ramsay" class="sinais_vitais2"/>Grau 4: pior dor possivel</label>
                <h4>Pontos</h4>
                <input type="text" readonly name="sinais_vitais2" id="sinais_vitais2" class="size2" value="0"/>
            </div>

            <div id="conduta_select6" class="size2 espec">
                <div >
                    <h4>Escala comportamental de dor para recem nascidos</h4>
                    <h4>Parametro</h4>
                    <label>Expressao facial</label>
                    <label>Choro</label>
                    <label>Respiracao</label>
                    <label>Bracos</label>
                    <label>Pernas</label>
                    <label>Estado de conciencia</label>
                    <br />
                </div>
                <div >
                    <h4>0</h4>
                    <label><input type="radio" value="0" name="grupo1" class="radios1" />relachada</label><input type="hidden" id="valor1" class="valorGrupo" value="0" />
                    <label><input type="radio" value="0" name="grupo2" class="radios2" />ausente</label><input type="hidden" id="valor2" class="valorGrupo" value="0" />
                    <label><input type="radio" value="0" name="grupo3" class="radios3" />relachada</label><input type="hidden" id="valor3" class="valorGrupo" value="0" />
                    <label><input type="radio" value="0" name="grupo4" class="radios4" />relachados</label><input type="hidden" id="valor4" class="valorGrupo" value="0" />
                    <label><input type="radio" value="0" name="grupo5" class="radios5" />relachada</label><input type="hidden" id="valor5" class="valorGrupo" value="0" />
                    <label><input type="radio" value="0" name="grupo6" class="radios6" />dormindo/calmo</label><input type="hidden" id="valor6" class="valorGrupo" value="0" />
                    <br />
                </div>
                <div >
                    <h4>1</h4>
                    <label><input type="radio" value="1" name="grupo1" class="radios1" />contraida</label><input type="hidden" id="valor1" class="valorGrupo" value="0" />
                    <label><input type="radio" value="1" name="grupo2" class="radios2" />resmungando</label><input type="hidden" id="valor2" class="valorGrupo" value="0" />
                    <label><input type="radio" value="1" name="grupo3" class="radios3" />alterada</label><input type="hidden" id="valor3" class="valorGrupo" value="0" />
                    <label><input type="radio" value="1" name="grupo4" class="radios4" />fletidos/estendidos</label><input type="hidden" id="valor4" class="valorGrupo" value="0" />
                    <label><input type="radio" value="1" name="grupo5" class="radios5" />fletidas/estendidas</label><input type="hidden" id="valor5" class="valorGrupo" value="0" />
                    <label><input type="radio" value="1" name="grupo6" class="radios6" />desconfortavel</label><input type="hidden" id="valor6" class="valorGrupo" value="0" />
                    <br />
                </div>
                <div >
                    <h4>2</h4>
                    <label>&nbsp;</label>
                    <label><input type="radio" value="2" name="grupo2" class="radios2" />vigoroso</label><input type="hidden" id="valor2" class="valorGrupo" value="0" />
                    <label>&nbsp;</label>
                    <label>&nbsp;</label>
                    <label>&nbsp;</label>
                    <label>&nbsp;</label>
                    <br />
                </div>
                <div >
                    <h4>Pontos</h4>
                    <input type="text" readonly id="sinais_vitais3" name="sinais_vitais3" class="valorTotal">
                </div>
            </div>


        </fieldset>

        <fieldset>
            <legend>Numero de vezes que passou pela unidade</legend>
            <div>
                <label>Posto de Saude</label>
                <input type="text" id="visitas_posto_saude" class="size1" name="visitas_posto_saude" value="0"/>
            </div>
            <div>
                <label>Hospital secundario</label>
                <input type="text" id="visitas_hospital_secundario" class="size1" name="visitas_hospital_secundario" value="0"/>
            </div>
            <div>
                <label>Hospital terciario</label>
                <input type="text" id="visitas_hospital_terciario" class="size1" name="visitas_hospital_terciario" value="0"/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Classificacao de risco</legend>
            <div>
                <select name="risco_id" id="risco_id" class="size2">
                    <option value="0">Nenhum</option>
                    <option value="1">Vermelho</option>
                    <option value="2">Laranja</option>
                    <option value="3">Amarelo</option>
                    <option value="4">Verde</option>
                    <option value="5">Azul</option>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>Referencia para a rede</legend>
            <div>
                <select name="referencia_rede_id" id="referencia_rede_id">
                <? foreach ($listaUnidade as $item) : ?>
                    <option value="<?= $item->unidades_id; ?>"><?= $item->nome; ?></option>
                <? endforeach; ?>
                </select>
            </div>


        </fieldset>
        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
        <button type="button" id="btnVoltar">Voltar</button>
    </form>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.sinais_vitais1').change(function(){
            $("#sinais_vitais1").val(this.value);
        })
        $('.sinais_vitais2').change(function(){
            $("#sinais_vitais2").val(this.value);
        })
        $('.radios1').change(function(){
            $("#valor1").val(this.value);
            atualizaValorTotal()
        })
        $('.radios2').change(function(){
            $("#valor2").val(this.value);
            atualizaValorTotal()
        })
        $('.radios3').change(function(){
            $("#valor3").val(this.value);
            atualizaValorTotal()
        })
        $('.radios4').change(function(){
            $("#valor4").val(this.value);
            atualizaValorTotal()
        })
        $('.radios5').change(function(){
            $("#valor5").val(this.value);
            atualizaValorTotal()
        })
        $('.radios6').change(function(){
            $("#valor6").val(this.value);
            atualizaValorTotal()
        })

        function atualizaValorTotal() {
            total=0;
            for(i=1; i<=6; i++){
                campo = "#valor"+i;
                total += $(campo).val()*1;
            }
            $('#sinais_vitais3').val(total);
        }
        atualizaValorTotal();
    });

    $(function() {
        $( "#txtCidade" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtCidade" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtCidade" ).val( ui.item.value );
                $( "#txtCidadeID" ).val( ui.item.id );
                return false;
            }
        });
    });
    $(function() {
        $( "#txtEstado" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=estado",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtEstado" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtEstado" ).val( ui.item.value );
                $( "#txtEstadoID" ).val( ui.item.id );
                return false;
            }
        });
    });
    $(function() {
        $( "#paciente" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 1,
            focus: function( event, ui ) {
                $( "#paciente" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#paciente" ).val( ui.item.value );
                $( "#paciente_id" ).val( ui.item.id );
                $( "#nome_mae" ).val( ui.item.mae );
                $( "#nascimento" ).val( ui.item.nascimento );
                return false;
            }
        });
    });


    $(document).ready(function(){
        jQuery('#form_paciente').validate( {
            rules: {
                paciente_id: {
                    required: true
                },
                paciente: {
                    required: true
                }

            },
            messages: {
                paciente_id: {
                    required: "*"
                },
                paciente: {
                    required: "*"
                }

            }
        });
    });




</script>