<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Bloqueio / Altera&ccedil;&otilde;s</a></h3>
        <div>
            <form name="form_medicoagenda" id="form_medicoagenda" action="<?= base_url() ?>ambulatorio/agenda/gravarmedicoconsulta" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>A&ccedil;&atilde;o</label>
                    </dt>
                    <dd>
                        <select name="txtacao" size="1" class="texto03" id="teste"  >
                            <option value="Bloquear">Bloquear</option>
                            <option value="Alterarmedico">Alterar medico</option>
                            <option value="Excluir">Excluir hor&aacute;rios</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Medico</label>
                    </dt>
                    <dd>
                        <?
                        $operador_id = $this->session->userdata('operador_id');
                        $perfil_id = $this->session->userdata('perfil_id');
                        ?>
                        <select name="medico" id="medico" class="size2">
                            <option value=""></option>
                            <?
                            foreach ($medicos as $value) {
                                if (($value->operador_id == $operador_id && $perfil_id == 4) || $perfil_id != 4) {
                                    ?>
                                    <option value="<?= $value->operador_id; ?>"><?php echo $value->nome; ?></option>
                                    <?
                                }
                            }
                            ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Salas</label>
                    </dt>
                    <dd>
                        <select name="sala" id="sala" class="size2">
                            <option value=""></option>
                            <? foreach ($salas as $value) : ?>
                                <option value="<?= $value->exame_sala_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text"  id="datainicio" name="datainicio" class="size1"/>
                    </dd>
                    <dt>
                        <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text"  id="datafim" name="datafim" class="size1"/>
                    </dd>
                    <dt>
                        <label>Hora inicio</label>
                    </dt>
                    <dd>
                        <input type="text" alt="time" id="horainicio" name="horainicio" class="size1"/>
                    </dd>
                    <dt>
                        <label>Hora fim</label>
                    </dt>
                    <dd>
                        <input type="text" alt="time" id="horafim" name="horafim" class="size1"/>
                    </dd>
                    <dt>
                        <label>Observacao</label>
                    </dt>
                    <dd>
                        <textarea type="text" name="txtobservacao" cols="55" class="texto12"></textarea>
                    </dd>
                    <br>
                    <div id="chk_desc_inss">
                        <input type="checkbox" name="txtsegunda" /><label>Segunda</label>
                        <input type="checkbox" name="txtterca" /><label>Terca</label>
                        <input type="checkbox" name="txtquarta" /><label>Quarta</label>
                        <input type="checkbox" name="txtquinta" /><label>Quinta</label>
                        <input type="checkbox" name="txtsexta" /><label>Sexta</label>
                        <input type="checkbox" name="txtsabado" /><label>Sabado</label>
                        <input type="checkbox" name="txtdomingo" /><label>Domingo</label>
                    </div>

                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function () {
        $("#datainicio").datepicker({
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
        $("#datafim").datepicker({
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

    $(document).ready(function () {
        jQuery('#form_medicoagenda').validate({
            rules: {
                medico: {
                    required: true
                },
                datainicio: {
                    required: true
                },
                datafim: {
                    required: true
                },
                horainicio: {
                    required: true
                },
                horafim: {
                    required: true
                }
            },
            messages: {
                medico: {
                    required: "*"
                },
                datainicio: {
                    required: "*"
                },
                datafim: {
                    required: "*"
                },
                horainicio: {
                    required: "*"
                },
                horafim: {
                    required: "*"
                }
            }
        });
    });

</script>