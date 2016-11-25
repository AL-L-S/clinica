<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Conferencia</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatorioexame">
                <dl>
                    <dt>
                    <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size2">
                            <option value='0' >TODOS</option>
                            <option value="" >CONVENIOS</option>
                            <option value="-1" >PARTICULARES</option>
                            <? foreach ($convenio as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Grupo Convenio</label>
                    </dt>
                    <dd>
                        <select name="grupoconvenio" id="convenio" class="size2">
                            <option value='0' >TODOS</option>
                            <? foreach ($grupoconvenio as $value) : ?>
                                <option value="<?= $value->convenio_grupo_id; ?>" ><?php echo $value->nome; ?></option>
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
                            <option value='1' >SEM RM/TOMOGRAFIA</option>
                            <? foreach ($grupo as $value) : ?>
                                <option value="<?= $value->nome; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>
                    </dd>
                    <dt>
                    <label>Procedimento</label>
                    </dt>
                    <dd>
                        <select name="procedimentos" id="procedimentos" class="size1" >
                            <option value='0' >TODOS</option>
                            <? foreach ($procedimentos as $value) : ?>
                                <option value="<?= $value->procedimento_tuss_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>
                    </dd>
                    <dt>
                    <label>Classificacao</label>
                    </dt>
                    <dd>
                        <select name="classificacao" id="classificacao" class="size1" >
                            <option value='0' >Data</option>
                            <option value='1' >Nome</option>
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
                    <label>Tipo</label>
                    </dt>
                    <dd>
                        <select name="tipo" id="tipo" class="size2">
                            <option value='0' >TODOS</option>
                            <option value="" >CONSULTA / RETORNO</option>
                            <option value="-1" >CONSULTA / EXAMES</option>
                            <? foreach ($classificacao as $value) : ?>
                                <option value="<?= $value->tuss_classificacao_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Ra&ccedil;a / Cor</label>
                    </dt>
                    <dd>
                        <select name="raca_cor" id="txtRacaCor" class="size2">
                            <option value=0 >TODOS</option>
                            <option value=-1 >Sem o Ind&iacute;gena</option>
                            <option value=1 >Branca</option>
                            <option value=2 >Amarela</option>
                            <option value=3 >Preta</option>
                            <option value=4 >Parda</option>
                            <option value=5>Ind&iacute;gena</option>
                        </select>
                    </dd>
                    <dt>
                    <dt>
                    <label>Medico</label>
                    </dt>
                    <dd>
                        <select name="medico" id="medico" class="size2">
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