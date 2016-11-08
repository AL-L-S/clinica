<?php
$html ='';?>

<h3>CEATOX </h3>

  <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Matr&iacute;cula</th>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Percentual</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                    <?

                        $i = 0;
                        foreach ($lista as $item) :
                            if ($i % 2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;?>
                        <tr>
                                <td class="<?= $classe; ?>"><?= $item->matricula; ?></td>
                                <td class="<?= $classe; ?>"><?= $item->nome; ?></td>
                                <td class="<?= $classe; ?>"><?= $item->percentual; ?></td>
                                <td class="<?= $classe; ?>">__________________</td>
                        </tr>
                        <?endforeach;?>
</table>

<?php
require_once(BASEPATH.'plugins/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper('letter', 'landscape');
    $dompdf->render();
    $dompdf->stream("exemplo-01.pdf");
?>