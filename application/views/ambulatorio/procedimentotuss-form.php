<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Procedimento TUSS</a></h3>
        <div>
            <form name="form_procedimento" id="form_procedimento" action="<?= base_url() ?>ambulatorio/procedimento/gravartuss" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" class="size10" value="<?= $procedimento[0]->descricao; ?>" />
                        <input type="hidden" name="tuss_id" value="<?= $procedimento[0]->tuss_id; ?>" />
                    </dd>
                    <dt>
                    <label>Codigo</label>
                    </dt>
                    <dd>
                        <input type="text" name="procedimento" id="procedimento" class="size04" value="<?= $procedimento[0]->codigo; ?>"/>
                    </dd>
                    <dt>
                    <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtvalor" alt="decimal" class="texto02" value="<?= $procedimento[0]->valor; ?>"/>
                    </dd>
                    <dt>
                    <label>Valor Brasíndice</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtvalorbri" alt="decimal" class="texto02" value="<?= $procedimento[0]->valor_bri; ?>"/>
                    </dd>
                    <dt>
                    <label>Descricao do Porte</label>
                    </dt>
                    <dd>
                        <select id="descricaoporte" name="descricaoporte" required="">
                            <option value="">Selecione</option>
                            <option value="01A" <? if("01A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>01A</option>
                            <option value="05C" <? if("05C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>05C</option>
                            <option value="10B" <? if("10B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>10B</option>
                            <option value="01B" <? if("01B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>01B</option>
                            <option value="06A" <? if("06A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>06A</option> 
                            <option value="10C" <? if("10C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>10C</option>
                            <option value="01C" <? if("01C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>01C</option>
                            <option value="06B" <? if("06B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>06B</option>
                            <option value="11A" <? if("11A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>11A</option>
                            <option value="02A" <? if("02A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>02A</option>
                            <option value="06C" <? if("06C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>06C</option>
                            <option value="11B" <? if("11B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>11B</option>
                            <option value="02B" <? if("02B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>02B</option>
                            <option value="07A" <? if("07A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>07A</option>
                            <option value="11C" <? if("11C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>11C</option>
                            <option value="02C" <? if("02C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>02C</option>
                            <option value="07B" <? if("07B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>07B</option>
                            <option value="12A" <? if("12A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>12A</option>
                            <option value="03A" <? if("03A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>03A</option>
                            <option value="07C" <? if("07C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>07C</option>
                            <option value="12B" <? if("12B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>12B</option>
                            <option value="03B" <? if("03B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>03B</option>
                            <option value="08A" <? if("08A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>08A</option>
                            <option value="12C" <? if("12C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>12C</option>
                            <option value="03C" <? if("03C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>03C</option>
                            <option value="08B" <? if("08B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>08B</option>
                            <option value="13A" <? if("13A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>13A</option>
                            <option value="04A" <? if("04A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>04A</option>
                            <option value="08C" <? if("08C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>08C</option>
                            <option value="13B" <? if("13B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>13B</option>
                            <option value="04B" <? if("04B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>04B</option>
                            <option value="09A" <? if("09A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>09A</option>
                            <option value="13C" <? if("13C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>13C</option>
                            <option value="04C" <? if("04C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>04C</option>
                            <option value="09B" <? if("09B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>09B</option>
                            <option value="14A" <? if("14A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>14A</option>
                            <option value="05A" <? if("05A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>05A</option>
                            <option value="09C" <? if("09C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>09C</option>
                            <option value="14B" <? if("14B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>14B</option>
                            <option value="05B" <? if("05B" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>05B</option>
                            <option value="10A" <? if("10A" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>10A</option>
                            <option value="14C" <? if("14C" == @$procedimento[0]->porte_descricao){ echo "selected"; }?>>14C</option>
                        </select>
                    </dd>
                    <dt>
                    <label>Valor Porte</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtvalorporte" alt="decimal" class="texto02" value="<?= $procedimento[0]->valor_porte; ?>"/>
                    </dd>
                    <dt>
                    <label>Classificaco</label>
                    </dt>
                    <dd>

                        <select name="classificaco" id="classificaco" class="size2" >
                            <option value='' >Selecione</option>
                            <?php foreach ($classificacao as $item) { ?>
                                <option value="<?php echo $item->tuss_classificacao_id; ?>" <?if ($item->tuss_classificacao_id ==  $procedimento[0]->classificacao):echo 'selected'; endif;?>><?php echo $item->nome; ?></option>
                            <?php } ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Grupo (Apenas pra Mat/Med)</label>
                    </dt>
                    <dd>

                        <select name="grupo" id="grupo" class="size2" >
                            <option value="" >Selecione</option>
                            <option value="MATERIAL" <?if($procedimento[0]->grupo_matmed == 'MATERIAL'){ echo 'selected';}?>>MATERIAL</option>
                            <option value="MEDICAMENTO" <?if($procedimento[0]->grupo_matmed == 'MEDICAMENTO'){ echo 'selected';}?>>MEDICAMENTO</option>
                            
                        </select>
                    </dd>
                    <dt>
                    <label>Texto</label>
                    </dt>
                    <div>
                        <textarea id="laudo" name="laudo" rows="10" cols="60" style="width: 80%"><?= $procedimento[0]->texto; ?></textarea>
                    </div>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $("#accordion").accordion();
    });

    $(function() {
        $("#txtprocedimentolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentotuss",
            minLength: 3,
            focus: function(event, ui) {
                $("#txtprocedimentolabel").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtprocedimentolabel").val(ui.item.value);
                $("#txtprocedimento").val(ui.item.id);
                $("#txtcodigo").val(ui.item.codigo);
                $("#txtdescricao").val(ui.item.descricao);
                return false;
            }
        });
    });

    $(document).ready(function() {
        jQuery('#form_procedimento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtprocedimentolabel: {
                    required: true
                },
                grupo: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtprocedimentolabel: {
                    required: "*"
                },
                grupo: {
                    required: "*"
                }
            }
        });
    });

</script>