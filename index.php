<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Bases de datos</title>
    </head>
    <?php
    $con = new PDO('pgsql:host=localhost;dbname=fa', 'fa', 'fa'); //conexion
    $numFilas = $con->exec("INSERT INTO genero (genero)
                            VALUES ('Costumbrismo')");
    $st = $con->query('SELECT * FROM generos'); //sentencia
    ?>
    <style>
    th, td {border-bottom: 1px solid #ddd;}
    </style>
    <table style="margin:auto">
        <thead>
            <th>Id</th>
            <th>Género</th>
        </thead>
        <tbody>
    <?php foreach ($st as $fila): ?>
         <tr>
             <td><?= $fila['id']; ?></td>
             <td><?= $fila['genero']; ?></td>
         </tr>
     <?php endforeach; ?>
 </tbody>
</table>
</html>
