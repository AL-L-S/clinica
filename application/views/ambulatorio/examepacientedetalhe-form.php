<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Paciente Detalhe</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/exame/gravarpacientedetalhes" method="post">
                <fieldset>
                    <? //echo'<pre>'; var_dump($guia[0]);die;?>
                    <dl class="dl_desconto_lista">
                        <dt>
                        <label>Nome</label>
                        </dt>
                        <dd>
                            <input type="text" name="paciente" id="paciente" class="texto01" value="<?= $guia[0]->paciente; ?>" readonly/>
                            <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" class="texto01" value="<?= $agenda_exames_id; ?>"/>
                            <input type="hidden" name="guia_id" id="guia_id" class="texto01" value="<?= $guia_id; ?>"/>
                            <input type="hidden" name="paciente_id" id="paciente_id" class="texto01" value="<?= $paciente_id; ?>"/>
                            <input type="hidden" name="procedimento_tuss_id" id="procedimento_tuss_id" class="texto01" value="<?= $procedimento_tuss_id; ?>"/>
                        </dd>
                        <dt>
                        <label>Convenio</label>
                        </dt>
                        <dd>
                            <input type="text" name="convenio" id="convenio" class="texto01" value="<?= $guia[0]->convenio; ?>" readonly/>
                        </dd>
                        <dt>
                        <label>Nascimento</label>
                        </dt>
                        <?$nascimento = substr($guia[0]->nascimento, 8, 2) . "/" . substr($guia[0]->nascimento, 5, 2) . "/" . substr($guia[0]->nascimento, 0, 4)?>
                        <dd>
                            <input type="text" name="nascimento" id="nascimento" class="texto01" value="<?= $nascimento; ?>" readonly/>
                        </dd>
                        <dt>
                        <dt>
                        <label>Medico Solic.</label>
                        </dt>
                        <dd>
                            <input type="text" name="medico" id="medico" class="texto01" value="<?= $guia[0]->medico; ?>" readonly/>
                        </dd>
                        <dt>
                        <label>Operador Respons&aacute;vel</label>
                        </dt>
                        <dd>
                            <input type="text" name="operador" id="operador" class="texto01" value="<?= $guia[0]->operadorresp; ?>" readonly/>
                        </dd>
                        <dt>
                        <label>Peso</label>
                        </dt>
                        <dd>
                            <input type="text" name="peso" id="peso" class="texto01" alt="decimal" value="<?= $guia[0]->peso; ?>"/>Kg
                        </dd>
                        <dt>
                        <label>Altura</label>
                        </dt>
                        <dd>
                            <input type="text" name="altura" id="altura" class="texto01" alt="integer" value="<?= $guia[0]->altura; ?>"/>Cm
                        </dd>
                        <dt>
                        <label>P.A. sist&oacute;lica</label>
                        </dt>
                        <dd>
                            <input type="text" name="pasistolica" id="pasistolica" class="texto01" alt="999" value="<?= $guia[0]->pasistolica; ?>"/>
                        </dd>
                        <dt>
                        <label>P.A. diast&oacute;lica</label>
                        </dt>
                        <dd>
                            <input type="text" name="padiastolica" id="padiastolica" class="texto01" alt="99" value="<?= $guia[0]->padiastolica; ?>"/>
                        </dd>
                    </dl>    
 <table border="1">
        <thead>
            <tr>
                <th class="tabela_header">Procedimento</th>
                <th class="tabela_header">status</th>
                <th class="tabela_header">Operador Respons&aacute;vel</th>
            </tr>
        </thead>
        <tbody>
            <?
            foreach ($exames as $item) :
            ?>
            <tr>
                <td width="400px;"><?= $item->procedimento ?></td>
                <td width="150px;"><?= $item->situacaolaudo ?></td>
                <td width="400px;"><?= $item->operadorresp ?></td>
            </tr>
            <? endforeach; ?>
        </tbody>
 </table>
                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
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