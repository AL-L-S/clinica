<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <fieldset>
        <legend>Cadastrar Orçamento</legend>
        <div>
            <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarsolicitacaorcamento" method="post">
                <div style="padding-bottom: 50px;">
                    <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="<?= @$solicitacao_id; ?>"/>
                    <div>
                        <label>Cirurgião *</label>
                        <input type="text" name="cirurgiao1" id="cirurgiao1" class="texto06"/>
                        <input type="text" name="cirurgiao1id" id="cirurgiao1id" class="texto01"/>
                        <input type="text" id="txtNome" name="txtNome" class="texto10"/>
                    </div>                   

                </div>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </fieldset>
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

//    $(function () {
//        $("#cirurgiao1").autocomplete({
//            source: "<?= base_url() ?>index.php?c=autocomplete&m=centrocirurgicomedicos",
//            minLength: 1,
//            focus: function (event, ui) {
//                $("#cirurgiao1").val(ui.item.label);
//                return false;
//            },
//            select: function (event, ui) {
//                $("#cirurgiao1").val(ui.item.nome);
//                $("#solicitacao_id").val(ui.item.id);
//                return false;
//            }
//        });
//    });

    $(function () {
        $("#cirurgiao1").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=centrocirurgicomedicos",
            minLength: 1,
            focus: function (event, ui) {
                console.log(event);
                $("#cirurgiao1").val(ui.item.nome);
                return false;
            },
            select: function (event, ui) {
                $("#cirurgiao1").val(ui.item.nome);
                $("#cirurgiao1id").val(ui.item.id);
                return false;
            }
        });
    });

    $(function () {
        $("#txtNome").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtNome").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtNome").val(ui.item.value);
                $("#txtNomeid").val(ui.item.id);
                $("#telefone").val(ui.item.itens);
                $("#nascimento").val(ui.item.valor);
                $("#txtEnd").val(ui.item.endereco);
                return false;
            }
        });
    });

</script>
