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

// Prenotazioni
$f3->route('GET @vaccini_prenotazioni_nuovo: /vaccini/prenotazioni/nuovo', '\App\Vaccini\Prenotazioni->Nuovo');
$f3->route('POST @vaccini_prenotazioni_nuovo_registra: /vaccini/prenotazioni/nuovo', '\App\Vaccini\Prenotazioni->NuovoRegistra');
$f3->route('GET @vaccini_prenotazioni_lista: /vaccini/prenotazioni/lista', '\App\Vaccini\Prenotazioni->Lista');
$f3->route('GET @vaccini_prenotazioni_modifica: /vaccini/prenotazioni/modifica/@id', '\App\Vaccini\Prenotazioni->Modifica');
$f3->route('POST @vaccini_prenotazioni_modifica_registra: /vaccini/prenotazioni/modifica/@id', '\App\Vaccini\Prenotazioni->ModificaRegistra');
$f3->route('GET @vaccini_prenotazioni_cancella: /vaccini/prenotazioni/cancella/@id', '\App\Vaccini\Prenotazioni->Cancella');
$f3->route('POST @vaccini_prenotazioni_cancella_registra: /vaccini/prenotazioni/cancella/@id', '\App\Vaccini\Prenotazioni->CancellaRegistra');

// Depositi
$f3->route('GET @vaccini_depositi_nuovo: /vaccini/depositi/nuovo', '\App\Vaccini\Depositi->Nuovo');
$f3->route('POST @vaccini_depositi_nuovo_registra: /vaccini/depositi/nuovo', '\App\Vaccini\Depositi->NuovoRegistra');
$f3->route('GET @vaccini_depositi_lista: /vaccini/depositi/lista', '\App\Vaccini\Depositi->Lista');
$f3->route('GET @vaccini_depositi_listapdf: /vaccini/depositi/listapdf', '\App\Vaccini\Depositi->ListaPDF');
$f3->route('GET @vaccini_depositi_visualizza: /vaccini/depositi/visualizza/@id', '\App\Vaccini\Depositi->Visualizza');
$f3->route('GET @vaccini_depositi_modifica: /vaccini/depositi/modifica/@id', '\App\Vaccini\Depositi->Modifica');
$f3->route('POST @vaccini_depositi_modifica_registra: /vaccini/depositi/modifica/@id', '\App\Vaccini\Depositi->ModificaRegistra');
$f3->route('GET @vaccini_depositi_cancella: /vaccini/depositi/cancella/@id', '\App\Vaccini\Depositi->Cancella');
$f3->route('POST @vaccini_depositi_cancella_registra: /vaccini/depositi/cancella/@id', '\App\Vaccini\Depositi->CancellaRegistra');

// Persone vaccinabili
$f3->route('GET @vaccini_vaccinabili_nuovo: /vaccini/vaccinabili/nuovo', '\App\Vaccini\Vaccinabili->Nuovo');
$f3->route('POST @vaccini_vaccinabili_nuovo_registra: /vaccini/vaccinabili/nuovo', '\App\Vaccini\Vaccinabili->NuovoRegistra');
$f3->route('GET @vaccini_vaccinabili_lista: /vaccini/vaccinabili/lista', '\App\Vaccini\Vaccinabili->Lista');
$f3->route('GET @vaccini_vaccinabili_modifica: /vaccini/vaccinabili/modifica/@id', '\App\Vaccini\Vaccinabili->Modifica');
$f3->route('POST @vaccini_vaccinabili_modifica_registra: /vaccini/vaccinabili/modifica/@id', '\App\Vaccini\Vaccinabili->ModificaRegistra');
$f3->route('GET @vaccini_vaccinabili_import: /vaccini/vaccinabili/import', '\App\Vaccini\Vaccinabili->Import');
$f3->route('GET @vaccini_vaccinabili_chiamare: /vaccini/vaccinabili/chiamare', '\App\Vaccini\Vaccinabili->Chiamare');

// TODO cancella vaccinabile solo se non ha un vaccino collegato
$f3->route('GET @vaccini_vaccinabili_cancella: /vaccini/vaccinabili/cancella/@id', '\App\Vaccini\Vaccinabili->Cancella');
$f3->route('POST @vaccini_vaccinabili_cancella_registra: /vaccini/vaccinabili/cancella/@id', '\App\Vaccini\Vaccinabili->CancellaRegistra');

// Vaccinazioni
$f3->route('GET @vaccini: /vaccini', '\App\Vaccini\Vaccinazioni->Home' );

// TODO statistiche pneu
// TODO nelle lista aggiunta tasto nuovo

// Vaccini prenotazioni
$f3->route('GET @vaccini_prenotazioni_tabella: /vaccini/prenotazioni/tabella', '\App\Vaccini\Prenotazioni->Tabella');
$f3->route('GET @vaccini_prenotazioni_tabella_giorno: /vaccini/prenotazioni/tabella/@data', '\App\Vaccini\Prenotazioni->TabellaGiorno');
$f3->route('POST @vaccini_prenotazioni_registra: /vaccini/prenotazioni/registra', '\App\Vaccini\Prenotazioni->Registra');
$f3->route('POST @vaccini_prenotazioni_modifica: /vaccini/prenotazioni/modifica', '\App\Vaccini\Prenotazioni->Modifica');
$f3->route('GET @vaccini_prenotazioni_pdf: /vaccini/prenotazioni/pdf', '\App\Vaccini\Prenotazioni->Pdf');

