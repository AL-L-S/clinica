<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Medico convenio Previsao</a></h3>
        <div>
            <form name="form_paciente" id="form_paciente"  method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriomedicoconvenioprevisaofinanceiro">
                <dl>
                    <dt>
                    <label>Medico</label>
                    </dt>
                    <dd>
                        <select name="medicos" id="medicos" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size2">
                            <option value='0' >TODOS</option>
                            <option value="" >SEM PARTICULAR</option>
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <dt>
                    <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                    </dd>
                    <dt>
                    <label>Especialidade</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size1" >
                            <option value='0' >TODOS</option>
                            <option value='1' >SEM RM</option>
                            <option value='AUDIOMETRIA'>AUDIOMETRIA</option>
                            <option value='CONSULTA'>CONSULTA</option>
                            <option value='DENSITOMETRIA'>DENSITOMETRIA</option>
                            <option value='ELETROCARDIOGRAMA'>ELETROCARDIOGRAMA</option>
                            <option value='ESPIROMETRIA'>ESPIROMETRIA</option>
                            <option value='ECOCARDIOGRAMA'>ECOCARDIOGRAMA</option>
                            <option value='FISIOTERAPIA'>FISIOTERAPIA</option>
                            <option value='LABORATORIAL'>LABORATORIAL</option>
                            <option value='MAMOGRAFIA'>MAMOGRAFIA</option>
                            <option value='RM'>RM</option>
                            <option value='RX'>RX</option>
                            <option value='US'>US</option>
                            <option value='TOMOGRAFIA'>TOMOGRAFIA</option>
                        </select>
                    </dd>
                    <dt>
                    <label>Clinica</label>
                    </dt>
                    <dd>
                        <select name="clinica" id="clinica" class="size1" >
                            <option value='SIM' >SIM</option>
                            <option value='NAO' >NAO</option>
                        </select>
                    </dd>
                    <dt>
                    <label>Solicitante</label>
                    </dt>
                    <dd>
                        <select name="solicitante" id="solicitante" class="size1" >
                            <option value='SIM' >SIM</option>
                            <option value='NAO' >NAO</option>
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
                    <dt>
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


                    $(document).ready(function() {
                        jQuery('#form_paciente').validate({
                            rules: {
                                txtdata_inicio: {
                                    required: true
                                },
                                txtdata_fim: {
                                    required: true
                                },
                                producao: {
                                    required: true
                                }

                            },
                            messages: {
                                txtdata_inicio: {
                                    required: "*"
                                },
                                txtdata_fim: {
                                    required: "*"
                                },
                                producao: {
                                    required: "*"
                                }
                            }
                        });
                    });
                    
                        $(function() {
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

    $(function() {
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
                    
    $(function() {
        $("#accordion").accordion();
    });

</script>