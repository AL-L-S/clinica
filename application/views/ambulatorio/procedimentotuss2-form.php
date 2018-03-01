<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Procedimento TUSS</a></h3>
        <div>
            <form name="form_procedimento" id="form_procedimento" action="<?= base_url() ?>ambulatorio/procedimento/gravartuss" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" class="size10"/>
                    </dd>
                    <dt>
                    <label>Codigo</label>
                    </dt>
                    <dd>
                        <input type="text" name="procedimento" id="procedimento" class="size04"/>
                    </dd>
                    <dt>
                    <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" alt="decimal" name="txtvalor" class="texto02"/>
                    </dd>
                    <dt>
                    <label>Valor Brasíndice</label>
                    </dt>
                    <dd>
                        <input type="text" alt="decimal" name="txtvalorbri" class="texto02" value=""/>
                    </dd>
                    <dt>
                    <label>Descricao do Porte</label>
                    </dt>
                    <dd>
                        <select id="descricaoporte" name="descricaoporte">
                            <option value="">Selecione</option>
                            <option>01A</option>
                            <option>05C</option>
                            <option>10B</option>
                            <option>01B</option>
                            <option>06A</option> 
                            <option>10C</option>
                            <option>01C</option>
                            <option>06B</option>
                            <option>11A</option>
                            <option>02A</option>
                            <option>06C</option>
                            <option>11B</option>
                            <option>02B</option>
                            <option>07A</option>
                            <option>11C</option>
                            <option>02C</option>
                            <option>07B</option>
                            <option>12A</option>
                            <option>03A</option>
                            <option>07C</option>
                            <option>12B</option>
                            <option>03B</option>
                            <option>08A</option>
                            <option>12C</option>
                            <option>03C</option>
                            <option>08B</option>
                            <option>13A</option>
                            <option>04A</option>
                            <option>08C</option>
                            <option>13B</option>
                            <option>04B</option>
                            <option>09A</option>
                            <option>13C</option>
                            <option>04C</option>
                            <option>09B</option>
                            <option>14A</option>
                            <option>05A</option>
                            <option>09C</option>
                            <option>14B</option>
                            <option>05B</option>
                            <option>10A</option>
                            <option>14C</option>
                        </select>
                    </dd>
                    <dt>
                    <label>Valor Porte</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtvalorporte" alt="decimal" class="texto02" value=""/>
                    </dd>
                    <dt>
                    <label>Classificaco</label>
                    </dt>
                    <dd>

                        <select name="classificaco" id="classificaco" class="size2" >
                            <option value='' >Selecione</option>
                            <?php foreach ($classificacao as $item) { ?>
                                <option value="<?php echo $item->tuss_classificacao_id; ?>" ><?php echo $item->nome; ?></option>
                            <?php } ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Grupo (Apenas pra Mat/Med)</label>
                    </dt>
                    <dd>

                        <select name="grupo" id="grupo" class="size2" >
                            <option value="" >Selecione</option>
                            <option value="MATERIAL">MATERIAL</option>
                            <option value="MEDICAMENTO">MEDICAMENTO</option>
                            
                        </select>
                    </dd>
                    <dt>
                    <label>Texto</label>
                    </dt>
                    <div>
                        <textarea id="laudo" name="laudo" rows="10" cols="60" style="width: 80%"></textarea>
                    </div>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $("#accordion").accordion();
    });

    $(function() {
        $("#txtprocedimentolabel").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=procedimentotuss",
            minLength: 3,
            focus: function(event, ui) {
                $("#txtprocedimentolabel").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#txtprocedimentolabel").val(ui.item.value);
                $("#txtprocedimento").val(ui.item.id);
                $("#txtcodigo").val(ui.item.codigo);
                $("#txtdescricao").val(ui.item.descricao);
                return false;
            }
        });
    });

    $(document).ready(function() {
        jQuery('#form_procedimento').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtprocedimentolabel: {
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
                grupo: {
                    required: "*"
                }
            }
        });
    });

</script>