// Vaccini
$f3->route('GET @vaccini_nuovo: /vaccini/nuovo/@tipo', '\App\Vaccini\Vaccini->Nuovo');
$f3->route('POST @vaccini_nuovo_registra: /vaccini/nuovo', '\App\Vaccini\Vaccini->NuovoRegistra');
$f3->route('GET @vaccini_lista: /vaccini/lista', '\App\Vaccini\Vaccini->Lista');
$f3->route('GET @vaccini_lista_pdf: /vaccini/pdf', '\App\Vaccini\Vaccini->Pdf');
$f3->route('GET @vaccini_modifica: /vaccini/modifica/@id', '\App\Vaccini\Vaccini->Modifica');
$f3->route('POST @vaccini_modifica_registra: /vaccini/modifica/@id', '\App\Vaccini\Vaccini->ModificaRegistra');
$f3->route('GET @vaccini_cancella: /vaccini/cancella/@id', '\App\Vaccini\Vaccini->Cancella');
$f3->route('POST @vaccini_cancella_registra: /vaccini/cancella/@id', '\App\Vaccini\Vaccini->CancellaRegistra');

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
$f3->route('GET @covid: /covid', '\App\Covid\Controller\Covid->Home');
$f3->route('GET @covid_scheda_nuova: /covid/scheda/@fkpaziente', '\App\Covid\Controller\Covid->SchedaNuova');
$f3->route('POST @covid_scheda_registra: /covid/scheda/@fkpaziente', '\App\Covid\Controller\Covid->SchedaRegistra');
$f3->route('GET @covid_scheda_modifica: /covid/scheda/modifica/@id', '\App\Covid\Controller\Covid->SchedaModifica');
$f3->route('POST @covid_scheda_modifica_registra: /covid/scheda/modifica/@id', '\App\Covid\Controller\Covid->SchedaModificaRegistra');
$f3->route('GET @covid_scheda_cancella_conferma: /covid/scheda/cancella/@id', '\App\Covid\Controller\Covid->SchedaCancellaConferma');
$f3->route('POST @covid_scheda_cancella_registra: /covid/scheda/cancella/@id', '\App\Covid\Controller\Covid->SchedaCancellaRegistra');
$f3->route('GET @covid_lista: /covid/lista', '\App\Covid\Controller\Covid->Lista');
$f3->route('GET @covid_lista_paziente: /covid/lista/@fkpaziente', '\App\Covid\Controller\Covid->ListaPaziente');
$f3->route('GET @covid_pdf: /covid/pdf/@stato', '\App\Covid\Controller\Covid->PdfStato');

// Autenticazione
$f3->route('GET @login: /login', '\App\Auth->Login');
$f3->route('POST @loginCheck: /loginCheck', '\App\Auth->LoginCheck');
$f3->route('GET @logout: /logout', '\App\Auth->Logout');
$f3->route('GET @autentica: /autentica', '\App\Auth->Autentica');

// Amministrazione
$f3->route('GET @amministrazione: /amministrazione', '\App\Admin->Amministrazione');

// Impostazioni
$f3->route('GET  @impostazioni:                     /impostazioni',                      '\App\Impostazioni->Home');

$f3->route('GET  @impostazionisvuotaricette:        /impostazioni/svuotaricette',        '\App\Impostazioni->SvuotaRicette');
$f3->route('GET  @impostazionisvuotaprivacy:        /impostazioni/svuotaprivacy',        '\App\Impostazioni->SvuotaPrivacy');
$f3->route('GET  @impostazionisvuotaprenotazioni:   /impostazioni/svuotaprenotazioni',   '\App\Impostazioni->SvuotaPrenotazioni');
$f3->route('GET  @impostazionisvuotaschedecovid:    /impostazioni/svuotaschedecovid',    '\App\Impostazioni->SvuotaSchedeCovid');
$f3->route('GET  @impostazionisvuotanaotao:         /impostazioni/svuotanaotao',         '\App\Impostazioni->SvuotaNaoTao');
$f3->route('GET  @impostazionisvuotaantinfluenzale: /impostazioni/svuotaantinfluenzale', '\App\Impostazioni->SvuotaAntinfluenzale');
$f3->route('GET  @impostazionisvuotapazienti:       /impostazioni/svuotapazienti',       '\App\Impostazioni->SvuotaPazienti');

$f3->route('GET  @impostazioni_import_pazienti:    /impostazioni/import/pazienti',       '\App\Impostazioni->ImportPazienti');
$f3->route('POST @impostazioni_import_pazienti_db: /impostazioni/import/pazienti',       '\App\Impostazioni->ImportPazientiDb');

