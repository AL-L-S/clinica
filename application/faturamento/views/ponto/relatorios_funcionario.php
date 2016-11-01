<html>

    <h3><center>Funcionario<center></h3>
    <table border="1" >
        <thead>
            <tr bgcolor ="gray">

                <th>Matr&iacute;cula</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Fun&ccedil;&atilde;o</th>
                <th>Setor</th>
                <th>Horario</th>
            </tr>

            <?php
                 foreach ($lista as $item) {
            ?>
                 <tr>
                    <td><?php echo $item->matricula; ?></td>
                    <td><?php echo utf8_decode($item->nome); ?></td>
                    <td><?php echo utf8_decode($item->cargo); ?></td>
                    <td><?php echo utf8_decode($item->funcao); ?></td>
                    <td><?php echo utf8_decode($item->setor); ?></td>
                    <td><?php echo utf8_decode($item->horariostipo); ?></td>
                 </tr>

            <?php
                 }
            ?>
    </table>