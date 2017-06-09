
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Multifuncao Exame Recep&ccedil;&atilde;o</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            ?>
            <table>
                <thead>
                <form method="get" action="<?= base_url() ?>ambulatorio/exame/listarmultifuncao">

                    <tr>
                        <th class="tabela_title">Salas</th>
                        <th class="tabela_title">SITUA&Ccedil;&Atilde;O</th>
                        <th class="tabela_title">Data</th>
                        <th colspan="2" class="tabela_title">Nome</th>
                    </tr>
                    <tr>
                        <th class="tabela_title">
                            <select name="sala" id="sala" class="size2">
                                <option value=""></option>
                                <? foreach ($salas as $value) : ?>
                                    <option value="<?= $value->exame_sala_id; ?>" <?
                                    if (@$_GET['sala'] == $value->exame_sala_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <select name="situacao" id="situacao" class="size2">
                                <option value=""></option>
                                <option value="LIVRE">VAGO</option>
                                <option value="OK">OCUPADO</option>
                            </select>
                        </th>
                        <th class="tabela_title">
                            <input type="text"  id="data" alt="date" name="data" class="size1"  value="<?php echo @$_GET['data']; ?>" />
                        </th>
                        <th colspan="3" class="tabela_title">
                            <input type="text" name="nome" class="texto06 bestupper" value="<?php echo @$_GET['nome']; ?>" />
                        </th>
                        <th colspan="3" class="tabela_title">
                            <button type="submit" id="enviar">Pesquisar</button>
                        </th>

                    </tr>
                </form>
                </thead>
            </table>
            <?
           
            ?>
            <table>
                <thead id="teste">
                    <tr>
                        <th class="tabela_header" width="250px;">Nome</th>
                        <th class="tabela_header" width="70px;">Resp.</th>
                        <th class="tabela_header" width="70px;">Agenda</th>
                        <th class="tabela_header" width="150px;">Sala</th>
                        <th class="tabela_header">Telefone</th>
                        <th class="tabela_header" width="250px;">Observa&ccedil;&otilde;es</th>
                        <th class="tabela_header" colspan="3"><center>A&ccedil;&otilde;es</center></th>
                </tr>
                </thead>

                <tbody>

                <tfoot>
                    <tr>

                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">

    $(function () {
        $("#data").datepicker({
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
//        $(document).ready(function () {
//            if ($(this).val()) {
//                $('.carregando').show();
        $.getJSON('<?= base_url() ?>autocomplete/listarhorariosmultiempresa', {convenio1: '2123'}, function (j) {
            options = '';
            estilo = 'tabela_content01';
            for (var c = 0; c < j.length; c++) {


                options += '<tr>';
                options += '<td class=' + estilo + '>' + j[c].id + '</td>';
                options += '</tr>';
//                        alert(j[c].id);
                if (estilo == 'tabela_content01') {
                    estilo = 'tabela_content02';
                } else {
                    estilo = 'tabela_content01';
                }
            }

            $('#teste').html(options).show();
//                    $('.carregando').hide();
//            alert(options);
            $(function () {
                $("#accordion").accordion();
            });
            ;
        });

//            } else {
//                $('#procedimento1').html('<option value="">Selecione</option>');
//            }
//        });
    });

    $(function () {
        $("#accordion").accordion();
    });

</script>
