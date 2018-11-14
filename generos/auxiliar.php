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
?>
