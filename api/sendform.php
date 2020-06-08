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

require_once('roomhandler.php');
try {
    if (!isset($_POST['videoUrl'])) {
        throw new Exception('Servidor: No has introducido todos los campos obligatorios');
    }
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
    if (isset($response['key'])) {
        echo '<div class="alert alert-dark">
        ¡Sala creada correctamente! Comparte este link con tus amigos:
        <div class="input-group">
            <input id="copy" type="text" class="form-control" value="http://' . $_SERVER["SERVER_NAME"] . '/play.php?p=' . $response['key'] . '" readonly>
            <div class="input-group-append">
            <div class="customtooltip">
                <button onclick="copy()" onmouseout="outFunc()" class="btn btn-dark" type="button"><span class="tooltiptext" id="myTooltip">Copiar al portapapeles</span>Copiar</button>
            </div>
            <button class="btn btn-dark" type="button" onclick="location.href=document.getElementById(\'copy\').value;">Ir</button>
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
    } else if ($response == '429') {
        http_response_code(429);
        echo '¡Has alcanzado el límite de salas! Pide a algún amigo que cree otra sala por ti o espera a que se borre/borra alguna antes de crear otra sala. Recuerda que solo se pueden crear 10 salas por IP';
    } else {
        //DB Failure
        throw new Exception('Ha ocurrido un error al crear la sala. ' . $response);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
