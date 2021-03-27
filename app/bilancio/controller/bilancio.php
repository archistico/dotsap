<?php

namespace App\Controller\Bilancio;
use \app\Helper\Utilita;

class Bilancio 
{
   public function Nuovo($f3) {
      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'Bilancio/Bilancio_nuovo.htm');
      $f3->set('script', 'Bilancio_nuovo.js');
      echo \Template::instance()->render('../app/View/Generic/Base.htm');
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

      $bilancio = new \app\Model\Bilancio(null, $entratauscita, $lavoroprivato, $tipologia, $totale, $tasse, $commissioni, $data, $chi, $note);
      $bilancio->Insert();

      \app\Helper\Flash::instance()->addMessage('Bilancio aggiunto', 'success');
      $f3->reroute('@bilancio_lista');
   }

   public function Modifica($f3, $params) {
      $idbilancio = $params['id'];
      $elemento = \app\Model\Bilancio::SelectById($idbilancio);
      $f3->set('elemento', $elemento);

      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'Bilancio/Bilancio_modifica.htm');
      $f3->set('script', 'Bilancio_modifica.js');
      echo \Template::instance()->render('../app/View/Generic/Base.htm');
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

      $bilancio = new \app\Model\Bilancio($idbilancio, $entratauscita, $lavoroprivato, $tipologia, $totale, $tasse, $commissioni, $data, $chi, $note);
      $bilancio->Update();

      \app\Helper\Flash::instance()->addMessage('Bilancio modificato', 'success');
      $f3->reroute('@bilancio_lista');
   }

   public function Lista($f3) {
      $lista = \app\Model\Bilancio::SelectAll();
      $f3->set('lista', $lista);

      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'Bilancio/Bilancio_lista.htm');
      $f3->set('script', 'Bilancio_lista.js');
      echo \Template::instance()->render('../app/View/Generic/Base.htm');
   }

   public function Vedi($f3, $params) {
      $idbilancio = $params['id'];
      $elemento = \app\Model\Bilancio::SelectById($idbilancio);
      $f3->set('elemento', $elemento);

      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'Bilancio/Bilancio_vedi.htm');
      echo \Template::instance()->render('../app/View/Generic/Base.htm');
   }

   public function Cancella($f3, $params) {
      $idbilancio = $params['id'];
      $elemento = \app\Model\Bilancio::SelectById($idbilancio);
      $f3->set('elemento', $elemento);

      $f3->set('titolo', 'Bilancio');
      $f3->set('contenuto', 'Bilancio/Bilancio_cancella.htm');
      echo \Template::instance()->render('../app/View/Generic/Base.htm');
   }

   public function CancellaDb($f3, $params) {
      $idbilancio = $params['id'];
      \app\Model\Bilancio::DeleteById($idbilancio);

      \app\Helper\Flash::instance()->addMessage('Bilancio cancellato', 'success');
      $f3->reroute('@bilancio_lista');
   }
}
