<?php

class GuestBook
{
    private $user, $email, $mess, $subj, $md5, $co, $id, $date, $sub, $datawin, $datafil, $masBlList, $LostKaran;

    function __construct(Bd $database)
    {
        $this->bd = $database;
        if (!empty($_POST['message'])) {
            $this->user = strip_tags($_POST["name"]);
            $email = strip_tags($_POST["email"]);
            $this->email = strtolower($email);
            $this->subj = strip_tags($_POST["subject"]);
            $this->mess = strip_tags($_POST["message"]);
            $this->md5 = $_POST["code"];
            $code = $_POST["codeorig"];
            $this->co = md5($code);
            $this->id = $_SERVER['REMOTE_ADDR'];
            $this->date = date("Y-m-d H:i", $_SERVER['REQUEST_TIME']);
            $this->sub = $_POST['sub'];
        } else {
            die("Вы не заполнили сообщение!");
        }

    }

    public function init()
    {
        if ($this->md5 === $this->co) {
            $tr_name = trim($this->user);
            $tr_subj = trim($this->subj);
            $tr_mess = trim($this->mess);
            $this->masBlList = $this->bd->getBlack();
            $this->LostKaran = $this->bd->getKar();
            $this->checkBlackList();
            $this->checkKaran();
            $this->bd->setKar($this->id);
            $this->bd->setMess($tr_name, $this->email, $tr_subj, $tr_mess);
            echo "Ваша запись добавлена!!!";
        } else {
            echo 'Не правильно введён код с картинки!';
        }
    }

    private function checkBlackList()
    {
        $ipBlack = $this->masBlList;
        if (!is_array($ipBlack)) {
            $ipBlack = array();
        }
        $time = substr($this->date, 0, -6);
        foreach ($ipBlack as $key => $value) {
            $resul = in_array($this->id, $value);
            if ($resul == false) {
                continue;
            } elseif ($value['ip'] == $this->id and substr($value['time'], 0, -9) == $time) {
                die("Вас занесено в black list за спам!!!");
            }
        }
    }

    private function checkKaran()
    {
        $ipKaran = $this->LostKaran['ip'];
        $dateKaran = $this->LostKaran['timeLost'];
        $dateKaran = substr($dateKaran, 0, -3);
        if (($ipKaran == $this->id and $dateKaran != $this->date) or ($ipKaran == NULL)) {
            return true;
        } else {
            $this->bd->setBlack();
            die("Вас занесено в black list за спам на одни сутки!!!");
        }
    }

}