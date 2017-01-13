<html>

    <h3>Servidores</h3>
    <table border="1" >
        <thead>
            <tr>

                <th>Matr&iacute;cula</th>
                <th>Nome</th>
                <th>Fun&ccedil;&atilde;o</th>
                <th>Sal&aacute;rio base</th>
                <th>Conta</th>
                <th>Agencia</th>
                <th>&nbsp;</th>
            </tr>

            <?php
                 foreach ($lista as $item) {
            ?>
                 <tr>
                    <td><?php echo $item->matricula; ?></td>
                    <td><?php echo $item->nome; ?></td>
                    <td><?php echo utf8_decode($item->classificacao); ?></td>
                    <td>R$ <?php echo  number_format($item->salario_base, 2, ",", "."); ?></td>
                    <td><?php echo $item->conta . "-" .  $item->conta_dv ; ?></td>
                    <td><?php echo $item->agencia . "-" .  $item->agencia_dv ; ?></td>
                    <td>____________</td>
                 </tr>

            <?php
                 }
            ?>
    </table>