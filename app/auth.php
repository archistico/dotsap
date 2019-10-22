<?php
namespace App;

class Auth
{
    public function Login($f3, $args)
    {
        // CSRF
        $session = new \Session();
        $csrf = $session->csrf();
        $f3->set('token', $csrf);
        $f3->set('SESSION.csrf', $csrf);

        // Reset persistenza
        $f3->set('COOKIE.sessionName', null);

        echo \Template::instance()->render('templates/login.htm');
    }

    public function Logout($f3, $args)
    {
        $session = new \Session();
        $csrf = $f3->get('COOKIE.sessionName');

        $sessionUserid = "SESSION.UserID." . $csrf;
        $sessionPassword = "SESSION.Password." . $csrf;

        $f3->set('COOKIE.sessionName', null);
        $f3->set($sessionUserid, null);
        $f3->set($sessionPassword, null);

        \App\Flash::instance()->addMessage('Logout avvenuto', 'success');
        $f3->reroute('/login');
    }

    public static function Autentica($f3)
    {
        $session = new \Session();
        $csrf = $f3->get('COOKIE.sessionName');

        if (isset($csrf)) {
            $sessionUserid = "SESSION.UserID." . $csrf;
            $sessionPassword = "SESSION.Password." . $csrf;
          
            if ( ($f3->get($sessionUserid)!==null) && ($f3->get($sessionPassword)!==null) ) {

                $utente = trim($f3->get($sessionUserid));
                $password = trim($f3->get($sessionPassword));
                
                $db = new \DB\SQL('sqlite:db/database.sqlite');
                $users = new \DB\SQL\Mapper($db, 'users');
                $auth = new \Auth($users, array('id' => 'user_id', 'pw' => 'password'));

                $hash = hash('sha512', $password, false);
                $login_result = $auth->login($utente, $hash);

                return $login_result;
            } else {
                \App\Flash::instance()->addMessage('Errore di autenticazione', 'danger');
                return false;
            }
        }
        
        \App\Flash::instance()->addMessage('Richieste multiple non valide', 'danger');
        return false;
    }

    public function LoginCheck($f3, $args)
    {
        // INIZIALIZZA SESSIONE
        $session = new \Session();

        if ($f3->VERB == 'POST') {

            // CARICA I DATI INVIATI E DI SESSIONE
            $utente = $f3->get('POST.utente');
            $password = $f3->get('POST.p');
            $token = $f3->get('POST.token');
            $csrf = $f3->get('SESSION.csrf');

            $utente = str_replace('"', "", $utente);
            $utente = str_replace("'", "", $utente);

            // Resetta il csrf per evitare il doppio invio
            $f3->set('SESSION.csrf', $session->csrf());

            // CONTROLLA SE NON SONO SOTTO ATTACCO CSRF
            if ($token === $csrf) {

                $db = new \DB\SQL('sqlite:db/database.sqlite');
                $users = new \DB\SQL\Mapper($db, 'users');
                $auth = new \Auth($users, array('id' => 'user_id', 'pw' => 'password'));

                $hash = hash('sha512', $password, false);
                $login_result = $auth->login($utente, $hash);

                if ($login_result) {

                    $f3->set('COOKIE.sessionName', $csrf);
                    $sessionUserid = "SESSION.UserID." . $csrf;
                    $sessionPassword = "SESSION.Password." . $csrf;

                    $f3->set($sessionUserid, $utente);
                    $f3->set($sessionPassword, $password);

                    $f3->reroute('/');
                } else {
                    \App\Flash::instance()->addMessage('Nome utente o password non corretta', 'danger');
                    $f3->reroute('/login');
                }
            } else {
                \App\Flash::instance()->addMessage('Richieste multiple non valide', 'danger');
                $f3->reroute('/login');
            }
        }
    }
}
