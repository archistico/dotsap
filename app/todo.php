<?php
namespace App;

class Todo
{
    // Bisogna essere loggati
    public function beforeroute($f3)
    {
        $auth = \App\Auth::Autentica($f3);
        if (!$auth) {
            $f3->set('logged', false);
            $f3->reroute('/login');
        } else {
            $f3->set('logged', true);
        }
    }

    public $id;
    public $todo;
    public $chi;

    public function __construct($id, $todo, $chi)
    {
        $this->id = $id;
        $this->todo = $todo;
        $this->chi = $chi;
    }

    public function ToArray()
    {
        return ['id' => $this->id, 'todo' => $this->todo, 'chi' => $this->chi];
    }

    public function Cancella($f3, $params)
    {
        $db = (\App\Db::getInstance())->connect();

        $id = $params['id'];
        $sql = "DELETE FROM todo WHERE id=$id";

        $db->begin();
        $db->exec($sql);
        $db->commit();

        // ridirigi
        $f3->reroute('/appuntamenti');
    }

    public function Aggiungi($f3)
    {
        $todo = $f3->get('POST.todo');
        $chi = $f3->get('POST.chi');

        $chi = \App\Utilita::PulisciStringa($chi);
        $todo = \App\Utilita::PulisciStringa($todo);

        if (isset($todo) && isset($chi)) {
            $db = (\App\Db::getInstance())->connect();
            $db->begin();
            $sql = "INSERT into todo values(null, '$todo', '$chi')";
            $db->exec($sql);
            $db->commit();
        }

        // ridirigi
        $f3->reroute('/appuntamenti');
    }
}
