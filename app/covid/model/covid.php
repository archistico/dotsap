<?php

namespace App\Covid\Model;

use App\Utilita;

class Covid
{
    public $id;
    public $fkpaziente;
    public $datascheda;
    public $datatampone;
    public $stato;
    public $clinica;
    public $presaincarico;
    public $comorbidita;
    public $esami;
    public $terapia;
    public $ossigeno;
    public $note;

    public static $STATO_IGNOTO = "Ignoto";
    public static $STATO_SOSPETTO_IN_ATTESA_DI_TAMPONE = "Sospetto in attesa di tampone";
    public static $STATO_SOSPETTO_NON_IN_ATTESA_DI_TAMPONE = "Sospetto non in attesa di tampone";
    public static $STATO_NEGATIVO = "Negativo";
    public static $STATO_ISOLAMENTO = "Isolamento";
    public static $STATO_POSITIVO = "Positivo";
    public static $STATO_GUARITO = "Guarito";
    public static $STATO_DECEDUTO = "Deceduto";

    public function __construct($id, $fkpaziente, $datascheda, $datatampone, $stato, $clinica, $presaincarico, $comorbidita, $esami, $terapia, $ossigeno, $note)
    {
        $this->id = $id;
        $this->fkpaziente = $fkpaziente;
        $this->datascheda = $datascheda;
        $this->datatampone = $datatampone;
        $this->stato = $stato;
        $this->clinica = $clinica;
        $this->presaincarico = $presaincarico;
        $this->comorbidita = $comorbidita;
        $this->esami = $esami;
        $this->terapia = $terapia;
        $this->ossigeno = $ossigeno;
        $this->note = $note;
    }

    public function AddDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = 'INSERT into covid values(null, :fkpaziente, :datascheda, :datatampone, :stato, :clinica, :comorbidita, :presaincarico, :terapia, :ossigeno, :esami, :note)';

            $db->begin();
            $db->exec($sql, [
                ':fkpaziente' => $this->fkpaziente,
                ':datascheda' => $this->datascheda,
                ':datatampone' => $this->datatampone,
                ':stato' => $this->stato,
                ':clinica' => $this->clinica,
                ':presaincarico' => $this->presaincarico,
                ':comorbidita' => $this->comorbidita,
                ':esami' => $this->esami,
                ':terapia' => $this->terapia,
                ':ossigeno' => $this->ossigeno,
                ':note' => $this->note,
            ]);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public static function ReadAll()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT covid.*, pazienti.cognome, pazienti.nome, pazienti.datanascita FROM covid INNER JOIN pazienti ON covid.fkpaziente = pazienti.id ORDER BY covid.fkpaziente ASC, covid.datascheda DESC, covid.id DESC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public static function ReadAllOrderByDate()
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT covid.*, pazienti.cognome, pazienti.nome, pazienti.datanascita FROM covid INNER JOIN pazienti ON covid.fkpaziente = pazienti.id ORDER BY covid.datascheda DESC, pazienti.cognome ASC, pazienti.nome ASC";
        $listaArray = $db->exec($sql);

