<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Horario Variavel</a></h3>
        <div>
            <form name="form_cargo" id="form_servidor" action="<?= base_url() ?>ponto/horariostipo/gravarhorariovariavel" method="post">

                <dl class="dl_desconto_lista">
                    <dd>
                        <input type="hidden" id="txthorariostipoID" name="txthorariostipoID" value="<?= $horariostipo_id; ?>" />
                    </dd>
                </dl> 
                <table>
                    <tr>
                        <th>Data</th>
                        <th>Hora entrada1</th>
                        <th>Hora saida1</th>
                        <th>Hora entrada2</th>
                        <th>Hora saida2</th>
                        <th>Hora entrada3</th>
                        <th>Hora saida3</th>
                    </tr>
                    <tr>
                        <td><input type="text"  id="txtData" name="txtData" alt="date" class="size1" /></td>
                        <td><input type="text"  id="txthoraEntrada1" name="txthoraEntrada1" alt="time" class="size1" /></td>
                        <td><input type="text"  id="txthoraSaida1" name="txthoraSaida1" alt="time" class="size1" /></td>
                        <td><input type="text"  id="txthoraEntrada2" name="txthoraEntrada2" alt="time" value="00:00" class="size1" /></td>
                        <td><input type="text"  id="txthoraSaida2" name="txthoraSaida2" alt="time" value="00:00" class="size1" /></td>
                        <td><input type="text"  id="txthoraEntrada3" name="txthoraEntrada3" alt="time" value="00:00" class="size1" /></td>
                        <td><input type="text"  id="txthoraSaida3" name="txthoraSaida3" alt="time" value="00:00" class="size1" /></td>
                    </tr>
                </table>    

                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $(function() {
        $( "#data_ficha" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_cargo').validate( {
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