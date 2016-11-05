<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>giah/servidor">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Servidor</a></h3>


        <div>
            <form name="form_emergencia-parecer" id="form_emergencia-parecer" action="<?= base_url() ?>emergencia/emergencia/gravarparecer/" method="post">
                <fieldset>
                    <div class="parecer_desc">
                        <label>Descri&ccedil;&atilde;o</label><br />
                        <input type="hidden" id="txtSolicitacao" name="txtSolicitacao" value="<?= $solicitacao ?>" />
                        <input type="hidden" id="txtEvolucao_id" name="txtEvolucao_id" value="<?= $evolucao ?>" />
                        <textarea cols="60" rows="20" name="txtDescricao" id="txtDescricao" ></textarea><br/>
                    </div>
                    
                    <div>
                        <label>Conduta</label><br/>
                        <select  name="txtConduta" class="parecer_select" >
                            <option value="">Selecione</option>
                            <?php foreach ($conduta as $item): ?>
                                <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
                            <?php endforeach; ?>
                            
                            </select><br/>
                            <label>Tempo da conduta</label><br/>
                            <select name="txtTempo" id="txtTempo" class="parecer_select">
                                <option value="">Selecione</option>
                                <option value="0 - imediato">Imediato</option>
                                <option value="1 - 5 minutos">1 - Vermelho - 5 minutos</option>
                                <option value="2 - 15 minutos">2 - Laranja - 15 minutos</option>
                                <option value="3 - 30 minutos">3 - Amarelo - 30 minutos</option>
                                <option value="4 - 50 minutos">4 - Verde - 50 minutos</option>
                                <option value="5 - 90 minutos">5 - Azul - 90 minutos</option>
                                <option value="6 - Até 6 horas">6 - Até 6 horas</option>
                                <option value="7 - Até 12 horas">7 - Até 12 horas</option>
                                <option value="8 - Até 24 horas">8 - Até 24 horas</option>
                                <option value="9 - Até 48 horas">9 - Até 48 horas</option>
                                <option value="10 - Até 72 horas">10 - Até 72 horas</option>
                                <option value="11 - Até 2 semanas">11 - Até 2 semanas</option>
                                <option value="12 - Até 4 semanas">12 - Até 4 semanas</option>
                                <option value="13 - Mais 4 semanas">13 - Mais 4 semanas</option>
                            </select>
                        </div>
                        <br />
                        <div class="left parecer_data_hora">
                            <div>
                                <div class="parecer_lbl">
                                    <label>Data/hora do parecer</label>
                                </div>
                                <input type="text" name="txtdata" alt="date" value="<?= $data; ?>" class="size1" /><input type="text" name="txthora" value="<?= $hora; ?>" alt="time" class="size1" />
                            </div>
                        </div>
                        <div class="left">
                            <div class="parecer_lbl">
                                <label>Medico</label>
                            </div>
                            <input type="text" id="txtmedico" name="txtmedico" class="size1" readonly="true" />
                            <input type="text" id="txtmedicolabel" name="txtmedicolabel" class="parecer_medico"  />
                        </div>
                        <div class="clear" />
                        <br />
                        <hr>
                        <button type="submit" name="btnEnviar">Enviar</button>
                        <button type="reset" name="btnLimpar">Limpar</button>
                        <br>

                    </fieldset>
                </form>
            </div>
        </div>



    </div> <!-- Final da DIV content -->
    <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
    <script type="text/javascript">

        $(function() {

            $(function() {
                $( "#accordion" ).accordion();
            });

            $( "#txtmedicolabel" ).autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=medico",
            minLength: 1,
            focus: function( event, ui ) {
                $( "#txtmedicolabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtmedicolabel" ).val( ui.item.value );
                $( "#txtmedico" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(document).ready(function(){


        $('#form_emergencia-parecer').validate( {
            rules:
                {
                txtDescricao:
                    {
                    required: true,
                    minlength: 3
                },
                txtTempo:
                    {
                    required: true
                },
                txtmedico:
                    {
                    required: true
                },
                txtdata:
                    {
                    required: true
                },
                txthora:
                    {
                    required: true
                },
                txtConduta:
                    {
                    required: true
                }
            },
            messages:
                {
                txtDescricao:
                    {
                    required: "*",
                    minlength: "!"
                },
                txtTempo:
                    {
                    required: "*",
                    minlength: "!"
                },
                txtmedico:
                    {
                    required: "*",
                    minlength: "!"
                },
                txtdata:
                    {
                    required: "*",
                    minlength: "!"
                },
                txthora:
                    {
                    required: "*",
                    minlength: "!"
                },
                txtConduta:
                    {
                    required: "*"
                }
            }

        });

    });

</script>