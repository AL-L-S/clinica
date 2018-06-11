<body bgcolor="#C0C0C0">
    <meta charset="UTF-8">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Mini-Curriculo</h3>
        <div>
            <fieldset>

                <table border="0">
                    <thead>
                        <tr>
                            <th align="center" class="tabela_header"><?= $guia[0]->medico ?></th>
                        </tr>
                    </thead>

                </table>
                <br>
                <!--<table>-->
                    <!--<tbody>-->
                        <!--<tr>-->
                            <!--<td align="center" colspan="5">-->
                <form method="POST">

                     <?= $guia[0]->curriculo ?>
                </form>
                <!--</td>-->
                <!--</tr>-->

                <!--</tbody>-->
                <!--</table>-->
                <hr/>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
