<?php

namespace App;

class Log
{

    public $id;
    public $data;
    public $ip;
    public $user;
    public $message;

    public function __construct($data, $ip, $user, $message)
    {
        $this->data = $data;
        $this->ip = $ip;
        $this->user = $user;
        $this->message = $message;
    }

    public function ToArray()
    {
        return ['id' => $this->id, 'data' => $this->data, 'ip' => $this->ip, 'user' => $this->user, 'message' => $this->message];
    }

    public function Save()
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $db->begin();
        $db->exec(
            'INSERT INTO logs VALUES (:id, :data, :ip, :user, :message)',
            array(
                ':id' => null,
                ':data' => $this->data,
                ':ip' => $this->ip,
                ':user' => $this->user,
                ':message' => $this->message
            )
        );
        $db->commit();
    }

    public static function SaveMessage($user, $message)
    {
        $l = new \App\Log(date('Y/m/d H:i'), $_SERVER['REMOTE_ADDR'], $user, $message);
        $l->Save();
    }

    public static function LoadAll()
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $sql = "SELECT * FROM logs ORDER BY data DESC";
        return $db->exec($sql);
    }
}
