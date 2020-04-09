<?php

/**
 * ProperLabMedia\RoomHandler
 * © 2020 ProperLab - All Rights Reserved
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
        $existe = false;
        do {
            $tamañoClave = 8;
            $alphaClave = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $claveSala = "";
            for ($i = 0; $i < $tamañoClave; $i++) {
                $claveSala .= $alphaClave[mt_rand(0, strlen($alphaClave) - 1)];
            }
            $dh = new DataHandler;
            if($dh->keyExist($claveSala)) $existe = true;
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

            return $key;

        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
