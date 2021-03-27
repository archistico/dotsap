<?php

namespace App\Bilancio\Model;

class Bilancio 
{
   public $idbilancio;
   public $entratauscita;
   public $lavoroprivato;
   public $tipologia;
   public $totale;
   public $tasse;
   public $commissioni;
   public $data;
   public $chi;
   public $note;

   public function __construct($idbilancio, $entratauscita, $lavoroprivato, $tipologia, $totale, $tasse, $commissioni, $data, $chi, $note)
   {
      $this->idbilancio = $idbilancio;
      $this->entratauscita = $entratauscita;
      $this->lavoroprivato = $lavoroprivato;
      $this->tipologia = $tipologia;
      $this->totale = $totale;
      $this->tasse = $tasse;
      $this->commissioni = $commissioni;
      $this->data = $data;
      $this->chi = $chi;
      $this->note = $note;
   }

   public function Insert()
   {
      try {
         $db = (\app\Db::getInstance())->connect();
         $sql = "INSERT INTO bilancio (idbilancio, entratauscita, lavoroprivato, tipologia, totale, tasse, commissioni, data, chi, note)
         VALUES (:idbilancio, :entratauscita, :lavoroprivato, :tipologia, :totale, :tasse, :commissioni, :data, :chi, :note)";

         $db->begin();
         $db->exec($sql, [
            ':idbilancio' => $this->idbilancio, 
            ':entratauscita' => $this->entratauscita, 
            ':lavoroprivato' => $this->lavoroprivato, 
            ':tipologia' => $this->tipologia, 
            ':totale' => $this->totale, 
            ':tasse' => $this->tasse, 
            ':commissioni' => $this->commissioni, 
            ':data' => $this->data, 
            ':chi' => $this->chi, 
            ':note' => $this->note
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
         $db = (\app\Db::getInstance())->connect();
         $sql = "UPDATE bilancio SET 
            entratauscita = :entratauscita, 
            lavoroprivato = :lavoroprivato, 
            tipologia = :tipologia, 
            totale = :totale, 
            tasse = :tasse, 
            commissioni = :commissioni, 
            data = :data, 
            chi = :chi, 
            note = :note 
            WHERE idbilancio = :idbilancio
         ";

         $db->begin();
         $db->exec($sql, [
            ':idbilancio' => $this->idbilancio, 
            ':entratauscita' => $this->entratauscita, 
            ':lavoroprivato' => $this->lavoroprivato, 
            ':tipologia' => $this->tipologia, 
            ':totale' => $this->totale, 
            ':tasse' => $this->tasse, 
            ':commissioni' => $this->commissioni, 
            ':data' => $this->data, 
            ':chi' => $this->chi, 
            ':note' => $this->note
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

   public static function SelectById($idbilancio)
   {
      $db = (\app\Db::getInstance())->connect();
      $sql = "SELECT * FROM bilancio WHERE idbilancio = :idbilancio";
      $lista = $db->exec($sql, [
         ':idbilancio' => $idbilancio
      ]);
      return $lista[0];
   }

   public static function SelectAll()
   {
      $db = (\app\Db::getInstance())->connect();
      $sql = "SELECT * FROM bilancio";
      $lista = $db->exec($sql, []);
      return $lista;
   }

   public static function DeleteById($idbilancio)
   {
      $db = (\app\Db::getInstance())->connect();
      $sql = "DELETE FROM bilancio WHERE idbilancio = :idbilancio";
      $db->exec($sql, [
         ':idbilancio' => $idbilancio
      ]);
      return true;
   }
}