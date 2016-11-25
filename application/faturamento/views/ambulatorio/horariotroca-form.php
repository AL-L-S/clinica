<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Pantao</a></h3>
        <div>
            <form name="form_cargo" id="form_servidor" action="<?= base_url() ?>ponto/horariostipo/gravarhorariotroca" method="post">

                <dl class="dl_desconto_lista">
                    <dd>
                        <input type="hidden" id="txtfuncionario_id" name="txtfuncionario_id" value="<?= $funcionario_id; ?>" />
                    </dd>
                </dl> 
                <table>
                    <tr>
                        <th>Descricao</th>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Entrada padrao</th>
                        <th>Saida padrao</th>
                        <th>Entrada extra</th>
                        <th>Saida extra</th>
                        <th>Entrada extensao</th>
                        <th>saida extensao</th>
                    </tr>
                    <tr>
                        <td><select name="txtdescricao" id="txtdescricao" class="size2">
                                <option value="">Selecione</option>
                                <option value="TROCA">TROCA DE PLANTÃO</option>
                                <option value="SUBSTITUICAO">SUBSTİTUİÇAO DE PLANTAO</option>
                            </select></td>
                        <td><input type="hidden" id="txtNome" class="texto_id" name="txtNome"/>
                            <input type="text" id="txtNomeLabel" class="texto03" name="txtNomeLabel"/></td>
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

    
    $('#btnVoltar').click(function() {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function() {
        $( "#accordion" ).accordion();
    });
    $(function() {
        $( "#txtNomeLabel" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=funcionario",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtNomeLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtNomeLabel" ).val( ui.item.value );
                $( "#txtNome" ).val( ui.item.id );
                return false;
            }
        });
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