<?php
if (is_object($pagosExport)) {
    ?><table class="table">

    <tr>
        <th></th>
        <th>Participante</th>
        <th>Fecha</th>
        <th>Monto</th>
        <th>Estado</th>
        <th>Origen</th>
        <th>Datos</th>
    </tr>
    <?php foreach($pagosExport as $c): ?>
        <tr>
            <td></td>
            <td><?= h($c->participante->apellido) ?>, <?= h($c->participante->nombre) ?> ( <?= h($c->participante->email) ?> )</td>
            <td><?= h($c->created->format('d/m/Y H:i')) ?></td>
            <td><?= h($c->monto) ?></td>
            <td><?= h($c->status) ?></td>
            <td><?= h($c->origen) ?></td>
            <td><?= h($c->datos) ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php }
?>



                