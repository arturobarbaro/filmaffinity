<?php
const PAR = [
    'genero' => '',
];

function insertarGenero($pdo, $fila)
{
    $st = $pdo->prepare('INSERT INTO generos (genero)
                         VALUES (:genero)');
    $st->execute($fila);
}

 ?>