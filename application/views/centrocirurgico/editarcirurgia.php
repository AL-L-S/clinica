<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->      
    <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravareditarcirurgia" method="post">
        <fieldset>
            <legend>Outras Opções</legend>
            <div class="bt_link"><a  href="<?= base_url() ?>centrocirurgico/centrocirurgico/cadastrarequipeguiacirurgicasolicitacao/<?= @$solicitacao[0]->solicitacao_cirurgia_id; ?>/<?= $solicitacao[0]->guia_id; ?>">Equipe</a></div>
            <div class="bt_link"><a  href="<?= base_url() ?>centrocirurgico/centrocirurgico/editarprocedimentoscirurgia/<?= @$solicitacao[0]->solicitacao_cirurgia_id; ?>/<?= $solicitacao[0]->guia_id; ?>">Procedimentos</a></div>
            <div class="bt_link"><a  href="<?= base_url() ?>centrocirurgico/centrocirurgico/carregarsolicitacaomaterial/<?= @$solicitacao[0]->solicitacao_cirurgia_id; ?>/<?= $solicitacao[0]->guia_id; ?>">Material</a></div>
        </fieldset>
        <fieldset >
            <legend>Dados da Solicitacao</legend>

            <div>
                <label>Paciente</label>
                <input type="hidden" id="txtsolcitacao_id" class="texto_id" name="txtsolcitacao_id" readonly="true" value="<?= @$solicitacao_id; ?>" />
                <input type="hidden" id="txtNomeid" class="texto_id" name="txtNomeid" readonly="true" value="<?= @$solicitacao[0]->paciente_id; ?>" />
                <input type="text" id="txtNome" required name="txtNome" class="texto10" value="<?= @$solicitacao[0]->paciente; ?>" readonly="true"/>
            </div>

            <div>
                <label>Telefone</label>
                <input type="text" id="telefone" class="texto02" name="telefone" value="<?= @$solicitacao[0]->telefone; ?>" readonly="true"/>
            </div>

            <div>
                <label>Solicitante</label>
                <input type="text"  id="solicitante" class="texto02" name="solicitante" value="<?= @$solicitacao[0]->solicitante; ?>" readonly="true"/>
            </div>

            <div>
                <label>Convenio</label>
                <input type="text"  id="convenio" class="texto02" name="convenio" value="<?= @$solicitacao[0]->convenio; ?>" readonly="true"/>
            </div>

            <div>
                <label>Hospital</label>
                <input type="text"  id="hospital" class="texto02" name="hospital" value="<?= @$solicitacao[0]->hospital; ?>" readonly="true"/>
            </div>

        </fieldset>

        <fieldset>
            <legend>Editar Cirurgia</legend>
            
            
            <fieldset>
                <div>
                    <label>Data Cirurgia</label>
                    <input type="text" name="txtdata" id="txtdata" alt="date" class="texto02" value="<? if (@$solicitacao[0]->data_prevista != '') {
    echo date("d/m/Y", strtotime(@$solicitacao[0]->data_prevista));
} ?>" required/>
                </div>
                <div>
                    <label>Hora Inicio</label>
                    <input type="text" name="hora" id="hora" alt="99:99" class="texto02" value="<? if (@$solicitacao[0]->hora_prevista != '') {
    echo date("H:i", strtotime(@$solicitacao[0]->hora_prevista));
} ?>" required/>
                </div>
                <div>
                    <label>Hora Fim</label>
                    <input type="text" name="hora_fim" id="hora_fim" alt="99:99" class="texto02" value="<? if (@$solicitacao[0]->hora_prevista_fim != '') {
    echo date("H:i", strtotime(@$solicitacao[0]->hora_prevista_fim));
} ?>" required/>
                </div>
                <!--                <div>
                                    <label>Desconto (%)</label>
                                    <input type="number" id="desconto" name="desconto" value="0" step="0.01" min="0" required=""/>
                                </div>-->
                <!--                <div>
                                    <label>Forma Pagamento</label>
                                    <select name="formapamento" id="formapamento" class="size2">
                                        <option value="">Selecione</option>
                <?
                foreach ($forma_pagamento as $item) :
                    if ($item->forma_pagamento_id == 1000)
                        continue;
                    ?>
                                                <option value="<?= $item->forma_pagamento_id; ?>"><?= $item->nome; ?></option>
<? endforeach; ?>
                                    </select>
                                </div>-->
            </fieldset>

<!--            <fieldset>
                <legend>Via</legend>
                <div id="via">
                    <input <? if (@$solicitacao[0]->via == 'M') {
    echo 'checked';
} ?> type="radio" name="via" id="m" value="M" required/> <label for="m">Mesma Via</label>
                    <input <? if (@$solicitacao[0]->via == 'D') {
    echo 'checked';
} ?> type="radio" name="via" id="d" value="D" required/> <label for="d">Via Diferente</label>
                </div>
            </fieldset>-->



            <hr/>

            <button type="submit" name="btnEnviar">Enviar</button>
            <button type="reset" name="btnLimpar">Limpar</button>
        </fieldset>

    </form>
</div> <!-- Final da DIV content -->
<style>
    div#via label { color: black; font-weight: bolder; font-size: 12pt; }
    div#via label, div#via input{ display: inline-block; }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    $(function () {
        $("#txtdata").datepicker({
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
        $('#valor').blur(function () {

        });
    });


</script>
