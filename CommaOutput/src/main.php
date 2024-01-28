<?php
namespace src;

use src\DataClass\PaymentData;
use src\Reader\AuCardReader;
use src\Reader\AuPayReader;
use src\Reader\AuKantanReader;
require_once 'DataClass\PaymentData.php';
require_once 'Reader\ReaderInterface.php';
require_once 'Reader\AbstractReader.php';
require_once 'Reader\AuCardReader.php';
require_once 'Reader\AuPayReader.php';
require_once 'Reader\AuKantanReader.php';

main();

/**
 * メイン処理
 */
function main()
{
    echo "start----------------------------------\n";

    $dir = '../input/';
    // フォルダ読み込み
    $dp = opendir($dir);

    // ディレクトリ内のファイル名を読み込む
    while (($item = readdir($dp))) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        // ファイル名で判断
        if (strpos($item, 'auPAY_Card') === 0) {
            $reader = new AuCardReader();
            $cardArray = readData($dir, $item, $reader);
        } elseif (strpos($item, 'auPAY_20') === 0) {
            $reader = new AuPayReader();
            $payArray = readData($dir, $item, $reader);
        } elseif (strpos($item, 'auKANTAN_') === 0) {
            $reader = new AuKantanReader();
            $kantanArray = readData($dir, $item, $reader);
        } else {
            echo $item . "\n";
            continue;
        }
    }

    // 出力
    outputResults('auPAYカード', $cardArray);
    outputResults('auPay', $payArray);
    outputResults('auかんたん決済', $kantanArray);
    
    echo "end----------------------------------\n";
}

function readData($dir, $fileName, $reader)
{

    // ファイルを読み込み配列に格納
    $data = file_get_contents($dir . $fileName);
    $data = mb_convert_encoding($data, 'UTF-8', 'SJIS-win');

    // 読み込んだデータを1行ずつ処理
    $rows = explode("\n", $data);
    return $reader->read($rows);
}

/**
 * 読み込み結果の出力
 * @param string $label
 * @param array $data
 */
function outputResults(string $label, array $data)
{
    echo $label . "\n";
    foreach ($data as $d) {
        outputResult($d);
    }
}

/**
 * 読み込み結果を項目ごとに出力
 * @param PaymentData $paymentData
 */
function outputResult(PaymentData $paymentData)
{
    echo $paymentData->getDate()->format('Y/m/d') . ',';
    echo $paymentData->getShop() . ',';
    echo $paymentData->getAmount() . "\n";
}

?>