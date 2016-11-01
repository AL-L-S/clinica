<head>
    <meta charset="UTF-8"/>
</head>
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <div>
            <form name="form" id="form" action="<?= base_url() ?>ambulatorio/guia/reciboounotaindicador" method="post">
                <input type="hidden" name="paciente_id" value="<?= $paciente_id ?>"/>
                <input type="hidden" name="guia_id" value="<?= $guia_id ?>"/>
                <input type="hidden" name="exames_id" value="<?= $exames_id ?>"/>
                <fieldset>
                    <div>
                        <label>Recibo</label>
                        <input type="checkbox" name="recibo" id="recibo" value='off'/>
                    </div>
                    <br/>

                    <div>
                        <label >Nota</label>
                        <input type="checkbox" name="nota" id="nota" style="width: 37px;" value='off'/>
                    </div>
                    <hr>
                    <dd>                    
                        <button type="submit" id="enviar" >Enviar</button>
                    </dd>

            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>

