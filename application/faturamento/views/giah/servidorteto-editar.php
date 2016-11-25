<div class="content"> <!-- Inicio da DIV content -->
    <?php $this->load->view("giah/snippets/servidor-detalhe"); ?>
    <div id="accordion">

        <h3><a href="#">Editar Teto</a></h3>
        <div><!-- Início do formulário pensionistas -->
            <form name="form_teto" id="form_teto" action="<?php echo base_url() ?>giah/servidor/editarteto/<?=$teto["0"]->teto_id;?>/<?=$teto["0"]->servidor_id;?>" method="post">
                <input type="hidden" name="txtServidorID" value="<?=@$servidor->_servidor_id;?>" />
                <input type="hidden" name="txtTetoID" value="1" />
                <dl class="dl_cadastro_teto">
                    <dt>
                        <label>Matricula SAM</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtMatricula" class="texto02" value="<?=$teto["0"]->matricula_sam;?>"/>
                    </dd>
                    <dt>
                        <label>Banco</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtBanco" class="texto02" value="<?=$teto["0"]->banco;?>"/>
                    </dd>
                    <dt>
                        <label>Ag&ecirc;ncia / DV</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtAgencia" class="texto03" value="<?=$teto["0"]->agencia;?>" /> / <input type="text" class="texto02" name="txtAgenciaDV" value="<?=$teto["0"]->agencia_dv;?>"/>
                    </dd>
                    <dt>
                        <label>Conta Corrente / DV</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtConta" class="texto03" value="<?=$teto["0"]->conta;?>" /> / <input type="text" class="texto02" name="txtContaDV" value="<?=$teto["0"]->conta_dv;?>" />
                    </dd>
                    <dt>
                        <label>Sal&aacute;rio base</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtSalarioBase" class="texto03" alt="decimal" value="<?= number_format($teto["0"]->salario_base, 2, ",", ".");?>" />
                    </dd>
                </dl>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div><!-- Fim do formulário pensionistas -->
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#servidor" ).accordion();
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        $('#form_teto').validate( {
            rules: {

                txtMatricula: {
                    required: true,
                    minlength: 3,
                    maxlength: 10
                },
                txtBanco: {
                    required: true,
                    minlength: 3,
                    maxlength: 5
                },
                txtAgencia: {
                    required: true,
                    minlength: 3,
                    maxlength: 5
                },
                txtAgenciaDV: {
                    required: true,
                    minlength: 1,
                    maxlength: 1
                },
                txtConta: {
                    required: true,
                    minlength: 3,
                    maxlength: 12
                },
                txtContaDV: {
                    required: true,
                    minlength: 1,
                    maxlength: 1
                },
                txtSalarioBase: {
                    required: true,
                    minlength: 3
                }

            },
            messages: {

                txtMatricula: {
                    required: "*",
                    minlength: "Minimo 3 digitos",
                    maxlength: "Maximo 10 digitos"
                },
                txtBanco: {
                    required: "*",
                    minlength: "Minimo 3 digitos",
                    maxlength: "Maximo 5 digitos"
                },
                txtAgencia: {
                    required: "*",
                    minlength: "Minimo 3 digitos",
                    maxlength: "Maximo 5 digitos"
                },
                txtAgenciaDV: {
                    required: "*",
                    minlength: "Minimo 1 digitos",
                    maxlength: "Maximo 1 digitos"
                },
                txtConta: {
                    required: "*",
                    minlength: "Minimo 3 digitos",
                    maxlength: "Maximo 12 digitos"
                },
                txtContaDV: {
                    required: "*",
                    minlength: "Minimo 1 digitos",
                    maxlength: "Maximo 1 digitos"
                },
                txtSalarioBase: {
                    required: "*",
                    minlength: "Minimo 1 digitos"
                }
            }
        });
    });

</script>