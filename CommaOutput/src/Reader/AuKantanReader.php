<?php
namespace src\Reader;

class AuKantanReader extends AbstractReader
{
    public function __construct()
    {
        $this->dateCol = 1;
        $this->shopCol = 2;
        $this->amountCol = 3;
    }
}

