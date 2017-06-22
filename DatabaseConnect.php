<?php
/**
 * Author : Kayode Omotoye
 */
class DatabaseConnect
{
    public function connect() {
        $serverName = "localhost";
        $UserName = "root";
        $Password = "";
        $database = "myjar_clients_data";

        $conn = new mysqli($serverName, $UserName, $Password, $database);

        if ($conn->connect_error) {
            die("Connection Failed ". mysqli_connect_error());
        }

        return $conn;
    }
}
?>
