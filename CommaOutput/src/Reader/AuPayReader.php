<?php
namespace src\Reader;

class AuPayReader extends AbstractReader
{
    public function __construct()
    {
        $this->dateCol = 1;
        $this->shopCol = 2;
        $this->amountCol = 4;
    }
}

