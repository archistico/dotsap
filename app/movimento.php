<?php
namespace App;

class Movimento
{
    function beforeroute($f3) {
        $auth = \App\Auth::Autentica($f3); 
        if(!$auth) {
            $f3->set('logged', false);
            $f3->reroute('/login');
        } else {
            $f3->set('logged', true);
        }
    }
    
    public function Homepage($f3)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = 'SELECT SUM(importo) AS somma';
        $sql .= ' FROM movimenti';
        $sql .= ' WHERE cat1 = 2';
        $risultato = $db->exec($sql);
        $totentrate = $risultato[0]['somma'];

        $sql = 'SELECT SUM(importo) AS somma';
        $sql .= ' FROM movimenti';
        $sql .= ' WHERE cat1 = 1';
        $risultato = $db->exec($sql);
        $totuscite = $risultato[0]['somma'];

        $differenza = $totentrate + $totuscite;

        $sql = 'SELECT categoria1.descrizione AS des1, categoria2.descrizione AS des2, SUM(importo) AS subtotale';
        $sql .= ' FROM movimenti';
        $sql .= ' JOIN categoria1 ON movimenti.cat1 = categoria1.id';
        $sql .= ' JOIN categoria2 ON movimenti.cat2 = categoria2.id';
        $sql .= ' WHERE movimenti.cat1 = 1';
        $sql .= ' GROUP BY categoria2.id';
        $f3->set('listauscite2', $db->exec($sql));

        $sql = 'SELECT categoria1.descrizione AS des1, categoria2.descrizione AS des2, SUM(importo) AS subtotale';
        $sql .= ' FROM movimenti';
        $sql .= ' JOIN categoria1 ON movimenti.cat1 = categoria1.id';
        $sql .= ' JOIN categoria2 ON movimenti.cat2 = categoria2.id';
        $sql .= ' WHERE movimenti.cat1 = 2';
        $sql .= ' GROUP BY categoria2.id';
        $f3->set('listaentrate2', $db->exec($sql));

        $f3->set('totentrate', $totentrate);
        $f3->set('totuscite', $totuscite);
        $f3->set('differenza', $differenza);

