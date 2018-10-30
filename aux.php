<?php
function conectar(){
    return $pdo = new PDO('pgsql:host=localhost;dbname=fa', 'fa', 'fa');
}

function buscarPelicula($pdo, $id){
    $st = $pdo -> prepare('DELETE FROM peliculas WHERE id = :id');
    $st -> execute([':id' => $id]);
    return $st->fetch();
}
