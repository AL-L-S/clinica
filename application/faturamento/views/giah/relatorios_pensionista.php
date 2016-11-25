<html>

    <h3>PENSIONISTAS</h3>
    <table border="1" >
        <thead>
            <tr>               
                <th>Nome</th>
                <th>Percentual</th>
                <th>Matr&iacute;cula</th>
                <th>&nbsp;</th>

            </tr>

            <?php
                 foreach ($lista as $item) {
            ?>
                 <tr>
                    <td><?= $item->nome;?></td>
                    <td><?= $item->percentual;?> %</td>
                    <td><?= $item->matricula;?></td>
                    <td>__________________</td>
                 </tr>

            <?php
                 }
            ?>
    </table>