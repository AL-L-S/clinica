<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">ALTERACAO</h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/guia/fecharprocedimentonota/<? // $verificado['0']->agenda_exames_id;      ?>" method="post">
                <fieldset>

                    <table border="1" style="border-width:2px;  
                           border-style:solid;">
                        <tr>
                            <th>PROCEDIMENTO</th>
                            <th>FORMA DE PAGAMENTO</th>
                        </tr>

                        <? foreach ($procedimento as $value) { ?>


                            <tr>
                                <td><font size="-1"><?= $value->procedimento; ?></td>
                                <td><font size="-1"><?
                                    echo $value->forma_pagamento;
                                    if ($value->forma_pagamento_2 != '') {
                                        echo '<br>';
                                        echo $value->forma_pagamento_2;
                                    }
                                    if ($value->forma_pagamento_2 != '') {
                                        echo '<br>';
                                        echo $value->forma_pagamento_3;
                                    }
                                    if ($value->forma_pagamento_2 != '') {
                                        echo '<br>';
                                        echo $value->forma_pagamento_3;
                                    }
                                    ?></td>
                            </tr>

                            <!--                        <dl class="dl_desconto_lista">
                                                        <dt>
                                                            <label>PROCEDIMENTO</label>
                                                        </dt>
                                                        <dd>
                                                            <input type="text" name="valor2" class="texto01" value="<?= $value->procedimento; ?>" readonly/>
                                                        </dd>
                                                        <dt>
                                                            <label>FORMA DE PAGAMENTO</label>
                                                        </dt>
                                                        <dd>
                                                            <input type="text" name="valor3" class="texto03" value="" readonly/>
                                                        </dd>
                                                    </dl>    -->
<? } ?>
                    </table>
                    <hr/>
                    <button type="submit" name="btnEnviar">OK</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });


</script>