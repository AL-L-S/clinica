<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <fieldset>
        <legend>Cadastrar Orçamento</legend>
        <div>
            <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaorcamento" method="post">
                <div style="padding-bottom: 50px;">
                    <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="<?= @$solicitacao_id; ?>"/>
                    <input type="hidden" name="convenio_id" id="convenio_id" value="<?= @$convenio_id; ?>"/>
                    <input type="hidden" name="verifica" id="verifica" value="<?= @count($verifica); ?>"/>
                    <div>
                        <label>Cirurgião</label>
                        <select name="cirurgiao1" id="cirurgiao1" class="texto04" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($medicos as $value) { ?>
                                <option value="<?= $value->operador_id ?>"
                                <?
                                if (isset($cirurgiao->operador_responsavel) && $cirurgiao->operador_responsavel == $value->operador_id) :
                                    echo 'selected';
                                endif;
                                ?>><?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                        <input type="hidden" name="cirurgiao1_id"  value="<?= @$cirurgiao->solicitacao_cirurgia_orcamento_id ?>"/>
                    </div> 
                    <div>
                        <label>Procedimento</label>
                        <select name="procedimento1" id="procedimento1" class="texto06" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($procedimentos as $value) { ?>
                                <option value="<?= $value->procedimento_tuss_id ?>"<?
                                if (isset($cirurgiao->procedimento_tuss_id) && $cirurgiao->procedimento_tuss_id == $value->procedimento_tuss_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->codigo ?> - <?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                    </div>
                    <div>
                        <label>Valor(R$)</label>
                        <input name="valor1" id="valor1" class="texto02" alt="decimal" value="<?= @$cirurgiao->valor ?>"/>
                    </div>
                    <br/>
                    <div>
                        <label>1° Auxílio</label>
                        <select name="auxilio1" id="auxilio1" class="texto04">
                            <option value="">SELECIONE</option>
                            <? foreach ($medicos as $value) { ?>
                                <option value="<?= $value->operador_id ?>"
                                <?
                                if (isset($auxilio1->operador_responsavel) && $auxilio1->operador_responsavel == $value->operador_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                        <input type="hidden" name="auxilio1_id"  value="<?= @$auxilio1->solicitacao_cirurgia_orcamento_id ?>"/>
                    </div> 
                    <div>
                        <label>Procedimento</label>
                        <select name="procedimento2" id="procedimento2" class="texto06">
                            <option value="">SELECIONE</option>
                            <? foreach ($procedimentos as $value) { ?>
                                <option value="<?= $value->procedimento_tuss_id ?>"
                                <?
                                if (isset($auxilio1->procedimento_tuss_id) && $auxilio1->procedimento_tuss_id == $value->procedimento_tuss_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->codigo ?> - <?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                    </div>
                    <div>
                        <label>Valor(R$)</label>
                        <input name="valor2" id="valor2" class="texto02" alt="decimal" value="<?= @$auxilio1->valor ?>"/>
                    </div>
                    <br/>
                    <div>
                        <label>2° Auxílio</label>
                        <select name="auxilio2" id="auxilio2" class="texto04">
                            <option value="">SELECIONE</option>
                            <? foreach ($medicos as $value) { ?>
                                <option value="<?= $value->operador_id ?>"
                                <?
                                if (isset($auxilio2->operador_responsavel) && $auxilio2->operador_responsavel == $value->operador_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                        <input type="hidden" name="auxilio2_id"  value="<?= @$auxilio2->solicitacao_cirurgia_orcamento_id ?>"/>
                    </div> 
                    <div>
                        <label>Procedimento</label>
                        <select name="procedimento3" id="procedimento3" class="texto06">
                            <option value="">SELECIONE</option>
                            <? foreach ($procedimentos as $value) { ?>
                                <option value="<?= $value->procedimento_tuss_id ?>"
                                <?
                                if (isset($auxilio2->procedimento_tuss_id) && $auxilio2->procedimento_tuss_id == $value->procedimento_tuss_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->codigo ?> - <?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                    </div>
                    <div>
                        <label>Valor(R$)</label>
                        <input name="valor3" id="valor3" class="texto02" alt="decimal" value="<?= @$auxilio2->valor ?>" />
                    </div>
                    <br/>
                    <div>
                        <label>Anestesista</label>
                        <select name="anestesista" id="anestesista" class="texto04" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($medicos as $value) { ?>
                                <option value="<?= $value->operador_id ?>"
                                <?
                                if (isset($anestesista->operador_responsavel) && $anestesista->operador_responsavel == $value->operador_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                        <input type="hidden" name="anestesista_id"  value="<?= @$anestesista->solicitacao_cirurgia_orcamento_id ?>"/>
                    </div> 
                    <div>
                        <label>Procedimento</label>
                        <select name="procedimento4" id="procedimento4" class="texto06" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($procedimentos as $value) { ?>
                                <option value="<?= $value->procedimento_tuss_id ?>"
                                <?
                                if (isset($anestesista->procedimento_tuss_id) && $anestesista->procedimento_tuss_id == $value->procedimento_tuss_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->codigo ?> - <?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                    </div>
                    <div>
                        <label>Valor(R$)</label>
                        <input name="valor4" id="valor4" class="texto02" alt="decimal" value="<?= @$anestesista->valor ?>"/>
                    </div>
                    <br/>
                    <div>
                        <label>Cirurgião 2</label>
                        <select name="cirurgiao2" id="cirurgiao2" class="texto04">
                            <option value="">SELECIONE</option>
                            <? foreach ($medicos as $value) { ?>
                                <option value="<?= $value->operador_id ?>"
                                <?
                                if (isset($cirurgiao2->operador_responsavel) && $cirurgiao2->operador_responsavel == $value->operador_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                        <input type="hidden" name="cirurgiao2_id"  value="<?= @$cirurgiao2->solicitacao_cirurgia_orcamento_id ?>"/>
                    </div> 
                    <div>
                        <label>Procedimento</label>
                        <select name="procedimento5" id="procedimento5" class="texto06">
                            <option value="">SELECIONE</option>
                            <? foreach ($procedimentos as $value) { ?>
                                <option value="<?= $value->procedimento_tuss_id ?>"
                                <?
                                if (isset($cirurgiao2->procedimento_tuss_id) && $cirurgiao2->procedimento_tuss_id == $value->procedimento_tuss_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->codigo ?> - <?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                    </div>
                    <div>
                        <label>Valor(R$)</label>
                        <input name="valor5" id="valor5" class="texto02" alt="decimal" value="<?= @$cirurgiao2->valor ?>" />
                    </div>
                    <br/>
                    <div>
                        <label>Cirurgião 3</label>
                        <select name="cirurgiao3" id="cirurgiao3" class="texto04">
                            <option value="">SELECIONE</option>
                            <? foreach ($medicos as $value) { ?>
                                <option value="<?= $value->operador_id ?>"
                                <?
                                if (isset($cirurgiao3->operador_responsavel) && $cirurgiao3->operador_responsavel == $value->operador_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                        <input type="hidden" name="cirurgiao3_id"  value="<?= @$cirurgiao3->solicitacao_cirurgia_orcamento_id ?>"/>
                    </div> 
                    <div>
                        <label>Procedimento</label>
                        <select name="procedimento6" id="procedimento6" class="texto06">
                            <option value="">SELECIONE</option>
                            <? foreach ($procedimentos as $value) { ?>
                                <option value="<?= $value->procedimento_tuss_id ?>"
                                <?
                                if (isset($cirurgiao3->procedimento_tuss_id) && $cirurgiao3->procedimento_tuss_id == $value->procedimento_tuss_id) :
                                    echo 'selected';
                                endif;
                                ?>
                                        ><?= $value->codigo ?> - <?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                    </div>
                    <div>
                        <label>Valor(R$)</label>
                        <input name="valor6" id="valor6" class="texto02" alt="decimal" value="<?= @$cirurgiao3->valor ?>"/>
                    </div>
                    <br/>
                    <div style="margin-top: 20px;">
                        <textarea rows="5" cols="60" placeholder="obs..." name="obs"></textarea>
                    </div>
                </div>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </fieldset>
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

    $(function () {
        $('#procedimento1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalororcamento', {procedimento1: $(this).val(), convenio: $("#convenio_id").val()}, function (j) {
                    options = "";
                    options += j[0].valortotal;
//                    b = options.toPrecision(2);
                    document.getElementById("valor1").value = options.replace(".", ",");
                    $('.carregando').hide();
                });
            } else {
                $('#valor1').html('value=""');
            }
        });
    });

    $(function () {
        $('#procedimento2').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalororcamento', {procedimento1: $(this).val(), convenio: $("#convenio_id").val()}, function (j) {
                    options = "";
                    options += j[0].valortotal;
//                    b = options.toPrecision(2);
                    document.getElementById("valor2").value = options.replace(".", ",");
                    $('.carregando').hide();
                });
            } else {
                $('#valor2').html('value=""');
            }
        });
    });

    $(function () {
        $('#procedimento3').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalororcamento', {procedimento1: $(this).val(), convenio: $("#convenio_id").val()}, function (j) {
                    options = "";
                    options += j[0].valortotal;
//                    b = options.toPrecision(2);
                    document.getElementById("valor3").value = options.replace(".", ",");
                    $('.carregando').hide();
                });
            } else {
                $('#valor3').html('value=""');
            }
        });
    });

    $(function () {
        $('#procedimento4').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalororcamento', {procedimento1: $(this).val(), convenio: $("#convenio_id").val()}, function (j) {
                    options = "";
                    options += j[0].valortotal;
//                    b = options.toPrecision(2);
                    document.getElementById("valor4").value = options.replace(".", ",");
                    $('.carregando').hide();
                });
            } else {
                $('#valor4').html('value=""');
            }
        });
    });
</script>
