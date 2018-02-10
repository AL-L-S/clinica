<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Observa&ccedil;&atilde;o</h3>
        <div>
            <form name="form1" id="form1" action="<?= base_url() ?>ambulatorio/guia/gravarvalorguia/<?= $guia_id[0]->ambulatorio_guia_id ?>" method="post">
                <fieldset>
                    <table>
                        <tr>
                            <td style="text-align: left">
                                Valor da Guia

                            </td>

                        </tr>

                        <tr>

                            <td>
                                <input style="width: 150px;" type="integer" name="txtvalorguia_carregado" id="txtvalorguia_carregado" value="<?= number_format($exame[0]->total, 2, ",", ".") ?>" readonly/>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left">
                                Nota Fiscal<?php
                                if ($guia_id[0]->nota_fiscal == "t") {
                                    ?>
                                    <input type="checkbox" name="nota_fiscal" checked ="true" />
                                    <?php
                                } else {
                                    ?>
                                    <input type="checkbox" name="nota_fiscal"  />
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left">
                                Recibo <?php
                                if ($guia_id[0]->recibo == "t") {
                                    ?>
                                    <input type="checkbox" name="recibo" checked ="true" />
                                    <?php
                                } else {
                                    ?>
                                    <input type="checkbox" name="recibo" />
                                    <?php
                                }
                                ?>
                                <br>
                                <br>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: left">
                                Valor Do Recibo
                            </td>
                            <td style="text-align: left">
                                Numero Nota Fiscal
                            </td>

                        </tr>

                        <tr>

                            <td>
                                <input type="hidden" />
                                <input type="integer" style="width: 150px;" name="txtvalorguia" id="txtvalorguiainput" value="<?= number_format($exame[0]->total, 2, ",", ".") ?>" alt="decimal"/>
                            </td>
                            <td>
                                <input type="text" style="width: 150px;" name="numero_nota_fiscal" id="numero_nota_fiscal" value="<?= @$guia_id[0]->numero_nota_fiscal?>"/>
                            </td>
                        </tr>




                    </table>
                    <dl class="dl_desconto_lista">



                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar">enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/fullcalendar/lib/jquery.min.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-cookie.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-treeview.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.bestupper.min.js"  ></script>
<script type="text/javascript" src="<?= base_url() ?>js/scripts_alerta.js" ></script>
<script type="text/javascript">
    /* Máscaras ER */
    function mascara(telefone) {
        if (telefone.value.length == 0)
            telefone.value = '(' + telefone.value; //quando começamos a digitar, o script irá inserir um parênteses no começo do campo.
        if (telefone.value.length == 3)
            telefone.value = telefone.value + ') '; //quando o campo já tiver 3 caracteres (um parênteses e 2 números) o script irá inserir mais um parênteses, fechando assim o código de área.

        if (telefone.value.length == 9)
            telefone.value = telefone.value + '-'; //quando o campo já tiver 8 caracteres, o script irá inserir um tracinho, para melhor visualização do telefone.

    }


    (function ($) {
        $(function () {
            $('input:text').setMask();
        });
    })(jQuery);

</script>