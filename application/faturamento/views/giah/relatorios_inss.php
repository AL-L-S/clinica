<html>

    <h3><center>INSS</center></h3>
    <table border="1" >
        <thead>
            <tr>
                <tr bgcolor ="gray">
                <th>Matr&iacute;cula</th>
                <th>Nome</th>
                <th>cpf</th>
                <th>Valor</th>
            </tr>

            <?php
            $total = 0;
            foreach ($lista as $item) {
            ?>
                <tr>
                    <td><?php echo $item->matricula; ?></td>
                    <td><?php echo $item->nome; ?></td>
                    <td><?php echo $item->cpf; ?></td>
                    <td>R$ <?php echo number_format($item->inss, 2, ",", "."); ?></td>
                </tr>

            <?php
            $total = $total + $item->inss;
            }
            ?>
            <tr>
                <tr bgcolor ="gray">
                <td colspan="3">TOTAL</td>
                <td>R$ <?php echo number_format($total, 2, ",", "."); ?></td>
            </tr>
    </table>
