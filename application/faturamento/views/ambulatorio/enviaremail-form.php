
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">

        <h3><a href="#">Enviar Email</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>cadastros/caixa/enviaremail/<?= $email_id?>">
                <input type="hidden" name="tiporelatorio" id="tiporelatorio" value="<? echo $tiporelatorio; ?>" />
                <dl>                  
                    <dt>
                        <label>Seu Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="seunome" id="seunome" />
                    </dd>
                    <dt>
                        <label>Assunto</label>
                    </dt>
                    <dd>
                        <input type="text" name="assunto" id="assunto" />
                    </dd>
                    <dt>
                        <label>Destinatário(s)</label>
                    </dt>
                    <dd>
                        <input type="text" name="destino1" id="destino1" class="texto05"/>
                    </dd>           
                </dl></br></br>
                <button type="submit" >Enviar</button>
            </form>
        </div>
    </div>


</div> <!-- Final da DIV content -->
<script type="text/javascript">



    $(function () {
        $("#accordion").accordion();
    });

</script>
