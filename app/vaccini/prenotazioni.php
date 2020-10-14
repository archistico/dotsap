<?php

namespace App\Vaccini;

use App\Utilita;

class Prenotazioni
{
  // Bisogna essere loggati
  public function beforeroute($f3)
  {
    $auth = \App\Auth::Autentica($f3);
    if (!$auth) {
      $f3->set('logged', false);
      $f3->reroute('/login');
    } else {
      $f3->set('logged', true);
    }
  }

  public function Tabella($f3)
  {
    $oggi = new \Datetime();
    $dmy = $oggi->format('d-m-Y');
    $f3->reroute('/vaccini/prenotazioni/tabella/' . $dmy);
  }

  public function TabellaGiorno($f3, $params)
  {
    $settimana = new \App\Settimana($params['data']);

    $listaGiorni = new \App\ListaGiorni();
    $listaGiorni->Add(new \App\Giorno($settimana->lunedi->format('d/m/Y'), 'Lunedì'));
    $listaGiorni->Add(new \App\Giorno($settimana->martedi->format('d/m/Y'), 'Martedì'));
    $listaGiorni->Add(new \App\Giorno($settimana->mercoledi->format('d/m/Y'), 'Mercoledì'));
    $listaGiorni->Add(new \App\Giorno($settimana->giovedi->format('d/m/Y'), 'Giovedì'));
    $listaGiorni->Add(new \App\Giorno($settimana->venerdi->format('d/m/Y'), 'Venerdì'));

    $listaOrari = new \App\Vaccini\PrenotazioneOrari();

    $orari_check = new \App\Orari_check();

    $ORARIO_SUDDIVISIONE = ["00", "03", "06", "10", "13", "16", "20", "23", "26", "30", "33", "36", "40", "43", "46", "50", "53", "56"];
    $ORARIO_SETTIMANALE = [
      [
        'giorno' => 'Lunedì',
        'inizio' => '14:30',
        'fine' => '15:30'
      ],
      [
        'giorno' => 'Martedì',
        'inizio' => '14:30',
        'fine' => '15:30'
      ],
      [
        'giorno' => 'Mercoledì',
        'inizio' => '14:30',
        'fine' => '15:30'
      ],
      [
        'giorno' => 'Giovedì',
        'inizio' => '14:30',
        'fine' => '15:30'
      ],
      [
        'giorno' => 'Venerdì',
        'inizio' => '14:30',
        'fine' => '15:30'
      ],
    ];

    $orari_check->OrarioByArray(8, 18, $ORARIO_SUDDIVISIONE);

    $app_check = new \App\Vaccini\PrenotazioneGiornataHelper($orari_check);

    foreach ($ORARIO_SETTIMANALE as $a) {
      $app_check->AddGiornata($a['giorno'], $a['inizio'], $a['fine']);
    }

    $giorni_settimana = ["Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì"];
    $orario_giornaliero = $orari_check->getOrari();

    // Seleziono orari attivi o non attivi
    foreach ($giorni_settimana as $g) {
      foreach ($orario_giornaliero as $o) {
        $listaOrari->Add(new \App\Vaccini\PrenotazioneOrario($g, $o, $app_check->CercaPrenotabile($g, $o)));
      }
    }

    $listaAppuntamenti = new \App\Vaccini\PrenotazioneLista();
    foreach (\App\Vaccini\Prenotazione::ReadAll() as $p) {
      $data = Utilita::ConvertToDMY($p['data']);
      $persona = \App\Vaccini\Vaccinabile::ReadById($p['fkpersona']);
      $listaAppuntamenti->Add(new \App\Vaccini\Prenotazione($p['idprenotazione'], $data, $p['ora'], ['fkpersona' => $p['fkpersona'], 'denominazione' => $persona['denominazione']], $p['antinfluenzale'], $p['antipneumococco'], $p['fatto']));
    }

    $tabella = new \App\Vaccini\PrenotazioneTabella($listaGiorni, $listaOrari, $listaAppuntamenti);

    // -------------------------

    $listaVaccinabili = \App\Vaccini\Vaccinabile::ListaVaccinabili();
    $f3->set('listaVaccinabili', $listaVaccinabili);

    $f3->set('tabella', $tabella->ToArray());

    $f3->set('lunedi', $settimana->lunedi->format('d-m-Y'));
    $f3->set('domenica', $settimana->domenica->format('d-m-Y'));

    $f3->set('lunediPrecedente', $settimana->lunediPrecedente->format('d-m-Y'));
    $f3->set('lunediSuccessivo', $settimana->lunediSuccessivo->format('d-m-Y'));

    $f3->set('titolo', 'Vaccini');
    $f3->set('script', 'prenotazionitabella.js');
    $f3->set('contenuto', 'vaccini/prenotazioni/tabella.htm');
    echo \Template::instance()->render('templates/base.htm');
  }

  public function Registra($f3)
  {
    $data = $f3->get('POST.data');
    $ora = $f3->get('POST.ora');
    $fkpersona = $f3->get('POST.fkpersona');
    $antinfluenzale = $f3->get('POST.antinfluenzale');
    $antipneumococco = $f3->get('POST.antipneumococco');
    $lunedi = $f3->get('POST.tabelladata');

    $p = new \App\Vaccini\Prenotazione(null, $data, $ora, $fkpersona, $antinfluenzale, $antipneumococco, 0);
    $p->AddDB();

    // ridirigi sulla tabella con la data della registrazione
    $f3->reroute('/vaccini/prenotazioni/tabella/' . $lunedi);
  }

