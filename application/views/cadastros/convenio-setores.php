<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion"> 
        <h2 class="singular"><a href="#">Cadastro de Setores</a></h2>
        
        <div>
            <form name="form_convenio" id="form_convenio" action="<?= base_url() ?>cadastros/convenio/gravarsetorempresa" method="post">
                <table width="100%" height="50px">
                    <thead>
                    <tr>
                        <th colspan="5" class="tabela_title">
                    </tr>
                    </thead>
                    <tr height="50px">
                        <th class="tabela_title">Empresa</th>
                        <td>
                            <input type="hidden" name="txtconvenioid" class="texto10" value="<?= $convenio_selecionado[0]->convenio_id; ?>" />
                            <input type="text" name="convenio_selecionado" value="<?= $convenio_selecionado[0]->nome; ?>" readonly="" />
                        </td>
                    </tr>
                    <!--<br><br>-->              
                    <tr height="50px">
                        <th class="tabela_title">Setor</th>
                        <td>
                            <select name="txtsetor_id" id="txtsetor_id" class="size4 chosen-select" tabindex="1" required="">
                                <option value="">SELECIONE </option>
                                <? foreach ($setor as $value) : ?>
                                    <option value="<?= $value->aso_setor_id; ?>"><?= $value->descricao_setor; ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <!--<br>-->
                    <tr height="100px">

                        <th class="tabela_title">Funções</th>
                        <td>                   
                            <select name="txtfuncao_id[]" id="txtfuncao_id" style="width: 450px;" class="chosen-select" data-placeholder="Selecione as Funções..." multiple required="">
                                <? foreach ($funcao as $value) : ?>
                                    <option value="<?= $value->aso_funcao_id; ?>"><?= $value->descricao_funcao; ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>    
                    </tr>
                    <!--<br>-->
                    <tr height="80px">

                        <th class="tabela_title">Riscos</th>
                        <td>                  
                            <select name="txtrisco_id[]" id="txtrisco_id" style="width: 450px;" class="chosen-select" data-placeholder="Selecione os Riscos..." multiple required="">
                                <? foreach ($riscos as $value) : ?>
                                    <option value="<?= $value->aso_risco_id; ?>"><?= $value->descricao_risco; ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>
                    </tr>                    
                    <tr height="80px">

                        <th class="tabela_title">Exames Complementares</th>
                        <td>                  
                            <select name="procedimentos[]" id="procedimentos" style="width: 450px;" class="chosen-select" data-placeholder="Selecione os Exames..." multiple >
                                <? foreach ($procedimento as $value) : ?>
                                    <option value="<?= $value->procedimento_convenio_id; ?>"><?= $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>
                    </tr>                    

                    <!--                    <br>-->
                </table>
                <table align="center">
                    <tr height="50px">
                        <td>
                            <button style="width:100px; height: 30px" type="submit" name="btnEnviar">Adicionar</button>
                        </td>
                    </tr>

                </table>
            </form>
            <br>


            <table id="table_agente_toxico" border="0">
                <thead>
                    <? // var_dump($cadastro);die; ?>
                    <tr>
                        <th class="tabela_header">Setor</th>
                        <th class="tabela_header">Função</th>
                        <th class="tabela_header">Risco</th>
                        <th class="tabela_header">Exames Complementares</th>
                        <th class="tabela_header" colspan="4">&nbsp;</th>
                    </tr>
                </thead>
                <?
    
                ?>
                <tbody>
                    <?
                    $estilo_linha = "tabela_content01";
                    ?>
                    <? foreach ($cadastro as $value) : ?>
                        <?
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $value->descricao_setor ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $value->descricao_funcao ?></td>
                            <td class="<?php echo $estilo_linha; ?>">
                                <?
                                $array_riscos = json_decode($value->risco_id);
                                foreach ($array_riscos as $key => $item) :
                                    $risco = $this->saudeocupacional->listarriscofuncao2($item);
                                    ?>
                                    <?
                                    if ($key == count($array_riscos) - 1) {
                                        echo $risco[0]->descricao_risco;
                                    } else {
                                        echo $risco[0]->descricao_risco . ", ";
                                    }
                                    ?>                

                                    <?
                                endforeach;
                                ?>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>">
                                <?
                                $array_exames = json_decode($value->exames_id);
                                if(count($array_exames)>0){
                                foreach ($array_exames as $key => $item) :
                                    $exames = $this->procedimento->listarprocedimentossetor($item);
                                    ?>
                                    <?
                                    if ($key == count($array_exames) - 1) {
                                        echo $exames[0]->nome;
                                    } else {
                                        echo $exames[0]->nome . ", ";
                                    }
                                    ?>                

                                    <?
                                endforeach;
                                }
                                ?>
                            </td>
                            <td class="<?php echo $estilo_linha; ?>">
                            <a onclick="javascript: return confirm('Deseja realmente excluir o Setor? ');" target="_blank"
                                               href="<?= base_url() ?>cadastros/convenio/excluirsetor/<?=$value->setor_cadastro_id?>/<?=$convenio_selecionado[0]->convenio_id?>">
                                               Excluir
                            </a>
                            </td> 
                            <td class="<?php echo $estilo_linha; ?>">
                            <a target="_blank" href="<?= base_url() ?>cadastros/convenio/editarsetor/<?=$value->setor_cadastro_id?>/<?=$convenio_selecionado[0]->convenio_id?>">
                                                Editar
                            </a>
                            </td> 
                        </tr>
                        <?
                    endforeach;
                    ?>

                </tbody>
                <?
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                        </th>
                    </tr>
                </tfoot>
            </table> 
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
        $("#procedimento").chosen({
            width: '100%'
        });
    });


    $(document).ready(function () {
        jQuery('#form_sala').validate({
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