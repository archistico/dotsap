<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();
$f3->set('CACHE', true);
$f3->set('DEBUG', 3);

// Appuntamenti
$f3->route('GET @appuntamenti: /appuntamenti', '\App\Appuntamenti->Tabella');
$f3->route('GET @giorno: /appuntamenti/@giorno', '\App\Appuntamenti->TabellaGiorno');
$f3->route('POST @appuntamentomodifica: /appuntamenti/modifica', '\App\Appuntamenti->Modifica');
$f3->route('POST @appuntamentoaggiungi: /appuntamenti/aggiungi', '\App\Appuntamenti->Aggiungi');

// Entrate/Uscite
$f3->route('GET @lista: /lista', '\App\Movimento->Lista');
$f3->route('GET @home: /', '\App\Movimento->Homepage');
$f3->route('GET @nuovo: /nuovo', '\App\Movimento->Nuovo');
$f3->route('GET @nuovo2: /nuovo/@num', '\App\Movimento->Nuovo2');
$f3->route('GET @nuovo3: /nuovo/@cat1/@cat2', '\App\Movimento->Nuovo3');
$f3->route('GET @nuovo4: /nuovo/@cat1/@cat2/@cat3', '\App\Movimento->Nuovo4');
$f3->route('GET @nuovo5: /nuovo/@cat1/@cat2/@cat3/@cat4', '\App\Movimento->Nuovo5');
$f3->route('POST @registra: /registra', '\App\Movimento->Registra');
$f3->route('GET @cancella: /cancella/@id', '\App\Movimento->Cancella');
$f3->route('POST @sopprimi: /sopprimi', '\App\Movimento->Sopprimi');

// Autenticazione
$f3->route('GET @login: /login', '\App\Auth->Login');
$f3->route('POST @loginCheck: /loginCheck', '\App\Auth->LoginCheck');
$f3->route('GET @logout: /logout', '\App\Auth->Logout');
$f3->route('GET @autentica: /autentica', '\App\Auth->Autentica');
$f3->route('GET @utente: /utente', '\App\Admin->UtenteLista');
$f3->route('GET @utentenuovo: /utente/nuovo', '\App\Admin->UtenteNuovo');
$f3->route('GET @utentecancella: /utente/cancella/@user_id', '\App\Admin->UtenteCancella');
$f3->route('POST @utenteregistra: /utente/registra', '\App\Admin->UtenteRegistra');

$f3->run();
