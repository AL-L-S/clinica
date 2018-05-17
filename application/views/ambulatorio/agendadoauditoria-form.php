<meta charset="UTF-8">
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Detalhe</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/exame/gravarpacientedetalhes" method="post">
                <fieldset>

                    <table border="1">
                        <thead>
                            <tr>
                                <th class="tabela_header">Descricao</th>
                                <th class="tabela_header">Situacao</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            foreach ($guia as $item) :
                                ?>
                                <tr>
                                    <td width="400px;">Operador agenda</td>
                                    <td width="150px;"><?= $item->operadorcadastro ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Data agenda</td>
                                    <td width="150px;"><?= substr($item->datacadastro, 8, 2) . "-" . substr($item->datacadastro, 5, 2) . "-" . substr($item->datacadastro, 0, 4) ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Operador do Agendamento</td>
                                    <td width="150px;"><?= $item->operadoratualizacao ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Data do Agendamento</td>
                                    <td width="150px;"><?= substr($item->data_atualizacao, 8, 2) . "-" . substr($item->data_atualizacao, 5, 2) . "-" . substr($item->data_atualizacao, 0, 4) ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Hora do Agendamento</td>
                                    <td width="150px;"><?= date("H:i:s", strtotime(str_replace("/", "-", $item->data_atualizacao))) ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Operador autorizacao</td>
                                    <td width="150px;"><?= $item->operadorautorizacao ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Data autorizacao</td>
                                    <td width="150px;"><?= substr($item->data_autorizacao, 8, 2) . "-" . substr($item->data_autorizacao, 5, 2) . "-" . substr($item->data_autorizacao, 0, 4) ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Operador Confirmação (Telefonema)</td>
                                    <td width="150px;"><?= $item->operador_telefonema ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Data Confirmação (Telefonema)</td>
                                    <td width="150px;"><?= substr($item->data_telefonema, 8, 2) . "-" . substr($item->data_telefonema, 5, 2) . "-" . substr($item->data_telefonema, 0, 4) ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Medico Solicitante</td>
                                    <td width="150px;"><?= $item->medico ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Medico Executante</td>
                                    <td width="150px;"><?= $item->operadorautorizacao ?></td>
                                </tr>
                                <tr>
                                    <td width="400px;">Operador Bloqueio</td>
                                    <td width="150px;"><?= @$item->operador_bloqueio ?></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>

                    <hr/>
                    <h3 class="singular">Cancelamentos</h3>
                    <table border="1">
                        <thead>
                            <tr>
                                <th class="tabela_header">Paciente</th>
                                <th class="tabela_header">Operador</th>
                                <th class="tabela_header">Data</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?
                            foreach ($exclusao as $item) :
                                ?>
                                <tr>
                                    <td width="400px;"><?= $item->paciente ?></td>
                                    <td width="400px;"><?= $item->operador_exclusao ?></td>
                                    <td width="200px;"><?=date("d/m/Y H:i:s", strtotime($item->data_cadastro));?></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript">
    (function ($) {
        $(function () {
            $('input:text').setMask();
        });
    })(jQuery);

</script>