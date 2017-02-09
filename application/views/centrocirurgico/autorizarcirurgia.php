<div class="content ficha_ceatox">
    <div>
        <form name="form_autorizar" id="form_autorizar" action="<?= base_url() ?>centrocirurgico/centrocirurgico/autorizarcirurgia" method="post">
            <fieldset>
                <legend>Dados da Solicitacao</legend>
                <div>
                    <label>Paciente</label>                      
                    <input type="text" id="paciente" name="paciente"  class="texto09" value="<?= $solicitacao[0]->nome; ?>" readonly/>
                </div>
                <div style="display: none;">                     
                    <input type="text" id="idpaciente" name="idpaciente"  class="texto09" value="<?= $solicitacao[0]->paciente_id; ?>" readonly/>
                    <input type="text" id="idsolicitacaocirurgia" name="idsolicitacaocirurgia"  class="texto09" value="<?= $solicitacao[0]->solicitacao_cirurgia_id; ?>" readonly/>
                </div>
            </fieldset>                

            <fieldset>
                <legend></legend>
                <div>
                    <label>Medico Agendado</label>                      
                    <select  name="medicoagendadoid" id="medicoagendadoid" class="size04" required="true">
                        <option value="">Selecione</option>
                        <? foreach ($medicos as $item) : ?>
                            <option value="<?= $item->operador_id; ?>"
                                    <?if($solicitacao[0]->medico_agendado == $item->operador_id): echo 'selected'; endif;?>>
                                <?= $item->nome; ?>
                            </option>
                        <? endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Sala Agendada</label>                      
                    <select name="salaagendada" id="salaagendada" required>
                        <option value="">Selecione</option>
                        <? foreach ($salas as $item) { ?>
                            <option value="<?= $item->exame_sala_id ?>"><? echo $item->nome; ?></option>    
                        <? } ?>                    
                    </select>
                </div>
                <div>
                    <label>Data/hora Prevista ex.( 20/01/2017 14:30)</label>
                    <input type="text" id="dataprevista" class="texto08" name="dataprevista" alt="39/19/9999 24:59" />
                </div>
            </fieldset>   
            <button type="submit">Enviar</button>
            <button type="reset">Limpar</button>
        </form>    
    </div>

    <div class="clear"></div>
</div>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
<script>
    $(document).ready(function () {
        jQuery('#form_autorizar').validate({
            rules: {
                medicoagendado: {
                    required: true,
                    minlength: 3
                },
                salaagendada: {
                    required: true
                },
                dataprevista: {
                    required: true
                }

            },
            messages: {
                medicoagendado: {
                    required: "*",
                    minlength: 3
                },
                salaagendada: {
                    required: "*"
                },
                dataprevista: {
                    required: "*"
                }
            }
        });
    });


    $(function () {
        $("#medicoagendado").autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=operador",
            minLength: 2,
            focus: function (event, ui) {
                $("#medicoagendado").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#medicoagendado").val(ui.item.value);
                $("#medicoagendadoid").val(ui.item.id);
                return false;
            }
        });
    });
</script>