
<div class="content"> <!-- Inicio da DIV content -->


    <div id="accordion">
        <h3 class="singular"><a href="#">Manter Senhas</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $medicos = $this->operador_m->listarmedicos();
            ?>
            <table>
                <tr>
                    <td style="width: 100px;">
                        <div class="bt_link_new">
                            <a href="#" id="botaochamar">
                                Chamar Senha
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="bt_link_new">
                            <a href="#" id="botaoatender">
                                Atender
                            </a>
                        </div>
                    </td>  
                </tr>
            </table>
            <form id="formIdFila">
                <input type="hidden" name="IdFila" id="IdFila">
                <input type="hidden" name="SenhaFila" id="SenhaFila">
            </form>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_title">Pendentes</th>
                    </tr>
                    <tr>

                    </tr>


                    <tr>
                        <th class="tabela_header">ID</th>
                        <th class="tabela_header">Senha</th>
                        <!--<th class="tabela_header"><center>A&ccedil;&otilde;es</center></th>-->
                    </tr>
                </thead>
                <?php
                if (count($senhas) > 0) {
                    ?>
                    <tbody>
                        <?php
                        $perfil_id = $this->session->userdata('perfil_id');
                        $operador_id = $this->session->userdata('operador_id');
                        $estilo_linha = "tabela_content01";
                        foreach ($senhas as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->senha ?></td>

                            </tr>

                        </tbody>
                        <?php
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="4">
                                Total de registros: <?php echo count($senhas); ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            <? }
            ?>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

    $("#botaochamar").click(function () {
//        alert('asadasdadad');
        $.ajax({
            type: "POST",
            data: {teste: 'teste'},
            //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
            url: "<?= $endereco ?>/webService/telaAtendimento/proximo/<?= $setor_string ?>/Guichê 1/true/false/<?= $operador_id ?>/1",
            success: function (data) {
//                alert('asdsadsd');
//                console.log(data);
//                console.log(data.filaDeEspera.data);
                alert('Senha chamada: ' + data.filaDeEspera.senha + '');
                $('#IdFila').val(data.filaDeEspera.id);
                $('#SenhaFila').val(data.filaDeEspera.senha);
                gravarSenha(data.filaDeEspera.senha, data.filaDeEspera.id, data.filaDeEspera.data);
                
            },
            error: function (data) {
//                console.log(data);
//                alert('DEU MERDA');
            }
        });
    });
    
    $("#botaoatender").click(function () {
//        alert('asadasdadad');
        var idFila = $('#IdFila').val();
        var SenhaFila = $('#SenhaFila').val();
        $.ajax({
            type: "POST",
            data: {teste: 'teste'},
            //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
            url: "<?= $endereco ?>/webService/telaAtendimento/cancelar/" + idFila +"" ,
            success: function () {
                alert('Senha ' + SenhaFila + ' atendida com sucesso');
                atenderSenha(idFila);
                window.location.reload();
            },
            error: function (data) {
//                console.log(data);
                alert('Chame uma senha antes de atendê-la');
            }
        });
    });
  
    function gravarSenha(senha, id, data){
        $.ajax({
            type: "POST",
            data: {
                senha: senha,
                id: id,
                data: data,
            
            },
            //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
            url: "<?= base_url() ?>autocomplete/gravarsenhatoten",
            success: function (data) {
//                alert('asdsadsd');
//                console.log(data);
//                console.log(data.filaDeEspera.senha);
                alert('Senha chamada: ' + data.filaDeEspera.senha + '');
                
            },
            error: function (data) {
                console.log(data);
            }
        });
    
    }
    
    function atenderSenha(id){
       
        $.ajax({
            type: "POST",
            data: {
                id: id

            
            },
            //url: "http://192.168.25.47:8099/webService/telaAtendimento/cancelar/495",
            url: "<?= base_url() ?>autocomplete/atendersenhatoten",
            success: function (data) {
//                  alert('asdsadsd');
//                console.log(data);
//                console.log(data.filaDeEspera.senha);
//                alert('Senha chamada: ' + data.filaDeEspera.senha + '');
                
            },
            error: function (data) {
//                console.log(data);
//                alert('DEU MERDA');
            }
        });
    
    }


</script>
