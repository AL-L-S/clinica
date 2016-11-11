<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Detalhe</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/exame/gravarpacientedetalhes" method="post">
                <fieldset>

                    <table border="1">
                        <thead>
                            <tr>
                                <th class="tabela_header">Criador da agenda</th>
                                <th class="tabela_header">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            foreach ($guia as $item) :
                                ?>
                                <tr>
                                    <td width="400px;"><?= $item->operadorcadastro ?></td>
                                    <td width="150px;"><?= substr($item->datacadastro, 8, 2) . "-" . substr($item->datacadastro, 5, 2) . "-" . substr($item->datacadastro, 0, 4)?></td>
                                </tr>
                            <? endforeach; ?>
                        </tbody>
                    </table>
                    <hr/>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript">
    (function($) {
        $(function() {
            $('input:text').setMask();
        });
    })(jQuery);

</script>