<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3 class="h3_title">Acolhimento</h3>
    <form name="form_acolhimento" id="form_acolhimento" action="<?= base_url() ?>emergencia/filaacolhimento/gravarrae/<?= $paciente_id; ?>" method="post">
        <fieldset>
            <legend>Dados do paciente</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
            </div>
            <div>
                <label>Nascimento</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
            </div>
            <div>
                <label>Idade</label>
                <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />
            </div>
            <div>
                <label>Nome da M&atilde;e</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
            </div>
            <div>
                <label>CNS</label>
                <input type="text" id="txtCns" name="cns"  class="texto04" value="<?= $paciente['0']->cns; ?>" readonly/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Ocorrencia</legend>
            <div>
                <label><input type="radio" value="residencia" name="ocorrencia" class="radios1" />Residencia </label>
            </div>
            <div>
                <label><input type="radio" value="area publica" name="ocorrencia" class="radios2" />&Aacute;rea p&uacuteblica</label>
            </div>
            <div>
                <label> <input type="radio" value="trabalho" name="ocorrencia" class="radios3" />Trabalho</label>
            </div>
            <div>
                <label> <input type="radio" value="instituicao de ensino" name="ocorrencia" class="radios4" />Institui&ccedil;&atilde;o de ensino</label>
            </div>
            <div>
                <label>Local da Ocorrencia</label>
                <textarea cols="" rows="" name="descricaocorrencia" id="txtdescricaocorrencia" class="texto_area" ></textarea>
            </div>
            <div>
                <label>Veiculo</label>
                <input type="text" id="txtveiculo" class="texto04" name="veiculo"/>
            </div>
            <div>
                <label>PLaca</label>
                <input type="text" id="txtplaca" class="texto02" alt="ZZZ-9999" name="placa"/>
            </div>
            <div>
                <label>Condutor</label>
                <input type="text" id="txtcondutor" class="texto06" name="condutor" />
            </div>
            <div>
                <label>Município</label>
                <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" readonly="true" />
                <input type="text" id="txtCidade" class="texto04" name="txtCidade" />
            </div>
        </fieldset>
        <fieldset>
            <legend>Dados acolhimento</legend>
            <div>
                <label>Tipo de atendimeto</label>
                <select name="tipoatendimento" id="tipoatendimento" class="size10" >
                    <option value='' >selecione</option>
                    <?php
                    $listaatendimento = $this->acolhimento->listatipoatendimento($_GET);
                    foreach ($listaatendimento as $item) {
                        ?>
                        <option ><?php echo $item->nome; ?></option>
                        <?php
                    }
                    ?> 
                </select>
            </div>

            <div>
                <label>Motivo de Atendimento</label>
                <input type="hidden" id="txtmotivoID" class="texto_id" name="motivoID"/>
                <input type="text" id="txtmotivo" class="size10" name="txtmotivo"/>
            </div>
            <div>
                <label>Sinais e Sintomas</label>
                <textarea cols="" rows="" name="sinais" id="txtsinais" class="texto_area"></textarea>
            </div>
            <div>
                <label>Escala de Dor</label>
                <select name="esacalador" id="txtesacalador" class="size06">
                    <option value="0">0 - Sem dor</option>
                    <option value="1">1 - Dor leve</option>
                    <option value="2">2 - Dor moderada</option>
                    <option value="3">3 - Dor forte</option>
                    <option value="4">4 - Pior Dor possivel</option>
                </select>
            </div>
        </fieldset>

        <fieldset>
            <legend>Escala de Glasgow</legend>
            <div>
                <h4>Ocular</h4>
                <label><input type="radio" value="1" name="grupo1" class="radios1" />1-Não abre os olhos</label>
                <label><input type="radio" value="2" name="grupo1" class="radios1" />2-Abre os olhos em resposta a estímulo de dor</label>
                <label><input type="radio" value="3" name="grupo1" class="radios1" />3-Abre os olhos em resposta a um chamado</label>
                <label><input type="radio" value="4" name="grupo1" class="radios1" />4-Abre os olhos espontaneamente</label>
                <input type="hidden" id="valor1" class="valorGrupo" value="0" /><br />
            </div>
            <div>
                <h4>Verbal</h4>
                <label><input type="radio" value="1" name="grupo2" class="radios2" /> 1-Emudecido</label>
                <label><input type="radio" value="2" name="grupo2" class="radios2" /> 2-Emite sons incompreensíveis</label>
                <label><input type="radio" value="3" name="grupo2" class="radios2" /> 3-Pronuncia palavras desconexas</label>
                <label><input type="radio" value="4" name="grupo2" class="radios2" /> 4-Confuso, desorientado</label>
                <label><input type="radio" value="5" name="grupo2" class="radios2" /> 5-Orientado, conversa normalmente</label>

                <input type="hidden" id="valor2" class="valorGrupo" value="0" /><br />
            </div>
            <div>
                <h4>Motor</h4>
                <label><input type="radio" value="1" name="grupo3" class="radios3" /> 1-Não se movimenta</label>
                <label><input type="radio" value="2" name="grupo3" class="radios3" /> 2-Extensão a estímulos dolorosos (descerebração)</label>
                <label><input type="radio" value="3" name="grupo3" class="radios3" /> 3-Flexão anormal a estímulos dolorosos (decorticação)</label>
                <label><input type="radio" value="4" name="grupo3" class="radios3" /> 4-Flexão inespecífica/ Reflexo de retirada a estímulos dolorosos</label>
                <label><input type="radio" value="5" name="grupo3" class="radios3" /> 5-Localiza estímulos dolorosos</label>
                <label><input type="radio" value="6" name="grupo3" class="radios3" /> 6-Obedece a comandos</label>
                <input type="hidden" id="valor3" class="valorGrupo" value="0" /><br />
            </div>
            <div>
                <h4>TOTAL</h4>
                <input type="text" readonly id="txtGlasgow" name="glasgow" class="valorTotal">
            </div>
        </fieldset>
        <fieldset>
            <legend>Trabalho</legend>
            <div>
                <label><input type="checkbox" name="trabalho" class="radios10" />Acidente de Trabalho </label>
            </div>
            <div>
                <label>Codigo acidente</label>
                <input type="text" id="txcodigoacidente" class="texto04" name="codigoacidente"/>
            </div>
        </fieldset>
        <fieldset>
            <legend>Sinais vitais</legend>
            <div>
                <label>P.A.S</label>
                <input type="text" id="txtpas" class="texto04" name="pas"/>
            </div>
            <div>
                <label>P.A.D</label>
                <input type="text" id="txtpad" class="texto04" name="pad"/>
            </div>
            <div>
                <label>F.R</label>
                <input type="text" id="txtfr" class="texto04" name="fr"/>
            </div>
            <div>
                <label>Satura&ccedil;&atilde;o de O&sup2;</label>
                <input type="text" name="saturacao" id="txtsaturacao" alt="numeromask" class="size2" />
            </div>
            <div>
                <label>Classificacao de Risco</label>
                <select name="classificacaorisco" id="txtclassificacaorisco" class="texto10">
                    <option >Vermelha</option>
                    <option >Laranja</option>
                    <option >Amarela</option>
                    <option >Verde</option>
                    <option >Azul</option>
                    <option >Branca</option>
                </select>
            </div>
            <div>
                <label>Data e hora ex.( 20/01/2010 14:30:21)</label>
                <input type="text" name="data" id="data" alt="39/19/9999 29:59:59" value="<? echo $data;?>" class="size2" />
            </div>
        </fieldset>


        <button type="submit">Enviar</button>
        <button type="reset">Limpar</button>
    </form>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">


    $(document).ready(function(){
        jQuery('#form_acolhimento').validate( {
            rules: {
                tipoatendimento: {
                    required: true
                },
                txtmotivo: {
                    required: true
                },
                txtmotivoID: {
                    required: true
                }
   
            },
            messages: {
                tipoatendimento: {
                    required: "*"
                },
                txtmotivo: {
                    required: "*"
                },
                txtmotivoID: {
                    required: "*"
                }
            }
        });
    });
    $(function() {
        $( "#txtmotivo" ).autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=motivo_atendimento",
            minLength: 4,
            focus: function( event, ui ) {
                $( "#txtmotivo" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtmotivo" ).val( ui.item.value );
                $( "#txtmotivoID" ).val( ui.item.id );
                return false;
            }
        });
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

    $(document).ready(function(){
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
        $('.Ramsay').change(function(){
            $("#txtRamsay").val(this.value);
        })
        function atualizaValorTotal() {
            total=0;
            for(i=1; i<=3; i++){
                campo = "#valor"+i;
                total += $(campo).val()*1;
            }
            $('#txtGlasgow').val(total);
        }
        atualizaValorTotal();
    });






</script>