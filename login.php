<?php session_start() ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Iniciar sesión</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <?php
        require './comunes/auxiliar.php';

        mostrarCabezera();

        try {
            $error = [];
            $pdo = conectar();
            comprobarParametros(PAR_LOGIN);
            $valores = array_map('trim', $_POST);
            $flt['login'] = comprobarLogin($error);
            $flt['password'] = comprobarPassword($error);
            $usuario = comprobarUsuario($flt, $pdo, $error);
            comprobarErrores($error);
            // Sólo queda loguearse
            $_SESSION['usuario'] = $usuario['login'];
            header('Location: index.php');
        } catch (EmptyParamException|ValidationException $e) {
            // No hago nada
        } catch (ParamException $e) {
            header('Location: index.php');
        }
        ?>
        <div class="container">
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="row">
                    <div class="alert alert-success" role="alert">
                        <?= $_SESSION['mensaje'] ?>
                    </div>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif ?>
            <div class="row">
                <form action="" method="post">
                    <div class="form-group <?= hasError('login', $error) ?>">
                        <label for="login" class="control-label">Usuario:</label>
                        <input id="usuario" class="form-control" type="text" name="login" value="">
                    </div>
                    <div class="form-group <?= hasError('password', $error)?>">
                        <label for="password">Contraseña:</label>
                        <input class="form-control" type="password" name="password" value="">
                    </div>
                    <?php
                    //if (!isset($_SESSION['mensaje'])){
                        if (!comprobarLogin($error)){
                            mensajeError('login', $error);
                        } elseif (!comprobarPassword($error)){
                            mensajeError('password', $error);
                        } elseif (!comprobarUsuario($flt, $pdo, $error)){
                            mensajeError('sesion', $error);
                        }
                    //}
                    ?>
                    <button type="submit" class="btn btn-success">Iniciar sesión</button>
                </form>
            </div>
            <div class="row">
                <div class="text-center">
                    <a href="/registrarse.php" class="btn btn-info">Registrarse</a>
                </div>
            </div>
            <?php pie() ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
