<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <fieldset>
        <legend>Copiar Procedimentos Convenio</legend>
        
        <div>
            <form name="form_convenio" id="form_convenio" action="<?= base_url() ?>cadastros/convenio/gravarconvenioempresa" method="post">



                <div>
                    <label>Convênio</label>



                    <input type="text" name="convenio_selecionado" value="<?= $convenio_selecionado[0]->nome; ?>" readonly="" />
                </div>


                <div>
                    <label>Empresa</label>
                    <select name="empresa" id="empresa" class="size4">
                        <!--<option value="">TODOS</option>-->
                        <? foreach ($empresa as $value) : ?>
                            <option value="<?= $value->empresa_id; ?>"><?php echo $value->nome; ?></option>
                        <? endforeach; ?>
                    </select>
                    <input type="hidden" name="convenio_id" value="<?= $convenioid; ?>" />
                </div>

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </fieldset>
    <fieldset>
        <div style="display: block; width: 100%;">
            <? if (count($empresa_conta) > 0) { ?>
                <table class="taxas-feitas">
                    <thead>
                        <tr>
                            <th class="tabela_header">Empresa</th>
                            <th class="tabela_header"><center>Deletar</center></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $estilo_linha = "tabela_content01";
                        foreach ($empresa_conta as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>

                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->empresa ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><center><a class="delete" href="<?= base_url() ?>cadastros/convenio/excluirconvenioempresa/<?= $item->convenio_empresa_id ?>/<?= $convenioid ?>">delete</a></center></td>
                            </tr>
                    <? } ?>
                    </tbody>
                </table>
            <? } ?> 
        </div>
    </fieldset>

</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_sala').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>