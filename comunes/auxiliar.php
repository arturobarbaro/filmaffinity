<?php
class ValidationException extends Exception
{
}
class ParamException extends Exception
{
}
class EmptyParamException extends Exception
{
}
function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=fa', 'fa', 'fa');
}

function comprobarParametros($par)
{
    if (empty($_POST)) {
        throw new EmptyParamException();
    }
    if (!empty(array_diff_key($par, $_POST)) ||
        !empty(array_diff_key($_POST, $par))) {
        throw new ParamException();
    }
}
function comprobarErrores($error)
{
    if (!empty($error)) {
        throw new ValidationException();
    }
}
function hasError($key, $error)
{
    return array_key_exists($key, $error) ? 'has-error' : '';
}
function mensajeError($key, $error)
{
    if (isset($error[$key])) { ?>
        <small class="help-block"><?= $error[$key] ?></small>
    <?php
    }
}

function h($cadena)
{
    return htmlspecialchars($cadena, ENT_QUOTES);
}
function comprobarId()
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === null || $id === false) {
        throw new ParamException();
    }
    return $id;
}
function comprobarPelicula($pdo, $id)
{
    $fila = buscarPelicula($pdo, $id);
    if ($fila === false) {
        throw new ParamException();
    }
    return $fila;
}

function selected($a, $b)
{
    return $a == $b ? 'selected' : '';
}
function comprobarLogin(&$error)
{
    $login = trim(filter_input(INPUT_POST, 'login'));
    if ($login === '') {
        $error['login'] = 'El nombre de usuario no puede estar vacío.';
    }
    return $login;
}
function comprobarPassword(&$error)
{
    $password = trim(filter_input(INPUT_POST, 'password'));
    if ($password === '') {
        $error['password'] = 'La contraseña no puede estar vacía.';
    }
    return $password;
}
function comprobarUsuario($valores, $pdo, &$error)
{
    extract($valores);
    $st = $pdo->prepare('SELECT *
                           FROM usuarios
                          WHERE login = :login');
    $st->execute(['login' => $login]);
    $fila = $st->fetch();
    if ($fila !== false) {
        if (password_verify($password, $fila['password'])) {
            return;
        }
    }
    $error['sesion'] = 'El usuario o la contraseña son incorrectos.';
}


//MIAS
function buscarGenero($pdo, $id)
{
    $st = $pdo->prepare('SELECT * FROM generos WHERE id = :id');
    $st->execute([':id' => $id]);
    return $st->fetch();
}


function comprobarGenero($pdo, &$error)
{
    $fltGenero = trim(filter_input(INPUT_POST, 'genero'));
    if ($fltGenero === '') {
        $error['genero'] = 'El género es obligatorio.';
    } elseif (mb_strlen($fltGenero) > 255) {
        $error['genero'] = "El género es demasiado largo.";
    }
    return $fltGenero;
}

function mostrarCabezera(){
    ?>
    <nav class="navbar navbar-default navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">FilmAffinity</a>
            </div>
            <div class="navbar-text navbar-right">
                <a href="../comunes/login.php" class="btn btn-success">Login</a>
            </div>
        </div>
    </nav>
    <?php
}
