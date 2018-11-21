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
                        <!-- <tr> -->
                        <tr>
                                <td style="width: 300px;">
                                        Operador    
                                </td>
                                <td style="width: 300px;">
                                        Guichê
                                </td>
                        </tr>
                        <!-- </tr> -->
                        <tr>
                        <td>
                        
                        <select name="operador_id" id="operador_id" style="width: 200px" class="" data-placeholder="Selecione os Operadores..." required="">
                                <? foreach ($operadores as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" 
                                <? // if (@$_GET['perfil_id'] == $value->perfil_id) echo 'selected' ?>>
                                        <?php echo $value->nome; ?>
                                </option>
                        <? endforeach; ?> 
                        </select>
                        
                        </td>
                        <td>
                        <select name="guiche" id="guiche">
                                <option value="1">GUICHÊ 1</option>
                                <option value="2">GUICHÊ 2</option>
                                <option value="3">GUICHÊ 3</option>
                                <option value="4">GUICHÊ 4</option>
                                <option value="5">GUICHÊ 5</option>
                                <option value="6">GUICHÊ 6</option>
                                <option value="7">GUICHÊ 7</option>
                                <option value="8">GUICHÊ 8</option>
                                <option value="9">GUICHÊ 9</option>
                                <option value="10">GUICHÊ 10</option>
                                <option value="11">GUICHÊ 11</option>
                                <option value="12">GUICHÊ 12</option>
                                <option value="13">GUICHÊ 13</option>
                                <option value="14">GUICHÊ 14</option>
                                <option value="15">GUICHÊ 15</option>
                                <option value="16">GUICHÊ 16</option>
                                <option value="17">GUICHÊ 17</option>
                                <option value="18">GUICHÊ 18</option>
                                <option value="19">GUICHÊ 19</option>
                                <option value="20">GUICHÊ 20</option>
                        </select>  
                        </td>
                        <td>
                        <button type="submit" name="btnEnviar">Gravar</button>     
                        </td>
                        </tr>
                </table>
        <br>
        <br>
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
                    <td class="<?php echo $estilo_linha; ?>">GUICHÊ <?=($value->guiche > 0)?$value->guiche : '1';?></td>
                    <!-- <td class="<?php echo $estilo_linha; ?>"> -->
                        
                    <!-- </td>               -->
                </tr>
                <? endforeach; ?>
            </table>
            <hr>
            <!-- <button type="submit" name="btnEnviar">Gravar Operadores</button> -->
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
