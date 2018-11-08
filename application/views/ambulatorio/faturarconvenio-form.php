<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Faturar</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarfaturadoconvenio" method="post">
                <fieldset>

                    <dl class="dl_desconto_lista">
                        <dt>
                        <label>Tem certeza que deseja Faturar?</label>
                        </dt>
                        <dd>
                            <input type="text" name="valorafaturar" id="valorafaturar" class="texto01" value="<?= $exame[0]->valor_total; ?>" />
                            <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" class="texto01" value="<?= $agenda_exames_id; ?>"/>
                        </dd>
                        <dt>
                        <label>Carater Atendimento</label>
                        </dt>
                        <dd>
                            <select name="carater_xml" id="carater_xml" style="width: 100px">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </dd>
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
        
    //    (function($){
    //        $(function(){
    //            $('input:text').setMask();
    //        });
    //    })(jQuery);
    
    
    $(document).ready(function(){

        function multiplica()
        {
            total=0;
            valor = parseFloat(document.form_faturar.valorcadastrado.value.replace(",","."));
            numer1 = parseFloat(document.form_faturar.valor1.value.replace(",","."));
            total+= numer1;
            
            resultado= total - valor;
            y=resultado.toFixed(2);
            $('#valortotal').val(y);
            $('#novovalortotal').val(y);
//            document.getElementById("valortotal").value = 10;
            //        document.form_faturar.valortotal.value = 10;
        }
        multiplica();
           
            
    });
</script>