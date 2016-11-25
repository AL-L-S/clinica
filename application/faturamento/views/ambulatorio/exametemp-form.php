<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravartemp" method="post">

            <fieldset>
                <div>
                    <label>Data</label>
                    <input type="text"  id="data_ficha" name="data_ficha" class="size1"  />
                    <input type="hidden" name="txtpaciente_id" value="<?= @$obj->_ambulatorio_pacientetemp_id; ?>" />
                </div>
                <legend>Exames tipo</legend>

                <div>
                    <label>Exame</label>
                    <select name="exame" id="exame" class="size1">
                        <option value="" >Selecione</option>
                        <option value="RX" >RX</option>
                        <option value="RM" >RM</option>
                        <option value="ULTRA SOM" >ULTRA SOM</option>
                        <option value="MAMA" >MAMA/D.O</option>
                    </select>
                </div>

                <div>
                    <label>Horarios</label>
                    <select name="horarios" id="horarios" class="size2">
                        <option value="" >-- Escolha um exame --</option>
                    </select>
                </div>
                <div>
                    <label>Obsedrva&ccedil;&otilde;es</label>
                    <input type="text" id="observacoes" class="size3" name="observacoes" />
                </div>
                
                <div>
                    <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
                </div>
                </form>
                </fieldset>
            
                 <fieldset>
                    <?
                    if ($contador > 0) {
                        
                            ?>
                            <table id="table_agente_toxico" border="0">
                                <thead>

                                    <tr>
                                        <th class="tabela_header">Data</th>
                                        <th class="tabela_header">Hora</th>
                                        <th class="tabela_header">Exame</th>
                                        <th class="tabela_header">Observa&ccedil;&otilde;es</th>
                                        <th class="tabela_header">&nbsp;</th>
                                    </tr>
                                </thead>
<?
$estilo_linha = "tabela_content01";
                        foreach ($exames as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
?>
                                <tbody>
                                    <tr>
                                        <td class="<?php echo $estilo_linha; ?>"><?= substr($item->data, 8, 2) . '/' . substr($item->data, 5, 2) . '/' . substr($item->data, 0, 4); ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->inicio; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->nome; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>"><?= $item->observacoes; ?></td>
                                        <td class="<?php echo $estilo_linha; ?>" width="100px;">
                                            <a href="<?= base_url() ?>ambulatorio/exametemp/excluir/<?= $item->agenda_exames_id; ?>/<?= @$obj->_ambulatorio_pacientetemp_id; ?>" class="delete">
                                            </a>

                                        </td>
                                    </tr>

                                </tbody>
                                                        <?
                        }
                    }
                    ?>
                        <tfoot>
                            <tr>
                                <th class="tabela_footer" colspan="4">
                                </th>
                    </tr>
                </tfoot>
                            </table> 

                </fieldset>
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

    $(function(){
        $('#exame').change(function(){
            if( $(this).val() ) {
                $('#horarios').hide();
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/horariosambulatorio',{exame: $(this).val(), teste: $("#data_ficha").val()}, function(j){
                    var options = '<option value=""></option>';	
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '-' + j[i].nome + '</option>';
                    }	
                    $('#horarios').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#horarios').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });





    //$(function(){     
    //    $('#exame').change(function(){
    //        exame = $(this).val();
    //        if ( exame === '')
    //            return false;
    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
    //            var option = new Array();
    //            $.each(data, function(i, obj){
    //                console.log(obl);
    //                option[i] = document.createElement('option');
    //                $( option[i] ).attr( {value : obj.id} );
    //                $( option[i] ).append( obj.nome );
    //                $("select[name='horarios']").append( option[i] );
    //            });
    //        });
    //    });
    //});





    $(function() {
        $( "#accordion" ).accordion();
    });


    $(document).ready(function(){
        jQuery('#form_exametemp').validate( {
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