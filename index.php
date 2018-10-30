<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>FilmAffinity</title>
</head>
<body>
    <?php
    require 'aux.php';
    $pdo = conectar();

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $pdo ->beginTransaction();
        $pdo->exec('LOCK TABLE peliculas IN SHARE MODE');
        if (!buscarPelicula($pdo, $id)){ ?>
            <h3>La pelicula no existe</h3>
        <?php
        } else{
            $stBorrar = $pdo -> prepare('DELETE FROM peliculas WHERE id = :id');
            $stBorrar -> execute([':id' => $id]); ?>
            <h3>Pelicula borrada correctamente</h3>
        <?php
        }
        $pdo->comit();
    }
    $buscarTitulo = isset($_GET['buscarTitulo']) ? trim($_GET['buscarTitulo']) : '';
    $stPeliculas = $pdo->prepare('SELECT p.*, genero
        FROM peliculas p JOIN generos g ON p.genero_id = g.id
        WHERE position(lower(:titulo) in lower(titulo)) != 0;');
        $stPeliculas -> execute([':titulo'=>$buscarTitulo]);
        ?>

        <div>
            <fieldset>
                <legend>Buscar...</legend>
                <form action="" method="get">
                    <label for="buscarTitulo">Buscar por titulo</label>
                    <input id="buscarTitulo" type="text" name="buscarTitulo" value="<?= $buscarTitulo ?>">
                    <input type="submit" value="Buscar">
                </form>
            </fieldset>
        </div>

        <div style="margin-top: 20px">
            <table border="1" style="margin:auto">
                <thead>
                    <th>Titulo</th>
                    <th>Año</th>
                    <th>Sinopsis</th>
                    <th>Duración</th>
                    <th>Género</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php foreach ($stPeliculas as $fila) { ?>
                        <tr>
                            <td><?= $fila['titulo'] ?></td>
                            <td><?= $fila['anyo'] ?></td>
                            <td><?= $fila['sinopsis'] ?></td>
                            <td><?= $fila['duracion'] ?></td>
                            <td><?= $fila['genero'] ?></td>
                            <td> <a href="confirm_borrado.php?id=<?= $fila['id'] ?>">Borrar</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>
