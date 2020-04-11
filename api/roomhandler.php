<?php

/**
 * ProperLabMedia\RoomHandler
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

namespace ProperLabMedia;

use Exception;

require_once('datahandler.php');
/**
 * Room handling functions
 *
 * Contains all methods used in room creation
 */
class RoomHandler
{

    //$dh = new ProperLabMedia\DataHandler;
    //$response = $dh->createRoom($videoUrl);

    /**
     * Creates a new room key
     *
     * @return string Clave generada
     */
    private function generateRoomKey()
    {
        do {
            $existe = false;
            $tamañoClave = 8;
            $alphaClave = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $claveSala = "";
            for ($i = 0; $i < $tamañoClave; $i++) {
                $claveSala .= $alphaClave[mt_rand(0, strlen($alphaClave) - 1)];
            }
            $dh = new DataHandler;
            if ($dh->keyExist($claveSala)) $existe = true;
        } while ($existe);
        return $claveSala;
    }

    /**
     * Creates a new room with a video url
     *
     * @param  string $videoUrl String with the video url
     * @param  string $salaId String with the room id
     *
     * @return string
     */
    public function createRoom($videoUrl)
    {
        try {
            $key = $this->generateRoomKey();
            $dh = new DataHandler;
            if (!$dh->saveRoom($videoUrl, $key)) {
                throw new Exception('Error al guardar la sala');
            }

            return ['key' => $key];
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Gets all the info of a room from a room key
     *
     * @param  string $salaId String with the room id
     *
     * @return array
     */
    public function getRoom($salaId)
    {
        try {
            $dh = new DataHandler;
            $room = $dh->getRoom($salaId);
            if (!$room) throw new Exception('La sala no existe o ha sido eliminada');

            return $room;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Delete a room from DB
     *
     * @param  string $salaId String with the room id
     *
     * @return array
     */
    public function deleteRoom($salaId)
    {
        try {
            $room = $this->getRoom($salaId);
            if ($room['ip'] == $_SERVER["REMOTE_ADDR"]) {
                $dh = new DataHandler;
                $dh->deleteRoom($salaId);
                return true;
            }
            return false;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
