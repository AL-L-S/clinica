<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Lista de Relat&oacute;rio</a></h3>
        <div>
            <table>
                <thead>

                    <tr>
                        <th width="100px;" class="tabela_header">Relat&oacute;rio de Agente T&oacute;xico</th>
                        <th width="100px;" class="tabela_header">Relat&oacute;rio de Agente T&oacute;xico x Evolu&ccedil;&atilde;o</th>
                        <th width="100px;" class="tabela_header">Relat&oacute;rio de Agente T&oacute;xico x Circunst&acirc;ncia</th>
                        <th width="100px;" class="tabela_header">Relat&oacute;rio de Agente T&oacute;xico x Sexo</th>
                        <th width="100px;" class="tabela_header">Relat&oacute;rio de Agente T&oacute;xico x Zona de Ocorr&ecirc;ncia</th>
                        <th width="100px;" class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>

                <tbody>

                       <tr>
                                <td  width="100px;">
                                    <a href="<?= base_url() ?>ceatox/ceatoxrelatorio/agentetoxico">
                                        <img border="0" title="Relatorio Agente Toxico" alt="Relatorio Agente Toxico"
                                             src="<?= base_url() ?>img/form/page_white_magnify.png" />
                                    </a>
                                </td>
                                <td  width="100px;">
                                    <a href="<?= base_url() ?>ceatox/ceatoxrelatorio/agentetoxicoevolucao">
                                        <img border="0" title="Relatorio Agente Toxico x Evolucao" alt="Relatorio Agente Toxico x Evolucao"
                                             src="<?= base_url() ?>img/form/page_white_magnify.png" />
                                    </a>
                                </td>
                                <td  width="100px;">
                                    <a href="<?= base_url() ?>ceatox/ceatoxrelatorio/agentetoxicocircunstancia">
                                        <img border="0" title="Relatorio Agente Toxico x Circunstancia" alt="Relatorio Agente Toxico x Circunstancia"
                                             src="<?= base_url() ?>img/form/page_white_magnify.png" />
                                    </a>
                                </td>
                                <td  width="100px;">
                                    <a href="<?= base_url() ?>ceatox/ceatoxrelatorio/agentetoxicosexo">
                                        <img border="0" title="Relatorio Agente Toxico x Sexo" alt="Relatorio Agente Toxico x Sexo"
                                             src="<?= base_url() ?>img/form/page_white_magnify.png" />
                                    </a>
                                </td>
                                <td  width="100px;">
                                    <a href="<?= base_url() ?>ceatox/ceatoxrelatorio/agentetoxicozona">
                                        <img border="0" title="Relatorio Agente Toxico x Zona" alt="Relatorio Agente Toxico x Zona"
                                             src="<?= base_url() ?>img/form/page_white_magnify.png" />
                                    </a>
                                </td>
                        </tr>

                     </tbody>


            </table>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>
