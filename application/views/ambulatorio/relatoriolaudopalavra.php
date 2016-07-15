<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Laudo Palavra chave</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriolaudopalavra">
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
                    <label>Palavra Chave</label>
                    </dt>
                    <dd>
                        <input type="text" name="palavra" id="palavra" class="size10"/>
                    </dd>
                    <dt>
                    <label>Especialidade</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size2" >
                            <option value='0' >TODOS</option>
                            <option value='1' >SEM RM</option>
                            <option value='US'>US</option>
                            <option value='RM'>RM</option>
                            <option value='MAMOGRAFIA'>MAMOGRAFIA</option>
                            <option value='RX'>RX</option>
                            <option value='DENSITOMETRIA'>DENSITOMETRIA</option>
                            <option value='AUDIOMETRIA'>AUDIOMETRIA</option>
                            <option value='ELETROCARDIOGRAMA'>ELETROCARDIOGRAMA</option>
                            <option value='ESPIROMETRIA'>ESPIROMETRIA</option>

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
<script type="text/javascript">
    $(function() {
        $( "#txtdata_inicio" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    
    $(function() {
        $( "#txtdata_fim" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });


    $(function() {
        $( "#accordion" ).accordion();
    });

</script>