$f3->route('GET  @impostazioni_converti_nomi:      /impostazioni/converti/nomi',         '\App\Impostazioni->ConvertiNomi');
$f3->route('POST @impostazioni_converti_nomi_db:   /impostazioni/converti/nomi',         '\App\Impostazioni->ConvertiNomiDb');


// Utenti
$f3->route('GET  @utente_nuovo:        /impostazioni/utente/nuovo',        '\App\Utenti->Nuovo');
$f3->route('POST @utente_nuovo_db:     /impostazioni/utente/nuovo',        '\App\Utenti->NuovoDb');
$f3->route('GET  @utente_modifica:     /impostazioni/utente/modifica/@id', '\App\Utenti->Modifica');
$f3->route('POST @utente_modifica_db:  /impostazioni/utente/modifica/@id', '\App\Utenti->ModificaDb');
$f3->route('GET  @utente_cancella:     /impostazioni/utente/cancella/@id', '\App\Utenti->Cancella');
$f3->route('POST @utente_cancella_db:  /impostazioni/utente/cancella/@id', '\App\Utenti->CancellaDb');

// Log
$f3->route('GET @logs: /logs', '\App\Logs->Show');

// Creazione database e tabelle
$f3->route('GET @database_migrazioni: /database_migrazioni', 'App\Migrazioni->All');
$f3->route('GET @database_download: /database_download', 'App\Migrazioni->Download');

// Crypt
$f3->route('GET @crypt: /crypt', '\App\Crypt->Show');

// OrariDipendenti
$f3->route('GET @dipendenti_presenze_nuovo: /dipendenti/presenze/nuovo', '\App\Dipendenti\Presenze->Nuovo');
$f3->route('POST @dipendenti_presenze_nuovo_registra: /dipendenti/presenze/nuovo', '\App\Dipendenti\Presenze->NuovoRegistra');
$f3->route('GET @dipendenti_presenze_lista: /dipendenti/presenze/lista', '\App\Dipendenti\Presenze->Lista');
$f3->route('GET @dipendenti_presenze_cancella: /dipendenti/presenze/cancella/@id', '\App\Dipendenti\Presenze->Cancella');
$f3->route('POST @dipendenti_presenze_cancella_registra: /dipendenti/presenze/cancella/@id', '\App\Dipendenti\Presenze->CancellaRegistra');
$f3->route('GET @dipendenti_presenze_statistiche: /dipendenti/presenze/statistiche', '\App\Dipendenti\Presenze->Statistiche');

// NAOTAO
$f3->route('GET  @naotao:              /naotao',                    '\App\Naotao\Controller\Naotao->Lista');
$f3->route('GET  @naotao_scelta:       /naotao/scelta/@fkpaziente', '\App\Naotao\Controller\Naotao->Scelta');
$f3->route('GET  @naotao_nuovo:        /naotao/nuovo/@fkpaziente',  '\App\Naotao\Controller\Naotao->Nuovo');
$f3->route('POST @naotao_nuovo_db:     /naotao/nuovo/@fkpaziente',  '\App\Naotao\Controller\Naotao->NuovoDb');
$f3->route('GET  @naotao_modifica:     /naotao/modifica/@id',       '\App\Naotao\Controller\Naotao->Modifica');
$f3->route('POST @naotao_modifica_db:  /naotao/modifica/@id',       '\App\Naotao\Controller\Naotao->ModificaDb');
$f3->route('GET  @naotao_cancella:     /naotao/cancella/@id',       '\App\Naotao\Controller\Naotao->Cancella');
$f3->route('POST @naotao_cancella_db:  /naotao/cancella/@id',       '\App\Naotao\Controller\Naotao->CancellaDb');

// BILANCIO
$f3->route('GET  @bilancio:              /bilancio',                    '\App\Bilancio\Controller\Bilancio->Nuovo');
$f3->route('GET  @bilancio_lista:        /bilancio/lista',              '\App\Bilancio\Controller\Bilancio->Lista');
$f3->route('GET  @bilancio_nuovo:        /bilancio/nuovo',              '\App\Bilancio\Controller\Bilancio->Nuovo');
$f3->route('POST @bilancio_nuovo_db:     /bilancio/nuovo',              '\App\Bilancio\Controller\Bilancio->NuovoDb');
$f3->route('GET  @bilancio_modifica:     /bilancio/modifica/@id',       '\App\Bilancio\Controller\Bilancio->Modifica');
$f3->route('POST @bilancio_modifica_db:  /bilancio/modifica/@id',       '\App\Bilancio\Controller\Bilancio->ModificaDb');
$f3->route('GET  @bilancio_cancella:     /bilancio/cancella/@id',       '\App\Bilancio\Controller\Bilancio->Cancella');
$f3->route('POST @bilancio_cancella_db:  /bilancio/cancella/@id',       '\App\Bilancio\Controller\Bilancio->CancellaDb');


// Se errori
// $f3->set('ONERROR',function($f3){
//     $f3->reroute('/');
//     // $f3->error(403, "Rifare il login");
// });

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
