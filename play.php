<?php

/**
 * ProperLabMedia\SendForm
 * @copyright Copyright (c) 2020, ProperLab <contact.properlab@gmail.com>
 *
 * @author MakerLab <contact.makerlab@gmail.com>
 * @author ProperCloud <contact.propercloud@gmail.com>
 *
 * @license MIT
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

require_once('api/roomhandler.php');
?>

<!doctype html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Un reproductor multimedia minimalista online para ver series o películas con amigos.">
    <meta name="author" content="ProperLab">

    <title>ProperLab Media</title>

    <link rel="icon" href="/assets/img/icon/favicon.ico">
    <link href="/assets/vendor/bootsrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/main.css" rel="stylesheet">

</head>

<body class="text-center" onload="$('#startSession').modal('show')">

    <div id="mySidenav" class="sidenav">
        <a style="cursor: pointer;" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Amigo 1</a>
        <p>XX:XX / PAUSE</p>
        <a href="#">Amigo 2</a>
        <p>XX:XX / PAUSE</p>
        <a href="#">Amigo 3</a>
        <p>XX:XX / PAUSE</p>
        <a href="#">Amigo 4</a>
        <p>XX:XX / PAUSE</p>
    </div>

    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
        <header class="masthead mb-auto">
            <div class="inner">
                <h3 class="masthead-brand">ProperLab Media</h3>
                <nav class="nav nav-masthead justify-content-center">
                    <a class="nav-link active" href="/">Inicio</a>
                    <a class="nav-link" href="mailto:contact.properlab@gmail.com">Contactanos</a>
                </nav>
            </div>
        </header>

        <main role="main" class="inner cover">
            <?php
            try {
                // Validar todo lo enviado
                if (isset($_GET['p'])) {
                    $roomKey = htmlspecialchars($_GET['p']);
                } else {
                    throw new Exception('Error al cargar la sala');
                }

                // Validacion inical pasada
                // Mandar toda la informacion a la base de datos
                $dh = new ProperLabMedia\RoomHandler;
                $response = $dh->getRoom($roomKey);
                //Success
                if (isset($response['id'])) {
                    echo '<div>
                    <p class="lead">¡Invita a mas gente! Comparte este link con tus amigos:</p>
                    <p><button type="button" class="btn btn-outline-info" onclick="openNav()">Abrir menu de amigos</button></p>
                    <div class="input-group">
                        <input id="copy" type="text" class="form-control" value="http://' . $_SERVER["SERVER_NAME"] . '/play.php?p=' . $response['sala'] . '" readonly>
                        <div class="input-group-append">
                        <div class="customtooltip">
                            <button onclick="copy()" onmouseout="outFunc()" class="btn btn-secondary" type="button"><span class="tooltiptext" id="myTooltip">Copiar al portapapeles</span>Copiar</button>
                        </div>
                        </div>
                    </div>
                    <script>
                    function copy() {
                        var copyText = document.getElementById("copy");
                        copyText.select();
                        copyText.setSelectionRange(0, 99999);
                        document.execCommand("copy");

                        var tooltip = document.getElementById("myTooltip");
                        tooltip.innerHTML = "¡Copiado!";
                    }

                    function outFunc() {
                        var tooltip = document.getElementById("myTooltip");
                        tooltip.innerHTML = "Pulsa para copiar al portapapeles";
                    }
                    </script>
                    </div>';
                    echo '<p id="fecha"></p>';
                    echo ' <script>document.getElementById("fecha").innerHTML = "Fecha de creación:" + new Date(' .  $response['fecha'] * 1000 . ') + "<br>Las salas se eliminan tras 10 horas de ser creadas";</script>';
                    if ($response['ip'] == $_SERVER["REMOTE_ADDR"]) {
                        echo '<p>Eres el creador de esta sala</p>';
                        echo '<button type="button" class="btn btn-outline-danger btn-sm mb-5" onclick="$.post(\'/api/playAPI.php\',
                        {
                            action: \'delete\',
                            videoUrl: \'' . $response['sala'] . '\'
                        },
                        function(data, status){})
                        .done (function (data) {
                            location.href=\'/\';
                        })
                        .fail (function (data) {
                            alert(\'Ha ocurrido un error al borrar la sala o la sala ya está borrada\');
                        });">Borrar sala</button>';
                    }
                } else {
                    //DB Failure
                    throw new Exception('Ha ocurrido un error: ' . $response);
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo '<h1 class="cover-heading">ProperLab Media</h1>
                <p class="lead">Un reproductor multimedia minimalista online para ver series o películas con amigos.</p>';
                echo '<p class="lead">' . $e->getMessage() . '</p> <button class="btn btn-secondary" type="button" onclick="location.href=\'/\'">Crea tu propia sala</button></p>';
            }
            ?>
            <p class="lead">
                <?php
                if (isset($response['id'])) {
                    echo '<video src="' . $response['video'] . '" controls playsinline="true" preload="true" poster="/assets/img/icon/properlab-loader.gif" width="100%" height="100%">Tu navegador no soporta la etiqueta video.</video>';
                }
                ?>
            </p>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="startSession" tabindex="-1" role="dialog" aria-labelledby="startSessionTitle" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="startSessionLongTitle">¿Como quieres que te llamen?</h5>
                    </div>
                    <div class="modal-body">
                        <label for="name">Nombre</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="name" placeholder="Adrián, Jesús, ChemaHacker, ...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php
                        echo '<button type="button" class="btn btn-primary" onclick="$.post(\'/api/playAPI.php\',
                        {
                            action: \'createUser\',
                            name: document.getElementById(\'name\').value,
                            salaId: \'' . $response['sala'] . '\'
                        },
                        function(data, status){})
                        .done (function (data) {
                            document.getElementById(\'name\').value = data;
                            $(\'#startSession\').modal(\'hide\');
                            fetchFriends();
                        })
                        .fail (function (data) {
                            alert(\'Ha ocurrido un error al crear el usuario. \'+data.responseText);
                            $(\'#startSession\').modal(\'show\');
                        });">¡Empezar!</button>'
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mastfoot mt-auto">
            <div class="inner">
                <p>Puedes descargar este proyecto en nuestro repositorio publico <a href="https://github.com/ProperLab/ProperLabMedia">ProperLab Media</a>.</p>
            </div>
        </footer>
    </div>

    <script src="/assets/vendor/js/jquery-3.4.1.min.js"></script>
    <script src="/assets/vendor/js/popper.min.js"></script>
    <script src="/assets/vendor/bootsrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/hellofriend.js"></script>

    <script>
        function openNav() {
            document.getElementById("mySidenav").style.left = "0";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.left = "-250px";
        }
    </script>

</body>

</html>