<link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
<BODY >
    <?  $texto = strtr(strtoupper($laudo['0']->texto),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");?>
    <p ><?= $laudo['0']->texto; ?></p>

    
</BODY >




