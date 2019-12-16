<?php
namespace App;

class Orari_check
{

    public $orari;

    public function __construct()
    {
        $this->orari = array();
    }

    public function AddOrario(string $orario): self
    {
        $this->orari[] = $orario;
        return $this;
    }

    public function OrarioByArray(int $inizio, int $fine, array $orario): self
    {
        for ($c = $inizio; $c <= $fine; $c++) {
            foreach ($orario as $s) {
                $this->orari[] = "{$c}:{$s}";
            }
        }
        return $this;
    }

    public function getOrari(): array
    {
        return $this->orari;
    }
}