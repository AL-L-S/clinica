<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Censo Diário</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>internacao/internacao/gerarelatoriocensodiario">
                <dl>
                    <dt>
                        <label>Unidade</label>
                    </dt>
                    <? $unidade = $this->unidade_m->listaunidadepacientes(); ?>
                    <dd>
                        <select name="unidade" id="unidade" class="size2" >
                            <option value=''>TODOS</option>
                            <?php
                            foreach ($unidade as $item) {
                                ?>
                                <option value="<?php echo $item->internacao_unidade_id; ?>">

                                    <?php echo $item->nome; ?>
                                </option>
                                <?php
                            }
                            ?> 
                        </select>
                    </dd>

                    <dt>
                        <label>Enfermaria</label>
                    </dt>
                    <? $enfermaria = $this->enfermaria_m->listaenfermariarelatorio(); ?>
                    <dd>
                        <select name="enfermaria" id="enfermaria" class="size2" >
                            <option value=''>TODOS</option>
                            <?php
                            foreach ($enfermaria as $item) {
                                ?>
                                <option value="<?php echo $item->internacao_enfermaria_id; ?>">

                                    <?php echo $item->nome; ?>
                                </option>
                                <?php
                            }
                            ?> 
                        </select>
                    </dd>

                    <dt>
                        <label>Status</label>
                    </dt>

                    <dd>
                        <select name="status_leito" id="status_leito" class="size2" >
                            <option value=''>TODOS</option>
                            <option value='Vago'>Vago</option>
                            <option value='Ocupado'>Ocupado</option>
                            <option value='Manutencao'>Manutenção</option>
                            <option value='Higienizacao'>Higienização</option>
                            <option value='Fechado'>Fechado</option>
                            <!--<option value='Cirurgico'>Cirurgico</option>-->
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
        $("#txtCidade").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCidade").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCidade").val(ui.item.value);
                $("#txtCidadeID").val(ui.item.id);
                return false;
            }
        });
    });

</script>