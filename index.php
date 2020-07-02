<?php
require 'vendor/autoload.php';

if(file_exists('./env.php')) {
    include './env.php';
}

if(!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

// ----------------------
//   FAT FREE FRAMEWORK
// ----------------------

$f3 = \Base::instance();
$f3->set('CACHE', true);
$f3->set('DEBUG', 3);
$f3->set('ANNO', date("Y"));
$f3->set('APP_VERSIONE', env("APP_VERSIONE"));

// ----------------------
//         ROUTE
// ----------------------

// \App\Utilita::DumpDie($f3);

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
$f3->route('GET @ricettalistafatte: /ricetta/listafatte', '\App\Ricetta->ListaFatte');
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
$f3->route('GET @privacysearch: /privacy/search', '\App\Privacy->PazienteSearch');
$f3->route('POST @privacysearchlist: /privacy/search', '\App\Privacy->PazienteSearchList');
$f3->route('GET @privacytable: /privacy/table', '\App\Privacy->TablePDF');
$f3->route('GET @privacycancella: /privacy/cancella/@id', '\App\Privacy->Cancella');

// Pazienti
$f3->route('GET @pazienti: /pazienti', '\App\Pazienti->Home');
$f3->route('GET @pazientinuovo: /pazienti/nuovo', '\App\Pazienti->Nuovo');
$f3->route('POST @pazientisalva: /pazienti/salva', '\App\Pazienti->Salva');
$f3->route('GET @pazienticerca: /pazienti/cerca', '\App\Pazienti->Cerca');
$f3->route('POST @pazienticercalista: /pazienti/cerca/lista', '\App\Pazienti->CercaLista');
$f3->route('GET @pazientimodifica: /pazienti/modifica/@id', '\App\Pazienti->Modifica');
$f3->route('POST @pazientimodificasql: /pazienti/modifica/sql', '\App\Pazienti->ModificaSQL');
$f3->route('GET @pazienticancella: /pazienti/cancella/@id', '\App\Pazienti->CancellaConferma');
$f3->route('POST @pazienticancella: /pazienti/cancella', '\App\Pazienti->Cancella');
$f3->route('GET @pazientilettera: /pazienti/lettera/@lettera', '\App\Pazienti->Lettera');

// Covid
$f3->route('GET @covid: /covid', '\App\Covid->Home');
$f3->route('GET @covidmodifica: /covid/modifica/@id', '\App\Covid->Modifica');
$f3->route('POST @covidmodificasql: /covid/modifica', '\App\Covid->ModificaSQL');

// Autenticazione
$f3->route('GET @login: /login', '\App\Auth->Login');
$f3->route('POST @loginCheck: /loginCheck', '\App\Auth->LoginCheck');
$f3->route('GET @logout: /logout', '\App\Auth->Logout');
$f3->route('GET @autentica: /autentica', '\App\Auth->Autentica');
$f3->route('GET @utente: /utente', '\App\Admin->UtenteLista');
$f3->route('GET @utentenuovo: /utente/nuovo', '\App\Admin->UtenteNuovo');
$f3->route('GET @utentecancella: /utente/cancella/@user_id', '\App\Admin->UtenteCancella');
$f3->route('POST @utenteregistra: /utente/registra', '\App\Admin->UtenteRegistra');

// Impostazioni
$f3->route('GET @impostazioni: /impostazioni', '\App\Impostazioni->Home');
$f3->route('GET @impostazionisvuotaricette: /impostazioni/svuotaricette', '\App\Impostazioni->SvuotaRicette');
$f3->route('GET @impostazionisvuotaprivacy: /impostazioni/svuotaprivacy', '\App\Impostazioni->SvuotaPrivacy');

// Log
$f3->route('GET @logs: /logs', '\App\Logs->Show');

// Creazione database e tabelle
$f3->route('GET @database_migrazioni: /database_migrazioni', 'App\Migrazioni->All');
$f3->route('GET @database_download: /database_download', 'App\Migrazioni->Download');

// Crypt
$f3->route('GET @crypt: /crypt', '\App\Crypt->Show');

// Se errori
$f3->set('ONERROR',function($f3){
    $f3->reroute('/');
    // $f3->error(403, "Rifare il login");
});

$f3->route('GET /env',
    function() {
        //json_decode(env('APP_AMBULATORI'))
        $arr_ambulatori = json_decode(env('APP_AMBULATORI'));
        
        foreach($arr_ambulatori as $a) {
            foreach ($a->riservati as $key => $value) {
                echo "$key => $value\n";
            }
        }
    }
);

$f3->run();
