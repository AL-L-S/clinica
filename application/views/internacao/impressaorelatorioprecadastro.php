
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <h4 class="title_relatorio">Relatório Pré-Cadastro</h4>
    <p></p>
    <h4 class="title_relatorio">Inicio: <?= $data_inicio; ?> - Fim: <?= $data_fim; ?> </h4>
    <h4 class="title_relatorio">Tipo de Dependência: <?= @$tipo_dependencia; ?> </h4>
    <h4 class="title_relatorio">Aceita Tratamento: <?= (@$_POST['aceita_tratamento'] != '') ? $_POST['aceita_tratamento'] : 'TODOS'; ?> </h4>
    <h4 class="title_relatorio">Indicação: <?= @$indicacao; ?> </h4>
    <h4 class="title_relatorio">Convênio: <?= @$convenio; ?> </h4>
    <h4 class="title_relatorio">Cidade: <?= @$cidade; ?> </h4>


    <? if (count($precadastro) > 0) { ?>
        <hr/>
        <table border='1' cellspacing=0 cellpadding=5>
            <tr>
                <th class="tabela_header">
                    Convênio
                </th>
                <th class="tabela_header">
                    Paciente
                </th>
                <th class="tabela_header">
                    Responsável
                </th>
                <th class="tabela_header">
                    Data
                </th>
                <th class="tabela_header">
                    Tipo Depêndencia
                </th>
                <th class="tabela_header">
                    Aceita Tratamento
                </th>
                <th class="tabela_header">
                    Indicação
                </th>
                <th class="tabela_header">
                    Cidade
                </th>
                <th class="tabela_header">
                    Telefone
                </th>
                <th class="tabela_header">
                    Ligação Confi.
                </th>
                <th class="tabela_header">
                    Aprovado
                </th>


            </tr>
            <tr>
                <?
                $totaletapas = 0;
                $totalpacientes = 0;
                $paciente = "";
                $etapas = "";
                $internacao_precricao_id = "";
                $estilo_linha = "tabela_content01";
                $teste = 0;
                $total_cadastros = 0;
                $dependencia = array();
                $dependencia_id = array();
                foreach($dependencias as $value){

                    array_push($dependencia, $value->nome);
                    array_push($dependencia_id, $value->internacao_tipo_dependencia_id);

                }
                // var_dump($_POST['tipo_dependencia']); die;
                foreach ($precadastro as $item) {



                    $dependencia_nomes = '';
                    $array_dependencia = json_decode($item->dependencia);
                    if ($_POST['tipo_dependencia'] > 0) {
                        // Caso não tenha no array algo igual do que foi pesquisado no POST ele pula a linha
                        if (!in_array($_POST['tipo_dependencia'], $array_dependencia)) {
                            continue;
                        }

                    }
                    $total_cadastros++;
                    foreach($array_dependencia as $value){
                        $key = array_search($value, $dependencia_id);
                        $dependencia_loop = $dependencia[$key];
                        if($dependencia_nomes == ''){
                            $dependencia_nomes = $dependencia_nomes . $dependencia_loop;
                        }else{
                            $dependencia_nomes = $dependencia_nomes . ', ' . $dependencia_loop;
                        }
                    }


                    ?>
                <tr>
                    <td ><?= ($item->convenio != '') ? $item->convenio : '<b>Não Tem</b>'; ?></td>
                    <td ><?= $item->paciente; ?></td>
                    <td ><?= $item->responsavel; ?></td>
                    <td ><?= date("d/m/Y", strtotime($item->data_cadastro)); ?></td>
                    <td ><?= $dependencia_nomes; ?></td>
                    <td ><?= ($item->aceita_tratamento == 'SIM') ? 'Sim' : 'Não'; ?></td>
                    <td ><?= $item->indicacao; ?></td>
                    <td ><?= $item->cidade; ?></td>
                    <td ><?= $item->telefone; ?></td>
                    <td ><?= ($item->confirmado == 't') ? 'Sim' : 'Não'; ?></td>
                    <td ><?= ($item->aprovado == 't') ? 'Sim' : 'Não'; ?></td>
                </tr>
                <?
            }
            ?>
            <tr><th colspan="12" class="tabela_header">Total de Pré-Cadastros: <?= $total_cadastros; ?></th></tr>
        </table>
    <? } else { ?>
        <br> <hr/>
        <h2 class="title_relatorio">Sem Registros </h2>
    <? } ?>


</div> 

<!-- Reset de CSS para garantir o funcionamento do layout em todos os brownsers -->

<script type="text/javascript">

</script>