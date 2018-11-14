<?
if (count(@$informacao_aso[0]->impressao_aso) > 0) {
    $config = json_decode(@$informacao_aso[0]->impressao_aso);
} else {
    $config = '';
}
?>
<? $perfil_id = $this->session->userdata('perfil_id'); ?>
<?php
$this->load->library('utilitario');
//    echo'<pre>';
//    var_dump($config); die;
Utilitario::pmf_mensagem($this->session->flashdata('message'));
?>
<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3>Cadastro ASO</h3>

    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/guia/gravarcadastroaso/<?= @$paciente[0]->paciente_id ?>/" method="post">


        <fieldset>
            <legend>Dados do Paciente</legend>
            <div>
                <label>Nome</label>                      
                <input readonly="" type="text" id="txtNome" name="nome_paciente"  class="texto09" value="<?= $paciente[0]->nome ?>" />
                <input type="hidden" id="txtPacienteId" name="txtPacienteId"  class="texto09" value="<?= @$paciente[0]->paciente_id ?>"/>
                <input type="hidden" id="cadastro_aso_id" name="cadastro_aso_id"  class="texto09" value="<?= @$informacao_aso[0]->cadastro_aso_id ?>"/>
                <input type="hidden" id="conveniobase_id" name="conveniobase_id"  class="texto09" value="<?= @$convenioid[0]->convenio_id ?>"/>
                <!--<input type="hidden" id="coordenador_id" name="coordenador_id"  class="texto09" value="<?= @$coordenador_id[0]->coordenador_id ?>"/>-->
                <? // var_dump($convenioid[0]->convenio_id);die; ?>
            </div>
            <div>
                <label>Sexo</label>
                <select disabled="" name="sexo" id="txtSexo" class="size2" required="">
                    <option value="" <?
                    if (@$paciente[0]->sexo == ""):echo 'selected';
                    endif;
                    ?>>Selecione</option>
                    <option value="M" <?
                    if (@$paciente[0]->sexo == "M"):echo 'selected';
                    endif;
                    ?>>Masculino</option>
                    <option value="F" <?
                    if (@$paciente[0]->sexo == "F"):echo 'selected';
                    endif;
                    ?>>Feminino</option>
                    <option value="O" <?
                    if (@$paciente[0]->sexo == "O"):echo 'selected';
                    endif;
                    ?>>Outro</option>
                </select>

            </div>
            <div>
                <label>DT de nascimento</label>

                <input readonly type="text" name="nascimento" id="nascimento" alt="date" value="<?= (@$paciente[0]->nascimento != '') ? date("d/m/Y", strtotime(@$paciente[0]->nascimento)) : ''; ?>"  class="texto02" maxlength="10" value="" required=""/>
            </div>
            <div>
                <label>Idade</label>

                <input readonly="" type="text" onblur="calculoIdade()" name="idade"  id="idade" class="texto02"   maxlength="10" value="<?php echo substr(@$paciente[0]->nascimento, 8, 2) . '/' . substr(@$paciente[0]->nascimento, 5, 2) . '/' . substr(@$paciente[0]->nascimento, 0, 4); ?>" required=""/>
            </div>
            <div>
                <label>RG</label>
                <input readonly="" type="text" name="rg" id="rg" class="texto04" value="<?= @$paciente[0]->rg ?>" />
            </div>
            <div>
                <label>Modalidade</label>
                <select name="consulta" id="consulta" class="size2" required="">
                    <option value="">SELECIONE</option>
                    <option value="particular" <?= (@$config->consulta == 'particular') ? 'selected' : ''; ?>>Particular</option>
                    <option value="conveniado" <?= (@$config->consulta == 'conveniado') ? 'selected' : ''; ?>>Conveniado</option>                    
                </select>

            </div>


        </fieldset>
        <fieldset>
            <legend>Informações</legend>

            <div>
                <label>Tipo</label>
                <select id="tipo" name="tipo"  class="size02" >
                    <option value="">
                        Selecione
                    </option>
                    <option value="ADMISSIONAL" <?= (@$informacao_aso[0]->tipo == 'ADMISSIONAL') ? 'selected' : ''; ?>>
                        ADMISSIONAL
                    </option>
                    <option value="PERÍODICO" <?= (@$informacao_aso[0]->tipo == 'PERÍODICO') ? 'selected' : ''; ?>>
                        PERÍODICO
                    </option>
                    <option value="RETORNO AO TRABALHO" <?= (@$informacao_aso[0]->tipo == 'RETORNO AO TRABALHO') ? 'selected' : ''; ?>>
                        RETORNO AO TRABALHO
                    </option>
                    <option value="MUDANÇA DE FUNÇÃO" <?= (@$informacao_aso[0]->tipo == 'MUDANÇA DE FUNÇÃO') ? 'selected' : ''; ?>>
                        MUDANÇA DE FUNÇÃO
                    </option>
                    <option value="DEMISSIONAL" <?= (@$informacao_aso[0]->tipo == 'DEMISSIONAL') ? 'selected' : ''; ?>>
                        DEMISSIONAL
                    </option>
                </select>

            </div>



            <div id="convenio">
                <label>Empresa</label>

                <select  name="convenio1" id="convenio1" class="size2" required="" >      
                    <option value="">Selecione </option>
                    <?
                    foreach ($convenio as $item) :
                        ?>
                        <option value="<?= $item->convenio_id; ?>" <?= (@$config->convenio1 == $item->convenio_id) ? 'selected' : '' ?>>
                            <?= $item->nome; ?>
                        </option>
                    <? endforeach; ?>
                </select>                
                <input type="text" id="convenio2" name="convenio2"  class="texto04" value="<?= @$config->convenio2 ?>" />
            </div>

            <div id="setor1">
                <label>Setor</label>
                <select name="setor" id="setor" class="size2" required="">

                </select>
                <input type="text" id="setor2" name="setor2"  class="texto04" value="<?= @$config->setor2 ?>" />
            </div>
            <div id="funcao1">
                <label>Função</label>
                <select name="funcao" id="funcao" class="size2" required="">


                </select>
                <input type="text" id="funcao2" name="funcao2"  class="texto04" value="<?= @$config->funcao2 ?>" />
            </div>
            <div>
                <label>Data De Realização</label>
                <input type="text" name="data_realizacao" id="data_realizacao" class="texto04" value="<?= @$config->data_realizacao ?>" required=""/>
            </div>
            <div>
                <label>Médico</label>
                <select name="medico" id="medico" class="size2" required="">
                    <option value="">Selecione</option>
                    <? foreach ($medicos as $item) : ?>
                        <option value="<?= $item->operador_id; ?>" <?= (@$informacao_aso[0]->medico_responsavel == $item->operador_id) ? 'selected' : '' ?>>
                            <?= $item->nome; ?>
                        </option>
                    <? endforeach; ?>
                </select>
            </div>
            <div id="divcoordenador">
                <label>Médico Coordenador</label>
                <select name="coordenador" id="coordenador" class="size2">
                    <option value="">Selecione</option>
                    <? foreach ($medicos as $item) : ?>
                        <option value="<?= $item->operador_id; ?>" <?= (@$config->coordenador == $item->operador_id) ? 'selected' : '' ?>>
                            <?= $item->nome; ?>
                        </option>
                    <? endforeach; ?>
                </select>
            </div>
            <div>
                <label>Validade do Exame</label>
                <input type="text" name="validade_exame" id="validade_exame" class="texto04" value="<?= @$config->validade_exame ?>" readonly="" />
            </div>
            <div>
                <label>Sala</label>
                <select  name="sala1" id="sala1" class="size2" required="">
                    <option value="">Selecione</option>
                    <? foreach ($salas as $item) : ?>
                        <option value="<?= $item->exame_sala_id; ?>"<?= (@$config->sala1 == $item->exame_sala_id) ? 'selected' : '' ?>>
                            <?= $item->nome; ?>
                        </option>
                    <? endforeach; ?>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <div class="examec">

                <label>Exames Complementares</label>
                <select name="procedimento1[]" id="procedimento1" style="width: 400px" class="chosen-select" data-placeholder="Selecione os Exames..." multiple>

                </select>
            </div>

            <div>               

                <label>Riscos Ocupacionais Específicos</label>


                <select name="riscos[]" id="riscos" style="width: 400px" class="chosen-select" data-placeholder="Selecione os Riscos..." multiple tabindex="1">

                </select>

            </div>


        </fieldset>
        <fieldset>
            <legend>Avaliação Clínica</legend>
            <textarea name="avaliacao_clinica" style="height: 300px;" id="avaliacao_clinica"><?= @$config->avaliacao_clinica ?></textarea>
            <div style="width: 100%;">
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </div>

        </fieldset>
        <? if ($perfil_id == 4) { ?>
            <fieldset>
                <legend>Aptidões</legend>
                <div>

                    <label title="O funcionário acima, foi submetido(a) a exame médico, conforme a NR 07, sendo considerado:">NR7 (?) </label>
                    <select name="questao_um" id="questao_um" required="" class="texto04" title="O funcionário acima, foi submetido(a) a exame médico, conforme a NR 07, sendo considerado:" >
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_um == 'APTO') ? 'selected' : '' ?>>APTO PARA O TRABALHO QUE EXERCE</option>
                        <option value="APTO2" <?= (@$config->questao_um == 'APTO2') ? 'selected' : '' ?>>APTO PARA O TRABALHO QUE IRÁ EXERCER</option>
                        <option value="APTO3" <?= (@$config->questao_um == 'APTO3') ? 'selected' : '' ?>>APTO PARA O TRABALHO QUE EXERCEU</option>
                        <option value="INAPTO" <?= (@$config->questao_um == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>

                    </select>
                </div>
                <div>

                    <label title="NR 35 - Quanto a obrigatoriedade de constar no ASO do funcionário se ele é mapeado para Trabalho em Altura
                           NR 35.4.1.2.1 - A Aptidão para Trabalho em Altura deve ser consignada no atestado de saúde ocupacional do trabalhador ">NR35, NR 35.4.1.2.1</label>
                    <select name="questao_dois" id="questao_dois" required="" class="texto04" title="NR 35 - Quanto a obrigatoriedade de constar no ASO do funcionário se ele é mapeado para Trabalho em Altura
                            NR 35.4.1.2.1 - A Aptidão para Trabalho em Altura deve ser consignada no atestado de saúde ocupacional do trabalhador ">
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_dois == 'APTO') ? 'selected' : '' ?>>APTO PARA TRABALHO EM ALTURA</option>
                        <option value="INAPTO" <?= (@$config->questao_dois == 'INAPTO') ? 'selected' : '' ?>>INAPTO PARA TRABALHO EM ALTURA</option>
                        <option value="NÃO MAPEADO" <?= (@$config->questao_dois == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>
                    </select>
                </div>
                <div>

                    <label title="NR 33 - Segurança e Saúde nos Trabalhos em Espaços Confinados conforme item 33.3.4.1">NR 33 </label>
                    <select name="questao_tres" id="questao_tres" required="" class="texto04" title="NR 33 - Segurança e Saúde nos Trabalhos em Espaços Confinados conforme item 33.3.4.1">
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_tres == 'APTO') ? 'selected' : '' ?>>APTO</option>
                        <option value="INAPTO" <?= (@$config->questao_tres == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>
                        <option value="NÃO MAPEADO" <?= (@$config->questao_tres == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>
                    </select>
                </div>
                <div>

                    <label>APTIDÃO MÁQUINAS MÓVEIS </label>
                    <select name="questao_quatro" id="questao_quatro" required="" class="texto04">
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_quatro == 'APTO') ? 'selected' : '' ?>>APTO PARA OPERAR MÁQUINAS MÓVEIS</option>
                        <option value="INAPTO" <?= (@$config->questao_quatro == 'INAPTO') ? 'selected' : '' ?>>INAPTO PARA OPERAR MÁQUINAS MÓVEIS</option>
                        <option value="NÃO MAPEADO" <?= (@$config->questao_quatro == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>
                    </select>
                </div>
                <div>

                    <label title="NR 10 - Segurança em Instalações e Serviços em Eletricidade conforme item 10.8.7">NR 10 </label>
                    <select name="questao_cinco" id="questao_cinco"  required="" class="texto04" title="NR 10 - Segurança em Instalações e Serviços em Eletricidade conforme item 10.8.7">
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_cinco == 'APTO') ? 'selected' : '' ?>>APTO</option>
                        <option value="INAPTO" <?= (@$config->questao_cinco == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>
                        <option value="NÃO MAPEADO" <?= (@$config->questao_cinco == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>

                    </select>
                </div>          

            </fieldset>
        <? } else { ?>
            <fieldset>
                <legend>Aptidões</legend>
                <div>

                    <label title="O funcionário acima, foi submetido(a) a exame médico, conforme a NR 07, sendo considerado:">NR7 (?) </label>
                    <select name="questao_um" id="questao_um" class="texto04" title="O funcionário acima, foi submetido(a) a exame médico, conforme a NR 07, sendo considerado:" >
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_um == 'APTO') ? 'selected' : '' ?>>APTO PARA O TRABALHO QUE EXERCE</option>
                        <option value="APTO2" <?= (@$config->questao_um == 'APTO2') ? 'selected' : '' ?>>APTO PARA O TRABALHO QUE IRÁ EXERCER</option>
                        <option value="APTO3" <?= (@$config->questao_um == 'APTO3') ? 'selected' : '' ?>>APTO PARA O TRABALHO QUE EXERCEU</option>
                        <option value="INAPTO" <?= (@$config->questao_um == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>

                    </select>
                </div>
                <div>

                    <label title="NR 35 - Quanto a obrigatoriedade de constar no ASO do funcionário se ele é mapeado para Trabalho em Altura
                           NR 35.4.1.2.1 - A Aptidão para Trabalho em Altura deve ser consignada no atestado de saúde ocupacional do trabalhador ">NR35, NR 35.4.1.2.1</label>
                    <select name="questao_dois" id="questao_dois" class="texto04" title="NR 35 - Quanto a obrigatoriedade de constar no ASO do funcionário se ele é mapeado para Trabalho em Altura
                            NR 35.4.1.2.1 - A Aptidão para Trabalho em Altura deve ser consignada no atestado de saúde ocupacional do trabalhador ">
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_dois == 'APTO') ? 'selected' : '' ?>>APTO PARA TRABALHO EM ALTURA</option>
                        <option value="INAPTO" <?= (@$config->questao_dois == 'INAPTO') ? 'selected' : '' ?>>INAPTO PARA TRABALHO EM ALTURA</option>
                        <option value="NÃO MAPEADO" <?= (@$config->questao_dois == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>
                    </select>
                </div>
                <div>

                    <label title="NR 33 - Segurança e Saúde nos Trabalhos em Espaços Confinados conforme item 33.3.4.1">NR 33 </label>
                    <select name="questao_tres" id="questao_tres" class="texto04" title="NR 33 - Segurança e Saúde nos Trabalhos em Espaços Confinados conforme item 33.3.4.1">
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_tres == 'APTO') ? 'selected' : '' ?>>APTO</option>
                        <option value="INAPTO" <?= (@$config->questao_tres == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>
                        <option value="NÃO MAPEADO" <?= (@$config->questao_tres == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>
                    </select>
                </div>
                <div>

                    <label>APTIDÃO MÁQUINAS MÓVEIS </label>
                    <select name="questao_quatro" id="questao_quatro" class="texto04">
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_quatro == 'APTO') ? 'selected' : '' ?>>APTO PARA OPERAR MÁQUINAS MÓVEIS</option>
                        <option value="INAPTO" <?= (@$config->questao_quatro == 'INAPTO') ? 'selected' : '' ?>>INAPTO PARA OPERAR MÁQUINAS MÓVEIS</option>
                        <option value="NÃO MAPEADO" <?= (@$config->questao_quatro == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>
                    </select>
                </div>
                <div>

                    <label title="NR 10 - Segurança em Instalações e Serviços em Eletricidade conforme item 10.8.7">NR 10 </label>
                    <select name="questao_cinco" id="questao_cinco" class="texto04" title="NR 10 - Segurança em Instalações e Serviços em Eletricidade conforme item 10.8.7">
                        <option value="">Selecione</option>
                        <option value="APTO" <?= (@$config->questao_cinco == 'APTO') ? 'selected' : '' ?>>APTO</option>
                        <option value="INAPTO" <?= (@$config->questao_cinco == 'INAPTO') ? 'selected' : '' ?>>INAPTO</option>
                        <option value="NÃO MAPEADO" <?= (@$config->questao_cinco == 'NÃO MAPEADO') ? 'selected' : '' ?>>NÃO MAPEADO</option>

                    </select>
                </div>          

            </fieldset>
        <? } ?>
        <fieldset>
            <? if (@$informacao_aso[0]->medico_responsavel != '') { ?>
                <input type="hidden" name="medico_responsavel" id="medico_responsavel" class="texto04" value="<?= @$informacao_aso[0]->medico_responsavel ?>" />
            <? } else { ?>
                <input type="hidden" name="medico_responsavel" id="medico_responsavel" class="texto04" value="<?= @$medico_id ?>" />
            <? } ?>

            <div style="width: 100%;">
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>               

            </div>
        </fieldset>

    </form>
    <!--</div>  Final da DIV content -->
</div> <!-- Final da DIV content -->
<style>
    textarea{
        width: 90%;
        /*font-size: 18pt;*/
        /*height: 50pt;*/

        .examec {
            display: inline;
            float: left;

        }
    }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 330px; }
</style>
<? // echo'<pre>'; var_dump($informacao_aso);die;  ?>
<script type="text/javascript">

                    $(function () {
                        $("#data_realizacao").datepicker({
                            autosize: true,
                            changeYear: true,
                            changeMonth: true,
                            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                            buttonImage: '<?= base_url() ?>img/form/date.png',
                            dateFormat: 'dd/mm/yy'


                        });
                    });

                    
                    $(function () {
                        $('#tipo').change(function () {
                            $.getJSON('<?= base_url() ?>autocomplete/datavalidade356', {data_realizacao: $('#data_realizacao').val(), tipo: $(this).val(), empresa: $('#convenio1').val(), modalidade: $('#consulta').val()}, function (j) {

                                validade = j;
//                                console.log(validade);

                                $('#validade_exame').val(validade);

                            });


                        });
                    });
                    
                    $(function () {
                        $('#data_realizacao').change(function () {
                            $.getJSON('<?= base_url() ?>autocomplete/datavalidadenova', {data_realizacao: $(this).val(), tipo: $('#tipo').val(), empresa: $('#convenio1').val(), modalidade: $('#consulta').val()}, function (j) {

                                validadenova = j;
//                                console.log(validadenova);

                                $('#validade_exame').val(validadenova);

                            });


                        });
                    });




<? if (@$config->setor != '') { ?>

                        var setor = <?= @$config->setor ?>;
                        carregarSetorAtualizar();
<? } else { ?>
                        var setor = '';
<? }
?>
                    function carregarSetorAtualizar() {
                        $.getJSON('<?= base_url() ?>autocomplete/setorempresamt2', {convenio1: $('#convenio1').val()}, function (j) {
                            options = '<option value=""></option>';
//                                console.log(j);
                            for (var c = 0; c < j.length; c++) {
                                if (setor == j[c].setor_id) {
                                    options += '<option selected value="' + j[c].setor_id + '">' + j[c].descricao_setor + '</option>';
                                } else {
                                    options += '<option value="' + j[c].setor_id + '">' + j[c].descricao_setor + '</option>';
                                }

                            }


                            $('#setor option').remove();
                            $('#setor').append(options);
                            $("#setor").trigger("chosen:updated");
                            $('.carregando').hide();
                        });
                    }


                    $(function () {
                        $('#convenio1').change(function () {

//                            $('.carregando').show();
//                            alert('asdsd');
                            $.getJSON('<?= base_url() ?>autocomplete/setorempresamt2', {convenio1: $(this).val()}, function (j) {
                                options = '<option value=""></option>';
//                                console.log(j);

                                for (var c = 0; c < j.length; c++) {
                                    if (setor == j[c].setor_id) {
                                        options += '<option selected value="' + j[c].setor_id + '">' + j[c].descricao_setor + '</option>';
                                    } else {
                                        options += '<option value="' + j[c].setor_id + '">' + j[c].descricao_setor + '</option>';
                                    }

                                }


                                $('#setor option').remove();
                                $('#setor').append(options);
                                $("#setor").trigger("chosen:updated");
                                $('.carregando').hide();
                            });
//                            if(){}
//                            $.getJSON('<?= base_url() ?>autocomplete/medcoordenador', {convenio1: $('#convenio1').val()}, function (j) {
//                                        options = '<option value=""></option>';
////                                console.log(j);
//
//                                        for (var c = 0; c < j.length; c++) {
//                                            if (coordenador == j[c].coordenador_id) {
//                                                options += '<option selected value="' + j[c].coordenador_id + '">' + j[c].nome + '</option>';
//                                            } else {
//                                                options += '<option selected value="' + j[c].coordenador_id + '">' + j[c].nome + '</option>';
//                                            }
//
//                                        }
//
//
//                                        $('#coordenador option').remove();
//                                        $('#coordenador').append(options);
//                                        $("#coordenador").trigger("chosen:updated");
//                                        $('.carregando').hide();
//                                    });

                        });
                    });


<? if (@$config->funcao != '') { ?>

                        var funcao = <?= @$config->funcao ?>;
                        carregarFuncaoAtualizar();
<? } else { ?>
                        var funcao = '';
<? }
?>
                    function carregarFuncaoAtualizar() {
//                        alert(setor);
//                                console.log(j);
                        $.getJSON('<?= base_url() ?>autocomplete/funcaosetormt2', {setor: setor, empresa: $('#convenio1').val()}, function (j) {
                            options = '<option value=""></option>';
                            for (var c = 0; c < j.length; c++) {
                                if (funcao == j[c].funcao_id) {
                                    options += '<option selected value="' + j[c].funcao_id + '">' + j[c].descricao_funcao + '</option>';
                                } else {
                                    options += '<option value="' + j[c].funcao_id + '">' + j[c].descricao_funcao + '</option>';
                                }

                            }


                            $('#funcao option').remove();
                            $('#funcao').append(options);
                            $("#funcao").trigger("chosen:updated");
                            $('.carregando').hide();
                        });
                    }

//                    function carregarFuncaoAtualizar2() {
////                        alert(funcao);
//                            $('#funcao2 option').remove();
//                            $('#funcao2').append(funcao);
////                            $("#funcao2").trigger("chosen:updated");
//                            $('.carregando').hide();
//                        });
//                    }


                    $(function () {
                        $('#setor').change(function () {

//                            $('.carregando').show();
//                            alert('asdsd');
                            $.getJSON('<?= base_url() ?>autocomplete/funcaosetormt2', {setor: $(this).val(), empresa: $('#convenio1').val()}, function (j) {
                                options = '<option value=""></option>';
//                                console.log(j);
                                for (var c = 0; c < j.length; c++) {
                                    if (funcao == j[c].funcao_id) {
                                        options += '<option selected value="' + j[c].funcao_id + '">' + j[c].descricao_funcao + '</option>';
                                    } else {
                                        options += '<option value="' + j[c].funcao_id + '">' + j[c].descricao_funcao + '</option>';
                                    }

                                }


                                $('#funcao option').remove();
                                $('#funcao').append(options);
                                $("#funcao").trigger("chosen:updated");
                                $('.carregando').hide();
                            });

                        });
                    });

<? if (count($informacao_aso) > 0) { ?>
    <? if (isset($informacao_aso[0]->cadastro_aso_id)) { ?>
                            var aso_id = <?= $informacao_aso[0]->cadastro_aso_id ?>;
    <? } else { ?>
                            var aso_id = '';
    <? } ?>

    //                            alert(aso_id);
<? } else { ?>

                        var aso_id = '';
<? } ?>

<? if (@$config->consulta == "particular") { ?>
                        var modalidade = "particular";
<? } else { ?>
                        var modalidade = "conveniado";
<? } ?>

<? if (@$config->riscos != '') { ?>

                        var risco = [<?= implode(', ', @$config->riscos); ?>];
                        carregarRiscoAtualizar();
<? } else { ?>

                        var risco = '';
<? } ?>


                    function carregarRiscoAtualizar() {
//                       alert(aso_id);
                        if (modalidade == "conveniado") {
                            $.getJSON('<?= base_url() ?>autocomplete/riscofuncaomt2', {funcao: funcao, empresa: $('#convenio1').val(), setor: setor}, function (j) {
                                options = '<option value=""></option>';
//                                console.log(j);
                                for (var c = 0; c < j.length; c++) {
//                                    alert(risco.indexOf(parseInt(j[c].aso_risco_id)));
//                                    alert(j[c].aso_risco_id);
                                    if (risco.indexOf(parseInt(j[c].aso_risco_id)) > -1) {
                                        options += '<option selected value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';
                                    } else {
                                        options += '<option value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';
                                    }

                                }


                                $('#riscos option').remove();
                                $('#riscos').append(options);
//                                $("#riscos_teste").trigger("listz:updated");
                                $("#riscos").trigger("chosen:updated");
//                                $('.carregando').hide();
                            });
                        } else {
//                        alert(aso_id);

                            $.getJSON('<?= base_url() ?>autocomplete/riscofuncaomt', {aso_id: aso_id}, function (j) {

                                console.log(j);
                                options = '<option value=""></option>';
                                for (var c = 0; c < j.length; c++) {
//                                    alert(risco.indexOf(parseInt(j[c].aso_risco_id)));
//                                    alert(j[c].aso_risco_id);
                                    if (risco.indexOf(parseInt(j[c].aso_risco_id)) > -1) {
                                        options += '<option selected value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';
                                    } else {
                                        options += '<option value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';
                                    }

                                }


                                $('#riscos option').remove();
                                $('#riscos').append(options);
//                                $("#riscos_teste").trigger("listz:updated");
                                $("#riscos").trigger("chosen:updated");
//                                $('.carregando').hide();
                            });
                        }
                    }
                    $(function () {
                        $('#funcao').change(function () {

//                            

                            $.getJSON('<?= base_url() ?>autocomplete/riscofuncaomt2', {funcao: $(this).val(), empresa: $('#convenio1').val(), setor: $('#setor').val()}, function (j) {
                                options = '<option value=""></option>';
//                                console.log(j);
                                for (var c = 0; c < j.length; c++) {

                                    options += '<option selected value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';


                                }


                                $('#riscos option').remove();
                                $('#riscos').append(options);
//                                $("#riscos_teste").trigger("listz:updated");
                                $("#riscos").trigger("chosen:updated");
//                                $('.carregando').hide();
                            });

                        });
                    });


<? if (@$config->procedimento1 != '') { ?>
                        //                       
                        var exame = [<?= implode(', ', @$config->procedimento1); ?>];
                        carregarProcedimentoAtualizar();
                        //  Carrega os procedimentos quando a página atualiza e cria um array com os procedimentos
                        // para os mesmos já virem selecionados em caso de edição
<? } else { ?>
                        var exame = '';
                        carregarProcedimentoAtualizar();
                        //Se não houver procedimentos salvos nesse aso, ele entra na função e mostra os procedimentos
                        // que existem para aquela função, deixando possível de alguém adicionar um procedimento
<? }
?>

                    function carregarProcedimentoAtualizar() {
                        if (modalidade == "conveniado") {
                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioaso', {funcao: funcao, empresa: $('#convenio1').val(), setor: setor}, function (j) {
                                options = '<option value=""></option>';

                                for (var c = 0; c < j.length; c++) {
//                                    alert(exame.indexOf(parseInt(j[c].procedimento_convenio_id)));
                                    //    alert(j[c].procedimento_convenio_id);
                                    if (exame.indexOf(parseInt(j[c].procedimento_convenio_id)) > -1) {
                                        options += '<option selected value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                    } else {
                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                    }

                                }


                                $('#procedimento1 option').remove();
                                $('#procedimento1').append(options);
                                $("#procedimento1").trigger("chosen:updated");
                            });
                        } else {
//                    alert(aso_id);
                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoparticular', {aso_id: aso_id}, function (j) {
                                options = '<option value=""></option>';

                                for (var c = 0; c < j.length; c++) {
//                                    alert(exame.indexOf(parseInt(j[c].procedimento_convenio_id)));
//                                    alert(j[c].procedimento_convenio_id);
                                    if (exame.indexOf(parseInt(j[c].procedimento_convenio_id)) > -1) {
                                        options += '<option selected value="' + j[c].procedimento_convenio_id + '">' + j[c].nome + '</option>';
                                    } else {
                                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].nome + '</option>';
                                    }

                                }


                                $('#procedimento1 option').remove();
                                $('#procedimento1').append(options);
                                $("#procedimento1").trigger("chosen:updated");
                            });
                        }
                    }
                    $(function () {
                        $('#funcao').change(function () {
                            if ($(this).val()) {
//                                $('.carregando').show();
//                                alert('hello');
                                $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioaso', {funcao: $('#funcao').val(), empresa: $('#convenio1').val(), setor: $('#setor').val()}, function (j) {
                                    options = '<option value=""></option>';
//                                    console.log(j);
                                    for (var c = 0; c < j.length; c++) {
                                        options += '<option selected value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';
                                    }
//                                    alert(options);
//                            $('#procedimento1').html(options).show();
                                    $('#procedimento1 option').remove();
                                    $('#procedimento1').append(options);
                                    $("#procedimento1").trigger("chosen:updated");
                                    $('.carregando').hide();
                                });
                            } else {
                                $('#procedimento1').html('<option value="">Selecione</option>');
                            }
                        });
                    });


                    tinyMCE.init({
                        // General options
                        mode: "textareas",
                        theme: "advanced",
                        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
                        // Theme options
                        theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,pagebreak,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,fullscreen",
                        theme_advanced_toolbar_location: "top",
                        theme_advanced_toolbar_align: "left",
                        theme_advanced_statusbar_location: "bottom",
                        theme_advanced_resizing: true,
                        browser_spellcheck: true,
                        // Example content CSS (should be your site CSS)
                        //                                    content_css : "css/content.css",
                        content_css: "js/tinymce/jscripts/tiny_mce/themes/advanced/skins/default/img/content.css",
                        // Drop lists for link/image/media/template dialogs
                        template_external_list_url: "lists/template_list.js",
                        external_link_list_url: "lists/link_list.js",
                        external_image_list_url: "lists/image_list.js",
                        media_external_list_url: "lists/media_list.js",
                        // Style formats
                        style_formats: [
                            {title: 'Bold text', inline: 'b'},
                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                            {title: 'Table styles'},
                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                        ],
                        // Replace values for the template plugin
                        template_replace_values: {
                            username: "Some User",
                            staffid: "991234"
                        }

                    });
                    function calculoIdade() {
                        var data = document.getElementById("nascimento").value;

                        if (data != '' && data != '//') {

                            var ano = data.substring(6, 12);
                            var idade = new Date().getFullYear() - ano;

                            var dtAtual = new Date();
                            var aniversario = new Date(dtAtual.getFullYear(), parseInt(data.substring(3, 5)) - 1, data.substring(0, 2));

                            if (dtAtual < aniversario) {
                                idade--;
                            }
                            document.getElementById("idade").value = idade + " ano(s)";
                        } else {

                        }
                    }
                    calculoIdade();


