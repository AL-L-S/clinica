<div class="content"> <!-- Inicio da DIV content -->
<!--    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ambulatorio/procedimentoplano">
            Voltar
        </a>
    </div>-->

    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastrar Pagamento</a></h3>
        <div>
            <form name="form_procedimento" id="form_procedimento" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarformapagamentoprocedimento" method="post">  
                <input type="hidden" name="procedimento_convenio_id" id="procedimento_convenio_id" value="<?= $procedimento_convenio_id; ?>" />

                <div>
                    <? if(@$permissoes[0]->ajuste_pagamento_procedimento == 't'){ ?>
                        <dl class="dl_cadastro_teto dt">
                        <dt>
                            <label>Ajuste</label>
                        </dt>
                        <dd>
                            <input type="text" alt="decimal" class="texto02" name="ajuste" id="ajuste" value="<?=@$formasAssociadas[0]->ajuste?>"/>
                        </dd>
                        <br>
                    <? } ?>
                    
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2" class="tabela_header">Forma de Pagamento</td>
                                <td colspan="1" class="tabela_header">Ativar?</td>
                            </tr>
                        </thead>
                        <?
                        $ativos = array();
                        $ajustes = array();
                        foreach($formasAssociadas as $value){
                            @$ativos[$value->forma_pagamento_id] = true;
                            @$ajustes[$value->forma_pagamento_id] = $value->ajuste;
                        }
                        
                        $estilo_linha = "tabela_content01";
                        foreach ($forma_pagamento as $item) {
                            if(isset($ativos[$item->forma_pagamento_id])){
                                $ajuste = (float) $ajustes[$item->forma_pagamento_id];
                                $checked = true;
                            }
                            else{
                                $ajuste = 0;
                                $checked = false;
                            }
                            $ajuste = number_format($ajuste, 2, ",", "");
                            
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";?>
                            <tr>
                                <td colspan="2" class="<?php echo $estilo_linha; ?>"><?=$item->nome?></td>
                                <td colspan="1" class="<?php echo $estilo_linha; ?>">
                                    <input type="hidden" name="cartao[<?=$item->forma_pagamento_id?>]" id="cartao<?=$item->forma_pagamento_id?>" value="<?= $item->cartao;?>"/>
                                    <input type="checkbox" name="ativar[<?=$item->forma_pagamento_id?>]" id="ativar<?=$item->forma_pagamento_id?>" <?if ($checked) echo "checked";?>/>
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                    </table>
                </div>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $("#txtpagamento").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentoformapagamento",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtpagamento").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtpagamento").val(ui.item.value);
                $("#txtpagamentoid").val(ui.item.id);
                return false;
            }
        });
    });

    $(document).ready(function () {
        jQuery('#form_procedimento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtprocedimentolabel: {
                    required: true
                },
                txtperc_medico: {
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
                txtperc_medico: {
                    required: "*"
                },
                grupo: {
                    required: "*"
                }
            }
        });
    });

</script>