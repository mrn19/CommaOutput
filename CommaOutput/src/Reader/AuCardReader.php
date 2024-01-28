<?php
namespace src\Reader;


class AuCardReader extends AbstractReader
{
    public function __construct()
    {
        $this->dateCol = 1;
        $this->shopCol = 2;
        $this->amountCol = 3;
    }
}

