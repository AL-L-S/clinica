<div class="content"> <!-- Inicio da DIV content -->
<!--    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>-->
    <div id="accordion">
        <h3 class="singular"><a href="#">Grupos Cadastrados</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarformapagamentoplanoconvenio/<?= $convenio_id ?>" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Grupo de Pagamento*</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="convenio" id="convenio" value="<?= $convenio_id ?>"/>
                        <select name="grupopagamento_id" id="grupopagamento_id" class="size4" required>
                            <option value="">Selecione</option>
                            <? foreach ($formapagamento_grupo as $value) { ?>
                                <option value="<?= $value->financeiro_grupo_id ?>" ><?= $value->nome ?></option>
                            <? } ?> 
                        </select>
                    </dd>
                    
                   

                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
        <? if(count($formas) > 0 ) {?>
            <h3 class="singular"><a href="#">Grupo de Pagamentos Cadastrados</a></h3>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Grupo de Pagamento</th>
                            <th class="tabela_header"><center>Detalhes</center></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($formas as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01"; ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->grupopagamento; ?></td>
                                <td class="<?php echo $estilo_linha; ?>">  
                                    <center>
                                        <a onclick="javascript: return confirm('Deseja realmente exlcuir essa Forma de Pagamento?');" href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirformapagamentoplanoconvenio/<?= $item->convenio_grupopagamento_id ?>/<?= $convenio_id ?>/<?= $item->grupo_pagamento_id ?>">Excluir</a>
                                    </center>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
        <?}?>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

</script>