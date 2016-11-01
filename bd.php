<?php

class Bd
{
    protected $bd;

    function __construct()
    {
        $dbn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $param = array('PDO::ATTR_PERSISTENT' => 'true');//for all time connnect
        $this->bd = new PDO($dbn, DB_USER, DB_PASS, $param);
    }

    function setMess($name, $email, $topic, $mesage)
    {
        try {
            $insert = "INSERT INTO `message` (`id`, `name`, `email`, `topic`, `message`) VALUES(NULL, '$name', '$email', '$topic', '$mesage')";
            $this->bd->exec($insert);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    function getKar()
    {
        $select = "SELECT * FROM `antiflood` WHERE id =(SELECT max(id) FROM `antiflood`)";
        $res = $this->bd->query($select);
        $row = $res->fetch();
        return $row;

    }

    function setKar($id)
    {
        $res = $this->bd->prepare("INSERT INTO `antiflood` (`id`, `ip`) VALUES(NULL, :id)");
        $res->bindParam(':id', $id);
        $res->execute();
    }

    function getBlack()
    {
        $sel = "SELECT * FROM `blacklist` ";
        $res = $this->bd->query($sel);
        while ($rows = $res->fetch()) {
            $blacklist[] = $rows;
        }
        return $blacklist;
    }

    function setBlack()
    {
        $ipKaran = $this->getKar();
        $a = $ipKaran['ip'];
        $res1 = $this->bd->prepare("INSERT INTO `blacklist` (`id`, `ip`) VALUES(NULL, :ip)");
        $res1->bindParam(':ip', $a);
        $res1->execute();
    }
}