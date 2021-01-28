<?php

namespace App;

class Utente
{
    public $idutente;
    public $username;
    public $password;
    public $role;

    public static $RUOLO_ADMIN = 'Admin';
    public static $RUOLO_LIVELLO1 = 'Dottoressa';
    public static $RUOLO_LIVELLO2 = 'Infermiere';
    public static $RUOLO_LIVELLO3 = 'Segreteria';

    public function __construct($idutente, $username, $password, $role)
    {
        $this->idutente = $idutente;
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

    public function Insert()
    {
        try {
            $db = (\App\Db::getInstance())->connect();
            $sql = "INSERT INTO utente (idutente, username, password, role)
         VALUES (:idutente, :username, :password, :role)";

            $db->begin();
            $db->exec($sql, [
                ':idutente' => $this->idutente,
                ':username' => $this->username,
                ':password' => $this->password,
                ':role' => $this->role
            ]);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            return false;
        }
        return true;
    }

    public function Update()
    {
        try {
            $db = (\App\Db::getInstance())->connect();
            $sql = "UPDATE utente SET 
            username = :username, 
            password = :password, 
            role = :role
            WHERE idutente = :idutente
         ";

            $db->begin();
            $db->exec($sql, [
                ':username' => $this->username,
                ':password' => $this->password,
                ':role' => $this->role,
                ':idutente' => $this->idutente
            ]);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            return false;
        }
        return true;
    }

    // --------------------------
    // --------- STATIC ---------
    // --------------------------

    public static function Login($username, $password)
    {
        $db = (\App\Db::getInstance())->connect();
        $sql = "SELECT COUNT(idutente) as conteggio FROM utente WHERE username = :username AND password = :password LIMIT 1";
        $lista = $db->exec($sql, [
            ':username' => $username,
            ':password' => $password
        ]);

        if ($lista[0]['conteggio'] > 0) {
            return true;
        }
        return false;
    }

    public static function Role($username, $password)
    {
        $db = (\App\Db::getInstance())->connect();
        $sql = "SELECT utente.role FROM utente WHERE username = :username AND password = :password LIMIT 1";
        $lista = $db->exec($sql, [
            ':username' => $username,
            ':password' => $password
        ]);

        return $lista[0]['role'];
    }

    public static function SelectById($idutente)
    {
        $db = (\App\Db::getInstance())->connect();
        $sql = "SELECT * FROM utente WHERE idutente = :idutente";
        $lista = $db->exec($sql, [
            ':idutente' => $idutente
        ]);
        return $lista[0];
    }

    public static function SelectAll()
    {
        $db = (\App\Db::getInstance())->connect();
        $sql = "SELECT * FROM utente";
        $lista = $db->exec($sql, []);
        return $lista;
    }

    public static function DeleteById($idutente)
    {
        $db = (\App\Db::getInstance())->connect();
        $sql = "DELETE FROM utente WHERE idutente = :idutente";
        $db->exec($sql, [
            ':idutente' => $idutente
        ]);
        return true;
    }

    public static function ListaRuolo()
    {
        $array = [];

        $array[] = Utente::$RUOLO_ADMIN;
        $array[] = Utente::$RUOLO_LIVELLO1;
        $array[] = Utente::$RUOLO_LIVELLO2;
        $array[] = Utente::$RUOLO_LIVELLO3;

        return $array;
    }
}
