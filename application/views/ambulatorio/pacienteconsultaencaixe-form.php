<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravapacienteconsultaencaixe" method="post">
        <fieldset>
            <legend>Dados do paciente</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
            </div>


            <div>
                <label>Nascimento</label>


                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
            </div>

            <div>

                <label>Idade</label>
                <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

            </div>

            <div>
                <label>Nome da M&atilde;e</label>


                <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
            </div>
                        <div>
                <label>Sexo</label>
                <select name="sexo" id="txtSexo" class="size2">
                    <option value="M" <?
                    if ($paciente['0']->sexo == "M"):echo 'selected';
                    endif;
                    ?>>Masculino</option>
                    <option value="F" <?
                    if ($paciente['0']->sexo == "F"):echo 'selected';
                    endif;
                    ?>>Feminino</option>
                </select>
            </div>
        </fieldset>
        <fieldset>

            <legend>Manter Consultas</legend>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" class="size1"  />
                <input type="hidden" name="txtpaciente_id"  value="<?= $paciente_id; ?>" />
            </div>
                        <div>
                <label>Horarios</label>
                <input type="text" id="horarios" alt="time" class="size1" name="horarios" />
            </div>
            <div>
                <label>Medico</label>
                <select name="medico" id="medico" class="size4">
                    <option value="" >Selecione</option>
                    <? foreach ($medico as $item) : ?>
                        <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                    <? endforeach; ?>
                </select>
            </div>

            <div>
                <label>Observa&ccedil;&otilde;es</label>
                <input type="text" id="observacoes" class="size3" name="observacoes" />
            </div>
            </fieldset>
            <button type="submit" name="btnEnviar">Adicionar</button>
    </form>



</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


                            $(function() {
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
                            $(function() {
                                $("#txtNascimento").datepicker({
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


                            $(document).ready(function() {
                                jQuery('#form_exametemp').validate({
                                    rules: {
                                        data_ficha: {
                                            required: true
                                        },
                                        horarios: {
                                            required: true,
                                            minlength: 5
                                        }
                                    },
                                    messages: {
                                        data_ficha: {
                                            required: "*"
                                        },
                                        horarios: {
                                            required: "*",
                                            minlength: "!"
                                        }
                                    }
                                });
                            });


</script>