//                     function carregarProcedimentosAtualizar(){

//                         $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioaso', {funcao: $('#funcao').val(), empresa: $('#convenio1').val(), setor: $('#setor').val()}, function (j) {
//                                 options = '<option value=""></option>';
// //                                     console.log(j);
//                                 for (var c = 0; c < j.length; c++) {
//                                     options += '<option selected value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';

//                                 }
// //                            $('#procedimento1').html(options).show();
//                                 $('#procedimento1 option').remove();
//                                 $('#procedimento1').append(options);
//                                 $("#procedimento1").trigger("chosen:updated");
// //                                    $('.carregando').hide();
//                             });
//                     }                


                    function coordenador() {

                        $.getJSON('<?= base_url() ?>autocomplete/medcoordenador', {convenio1: $('#convenio1').val()}, function (j) {
                            options = '<option value=""></option>';
//                                console.log(j);

                            for (var c = 0; c < j.length; c++) {
                                if (coordenador == j[c].coordenador_id) {
                                    options += '<option selected value="' + j[c].coordenador_id + '">' + j[c].nome + '</option>';
                                } else {
                                    options += '<option selected value="' + j[c].coordenador_id + '">' + j[c].nome + '</option>';
                                }

                            }


                            $('#coordenador option').remove();
                            $('#coordenador').append(options);
                            $("#coordenador").trigger("chosen:updated");
                            $('.carregando').hide();
                        });

                    }
                    ;

                    function coordenadorparticular() {
//                    alert('asdsd');


                        $.getJSON('<?= base_url() ?>autocomplete/medcoordenadorparticular', {convenio1: $('convenio1').val()}, function (j) {
                            options = '<option value=""></option>';
//                                console.log(j);

                            for (var c = 0; c < j.length; c++) {
                                if (coordenador == j[c].coordenador_id) {
                                    options += '<option selected value="' + j[c].operador_id + '">' + j[c].nome + '</option>';
                                } else {
                                    options += '<option  value="' + j[c].operador_id + '">' + j[c].nome + '</option>';
                                }

                            }


                            $('#coordenador option').remove();
                            $('#coordenador').append(options);
                            $("#coordenador").trigger("chosen:updated");
                            $('.carregando').hide();
                        });


                    }
                    ;


