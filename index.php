<?php
require 'vendor/autoload.php';
$f3 = \Base::instance();
$f3->set('CACHE', true);
$f3->set('DEBUG', 3);
$f3->set('ANNO', date("Y"));

$f3->route('GET @home: /', '\App\Appuntamenti->Homepage');

// Appuntamenti
$f3->route('GET @appuntamenti: /appuntamenti', '\App\Appuntamenti->Tabella');
$f3->route('GET @giorno: /appuntamenti/@data', '\App\Appuntamenti->TabellaGiorno');
$f3->route('GET @appuntamentilista: /appuntamentilista', '\App\Appuntamenti->Lista');
$f3->route('POST @appuntamentomodifica: /appuntamenti/modifica', '\App\Appuntamenti->Modifica');
$f3->route('POST @appuntamentoaggiungi: /appuntamenti/aggiungi', '\App\Appuntamenti->Aggiungi');
$f3->route('POST @appuntamentoparti: /appuntamenti/parti', '\App\Appuntamenti->Parti');

// Todo
$f3->route('GET @todocancella: /todo/cancella/@id', '\App\Todo->Cancella');
$f3->route('POST @todoaggiungi: /todo/aggiungi', '\App\Todo->Aggiungi');

// Ricette
$f3->route('GET @ricettalista: /ricetta/lista', '\App\Ricetta->Lista');
$f3->route('GET @ricettanuova: /ricetta/nuova', '\App\Ricetta->Nuova');
$f3->route('POST @ricettaaggiungi: /ricetta/aggiungi', '\App\Ricetta->Aggiungi');
$f3->route('GET @ricettacancella: /ricetta/cancella/@id', '\App\Ricetta->Cancella');
$f3->route('GET @ricettamodifica: /ricetta/modifica/@id', '\App\Ricetta->Modifica');
$f3->route('POST @ricettamodificapost: /ricetta/modifica/@id', '\App\Ricetta->ModificaPost');

// Entrate/Uscite
$f3->route('GET @lista: /lista', '\App\Movimento->Lista');
$f3->route('GET @nuovo: /nuovo', '\App\Movimento->Nuovo');
$f3->route('GET @nuovo2: /nuovo/@num', '\App\Movimento->Nuovo2');
$f3->route('GET @nuovo3: /nuovo/@cat1/@cat2', '\App\Movimento->Nuovo3');
$f3->route('GET @nuovo4: /nuovo/@cat1/@cat2/@cat3', '\App\Movimento->Nuovo4');
$f3->route('GET @nuovo5: /nuovo/@cat1/@cat2/@cat3/@cat4', '\App\Movimento->Nuovo5');
$f3->route('POST @registra: /registra', '\App\Movimento->Registra');
$f3->route('GET @cancella: /cancella/@id', '\App\Movimento->Cancella');
$f3->route('POST @sopprimi: /sopprimi', '\App\Movimento->Sopprimi');

// Privacy
$f3->route('GET @privacy: /privacy', '\App\Privacy->Home');
$f3->route('GET @privacylista: /privacy/@lettera', '\App\Privacy->Lista');
$f3->route('GET @privacypdf: /privacy/pdf/@id', '\App\Privacy->MakePDF');
$f3->route('POST @privacymodifica: /privacy/modifica', '\App\Privacy->Modifica');
$f3->route('GET @privacynew: /privacy/new', '\App\Privacy->PazienteNew');
$f3->route('POST @privacysave: /privacy/new', '\App\Privacy->PazienteSave');
$f3->route('GET @privacysearch: /privacy/search', '\App\Privacy->PazienteSearch');
$f3->route('POST @privacysearchlist: /privacy/search', '\App\Privacy->PazienteSearchList');
$f3->route('GET @privacytable: /privacy/table', '\App\Privacy->TablePDF');

// Autenticazione
$f3->route('GET @login: /login', '\App\Auth->Login');
$f3->route('POST @loginCheck: /loginCheck', '\App\Auth->LoginCheck');
$f3->route('GET @logout: /logout', '\App\Auth->Logout');
$f3->route('GET @autentica: /autentica', '\App\Auth->Autentica');
$f3->route('GET @utente: /utente', '\App\Admin->UtenteLista');
$f3->route('GET @utentenuovo: /utente/nuovo', '\App\Admin->UtenteNuovo');
$f3->route('GET @utentecancella: /utente/cancella/@user_id', '\App\Admin->UtenteCancella');
$f3->route('POST @utenteregistra: /utente/registra', '\App\Admin->UtenteRegistra');

// Creazione database e tabelle
$f3->route('GET @migrazioni: /migrazioni', 'App\Migrazioni->All');

// Crypt
$f3->route('GET @crypt: /crypt', '\App\Crypt->Show');

// Se errori
/*
$f3->set('ONERROR',function($f3){
    $f3->reroute('/login');
    // $f3->error(403, "Rifare il login");
});
*/

$f3->run();
