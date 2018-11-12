<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bases de datos</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style media="screen">
            #busqueda { margin-top: 1em; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">FilmAffinity</a>
                </div>
                <div class="navbar-text navbar-right">
                    <a href="../comunes/login.php" class="btn btn-success">Login</a>
                </div>
            </div>
        </nav>
        <div class="container">
            <hr>
            <div class="row">
                <div class="text-center">
                    <a href="./peliculas/">Ir a peliculas</a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="text-center">
                    <a href="./generos/">Ir a generos</a>
                </div>
            </div>
            <?php if (!isset($_COOKIE['acepta'])): ?>
                <nav class="navbar navbar-fixed-bottom navbar-inverse">
                    <div class="container">
                        <div class="navbar-text navbar-right">
                            Tienes que aceptar las políticas de cookies.
                            <a href="./crear_cookie.php" class="btn btn-success">Aceptar cookies</a>
                        </div>
                    </div>
                </nav>
            <?php endif ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
