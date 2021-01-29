<?php

namespace App;

class Utenti 
{
    public function beforeroute($f3)
    {
        $auth = \App\Auth::Autentica($f3);
        if (!$auth) {
            \App\Flash::instance()->addMessage('Prima effettuare il login', 'danger');
            $f3->set('logged', false);
            $f3->reroute('@login');
        } else {
            $f3->set('logged', true);
        }
    }
   
   public function Nuovo($f3) {
      $lista_ruoli = \App\Utente::ListaRuolo();
      $f3->set('lista_ruoli', $lista_ruoli);

      $f3->set('titolo', 'Utente');
      $f3->set('contenuto', '/utente/utente_nuovo.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function NuovoDb($f3) {
      $username = $f3->get('POST.username');
      $password = $f3->get('POST.password');
      $role = $f3->get('POST.role');

      $username = str_replace(" ", "_", $username);
      $password_hash = hash('sha512', $password, false);
      $password_hash_2 = hash('sha512', $password_hash, false);

      $utente = new \App\Utente(null, $username, $password_hash_2, $role);
      $utente->Insert();

      \App\Flash::instance()->addMessage('Utente aggiunto', 'success');
      $f3->reroute('@amministrazione');
   }

   public function Modifica($f3, $params) {
      $idutente = $params['id'];
      $utente = \App\Utente::SelectById($idutente);
      $f3->set('utente', $utente);

      $lista_ruoli = \App\Utente::ListaRuolo();
      $f3->set('lista_ruoli', $lista_ruoli);

      $f3->set('titolo', 'Utente');
      $f3->set('contenuto', '/utente/utente_modifica.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function ModificaDb($f3, $params) {
      $idutente = $params['id'];

      $username = $f3->get('POST.username');
      $password = $f3->get('POST.password');
      $role = $f3->get('POST.role');

      $username = str_replace(" ", "_", $username);
      $password_hash = hash('sha512', $password, false);
      $password_hash_2 = hash('sha512', $password_hash, false);

      $utente = new \App\Utente($idutente, $username, $password_hash_2, $role);
      $utente->Update();

      \App\Flash::instance()->addMessage('Utente modificato', 'success');
      $f3->reroute('@amministrazione');
   }

   public function Cancella($f3, $params) {
      $idutente = $params['id'];
      $utente = \App\Utente::SelectById($idutente);
      $f3->set('utente', $utente);

      $f3->set('titolo', 'Utente');
      $f3->set('contenuto', '/utente/utente_cancella.htm');
      echo \Template::instance()->render('templates/base.htm');
   }

   public function CancellaDb($f3, $params) {
      $idutente = $params['id'];
      \App\Utente::DeleteById($idutente);

      \App\Flash::instance()->addMessage('Utente cancellato', 'success');
      $f3->reroute('@amministrazione');
   }
}
