<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td width="70">
                <div class="bt_link_new">
                    <a href="#">
                        Nova Guia Ambualtorial
                    </a>
                </div>
            </td>
            <td width="20"></td>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/exame/carregarguiacirurgica">
                        Nova Guia Cirurgica
                    </a>
                </div>
            </td>
            <td width="20"></td>
        </tr>
    </table>
    <div id="accordion">
        <h3><a href="#">Gerar relatorio Faturamento Manual</a></h3>
        <div>

            <?
            $empresa = $this->guia->listarempresas();
            $medicos = $this->operador_m->listarmedicos();
            $salas = $this->exame->listartodassalas();
            $convenios = $this->convenio->listarconvenionaodinheiro();
            $guia = "";
            ?>

            <form method="post" action="<?= base_url() ?>ambulatorio/exame/faturamentomanuallista">
                <dl>
                    <dt>
                    <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size2">
                            <option value="" >TODOS</option>
                            <? foreach ($convenios as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
<!--                    <dt>
                    <label>Medico</label>
                    </dt>
                    <dd>
                        <select name="medico" id="medico" class="size2">
                            <option value="0">TODOS</option>
                            <? // foreach ($medicos as $value) : ?>
                                <option value="<? // $value->operador_id; ?>" ><?php // echo $value->nome; ?></option>
                            <? // endforeach; ?>

                        </select>
                    </dd>-->
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
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="nome" class="texto06"/>
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