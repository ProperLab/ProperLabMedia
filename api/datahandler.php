<?php

/**
 * ProperLabMedia\DataHandler
 * © 2020 ProperLab - All Rights Reserved
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

            $datetimeNow = date("Y-m-d H:i:s");

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
     * Gets info from a sala key
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