        $f3->set('euro', function ($i) {
            if ($i >= 0) {
                return "+" . number_format((float) $i, 2, '.', '') . " €";
            } else {
                return number_format((float) $i, 2, '.', '') . " €";
            }
        }
        );
        $f3->set('titolo', 'Home');
        $f3->set('contenuto', 'homepage.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Lista($f3)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $sql = "SELECT movimenti.id, movimenti.giorno, movimenti.importo, movimenti.note,";
        $sql .= " categoria1.descrizione AS des1,";
        $sql .= " categoria2.descrizione AS des2,";
        $sql .= " categoria3.descrizione AS des3,";
        $sql .= " categoria4.descrizione AS des4";
        $sql .= " FROM movimenti";
        $sql .= " JOIN categoria1 ON categoria1.id = movimenti.cat1";
        $sql .= " JOIN categoria2 ON categoria2.id = movimenti.cat2";
        $sql .= " JOIN categoria3 ON categoria3.id = movimenti.cat3";
        $sql .= " JOIN categoria4 ON categoria4.id = movimenti.cat4";
        $sql .= " ORDER BY giorno DESC";

        $f3->set('lista', $db->exec($sql));

        $f3->set('convertiData',
            function ($d) {
                $str = jdtojulian($d);
                $dmy = \DateTime::createFromFormat('m/d/Y', $str)->format('d/m/Y');
                return $dmy;
            }
        );

        $f3->set('unisci',
            function ($a, $b, $c, $d) {
                return $a . " / " . $b . " / " . $c . " / " . $d;
            }
        );

        $f3->set('euro', function ($i) {
            if ($i >= 0) {
                return "+" . number_format((float) $i, 2, '.', '') . " €";
            } else {
                return number_format((float) $i, 2, '.', '') . " €";
            }
        }
        );

        $f3->set('titolo', 'Lista');
        $f3->set('contenuto', 'lista.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Nuovo($f3)
    {
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $f3->set('categoria1', $db->exec('SELECT * FROM categoria1 ORDER BY categoria1.descrizione ASC'));

        $f3->set('titolo', 'Nuovo');
        $f3->set('contenuto', 'nuovo.htm');
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Nuovo2($f3, $params)
    {
        $cat1 = $params['num'];

        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = 'SELECT categoria1.descrizione AS categoria1 FROM categoria1 WHERE categoria1.id=' . $cat1;
        $risultato = $db->exec($sql);
        $f3->set('categoria1', $risultato[0]['categoria1']);

        $sql = 'SELECT categoria2.id, categoria2.descrizione AS cat2, categoria1.descrizione AS cat1 FROM categoria2 JOIN categoria1 ON categoria2.madre = categoria1.id WHERE categoria2.madre=' . $cat1 . ' ORDER BY categoria1.descrizione ASC, categoria2.descrizione ASC';
        $f3->set('categoria2', $db->exec($sql));

        $f3->set('titolo', 'Nuovo');
        $f3->set('contenuto', 'nuovo2.htm');
        $f3->set('cat1', $cat1);
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Nuovo3($f3, $params)
    {
        $cat1 = $params['cat1'];
        $cat2 = $params['cat2'];

        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = 'SELECT categoria1.descrizione AS categoria1 FROM categoria1 WHERE categoria1.id=' . $cat1;
        $risultato = $db->exec($sql);
        $f3->set('categoria1', $risultato[0]['categoria1']);

        $sql = 'SELECT categoria2.descrizione AS categoria2 FROM categoria2 WHERE categoria2.id=' . $cat2;
        $risultato = $db->exec($sql);
        $f3->set('categoria2', $risultato[0]['categoria2']);

        $sql = 'SELECT categoria3.id, categoria3.descrizione AS cat3, categoria1.descrizione AS cat1, categoria2.descrizione AS cat2';
        $sql .= ' FROM categoria3 JOIN categoria1 ON categoria2.madre = categoria1.id JOIN categoria2 ON categoria3.madre = categoria2.id';
        $sql .= ' WHERE categoria3.madre = ' . $cat2;
        $sql .= ' ORDER BY categoria1.descrizione ASC, categoria2.descrizione ASC, categoria3.descrizione ASC';
        $f3->set('categoria3', $db->exec($sql));

        $f3->set('titolo', 'Nuovo');
        $f3->set('contenuto', 'nuovo3.htm');
        $f3->set('cat1', $cat1);
        $f3->set('cat2', $cat2);
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Nuovo4($f3, $params)
    {
        $cat1 = $params['cat1'];
        $cat2 = $params['cat2'];
        $cat3 = $params['cat3'];

        $db = new \DB\SQL('sqlite:db/database.sqlite');

        $sql = 'SELECT categoria1.descrizione AS categoria1 FROM categoria1 WHERE categoria1.id=' . $cat1;
        $risultato = $db->exec($sql);
        $f3->set('categoria1', $risultato[0]['categoria1']);

        $sql = 'SELECT categoria2.descrizione AS categoria2 FROM categoria2 WHERE categoria2.id=' . $cat2;
        $risultato = $db->exec($sql);
        $f3->set('categoria2', $risultato[0]['categoria2']);

        $sql = 'SELECT categoria3.descrizione AS categoria3 FROM categoria3 WHERE categoria3.id=' . $cat3;
        $risultato = $db->exec($sql);
        $f3->set('categoria3', $risultato[0]['categoria3']);

        
        $sql = 'SELECT categoria4.id, categoria4.descrizione AS cat4, categoria3.descrizione AS cat3, categoria1.descrizione AS cat1, categoria2.descrizione AS cat2';
        $sql .= ' FROM categoria4 JOIN categoria1 ON categoria2.madre = categoria1.id JOIN categoria2 ON categoria3.madre = categoria2.id JOIN categoria3 ON categoria4.madre = categoria3.id';
        $sql .= ' WHERE categoria4.madre = ' . $cat3;
        $sql .= ' ORDER BY categoria1.descrizione ASC, categoria2.descrizione ASC, categoria3.descrizione ASC, categoria4.descrizione ASC';
        $f3->set('categoria4', $db->exec($sql));

        $f3->set('titolo', 'Nuovo');
        $f3->set('contenuto', 'nuovo4.htm');
        $f3->set('cat1', $cat1);
        $f3->set('cat2', $cat2);
        $f3->set('cat3', $cat3);

        echo \Template::instance()->render('templates/base.htm');
    }

    public function Nuovo5($f3, $params)
    {
        $cat1 = $params['cat1'];
        $cat2 = $params['cat2'];
        $cat3 = $params['cat3'];
        $cat4 = $params['cat4'];

        $db = new \DB\SQL('sqlite:db/database.sqlite');
        
        $sql = 'SELECT categoria1.descrizione AS categoria1 FROM categoria1 WHERE categoria1.id=' . $cat1;
        $risultato = $db->exec($sql);
        $f3->set('categoria1', $risultato[0]['categoria1']);

        $sql = 'SELECT categoria2.descrizione AS categoria2 FROM categoria2 WHERE categoria2.id=' . $cat2;
        $risultato = $db->exec($sql);
        $f3->set('categoria2', $risultato[0]['categoria2']);

        $sql = 'SELECT categoria3.descrizione AS categoria3 FROM categoria3 WHERE categoria3.id=' . $cat3;
        $risultato = $db->exec($sql);
        $f3->set('categoria3', $risultato[0]['categoria3']);

        $sql = 'SELECT categoria4.descrizione AS categoria4 FROM categoria4 WHERE categoria4.id=' . $cat4;
        $risultato = $db->exec($sql);
        $f3->set('categoria4', $risultato[0]['categoria4']);

        $f3->set('titolo', 'Nuovo');
        $f3->set('contenuto', 'nuovo5.htm');
        $f3->set('cat1', $cat1);
        $f3->set('cat2', $cat2);
        $f3->set('cat3', $cat3);
        $f3->set('cat4', $cat4);

        echo \Template::instance()->render('templates/base.htm');
    }

    public function Registra($f3, $params)
    {
        $importo = $f3->get('POST.importo');
        $data = $f3->get('POST.data');
        $note = $f3->get('POST.note');
        $cat1 = $f3->get('POST.cat1');
        $cat2 = $f3->get('POST.cat2');
        $cat3 = $f3->get('POST.cat3');
        $cat4 = $f3->get('POST.cat4');

        if ($cat1 == 1) {
            $importo = -$importo;
        }

        $categoria = "";

        $db = new \DB\SQL('sqlite:db/database.sqlite');

        /*
        $rcat1 = $db->exec("SELECT * FROM categoria1 WHERE id = $cat1");
        $categoria .= $rcat1[0]['descrizione'];
        $rcat2 = $db->exec("SELECT * FROM categoria2 WHERE id = $cat2");
        $categoria .= " / " . $rcat2[0]['descrizione'];
        $rcat3 = $db->exec("SELECT * FROM categoria3 WHERE id = $cat3");
        $categoria .= " / " . $rcat3[0]['descrizione'];
        $rcat4 = $db->exec("SELECT * FROM categoria4 WHERE id = $cat4");
        $categoria .= " / " . $rcat4[0]['descrizione'];

        $f3->set('categoria', $categoria);
        $f3->set('importo', $importo);
        $f3->set('data', $data);
        $f3->set('note', $note);
        */

        // 2018-09-13
        $data_array = explode("-", $data);
        $jd = juliantojd($data_array[1], $data_array[2], $data_array[0]);

        $importo = str_replace(',', '.', (string)$importo);

        $note = str_replace('"', "", $note);
        $note = str_replace("'", "", $note);

        $db->begin();
        $sql = "INSERT into movimenti values(null, '$jd', '$importo', '$note', '$cat1', '$cat2', '$cat3', '$cat4')";
        
        $db->exec($sql);
        $db->commit();

        $f3->reroute('/lista');
    }

    public function Cancella($f3, $params)
    {
        $f3->set('titolo', 'Homepage');
        $f3->set('contenuto', 'cancella.htm');
        $f3->set('id', $params['id']);
        echo \Template::instance()->render('templates/base.htm');
    }

    public function Sopprimi($f3, $params)
    {
        $id = $f3->get('POST.id');
        $db = new \DB\SQL('sqlite:db/database.sqlite');
        $db->begin();
        $sql = "DELETE FROM movimenti WHERE movimenti.id = $id";
        $db->exec($sql);
        $db->commit();

        $f3->reroute('/lista');
    }
}
