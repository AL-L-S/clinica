<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/agenda">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Horario Fixo</a></h3>
        <div>
            <form name="form_horarioagenda" id="form_horarioagenda" action="<?= base_url() ?>ambulatorio/agenda/gravarhorarioagenda" method="post">

                <dl class="dl_desconto_lista">
                    <dd>
                        <input type="hidden" id="txthorariostipoID" name="txtagendaID" value="<?= $agenda_id; ?>" />
                    </dd>
                </dl> 
                <table>
                    <tr>
                        <th>Dia</th>
                        <th>Inicio</th>
                        <th>Fim</th>
                        <th>Inicio intervalo</th>
                        <th>Fim do intervalo</th>
                        <th>Tempo consulta</th>
                        <th>QTDE consulta</th>
                        <th>Empresa</th>
                    </tr>
                    <tr>
                        <td>                
                            <select name="txtDia" id="txtData" class="size1">
                                <option value=""></option>
                                <option value="1 - Segunda">1 - Segunda</option>
                                <option value="2 - Terça">2 - Terça</option>
                                <option value="3 - Quarta">3 - Quarta</option>
                                <option value="4 - Quinta">4 - Quinta</option>
                                <option value="5 - Sexta">5 - Sexta</option>
                                <option value="6 - Sabado">6 - Sabado</option>
                                <option value="7 - Domingo">7 - Domingo</option>
                            </select>
                        </td>
                        <td><input type="text"  id="txthoraEntrada1" name="txthoraEntrada1" alt="time" class="size1" /></td>
                        <td><input type="text"  id="txthoraSaida1" name="txthoraSaida1" alt="time" class="size1" /></td>
                        <td><input type="text"  id="txtIniciointervalo" name="txtIniciointervalo" alt="time" value="00:00" class="size1" /></td>
                        <td><input type="text"  id="txtFimintervalo" name="txtFimintervalo" alt="time" value="00:00" class="size1" /></td>
                        <td><input type="text"  id="txtTempoconsulta" name="txtTempoconsulta" class="size1" /></td>
                        <td><input type="text"  id="txtQtdeconsulta" name="txtQtdeconsulta" value="0" class="size1" /></td>
                        <td>                
                            <select name="empresa" class="size2" required>
                                <option value="" ></option>
                                <? foreach ($empresas as $row) : ?>
                                    <option value="<?= $row->empresa_id ?>"
                                    <?
//                                    $empresa_id = $this->session->userdata('empresa_id');
//                                    if ($empresa_id == $row->empresa_id): echo 'selected';
//                                    endif;
                                    ?>><?= $row->nome ?></option> 
                                        <? endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table>    
                <br/><br/>
                <table>
                    <tr>
                        <td>
                            <textarea rows="2" cols="50" placeholder="obs..." value="" name="obs"></textarea>
                        </td>
                    </tr>
                </table>
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
        $("#data_ficha").datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(document).ready(function () {
        jQuery('#form_horarioagenda').validate({
            rules: {
                txtDia: {
                    required: true
                },
                txthoraEntrada1: {
                    required: true
                },
                txthoraSaida1: {
                    required: true
                },
                txtIniciointervalo: {
                    required: true
                },
                txtFimintervalo: {
                    required: true
                },
                txtTempoconsulta: {
                    required: true
                },
                txtQtdeconsulta: {
                    required: true
                }
            },
            messages: {
                txtDia: {
                    required: "*"
                },
                txthoraEntrada1: {
                    required: "*"
                },
                txthoraSaida1: {
                    required: "*"
                },
                txtIniciointervalo: {
                    required: "*"
                },
                txtFimintervalo: {
                    required: "*"
                },
                txtTempoconsulta: {
                    required: "*"
                },
                txtNome: {
                    required: "*"
                },
                txtQtdeconsulta: {
                    required: "*"
                }
            }
        });
    });

</script>