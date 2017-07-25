<body bgcolor="#C0C0C0">
<div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Calculadora</h3>
        <div>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/laudo/calcularvolume" method="post">
                <fieldset>
                    
                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Multiplicador</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" class="texto01" value="0.5233" readonly/>
                    </dd>
                    <dt>
                    <label>Valor1</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor1" class="texto01" value="<?= $valor1; ?>"/>
                    </dd>
                    <dt>
                    <label>Valor2</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor2" class="texto01" value="<?= $valor2; ?>"/>
                    </dd>
                    <dt>
                    <label>Valor3</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor3" class="texto01" value="<?= $valor3; ?>"/>
                    </dd>
                    <dt>
                    <label>Resultado</label>
                    </dt>
                    <dd>
                        <input type="text" name="resultado" class="texto01" value="<?= $resultado; ?>" readonly/>
                        <?if ($resultado != ''){
                            $resultado = number_format($resultado, 1, ",", ".");
                            ?>
                        <input type="text" name="resultado" class="texto06" value="<?= $valor1 . " x " . $valor2 . " x " . $valor3 . " cm Vol " . $resultado . " cm&sup3;"; ?>" readonly/>    
                       <? }
                    ?>
                    </dd>
                         <?php
    $valuecalculado = $valor1 . " x " . $valor2 . " x " . $valor3 . " cm Vol " . $resultado . " cm&sup3;";
    setcookie("TestCookie", $valuecalculado);
    ?>
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar" >Calcular</button>
            </form>
            </fieldset>
        </div>
</div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_horariostipo').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                txtTipo: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtTipo: {
                    required: "*"
                }
            }
        });
    });

</script>