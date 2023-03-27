<?php

class Dbh
{
    private $host = "1.2.3.4";
    private $user = "username";
    private $pass = "password";
    private $db = "turtle-builder";

    protected function connect()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=utf8';
        $conn = new PDO($dsn, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $conn;
    }
}
