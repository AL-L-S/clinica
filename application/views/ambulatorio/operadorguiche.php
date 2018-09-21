<?
$empresa_id = $this->session->userdata('empresa_id');
$empresapermissao = $this->guia->listarempresasaladepermissao();
?>
<div class="content"> <!-- Inicio da DIV content -->
    <? $perfil_id = $this->session->userdata('perfil_id'); ?>

    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Guichê Operador</a></h3>
        <div>
            <form action="<?= base_url() ?>ambulatorio/exame/gravaroperadorguiche" method="post">
<!--            <table>
                <tr>
                    <td>
                        <label style="font-size: 10pt; color: black">Perfil</label>
                    </td>
                    <td>
                        <select name="perfil_id[]" id="perfil_id" style="width: 400px" class="chosen-select" data-placeholder="Selecione os Perfis..." multiple >

                            <option value='TODOS'>TODOS</option>
                            <? foreach ($perfil as $value) : ?>
                                <option value="<?= $value->perfil_id; ?>" 
                                        
                                            <?php echo $value->nome; ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table><br><br>-->
            <table>
                <tr>
                    <th class="tabela_header">OPERADOR</th>
                    <th class="tabela_header">GUICHÊ</th>
                </tr>

                <?$estilo_linha = "tabela_content01"; ?>
                <? foreach ($operador as $value) : ?>
                    <? // echo'<pre>'; var_dump($value);die;?>
                <?($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";?>
                <tr>
                    <td class="<?php echo $estilo_linha; ?>"><?= $value->nome; ?></td>
                    <td class="<?php echo $estilo_linha; ?>">
                    <input type="hidden" id="operador_id" name="operador_id[]" value="<?= $value->operador_id ?>"/>
                        <select name="guiche[]" id="guiche" style="width: 400px" class="size02" >
                            <option value=''>SELECIONE</option>                                                        
                            <option value='1'<?if (@$value->guiche == '1'):echo 'selected';
                                    endif; ?>>GUICHÊ 1</option>                            
                            <option value='2'<?if (@$value->guiche == '2'):echo 'selected';
                                    endif; ?>>GUICHÊ 2</option>                            
                            <option value='3'<?if (@$value->guiche == '3'):echo 'selected';
                                    endif; ?>>GUICHÊ 3</option>                             
                            <option value='4'<?if (@$value->guiche == '4'):echo 'selected';
                                    endif; ?>>GUICHÊ 4</option>                             
                            <option value='5'<?if (@$value->guiche == '5'):echo 'selected';
                                    endif; ?>>GUICHÊ 5</option>                             
                            <option value='6'<?if (@$value->guiche == '6'):echo 'selected';
                                    endif; ?>>GUICHÊ 6</option>                             
                            <option value='7'<?if (@$value->guiche == '7'):echo 'selected';
                                    endif; ?>>GUICHÊ 7</option>                             
                            <option value='8'<?if (@$value->guiche == '8'):echo 'selected';
                                    endif; ?>>GUICHÊ 8</option>                             
                            <option value='9'<?if (@$value->guiche == '9'):echo 'selected';
                                    endif; ?>>GUICHÊ 9</option>                             
                            <option value='10'<?if (@$value->guiche == '10'):echo 'selected';
                                    endif; ?>>GUICHÊ 10</option>                             
                            <option value='11'<?if (@$value->guiche == '11'):echo 'selected';
                                    endif; ?>>GUICHÊ 11</option>                             
                            <option value='12'<?if (@$value->guiche == '12'):echo 'selected';
                                    endif; ?>>GUICHÊ 12</option>                             
                            <option value='13'<?if (@$value->guiche == '13'):echo 'selected';
                                    endif; ?>>GUICHÊ 13</option>                             
                            <option value='14'<?if (@$value->guiche == '14'):echo 'selected';
                                    endif; ?>>GUICHÊ 14</option>                             
                            <option value='15'<?if (@$value->guiche == '15'):echo 'selected';
                                    endif; ?>>GUICHÊ 15</option>                             
                            <option value='16'<?if (@$value->guiche == '16'):echo 'selected';
                                    endif; ?>>GUICHÊ 16</option>                             
                            <option value='17'<?if (@$value->guiche == '17'):echo 'selected';
                                    endif; ?>>GUICHÊ 17</option>                             
                            <option value='18'<?if (@$value->guiche == '18'):echo 'selected';
                                    endif; ?>>GUICHÊ 18</option>                             
                            <option value='19'<?if (@$value->guiche == '19'):echo 'selected';
                                    endif; ?>>GUICHÊ 19</option>                             
                            <option value='20'<?if (@$value->guiche == '20'):echo 'selected';
                                    endif; ?>>GUICHÊ 20</option>
                        </select>
                    </td>              
                </tr>
                <? endforeach; ?>
            </table>
            <hr>
            <button type="submit" name="btnEnviar">Gravar Operadores</button>
           </form> 
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $('#perfil_id').change(function () {

//                            $('.carregando').show();
//                            alert('asdsd');
            $.getJSON('<?= base_url() ?>autocomplete/perfiloperador', {perfil_id: $(this).val()}, function (j) {
                options = '<option value=""></option>';
                console.log(j);
                for (var c = 0; c < j.length; c++) {
                    if (operador_id == j[c].operador_id) {
                        options += '<option selected value="' + j[c].operador_id + '">' + j[c].nome + '</option>';
                    } else {
                        options += '<option value="' + j[c].operador_id + '">' + j[c].nome + '</option>';
                    }

                }


                $('#operador_id option').remove();
                $('#operador_id').append(options);
                $("#operador_id").trigger("chosen:updated");
                $('.carregando').hide();
            });

        });
    });

</script>
