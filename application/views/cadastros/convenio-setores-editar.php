<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion"> 
        <h2 class="singular"><a href="#">Cadastro de Setores</a></h2>
        
        <div>
            <form name="form_convenio" id="form_convenio" action="<?= base_url() ?>cadastros/convenio/editarsetorempresa/<?= $setor_selecionado[0]->setor_cadastro_id ?>/<?= $convenio_selecionado[0]->convenio_id ?>" method="post">
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
                    <? // var_dump($setor_selecionado[0]);die;?>
                    <!--<br><br>-->              
                    <tr height="50px">
                        <th class="tabela_title">Setor</th>
                        <td>
                           <input type="text" name="setor_selecionado" value="<?= $setor_selecionado[0]->descricao_setor; ?>" readonly="" /> 
                        </td>
                    </tr>
                    <!--<br>-->
                    <tr height="100px">

                        <th class="tabela_title">Funções</th>
                        <td>                   
                           <input type="text" name="setor_selecionado" value="<?= $setor_selecionado[0]->descricao_funcao; ?>" readonly="" />
                        </td>    
                    </tr>
                    <!--<br>-->
                    <tr height="80px">
                        
                        <?
//                        var_dump(@$cadastro[0]);die;
                        if(count(json_decode($setor_selecionado[0]->risco_id)) > 0){
                            $array_risco = json_decode($setor_selecionado[0]->risco_id);
                        }else{
                            $array_risco = array();
                        }
//                        var_dump($array_risco);die;
                        ?>

                        <th class="tabela_title">Riscos</th>
                        <td>                 
                            <select name="txtrisco_id[]" id="txtrisco_id" style="width: 450px;" class="chosen-select" data-placeholder="Selecione os Riscos..." multiple required="">
                                <? foreach ($riscos as $value) : ?>
                                    <option value="<?= $value->aso_risco_id; ?>"<? if (in_array($value->aso_risco_id,$array_risco)):echo 'selected'; endif;
                                    ?>>                    

                                        <?= $value->descricao_risco; ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>
                    </tr>                    
                    <tr height="80px">
                        
                        <?
                        if(count(json_decode($setor_selecionado[0]->exames_id)) > 0){
                            $array_exames = json_decode($setor_selecionado[0]->exames_id);
                        }else{
                            $array_exames = array();
                        }
                        ?>

                        <th class="tabela_title">Exames Complementares</th>
                        <td>                 
                        <? //echo'<pre>';var_dump($procedimento);die;?>
                            <select name="procedimentos[]" id="procedimentos" style="width: 450px;" class="chosen-select" data-placeholder="Selecione os Exames Complementares..." multiple required="">
                                <? foreach ($procedimento as $value) : ?>
                                    <option value="<?= $value->procedimento_convenio_id; ?>"<? if (in_array($value->procedimento_convenio_id, $array_exames)):echo 'selected'; endif;
                                    ?>> 
                                        <?= $value->nome; ?></option>
                                <? endforeach; ?>
                            </select>
                        </td>
                    </tr>                    

                    <!--                    <br>-->
                </table>
                <table align="center">
                    <tr height="50px">
                        <td>
                            <button style="width:100px; height: 30px" type="submit" name="btnEnviar">Enviar</button>
                        </td>
                    </tr>

                </table>
            </form>
            <br>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
 $(function () {
        $("#accordion").accordion();
        $("#procedimento").chosen({
            width: '100%'
        });
    });
</script>