<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/bottons.css"
    <div class="content">
    <?if(!isset($unidades)) {echo "<p class='unidade_vazia'>Não há unidades criadas.</p>";}
    else {?>
        <select name="condicao" style="display: block">
            <option onclick="javascript:window.location.href=('<?= base_url()?>internacao/internacao/pacientesinternados/Todas');">Selecione    </option></a>
            <option onclick="javascript:window.location.href=('<?= base_url()?>internacao/internacao/pacientesinternados/Vago');">Vago</option>
            <option onclick="javascript:window.location.href=('<?= base_url()?>internacao/internacao/pacientesinternados/Ocupado');">Ocupado</option></a>
            <option onclick="javascript:window.location.href=('<?= base_url()?>internacao/internacao/pacientesinternados/Manutencao');">Manutencao</option></a>
            <option onclick="javascript:window.location.href=('<?= base_url()?>internacao/internacao/pacientesinternados/Higienizacao');">Higienizacao</option></a>
            <option onclick="javascript:window.location.href=('<?= base_url()?>internacao/internacao/pacientesinternados/Fechado');">Fechado</option></a>
        </select>
        <br/>
        <?foreach ($unidades as $item) { ?>
        <div style="min-width: 200px; padding:10px; border: 1px solid rgba(0,0,0,.2); border-radius: 5px; background-color: rgba(0,0,0,.2); box-shadow: 1px 1px 1px 0.1px; margin:10px;">
        <a onclick="javascript:window.open('<?= base_url() ?>internacao/internacao/mostraenfermarialeito/<?= $item->internacao_unidade_id ?>','toolbar=no,Location=no,menubar=no,width=500,height=200');"
           style="display: block; text-align: center; font-size: 17px; cursor: pointer;">
            <? echo $item->nome; ?>
        </a>
        </div>
        <? }}?>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
//  function popup(internacao_id){ window.open('<?= base_url() ?>internacao/internacao/mostraenfermarialeito/'+internacao_id,'popup','width=800,height=600,scrolling=auto,top=0,left=0') }
</script> 

