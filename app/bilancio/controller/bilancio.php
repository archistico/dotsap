<?php

namespace App\Bilancio\Controller;
use \app\Utilita;

class Bilancio 
{
   public function Home($f3) {
      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'bilancio/bilancio_home.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function Nuovo($f3) {
      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'bilancio/bilancio_nuovo.htm');
      $f3->set('script', 'bilancio_nuovo.js');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function NuovoDb($f3) {
      $entratauscita = $f3->get('POST.entratauscita');
      $lavoroprivato = $f3->get('POST.lavoroprivato');
      $tipologia = $f3->get('POST.tipologia');
      $totale = $f3->get('POST.totale');
      $tasse = $f3->get('POST.tasse');
      $commissioni = $f3->get('POST.commissioni');
      $data = $f3->get('POST.data');
      $chi = $f3->get('POST.chi');
      $note = $f3->get('POST.note');

      $bilancio = new \app\Bilancio\Model\Bilancio(null, $entratauscita, $lavoroprivato, $tipologia, $totale, $tasse, $commissioni, $data, $chi, $note);
      $bilancio->Insert();

      \app\Flash::instance()->addMessage('Bilancio aggiunto', 'success');
      $f3->reroute('@bilancio_lista');
   }

   public function Modifica($f3, $params) {
      $idbilancio = $params['id'];
      $elemento = \app\Bilancio\Model\Bilancio::SelectById($idbilancio);
      $f3->set('elemento', $elemento);

      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'bilancio/bilancio_modifica.htm');
      $f3->set('script', 'bilancio_modifica.js');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function ModificaDb($f3, $params) {
      $idbilancio = $params['id'];

      $entratauscita = $f3->get('POST.entratauscita');
      $lavoroprivato = $f3->get('POST.lavoroprivato');
      $tipologia = $f3->get('POST.tipologia');
      $totale = $f3->get('POST.totale');
      $tasse = $f3->get('POST.tasse');
      $commissioni = $f3->get('POST.commissioni');
      $data = $f3->get('POST.data');
      $chi = $f3->get('POST.chi');
      $note = $f3->get('POST.note');

      $bilancio = new \app\Bilancio\Model\Bilancio($idbilancio, $entratauscita, $lavoroprivato, $tipologia, $totale, $tasse, $commissioni, $data, $chi, $note);
      $bilancio->Update();

      \app\Flash::instance()->addMessage('Bilancio modificato', 'success');
      $f3->reroute('@bilancio_lista');
   }

   public function Lista($f3) {
      $lista = \app\Bilancio\Model\Bilancio::SelectAll();
      $f3->set('lista', $lista);

      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'bilancio/bilancio_lista.htm');
      $f3->set('script', 'bilancio_lista.js');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function Vedi($f3, $params) {
      $idbilancio = $params['id'];
      $elemento = \app\Bilancio\Model\Bilancio::SelectById($idbilancio);
      $f3->set('elemento', $elemento);

      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'bilancio/bilancio_vedi.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function Cancella($f3, $params) {
      $idbilancio = $params['id'];
      $elemento = \app\Bilancio\Model\Bilancio::SelectById($idbilancio);
      $f3->set('elemento', $elemento);

      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'bilancio/bilancio_cancella.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function CancellaDb($f3, $params) {
      $idbilancio = $params['id'];
      \app\Bilancio\Model\Bilancio::DeleteById($idbilancio);

      \app\Flash::instance()->addMessage('Bilancio cancellato', 'success');
      $f3->reroute('@bilancio_lista');
   }
}
