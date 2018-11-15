<?php
const PAR = [
    'genero' => '',
];


function insertarGenero($pdo, $fila)
{
    if (comprobarGenero($pdo, $error)){
        return false;
    } else{
        $st = $pdo->prepare('INSERT INTO generos (genero)
                             VALUES (:genero)');
        $st->execute($fila);
    }

}

function modificarGenero($pdo, $fila, $id)
{
    $st = $pdo->prepare('UPDATE generos
                            SET genero = :genero
                          WHERE id = :id');
    $st->execute($fila + ['id' => $id]);
}

function mostrarFormulario($valores, $error, $pdo, $accion)
{
    extract($valores);
    $st = $pdo->query('SELECT * FROM generos');
    $generos = $st->fetchAll();
    ?>
    <br>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= $accion ?> un nuevo género...</h3>
            </div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group <?= hasError('genero', $error) ?>">
                        <label for="genero" class="control-label">Género</label>
                        <input id="genero" type="text" name="genero"
                               class="form-control" value="<?= $genero ?>">
                        <?php mensajeError('genero', $error) ?>
                    </div>
                    <input type="submit" value="<?= $accion ?>"
                           class="btn btn-success">
                    <a href="index.php" class="btn btn-info">Volver</a>
                </form>
            </div>
        </div>
    <?php
}
?>