//                    $(document).ready(function() {
<? if (@$config->consulta == "particular") { ?>
                        //                      alert('asdasd');
                        $('#convenio1').hide();
                        $('#convenio2').show();
                        $('#setor').hide();
                        $('#setor2').show();
                        $('#funcao').hide();
                        $('#funcao2').show();
                        $('#divcoordenador').show();
                        $("#consulta").prop('required', false);
                        $("#convenio1").prop('required', false);
                        $("#setor").prop('required', false);
                        $("#funcao").prop('required', false);


                        $.getJSON('<?= base_url() ?>ambulatorio/guia/listarriscos', {setor: $('#setor').val()}, function (j) {

                            options = '<option value=""></option>';
    //                                alert('ola');
                            for (var c = 0; c < j.length; c++) {
    //                                    console.log(j);
                                options += '<option value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';


                            }


                            $('#riscos option').remove();
                            $('#riscos').append(options);
                            $("#riscos").trigger("chosen:updated");

                        });
    <? if (count($convenioid) > 0) { ?>
                            var aso = <?= $convenioid[0]->convenio_id ?>;
    <? } else { ?>
                            alert('Não existe um convênio padrão associado para o Particular.')
                            var aso = '';
    <? }
    ?>

                        $.getJSON('<?= base_url() ?>cadastros/convenio/listarprocedimentossetores', {empresa: aso}, function (j) {
                            options = '<option value=""></option>';

                            for (var c = 0; c < j.length; c++) {

                                options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].nome + '</option>';


                            }


                            $('#procedimento1 option').remove();
                            $('#procedimento1').append(options);
                            $("#procedimento1").trigger("chosen:updated");

                        });

