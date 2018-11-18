<?php
const PAR = [
    'genero' => '',
];
//MIAS
/**
 *
 */
function buscarGenero($pdo, $id)
{
    $st = $pdo->prepare('SELECT * FROM generos WHERE id = :id');
    $st->execute([':id' => $id]);
    return $st->fetch();
}

function comprobarGenero($pdo, &$error)
{
    $error=[];
    $fltGenero = trim(filter_input(INPUT_POST, 'genero'));
    if ($fltGenero === '') {
        $error['genero'] = 'El género es obligatorio.';
    } elseif (mb_strlen($fltGenero) > 255) {
        $error['genero'] = "El género es demasiado largo.";
    }
    return $fltGenero;
}

function insertarGenero($pdo, $fila)
{
    $st = $pdo->prepare('INSERT INTO generos (genero)
                             VALUES (:genero)');
    $st->execute($fila);

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
                               class="form-control" value="<?= h($genero) ?>">
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
