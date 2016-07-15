<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Procedimento</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/procedimento/gerarelatorioprocedimento">
                <dl>
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
                            <option value='ECOCARDIOGRAMA'>ECOCARDIOGRAMA</option>
                            <option value='ELETROCARDIOGRAMA'>ELETROCARDIOGRAMA</option>
                            <option value='ELETROENCEFALOGRAMA'>ELETROENCEFALOGRAMA</option>
                            <option value='ESPIROMETRIA'>ESPIROMETRIA</option>
                            <option value='FISIOTERAPIA'>FISIOTERAPIA</option>
                            <option value='LABORATORIAL'>LABORATORIAL</option>
                            <option value='MAMOGRAFIA'>MAMOGRAFIA</option>
                            <option value='RM'>RM</option>
                            <option value='RX'>RX</option>
                            <option value='US'>US</option>
                        </select>
                    </dd>
                 </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
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