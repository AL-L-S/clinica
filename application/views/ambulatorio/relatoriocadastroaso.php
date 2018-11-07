<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Cadastro ASO</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriocadastroaso">
                <dl>
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
                        <label>Grupo de Convênio</label>
                    </dt>

                    <dd>
                        <select name="conveniogrupo" id="conveniogrupo" class="size2" >
                            <option value='' >TODOS</option>
<!--                            <option value='-1' >Não Tem</option>-->
                            <?php
                            $listaconveniogrupo = $this->grupoconvenio->listargrupoconvenios();
                            foreach ($listaconveniogrupo as $item) {
                                ?>

                                <option   value =<?php echo $item->convenio_grupo_id; ?> >
                                    <?php echo $item->nome; ?>
                                </option>

                            <? } ?> 

                        </select>
                    </dd>
                    <dt>
                        <label>Convênio</label>
                    </dt>

                    <dd>
                        <select name="convenio" id="convenio" class="size2" >
                            <option value='' >TODOS</option>
                            <option value='-1' >Não Tem</option>
                            <?php
                            $listaconvenio = $this->paciente->listaconvenio();
                            foreach ($listaconvenio as $item) {
                                ?>

                                <option   value =<?php echo $item->convenio_id; ?> >
                                    <?php echo $item->nome; ?>
                                </option>

                            <? } ?> 

                        </select>
                    </dd>
                    <dt>
                        <label>Grupo de Procedimentos</label>
                    </dt>

                    <dd>
                        <select name="gproc" id="gproc" class="size2" >
                            <option value='' >TODOS</option>
<!--                            <option value='-1' >Não Tem</option>-->
                            <?php
                            
                            foreach ($grupos as $item) {
                                ?>

                                <option value = <?php echo $item->ambulatorio_grupo_id; ?> >
                                    <?php echo $item->nome; ?>
                                </option>

                            <? } ?> 

                        </select>
                    </dd>
                    <dt>
                        <label>Procedimento</label>
                    </dt>

                    <dd>
                        <select name="procedimento" id="procedimento" class="size2" >
                            <option value='' >TODOS</option>
<!--                            <option value='-1' >Não Tem</option>-->
                            <?php
                            
                            foreach ($procedimento as $item) {
                                ?>

                                <option   value =<?php echo $item->procedimento_tuss_id; ?> >
                                    <?php echo $item->nome; ?>
                                </option>

                            <? } ?> 

                        </select>
                    </dd>
                    <dt>
                        <label>Agrupar Por</label>
                    </dt>
                    
                    <dd>
                        <select id="agrupador" name="agrupador"  class="size02" >
                                        
                    <option value="FUNCAO">
                        FUNÇÃO
                    </option>
                    <option value="SETOR">
                        SETOR
                    </option>
                    
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




    $(function () {
        $('#unidade').change(function () {
//            alert('adsdasd');
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/enfermariaunidade', {id: $(this).val(), ajax: true}, function (j) {
                    options = '<option value=""></option>';
                    console.log(j);

                    for (var c = 0; c < j.length; c++) {

                        options += '<option value="' + j[c].id + '">' + j[c].value + '</option>';

                    }
                    $('#enfermaria').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('.carregando').show();
                options = '';
                $('#enfermaria').html(options).show();
            }
        });
    });



</script>

