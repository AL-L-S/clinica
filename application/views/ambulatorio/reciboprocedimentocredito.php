<meta charset="UTF-8">
<p><center>Recibo</center></p>
<p>
<p><center>N° CRÉDITO: <?= @$paciente_credito_id; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VALOR:# <?= @$credito[0]->valor; ?> &nbsp;#</center></p>
<p>
<p>Recebi de <?= utf8_decode(@$credito[0]->paciente); ?>, a importância de <?= $credito[0]->valor; ?> (<?= @$extenso; ?>) referente a uma entrada de crédito</p>
<p>Recebimento atraves de: <?= @$credito[0]->forma_pagamento; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<p align="right"><span style="text-transform: uppercase"><?= $credito[0]->municipio; ?></span>, <?= substr(@$credito[0]->data_cadastro, 8, 2) . "/" . substr(@$credito[0]->data_cadastro, 5, 2) . "/" . substr(@$credito[0]->data_cadastro, 0, 4) . " "; ?><?= substr(@$credito[0]->data_cadastro, 11, 5); ?></p>
<p>Procedimento: <?= @$credito[0]->procedimento; ?></p>
<br>
<h4><center>___________________________________________</center></h4>

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    window.print()
</script>