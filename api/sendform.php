<?php

/**
 * ProperLabMedia\SendForm
 * © 2020 ProperLab - All Rights Reserved
 */
require_once('roomhandler.php');
try {
    // Validar todo lo enviado
    $videoUrl = htmlspecialchars($_POST['videoUrl']);
    sleep(3);
    // Comprobaciones
    if (($videoUrl == '')) {
        throw new Exception('Servidor: No has introducido todos los campos obligatorios');
    }

    // Validacion inical pasada
    // Mandar toda la informacion a la base de datos
    $dh = new ProperLabMedia\RoomHandler;
    $response = $dh->createRoom($videoUrl);
    //Success
    if ($response) {
        // TODO: Check if is valid
        echo '<div class="alert alert-dark">
        ¡Sala creada correctamente! Comparte este link con tus amigos:
        <div class="input-group">
            <input id="copy" type="text" class="form-control" value="http://' . $_SERVER["SERVER_NAME"] . '/play.php?p=' . $response . '" readonly>
            <div class="input-group-append">
            <div class="customtooltip">
                <button onclick="copy()" onmouseout="outFunc()" class="btn btn-dark" type="button"><span class="tooltiptext" id="myTooltip">Copiar al portapapeles</span>Copiar</button>
            </div>
            <button class="btn btn-dark" type="button" onclick="location.href=document.getElementById(\'copy\').value;">Ir</button>
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
    } else {
        //DB Failure
        throw new Exception('Ha ocurrido un error al crear la sala. ' . $response);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
