
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatório comparativo mensal</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriocomparativomensal">
                <dl>
                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size2">
                            <option value='0' >TODOS</option>
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>

                    <dt>
                        <label>Primeiro mês</label>
                    </dt>
                    <dd>
                        <input type="text" name="mes1_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <div>
                        <dt>
                            <label>Segundo mês</label>
                        </dt>
                        <dd  style="margin-bottom: 5pt; position: relative">
                            <input type="text" name="mes2_inicio" id="txtdata_fim" alt="date"/>
                            <input type="checkbox" name="filtro_hora" id="filtro_hora"><label for="filtro_hora">Filtrar por horario?</label>
                        </dd>
                    </div>


                    <dt>
                        <label>Data De Pesquisa</label>
                    </dt>
                    <dd>
                        <select name="data_atendimento" id="data_atendimento" class="size2" >
                            <option value='1' >DATA DE ATENDIMENTO</option>
                            <option value='0' >DATA DE FATURAMENTO</option>

                        </select>
                    </dd>
                    <dt>
                        <label>Especialidade</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size1" >
                            <option value='0' >TODOS</option>
                            <option value='1' >SEM RM/TOMOGRAFIA</option>
                            <? foreach ($grupo as $value) : ?>
                                <option value="<?= $value->nome; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>
                    </dd>


                    <dt>
                        <label>Procedimento</label>
                    </dt>
                    <dd style="margin-bottom: 5pt">
<!--                        <select name="procedimentos" id="procedimentos" class="size1" >
                            <option value='0' >TODOS</option>
                        <? foreach ($procedimentos as $value) : ?>
                                                <option value="<?= $value->procedimento_tuss_id; ?>" ><?php echo $value->nome; ?></option>
                        <? endforeach; ?>

                        </select>-->
                        <select name="procedimentos" id="procedimentos" class="size4 chosen-select" data-placeholder="Selecione" tabindex="1" required="">
                            <option value='0' >TODOS</option>
                            <? foreach ($procedimentos as $value) : ?>
                                <option value="<?= $value->procedimento_tuss_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>

                    </dd>
                    <? $subgrupo_procedimento = $this->session->userdata('subgrupo_procedimento'); ?>
                    <? if ($subgrupo_procedimento == 't') { ?>
                        <dt>
                            <label>Subgrupo</label>
                        </dt>
                        <dd style="margin-bottom: 5pt">
                            <select name="subgrupo_id" id="subgrupo_id" class="size2" data-placeholder="Selecione" tabindex="1">
                                <option value=''>Selecione</option>
                                <? foreach ($subgrupos as $value) : ?>
                                    <option value="<?= $value->ambulatorio_subgrupo_id; ?>" ><?php echo $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </dd>
                    <? } ?>

                    <dt>
                        <label>Aparecer Valor</label>
                    </dt>
                    <dd>
                        <select name="aparecervalor" id="aparecervalor" class="size1" >
                            <option value='1' >SIM</option>
                            <option value='0' >NÃO</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Faturamento</label>
                    </dt>
                    <dd>
                        <select name="faturamento" id="faturamento" class="size1" >
                            <option value='0' >TODOS</option>
                            <option value='t' >Faturado</option>
                            <option value='f' >Nao Faturado</option>
                        </select>
                    </dd>



                    <dt>
                    <dt>
                        <label>Medico</label>
                    </dt>
                    <!--                    <dd>
                                            <select name="medico" id="medico" class="size2">
                                                <option value="0">TODOS</option>
                    <? foreach ($medicos as $value) : ?>
                                                                    <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                    <? endforeach; ?>
                    
                                            </select>
                                        </dd>-->
                    <dd style="margin-bottom: 9px;">
                        <select name="medico[]" id="medico" class="chosen-select" data-placeholder="Selecione os médicos (Todos ou vázio trará todos)..." multiple>
                            <option value="0">TODOS</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>
                    </dd>

                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                            <option value="0">TODOS</option>
                        </select>
                    </dd>


                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<style>
    .chosen-container{ margin-top: 5pt;}
    #procedimento1_chosen a { width: 130px; }
    form { min-height: 550pt; }
</style>
<script type="text/javascript">


//
//    $('#medico').click(function () {
//        alert('asdasd');
//        $("#accordion").accordion();
//    });



    $(function () {
        $("#txtdata_inicio").datepicker({
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
        $("#txtdata_fim").datepicker({
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
        $("#accordion").accordion();
    });

</script>