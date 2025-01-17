<?$relatorios_clinica_med = $this->session->userdata('relatorios_clinica_med');?>
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio orçamentos</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/exame/gerarelatorioorcamentos">
                <dl>
                    <dt>
                        <label> Nome / CPF</label>
                    </dt>
                    <dd>
                        <input type="text" name="nome" class="texto04" value="<?php echo @$_GET['nome']; ?>" />
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
                        <label>Grupo</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size2">
                            <? foreach ($grupos as $value) : ?>
                                <option value="<?= $value->nome; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="" selected="">TODOS</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Status</label>
                    </dt>
                    <dd>
                        <select name="status" id="status" class="size2">
                            <option value="">TODOS</option>
                            <option value="0">REALIZADO</option>
                            <option value="1">PENDENTE</option>
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
                    <? if ($relatorios_clinica_med != 't'){ ?>
                    <dt>
                        <label>Buscar por</label>
                    </dt>
                    <dd>
                        <select name="tipo_orcamento" id="tipo_orcamento" class="size2">
                            <option value="">TODOS</option>
                            <option value="0">PRÉ-CADASTROS</option>
                            <option value="1">CLIENTES</option>
                        </select>
                    </dd>
                    <? } ?>
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

</script>