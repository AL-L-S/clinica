<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h3>Configurações Lembrete de Aniversário</h3>
    <form action="<?= base_url() ?>ambulatorio/empresa/gravarlembreteaniversario/<?= $empresa_lembretes_aniversario_id ?>" method="post">
    <fieldset>
        <legend>Lembrete de Aniversário</legend>
        <? // var_dump(@$mensagem[0]->texto);die;?>
        <textarea name="aniversario" id="aniversario" class="textarea" cols="70" rows="15" ><?= @$mensagem[0]->texto ?></textarea>
        <input type="hidden" id="empresa_id" name="empresa_id" value="<?= @$empresa_id ?>"/>

    </fieldset>
    <button type="submit" name="btnEnviar">Enviar</button>
    </form>
</div> <!-- Final da DIV content -->
<style>
    textarea{
        width: 90%;
        /*font-size: 18pt;*/
        /*height: 50pt;*/
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });
    
</script>