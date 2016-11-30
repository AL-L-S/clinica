<div class="content"> <!-- Inicio da DIV content -->
    <?if (count($empresa)>0){?>
    <h4><?= $empresa[0]->razao_social; ?></h4>
    <?}else{?>
    <h4>TODAS AS CLINICAS</h4>
    <?}?>
    <h4>Relatorio Laudo Palavra Chave</h4>
    <h4>PERIODO: <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_inicio) ) ); ?> ate <?= str_replace("-","/",date("d-m-Y", strtotime($txtdata_fim) ) ); ?></h4>
    <hr>
    <h4>Palavra: <?= $palavra; ?></h4>
    <hr>
    <? if ($contador > 0) {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="tabela_header"><font size="-1">Paciente</th>
                    <th class="tabela_header"><font size="-1">Dt. Nascimento</th>
                    <th class="tabela_header"><font size="-1">Telefone</th>
                    <th class="tabela_header" width="350px;"><font size="-1">Endere&ccedil;o</th>
                    <th class="tabela_header"><font size="-1">Sexo</th>
                    <th class="tabela_header"><font size="-1">Medico</th>
                    <th class="tabela_header" width="200px;"><font size="-1">Procedimento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $valor = 0;
                $valortotal = 0;
                $convenio = "";
                foreach ($relatorio as $item) :
                    $i++;


                        ?>
                        <tr>
                            <td><font size="-2"><?= utf8_decode($item->paciente); ?></td>
                            <td><font size="-2"><?= substr($item->nascimento, 8,2) . "/" . substr($item->nascimento, 5,2) . "/" . substr($item->nascimento, 0,4); ?></td>
                            <td><font size="-2"><?= "(" . substr($item->telefone,0,2) . ")" . substr($item->telefone,4,4) . "-" . substr($item->telefone,4,4); ?></td>
                            <td><font size="-2"><?= $item->tipologradouro . " " . utf8_decode($item->logradouro) . " " . utf8_decode($item->numero) . " " . utf8_decode($item->bairro); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->sexo); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->medico); ?></td>
                            <td><font size="-2"><?= utf8_decode($item->procedimento); ?></td>
                        </tr>


                        <?php
                endforeach;
                ?>
                <tr>
                    <td ><font size="-1">TOTAL</td>
                    <td colspan="6" ><font size="-1">Nr. Exa: <?= $i; ?></td>
                </tr>
            </tbody>
        </table>
        <hr>
    <? } else {
        ?>
        <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
        <?
    }
    ?>

</div> <!-- Final da DIV content -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">



    $(function() {
        $( "#accordion" ).accordion();
    });

</script>