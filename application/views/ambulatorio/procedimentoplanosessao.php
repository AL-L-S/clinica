<div class="content"> <!-- Inicio da DIV content -->
<!--    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>-->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastrar Sessão</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarprocedimentoconveniosessao/<?= $convenio_id ?>" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Sessão Inicial*</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="procedimento_convenio_id" id="convenio" value="<?= $convenio_id ?>"/>
                        <input type="number" min="1" <?=(@$procedimento[0]->qtde > 0)? "max='{$procedimento[0]->qtde}'": "max='1'"; ?> required name="numero_sessao_ini" id="convenio" value=""/>
                        
                        
                    </dd>
                    <dt>
                        <label>Sessão Final*</label>
                    </dt>
                    <dd>
                        <input type="number" min="1" <?=(@$procedimento[0]->qtde > 0)? "max='{$procedimento[0]->qtde}'": "max='1'"; ?> required name="numero_sessao_fim" id="convenio" value=""/>
                        
                        
                    </dd>
                    <dt>
                        <label>Valor Sessão*</label>
                    </dt>
                    <dd>
                        <input type="text" required alt="decimal" name="valor_sessao" id="convenio" value=""/>
                        
                        
                    </dd>
                    
                   

                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
        <? if(count($sessao) > 0 ) {?>
            <h3 class="singular"><a href="#">Sessões Cadastradas</a></h3>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th class="tabela_header">Sessão</th>
                            <th class="tabela_header">Valor</th>
                            <th class="tabela_header"><center>Detalhes</center></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?
                        $estilo_linha = "tabela_content01";
                        foreach ($sessao as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01"; ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->sessao; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= number_format($item->valor_sessao, 2, ",", ".");; ?></td>
                                <td class="<?php echo $estilo_linha; ?>">  
                                    <center>
                                        <a onclick="javascript: return confirm('Deseja realmente exlcuir essa sessão?');" href="<?= base_url() ?>ambulatorio/procedimentoplano/excluirprocedimentoplanoconveniosessao/<?= $item->procedimento_convenio_sessao_id ?>/<?= $item->procedimento_convenio_id ?>">Excluir</a>
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