<head>
    <title>Prescrição</title>
</head>
<div >
    <?
    $dataFuturo = date("Y-m-d");
    $dataAtual = @$obj->_nascimento;
    $date_time = new DateTime($dataAtual);
    $diff = $date_time->diff(new DateTime($dataFuturo));
    $teste = $diff->format('%Ya %mm %dd');

    if (count($receita) == 0) {
        $receituario_id = 0;
        $texto = "";
        $medico = "";
        $procedimento;
    } else {
        $procedimento = $receita[0]->procedimento;
        $texto = $receita[0]->texto;
        $receituario_id = $receita[0]->ambulatorio_receituario_id;
        $medico = $receita[0]->medico_parecer1;
    }
    $operador_id = $this->session->userdata('operador_id');
    ?>

    <div >
        <form name="form_prescricao" id="form_prescricao" action="<?= base_url() ?>ambulatorio/laudo/gravarprescricao/<?= $ambulatorio_laudo_id ?>/<?= $obj->_paciente_id ?>" method="post">
            <div >    
                <fieldset>
                    <legend>Cadastro de Prescrições</legend>
                    <table width="100%" height="50px">
                        <thead>
                            <tr>
                                <th colspan="5" class="tabela_title">
                            </tr>
                        </thead>

                        <tr height="50px">
                            <th class="tabela_title">Prescrição:</th>
                            <td>                            
                                <input type="text" name="prescricao" value="" class="texto10" />

                                <button style="width:100px; height: 30px" type="submit" name="btnEnviar">Adicionar</button>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div> 
        </form>
    </div> 
    <div>
        <fieldset>
            <table id="table_agente_toxico"  border="1" style="border-collapse: collapse; text-align: center" align="center" width="100%">
                <tr>
                    <th class="tabela_header">Data Cadastro</th>
                    <th class="tabela_header">Prescrição</th>

                    <th class="tabela_header" colspan="4">Opções</th>
                </tr>
                <?
                $estilo_linha = "tabela_content01";
                foreach ($prescricao as $value) {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                   
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= substr($value->data_cadastro, 8, 2) . "/" . substr($value->data_cadastro, 5, 2) . "/" . substr($value->data_cadastro, 0, 4); ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $value->prescricao ?></td>                        
                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                <a onclick="javascript: return confirm('Deseja realmente excluir a Prescrição? ');" target="_blank"
                                   href="<?= base_url() ?>ambulatorio/laudo/excluirprescricao/<?= $value->prescricao_id ?>/<?= $ambulatorio_laudo_id ?>/<?= $obj->_paciente_id ?>">
                                    Excluir
                                </a></div>
                            </td> 
                            <td class="<?php echo $estilo_linha; ?>" width="60px;"><div class="bt_link">
                                <a href="<?= base_url() ?>ambulatorio/laudo/editarprescricao/<?= $value->prescricao_id ?>/<?= $ambulatorio_laudo_id ?>/<?= $obj->_paciente_id ?>">
                                    Editar
                                </a></div>
                            </td>                         
                        </tr>
                        <?                  
                    }
                    ?>                
                </table>
            </fieldset>
        </div>

    </div> <!-- Final da DIV content -->
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; width: 1300px; }
        #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
    </style>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>css/style_p.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
    <!--<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>-->
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

</script>
