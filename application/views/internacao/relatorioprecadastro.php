<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatório Pré-Cadastro</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>internacao/internacao/gerarelatorioprecadastro">
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
                        <label>Tipo de Dependência</label>
                    </dt>
                    <? $dependencia = $this->internacao_m->listartipodependenciaquestionario(); ?>
                    <dd>
                        <select name="tipo_dependencia" id="tipo_dependencia" class="size2" >
                            <option value=''>TODOS</option>
                            <?php
                            foreach ($dependencia as $item) {
                                ?>
                                <option value="<?php echo $item->internacao_tipo_dependencia_id; ?>">

                                    <?php echo $item->nome; ?>
                                </option>
                                <?php
                            }
                            ?> 
                        </select>
                    </dd>
                    <dt>
                        <label>Aceita Tratamento</label>
                    </dt>

                    <dd>
                        <select name="aceita_tratamento" id="aceita_tratamento" class="size2" >
                            <option value=''>TODOS</option>
                            <option value='SIM'>Sim</option>
                            <option value='NAO'>Não</option>

                        </select>
                    </dd>
                    <dt>
                        <label>Indicação</label>
                    </dt>

                    <dd>
                        <select name="indicacao" id="indicacao" class="size2">
                            <option value=''>TODOS</option>
                            <?php
                            $indicacao = $this->paciente->listaindicacao();
                            foreach ($indicacao as $item) {
                                ?>
                                <option value="<?php echo $item->paciente_indicacao_id; ?>">

                                    <?php echo $item->nome; ?>
                                </option>
                                <?php
                            }
                            ?> 
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
                        <label>Município</label>
                    </dt>

                    <dd>
                        <input type="hidden" id="txtCidadeID" class="texto_id" name="cidade" value="" readonly="true" />
                        <input type="text" id="txtCidade"  name="txtCidade" value=""  />
                    </dd>

                    <dt>
                        <label>Ligação Confirmada</label>
                    </dt>

                    <dd>
                        <select name="confirmado" id="confirmado" class="size2" >
                            <option value=''>TODOS</option>
                            <option value='t'>Sim</option>
                            <option value='f'>Não</option>

                        </select>
                    </dd>
                    <dt>
                        <label>Aprovado</label>
                    </dt>

                    <dd>
                        <select name="aprovado" id="aprovado" class="size2" >
                            <option value=''>TODOS</option>
                            <option value='t'>Sim</option>
                            <option value='f'>Não</option>

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