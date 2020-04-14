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
     * @return bool
     */
    public function saveRoom(string $videoUrl, string $salaId): bool
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

            $resp = true;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            $resp = false;
        }

        return $resp;
    }

    /**
     * Gets info from a room key
     *
     * @param  string $salaId String with the room id
     *
     * @return array All data from DB
     */
    public function getRoom(string $salaId)
    {
        try {
            $dbconn = new DbConn;

            $stmt = $dbconn->conn->prepare("SELECT * FROM " . $dbconn->tbl_rooms . " WHERE sala = :salaid");
            $stmt->bindParam(':salaid', $salaId);
            $stmt->execute();
            $resp = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            $resp = false;
        }

        return $resp;
    }

    /**
     * Deletes a room from a key
     *
     * @param  string $salaId String with the room id
     *
     */
    public function deleteRoom(string $salaId): bool
    {
        try {
            $dbconn = new DbConn;

            $stmt = $dbconn->conn->prepare("DELETE FROM " . $dbconn->tbl_rooms . " WHERE sala = :salaid");
            $stmt->bindParam(':salaid', $salaId);
            $stmt->execute();

            $resp = true;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            $resp = false;
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
    public function keyExist(string $key): bool
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

    /**
     * Creates a new user for a room
     *
     * @param  string $name Name of the user
     * @param  string $room ID of the room
     *
     * @return int
     */
    public function newUser(string $name, string $room): int
    {
        try {
            $ip_address = $_SERVER["REMOTE_ADDR"];

            $datetimeNow = time();

            $dbconn = new DbConn;

            $test ='Cargando';

            $stmt = $dbconn->conn->prepare("INSERT INTO " . $dbconn->tbl_users . " (sala, nombre, estado, ip, fecha) VALUES(:sala, :nombre, :estado, :ip, :fecha)");
            $stmt->bindParam(':sala', $room);
            $stmt->bindParam(':nombre', $name);
            $stmt->bindParam(':estado', $test);
            $stmt->bindParam(':ip', $ip_address);
            $stmt->bindParam(':fecha', $datetimeNow);
            $stmt->execute();
            $id = $dbconn->conn->lastInsertId();

            $resp = $id;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            $resp = 0;
        }

        return $resp;
    }

    /**
     * Updates user status
     *
     * @param  int $id ID of the user
     * @param  string $status New status of the user
     *
     * @return bool
     */
    public function updateUser(int $id, string $status): bool
    {
        try {
            $datetimeNow = time();

            $dbconn = new DbConn;

            $stmt = $dbconn->conn->prepare("UPDATE " . $dbconn->tbl_users . " SET estado = :estado, fecha = :fecha WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':estado', $status);
            $stmt->bindParam(':fecha', $datetimeNow);
            $stmt->execute();

            $resp = true;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            $resp = false;
        }

        return $resp;
    }
}