  public function Modifica($f3)
  {
    $idprenotazione = $f3->get('POST.idprenotazione');
    $data = $f3->get('POST.data');
    $ora = $f3->get('POST.ora');
    $fkpersona = $f3->get('POST.fkpersona');
    $antinfluenzale = $f3->get('POST.antinfluenzale');
    $antipneumococco = $f3->get('POST.antipneumococco');
    $lunedi = $f3->get('POST.tabelladata');
    $tipologia = $f3->get('POST.tipologia');

    if ($tipologia == "modifica") {
      $p = new \App\Vaccini\Prenotazione($idprenotazione, $data, $ora, $fkpersona, $antinfluenzale, $antipneumococco, 0);
      $p->UpdateDB();
    }

    if ($tipologia == "fatto") {
      $p = new \App\Vaccini\Prenotazione($idprenotazione, $data, $ora, $fkpersona, $antinfluenzale, $antipneumococco, 1);
      $p->UpdateDB();
    }

    if ($tipologia == "cancella") {
      \App\Vaccini\Prenotazione::EraseById($idprenotazione);
    }

    // ridirigi sulla tabella con la data della registrazione
    $f3->reroute('/vaccini/prenotazioni/tabella/' . $lunedi);
  }

  public function Cancella($f3, $params)
  {
    $idprenotazione = $params['id'];
    \App\Vaccini\Prenotazione::EraseById($idprenotazione);
    
    $f3->reroute('@vaccini_prenotazioni_lista');
  }

  public function Lista($f3)
  {
    $lista = \App\Vaccini\Prenotazione::ReadComplete();
    $f3->set('lista', $lista);

    $f3->set('titolo', 'Vaccini');
    $f3->set('contenuto', 'vaccini/prenotazioni/lista.htm');
    \Template::instance()->filter('vaccinato','\App\Helpers\Filter::instance()->vaccinato');
    \Template::instance()->filter('fatto','\App\Helpers\Filter::instance()->fatto');
    echo \Template::instance()->render('templates/base.htm');
  }

  public function Pdf($f3)
  {
    $sizeFontGrande = 10;
    $sizeFontPiccolo = 8;
    $altezze_linea = 6;

    $larghezza_data = 18;
    $larghezza_ora = 10;
    $larghezza_cognomenome = 54;
    $larghezza_eta = 8;
    $larghezza_rischio = 36;
    $larghezza_vaccinato2019 = 12;
    $larghezza_antinfluenzale = 22;
    $larghezza_antipneumococco = 25;
    $larghezza_fatto = 8;

    $lista = \App\Vaccini\Prenotazione::ReadComplete();

    $pdf = new \FPDF();
    $pdf->AddPage();
    $pdf->SetMargins(8, 10, 8);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->SetFont('Arial', 'B', $sizeFontGrande);
    $pdf->Cell(0, 10, "LISTA PRENOTAZIONI", '', '', 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', $sizeFontPiccolo);

    // INTESTAZIONE TABELLA 

    $pdf->Cell($larghezza_data, $altezze_linea, 'Data', 1, 0, 'C');
    $pdf->Cell($larghezza_ora, $altezze_linea, 'Ora', 1, 0, 'C');
    $pdf->Cell($larghezza_cognomenome, $altezze_linea, 'Cognome nome', 1, 0, 'L');
    $pdf->Cell($larghezza_eta, $altezze_linea, iconv('UTF-8', 'windows-1252', "Età"), 1, 0, 'L');
    $pdf->Cell($larghezza_rischio, $altezze_linea, 'Rischio', 1, 0, 'L');
    $pdf->Cell($larghezza_vaccinato2019, $altezze_linea, 'V. 2019', 1, 0, 'C');
    $pdf->Cell($larghezza_antinfluenzale, $altezze_linea, 'Antinfluenzale', 1, 0, 'C');
    $pdf->Cell($larghezza_antipneumococco, $altezze_linea, 'Antipneumococco', 1, 0, 'C');
    $pdf->Cell($larghezza_fatto, $altezze_linea, 'Fatto', 1, 1, 'C');


    // INSERIMENTO PAZIENTI 

    foreach ($lista as $p) {
      $cognomenome = iconv('UTF-8', 'windows-1252', $p['denominazione']);
      $data = Utilita::ConvertToDMY($p['data']);
      $antinfluenzale = $p['antinfluenzale'];
      if($antinfluenzale == 'Altro antinfluenzale') {
        $antinfluenzale = "Altro";
      }
      $antipneumococco = $p['antipneumococco'];
      $ora = $p['ora'];
      $eta = $p['eta'];
      $rischio = $p['rischio'];
      $vaccinato2019 = $p["vaccinato2019"] == 1 ? "X" : "-";
      $fatto = $p["fatto"] == 1 ? "X" : "-";

      $pdf->Cell($larghezza_data, $altezze_linea, $data, 1, 0, 'C');
      $pdf->Cell($larghezza_ora, $altezze_linea, $ora, 1, 0, 'C');
      $pdf->Cell($larghezza_cognomenome, $altezze_linea, $cognomenome, 1, 0, 'L');
      $pdf->Cell($larghezza_eta, $altezze_linea, $eta, 1, 0, 'L');
      $pdf->Cell($larghezza_rischio, $altezze_linea, $rischio, 1, 0, 'L');
      $pdf->Cell($larghezza_vaccinato2019, $altezze_linea, $vaccinato2019, 1, 0, 'C');
      $pdf->Cell($larghezza_antinfluenzale, $altezze_linea, $antinfluenzale, 1, 0, 'C');
      $pdf->Cell($larghezza_antipneumococco, $altezze_linea, $antipneumococco, 1, 0, 'C');
      $pdf->Cell($larghezza_fatto, $altezze_linea, $fatto, 1, 1, 'C');
    }

    $titolo = "Prenotazioni del " . date("d-m-Y");
    $pdf->SetTitle($titolo);
    $pdf->Output('', $titolo . ".pdf");
  }
}
