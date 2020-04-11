<?php

/**
 * ProperLabMedia\PlayAPI
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
    if (!isset($_POST['action'])) {
        throw new Exception('Servidor: No has introducido todos los campos obligatorios');
    }
    $action = htmlspecialchars($_POST['action']);

    if ($action == 'delete') {
        if (!isset($_POST['videoUrl'])) {
            throw new Exception('Servidor: No has introducido todos los campos obligatorios');
        }
        $videoUrl = htmlspecialchars($_POST['videoUrl']);
        $dh = new ProperLabMedia\RoomHandler;
        $response = $dh->deleteRoom($videoUrl);
        if ($response) {
            return $response;
        } else {
            throw new Exception('Error al eliminar la sala');
        }
    } else {
        throw new Exception('La acción no es valida.');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo $e->getMessage();
}
