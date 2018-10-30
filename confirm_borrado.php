<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Confirmar borrado</title>
    </head>
    <body>
        <?php
        require 'aux.php';
        if (isset($_GET['id'])){
            $id = $_GET['id'];
        } else{
            header('location: index.php'); //Salida en buffer
        }
        $pdo=conectar();

        if (!buscarPelicula($pdo, $id)){
            header('location: index.php');
        }
        ?>
        <h3>¿Seguro que desea eliminar la fila?</h3>
        <form action="index.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="Si">
            <a href="index.php">No</a>
        </form>
    </body>
</html>
