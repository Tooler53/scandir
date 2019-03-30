<?php
/**
 * Created by PhpStorm.
 * User: Toole
 * Date: 27.03.2019
 * Time: 21:10
 *
 * @param $flag bool
 * @param $array array
 * @param $servname string
 * @param $username string
 * @param $password string
 * @param $dbname string
 * @param $conn PDO
 * @param $query string
 * @return $arrayout array
 * @param $pe PDOException
 */

class SqlCommands
{
    /**
     * @param $flag
     * @return array
     */
    public function createCommand($flag, $array = [])
    {
        $servname = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mydb";

        try {
            $conn = new PDO("mysql:host=$servname;dbname=$dbname", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            if ($flag) {
                return $this->select($conn);
            } else {
                $this->insert($conn, $array);
            };
        } catch
        (PDOException $pe) {
            echo "Connection failed: " . $pe->getMessage();
        };
    }

    private function select($conn)
    {
        $query = $conn->prepare("select * from dirfiles;");
        $query->execute();
        $array_out = [];

        for ($i = 0; $i < $query->rowCount(); $i++)
            $array_out[$i] = $query->fetch();

        $conn = null;
        $query = null;

        return $array_out;
    }

    private function insert($conn, $array)
    {
        $conn->query('delete from dirfiles where id > 0;');
        $conn->query('ALTER TABLE dirfiles AUTO_INCREMENT = 0;');

        for ($i = 0; $i < count($array); $i++) {
            $query = $conn->prepare('insert into dirfiles (filename, filesize, filetype, filetime) values (:filename, :filesize, :filetype, :filetime)');
            $query->bindParam(':filename', $array[$i]['filename']);
            $query->bindParam(':filesize', $array[$i]['filesize']);
            $query->bindParam(':filetype', $array[$i]['filetype']);
            $query->bindParam(':filetime', $array[$i]['filetime']);
            $query->execute();

            $query = null;
        }

        $conn = null;
    }
}
