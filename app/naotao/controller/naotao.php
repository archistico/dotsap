<?php

namespace App\Naotao\Controller;
use \app\Utilita;

class Naotao 
{
   public function Nuovo($f3) {
      $lista_farmaci = [ 
         'TAO - COUMADIN', 
         'TAO - SINTROM',
         'NAO - PRADAXA 110',
         'NAO - PRADAXA 150',
         'NAO - ELIQUIS 2.5',
         'NAO - ELIQUIS 5',
         'NAO - LIXIANA 30',
         'NAO - LIXIANA 60',
         'NAO - XARELTO 15',
         'NAO - XARELTO 20'
      ];
      $f3->set('lista_farmaci', $lista_farmaci);

      $listapazienti = \App\Paziente::ReadAllName();
      $f3->set('lista_pazienti', $listapazienti);

      // Utilita::Dump($listapazienti);

      $f3->set('titolo', 'Naotao');
      $f3->set('contenuto', 'naotao/naotao_nuovo.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function NuovoDb($f3) {
      $fkpaziente = $f3->get('POST.fkpaziente');
      $farmaco = $f3->get('POST.farmaco');
      $dataultimiesami = $f3->get('POST.dataultimiesami');
      $allegatocompilato = $f3->get('POST.allegatocompilato');
      $datafollowup = $f3->get('POST.datafollowup');
      $esamiprescritti = $f3->get('POST.esamiprescritti');
      $convocare = $f3->get('POST.convocare');
      $note = $f3->get('POST.note');

      $naotao = new \app\Naotao\Model\Naotao(null, $fkpaziente, $farmaco, $dataultimiesami, $allegatocompilato, $datafollowup, $esamiprescritti, $convocare, $note);
      $naotao->Insert();

      \app\Flash::instance()->addMessage('Naotao aggiunto', 'success');
      $f3->reroute('@naotao_lista');
   }

   public function Modifica($f3, $params) {
      $idnaotao = $params['id'];
      $elemento = \app\Naotao\Model\Naotao::SelectById($idnaotao);
      $f3->set('elemento', $elemento);

      $f3->set('titolo', 'Naotao');
      $f3->set('contenuto', 'naotao/naotao_modifica.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function ModificaDb($f3, $params) {
      $idnaotao = $params['id'];

      $fkpaziente = $f3->get('POST.fkpaziente');
      $farmaco = $f3->get('POST.farmaco');
      $dataultimiesami = $f3->get('POST.dataultimiesami');
      $allegatocompilato = $f3->get('POST.allegatocompilato');
      $datafollowup = $f3->get('POST.datafollowup');
      $esamiprescritti = $f3->get('POST.esamiprescritti');
      $convocare = $f3->get('POST.convocare');
      $note = $f3->get('POST.note');

      $naotao = new \app\Naotao\Model\Naotao($idnaotao, $fkpaziente, $farmaco, $dataultimiesami, $allegatocompilato, $datafollowup, $esamiprescritti, $convocare, $note);
      $naotao->Update();

      \app\Flash::instance()->addMessage('Naotao modificato', 'success');
      $f3->reroute('@naotao_lista');
   }

   public function Lista($f3) {
      $lista = \app\Naotao\Model\Naotao::SelectAll();
      $f3->set('lista', $lista);

      $f3->set('titolo', 'Naotao');
      $f3->set('contenuto', 'naotao/naotao_lista.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function Cancella($f3, $params) {
      $idnaotao = $params['id'];
      $elemento = \app\Naotao\Model\Naotao::SelectById($idnaotao);
      $f3->set('elemento', $elemento);

      $f3->set('titolo', 'Naotao');
      $f3->set('contenuto', 'naotao/naotao_cancella.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function CancellaDb($f3, $params) {
      $idnaotao = $params['id'];
      \app\Naotao\Model\Naotao::DeleteById($idnaotao);

      \app\Flash::instance()->addMessage('Naotao cancellato', 'success');
      $f3->reroute('@naotao_lista');
   }
}
