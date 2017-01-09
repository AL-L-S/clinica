<html>

    <h3><center>SUPLEMNETAR</center></h3>
    <table border="1" >
        <thead>
            <tr>
                <tr bgcolor ="gray">
                <th>Matr&iacute;cula</th>
                <th>Nome</th>
                <th>Fun&ccedil;&atilde;o</th>
                <th>Valor</th>
                <th>&nbsp;</th>
            </tr>

            <?php
            $total = 0;
                 foreach ($lista as $item) {
            ?>
                 <tr>
                    <td><?php echo $item->matricula; ?></td>
                    <td><?php echo $item->nome; ?></td>
                    <td><?php echo $item->funcao; ?></td>
                    <td>R$ <?php echo  number_format($item->valor, 2, ",", "."); ?></td>
                    <td>__________________</td>
                 </tr>

            <?php
            $total = $total + $item->valor;
                 }
            ?>
                 <tr bgcolor ="gray">
                 <tr>
                     <td colspan="3">TOTAL</td>
                    <td>R$ <?php echo  number_format($total, 2, ",", "."); ?></td>
                    <td>__________________</td>
                 </tr>
    </table>