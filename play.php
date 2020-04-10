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
    <link href="/assets/css/styles.css" rel="stylesheet">

</head>

<body class="text-center" onload="$('#startSesion').modal('show')">

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
            <h1 class="cover-heading">ProperLab Media</h1>
            <p class="lead">Un reproductor multimedia minimalista online para ver series o películas con amigos.</p>
            <p class="lead">Estás en la sala: <?php echo $_GET['p'] ?>.</p>
            <p class="lead">
                <?php
                // TODO: Ajuste del vídeo en moviles
                echo '<video src="https://propercloud.sytes.net/assets/video/code-lyoko.mp4" controls playsinline="true" preload="true" poster="poster.jpg" width="auto" height="auto">Tu navegador no soporta la etiqueta video.</video>';
                ?>
            </p>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="startSesion" tabindex="-1" role="dialog" aria-labelledby="startSesionTitle" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="startSesionLongTitle">¿Como quieres que te llamen?</h5>
                    </div>
                    <div class="modal-body">
                        <label for="name">Nombre</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="name" placeholder="Adrián, Jesús, ChemaHacker, ...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">¡Empezar!</button>
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

</body>

</html>