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
    <link href="/assets/css/simple-sidebar.css" rel="stylesheet">

</head>

<body class="text-center" onload="$('#startSesion').modal('show')">

<div class="d-flex" id="wrapper">

<!-- Sidebar -->
<div id="sidebar-wrapper">
  <div class="sidebar-heading">Amigos</div>
  <div class="list-group list-group-flush">
    <a href="#" class="list-group-item list-group-item-action bg-white">Amigo 1</a>
    <a href="#" class="list-group-item list-group-item-action bg-white">Amigo 2</a>
    <a href="#" class="list-group-item list-group-item-action bg-white">Amigo 3</a>
    <a href="#" class="list-group-item list-group-item-action bg-white">Amigo 4</a>
    <a href="#" class="list-group-item list-group-item-action bg-white">Amigo 5</a>
    <a href="#" class="list-group-item list-group-item-action bg-white">Amigo 6</a>
  </div>
</div>
<!-- /#sidebar-wrapper -->

</div>
<!-- /#wrapper -->

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
            <p class="lead">¡Espera a tus amigos o dale a ProperLab para comenzar!</p>
            <!-- Page Content -->
            <div id="page-content-wrapper">
            <button class="btn btn-primary" id="menu-toggle">Menu de amigos</button>
            </div>
            <!-- /#page-content-wrapper -->
            <p class="lead">
                <?php
                echo '<video src="https://propercloud.sytes.net/assets/video/code-lyoko.mp4" controls playsinline="true" preload="true" poster="/assets/img/icon/favicon.ico" width="auto" height="auto">Tu navegador no soporta la etiqueta video.</video>';
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.bundle.js"></script>
    <script src="/assets/js/gulpfile.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>