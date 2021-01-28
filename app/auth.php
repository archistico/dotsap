<?php

namespace App;

class Auth
{
    public function Login($f3, $args)
    {
        // RICORDARSI CACHE TRUE ALTRIMENTI NON FUNZIONA LA SESSIONE
        $session = new \Session();
        $csrf = $session->csrf();
        $f3->set('token', $csrf);
        $f3->set('SESSION.csrf', $csrf);

        // Reset persistenza utente
        $f3->set('COOKIE.sessionName', null, 86400);

        echo \Template::instance()->render('templates/login.htm');
    }

    public function Logout($f3, $args)
    {
        $session = new \Session();
        $csrf = $f3->get('COOKIE.sessionName');

        $sessionUsername = "SESSION.Username." . $csrf;
        $sessionPassword = "SESSION.Password." . $csrf;
        $sessionRole = "SESSION.Role." . $csrf;

        $f3->set($sessionUsername, null);
        $f3->set($sessionPassword, null);
        $f3->set($sessionRole, null);

        \App\Log::SaveMessage("-", "logout");

        \App\Flash::instance()->addMessage('Logout avvenuto', 'success');
        $f3->reroute('@login');
    }

    public static function Autentica($f3)
    {
        $session = new \Session();
        $csrf = $f3->get('COOKIE.sessionName');

        if (isset($csrf)) {
            $sessionUsername = "SESSION.Username." . $csrf;
            $sessionPassword = "SESSION.Password." . $csrf;
            $sessionRole = "SESSION.Role." . $csrf;

            if (($f3->get($sessionUsername) !== null) && ($f3->get($sessionPassword) !== null) && ($f3->get($sessionRole) !== null)) {

                $username = trim($f3->get($sessionUsername));
                $password = trim($f3->get($sessionPassword));
                $role = trim($f3->get($sessionRole));

                // HASH
                $password_hash = hash('sha512', $password, false);

                // CONTROLLO SE ESISTE UN UTENTE CON QUESTI USERNAME E PASSWORD
                $login_result = \App\Utente::Login($username, $password_hash);

                if ($login_result) {
                    $f3->set('auth_username', ucfirst($username));
                    $f3->set('auth_role', $role);
                }

                return $login_result;
            } else {
                \App\Flash::instance()->addMessage('Errore di autenticazione', 'danger');
                return false;
            }
        }
        return false;
    }

    public function LoginCheck($f3, $args)
    {
        // INIZIALIZZA SESSIONE
        $session = new \Session();

        // CARICA I DATI INVIATI
        $username = $f3->get('POST.utente');
        $password = $f3->get('POST.p');
        $token = $f3->get('POST.token');
        $csrf = $f3->get('SESSION.csrf');

        // CONTROLLA SE NON SONO SOTTO ATTACCO CSRF
        if ($token === $csrf) {

            // HASH
            $password_hash = hash('sha512', $password, false);

            // CONTROLLO SE ESISTE UN UTENTE CON QUESTI USERNAME E PASSWORD
            $login_result = \App\Utente::Login($username, $password_hash);

            if ($login_result) {

                // TROVO IL RUOLO
                $role = \App\Utente::Role($username, $password_hash);

                $f3->set('COOKIE.sessionName', $csrf, 86400);
                $sessionUsername = "SESSION.Username." . $csrf;
                $sessionPassword = "SESSION.Password." . $csrf;
                $sessionRole = "SESSION.Role." . $csrf;

                $f3->set($sessionUsername, $username);
                $f3->set($sessionPassword, $password);
                $f3->set($sessionRole, $role);

                $f3->reroute('@home');
            } else {
                // LOGIN USERNAME/PASSWORD ERRATO
                \App\Flash::instance()->addMessage('Username/password errati', 'danger');
                $f3->reroute('@login');
            }
        } else {
            // TOKEN ERRATO
            \App\Flash::instance()->addMessage('Richieste multiple non valide', 'danger');
            $f3->reroute('@login');
        }
    }
}
