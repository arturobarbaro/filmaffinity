<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Bases de datos</title>
    </head>
    <body>
        <?php
        //Mantener titutlo
        $buscarTitulo = isset($_GET['buscarTitulo'])
                        ? trim($_GET['buscarTitulo']) : '';

        $con = new PDO('pgsql:host=localhost;dbname=fa', 'fa', 'fa'); //conexion
        $st = $con->prepare("SELECT *
                            FROM peliculas
                            WHERE titulo ILIKE :titulo"); //sentencia
        $st->execute([':titulo'=> "%$buscarTitulo%"]);
        ?>
        <div class="">
            <fieldset>
                <legend>Buscar...</legend>
                <form action="" method="get">
                    <label for="buscarTitulo">Buscar for titutlo: </label>
                    <input id="buscarTitulo" type="text" name="buscarTitulo"
                    value="<?= $buscarTitulo ?>">
                    <input type="submit" value="Buscar">
                </form>
            </fieldset>
        </div>
        <div style="margin-top: 20px">
            <style>
            th, td {border-bottom: 1px solid #ddd;}
            </style>
            <table style="margin:auto">
                <thead>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Año</th>
                    <th>Sinopsis</th>
                    <th>Duracion</th>
                    <th>Género id</th>
                </thead>
                <tbody>
            <?php foreach ($st as $fila): ?>
                 <tr>
                     <td><?= $fila['id']; ?></td>
                     <td><?= $fila['titulo']; ?></td>
                     <td><?= $fila['anyo']; ?></td>
                     <td><?= $fila['sinopsis']; ?></td>
                     <td><?= $fila['duracion']; ?></td>
                     <td><?= $fila['genero_id']; ?></td>
                 </tr>
             <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </body>
</html>
