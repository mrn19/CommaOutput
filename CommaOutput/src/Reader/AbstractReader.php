<?php
namespace src\Reader;

use src\DataClass\PaymentData;

class AbstractReader implements ReaderInterface
{

    /**
     * 明細開始行（ラベルの次の行）
     * @var integer
     */
    private int $startLine = 8;
    /**
     * 日付カラム
     * @var integer
     */
    protected int $dateCol = 0;
    /**
     * 店舗カラム
     * @var integer
     */
    protected int $shopCol = 0;
    /**
     * 利用額カラム
     * @var integer
     */
    protected int $amountCol = 0;

    /**
     * コンストラクタ
     * @param int $dateCol 日付カラム
     * @param int $shopCol 店舗カラム
     * @param int $amountCol 利用額カラム
     */
    public function __construct(int $dateCol, int $shopCol, int $amountCol)
    {
        $this->dateCol = $dateCol;
        $this->shopCol = $shopCol;
        $this->amountCol = $amountCol;
    }

    /**
     * ファイル読み込み
     * {@inheritDoc}
     * @see \src\Reader\ReaderInterface::read()
     */
    public function read($fileData)
    {
        $result = [];
        for ($i = $this->startLine; ; $i ++) {
            $row = $fileData[$i];
            
            // 明細行の最後を判定
            if ($row == '■注意事項') {
                break;
            }

            // 利用額のダブルクォート内のカンマを除去しておく
            $pattern = '/\"\d+,\d+\"/';
            $rep = [];
            preg_match($pattern, $row, $rep);
            if ($rep != null) {
                $txtAmount = str_replace(',', '', $rep[0]);
                $data = preg_replace($pattern, $txtAmount, $row);
            } else {
                $data = $row;
            }

            $data = str_replace('"', '', $data);

            // カンマ区切り
            $data = explode(',', $data);
            $date = new \DateTime($data[$this->dateCol]);
            $shop = $data[$this->shopCol];
            $amount = $data[$this->amountCol];
            $str_num = str_replace(',', '', $amount);
            $int_num = (int) $str_num;
            // 1行ごとに保持
            $paymentData = new PaymentData($date, $shop, $int_num);
            $result[] = $paymentData;
        }
        // 日付昇順でソート
        usort($result, [
            PaymentData::class,
            "cmp"
        ]);

        return $result;
    }
}

