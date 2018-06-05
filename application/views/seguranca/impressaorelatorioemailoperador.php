<!--<div class="content">  Inicio da DIV content -->
<meta charset="utf-8"/>
<? // $tipoempresa = ""; ?>
<table>
    <thead>


        <tr>
            <th style='text-align: left; font-family: serif; font-size: 12pt;' colspan="4">Relatorio Operador</th>
        </tr>
        <tr>
            <th style='width:10pt;border:solid windowtext 1.0pt;
                border-bottom:none;mso-border-top-alt:none;border-left:
                none;border-right:none;' colspan="4">&nbsp;</th>
        </tr>




    </thead>
</table>

<? if (count($relatorio) > 0) {
    ?>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <td class="tabela_teste">Operador ID</td>
                <td class="tabela_teste" style='text-align: center;'>Perfil</td>  
                <td class="tabela_teste">Nome</td>
                <td class="tabela_teste">Nascimento</td>   
                <td class="tabela_teste">Telefone</td>  
                <td class="tabela_teste" style='text-align: center;'>Email</td>  
                <td class="tabela_teste">CPF</td>  
                <td class="tabela_teste" style='text-align: center;'>Ocupação</td>  
            </tr>
        </thead>
        <hr>
        <tbody>
            <?php
            $contador = 0;
            $i = 0;
            $b = 0;
            $c = 0;
            $qtde = 0;
            $qtdetotal = 0;
            $tecnicos = "";
            $paciente = "";
            $indicacao = "";
//            $this->load->library('utilitario');

            foreach ($relatorio as $item) :
                $i++;
                $qtdetotal++;
                ?>



                <tr >
                    <td><?= $item->operador_id; ?></td>
                    <td style='text-align: center;'><?= $item->perfil ?></td>
                    <td><?= $item->nome; ?></td>
                    <td style='text-align: center;'><? if($item->nascimento != ''){ echo date('d/m/Y', strtotime($item->nascimento)); }   ?></td>
                    <?
                    $telefone = $item->telefone;
                    if($telefone == ''){
                        $telefone = $item->celular;
                    }
                    ?>
                    <td><?= $telefone ?></td>
                    <td style='text-align: center;'><?= $item->email ?></td>
                    <td style='text-align: center;'><?= $item->cpf ?></td>
                    <td style='text-align: center;'><?= $item->cbo ?></td>
                </tr>

                <?
                $contador++;
            endforeach;
            ?>

            <tr>
                <td width="140px;" align="Right" colspan="4"><b>Total:&nbsp; <?= $qtdetotal; ?></b></td>
            </tr>
        </tbody>
    </table>



<? } else {
    ?>
    <h4>N&atilde;o h&aacute; resultados para esta consulta.</h4>
<? }
?>


<!--</div>  Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>js/morris/morris.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/Gruntfile.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/morris/morris.js" ></script>
<script src="<?= base_url() ?>js/morris/raphael.js"></script>


<script>

    $(document).ready(function () {
        $("#teste").click(function () {
            $("#adultos").fadeIn(1000);
            $("#adultoslabel").fadeIn(1000);
            $("#esconder").fadeIn(1000);
//            $("#adultos").css( "display", "block" );
//            $("#adultos").css( "display", "none" );
        });
        $("#esconder").click(function () {
            $("#adultos").fadeOut(1000);
            $("#adultoslabel").fadeOut(1000);
            $("#esconder").fadeOut(1000);
        });
    });
</script>
