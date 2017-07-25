<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <!--<div id="accordion">-->
        <h3 class="singular"><a href="#">Cadastro de Lembrete</a></h3>
        <div style="width: 100%">
            <form action="<?= base_url() ?>ambulatorio/empresa/gravarlembrete/<?= $empresa_lembretes_id ?>" method="post">
                <fieldset >
                    <table>
                        <tr>
                            <td>
                                <label style="font-size: 10pt; color: black">Operador</label>
                            </td>
                            <td>
                                <select name="operador_id" id="operador_id" class="size2" required="">
                                    <option value='' >Selecione</option>
                                <? foreach ($operadores as $value) : ?>
                                    <option value="<?= $value->operador_id; ?>" 
                                        <? // if (@$_GET['operador_id'] == $value->operador_id) echo 'selected' ?>>
                                            <?php echo $value->nome; ?>
                                    </option>
                                <? endforeach; ?>
                                </select>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <label style="font-size: 10pt; color: black">Lembrete</label>
                            </td>
                            <td>
                                <textarea  type="text" name="descricao" id="descricao" class="textarea" cols="70" rows="1" ><?= @$obj->_descricao_procedimento; ?> </textarea>
                            </td>
                        </tr>

                    </table>    

                    <hr/>
                    <button type="submit" name="btnEnviar">Enviar</button>
                    <button type="reset" name="btnLimpar">Limpar</button>
                </fieldset>
                <!--<button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>-->
            </form>
        </div>
    <!--</div>-->
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#rev').change(function () {
        if(this.checked){
            var tag = '<span>Dias</span><input type="text" alt="integer" name="dias" id="dias" required/>';
            $(".dias").append(tag);
        }
        else{
            $(".dias span").remove();
            $(".dias input").remove();
        }
    });


    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $("#txtprocedimentolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentotuss",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtprocedimentolabel").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtprocedimentolabel").val(ui.item.value);
                $("#txtprocedimento").val(ui.item.id);
                $("#txtcodigo").val(ui.item.codigo);
                $("#txtdescricao").val(ui.item.descricao);
                return false;
            }
        });
    });

    $(document).ready(function () {
        jQuery('#form_procedimento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtprocedimentolabel: {
                    required: true
                },
                txtperc_medico: {
                    required: true
                },
                grupo: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtprocedimentolabel: {
                    required: "*"
                },
                txtperc_medico: {
                    required: "*"
                },
                grupo: {
                    required: "*"
                }
            }
        });
    });

</script>