<?php
/**
* ProperLabMedia\DbConn
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

/**
* Database connection handler
*
* Establishes foundational database connection and property assignment pulled from `dbconf.php` config file.
* This base class is extended or utilized by numerous other classes.
*/
class DbConn
{
    /**
    * Database name
    * @var string
    */
    private $db_name;
    /**
    * Database server hostname
    * @var string
    */
    private $host;
    /**
    * Database username
    * @var string
    */
    private $username;
    /**
    * Database password
    * @var string
    */
    private $password;
    /**
    * PDO Connection object
    * @var object
    */
    public $conn;
    /**
    * Table where basic data is stored
    * @var string
    */
    public $tbl_rooms;

    /**
     * Class constructor
     * Initializes PDO connection and sets object properties
     */
    public function __construct()
    {
        // Pulls tables from dbconf.php file
        require 'dbconf.php';
        $this->tbl_rooms = $tbl_rooms;

        // Connect to server and select database
        try {
            $this->conn = new \PDO('mysql:host='.$host.';dbname='.$db_name.';charset=utf8', $username, $password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

}
