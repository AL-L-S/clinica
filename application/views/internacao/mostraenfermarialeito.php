    
<div class="accordion"> <!-- Inicio da DIV content -->

    <div style="position: relative; float: left;">
        <?
        foreach ($enfermaria as $valor) {
            if ($valor->ativo == 't') {
                ?>  
                <div>
                    <button class="accordion"><? echo $valor->nome; ?></button>
                    <div class="panel">
                        <ul>
                            <?
                            foreach ($leitos as $item) {
                                if ($item->enfermaria_id == $valor->internacao_enfermaria_id) {
                                    ?>
                                    <li style="display: inline-block; padding: 10px; list-style: none;"> 
                                        <? echo $item->nome; ?> <br/>
                                        <a onclick="javascript:window.open('<?= base_url() ?>internacao/internacao/mostrafichapacienteleito/<?= $item->internacao_leito_id ?>', 'toolbar=no,Location=no,menubar=no,width=500,height=200');">
                                            <img src="<?= base_url() ?>img/<?= $item->ativo === 't' ? $item->condicao . '.png' : 'Ocupado.png'; ?>"
                                                 width="25px" height="25px" style="cursor: pointer;"
                                                 title=" <?= $item->ativo === 't' ? $item->condicao : 'Ocupado'; ?> "/>
                                        </a>
                                    </li>
                                    <?
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?
            }
        }
        ?>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/accordion.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>

<script>
                            var acc = document.getElementsByClassName("accordion");
                            var i;

                            for (i = 0; i < acc.length; i++) {
                                acc[i].onclick = function () {
                                    this.classList.toggle("active");
                                    this.nextElementSibling.classList.toggle("show");
                                }
                            }
</script>