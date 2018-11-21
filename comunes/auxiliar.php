<?php
const PAR_LOGIN = ['login' => '', 'password' => ''];

class ValidationException extends Exception
{
}
class ParamException extends Exception
{
}
class EmptyParamException extends Exception
{
}
/**
 * Conecta con la BD
 */
function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=fa', 'fa', 'fa');
}

/**
 * Comprueba los parametros.
 * @param  array      $par   El array de valores
 * @throws new EmptyParamException()  si no se reciben comprobarParametros
 *            ParamException() si los parametros son erroneos
 */
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
/**
 * Comprueba los errores del array
 * @param  array      $error   El array de errores
 * @throws new ValidationException si el array no esta vacio
 */
function comprobarErrores($error)
{
    if (!empty($error)) {
        throw new ValidationException();
    }
}
/**
 *
 * @param  key        $key     La clave del array
 * @param  array      $error   El array de errores
 */
function hasError($key, $error)
{
    return array_key_exists($key, $error) ? 'has-error' : '';
}
/**
 * Muestra el mensaje de error
 * @param  key        $key     La clave del array
 * @param  array      $error   El array de errores
 */
function mensajeError($key, $error)
{
    if (isset($error[$key])) { ?>
        <small class="help-block"><?= $error[$key] ?></small>
    <?php
    }
}
/**
 * Evita el XSS
 * @param  String        $cadena     Codigo a depurar
 * @return htmlspecialchars($cadena, ENT_QUOTES)
 */
function h($cadena)
{
    return htmlspecialchars($cadena, ENT_QUOTES);
}
/**
 * Comprueba que el id existe y es valido
 * @throws ParamException si el id es erroneo
 * @return $id
 */
function comprobarId()
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === null || $id === false) {
        throw new ParamException();
    }
    return $id;
}
/**
 * Comprueba que existe la pelicula recibida
 * @param  PDO        $pdo     Objeto PDO usado para buscar al usuario
 * @param  BIGSERIAL  $id      Identificador de la pelicula
 * @throws new ParamException() si no existe
 * @return $fila      La fila de la consulta si es válida
 */
function comprobarPelicula($pdo, $id)
{
    $fila = buscarPelicula($pdo, $id);
    if ($fila === false) {
        throw new ParamException();
    }
    return $fila;
}
/**
 * Funcion para seleccionar una opción por defecto
 * @return  $a == $b ? 'selected' : '';
 */
function selected($a, $b)
{
    return $a == $b ? 'selected' : '';
}
/**
 * Trimea y comprueba que el nombre de usuario no es vacio
 * @param  array      $error   El array de errores
 * @return $login si existe y es valido
 */
function comprobarLogin(&$error)
{
    $login = trim(filter_input(INPUT_POST, 'login'));
    if ($login === '') {
        $error['login'] = 'El nombre de usuario no puede estar vacío.';
    }
    return $login;
}
/**
 * Trimea y comprueba que ela contraseña no es vacia
 *
 * @param  array      &$error   El array de errores
 * @return $password si no es vacia
 */
function comprobarPassword(&$error)
{
    $password = trim(filter_input(INPUT_POST, 'password'));
    if ($password === '') {
        $error['password'] = 'La contraseña no puede estar vacía.';
    }
    return $password;
}
/**
 * Comprueba si existe el usuario indicado en el array
 * $valores, con el nombre y la contraseña dados.
 *
 * @param  array      $valores El nombre y la contraseña
 * @param  PDO        $pdo     Objeto PDO usado para buscar al usuario
 * @param  array      $error   El array de errores
 * @return array|bool          La fila del usuario si existe; false e.o.c.
 */
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
            return $fila;
        }
    }
    $error['sesion'] = 'El usuario o la contraseña son incorrectos.';
    return false;
}

function insertarUsuario($pdo,$fila){
    $st = $pdo->prepare('INSERT INTO usuarios (login, password)
                         VALUES (:login, :password)');
    $st->execute($fila);
}

function mostrarCabezera(){
    ?>
    <nav class="navbar navbar-default navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">FilmAffinity</a>
                <a class="navbar-brand" href="/peliculas/">Películas</a>
                <a class="navbar-brand" href="/generos/">Géneros</a>
            </div>
            <div class="navbar-text navbar-right">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <?= $_SESSION['usuario'] ?>
                        <a href="/logout.php" class="btn btn-danger">Logout</a>
                    <?php else: ?>
                        <a href="/login.php" class="btn btn-success">Login</a>
                    <?php endif ?>
            </div>
        </div>
    </nav>
    <?php
}

function pie(){
    ?>
    <hr>
    <nav class="navbar navbar-default navbar-inverse">
        <div class="container">
            <p class="">
                Copyright (c) 2018 Todos los derechos reservados
            </p>
        </div>
    </nav>
    <?php
}
