<?php

/**
 * ProperLabMedia\DataHandler
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

require_once('dbconn.php');
/**
 * Data handling functions
 *
 * Contains all methods used in data form
 */
class DataHandler
{

    /**
     * Inserts form data into the `salas` table and creates a room
     *
     * @param  string $videoUrl String with the video url
     * @param  string $salaId String with the room id
     *
     * @return string
     */
    public function saveRoom($videoUrl, $salaId)
    {
        try {
            $ip_address = $_SERVER["REMOTE_ADDR"];

            $datetimeNow = time();

            $dbconn = new DbConn;

            $stmt = $dbconn->conn->prepare("INSERT INTO " . $dbconn->tbl_rooms . " (video, sala, ip, fecha) values(:video, :sala, :ip, :fecha)");
            $stmt->bindParam(':video', $videoUrl);
            $stmt->bindParam(':sala', $salaId);
            $stmt->bindParam(':ip', $ip_address);
            $stmt->bindParam(':fecha', $datetimeNow);
            $stmt->execute();
            $err = '';
        } catch (\PDOException $e) {
            $err = "Error: " . $e->getMessage();
        }

        //Determines returned value ('true' or error code)
        $resp = ($err == '') ? 'true' : $err;

        return $resp;
    }

    /**
     * Gets info from a room key
     *
     * @param  string $salaId String with the room id
     *
     * @return array All data from DB
     */
    public function getRoom($salaId)
    {
        try {
            $dbconn = new DbConn;

            $stmt = $dbconn->conn->prepare("SELECT * FROM " . $dbconn->tbl_rooms . " WHERE sala = :salaid");
            $stmt->bindParam(':salaid', $salaId);
            $stmt->execute();
            $resp = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $resp = $e->getMessage();
        }

        return $resp;
    }

    /**
     * Deletes a room from a key
     *
     * @param  string $salaId String with the room id
     *
     */
    public function deleteRoom($salaId)
    {
        try {
            $dbconn = new DbConn;

            $stmt = $dbconn->conn->prepare("DELETE FROM " . $dbconn->tbl_rooms . " WHERE sala = :salaid");
            $stmt->bindParam(':salaid', $salaId);
            $stmt->execute();
        } catch (\PDOException $e) {
            $resp = $e->getMessage();
        }

        return $resp;
    }

    /**
     * Checks if a key already exists
     *
     * @param  string $key String with the room id
     *
     * @return bool
     */
    public function keyExist($key): bool
    {
        try {
            $dbconn = new DbConn;

            $stmt = $dbconn->conn->prepare("SELECT sala FROM " . $dbconn->tbl_rooms . " WHERE sala = :key");
            $stmt->bindParam(':key', $key);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $result = true;
        }

        return $result;
    }
}
