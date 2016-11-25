<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Horario Fixo</a></h3>
        <div>
            <form name="form_cargo" id="form_servidor" action="<?= base_url() ?>ponto/horariostipo/gravarhorariofixo" method="post">

                <dl class="dl_desconto_lista">
                    <dd>
                        <input type="hidden" id="txthorariostipoID" name="txthorariostipoID" value="<?= $horariostipo_id; ?>" />
                    </dd>
                </dl> 
                <table>
                    <tr>
                        <th>Data</th>
                        <th>Entrada padrao</th>
                        <th>Saida padrao</th>
                        <th>Entrada extra</th>
                        <th>Saida extra</th>
                        <th>Entrada extensao</th>
                        <th>saida extensao</th>
                    </tr>
                    <tr>
                        <td>                
                            <select name="txtDia" id="txtData" class="size1">
                                <option value=""></option>
                                <option value="1 - Segunda">1 - Segunda</option>
                                <option value="2 - Terça">2 - Terça</option>
                                <option value="3 - Quarta">3 - Quarta</option>
                                <option value="4 - Quinta">4 - Quinta</option>
                                <option value="5 - Sexta">5 - Sexta</option>
                                <option value="6 - Sabado">6 - Sabado</option>
                                <option value="7 - Domingo">7 - Domingo</option>
                            </select>
                        </td>
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