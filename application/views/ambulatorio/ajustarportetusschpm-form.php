
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Ajustar valor do porte</a></h3>
        <div>
            <form name="form_procedimentoplano" id="form_procedimentoplano" action="<?= base_url() ?>ambulatorio/procedimento/gravarajustarportetusschpm" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Descrição Porte</label>
                    </dt>
                    <dd>
                        <select id="descricaoporte" name="descricaoporte" required="">
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
                        <label>Novo Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtvalorporte" alt="decimal" class="texto02" value=""/>
                    </dd>
                    
                </dl>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js" ></script>
<script type="text/javascript">
    $(function () {
        $("#accordion").accordion();
    });

</script>