<? } else {
    ?>
                        //                            alert('eeee');
    //                        coordenador();
                        $('#convenio2').hide();
                        $('#convenio1').show();
                        $('#setor2').hide();
                        $('#setor').show();
                        $('#funcao2').hide();
                        $('#funcao').show();
                        $('#divcoordenador').hide();
                        $("#consulta").prop('required', false);
<? } ?>

//                 });
//                             $.getJSON('<?= base_url() ?>ambulatorio/guia/listarriscos', {setor: $('#setor').val()}, function (j) {

//                                 options = '<option value=""></option>';
// //                                alert('ola');
//                                 for (var c = 0; c < j.length; c++) {
// //                                    console.log(j);
//                                     options += '<option value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';


//                                 }


//                                 $('#riscos option').remove();
//                                 $('#riscos').append(options);
//                                 $("#riscos").trigger("chosen:updated");

//                             });

//                             $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioaso', {funcao: $('#funcao').val(), empresa: $('#convenio1').val(), setor: $('#setor').val()}, function (j) {
//                                 options = '<option value=""></option>';
// //                                     console.log(j);
//                                 for (var c = 0; c < j.length; c++) {
//                                     options += '<option selected value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';

//                                 }
// //                            $('#procedimento1').html(options).show();
//                                 $('#procedimento1 option').remove();
//                                 $('#procedimento1').append(options);
//                                 $("#procedimento1").trigger("chosen:updated");
// //                                    $('.carregando').hide();
//                             });


                    $('#consulta').change(function () {

                        if ($('#consulta :selected').val() === "particular") {

                            coordenadorparticular();

                            $('#divcoordenador').show();
                            $('#convenio1').hide();
                            $('#convenio2').show();
                            $('#setor').hide();
                            $('#setor2').show();
                            $('#funcao').hide();
                            $('#funcao2').show();
                            $("#convenio1").prop('required', false);
                            $("#setor").prop('required', false);
                            $("#funcao").prop('required', false);


                            $.getJSON('<?= base_url() ?>ambulatorio/guia/listarriscos', {setor: $('#setor').val()}, function (j) {

                                options = '<option value=""></option>';
//                                alert('ola');
                                for (var c = 0; c < j.length; c++) {
//                                    console.log(j);
                                    options += '<option value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';


                                }


                                $('#riscos option').remove();
                                $('#riscos').append(options);
                                $("#riscos").trigger("chosen:updated");

                            });
<? if (count($convenioid) > 0) { ?>
                                var aso = <?= $convenioid[0]->convenio_id ?>;
<? } else { ?>
                                alert('Não existe um convênio padrão associado para o Particular.')
                                var aso = '';
<? }
?>

                            $.getJSON('<?= base_url() ?>cadastros/convenio/listarprocedimentossetores', {empresa: aso}, function (j) {
                                options = '<option value=""></option>';

                                for (var c = 0; c < j.length; c++) {

                                    options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].nome + '</option>';


                                }


                                $('#procedimento1 option').remove();
                                $('#procedimento1').append(options);
                                $("#procedimento1").trigger("chosen:updated");

                            });
//             


                        } else {
//                            coordenador();

                            $('#divcoordenador').hide();
                            $('#convenio2').hide();
                            $('#convenio1').show();
                            $('#setor2').hide();
                            $('#setor').show();
                            $('#funcao2').hide();
                            $('#funcao').show();

                            $.getJSON('<?= base_url() ?>autocomplete/riscofuncaomt2', {funcao: $('#funcao').val(), empresa: $('#convenio1').val(), setor: $('#setor').val()}, function (j) {
                                options = '<option value=""></option>';
//                                alert('ola');
                                for (var c = 0; c < j.length; c++) {

                                    if (risco.indexOf(parseInt(j[c].aso_risco_id)) > -1) {
                                        options += '<option selected value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';
                                    } else {
                                        options += '<option value="' + j[c].aso_risco_id + '">' + j[c].descricao_risco + '</option>';
                                    }

                                }


                                $('#riscos option').remove();
                                $('#riscos').append(options);
//                                $("#riscos_teste").trigger("listz:updated");
                                $("#riscos").trigger("chosen:updated");
//                                $('.carregando').hide();
                            });

                            $.getJSON('<?= base_url() ?>autocomplete/procedimentoconvenioaso', {funcao: $('#funcao').val(), empresa: $('#convenio1').val(), setor: $('#setor').val()}, function (j) {
                                options = '<option value=""></option>';
//                                     console.log(j);
                                for (var c = 0; c < j.length; c++) {
                                    options += '<option selected value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + '</option>';

                                }
//                            $('#procedimento1').html(options).show();
                                $('#procedimento1 option').remove();
                                $('#procedimento1').append(options);
                                $("#procedimento1").trigger("chosen:updated");
//                                    $('.carregando').hide();
                            });



                        }
                    });


</script>
