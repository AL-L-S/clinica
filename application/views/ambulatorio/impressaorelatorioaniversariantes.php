<div class="content">
    <meta charset="utf-8"> 
    <!--Inicio da DIV content--> 
    <? if (count($empresa) > 0) { ?>
        <h4><?= $empresa[0]->razao_social; ?></h4>
    <? } else { ?>
        <h4>TODAS AS CLINICAS</h4>
    <? } ?>
    <h4>Aniversariantes</h4>
    <h4>PERÍODO INICIAL: <?= $txtdata_inicio; ?></h4>
    <h4>PERÍODO FINAL: <?= $txtdata_fim; ?></h4>

    <hr>
    <? if (count($relatorio) > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Data De Nascimento</th>
                    <th class="tabela_header"><font size="-1">Nome</th>
                    <th class="tabela_header"><font size="-1">Email</th>
                    <th class="tabela_header"><font size="-1">Telefone/Celular</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $email = '';
                foreach ($relatorio as $item) :
                    ?>
                    <tr>
                        <td><font size="-2"><?= substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4); ?></td>
                        <td><font size="-2"><?= $item->paciente; ?></td>
                        <td><font size="-2">
                            <?php
                            echo $item->cns;
                            if (isset($item->cns) && $item->cns != '') {
                                $email = $email . $item->cns . ', ';
                            }
                            ?>
                        </td>
                        <td><font size="-2"><?= utf8_decode($item->telefone) . " / " . utf8_decode($item->celular); ?></td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
        <?
    } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>
        <br>
        <br>
    <?
    if ($mala_direta == true) {
        ?>

        <h3 style="display: inline">Mala Direta</h3> <span><button class="btn">Copiar Texto</button></span>
        <div id="mala_direta">
            <?
            echo "<p>" . $email . "</p>";
            ?>
        </div>
    <? } ?>
       

</div>

<!-- Final da DIV content -->
<!--<meta http-equiv="content-type" content="text/html;charset=utf-8" />-->
<!--<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">-->
<style>
    #mala_direta{
        width: 600pt;
        border: 1px solid black;
        background-color: #ecf0f1;
        word-wrap: break-word;
        max-height: 200pt;
        overflow-y: auto;
    }
</style>
    <script type="text/javascript" src="<?= base_url() ?>js/clipboard/dist/clipboard.js" ></script>
    <script>
    var clipboard = new Clipboard('.btn', {
        text: function() {
            return document.getElementById('mala_direta').textContent;
        }
    });

    clipboard.on('success', function(e) {
        alert('Copiado Com Sucesso!');
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });
    </script>

