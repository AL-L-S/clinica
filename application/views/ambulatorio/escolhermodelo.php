<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Procedimento</a></h3>
        <div>
            <form name="form_procedimento" id="form_procedimento" action="<?= base_url() ?>ambulatorio/guia/impressaodeclaracao/<?=$paciente_id?>/<?=$guia_id?>/<?=$exames_id?>" method="post">
                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <select name="modelo" id="modelo" class="size2" >
                            <option value='' >Selecione</option>
                            <? foreach ($modelos as $modelo) { ?>                                
                                <option value='<?= $modelo->ambulatorio_modelo_declaracao_id ?>'>
                                    <?= $modelo->nome ?></option>
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
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>