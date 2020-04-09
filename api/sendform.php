<?php
/**
* ProperLabMedia\SendForm
* © 2020 ProperLab - All Rights Reserved
*/
require_once('roomhandler.php');
try {
    // Validar todo lo enviado
    $videoUrl = htmlspecialchars($_POST['videoUrl']);
    sleep(2);
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
        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$response.'</div><div id="returnVal" style="display:none;">false</div>';
    } else {
        //DB Failure
        throw new Exception('Ha ocurrido un error al crear la sala. ' . $response);
    }
} catch (Exception $e) {
	http_response_code(500);
	echo $e->getMessage();
}
