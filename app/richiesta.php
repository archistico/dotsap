<?php
namespace App;

class Richiesta
{
    
    public $id;
    public $paziente;
    public $data;
    public $farmaci;
    public $note;
    
    public function __construct($paziente, $data, $farmaci, $note)
    {
        $this->paziente = $paziente;
        $this->data = $data;
        $this->farmaci = $farmaci;
        $this->note = $note;
    }

    public function ToArray()
    {
        return ['id' => $this->id, 'paziente' => $this->paziente, 'data' => $this->data, 'farmaci' => $this->farmaci, 'note' => $this->note];
    }

    public function Save()
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $db->begin();
        $db->exec(
                'INSERT INTO richieste VALUES (:id, :paziente, :data, :farmaco1, :farmaco2, :farmaco3, :farmaco4, :farmaco5, :farmaco6, :farmaco7, :farmaco8, :farmaco9, :note)',
            array(
                ':id'=>null,
                ':paziente'=> $this->paziente, 
                ':data'=> $this->data, 
                ':farmaco1'=> $this->farmaci[0], 
                ':farmaco2'=> $this->farmaci[1], 
                ':farmaco3'=> $this->farmaci[2], 
                ':farmaco4'=> $this->farmaci[3], 
                ':farmaco5'=> $this->farmaci[4], 
                ':farmaco6'=> $this->farmaci[5], 
                ':farmaco7'=> $this->farmaci[6], 
                ':farmaco8'=> $this->farmaci[7], 
                ':farmaco9'=> $this->farmaci[8], 
                ':note'=> $this->note
            )
        );
        $db->commit();
    }

    public static function LoadAll()
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $sql = "SELECT * FROM richieste";
        return $db->exec($sql);
    }

    public static function Cancella($id)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = "DELETE FROM richieste WHERE id=$id";

        $db->begin();
        $db->exec($sql);
        $db->commit();
    }

    public static function Carica($id)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $sql = "SELECT * FROM richieste WHERE id=$id";
        return $db->exec($sql);
    }

    public static function Modifica($id, $paziente, $data, $farmaco1, $farmaco2, $farmaco3, $farmaco4, $farmaco5, $farmaco6, $farmaco7, $farmaco8, $farmaco9, $note)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $db->begin();
        $db->exec(
                'UPDATE richieste SET paziente=:paziente, data=:data, farmaco1=:farmaco1, farmaco2=:farmaco2, farmaco3=:farmaco3, farmaco4=:farmaco4, farmaco5=:farmaco5, farmaco6=:farmaco6, farmaco7=:farmaco7, farmaco8=:farmaco8, farmaco9=:farmaco9, note=:note WHERE id=:id',
            array(
                ':id'=>$id,
                ':paziente'=> $paziente, 
                ':data'=> $data, 
                ':farmaco1'=> $farmaco1, 
                ':farmaco2'=> $farmaco2, 
                ':farmaco3'=> $farmaco3, 
                ':farmaco4'=> $farmaco4, 
                ':farmaco5'=> $farmaco5, 
                ':farmaco6'=> $farmaco6, 
                ':farmaco7'=> $farmaco7, 
                ':farmaco8'=> $farmaco8, 
                ':farmaco9'=> $farmaco9, 
                ':note'=> $note
            )
        );
        $db->commit();
    }
}
