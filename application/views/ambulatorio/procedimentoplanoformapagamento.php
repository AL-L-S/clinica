<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastrar Pagamento</a></h3>
        <div>
            <form name="form_procedimento" id="form_procedimento" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarformapagamentoplanoconvenio/<?= $convenio_id ?>" method="post">
                <div>
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2" class="tabela_header">Forma de Pagamento</td>
                                <td colspan="1" class="tabela_header">Ativar?</td>
                                <? if(@$permissoes[0]->ajuste_pagamento_procedimento == 't'){ ?>
                                    <td colspan="1" class="tabela_header">Ajuste</td>
                                <? } ?>
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
                                    <input type="checkbox" name="ativar[<?=$item->forma_pagamento_id?>]" id="ativar<?=$item->forma_pagamento_id?>" <?if ($checked) echo "checked";?>/>
                                </td>
                                
                                <? if(@$permissoes[0]->ajuste_pagamento_procedimento == 't'){ ?>
                                    <td colspan="1" class="<?php echo $estilo_linha; ?>">
                                        <input type="text" alt="decimal" class="texto02" name="ajuste[<?=$item->forma_pagamento_id?>]" id="ajuste<?=$item->forma_pagamento_id?>" value="<?=$ajuste?>"/>
                                    </td>
                                <? } ?>
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

    $(function () {
        $("#accordion").accordion();
    });

</script>
