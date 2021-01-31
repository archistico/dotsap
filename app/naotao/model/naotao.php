<?php

namespace App\Naotao\Model;

class Naotao
{
   public $idnaotao;
   public $fkpaziente;
   public $farmaco;
   public $dataultimiesami;
   public $allegatocompilato;
   public $datafollowup;
   public $esamiprescritti;
   public $convocare;
   public $note;

   public function __construct($idnaotao, $fkpaziente, $farmaco, $dataultimiesami, $allegatocompilato, $datafollowup, $esamiprescritti, $convocare, $note)
   {
      $this->idnaotao = $idnaotao;
      $this->fkpaziente = $fkpaziente;
      $this->farmaco = $farmaco;
      $this->dataultimiesami = $dataultimiesami;
      $this->allegatocompilato = $allegatocompilato;
      $this->datafollowup = $datafollowup;
      $this->esamiprescritti = $esamiprescritti;
      $this->convocare = $convocare;
      $this->note = $note;
   }

   public function Insert()
   {
      try {
         $db = (\app\Db::getInstance())->connect();
         $sql = "INSERT INTO naotao (idnaotao, fkpaziente, farmaco, dataultimiesami, allegatocompilato, datafollowup, esamiprescritti, convocare, note)
         VALUES (:idnaotao, :fkpaziente, :farmaco, :dataultimiesami, :allegatocompilato, :datafollowup, :esamiprescritti, :convocare, :note)";

         $db->begin();
         $db->exec($sql, [
            ':idnaotao' => $this->idnaotao,
            ':fkpaziente' => $this->fkpaziente,
            ':farmaco' => $this->farmaco,
            ':dataultimiesami' => $this->dataultimiesami,
            ':allegatocompilato' => $this->allegatocompilato,
            ':datafollowup' => $this->datafollowup,
            ':esamiprescritti' => $this->esamiprescritti,
            ':convocare' => $this->convocare,
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
         $sql = "UPDATE naotao SET 
            fkpaziente = :fkpaziente, 
            farmaco = :farmaco, 
            dataultimiesami = :dataultimiesami, 
            allegatocompilato = :allegatocompilato, 
            datafollowup = :datafollowup, 
            esamiprescritti = :esamiprescritti, 
            convocare = :convocare, 
            note = :note
            WHERE idnaotao = :idnaotao
         ";

         $db->begin();
         $db->exec($sql, [
            ':idnaotao' => $this->idnaotao,
            ':fkpaziente' => $this->fkpaziente,
            ':farmaco' => $this->farmaco,
            ':dataultimiesami' => $this->dataultimiesami,
            ':allegatocompilato' => $this->allegatocompilato,
            ':datafollowup' => $this->datafollowup,
            ':esamiprescritti' => $this->esamiprescritti,
            ':convocare' => $this->convocare,
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

   public static function SelectById($idnaotao)
   {
      $db = (\app\Db::getInstance())->connect();
      $sql = "
         SELECT naotao.*, pazienti.cognome as cognome, pazienti.nome as nome, pazienti.datanascita as datanascita
         FROM naotao 
         INNER JOIN pazienti ON naotao.fkpaziente = pazienti.id
         WHERE idnaotao = :idnaotao
         ";
      $lista = $db->exec($sql, [
         ':idnaotao' => $idnaotao
      ]);
      return $lista[0];
   }

   public static function SelectByFkpaziente($fkpaziente)
   {
      $db = (\app\Db::getInstance())->connect();
      $sql = "
         SELECT naotao.*, pazienti.cognome, pazienti.nome, pazienti.datanascita
         FROM naotao 
         INNER JOIN pazienti ON naotao.fkpaziente = pazienti.id
         WHERE fkpaziente = :fkpaziente
         ";
      $lista = $db->exec($sql, [
         ':fkpaziente' => $fkpaziente
      ]);
      return $lista[0];
   }

   public static function SelectAll()
   {
      $db = (\app\Db::getInstance())->connect();
      $sql = "SELECT naotao.*, pazienti.cognome, pazienti.nome, pazienti.datanascita
              FROM naotao 
              INNER JOIN pazienti ON naotao.fkpaziente = pazienti.id
              ";
      $lista = $db->exec($sql, []);
      return $lista;
   }

   public static function DeleteById($idnaotao)
   {
      $db = (\app\Db::getInstance())->connect();
      $sql = "DELETE FROM naotao WHERE idnaotao = :idnaotao";
      $db->exec($sql, [
         ':idnaotao' => $idnaotao
      ]);
      return true;
   }

   public static function DeleteByFkpaziente($fkpaziente)
   {
      $db = (\app\Db::getInstance())->connect();
      $sql = "DELETE FROM naotao WHERE fkpaziente = :fkpaziente";
      $db->exec($sql, [
         ':fkpaziente' => $fkpaziente
      ]);
      return true;
   }

   public static function SvuotaTabellaNaoTao()
   {
      $db = (\App\Db::getInstance())->connect();

      $db->begin();
      $db->exec("DELETE FROM naotao;");

      $db->commit();
   }
}
