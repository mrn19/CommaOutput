<?php
namespace src\Reader;

interface ReaderInterface
{
    /**
     * ファイル読み込み
     * @param array $fileData
     */
    function read($fileData);
}

