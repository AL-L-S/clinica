<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>ponto/horariostipo">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Horario</a></h3>
        <div>
            <form name="form_exame" id="form_exame" action="<?= base_url() ?>ambulatorio/exame/gravarconsulta" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                    <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" class="texto10 bestupper"/>
                    </dd>
                    <dt>
                    <label>Data inicial</label>
                    </dt>
                    <dd>
                        <input type="text"  id="txtdatainicial" name="txtdatainicial" alt="date" class="size2" />
                    </dd>
                    <dt>
                    <label>Data final</label>
                    </dt>
                    <dd>
                        <input type="text"  id="txtdatafinal" name="txtdatafinal" alt="date" class="size2" />
                    </dd>
                    <dt>
                    <label>Horario *</label>
                    </dt>
                    <dd>
                        <select name="txthorario" id="txthorario" class="size4">
                            <? foreach ($agenda as $item) : ?>
                                <option value="<?= $item->agenda_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Medico *</label>
                    </dt>
                    <dd>
                        <select name="txtmedico" id="txtsala" class="size4">
                            <? foreach ($medico as $item) : ?>
                                <option value="<?= $item->operador_id; ?>"><?= $item->nome; ?></option>
                                    <? endforeach; ?>
                        </select>
                    </dd>
                    </dd>
                    <dt>
                    <label>Tipo Consulta *</label>
                    </dt>
                    <dd>
                        <select name="txttipo" id="txttipo" class="size4">
                            <? foreach ($tipo as $item) : ?>
                                <option value="<?= $item->ambulatorio_tipo_consulta_id; ?>"><?= $item->descricao; ?></option>
                                    <? endforeach; ?>
                        </select>
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

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    
       $(function() {
        $( "#txtdatainicial" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    
       $(function() {
        $( "#txtdatafinal" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function() {
        $( "#accordion" ).accordion();
    });
    
    $(function() {
        $( "#txtprocedimentolabel" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=paciente",
            minLength: 3,
            focus: function( event, ui ) {
                $( "#txtpacientelabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtpacientelabel" ).val( ui.item.value );
                $( "#txtpacienteid" ).val( ui.item.id );
                return false;
            }
        });
    });

    $(document).ready(function(){
        jQuery('#form_exame').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
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