        return $listaArray;
    }

    public static function ReadByFkpaziente($fkpaziente)
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT covid.*, pazienti.cognome, pazienti.nome, pazienti.datanascita FROM covid INNER JOIN pazienti ON covid.fkpaziente = pazienti.id WHERE covid.fkpaziente = :fkpaziente ORDER BY covid.datascheda DESC";

        $listaArray = $db->exec($sql, [
            ':fkpaziente' => $fkpaziente,
        ]);

        return $listaArray;
    }

    public static function ReadByID($id)
    {
        $db = (\App\Db::getInstance())->connect();

        $sql = "SELECT covid.*, pazienti.cognome, pazienti.nome, pazienti.datanascita FROM covid INNER JOIN pazienti ON covid.fkpaziente = pazienti.id WHERE covid.id = '$id'";
        $sqlArray = $db->exec($sql);
        $el = $sqlArray[0];

        return $el;
    }


    public static function FilterLastByStato($lista, $stato)
    {
        $listaUltimeSchede = [];
        $risultato = [];

        $fkpaziente_corrente = null;
        $fkpaziente_precedente = null;

        // Attenzione funziona solo se la lista è ordinata per fkpaziente e datascheda
        // Elimina nella lista (ordinata in base alla data) tutte le schede > 1 per un fkpaziente
        foreach ($lista as $el) {
            $fkpaziente_corrente = $el['fkpaziente'];
            if ($fkpaziente_corrente == $fkpaziente_precedente) {
                // non faccio nulla
            } else {
                $fkpaziente_precedente = $fkpaziente_corrente;
                $listaUltimeSchede[] = $el;
            }
        }

        foreach ($listaUltimeSchede as $el) {
            if (($stato == self::$STATO_POSITIVO) && ($el['stato'] == self::$STATO_POSITIVO)) {
                $risultato[] = $el;
            }
            if (($stato == self::$STATO_SOSPETTO_IN_ATTESA_DI_TAMPONE) && ($el['stato'] == self::$STATO_SOSPETTO_IN_ATTESA_DI_TAMPONE)) {
                $risultato[] = $el;
            }
            if (($stato == self::$STATO_SOSPETTO_NON_IN_ATTESA_DI_TAMPONE) && ($el['stato'] == self::$STATO_SOSPETTO_NON_IN_ATTESA_DI_TAMPONE)) {
                $risultato[] = $el;
            }
            if (($stato == self::$STATO_ISOLAMENTO) && ($el['stato'] == self::$STATO_ISOLAMENTO)) {
                $risultato[] = $el;
            }
            if (($stato == self::$STATO_NEGATIVO) && ($el['stato'] == self::$STATO_NEGATIVO)) {
                $risultato[] = $el;
            }
            if (($stato == self::$STATO_IGNOTO) && ($el['stato'] == self::$STATO_IGNOTO)) {
                $risultato[] = $el;
            }
            if (($stato == self::$STATO_GUARITO) && ($el['stato'] == self::$STATO_GUARITO)) {
                $risultato[] = $el;
            }
            if (($stato == self::$STATO_DECEDUTO) && ($el['stato'] == self::$STATO_DECEDUTO)) {
                $risultato[] = $el;
            }
        }

        usort($risultato, function ($a, $b) {
            $retval = $a['datascheda'] <=> $b['datascheda'];
            if ($retval == 0) {
                $retval = $a['cognome'] <=> $b['cognome'];
                if ($retval == 0) {
                    $retval = $a['nome'] <=> $b['nome'];
                }
            }
            return $retval;
        });

        return $risultato;
    }

    public static function Conteggio($lista, $stato)
    {
        $conteggio = 0;
        $listaUltimeSchede = [];

        $fkpaziente_corrente = null;
        $fkpaziente_precedente = null;
        // Elimina nella lista (ordinata in base alla data) tutte le schede > 1 per un fkpaziente
        foreach ($lista as $el) {
            $fkpaziente_corrente = $el['fkpaziente'];
            if ($fkpaziente_corrente == $fkpaziente_precedente) {
                // non faccio nulla
            } else {
                $fkpaziente_precedente = $fkpaziente_corrente;
                $listaUltimeSchede[] = $el;
            }
        }

        // Utilita::DumpDie($listaUltimeSchede);

        foreach ($listaUltimeSchede as $el) {
            if (($stato == self::$STATO_POSITIVO) && ($el['stato'] == self::$STATO_POSITIVO)) {
                $conteggio += 1;
            }
            if (($stato == self::$STATO_SOSPETTO_IN_ATTESA_DI_TAMPONE) && ($el['stato'] == self::$STATO_SOSPETTO_IN_ATTESA_DI_TAMPONE)) {
                $conteggio += 1;
            }
            if (($stato == self::$STATO_SOSPETTO_NON_IN_ATTESA_DI_TAMPONE) && ($el['stato'] == self::$STATO_SOSPETTO_NON_IN_ATTESA_DI_TAMPONE)) {
                $conteggio += 1;
            }
            if (($stato == self::$STATO_ISOLAMENTO) && ($el['stato'] == self::$STATO_ISOLAMENTO)) {
                $conteggio += 1;
            }
            if (($stato == self::$STATO_NEGATIVO) && ($el['stato'] == self::$STATO_NEGATIVO)) {
                $conteggio += 1;
            }
            if (($stato == self::$STATO_IGNOTO) && ($el['stato'] == self::$STATO_IGNOTO)) {
                $conteggio += 1;
            }
            if (($stato == self::$STATO_GUARITO) && ($el['stato'] == self::$STATO_GUARITO)) {
                $conteggio += 1;
            }
            if (($stato == self::$STATO_DECEDUTO) && ($el['stato'] == self::$STATO_DECEDUTO)) {
                $conteggio += 1;
            }
        }

        return $conteggio;
    }

    public function UpdateDB()
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = "UPDATE covid
                            SET 
                                datascheda = :datascheda,
                                datatampone = :datatampone,
                                stato = :stato, 
                                clinica = :clinica, 
                                comorbidita = :comorbidita, 
                                presaincarico = :presaincarico, 
                                terapia = :terapia, 
                                o2 = :ossigeno, 
                                esami = :esami, 
                                note = :note 
                            WHERE id = :id
                            ;";

            $db->begin();
            $db->exec($sql, [
                ':datascheda' => $this->datascheda,
                ':datatampone' => $this->datatampone,
                ':stato' => $this->stato,
                ':clinica' => $this->clinica,
                ':presaincarico' => $this->presaincarico,
                ':comorbidita' => $this->comorbidita,
                ':esami' => $this->esami,
                ':terapia' => $this->terapia,
                ':ossigeno' => $this->ossigeno,
                ':note' => $this->note,
                ':id' => $this->id,
            ]);
            $db->commit();
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public static function EraseByID($id)
    {
        try {
            $db = (\App\Db::getInstance())->connect();

            $sql = "DELETE FROM covid WHERE id = :id";
            $db->exec($sql, ['id'=>$id]);
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        return true;
    }

    public static function DeleteByFkpaziente($fkpaziente)
   {
      $db = (\app\Db::getInstance())->connect();
      $sql = "DELETE FROM covid WHERE fkpaziente = :fkpaziente";
      $db->exec($sql, [
         ':fkpaziente' => $fkpaziente
      ]);
      return true;
   }
}
